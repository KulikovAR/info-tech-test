<?php

namespace common\services;

use common\models\AuthorSubscription;
use common\models\Book;
use Yii;

class NotificationService
{
    private $smsService;

    public function __construct()
    {
        $this->smsService = new SmsService();
    }

    public function notifyNewBook(Book $book): void
    {
        $authorIds = array_column($book->authors, 'id');
        
        foreach ($authorIds as $authorId) {
            $subscriptions = AuthorSubscription::find()
                ->where(['author_id' => $authorId])
                ->all();

            foreach ($subscriptions as $subscription) {
                if ($subscription->phone) {
                    $this->sendNewBookSms($subscription->phone, $book);
                }
            }
        }
    }

    private function sendNewBookSms(string $phone, Book $book): void
    {
        $authorNames = array_column($book->authors, 'full_name');
        $authorName = implode(', ', $authorNames);
        
        $message = "Новая книга от автора {$authorName}: {$book->title}";
        
        $this->smsService->sendSms($phone, $message);
    }
}
