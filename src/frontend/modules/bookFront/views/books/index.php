<?php
/** @var View $this */
/** @var \frontend\modules\bookFront\widgets\BooksWidget $booksWidget */

use common\base\View;

$this->breadcrumbs->addBreadcrumb(['/bookFront/book/index'], 'Книги');
?>
<?= $booksWidget->run() ?>
