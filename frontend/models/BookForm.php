<?php

namespace frontend\models;

use common\models\Book;
use common\validators\IsbnValidator;
use yii\base\Model;
use yii\web\UploadedFile;

class BookForm extends Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $cover_image;
    public $authorIds = [];

    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y') + 1],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], IsbnValidator::class],
            [['cover_image'], 'file', 'extensions' => 'jpg, jpeg, png, gif, webp', 'maxSize' => 5 * 1024 * 1024],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['authorIds'], 'required', 'message' => 'Необходимо выбрать хотя бы одного автора'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Обложка',
            'authorIds' => 'Авторы',
        ];
    }

    public function loadFromBook(Book $book)
    {
        $this->title = $book->title;
        $this->year = $book->year;
        $this->description = $book->description;
        $this->isbn = $book->isbn;
        $this->cover_image = $book->cover_image;
        $this->authorIds = array_column($book->authors, 'id');
    }

    public function saveToBook(Book $book)
    {
        $book->title = $this->title;
        $book->year = $this->year;
        $book->description = $this->description;
        $book->isbn = $this->isbn;
        $book->cover_image = $this->cover_image;
    }

    public function getCoverImageFile(): ?UploadedFile
    {
        return UploadedFile::getInstance($this, 'cover_image');
    }

    public function hasNewCoverImage(): bool
    {
        return $this->getCoverImageFile() !== null;
    }
}
