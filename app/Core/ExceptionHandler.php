<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

final class ExceptionHandler
{
    public static function register(View $view, bool $debug): void
    {
        set_exception_handler(static function (Throwable $exception) use ($view, $debug): void {
            http_response_code(500);

            if ($debug) {
                $message = $exception->getMessage();
            } else {
                $message = 'Ocorreu um erro inesperado. Tente novamente em instantes.';
            }

            $view->render('errors/friendly-error', [
                'title' => 'Erro interno',
                'message' => $message,
            ]);
        });
    }
}
