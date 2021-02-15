<?php

namespace frontend\modules\blogFront;

use common\modules\blog\Blog;
use common\modules\blog\models\BlogCategory;
use common\modules\blog\models\BlogPost;
use common\modules\blog\models\BlogPostTag;
use frontend\modules\blogFront\widgets\PostsWidget;
use frontend\modules\blogFront\widgets\SearchWidget;
use frontend\modules\blogFront\widgets\TagsCloudWidget;

/**
 * Расширение модуля "Блог" для фронтэнда
 */
class BlogFront extends Blog {

    /**
     * Получение виджета списка постов
     *
     * @param null $limit
     * @param null $categoryUrl
     * @param bool $showEmptyLabel
     *
     * @return PostsWidget
     */
	public function getPostsWidget($limit = null, $categoryUrl = null, bool $showEmptyLabel = true, bool $showPagination = true) {
		$query = BlogPost::find()
			->where([BlogPost::ATTR_IS_PUBLISHED => true])
			->orderBy([BlogPost::ATTR_INSERT_STAMP => SORT_DESC]);

		if ($categoryUrl !== null) {
			$query
				->innerJoinWith(BlogPost::REL_CATEGORY)
				->andWhere(BlogCategory::tableName() . '.' . BlogCategory::ATTR_TITLE_URL . ' = :categoryUrl',
					[':categoryUrl' => $categoryUrl]);
		}

		$params = [
            'query'          => $query,
            'showEmptyLabel' => $showEmptyLabel,
            'showPagination' => $showPagination,
        ];

		if ($limit !== null) {
		    $params['postsForPage'] = $limit;
        }

		return new PostsWidget($params);
	}

    /**
     * Получение виджета поиска постов
     *
     * @param string $request
     * @param int    $categoryId
     *
     * @return PostsWidget
     */
	public function getSearchPostsWidget(string $request, int $categoryId) {
		$query = BlogPost::find()
            ->where([BlogPost::tableName() . '.' . BlogPost::ATTR_CATEGORY_ID => $categoryId])
			->andWhere(['like', BlogPost::tableName() . '.' . BlogPost::ATTR_TITLE, $request])
			->orWhere(['like', BlogPost::tableName() . '.' . BlogPost::ATTR_TAGS, $request])
			->andWhere([BlogPost::tableName() . '.' . BlogPost::ATTR_IS_PUBLISHED => true])
			->orderBy([BlogPost::ATTR_INSERT_STAMP => SORT_DESC]);

		return new PostsWidget([
			'query'          => $query,
			'showTotalCount' => true,
            'showPagination' => false,
		]);
	}

	/**
	 * Получение виждета постов поиском по тегу
	 *
	 * @param int $tagId Id тега
	 * @param int $limit лимит
	 * @return PostsWidget виджет
	 */
	public function getTagPosts($tagId, $limit = null) {
		$query = BlogPost::find()
			->innerJoin(BlogPostTag::tableName(),
				BlogPostTag::tableName() . '.' . BlogPostTag::ATTR_POST_ID . ' = ' . BlogPost::tableName() . '.' . BlogPost::ATTR_ID
			)
			->where([BlogPostTag::tableName() . '.' . BlogPostTag::ATTR_TAG_ID => $tagId])
			->orderBy([BlogPost::ATTR_INSERT_STAMP => SORT_DESC]);

		return new PostsWidget([
			'postsForPage'   => $limit,
			'query'          => $query,
			'showTotalCount' => true,
		]);
	}

	/**
	 * Получение виджета поиска
	 *
	 * @param string $buttonClass Класс кнопки поиска
	 *
	 * @return SearchWidget
	 */
	public function getSearchWidget($buttonClass = null) {
		$params = [];

		if ($buttonClass !== null) {
			$params[SearchWidget::ATTR_BUTTON_CLASS] = $buttonClass;
		}

		return new SearchWidget($params);
	}

	/**
	 * Получение виджета облака тегов
	 *
	 * @return TagsCloudWidget
	 */
	public function getTagsCloudWidget() {
		return new TagsCloudWidget();
	}

}
