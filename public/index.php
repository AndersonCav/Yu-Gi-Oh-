<?php

declare(strict_types=1);

use App\Controllers\CardController;
use App\Core\ExceptionHandler;
use App\Core\View;
use App\Services\YgoApiService;
use Bramus\Router\Router;
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

$router = new Router();
$router->setNamespace('App\\Controllers');

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$basePath = rtrim($scriptDir, '/');
if ($basePath !== '') {
    $router->setBasePath($basePath);
}

$router->get('/', static function () use ($controller): void {
    $controller->home();
});

$router->get('/search', static function () use ($controller): void {
    $controller->search();
});

$router->set404(static function () use ($view): void {
    http_response_code(404);
    $view->render('errors/friendly-error', [
        'title' => 'Página não encontrada',
        'message' => 'A rota solicitada não existe.',
    ]);
});

// Compatibilidade temporaria com URL legada baseada em query string
if (isset($_GET['route'])) {
    $homePath = ($basePath !== '' ? $basePath : '') . '/';
    $searchPath = ($basePath !== '' ? $basePath : '') . '/search';

    if ((string) $_GET['route'] === 'home') {
        header('Location: ' . $homePath, true, 301);
        exit;
    }

    if ((string) $_GET['route'] === 'cards/search') {
        $query = [];

        if (isset($_GET['busca'])) {
            $query['busca'] = (string) $_GET['busca'];
        }

        if (isset($_GET['pagina'])) {
            $query['pagina'] = (string) $_GET['pagina'];
        }

        $location = $searchPath;
        if ($query !== []) {
            $location .= '?' . http_build_query($query);
        }

        header('Location: ' . $location, true, 301);
        exit;
    }
}

$router->run();
