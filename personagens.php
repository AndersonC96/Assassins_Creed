<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagens - Assassin's Creed Portal</title>
    <meta name="description" content="Conheça os protagonistas lendários da saga Assassin's Creed.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                <img src="./IMG/favicon.png" alt="AC Logo" class="navbar-logo">
                <span class="navbar-title">Animus</span>
            </a>
            <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="navbar-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="jogos.php" class="nav-link">Jogos</a></li>
                <li><a href="personagens.php" class="nav-link active">Personagens</a></li>
                <li><a href="timeline.php" class="nav-link">Timeline</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1>Personagens</h1>
        <p>Os assassinos e templários lendários que moldaram a história através dos séculos.</p>
    </header>

    <!-- Characters Grid -->
    <div class="game-list">
        <?php
        $personagens = [
            ['nome' => 'Altaïr Ibn-La\'Ahad', 'era' => 'Terceira Cruzada (1191)', 'jogo' => 'Assassin\'s Creed', 'desc' => 'Mestre Assassino sírio que redesenhou a Ordem dos Assassinos.'],
            ['nome' => 'Ezio Auditore da Firenze', 'era' => 'Renascimento Italiano (1476-1524)', 'jogo' => 'AC II, Brotherhood, Revelations', 'desc' => 'Nobre florentino que se tornou o mais célebre Mentor da Irmandade.'],
            ['nome' => 'Connor Kenway', 'era' => 'Revolução Americana (1754-1783)', 'jogo' => 'Assassin\'s Creed III', 'desc' => 'Meio-mohawk que lutou pela liberdade durante a independência americana.'],
            ['nome' => 'Edward Kenway', 'era' => 'Era de Ouro da Pirataria (1715)', 'jogo' => 'AC IV: Black Flag', 'desc' => 'Pirata galês que descobriu os Assassinos enquanto buscava fortuna.'],
            ['nome' => 'Arno Dorian', 'era' => 'Revolução Francesa (1789)', 'jogo' => 'Assassin\'s Creed Unity', 'desc' => 'Assassino francês que buscou redenção em meio ao caos revolucionário.'],
            ['nome' => 'Jacob & Evie Frye', 'era' => 'Era Vitoriana (1868)', 'jogo' => 'Assassin\'s Creed Syndicate', 'desc' => 'Gêmeos que libertaram Londres do controle Templário.'],
            ['nome' => 'Bayek de Siwa', 'era' => 'Egito Ptolemaico (49 a.C.)', 'jogo' => 'Assassin\'s Creed Origins', 'desc' => 'Medjay egípcio que fundou a Irmandade dos Assassinos.'],
            ['nome' => 'Kassandra / Alexios', 'era' => 'Grécia Antiga (431 a.C.)', 'jogo' => 'Assassin\'s Creed Odyssey', 'desc' => 'Mercenário(a) espartano(a) e descendente de Leônidas.'],
            ['nome' => 'Eivor Varinsdottir', 'era' => 'Era Viking (873)', 'jogo' => 'Assassin\'s Creed Valhalla', 'desc' => 'Viking norueguês(a) que liderou seu clã na conquista da Inglaterra.'],
            ['nome' => 'Basim Ibn Ishaq', 'era' => 'Bagdá Abássida (861)', 'jogo' => 'Assassin\'s Creed Mirage', 'desc' => 'Ladrão de rua que se tornou um Oculto em Bagdá.'],
        ];
        
        foreach ($personagens as $index => $p): ?>
        <div class="game-card animate-fadeInUp" style="animation-delay: <?= $index * 0.08 ?>s;">
            <div style="height: 200px; background: linear-gradient(135deg, var(--animus-bg-secondary) 0%, var(--animus-bg-tertiary) 100%); display: flex; align-items: center; justify-content: center; font-size: 4rem; border-bottom: 1px solid var(--glass-border);">
                👤
            </div>
            <div class="game-card-content">
                <h3><?= htmlspecialchars($p['nome']) ?></h3>
                <p style="color: var(--animus-accent); font-size: 0.8rem; margin-bottom: 0.25rem;">📅 <?= htmlspecialchars($p['era']) ?></p>
                <p style="color: var(--animus-text-muted); font-size: 0.75rem; margin-bottom: 0.75rem;">🎮 <?= htmlspecialchars($p['jogo']) ?></p>
                <p><?= htmlspecialchars($p['desc']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }
    </script>
</body>
</html>
