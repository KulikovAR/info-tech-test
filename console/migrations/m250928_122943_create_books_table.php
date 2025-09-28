<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m250928_122943_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text()->null(),
            'isbn' => $this->string(20)->null(),
            'cover_image' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->createIndex('idx_books_title', '{{%books}}', 'title');
        $this->createIndex('idx_books_year', '{{%books}}', 'year');
        $this->createIndex('idx_books_isbn', '{{%books}}', 'isbn');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
