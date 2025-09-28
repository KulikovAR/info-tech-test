<?php

use common\services\AuthorService;
use common\services\BookService;
use yii\caching\FileCache;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'authorService' => [
            'class' => AuthorService::class,
        ],
        'bookService' => [
            'class' => BookService::class,
        ],
    ],
];
