<?php

use common\base\View;
use common\components\Formatter;
use common\modules\image\models\ImageProvider;
use yii\data\Pagination;
use yii\widgets\LinkPager;

/** @var View $this */
/** @var \frontend\modules\bookFront\widgets\BooksWidget $widget */
/** @var \common\modules\book\models\Book[] $books */
/** @var Pagination $pages */
$formatter = new Formatter();
?>

<?php if (!empty($books)): ?>
    <div class="books">
        <?php if ($widget->showTotalCount): ?>
            <div class="post-count">Всего записей: <?= $pages->totalCount ?></div>
        <?php endif ?>
        <?php foreach ($books as $book): ?>
            <div class="book-item post-item">
                <div class="item-content">
	                <?php if ($book->image !== null): ?>
	                    <a href="<?= $book->url ?>" target="_blank">
                            <img src="<?= $book->image->getImageUrl(ImageProvider::FORMAT_BOOK) ?>">
	                    </a>
                    <?php endif ?>
                </div>

	            <h2>
		            <a href="<?= $book->url ?>" target="_blank">
                        <?= $book->title ?>
		            </a>
	            </h2>
            </div>
        <?php endforeach ?>

        <?php if ($widget->showTotalCount): ?>
            <br />
            <br />
            <div class="post-count">Всего книг: <?= $pages->totalCount ?></div>
        <?php endif ?>
    </div>
<?php elseif ($widget->showEmptyLabel): ?>
    <div class="alert alert-info">
        По вашему запросу ничего не найдено.
    </div>
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
