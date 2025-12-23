<div class="error-container">
    <div class="error-icon">
        <i class="bi bi-exclamation-triangle"></i>
    </div>
    
    <div class="error-code">404</div>
    
    <h1 class="error-title">Memória Corrompida</h1>
    
    <p class="error-message">
        A sequência de DNA ancestral foi dessincronizada. 
        A página que você procura não existe ou foi removida do Animus.
    </p>
    
    <div class="error-actions">
        <a href="<?= $baseUrl ?>/" class="error-btn error-btn-primary">
            <i class="bi bi-house"></i>
            Voltar ao Início
        </a>
        <a href="javascript:history.back()" class="error-btn error-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Página Anterior
        </a>
    </div>
    
    <div class="error-suggestions">
        <h3>Talvez você esteja procurando:</h3>
        <div class="suggestion-links">
            <a href="<?= $baseUrl ?>/games"><i class="bi bi-controller"></i> Jogos</a>
            <a href="<?= $baseUrl ?>/characters"><i class="bi bi-people"></i> Personagens</a>
            <a href="<?= $baseUrl ?>/timeline"><i class="bi bi-hourglass-split"></i> Timeline</a>
            <a href="<?= $baseUrl ?>/media"><i class="bi bi-book"></i> Livros</a>
        </div>
    </div>
</div>

<style>
    /* Inline styles for error page specific elements */
    .error-container {
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2em;
    }
    .error-code {
        font-size: 8rem;
        font-weight: 700;
        color: var(--accent-red);
        line-height: 1;
        text-shadow: 4px 4px 0 rgba(0,0,0,0.2);
        animation: glitch 2s infinite;
        position: relative;
    }
    /* Rest of glitch CSS from original 404.php */
</style>
