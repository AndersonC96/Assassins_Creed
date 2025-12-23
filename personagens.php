<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagens - AC Database</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <div class="container clearfix">
        <!-- Menu Lateral -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item">Home</a></li>
                <li><a href="jogos.php" class="item">Jogos</a></li>
                <li><a href="personagens.php" class="item active">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Personagens</div>
            
            <div class="description">
                <p>Os <strong>Assassinos</strong> e <strong>Templários</strong> lendários que moldaram a história através dos séculos.</p>
                <p><strong>Passe o mouse</strong> sobre um personagem para ver o efeito de seleção.</p>
            </div>

            <!-- Characters Grid -->
            <div class="cards-grid">
                <?php
                $personagens = [
                    ['nome' => 'Altaïr Ibn-La\'Ahad', 'era' => 'Terceira Cruzada (1191)', 'jogo' => 'Assassin\'s Creed', 'desc' => 'Mestre Assassino sírio que redesenhou a Irmandade.'],
                    ['nome' => 'Ezio Auditore', 'era' => 'Renascimento (1476-1524)', 'jogo' => 'AC II, Brotherhood, Revelations', 'desc' => 'Nobre florentino, o mais célebre Mentor da Irmandade.'],
                    ['nome' => 'Connor Kenway', 'era' => 'Revolução Americana (1754)', 'jogo' => 'Assassin\'s Creed III', 'desc' => 'Meio-mohawk que lutou pela liberdade americana.'],
                    ['nome' => 'Edward Kenway', 'era' => 'Era dos Piratas (1715)', 'jogo' => 'AC IV: Black Flag', 'desc' => 'Pirata galês que descobriu os Assassinos.'],
                    ['nome' => 'Arno Dorian', 'era' => 'Revolução Francesa (1789)', 'jogo' => 'Assassin\'s Creed Unity', 'desc' => 'Assassino francês em busca de redenção.'],
                    ['nome' => 'Jacob & Evie Frye', 'era' => 'Era Vitoriana (1868)', 'jogo' => 'Assassin\'s Creed Syndicate', 'desc' => 'Gêmeos que libertaram Londres.'],
                    ['nome' => 'Bayek de Siwa', 'era' => 'Egito Ptolemaico (49 a.C.)', 'jogo' => 'Assassin\'s Creed Origins', 'desc' => 'Medjay fundador da Irmandade.'],
                    ['nome' => 'Kassandra', 'era' => 'Grécia Antiga (431 a.C.)', 'jogo' => 'Assassin\'s Creed Odyssey', 'desc' => 'Mercenária espartana descendente de Leônidas.'],
                    ['nome' => 'Eivor', 'era' => 'Era Viking (873)', 'jogo' => 'Assassin\'s Creed Valhalla', 'desc' => 'Viking que liderou a conquista da Inglaterra.'],
                    ['nome' => 'Basim Ibn Ishaq', 'era' => 'Bagdá Abássida (861)', 'jogo' => 'Assassin\'s Creed Mirage', 'desc' => 'Ladrão que se tornou um Oculto.'],
                ];
                
                foreach ($personagens as $p): ?>
                <div class="character-card card">
                    <div class="character-avatar">👤</div>
                    <div class="character-content">
                        <div class="character-name"><?= htmlspecialchars($p['nome']) ?></div>
                        <div class="character-era"><?= htmlspecialchars($p['era']) ?></div>
                        <div class="character-game"><?= htmlspecialchars($p['jogo']) ?></div>
                        <div class="character-desc"><?= htmlspecialchars($p['desc']) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
