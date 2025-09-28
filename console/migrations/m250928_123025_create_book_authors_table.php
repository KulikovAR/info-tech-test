<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_authors}}`.
 */
class m250928_123025_create_book_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_authors}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->addPrimaryKey('pk_book_authors', '{{%book_authors}}', ['book_id', 'author_id']);
        $this->addForeignKey('fk_book_authors_book', '{{%book_authors}}', 'book_id', '{{%books}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_book_authors_author', '{{%book_authors}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_book_authors_author', '{{%book_authors}}');
        $this->dropForeignKey('fk_book_authors_book', '{{%book_authors}}');
        $this->dropTable('{{%book_authors}}');
    }
}
