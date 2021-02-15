<?php

namespace common\components;

use yii\base\InvalidParamException;

/**
 * Обёртка для параметров загруженного файла (из $_FILES)
 */
class UploadedFileParams {

	/**
	 * Имя загруженного файла
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Тип данных файла
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Имя временного файла, в котором хранится содержимое загруженного файла
	 *
	 * @var string
	 */
	public $tmpName;

	/**
	 * Идентификатор ошибки загрузки
	 *
	 * @var int
	 */
	public $error;

	/**
	 * Размер (в байтах)
	 *
	 * @var int
	 */
	public $size;

	/**
	 * Получить по массиву объект параметров
	 *
	 * @param array $array
	 *
	 * @return static
	 * @throws InvalidParamException
	 */
	public static function getInstanceByArray(array $array, ?string $field = null) {
		$obj = new static();

		if ($field !== null) {
            $params = [
                'name'     => $array['name'][$field],
                'type'     => $array['type'][$field],
                'tmp_name' => $array['tmp_name'][$field],
                'error'    => $array['error'][$field],
                'size'     => $array['size'][$field],
            ];
        } else {
		    $params = $array;
        }

		if (!isset($params['name'])) {
			throw new InvalidParamException('Отсутствует параметр "name"');
		}

		if (!isset($params['type'])) {
			throw new InvalidParamException('Отсутствует параметр "type"');
		}

		if (!isset($params['tmp_name'])) {
			throw new InvalidParamException('Отсутствует tmp_name"');
		}

		if (!isset($params['error'])) {
			throw new InvalidParamException('Отсутствует параметр "error"');
		}

		if (!isset($params['size'])) {
			throw new InvalidParamException('Отсутствует параметр "size"');
		}

		$obj->name    = $params['name'];
		$obj->type    = $params['type'];
		$obj->tmpName = $params['tmp_name'];
		$obj->error   = $params['error'];
		$obj->size    = $params['size'];

		return $obj;
	}

}
