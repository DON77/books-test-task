<?php

use yii\db\Migration;

/**
 * Handles the creation of table `authors`.
 */
class m180228_090438_create_authors_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('authors', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('authors');
    }

}
