<?php

use common\base\View;
use frontend\assets\CommonAsset;
use newerton\fancybox\FancyBox;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var View $this */
/** @var string $content */

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

<?php if (!defined('YII_DEBUG') || !YII_DEBUG): ?>
	<?= $this->render('//layouts/blocks/counters') ?>
<?php endif ?>

<?php $this->beginBody() ?>

<header>
	<nav>
		<div class="menu-group">
			<ul>
				<li class="nataly">
					<a href="<?= Url::to(['/']) ?>"></a>
				</li>
				<li class="books">
					<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => 'books']) ?>"></a>
				</li>
				<li class="news">
					<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => 'news']) ?>"></a>
				</li>
				<li class="photostories">
					<a href="<?= Url::to(['/blogFront/posts/category', 'category_url' => 'photostories']) ?>"></a>
				</li>
				<li class="drafts">
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

		<div class="menu-group">
			<ul class="search">
				<li class="search">
					<a href=""></a>
				</li>
			</ul>
		</div>
	</nav>
</header>

<section>
    <?= $content ?>
</section>

<footer>
	Владивосток 2020
</footer>

<?php $this->endBody() ?>

<div id="fade-layer"></div>

</body>
</html>
<?php $this->endPage() ?>
