<?php

use common\base\View;
use frontend\modules\blogFront\widgets\TagsPostWidget;
use yii\helpers\Html;

/** @var View $this */
/** @var TagsPostWidget $widget */
?>

<?php if (!empty($widget->post->tagsModels)): ?>
	<div class="tags-post">
		Теги: <?= implode(', ', array_map(function (\common\modules\blog\models\BlogTag $tag) {
			return Html::a($tag->name, ['/blogFront/posts/tag', 'tag' => $tag->name_url]);
		}, $widget->post->tagsModels)) ?>
	</div>
<?php endif ?>
