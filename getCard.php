<?php

declare(strict_types=1);

$query = [];

if (isset($_GET['busca'])) {
    $query['busca'] = (string) $_GET['busca'];
}

if (isset($_GET['pagina'])) {
    $query['pagina'] = (string) $_GET['pagina'];
}

$location = 'public/search';
if ($query !== []) {
    $location .= '?' . http_build_query($query);
}

header('Location: ' . $location);
exit;
