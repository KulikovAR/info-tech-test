<?php

namespace frontend\models;

use yii\base\Model;
use common\models\Author;

class AuthorForm extends Model
{
    public $first_name;
    public $last_name;
    public $middle_name;

    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'middle_name'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
        ];
    }

    public function loadFromAuthor(Author $author)
    {
        $this->first_name = $author->first_name;
        $this->last_name = $author->last_name;
        $this->middle_name = $author->middle_name;
    }

    public function saveToAuthor(Author $author)
    {
        $author->first_name = $this->first_name;
        $author->last_name = $this->last_name;
        $author->middle_name = $this->middle_name;
    }
}
