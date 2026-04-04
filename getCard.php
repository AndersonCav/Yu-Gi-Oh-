<?php
    error_reporting(0);
    ini_set('display_errors', '0');
    include_once './funcoes/pegaDados.php';

    $busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
    $paginaAtual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

    if ($paginaAtual < 1) {
        $paginaAtual = 1;
    }

    $cartasPorPagina = 10;
    $inicio = ($paginaAtual - 1) * $cartasPorPagina;
    $totalRegistros = 0;
    $cartas = $busca !== '' ? pegaDados($busca, $cartasPorPagina, $inicio, $totalRegistros) : [];
    $buscaExibida = htmlspecialchars($busca, ENT_QUOTES, 'UTF-8');
    $totalDePaginas = $totalRegistros > 0 ? (int) ceil($totalRegistros / $cartasPorPagina) : 1;
    $temProximaPagina = $paginaAtual < $totalDePaginas;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Yu-Gi-Oh! | Busca de Cartas</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
        <link rel='shortcut icon' type='image/x-icon' href='./img/favicon.ico' />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </head>
    <body class="is-loading">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">
                                <img src="./img/logo.png" alt="Yu-Gi-Oh! Card Explorer" class="img-fluid">
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action="getCard.php" method="get">
                        <input type="text" name="busca" placeholder="Buscar" value="<?php echo $buscaExibida; ?>" aria-label="Buscar cartas">
                        <button class="btn btn-outline-success" type="submit">Procurar</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="results-skeleton" aria-hidden="true">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-image"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-line skeleton-title"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-image"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-line skeleton-title"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card skeleton-card h-100">
                            <div class="skeleton skeleton-image"></div>
                            <div class="card-body">
                                <div class="skeleton skeleton-line skeleton-title"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                                <div class="skeleton skeleton-line"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (!empty($cartas)) : ?>
                    <?php foreach ($cartas as $card) : ?>
                        <?php
                            $cardName = htmlspecialchars($card->name ?? '', ENT_QUOTES, 'UTF-8');
                            $cardRace = htmlspecialchars($card->race ?? '', ENT_QUOTES, 'UTF-8');
                            $cardType = htmlspecialchars($card->type ?? '', ENT_QUOTES, 'UTF-8');
                            $cardDesc = htmlspecialchars($card->desc ?? '', ENT_QUOTES, 'UTF-8');
                            $cardArchetype = htmlspecialchars($card->archetype ?? '', ENT_QUOTES, 'UTF-8');
                            $cardImage = htmlspecialchars($card->card_images[0]->image_url ?? '', ENT_QUOTES, 'UTF-8');
                            $cardAttribute = $card->attribute ?? '';
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
                            $icon = $attributeIcons[$cardAttribute] ?? ($typeIcons[$card->type ?? ''] ?? null);
                            $iconAlt = htmlspecialchars($cardAttribute ?: ($card->type ?? ''), ENT_QUOTES, 'UTF-8');
                            $cardPrice = $card->card_prices[0] ?? null;
                            $cardLevel = (int) ($card->level ?? 0);
                        ?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?php echo $cardImage; ?>" class="card-img-top" alt="<?php echo $cardName; ?>">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $cardName; ?>
                                        <?php if ($icon) : ?>
                                            <img src="./img/<?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>" class="attribute-icon" alt="<?php echo $iconAlt; ?>">
                                        <?php endif; ?>
                                    </h5>
                                    <p class="card-text"><b>Nível</b>:
                                        <?php if ($cardLevel === 0) : ?>
                                            Não tem nível
                                        <?php else : ?>
                                            <?php echo $cardLevel; ?>
                                            <?php for ($levelIndex = 0; $levelIndex < $cardLevel; $levelIndex++) : ?>
                                                <img src="./img/level.png" alt="Nível da carta">
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text"><?php echo '<b>Raça</b>: ' . $cardRace; ?> | <?php echo '<b>Tipo</b>: ' . $cardType; ?></p>
                                    <p class="card-text"><?php echo '<b>Descrição</b>: ' . $cardDesc; ?></p>
                                    <p class="card-text">
                                        <?php if (($card->atk ?? null) === null) : ?>
                                            <b>ATK</b>: Não tem ataque
                                        <?php else : ?>
                                            <b>ATK</b>: <?php echo htmlspecialchars((string) $card->atk, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php endif; ?> /
                                        <?php if (($card->def ?? null) === null) : ?>
                                            <b>DEF</b>: Não tem defesa
                                        <?php else : ?>
                                            <b>DEF</b>: <?php echo htmlspecialchars((string) $card->def, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text"><b>Arquétipo</b>:
                                        <?php echo empty($cardArchetype) ? 'Não tem arquétipo' : $cardArchetype; ?>
                                    </p>
                                    <p class="card-text"><b>Conjuntos de cartas</b>:
                                        <?php
                                            if (empty($card->card_sets)) {
                                                echo 'Não tem packs';
                                            } else {
                                                $conjuntos = [];
                                                foreach ($card->card_sets as $set) {
                                                    $setName = htmlspecialchars($set->set_name ?? '', ENT_QUOTES, 'UTF-8');
                                                    $setRarity = htmlspecialchars($set->set_rarity ?? '', ENT_QUOTES, 'UTF-8');
                                                    $conjuntos[] = $setName . ' (<i>' . $setRarity . '</i>)';
                                                }

                                                echo implode(', ', $conjuntos);
                                            }
                                        ?>
                                    </p>
                                    <p class="card-text">
                                        <b>Preços</b>: <u><i>Amazon</i></u>: U$ <?php echo htmlspecialchars((string) ($cardPrice->amazon_price ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                        <u><i>Cardmarket</i></u>: € <?php echo htmlspecialchars((string) ($cardPrice->cardmarket_price ?? ''), ENT_QUOTES, 'UTF-8'); ?> |
                                        <u><i>CoolStuffInc</i></u>: U$ <?php echo htmlspecialchars((string) ($cardPrice->coolstuffinc_price ?? ''), ENT_QUOTES, 'UTF-8'); ?> |
                                        <u><i>Ebay</i></u>: U$ <?php echo htmlspecialchars((string) ($cardPrice->ebay_price ?? ''), ENT_QUOTES, 'UTF-8'); ?> |
                                        <u><i>TCGplayer</i></u>: U$ <?php echo htmlspecialchars((string) ($cardPrice->tcgplayer_price ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <h2>Nenhuma carta encontrada</h2>
                            <p>Tente outro termo de busca para encontrar cartas, atributos ou arquétipos relacionados.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($cartas) && ($paginaAtual > 1 || $temProximaPagina)) : ?>
                <nav class="pagination-bar" aria-label="Paginação de resultados">
                    <div class="pagination-actions">
                        <?php if ($paginaAtual > 1) : ?>
                            <a class="btn btn-outline-success" href="getCard.php?busca=<?php echo urlencode($busca); ?>&pagina=<?php echo $paginaAtual - 1; ?>">Anterior</a>
                        <?php endif; ?>
                        <?php if ($temProximaPagina) : ?>
                            <a class="btn btn-outline-success" href="getCard.php?busca=<?php echo urlencode($busca); ?>&pagina=<?php echo $paginaAtual + 1; ?>">Próxima</a>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script>
            window.addEventListener('load', function () {
                document.body.classList.remove('is-loading');
            });
        </script>
    </body>
</html>