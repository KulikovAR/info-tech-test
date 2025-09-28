<?php

namespace common\repositories;

use common\models\Book;
use common\models\BookAuthor;
use Exception;
use Yii;

class BookRepository implements BookRepositoryInterface
{
    public function findById(int $id): ?Book
    {
        return Book::findOne($id);
    }

    public function findAll(): array
    {
        return Book::find()->all();
    }

    public function findByYear(int $year): array
    {
        return Book::find()->where(['year' => $year])->all();
    }

    public function findByAuthor(int $authorId): array
    {
        return Book::find()
            ->joinWith('authors')
            ->where(['authors.id' => $authorId])
            ->all();
    }

    public function save(Book $book): bool
    {
        return $book->save();
    }

    public function delete(Book $book): bool
    {
        return $book->delete() !== false;
    }

    public function attachAuthors(Book $book, array $authorIds): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($authorIds as $authorId) {
                $bookAuthor = new BookAuthor();
                $bookAuthor->book_id = $book->id;
                $bookAuthor->author_id = $authorId;
                if (!$bookAuthor->save()) {
                    throw new Exception('Failed to attach author');
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function detachAuthors(Book $book, array $authorIds): bool
    {
        return BookAuthor::deleteAll([
            'book_id' => $book->id,
            'author_id' => $authorIds
        ]) !== false;
    }
}
