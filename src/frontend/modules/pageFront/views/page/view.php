<?php

use common\base\View;
use common\modules\blog\models\BlogCategory;
use common\modules\image\models\ImageProvider;
use common\modules\page\models\Page;
use frontend\modules\blogFront\components\PostOutHelper;
use yii\helpers\Url;

/**
 * @var View $this
 * @var Page $page
 * @var \yii\base\Widget $newsWidget
 * @var \yii\base\Widget $draftsWidget
 * @var \frontend\modules\bookFront\widgets\BooksWidget $booksWidget
 */

$this->breadcrumbs->addBreadcrumb(['/pageFront/page/view', 'title_url' => $page->title_url], $page->title);

$this->metaTagContainer->title = $page->title;

$mainImage = $page->mainImage;

$mainImageTitle = null;

if ($mainImage !== null) {
	$this->metaTagContainer->image = $mainImage->getImageUrl(ImageProvider::FORMAT_MEDIUM);
	$mainImageTitle = $mainImage->title;
}
?>

<?= PostOutHelper::wrapContentImages($page->content, ImageProvider::FORMAT_MEDIUM, $mainImageTitle) ?>

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
