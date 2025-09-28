<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\BookService;
use common\repositories\BookRepository;
use common\models\Book;
use Yii;

class BookServiceTest extends Unit
{
    private $bookService;
    private $bookRepositoryMock;

    protected function _before()
    {
        $this->bookRepositoryMock = $this->createMock(BookRepository::class);
        $this->bookService = new BookService();
        
        $reflection = new \ReflectionClass($this->bookService);
        $property = $reflection->getProperty('bookRepository');
        $property->setAccessible(true);
        $property->setValue($this->bookService, $this->bookRepositoryMock);
    }

    public function testGetAllBooksReturnsArray()
    {
        $mockBooks = [
            $this->createMock(Book::class),
            $this->createMock(Book::class)
        ];
        
        $this->bookRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($mockBooks);
        
        $result = $this->bookService->getAllBooks();
        
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function testGetBookWithInvalidId()
    {
        $this->bookRepositoryMock->expects($this->once())
            ->method('findById')
            ->with(99999)
            ->willReturn(null);
        
        $result = $this->bookService->getBook(99999);
        
        $this->assertNull($result);
    }
}
