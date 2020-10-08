<?php

use common\base\View;
use common\modules\blog\models\BlogTag;
use yii\base\Widget;

/** @var View $this */
/** @var Widget $postsWidget */
/** @var BlogTag $tag */

$this->breadcrumbs->addBreadcrumb(['/blogFront/posts/tags'], 'Теги');
$this->breadcrumbs->addBreadcrumb(['/blogFront/posts/tag', 'tag' => $tag->name_url], $tag->name);
?>

<?= $postsWidget->run() ?>
