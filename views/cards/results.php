<?php
$searchSafe = htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8');
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./">
                        <img src="assets/img/logo.png" alt="Yu-Gi-Oh! Card Explorer" class="img-fluid">
                    </a>
                </li>
            </ul>
            <form class="d-flex" role="search" action="search" method="get">
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
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($card->getImageUrl(), ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" alt="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>
                                <?php if ($card->getIconFilename() !== null): ?>
                                    <img src="assets/img/<?= htmlspecialchars((string) $card->getIconFilename(), ENT_QUOTES, 'UTF-8') ?>" class="attribute-icon" alt="<?= htmlspecialchars($card->getIconLabel(), ENT_QUOTES, 'UTF-8') ?>">
                                <?php endif; ?>
                            </h5>
                            <p class="card-text"><b>Nível</b>:
                                <?php if (!$card->hasLevel()): ?>
                                    Não tem nível
                                <?php else: ?>
                                    <?= htmlspecialchars((string) $card->getLevel(), ENT_QUOTES, 'UTF-8') ?>
                                    <?php for ($i = 0; $i < $card->getLevel(); $i++): ?>
                                        <img src="assets/img/level.png" alt="Nível da carta">
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><b>Raça</b>: <?= htmlspecialchars($card->getRace(), ENT_QUOTES, 'UTF-8') ?> | <b>Tipo</b>: <?= htmlspecialchars($card->getType(), ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><b>Descrição</b>: <?= htmlspecialchars($card->getDescription(), ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text">
                                <?php if (!$card->hasAttack()): ?>
                                    <b>ATK</b>: Não tem ataque
                                <?php else: ?>
                                    <b>ATK</b>: <?= htmlspecialchars((string) $card->getAtk(), ENT_QUOTES, 'UTF-8') ?>
                                <?php endif; ?> /
                                <?php if (!$card->hasDefense()): ?>
                                    <b>DEF</b>: Não tem defesa
                                <?php else: ?>
                                    <b>DEF</b>: <?= htmlspecialchars((string) $card->getDef(), ENT_QUOTES, 'UTF-8') ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><b>Arquétipo</b>: <?= htmlspecialchars($card->getArchetypeOrDefault(), ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><b>Conjuntos de cartas</b>: <?= htmlspecialchars($card->getSetsDisplay(), ENT_QUOTES, 'UTF-8') ?></p>
                            <?php $prices = $card->getPrices(); ?>
                            <p class="card-text">
                                <b>Preços</b>: <u><i>Amazon</i></u>: U$ <?= htmlspecialchars($prices['amazon'], ENT_QUOTES, 'UTF-8') ?>
                                <u><i>Cardmarket</i></u>: € <?= htmlspecialchars($prices['cardmarket'], ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>CoolStuffInc</i></u>: U$ <?= htmlspecialchars($prices['coolstuffinc'], ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>Ebay</i></u>: U$ <?= htmlspecialchars($prices['ebay'], ENT_QUOTES, 'UTF-8') ?> |
                                <u><i>TCGplayer</i></u>: U$ <?= htmlspecialchars($prices['tcgplayer'], ENT_QUOTES, 'UTF-8') ?>
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
                    <a class="btn btn-outline-success" href="search?busca=<?= urlencode((string) ($search ?? '')) ?>&pagina=<?= $page - 1 ?>">Anterior</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a class="btn btn-outline-success" href="search?busca=<?= urlencode((string) ($search ?? '')) ?>&pagina=<?= $page + 1 ?>">Próxima</a>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>
</div>
