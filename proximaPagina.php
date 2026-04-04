<?php
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_POST['paginaAtual']) || !isset($_POST['busca'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos.']);
        exit();
    }

    $paginaAtual = (int) $_POST['paginaAtual'];
    $busca = trim((string) $_POST['busca']);

    if ($paginaAtual < 1 || $busca === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos.']);
        exit();
    }

    $numResultadosPorPagina = 20;
    $offset = ($paginaAtual - 1) * $numResultadosPorPagina;
    $urlAPI = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?language=pt&fname=' . urlencode($busca) . '&num=' . $numResultadosPorPagina . '&offset=' . $offset;
    $context = stream_context_create(['http' => ['timeout' => 10]]);
    $jsonData = @file_get_contents($urlAPI, false, $context);

    if ($jsonData === false) {
        http_response_code(502);
        echo json_encode(['success' => false, 'message' => 'Não foi possível consultar a API.']);
        exit();
    }

    $responseData = json_decode($jsonData, true);

    echo json_encode([
        'success' => true,
        'paginaAtual' => $paginaAtual,
        'busca' => $busca,
        'data' => $responseData['data'] ?? [],
        'meta' => $responseData['meta'] ?? new stdClass(),
    ]);
?>