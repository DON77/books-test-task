<?php

use yii\db\Migration;

/**
 * Handles the creation of table `orders`.
 */
class m180317_085631_create_orders_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function up() {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->float(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
                'user_id', 'orders', 'user_id', 'user', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down() {
        $this->dropTable('orders');
    }

}
