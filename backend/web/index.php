<?php

// Ativa debug e ambiente de desenvolvimento
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

// Obtém a URI da requisição
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Adicionando redirecionamento manual para rotas específicas
if ($requestUri === '/user/get-users') {
    $_GET['r'] = 'user/get-users';
} elseif (strpos($requestUri, '/user/get-user') === 0) {
    $_GET['r'] = 'user/get-user';
} elseif ($requestUri === '/user/temporary-access') {
    $_GET['r'] = 'user/temporary-access';
} elseif ($requestUri === '/user/register-payment' && $requestMethod === 'POST') {
    $_GET['r'] = 'user/register-payment'; // Nova rota para registrar pagamento
}

// Inicializa o Yii
(new yii\web\Application($config))->run();
