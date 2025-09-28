<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_subscriptions}}`.
 */
class m250928_123114_create_author_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author_subscriptions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

        $this->addForeignKey('fk_author_subscriptions_user', '{{%author_subscriptions}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_author_subscriptions_author', '{{%author_subscriptions}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_author_subscriptions_unique', '{{%author_subscriptions}}', ['user_id', 'author_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_author_subscriptions_author', '{{%author_subscriptions}}');
        $this->dropForeignKey('fk_author_subscriptions_user', '{{%author_subscriptions}}');
        $this->dropTable('{{%author_subscriptions}}');
    }
}
