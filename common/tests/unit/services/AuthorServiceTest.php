<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\AuthorService;
use common\repositories\AuthorRepository;
use common\models\Author;
use Yii;

class AuthorServiceTest extends Unit
{
    private $authorService;
    private $authorRepositoryMock;

    protected function _before()
    {
        $this->authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $this->authorService = new AuthorService();
        
        $reflection = new \ReflectionClass($this->authorService);
        $property = $reflection->getProperty('authorRepository');
        $property->setAccessible(true);
        $property->setValue($this->authorService, $this->authorRepositoryMock);
    }

    public function testGetAllAuthorsReturnsArray()
    {
        $mockAuthors = [
            $this->createMock(Author::class),
            $this->createMock(Author::class)
        ];
        
        $this->authorRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($mockAuthors);
        
        $result = $this->authorService->getAllAuthors();
        
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function testGetAuthorWithInvalidId()
    {
        $this->authorRepositoryMock->expects($this->once())
            ->method('findById')
            ->with(99999)
            ->willReturn(null);
        
        $result = $this->authorService->getAuthor(99999);
        
        $this->assertNull($result);
    }
}
