<?php

use yii\db\Migration;

/**
 * Handles the creation of table `author_book`.
 */
class m180228_090827_create_author_book_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('author_book', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'book_id' => $this->integer(),
        ]);

        $this->addForeignKey(
                'author_id', 'author_book', 'author_id', 'authors', 'id'
        );
        $this->addForeignKey(
                'book_id', 'author_book', 'book_id', 'books', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('author_book');
    }

}
