<?php

use common\components\Formatter;
use common\modules\blog\models\BlogPost;
use common\modules\image\models\ImageProvider;
use frontend\modules\blogFront\components\PostOutHelper;
use frontend\modules\blogFront\widgets\PostsWidget;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var PostsWidget $widget */
/** @var BlogPost[] $posts */
/** @var Pagination $pages */
$formatter = new Formatter();
?>

<?php if (!empty($posts)): ?>
	<div class="blog-posts">
		<?php if ($widget->showTotalCount): ?>
			<div class="post-count">Всего записей: <?= $pages->totalCount ?></div>
		<?php endif ?>
		<?php foreach ($posts as $post): ?>
			<div class="post-item">
				<div class="post-stamp">
                    <?= Html::a($formatter->asLocalDateTime($post->insert_stamp, 'd.m.Y H:i'), ['/blogFront/posts/view', 'title_url' => $post->title_url]) ?>
				</div>

				<h2>
					<?= Html::a($post->title, ['/blogFront/posts/view', 'title_url' => $post->title_url]) ?>
				</h2>

				<div class="item-content">
					<?= PostOutHelper::wrapContentImages($post->short_content, ImageProvider::FORMAT_POST_MAIN, $post->title) ?>
				</div>
			</div>
		<?php endforeach ?>

		<?php if ($widget->showTotalCount): ?>
			<br />
			<br />
			<div class="post-count">Всего записей: <?= $pages->totalCount ?></div>
		<?php endif ?>

		<?php if ($widget->showPagination): ?>
			<div class="pagination-wrap">
				<?= LinkPager::widget([
						'pagination' => $pages,
						'nextPageLabel' => 'Вперёд',
						'prevPageLabel' => 'Назад',
				]) ?>
			</div>
		<?php endif ?>
	</div>
<?php elseif ($widget->showEmptyLabel): ?>
	<div class="alert alert-info">
		По вашему запросу ничего не найдено.
	</div>
<?php endif ?>
