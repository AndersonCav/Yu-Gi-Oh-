<main class="hero-page">
    <section class="hero-card">
        <h1><?= htmlspecialchars($title ?? 'Erro', ENT_QUOTES, 'UTF-8') ?></h1>
        <p><?= htmlspecialchars($message ?? 'Ocorreu um erro inesperado.', ENT_QUOTES, 'UTF-8') ?></p>
        <a class="btn btn-outline-success hero-button" href="/">Voltar ao início</a>
    </section>
</main>
