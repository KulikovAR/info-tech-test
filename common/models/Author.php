<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthorSubscriptions[] $authorSubscriptions
 * @property BookAuthors[] $bookAuthors
 * @property Books[] $books
 * @property User[] $users
 */
class Author extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['middle_name'], 'default', 'value' => null],
            [['first_name', 'last_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AuthorSubscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorSubscriptions()
    {
        return $this->hasMany(AuthorSubscriptions::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthors::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::class, ['id' => 'book_id'])->viaTable('book_authors', ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('author_subscriptions', ['author_id' => 'id']);
    }

}
