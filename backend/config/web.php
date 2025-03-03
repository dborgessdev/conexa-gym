<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'        => 'basic',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases'   => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true, // Remove index.php das URLs
            'showScriptName' => false,
            'rules' => [
                'GET user/get-users' => 'user/get-users', // Definindo a rota get.
            ],
        ],
        'request' => [
            'cookieValidationKey' => '39tJN3A-neU4n0sa9mvr9rEpj_Bh1ZgU',
            'enableCsrfValidation' => false, // Desative para evitar problemas com CORS
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class'             => \yii\symfonymailer\Mailer::class,
            'viewPath'          => '@app/mail',
            'useFileTransport'  => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        // Configuração do CORS de forma correta
        'cors' => [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'], // Permitir todas as origens
                'Access-Control-Allow-Methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ],
    ],
    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // Configuração extra para ambiente de desenvolvimento
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
