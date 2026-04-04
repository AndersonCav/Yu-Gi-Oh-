<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\YgoApiService;
use Throwable;

final class CardController
{
    private YgoApiService $service;
    private View $view;
    private int $resultsPerPage;

    public function __construct(YgoApiService $service, View $view, int $resultsPerPage = 10)
    {
        $this->service = $service;
        $this->view = $view;
        $this->resultsPerPage = max(1, $resultsPerPage);
    }

    public function home(): void
    {
        $this->view->render('cards/search', [
            'title' => 'Yu-Gi-Oh! Card Explorer',
        ]);
    }

    public function search(): void
    {
        $search = isset($_GET['busca']) ? trim((string) $_GET['busca']) : '';
        $page = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $page = max(1, $page);

        try {
            $result = $this->service->searchCardsByName($search, $page, $this->resultsPerPage);
            $cards = $result['data'];
            $meta = $result['meta'];
            $totalPages = (int) ceil(max(1, (int) $meta['total_rows']) / (int) $meta['per_page']);

            $this->view->render('cards/results', [
                'title' => 'Resultado da busca',
                'search' => $search,
                'cards' => $cards,
                'page' => $page,
                'totalPages' => $totalPages,
            ]);
        } catch (Throwable $exception) {
            http_response_code(502);
            $this->view->render('errors/friendly-error', [
                'title' => 'Erro ao consultar cartas',
                'message' => 'Não foi possível carregar as cartas agora. Tente novamente em alguns instantes.',
            ]);
        }
    }
}
