<?php

namespace common\repositories;

use common\models\Author;
use Yii;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function findById(int $id): ?Author
    {
        return Author::findOne($id);
    }

    public function findAll(): array
    {
        return Author::find()->all();
    }

    public function findByYear(int $year): array
    {
        return Author::find()
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->all();
    }

    public function findTopByBooksCount(int $year, int $limit = 10): array
    {
        return Author::find()
            ->select(['authors.*', 'COUNT(books.id) as books_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public function save(Author $author): bool
    {
        return $author->save();
    }

    public function delete(Author $author): bool
    {
        return $author->delete() !== false;
    }
}
