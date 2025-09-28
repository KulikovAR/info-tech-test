<?php

namespace common\tests\unit\validators;

use Codeception\Test\Unit;
use common\validators\IsbnValidator;
use yii\base\Model;

class IsbnValidatorTest extends Unit
{
    private $validator;
    private $model;

    protected function _before()
    {
        $this->validator = new IsbnValidator();
        $this->model = new class extends Model {
            public $isbn;
        };
    }

    public function testValidIsbn10()
    {
        $this->model->isbn = '0-306-40615-2';
        
        $this->validator->validateAttribute($this->model, 'isbn');
        
        $this->assertEmpty($this->model->getErrors('isbn'));
    }

    public function testValidIsbn13()
    {
        $this->model->isbn = '978-0-306-40615-7';
        
        $this->validator->validateAttribute($this->model, 'isbn');
        
        $this->assertEmpty($this->model->getErrors('isbn'));
    }

    public function testInvalidIsbn10()
    {
        $this->model->isbn = '0-306-40615-1';
        
        $this->validator->validateAttribute($this->model, 'isbn');
        
        $this->assertNotEmpty($this->model->getErrors('isbn'));
    }

    public function testInvalidIsbn13()
    {
        $this->model->isbn = '978-0-306-40615-1';
        
        $this->validator->validateAttribute($this->model, 'isbn');
        
        $this->assertNotEmpty($this->model->getErrors('isbn'));
    }
}
