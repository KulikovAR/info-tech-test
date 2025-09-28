<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'books' => 'book/index',
                'books/create' => 'book/create',
                'books/<id:\d+>' => 'book/view',
                'books/<id:\d+>/update' => 'book/update',
                'books/<id:\d+>/delete' => 'book/delete',
                'authors' => 'author/index',
                'authors/create' => 'author/create',
                'authors/<id:\d+>' => 'author/view',
                'authors/<id:\d+>/update' => 'author/update',
                'authors/<id:\d+>/delete' => 'author/delete',
                'reports/top-authors' => 'report/top-authors',
                'subscription/subscribe/<authorId:\d+>' => 'subscription/subscribe',
                'subscription/unsubscribe/<authorId:\d+>' => 'subscription/unsubscribe',
            ],
        ],
    ],
    'params' => $params,
];
