<?php
$searchSafe = htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8');
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php?route=home">
                        <img src="assets/img/logo.png" alt="Yu-Gi-Oh! Card Explorer" class="img-fluid">
                    </a>
                </li>
            </ul>
            <form class="d-flex" role="search" action="index.php" method="get">
                <input type="hidden" name="route" value="cards/search">
                <input type="text" name="busca" placeholder="Buscar" value="<?= $searchSafe ?>" aria-label="Buscar cartas">
                <button class="btn btn-outline-success" type="submit">Procurar</button>
            </form>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($cards)): ?>
            <?php foreach ($cards as $card): ?>
                <?php
                $name = htmlspecialchars((string) ($card['name'] ?? ''), ENT_QUOTES, 'UTF-8');
                $race = htmlspecialchars((string) ($card['race'] ?? ''), ENT_QUOTES, 'UTF-8');
                $type = htmlspecialchars((string) ($card['type'] ?? ''), ENT_QUOTES, 'UTF-8');
                $desc = htmlspecialchars((string) ($card['desc'] ?? ''), ENT_QUOTES, 'UTF-8');
                $archetype = htmlspecialchars((string) ($card['archetype'] ?? ''), ENT_QUOTES, 'UTF-8');
                $image = htmlspecialchars((string) ($card['card_images'][0]['image_url'] ?? ''), ENT_QUOTES, 'UTF-8');
                $attribute = (string) ($card['attribute'] ?? '');
                $level = (int) ($card['level'] ?? 0);
                $atk = $card['atk'] ?? null;
                $def = $card['def'] ?? null;
                $prices = $card['card_prices'][0] ?? [];

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
                $icon = $attributeIcons[$attribute] ?? ($typeIcons[$card['type'] ?? ''] ?? null);
                $iconAlt = htmlspecialchars($attribute !== '' ? $attribute : (string) ($card['type'] ?? ''), ENT_QUOTES, 'UTF-8');
                ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $image ?>" class="card-img-top" alt="<?= $name ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $name ?>
                                <?php if ($icon): ?>
                                    <img src="assets/img/<?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>" class="attribute-icon" alt="<?= $iconAlt ?>">
                                <?php endif; ?>
                            </h5>
                            <p class="card-text"><b>Nível</b>:
                                <?php if ($level === 0): ?>
                                    Não tem nível
                                <?php else: ?>
                                    <?= $level ?>
                                    <?php for ($i = 0; $i < $level; $i++): ?>
                                        <img src="assets/img/level.png" alt="Nível da carta">
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><b>Raça</b>: <?= $race ?> | <b>Tipo</b>: <?= $type ?></p>
                            <p class="card-text"><b>Descrição</b>: <?= $desc ?></p>
                            <p class="card-text">
                                <?php if ($atk === null): ?>
                                    <b>ATK</b>: Não tem ataque
                                <?php else: ?>
                                    <b>ATK</b>: <?= htmlspecialchars((string) $atk, ENT_QUOTES, 'UTF-8') ?>
                                <?php endif; ?> /
                                <?php if ($def === null): ?>
                                    <b>DEF</b>: Não tem defesa
                                <?php else: ?>
                                    <b>DEF</b>: <?= htmlspecialchars((string) $def, ENT_QUOTES, 'UTF-8') ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><b>Arquétipo</b>: <?= $archetype !== '' ? $archetype : 'Não tem arquétipo' ?></p>
                            <p class="card-text"><b>Conjuntos de cartas</b>:
                                <?php if (empty($card['card_sets'])): ?>
                                    Não tem packs
                                <?php else: ?>
                                    <?php
                                    $sets = [];
                                    foreach ($card['card_sets'] as $set) {
                                        $setName = htmlspecialchars((string) ($set['set_name'] ?? ''), ENT_QUOTES, 'UTF-8');
                                        $setRarity = htmlspecialchars((string) ($set['set_rarity'] ?? ''), ENT_QUOTES, 'UTF-8');
                                        $sets[] = $setName . ' (<i>' . $setRarity . '</i>)';
                                    }
                                    echo implode(', ', $sets);
                                    ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text">
                                <b>Preços</b>: <u><i>Amazon</i></u>: U$ <?= htmlspecialchars((string) ($prices['amazon_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                <u><i>Cardmarket</i></u>: € <?= htmlspecialchars((string) ($prices['cardmarket_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>CoolStuffInc</i></u>: U$ <?= htmlspecialchars((string) ($prices['coolstuffinc_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>Ebay</i></u>: U$ <?= htmlspecialchars((string) ($prices['ebay_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>TCGplayer</i></u>: U$ <?= htmlspecialchars((string) ($prices['tcgplayer_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="empty-state">
                    <h2>Nenhuma carta encontrada</h2>
                    <p>Tente outro termo de busca para encontrar cartas, atributos ou arquétipos relacionados.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($cards) && ($page > 1 || $page < $totalPages)): ?>
        <nav class="pagination-bar" aria-label="Paginação de resultados">
            <div class="pagination-actions">
                <?php if ($page > 1): ?>
                    <a class="btn btn-outline-success" href="index.php?route=cards/search&busca=<?= urlencode((string) ($search ?? '')) ?>&pagina=<?= $page - 1 ?>">Anterior</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a class="btn btn-outline-success" href="index.php?route=cards/search&busca=<?= urlencode((string) ($search ?? '')) ?>&pagina=<?= $page + 1 ?>">Próxima</a>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>
</div>
