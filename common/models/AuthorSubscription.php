<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "author_subscriptions".
 *
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property int $created_at
 *
 * @property Author $author
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
            [['author_id', 'phone', 'created_at'], 'required'],
            [['author_id', 'created_at'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+?[0-9\s\-\(\)]+$/', 'message' => 'Некорректный формат номера телефона'],
            [['author_id', 'phone'], 'unique', 'targetAttribute' => ['author_id', 'phone']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'phone' => 'Номер телефона',
            'created_at' => 'Дата подписки',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }


}
