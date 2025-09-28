<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\FileService;
use Yii;

class FileServiceTest extends Unit
{
    private $fileService;

    protected function _before()
    {
        $this->fileService = new FileService();
    }

    public function testGetImageUrlWithValidFileName()
    {
        $fileName = 'test_image.jpg';
        
        $result = $this->fileService->getImageUrl($fileName);
        
        $this->assertStringContainsString('uploads/books/', $result);
        $this->assertStringContainsString($fileName, $result);
    }

    public function testGetImageUrlWithNullFileName()
    {
        $result = $this->fileService->getImageUrl(null);
        
        $this->assertNull($result);
    }
}
