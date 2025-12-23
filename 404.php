<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada | AC Database</title>
    <meta name="description" content="Memória corrompida. A página que você procura foi dessincronizada.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        .error-container {
            min-height: 80vh;
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
        
        .error-code::before,
        .error-code::after {
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
        }
        
        .error-code::before {
            animation: glitchTop 1s infinite;
            clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
            -webkit-clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
        }
        
        .error-code::after {
            animation: glitchBottom 1.5s infinite;
            clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
            -webkit-clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
        }
        
        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(2px, -2px); }
            60% { transform: translate(-1px, -1px); }
            80% { transform: translate(1px, 1px); }
        }
        
        @keyframes glitchTop {
            0%, 100% { transform: translate(0); opacity: 0.8; }
            50% { transform: translate(3px, 0); }
        }
        
        @keyframes glitchBottom {
            0%, 100% { transform: translate(0); opacity: 0.8; }
            50% { transform: translate(-3px, 0); }
        }
        
        .error-title {
            font-size: 1.5rem;
            text-transform: uppercase;
            color: #333;
            margin: 1em 0 0.5em;
            letter-spacing: 0.2em;
        }
        
        .error-message {
            font-size: 1rem;
            color: #666;
            max-width: 500px;
            line-height: 1.6;
            margin-bottom: 2em;
        }
        
        .error-icon {
            font-size: 4rem;
            color: rgba(112, 0, 0, 0.3);
            margin-bottom: 1em;
        }
        
        .error-actions {
            display: flex;
            gap: 1em;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .error-btn {
            padding: 1em 2em;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }
        
        .error-btn-primary {
            background: var(--accent-red);
            color: #fff;
            border: 2px solid var(--accent-red);
        }
        
        .error-btn-primary:hover {
            background: #8b0000;
            border-color: #8b0000;
        }
        
        .error-btn-secondary {
            background: transparent;
            color: #333;
            border: 2px solid #333;
        }
        
        .error-btn-secondary:hover {
            background: #333;
            color: #fff;
        }
        
        /* Animus Effect */
        .animus-lines {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            background: 
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(112, 0, 0, 0.03) 2px,
                    rgba(112, 0, 0, 0.03) 4px
                );
            z-index: 0;
        }
        
        .error-suggestions {
            margin-top: 3em;
            padding-top: 2em;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .error-suggestions h3 {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 1em;
            letter-spacing: 0.1em;
        }
        
        .suggestion-links {
            display: flex;
            gap: 1.5em;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .suggestion-links a {
            color: var(--accent-red);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5em;
            transition: transform 0.3s;
        }
        
        .suggestion-links a:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body>
    <div class="animus-lines"></div>
    
    <div class="container clearfix">
        <!-- Menu Lateral -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item">Home</a></li>
                <li><a href="jogos.php" class="item">Jogos</a></li>
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
                <li><a href="livros.php" class="item">Livros & Mídia</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
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
                    <a href="index.php" class="error-btn error-btn-primary">
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
                        <a href="jogos.php"><i class="bi bi-controller"></i> Jogos</a>
                        <a href="personagens.php"><i class="bi bi-people"></i> Personagens</a>
                        <a href="timeline.php"><i class="bi bi-hourglass-split"></i> Timeline</a>
                        <a href="livros.php"><i class="bi bi-book"></i> Livros</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="./JS/main.js"></script>
</body>
</html>
