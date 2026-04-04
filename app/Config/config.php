<?php

declare(strict_types=1);

return [
    'app_env' => $_ENV['APP_ENV'] ?? 'production',
    'app_debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOL),
    'api_base_url' => $_ENV['YGO_API_BASE_URL'] ?? 'https://db.ygoprodeck.com/api/v7',
    'api_language' => $_ENV['YGO_API_LANGUAGE'] ?? 'pt',
    'results_per_page' => (int) ($_ENV['YGO_RESULTS_PER_PAGE'] ?? 10),
];
