<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    private string $viewsPath;

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = rtrim($viewsPath, DIRECTORY_SEPARATOR);
    }

    public function render(string $view, array $data = []): void
    {
        $viewFile = $this->viewsPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $view) . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException('View não encontrada: ' . $view);
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        require $this->viewsPath . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
    }
}
