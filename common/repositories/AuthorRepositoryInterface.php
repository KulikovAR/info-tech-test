<?php

namespace common\repositories;

use common\models\Author;

interface AuthorRepositoryInterface
{
    public function findById(int $id): ?Author;
    public function findAll(): array;
    public function findByYear(int $year): array;
    public function findTopByBooksCount(int $year, int $limit = 10): array;
    public function save(Author $author): bool;
    public function delete(Author $author): bool;
}
