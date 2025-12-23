<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline - Assassin's Creed Portal</title>
    <meta name="description" content="Linha do tempo cronológica do universo Assassin's Creed.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        .timeline {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, var(--animus-accent), transparent);
        }
        
        .timeline-item {
            position: relative;
            width: 45%;
            padding: 1.5rem;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            margin-bottom: 2rem;
            backdrop-filter: blur(var(--glass-blur));
        }
        
        .timeline-item:nth-child(odd) {
            margin-left: 5%;
        }
        
        .timeline-item:nth-child(even) {
            margin-left: 50%;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: var(--animus-accent);
            border-radius: 50%;
            top: 2rem;
            box-shadow: 0 0 10px var(--animus-accent-glow);
        }
        
        .timeline-item:nth-child(odd)::before {
            right: -8%;
        }
        
        .timeline-item:nth-child(even)::before {
            left: -8%;
        }
        
        .timeline-year {
            color: var(--animus-accent);
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .timeline-title {
            color: var(--animus-text-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .timeline-desc {
            color: var(--animus-text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .timeline::before {
                left: 20px;
            }
            
            .timeline-item {
                width: calc(100% - 50px);
                margin-left: 50px !important;
            }
            
            .timeline-item::before {
                left: -40px !important;
                right: auto !important;
            }
        }
    </style>
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
                <li><a href="personagens.php" class="nav-link">Personagens</a></li>
                <li><a href="timeline.php" class="nav-link active">Timeline</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1>Timeline</h1>
        <p>A cronologia do conflito milenar entre Assassinos e Templários através das eras.</p>
    </header>

    <!-- Timeline -->
    <div class="timeline">
        <?php
        $eventos = [
            ['ano' => '431 a.C.', 'titulo' => 'Assassin\'s Creed Odyssey', 'desc' => 'Guerra do Peloponeso na Grécia Antiga. Kassandra/Alexios descobre os ancestrais da Ordem.'],
            ['ano' => '49 a.C.', 'titulo' => 'Assassin\'s Creed Origins', 'desc' => 'Bayek e Aya fundam a Irmandade dos Assassinos no Egito Ptolemaico.'],
            ['ano' => '861', 'titulo' => 'Assassin\'s Creed Mirage', 'desc' => 'Basim se torna um Oculto na Bagdá da Era de Ouro Islâmica.'],
            ['ano' => '873', 'titulo' => 'Assassin\'s Creed Valhalla', 'desc' => 'Eivor lidera os vikings nórdicos na invasão da Inglaterra anglo-saxã.'],
            ['ano' => '1191', 'titulo' => 'Assassin\'s Creed', 'desc' => 'Altaïr luta na Terceira Cruzada na Terra Santa.'],
            ['ano' => '1476', 'titulo' => 'Assassin\'s Creed II', 'desc' => 'Ezio inicia sua jornada como Assassino no Renascimento italiano.'],
            ['ano' => '1500', 'titulo' => 'Assassin\'s Creed Brotherhood', 'desc' => 'Ezio reconstrói a Ordem em Roma e enfrenta os Borgia.'],
            ['ano' => '1511', 'titulo' => 'Assassin\'s Creed Revelations', 'desc' => 'Ezio viaja a Constantinopla buscando os segredos de Altaïr.'],
            ['ano' => '1715', 'titulo' => 'Assassin\'s Creed IV: Black Flag', 'desc' => 'Edward Kenway navega o Caribe durante a Era de Ouro da Pirataria.'],
            ['ano' => '1754', 'titulo' => 'Assassin\'s Creed III', 'desc' => 'Connor luta pela liberdade durante a Revolução Americana.'],
            ['ano' => '1789', 'titulo' => 'Assassin\'s Creed Unity', 'desc' => 'Arno busca redenção em meio à Revolução Francesa.'],
            ['ano' => '1868', 'titulo' => 'Assassin\'s Creed Syndicate', 'desc' => 'Jacob e Evie Frye libertam Londres vitoriana.'],
        ];
        
        foreach ($eventos as $index => $e): ?>
        <div class="timeline-item animate-fadeInUp" style="animation-delay: <?= $index * 0.1 ?>s;">
            <div class="timeline-year"><?= htmlspecialchars($e['ano']) ?></div>
            <div class="timeline-title"><?= htmlspecialchars($e['titulo']) ?></div>
            <div class="timeline-desc"><?= htmlspecialchars($e['desc']) ?></div>
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
