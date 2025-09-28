<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "author_subscriptions".
 *
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property int $created_at
 *
 * @property Authors $author
 * @property User $user
 */
class AuthorSubscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author_subscriptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'author_id', 'created_at'], 'required'],
            [['user_id', 'author_id', 'created_at'], 'integer'],
            [['user_id', 'author_id'], 'unique', 'targetAttribute' => ['user_id', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
