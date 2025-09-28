<?php

namespace common\services;

use Yii;
use yii\web\UploadedFile;

class FileService
{
    const UPLOAD_DIR = 'uploads/books/';
    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function uploadBookCover(UploadedFile $file, ?string $oldFileName = null): ?string
    {
        if (!$this->validateFile($file)) {
            return null;
        }

        if ($oldFileName) {
            $this->deleteFile($oldFileName);
        }

        $fileName = $this->generateFileName($file);
        $uploadPath = $this->getUploadPath($fileName);

        $this->createDirectories();

        if (!$file->saveAs($uploadPath)) {
            throw new \Exception('Ошибка при сохранении файла');
        }

        return $fileName;
    }

    private function validateFile(UploadedFile $file): bool
    {
        if (!$file || $file->error !== UPLOAD_ERR_OK) {
            return false;
        }

        if ($file->size > self::MAX_FILE_SIZE) {
            Yii::$app->session->setFlash('error', 'Размер файла не должен превышать 5MB');
            return false;
        }

        $extension = strtolower($file->extension);
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            Yii::$app->session->setFlash('error', 'Разрешены только файлы: ' . implode(', ', self::ALLOWED_EXTENSIONS));
            return false;
        }

        return true;
    }

    private function generateFileName(UploadedFile $file): string
    {
        $extension = strtolower($file->extension);
        return uniqid('book_', true) . '.' . $extension;
    }

    private function getUploadPath(string $fileName): string
    {
        return Yii::getAlias('@frontend/web/' . self::UPLOAD_DIR . $fileName);
    }

    private function createDirectories(): void
    {
        $uploadDir = Yii::getAlias('@frontend/web/' . self::UPLOAD_DIR);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    }

    public function deleteFile(string $fileName): void
    {
        $filePath = $this->getUploadPath($fileName);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function getImageUrl(?string $fileName): ?string
    {
        if (!$fileName) {
            return null;
        }

        return Yii::getAlias('@web/' . self::UPLOAD_DIR . $fileName);
    }
}
