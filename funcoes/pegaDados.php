<?php
    function pegaDados($busca, $numResultadosPorPagina = 60, $offset = 0, &$totalRegistros = null) {
        $busca = trim((string) $busca);

        if ($busca === '') {
            $totalRegistros = 0;
            return [];
        }

        $api_url = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?language=pt&fname=' . urlencode($busca) . '&startdate=1000-01-01&enddate=3000-12-31&num=' . (int) $numResultadosPorPagina . '&offset=' . (int) $offset;
        $context = stream_context_create(['http' => ['timeout' => 10]]);
        $json_data = @file_get_contents($api_url, false, $context);

        if ($json_data === false) {
            return [];
        }

        $response_data = json_decode($json_data);

        if (!is_object($response_data) || !isset($response_data->data) || !is_array($response_data->data)) {
            $totalRegistros = 0;
            return [];
        }

        $totalRegistros = isset($response_data->meta->total_rows) ? (int) $response_data->meta->total_rows : count($response_data->data);

        return $response_data->data;
    }
?>