<?php

namespace common\validators;

use yii\validators\Validator;

class IsbnValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        
        if (empty($value)) {
            return;
        }
        
        if (!$this->isValidIsbn($value)) {
            $this->addError($model, $attribute, 'Некорректный ISBN. Проверьте контрольную цифру.');
        }
    }
    
    private function isValidIsbn($isbn)
    {
        $isbn = str_replace(['-', ' '], '', $isbn);
        
        if (strlen($isbn) === 10) {
            return $this->isValidIsbn10($isbn);
        } elseif (strlen($isbn) === 13) {
            return $this->isValidIsbn13($isbn);
        }
        
        return false;
    }
    
    private function isValidIsbn10($isbn)
    {
        if (!preg_match('/^\d{9}[\dX]$/', $isbn)) {
            return false;
        }
        
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$isbn[$i] * (10 - $i);
        }
        
        $checkDigit = $isbn[9] === 'X' ? 10 : (int)$isbn[9];
        $remainder = $sum % 11;
        
        return $remainder === 0 ? $checkDigit === 0 : (11 - $remainder) === $checkDigit;
    }
    
    private function isValidIsbn13($isbn)
    {
        if (!preg_match('/^\d{13}$/', $isbn)) {
            return false;
        }
        
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $multiplier = ($i % 2 === 0) ? 1 : 3;
            $sum += (int)$isbn[$i] * $multiplier;
        }
        
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        return $checkDigit === (int)$isbn[12];
    }
}
