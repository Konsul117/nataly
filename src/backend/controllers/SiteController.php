<?php
namespace backend\controllers;

use backend\base\BackendController;
use backend\modules\commentBackend\CommentBackend;
use common\models\LoginForm;
use Yii;

/**
 * Site controller
 */
class SiteController extends BackendController {

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
