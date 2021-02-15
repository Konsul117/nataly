<?php

use common\base\View;
use common\modules\blog\models\BlogCategory;
use common\modules\page\models\Page;
use yii\helpers\Url;

/**
 * @var View $this
 * @var Page $page
 * @var \yii\base\Widget $newsWidget
 * @var \yii\base\Widget $draftsWidget
 * @var \frontend\modules\bookFront\widgets\BooksWidget $booksWidget
 */

$this->breadcrumbs->addBreadcrumb(['/pageFront/page/search'], 'Поиск');

$this->metaTagContainer->title = 'Поиск';
?>

<a href="<?= Url::to(['/bookFront/books/index']) ?>">
    <div class="delimiter books"></div>
</a>
<?= $booksWidget->run() ?>

<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => BlogCategory::CATEGORY_NEWS_URL]) ?>">
    <div class="delimiter news"></div>
</a>
<?= $newsWidget->run() ?>

<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => BlogCategory::CATEGORY_DRAFTS_URL]) ?>">
    <div class="delimiter drafts"></div>
</a>
<?= $draftsWidget->run() ?>
