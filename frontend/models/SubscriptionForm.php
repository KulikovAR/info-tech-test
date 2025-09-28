<?php

namespace frontend\models;

use yii\base\Model;

class SubscriptionForm extends Model
{
    public $phone;

    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+?[0-9\s\-\(\)]+$/', 'message' => 'Некорректный формат номера телефона'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
        ];
    }
}
