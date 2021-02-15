<?php

namespace frontend\modules\bookFront\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\Pagination;
use yii\db\Query;

class BooksWidget extends Widget
{
    /**
     * Количество постов на одну страницу
     *
     * @var int
     */
    public $postsForPage = 6;

    /**
     * @var Query
     */
    public $query;

    /**
     * Показывать сообщение об отсутствии записей
     * @var bool
     */
    public $showEmptyLabel = true;

    /**
     * Общее количество найденных постов
     * @var int
     */
    public $showTotalCount = false;

    public $showPagination = false;

    /**
     * @inheritdoc
     */
    public function run() {
        if (!$this->query instanceof Query) {
            throw new InvalidConfigException('Отсутствует query');
        }

        $countQuery = clone $this->query;

        $pages = new Pagination([
            'defaultPageSize' => $this->postsForPage,
            'totalCount'      => $countQuery->count(),
            'pageSize'        => $this->postsForPage,
            'route'           => 'bookFront/books/index',
        ]);

        $books = $this->query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('books', [
            'books'  => $books,
            'pages'  => $pages,
            'widget' => $this,
        ]);
    }
}
