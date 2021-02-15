<?php

namespace frontend\modules\bookFront\controllers;


use frontend\modules\bookFront\BookFront;
use Yii;
use yii\web\Controller;

class BooksController extends Controller
{
    /**
     * Главная страница
     *
     * @return string
     */
    public function actionIndex() {
        /** @var BookFront $bookModule */
        $bookModule = Yii::$app->modules['bookFront'];

        $this->view->params = array_merge($this->view->params, [
            'isBooks' => true,
        ]);

        return $this->render('index', [
            'booksWidget' => $bookModule->getBooksWidget(),
        ]);
    }
}
