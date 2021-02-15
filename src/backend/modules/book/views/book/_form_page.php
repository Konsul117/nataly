<?php

use common\modules\book\models\Book;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */

/** @var Book $model */
/** @var string[] $errors */
?>

<?php if (!empty($errors)): ?>
	<div class="alert alert-warning">
		<p>При сохранении произошли следующие ошибки:</p>
		<ul class="list-unstyled">
			<?php foreach ($errors as $error): ?>
				<li><?= $error ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>

<?php $form = ActiveForm::begin(['options' => ['id' => 'contactForm', 'autocomplete' => 'off']]); ?>

<div class="form-group">

	<?= $form->field($model, Book::ATTR_TITLE)->textInput(['maxlength' => 100]) ?>
	<?= $form->field($model, Book::ATTR_URL)->textInput(['maxlength' => 100]) ?>
	<?= $form->field($model, Book::ATTR_FILE)->fileInput() ?>

	<?php if ($model->image !== null): ?>
		<img src="<?= $model->image->getImageUrl(\common\modules\image\models\ImageProvider::FORMAT_BOOK) ?>"/>
	<?php endif ?>

</div>

<div class="form-group">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	<?= Html::a('Отмена', ['/book/index'],
		['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
