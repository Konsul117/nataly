<?php

namespace frontend\modules\blogFront\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\Pagination;
use yii\db\Query;

/**
 * Виджет списка постов
 */
class PostsWidget extends Widget {

	/**
	 * Количество постов на одну страницу
	 *
	 * @var int
	 */
	public $postsForPage = 10;

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
            'totalCount'      => $countQuery->count(),
            'defaultPageSize' => $this->postsForPage,
            'pageSize'        => $this->postsForPage,
            'route'           => 'blogFront/posts/category',
		]);

		$posts = $this->query->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return $this->render('posts', [
			'posts'  => $posts,
			'pages'  => $pages,
			'widget' => $this,
		]);
	}

}
