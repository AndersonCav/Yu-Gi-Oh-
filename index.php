<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Yu-Gi-Oh! | Card Explorer</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
        <link rel='shortcut icon' type='image/x-icon' href='./img/favicon.ico' />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <main class="hero-page">
            <section class="hero-card">
                <img class="hero-logo" src="./img/logo.png" alt="Yu-Gi-Oh! Card Explorer">
                <h1>Yu-Gi-Oh! Card Explorer</h1>
                <p>Explore cartas, atributos, tipos e detalhes da coleção oficial com uma busca rápida e visual voltado para portfólio.</p>
                <form class="hero-search" action="getCard.php" method="get">
                    <input type="text" name="busca" placeholder="Buscar cartas, arquétipos ou atributos" aria-label="Buscar cartas">
                    <button type="submit" class="btn btn-outline-success hero-button">Buscar cartas</button>
                </form>
            </section>
        </main>
    </body>
</html>