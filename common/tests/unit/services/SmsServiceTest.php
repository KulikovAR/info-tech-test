<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\SmsService;
use Yii;

class SmsServiceTest extends Unit
{
    private $smsService;

    protected function _before()
    {
        $this->smsService = new SmsService();
    }

    public function testSendSmsWithValidData()
    {
        $phone = '79081234567';
        $message = 'Test message';
        
        $result = $this->smsService->sendSms($phone, $message);
        
        $this->assertIsBool($result);
    }

    public function testSendSmsWithEmptyMessage()
    {
        $phone = '79081234567';
        $message = '';
        
        $result = $this->smsService->sendSms($phone, $message);
        
        $this->assertIsBool($result);
    }
}
