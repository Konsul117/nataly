<?php

namespace frontend\modules\pageFront\controllers;
use common\modules\blog\models\BlogCategory;
use common\modules\page\models\Page;
use frontend\modules\blogFront\BlogFront;
use frontend\modules\bookFront\BookFront;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Контроллер страниц для фронтэнда
 */
class PageController extends \yii\web\Controller {

	/**
	 * Просмотр страницы
	 *
	 * @param string $title_url ЧПУ страницы
	 *
	 * @return string
	 *
	 * @throws NotFoundHttpException
	 */
	public function actionView($title_url = null) {
	    if ($title_url !== null) {
            /** @var Page $page */
            $page = Page::find()
                ->where([
                    Page::ATTR_TITLE_URL    => $title_url,
                    Page::ATTR_IS_PUBLISHED => 1,
                ])
                ->one();
        } else {
            /** @var Page $page */
            $page = Page::find()
                ->where([
                    Page::ATTR_ID    => 1,
                    Page::ATTR_IS_PUBLISHED => 1,
                ])
                ->one();
        }

		if ($page === null) {
			throw new NotFoundHttpException('Страница не найдена');
		}

		$this->view->params = array_merge($this->view->params, [
            'isRoot' => true,
        ]);

		/** @var BlogFront $blog */
		$blog = Yii::$app->getModule('blogFront');
		/** @var BookFront $book */
		$book = Yii::$app->getModule('bookFront');

		return $this->render('view', [
			'page' => $page,
            'newsWidget' => $blog->getPostsWidget(5, BlogCategory::CATEGORY_NEWS_URL, false, false),
            'draftsWidget' => $blog->getPostsWidget(5, BlogCategory::CATEGORY_DRAFTS_URL, false, false),
            'booksWidget' => $book->getBooksWidget(3, false, false),
		]);
	}

	public function actionSearch(string $request) {
        /** @var BlogFront $blog */
        $blog = Yii::$app->getModule('blogFront');
        /** @var BookFront $book */
        $book = Yii::$app->getModule('bookFront');

        return $this->render('search', [
            'newsWidget' => $blog->getSearchPostsWidget($request, BlogCategory::CATEGORY_NEWS_ID),
            'draftsWidget' => $blog->getSearchPostsWidget($request, BlogCategory::CATEGORY_DRAFTS_ID),
            'booksWidget' => $book->search($request),
        ]);
    }

}
