<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m201011_125744_book
 */
class m201011_125744_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => \yii\db\Schema::TYPE_STRING . '(100) NOT NULL COMMENT \'Название\'',
            'url' => \yii\db\Schema::TYPE_STRING . '(255) NOT NULL COMMENT \'URL страницы покупки книги\'',
            'insert_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время создания поста"',
            'update_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время обновления поста"',
        ], 'COMMENT \'Книги\'');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('book');
    }
}
