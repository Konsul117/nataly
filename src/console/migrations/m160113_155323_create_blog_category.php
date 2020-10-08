<?php

use yii\db\Migration;
use yii\db\Schema;

class m160113_155323_create_blog_category extends Migration {

	var $tableName = 'blog_category';

	public function safeUp() {
		$this->createTable($this->tableName, [
			'id'        => $this->primaryKey() . ' COMMENT "Уникальный идентификатор категории"',
			'title'     => Schema::TYPE_STRING . '(100) NOT NULL COMMENT "Название категории"',
			'title_url' => Schema::TYPE_STRING . '(100) NOT NULL COMMENT "Название ЧПУ категории"',
		], ' COMMENT "Категории блога"');

		$this->batchInsert($this->tableName, ['id', 'title', 'title_url'], [
			[1, 'Книги', 'books'],
			[2, 'Новости', 'news'],
			[3, 'Фотоистории', 'photostories'],
			[4, 'Черновики', 'drafts'],
		]);
	}

	public function safeDown() {
		$this->dropTable($this->tableName);
	}
}
