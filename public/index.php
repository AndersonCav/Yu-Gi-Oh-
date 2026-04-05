<?php

declare(strict_types=1);

use App\Controllers\CardController;
use App\Core\ExceptionHandler;
use App\Core\View;
use App\Services\YgoApiService;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$projectRoot = dirname(__DIR__);
$autoloadFile = $projectRoot . '/vendor/autoload.php';

if (!is_file($autoloadFile)) {
    http_response_code(500);
    echo 'Dependências não instaladas. Execute: composer install';
    exit;
}

require $autoloadFile;

if (is_file($projectRoot . '/.env')) {
    Dotenv::createImmutable($projectRoot)->safeLoad();
}

$config = require $projectRoot . '/app/Config/config.php';
$view = new View($projectRoot . '/views');

ExceptionHandler::register($view, (bool) $config['app_debug']);

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler($projectRoot . '/logs/app.log', Logger::ERROR));

$httpClient = new Client();
$service = new YgoApiService(
    $httpClient,
    (string) $config['api_base_url'],
    (string) $config['api_language']
);
$controller = new CardController($service, $view, $logger, (int) $config['results_per_page']);

$route = (string) ($_GET['route'] ?? 'home');

switch ($route) {
    case 'home':
        $controller->home();
        break;

    case 'cards/search':
        $controller->search();
        break;

    default:
        http_response_code(404);
        $view->render('errors/friendly-error', [
            'title' => 'Página não encontrada',
            'message' => 'A rota solicitada não existe.',
        ]);
        break;
}
