<?php

use backend\modules\pageBackend\models\PageForm;
use yii\web\View;

/** @var View $this */
/** @var PageForm $model */

$this->title = 'Добавление книги';
?>

<h1><?= $this->title ?></h1>

<?= $this->render('_form_page', [
    'model' => $model,
]) ?>
