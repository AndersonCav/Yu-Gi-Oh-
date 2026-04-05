<?php

declare(strict_types=1);

namespace App\Entities;

final class Card
{
    private string $name;
    private ?string $attribute;
    private string $type;
    private string $race;
    private string $description;
    private int $level;
    private ?int $atk;
    private ?int $def;
    private ?string $archetype;
    private string $imageUrl;

    /** @var array<int, array{name: string, rarity: string}> */
    private array $cardSets = [];

    /** @var array{amazon: string, cardmarket: string, coolstuffinc: string, ebay: string, tcgplayer: string} */
    private array $prices;

    /**
     * @param array<string, mixed> $rawData
     */
    public function __construct(array $rawData)
    {
        $this->name = (string) ($rawData['name'] ?? '');
        $this->attribute = isset($rawData['attribute']) ? (string) $rawData['attribute'] : null;
        $this->type = (string) ($rawData['type'] ?? '');
        $this->race = (string) ($rawData['race'] ?? '');
        $this->description = (string) ($rawData['desc'] ?? '');
        $this->level = (int) ($rawData['level'] ?? 0);
        $this->atk = isset($rawData['atk']) && is_numeric($rawData['atk']) ? (int) $rawData['atk'] : null;
        $this->def = isset($rawData['def']) && is_numeric($rawData['def']) ? (int) $rawData['def'] : null;
        $this->archetype = isset($rawData['archetype']) ? (string) $rawData['archetype'] : null;
        $this->imageUrl = (string) ($rawData['card_images'][0]['image_url'] ?? '');

        foreach (($rawData['card_sets'] ?? []) as $set) {
            $this->cardSets[] = [
                'name' => (string) ($set['set_name'] ?? ''),
                'rarity' => (string) ($set['set_rarity'] ?? ''),
            ];
        }

        $price = $rawData['card_prices'][0] ?? [];
        $this->prices = [
            'amazon' => (string) ($price['amazon_price'] ?? ''),
            'cardmarket' => (string) ($price['cardmarket_price'] ?? ''),
            'coolstuffinc' => (string) ($price['coolstuffinc_price'] ?? ''),
            'ebay' => (string) ($price['ebay_price'] ?? ''),
            'tcgplayer' => (string) ($price['tcgplayer_price'] ?? ''),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getAtk(): ?int
    {
        return $this->atk;
    }

    public function getDef(): ?int
    {
        return $this->def;
    }

    public function getArchetype(): ?string
    {
        return $this->archetype;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /** @return array<int, array{name: string, rarity: string}> */
    public function getCardSets(): array
    {
        return $this->cardSets;
    }

    /** @return array{amazon: string, cardmarket: string, coolstuffinc: string, ebay: string, tcgplayer: string} */
    public function getPrices(): array
    {
        return $this->prices;
    }

    public function getIconFilename(): ?string
    {
        $attributeIcons = [
            'DARK' => 'dark.jpg',
            'EARTH' => 'earth.jpg',
            'FIRE' => 'fire.jpg',
            'LIGHT' => 'light.jpg',
            'WATER' => 'water.jpg',
            'WIND' => 'wind.jpg',
            'DIVINE' => 'divine.jpg',
        ];

        $typeIcons = [
            'Spell Card' => 'spell.png',
            'Trap Card' => 'trap.png',
        ];

        if ($this->attribute !== null && isset($attributeIcons[$this->attribute])) {
            return $attributeIcons[$this->attribute];
        }

        return $typeIcons[$this->type] ?? null;
    }

    public function getIconLabel(): string
    {
        return $this->attribute !== null && $this->attribute !== '' ? $this->attribute : $this->type;
    }

    public function hasLevel(): bool
    {
        return $this->level > 0;
    }

    public function hasAttack(): bool
    {
        return $this->atk !== null;
    }

    public function hasDefense(): bool
    {
        return $this->def !== null;
    }

    public function getArchetypeOrDefault(): string
    {
        return $this->archetype !== null && $this->archetype !== '' ? $this->archetype : 'Não tem arquétipo';
    }

    public function hasCardSets(): bool
    {
        return $this->cardSets !== [];
    }

    public function getSetsDisplay(): string
    {
        if (!$this->hasCardSets()) {
            return 'Não tem packs';
        }

        $formattedSets = [];
        foreach ($this->cardSets as $set) {
            $formattedSets[] = $set['name'] . ' (' . $set['rarity'] . ')';
        }

        return implode(', ', $formattedSets);
    }
}
