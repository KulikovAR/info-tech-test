<?php

namespace common\repositories;

use common\models\Book;

interface BookRepositoryInterface
{
    public function findById(int $id): ?Book;
    public function findAll(): array;
    public function findByYear(int $year): array;
    public function findByAuthor(int $authorId): array;
    public function save(Book $book): bool;
    public function delete(Book $book): bool;
    public function attachAuthors(Book $book, array $authorIds): bool;
    public function detachAuthors(Book $book, array $authorIds): bool;
}
