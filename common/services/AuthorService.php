<?php

namespace common\services;

use common\repositories\AuthorRepository;
use common\models\Author;
use Yii;

class AuthorService
{
    private $authorRepository;

    public function __construct()
    {
        $this->authorRepository = new AuthorRepository();
    }

    public function getAuthor(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    public function getAllAuthors(): array
    {
        return $this->authorRepository->findAll();
    }

    public function getAuthorsByYear(int $year): array
    {
        return $this->authorRepository->findByYear($year);
    }

    public function getTopAuthorsByBooksCount(int $year, int $limit = 10): array
    {
        return $this->authorRepository->findTopByBooksCount($year, $limit);
    }

    public function createAuthor(array $data): Author
    {
        $author = new Author();
        $author->setAttributes($data);
        
        if (!$this->authorRepository->save($author)) {
            throw new \Exception('Failed to create author');
        }
        
        return $author;
    }

    public function updateAuthor(Author $author, array $data): Author
    {
        $author->setAttributes($data);
        
        if (!$this->authorRepository->save($author)) {
            throw new \Exception('Failed to update author');
        }
        
        return $author;
    }

    public function deleteAuthor(Author $author): bool
    {
        return $this->authorRepository->delete($author);
    }
}
