<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Entities\Card;
use App\Services\YgoApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class YgoApiServiceTest extends TestCase
{
    public function testSearchCardsByNameReturnsCardsOnSuccess(): void
    {
        $payload = [
            'data' => [
                [
                    'name' => 'Dark Magician',
                    'attribute' => 'DARK',
                    'type' => 'Normal Monster',
                    'race' => 'Spellcaster',
                    'desc' => 'The ultimate wizard in terms of attack and defense.',
                    'level' => 7,
                    'atk' => 2500,
                    'def' => 2100,
                    'archetype' => 'Dark Magician',
                    'card_images' => [
                        [
                            'image_url' => 'https://images.example/dark-magician.jpg',
                        ],
                    ],
                    'card_prices' => [
                        [
                            'amazon_price' => '2.50',
                            'cardmarket_price' => '1.00',
                            'coolstuffinc_price' => '1.80',
                            'ebay_price' => '2.20',
                            'tcgplayer_price' => '1.90',
                        ],
                    ],
                ],
            ],
            'meta' => [
                'total_rows' => 1,
            ],
        ];

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode($payload, JSON_THROW_ON_ERROR)),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $service = new YgoApiService($client, 'https://db.ygoprodeck.com/api/v7', 'pt');

        $result = $service->searchCardsByName('dark magician', 1, 10);

        self::assertArrayHasKey('cards', $result);
        self::assertArrayHasKey('meta', $result);
        self::assertCount(1, $result['cards']);
        self::assertInstanceOf(Card::class, $result['cards'][0]);
        self::assertSame('Dark Magician', $result['cards'][0]->getName());
        self::assertSame(1, $result['meta']['total_rows']);
        self::assertSame(1, $result['meta']['current_page']);
        self::assertSame(10, $result['meta']['per_page']);
    }

    public function testSearchCardsByNameThrowsRuntimeExceptionOnGuzzleFailure(): void
    {
        $request = new Request('GET', 'https://db.ygoprodeck.com/api/v7/cardinfo.php');
        $mock = new MockHandler([
            new ConnectException('Network error', $request),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $service = new YgoApiService($client, 'https://db.ygoprodeck.com/api/v7', 'pt');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Falha na comunicação com a API YGOPRODeck.');

        $service->searchCardsByName('blue eyes', 1, 10);
    }
}
