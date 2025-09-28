<?php

use yii\db\Migration;

class m250928_124914_add_phone_to_author_subscriptions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%author_subscriptions}}', 'phone', $this->string(20)->notNull()->after('author_id'));
        $this->dropForeignKey('fk_author_subscriptions_user', '{{%author_subscriptions}}');
        $this->dropColumn('{{%author_subscriptions}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%author_subscriptions}}', 'user_id', $this->integer()->notNull()->after('id'));
        $this->addForeignKey('fk_author_subscriptions_user', '{{%author_subscriptions}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->dropColumn('{{%author_subscriptions}}', 'phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250928_124914_add_phone_to_author_subscriptions cannot be reverted.\n";

        return false;
    }
    */
}
