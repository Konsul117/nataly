<?php

namespace backend\modules\book\controllers;

use backend\modules\editor\components\ImageUploader;
use common\components\UploadedFileParams;
use common\models\Entity;
use common\modules\book\models\Book;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $searchModel  = new Book();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setPagination(['pageSize' => 10]);
        $dataProvider->setSort(['defaultOrder' => [Book::ATTR_INSERT_STAMP => SORT_DESC]]);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            $params = UploadedFileParams::getInstanceByArray($_FILES['Book'], Book::ATTR_FILE);
            /** @var ImageUploader $imageUploader */
            $imageUploader = Yii::$app->modules['editor']->imageUploader;

            $imageUploader->uploadWithModel(Entity::ENTITY_BOOK_ID, $model->id, $params);

            return $this->redirect(['index']);
        }

        $errors = $model->getErrors();

        return $this->render('create', [
            'model'  => $model,
            'errors' => $errors,
        ]);
    }

    /**
     * @param int $id Id страницы
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id) {
        /** @var Book $model */
        $model = Book::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            $params = UploadedFileParams::getInstanceByArray($_FILES['Book'], Book::ATTR_FILE);
            /** @var ImageUploader $imageUploader */
            $imageUploader = Yii::$app->modules['editor']->imageUploader;

            $imageUploader->uploadWithModel(Entity::ENTITY_BOOK_ID, $model->id, $params);

            return $this->redirect(['index']);
        }

        $errors = $model->getErrors();

        return $this->render('update', [
            'model'  => $model,
            'errors' => $errors,
        ]);
    }

    /**
     * Удаление поста
     *
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id) {
        /** @var Book|null $model */
        $model = Book::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Запись блога не найдена');
        }

        if ($model->image !== null) {
            $model->image->clearThumbs();
            /** @var ImageUploader $imageUploader */
            $imageUploader = Yii::$app->modules['editor']->imageUploader;
            $imageUploader->delete($model->image->id);
        }

        $result = $model->delete();

        if ($result) {
            Yii::$app->session->addFlash('success', 'Пост успешно удалён');
        }
        else {
            Yii::$app->session->addFlash('error', 'Ошибка при удалении поста');
        }

        return $this->redirect(['index']);
    }
}
