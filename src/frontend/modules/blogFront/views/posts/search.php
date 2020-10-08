<?php

use common\base\View;
use yii\base\Widget;

/** @var View $this */
/** @var Widget $postsWidget */

$this->breadcrumbs->addBreadcrumb(['/blogFront/posts/search'], 'Поиск');
?>

<?= $postsWidget->run() ?>
