<?php

namespace common\services;

use common\repositories\BookRepository;
use common\models\Book;
use Yii;

class BookService
{
    private $bookRepository;

    public function __construct()
    {
        $this->bookRepository = new BookRepository();
    }

    public function getBook(int $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }

    public function getBooksByYear(int $year): array
    {
        return $this->bookRepository->findByYear($year);
    }

    public function getBooksByAuthor(int $authorId): array
    {
        return $this->bookRepository->findByAuthor($authorId);
    }

    public function createBook(array $data, array $authorIds = []): Book
    {
        $book = new Book();
        $book->setAttributes($data);
        
        if (!$this->bookRepository->save($book)) {
            throw new \Exception('Failed to create book');
        }

        if (!empty($authorIds)) {
            if (!$this->bookRepository->attachAuthors($book, $authorIds)) {
                throw new \Exception('Failed to attach authors to book');
            }
        }

        $notificationService = Yii::$app->get('notificationService');
        $notificationService->notifyNewBook($book);
        
        return $book;
    }

    public function updateBook(Book $book, array $data, array $authorIds = null): Book
    {
        $book->setAttributes($data);
        
        if (!$this->bookRepository->save($book)) {
            throw new \Exception('Failed to update book');
        }

        if ($authorIds !== null) {
            $currentAuthorIds = array_column($book->authors, 'id');
            $toDetach = array_diff($currentAuthorIds, $authorIds);
            $toAttach = array_diff($authorIds, $currentAuthorIds);

            if (!empty($toDetach)) {
                $this->bookRepository->detachAuthors($book, $toDetach);
            }
            if (!empty($toAttach)) {
                $this->bookRepository->attachAuthors($book, $toAttach);
            }
        }
        
        return $book;
    }

    public function deleteBook(Book $book): bool
    {
        return $this->bookRepository->delete($book);
    }
}
