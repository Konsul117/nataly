<?php

use yii\db\Migration;
use yii\db\Schema;

class m160131_132216_create_page extends Migration {

	var $tableName = 'page';

	public function safeUp() {
		$this->createTable($this->tableName, [
			'id'           => $this->primaryKey() . ' COMMENT "Уникальный идентификатор"',
			'title'        => Schema::TYPE_STRING . '(255) NOT NULL COMMENT "Название страницы"',
			'title_url'    => Schema::TYPE_STRING . '(255) NOT NULL COMMENT "Название ЧПУ страницы"',
			'content'      => Schema::TYPE_TEXT . ' NOT NULL DEFAULT "" COMMENT "Контент страницы"',
			'is_published' => 'TINYINT NOT NULL DEFAULT 0 COMMENT "Состояние опубликованности"',
			'insert_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время создания поста"',
			'update_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время обновления поста"',
		], 'COMMENT "Страницы"');

		$this->createIndex('ix-' . $this->tableName . '-[title_url]', $this->tableName, ['title_url']);
		$this->createIndex('ix-' . $this->tableName . '-[insert_stamp]', $this->tableName, ['insert_stamp']);

		$currentDateTime = new DateTime('now', new DateTimeZone('UTC'));

		$this->batchInsert(
			$this->tableName,
			['id', 'title', 'title_url', 'content', 'is_published', 'insert_stamp', 'update_stamp'],
			[
				[1, 'Главная страница', 'main_page', '', 1, $currentDateTime->format('Y-m-d H:i:s'), $currentDateTime->format('Y-m-d H:i:s')],
			]
		);
	}

	public function safeDown() {
		$this->dropTable($this->tableName);
	}
}
