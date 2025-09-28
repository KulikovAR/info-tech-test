<?php

namespace common\services;

use Yii;

class SmsService
{
    private $apiKey;
    private $apiUrl = 'https://smspilot.ru/api.php';
    private $sender;

    public function __construct()
    {
        $this->apiKey = Yii::$app->params['sms.apiKey'];
        $this->sender = Yii::$app->params['sms.sender'];
    }

    public function sendSms(string $phone, string $message): bool
    {
        try {
            $url = $this->apiUrl
                . '?send=' . urlencode($message)
                . '&to=' . urlencode($phone)
                . '&from=' . $this->sender
                . '&apikey=' . $this->apiKey
                . '&format=json';

            $json = file_get_contents($url);
            
            if ($json === false) {
                Yii::error('Failed to get response from SMS API');
                return false;
            }

            $response = json_decode($json);
            
            if (!isset($response->error)) {
                Yii::info('SMS successfully sent, server_id=' . $response->send[0]->server_id);
                return true;
            } else {
                Yii::error('SMS API error: ' . $response->error->description_ru);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
}