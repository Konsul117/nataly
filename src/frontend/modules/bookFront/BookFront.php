<?php

namespace frontend\modules\bookFront;

use common\modules\book\Book;
use frontend\modules\bookFront\widgets\BooksWidget;

class BookFront extends Book
{
    public function getBooksWidget($limit = null, bool $showEmptyLabel = true, bool $showPagination = true): BooksWidget {
        $query = \common\modules\book\models\Book::find()
            ->orderBy([\common\modules\book\models\Book::ATTR_INSERT_STAMP => SORT_DESC]);

        $params = [
            'query'          => $query,
            'showEmptyLabel' => $showEmptyLabel,
            'showPagination' => $showPagination,
        ];

        if ($limit !== null) {
            $params['postsForPage'] = $limit;
        }

        return new BooksWidget($params);
    }

    public function search(string $request): ?BooksWidget {
        $query = \common\modules\book\models\Book::find()
            ->where(['like', \common\modules\book\models\Book::ATTR_TITLE, $request])
            ->orderBy([\common\modules\book\models\Book::ATTR_INSERT_STAMP => SORT_DESC]);

        return new BooksWidget([
            'query'          => $query,
            'showEmptyLabel' => true,
            'showPagination' => false,
        ]);
    }
}
