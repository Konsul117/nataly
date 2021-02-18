<?php

use common\base\View;
use frontend\assets\CommonAsset;
use newerton\fancybox\FancyBox;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var View $this */
/** @var string $content */
/** @var string $blogCategoryUrl */
/** @var bool $isRoot */

//BootstrapAsset::register($this);
CommonAsset::register($this);
FancyBox::widget([
    'target' => 'a[data-lightbox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<?= Html::csrfMetaTags() ?>

	<?php

	if ($this->title === null) {
		$lastBreadcrumb = $this->breadcrumbs->getLast();

		if ($lastBreadcrumb !== null) {
			$this->title = $lastBreadcrumb->title;
		}
	}

	$pageTagHeading = $this->title . ' - Сайт Натали Тумко';

	if (!$this->metaTagContainer->title) {
		$this->metaTagContainer->title = $pageTagHeading;
	}
	?>

	<?= $this->render('//layouts/blocks/meta', [
			'metaTagContainer' => $this->metaTagContainer,
	]) ?>

	<title><?= Html::encode($pageTagHeading) ?></title>

	<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />

	<?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

<header>
	<div class="head-right-wrap">
		<div class="head-right"></div>
	</div>
	<?php \yii\widgets\Spaceless::begin() ?>
	<nav>
		<div class="menu-group">
			<ul class="menu">
				<li class="nataly <?=(isset($this->params['isRoot']) && $this->params['isRoot']) ? 'selected' : '' ?>">
					<a href="<?= Url::to(['/']) ?>"></a>
				</li>
				<li class="books <?=(isset($this->params['isBooks']) && $this->params['isBooks']) ? 'selected' : '' ?>">
					<a href="<?= Url::to(['/bookFront/books/index']) ?>"></a>
				</li>
				<li class="news <?=(isset($this->params['blogCategoryUrl']) && $this->params['blogCategoryUrl'] === 'news') ? 'selected' : '' ?>">
					<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => 'news']) ?>"></a>
				</li>
				<li class="drafts <?=(isset($this->params['blogCategoryUrl']) && $this->params['blogCategoryUrl'] === 'drafts') ? 'selected' : '' ?>">
					<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => 'drafts']) ?>"></a>
				</li>
			</ul>
		</div>

		<div class="menu-group">
			<ul class="socials">
				<li class="social-inst">
					<a href=""></a>
				</li>
				<li class="social-mail">
					<a href=""></a>
				</li>
				<li class="social-vk">
					<a href=""></a>
				</li>
			</ul>
		</div>

		<div class="menu-group search-panel">
			<ul class="search">
				<li class="search">
					<form action="<?= Url::to(['/pageFront/page/search']) ?>" method="get" class="search-field">
						<input type="text" name="request" placeholder="Что ищем?"/>
						<button type="submit">Найти</button>
					</form>
					<a href="" id="button-search"></a>
				</li>
			</ul>
		</div>
	</nav>
    <?php \yii\widgets\Spaceless::end() ?>
</header>

<section>
	<div class="breadcrumbs"><?= implode(' - ', array_map(function (\common\components\BreadcrumbItem $item) {
		return Html::a($item->title, $item->url);
	}, $this->breadcrumbs->getAll())) ?></div>
    <?= $content ?>
</section>

<footer>
	Владивосток <?= date('Y') ?>
</footer>

<?php $this->endBody() ?>

<div id="fade-layer"></div>

</body>
</html>
<?php $this->endPage() ?>
