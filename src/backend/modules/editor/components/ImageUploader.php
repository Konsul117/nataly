<?php

namespace backend\modules\editor\components;

use common\components\UploadedFileParams;
use common\exceptions\ImageException;
use common\modules\image\models\Image;
use PHPImageWorkshop\ImageWorkshop;
use Yii;
use yii\base\Component;
use yii\base\Exception;

class ImageUploader extends Component {

	/**
	 * Максимальная ширина для оригинала
	 * @var int
	 */
	public $maxOriginalWidth;

	/**
	 * Максимальная высота для оригинала
	 * @var int
	 */
	public $maxOriginalHeight;

    /**
     * Загрузка изображения
     *
     * @param int                $entityId
     * @param int                $entityItemId
     * @param UploadedFileParams $uploadParams
     *
     * @throws Exception
     * @throws ImageException
     * @throws \PHPImageWorkshop\Core\Exception\ImageWorkshopLayerException
     * @throws \PHPImageWorkshop\Exception\ImageWorkshopException
     */
	public function uploadWithModel(int $entityId, int $entityItemId, UploadedFileParams $uploadParams): void {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $image = $this->saveImageModel($entityId, $entityItemId);
            $this->uploadImage($image->id, $uploadParams);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->commit();
    }

    /**
     * @param int $entityId
     * @param int $entityItemId
     *
     * @throws Exception
     * @throws ImageException
     * @throws \PHPImageWorkshop\Core\Exception\ImageWorkshopLayerException
     * @throws \PHPImageWorkshop\Exception\ImageWorkshopException
     */
    private function saveImageModel(int $entityId, int $entityItemId): Image {
        /** @var Image $existsImage */
        $existsImage = Image::find()->where([
            Image::ATTR_RELATED_ENTITY_ID      => $entityId,
            Image::ATTR_RELATED_ENTITY_ITEM_ID => $entityItemId,
        ])->one();

        if ($existsImage !== null) {
            return $existsImage;
        }

        $image = new Image();
        $image->related_entity_id = $entityId;
        $image->related_entity_item_id = $entityItemId;
        $image->is_need_watermark = false;

        if ($image->save() === false) {
            throw new ImageException('Ошибка сохранения изображения');
        }

        return $image;
    }

	/**
	 * Загрузка изображения
	 * @param string $imageIdent идентификатор изображения
	 * @param UploadedFileParams $uploadParams
	 * @throws ImageException
	 */
	public function uploadImage($imageIdent, UploadedFileParams $uploadParams) {

		if ($this->maxOriginalHeight === null || $this->maxOriginalWidth === null) {
			throw new ImageException('Для компонента ImageUploader не настроены параметры макс. ширины и высоты оригинала изображения');
		}

		if ($uploadParams->error !== UPLOAD_ERR_OK) {
			$error = 'Ошибка загрузки изображения: ';

			switch($uploadParams->error) {
				case UPLOAD_ERR_INI_SIZE:
					$error = 'размер превысил лимит ' . ini_get('upload_max_filesize');
					break;
			}
			throw new ImageException($error);
		}

		$imageLayer = ImageWorkshop::initFromPath($uploadParams->tmpName);

		if ($imageLayer->getHeight() > $this->maxOriginalHeight || $imageLayer->getWidth() > $this->maxOriginalWidth) {
			$imageLayer->resizeToFit($this->maxOriginalWidth, $this->maxOriginalHeight, true);
		}

		$savePath = $this->getSavePath();
		$filename = $imageIdent . '.jpg';

		$imageLayer->save($savePath, $filename, true, null, 100);

		//т.к. ImageResize::save() не возвращает результат сохранения, то приходиться проверять результат по наличию итогового файла
		if (!file_exists($savePath . DIRECTORY_SEPARATOR . $filename)) {
			throw new ImageException('Ошибка при сохранении изображения: файл не создан');
		}

	}

	protected function getSavePath() {
		$path = Yii::getAlias('@upload_images_path');

		if (!file_exists($path)) {
			if (!@mkdir($path)) {
				throw new Exception('Ошибка при создании каталона для загруженных изображений: ' . $path);
			}
		}

		return $path;
	}

    public function delete(int $id) {
        $savePath = $this->getSavePath();
        $path = $savePath . DIRECTORY_SEPARATOR . $id . '.jpg';

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
