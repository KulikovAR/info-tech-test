<?php

namespace common\services;

use Yii;
use yii\httpclient\Client;

class SmsService
{
    private $apiKey;
    private $apiUrl = 'https://smspilot.ru/api.php';
    private $httpClient;

    public function __construct()
    {
        $this->apiKey = Yii::$app->params['sms.apiKey'] ?? 'test123';
        $this->httpClient = new Client();
    }

    public function sendSms(string $phone, string $message): bool
    {
        try {
            $response = $this->httpClient->createRequest()
                ->setMethod('GET')
                ->setUrl($this->apiUrl)
                ->setData([
                    'send' => $message,
                    'to' => $phone,
                    'apikey' => $this->apiKey,
                    'format' => 'json'
                ])
                ->send();

            if ($response->isOk) {
                $data = $response->data;
                return isset($data['send']) && $data['send'] === true;
            }

            return false;
        } catch (\Exception $e) {
            Yii::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendNewBookNotification(string $phone, string $authorName, string $bookTitle): bool
    {
        $message = "Новая книга от автора {$authorName}: {$bookTitle}";
        return $this->sendSms($phone, $message);
    }
}
