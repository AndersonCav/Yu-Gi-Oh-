<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

final class YgoApiService
{
    private Client $httpClient;
    private string $baseUrl;
    private string $language;

    public function __construct(Client $httpClient, string $baseUrl, string $language = 'pt')
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->language = $language;
    }

    public function searchCardsByName(string $search, int $page = 1, int $perPage = 10): array
    {
        $search = trim($search);
        $page = max(1, $page);
        $perPage = max(1, min($perPage, 50));
        $offset = ($page - 1) * $perPage;

        if ($search === '') {
            return [
                'data' => [],
                'meta' => [
                    'total_rows' => 0,
                    'current_page' => $page,
                    'per_page' => $perPage,
                ],
            ];
        }

        try {
            $response = $this->httpClient->request('GET', $this->baseUrl . '/cardinfo.php', [
                'query' => [
                    'language' => $this->language,
                    'fname' => $search,
                    'num' => $perPage,
                    'offset' => $offset,
                ],
                'timeout' => 10.0,
                'connect_timeout' => 5.0,
                'http_errors' => true,
            ]);

            $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            return [
                'data' => $payload['data'] ?? [],
                'meta' => [
                    'total_rows' => (int) ($payload['meta']['total_rows'] ?? count($payload['data'] ?? [])),
                    'current_page' => $page,
                    'per_page' => $perPage,
                ],
            ];
        } catch (GuzzleException $exception) {
            throw new RuntimeException('Falha na comunicação com a API YGOPRODeck.', 0, $exception);
        } catch (JsonException $exception) {
            throw new RuntimeException('Resposta inválida recebida da API.', 0, $exception);
        }
    }
}
