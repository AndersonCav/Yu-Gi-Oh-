<?php

declare(strict_types=1);

use App\Controllers\CardController;
use App\Core\View;
use App\Services\YgoApiService;
use DI\ContainerBuilder;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return static function (array $config, string $projectRoot): ContainerInterface {
    $builder = new ContainerBuilder();

    $builder->addDefinitions([
        'config' => $config,
        'projectRoot' => $projectRoot,

        Client::class => static fn (): Client => new Client(),

        View::class => static fn (): View => new View($projectRoot . '/views'),

        LoggerInterface::class => static function () use ($projectRoot): LoggerInterface {
            $logger = new Logger('app');
            $logger->pushHandler(new StreamHandler($projectRoot . '/logs/app.log', Logger::ERROR));

            return $logger;
        },

        YgoApiService::class => static fn (ContainerInterface $container): YgoApiService => new YgoApiService(
            $container->get(Client::class),
            (string) $config['api_base_url'],
            (string) $config['api_language']
        ),

        CardController::class => static fn (ContainerInterface $container): CardController => new CardController(
            $container->get(YgoApiService::class),
            $container->get(View::class),
            $container->get(LoggerInterface::class),
            (int) $config['results_per_page']
        ),
    ]);

    return $builder->build();
};
