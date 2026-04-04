<?php

declare(strict_types=1);

$query = [
    'route' => 'cards/search',
];

if (isset($_GET['busca'])) {
    $query['busca'] = (string) $_GET['busca'];
}

if (isset($_GET['pagina'])) {
    $query['pagina'] = (string) $_GET['pagina'];
}

header('Location: public/index.php?' . http_build_query($query));
exit;
