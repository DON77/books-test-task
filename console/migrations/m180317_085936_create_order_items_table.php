<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_items`.
 */
class m180317_085936_create_order_items_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function up() {
        $this->createTable('order_items', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'book_id' => $this->integer(),
        ]);

        $this->addForeignKey(
                'order_id', 'order_items', 'order_id', 'orders', 'id'
        );
        $this->addForeignKey(
                'order_book_id', 'order_items', 'book_id', 'books', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down() {
        $this->dropTable('order_items');
    }

}
