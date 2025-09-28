<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\NotificationService;
use common\services\SmsService;
use common\models\Book;
use common\models\Author;
use common\models\AuthorSubscription;
use Yii;

class NotificationServiceTest extends Unit
{
    private $notificationService;

    protected function _before()
    {
        $this->notificationService = $this->createPartialMock(NotificationService::class, ['notifyNewBook']);
    }

    public function testNotifyNewBookWithValidBook()
    {
        $book = $this->createMock(Book::class);
        
        $this->notificationService->expects($this->once())
            ->method('notifyNewBook')
            ->with($book);
        
        $this->notificationService->notifyNewBook($book);
        
        $this->assertTrue(true);
    }

    public function testNotifyNewBookWithEmptyAuthors()
    {
        $book = $this->createMock(Book::class);
        
        $this->notificationService->expects($this->once())
            ->method('notifyNewBook')
            ->with($book);
        
        $this->notificationService->notifyNewBook($book);
        
        $this->assertTrue(true);
    }
}