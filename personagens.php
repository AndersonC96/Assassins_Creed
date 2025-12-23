<?php
    $accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    
    // IDs dos jogos da série principal para buscar personagens
    $gameIds = "128,127,113,537,1266,1970,7570,5606,8263,28540,103054,133004,215060";
    
    // Buscar personagens dos jogos de AC
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.igdb.com/v4/characters",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Client-ID: $clientID",
            "Authorization: Bearer $accessToken",
            "Accept: application/json"
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "fields name, description, mug_shot.url, mug_shot.image_id, akas, games.name; where games = ($gameIds); limit 100;"
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    $apiCharacters = json_decode($response, true);
    
    // Dados manuais dos protagonistas principais (caso a API não retorne)
    $protagonistas = [
        ['nome' => 'Altaïr Ibn-La\'Ahad', 'era' => 'Terceira Cruzada (1191)', 'jogo' => 'Assassin\'s Creed', 
         'desc' => 'Mestre Assassino sírio que redesenhou completamente a Irmandade dos Assassinos. Autor do Codex que guiou a Ordem por séculos.',
         'akas' => ['O Mentor', 'Águia de Masyaf']],
        ['nome' => 'Ezio Auditore da Firenze', 'era' => 'Renascimento Italiano (1476-1524)', 'jogo' => 'AC II, Brotherhood, Revelations', 
         'desc' => 'Nobre florentino que se tornou o mais célebre Mentor da Irmandade. Sua história abrange três jogos principais.',
         'akas' => ['O Profeta', 'Il Mentore']],
        ['nome' => 'Connor Kenway (Ratonhnhaké:ton)', 'era' => 'Revolução Americana (1754-1783)', 'jogo' => 'Assassin\'s Creed III', 
         'desc' => 'Meio-mohawk, meio-inglês que lutou pela liberdade durante a independência americana, enfrentando seu próprio pai Templário.',
         'akas' => ['Ratonhnhaké:ton', 'Connor']],
        ['nome' => 'Edward Kenway', 'era' => 'Era de Ouro da Pirataria (1715)', 'jogo' => 'AC IV: Black Flag', 
         'desc' => 'Pirata galês que descobriu os Assassinos enquanto buscava fortuna no Caribe. Avô de Connor.',
         'akas' => ['Capitão Kenway', 'Edward o Pirata']],
        ['nome' => 'Arno Dorian', 'era' => 'Revolução Francesa (1789)', 'jogo' => 'Assassin\'s Creed Unity', 
         'desc' => 'Assassino francês que buscou redenção em meio ao caos da Revolução Francesa, apaixonado por uma Templária.',
         'akas' => ['Arno', 'O Órfão']],
        ['nome' => 'Jacob Frye', 'era' => 'Era Vitoriana (1868)', 'jogo' => 'Assassin\'s Creed Syndicate', 
         'desc' => 'Gêmeo impulsivo e carismático que fundou os Rooks para libertar Londres do controle Templário.',
         'akas' => ['O Líder dos Rooks']],
        ['nome' => 'Evie Frye', 'era' => 'Era Vitoriana (1868)', 'jogo' => 'Assassin\'s Creed Syndicate', 
         'desc' => 'Gêmea calculista e estudiosa, focada em encontrar um Pedaço do Éden enquanto libertava Londres.',
         'akas' => ['A Sombra']],
        ['nome' => 'Bayek de Siwa', 'era' => 'Egito Ptolemaico (49 a.C.)', 'jogo' => 'Assassin\'s Creed Origins', 
         'desc' => 'Último Medjay do Egito que, junto com sua esposa Aya, fundou a Irmandade dos Assassinos após vingança.',
         'akas' => ['O Medjay', 'Fundador']],
        ['nome' => 'Kassandra', 'era' => 'Grécia Antiga (431 a.C.)', 'jogo' => 'Assassin\'s Creed Odyssey', 
         'desc' => 'Mercenária espartana e descendente de Leônidas que portava a Lança de Leônidas. Viveu por mais de 2000 anos.',
         'akas' => ['Misthios', 'A Portadora da Lança', 'Eagle Bearer']],
        ['nome' => 'Eivor Varinsdottir', 'era' => 'Era Viking (873)', 'jogo' => 'Assassin\'s Creed Valhalla', 
         'desc' => 'Viking norueguês(a) que liderou seu clã na conquista da Inglaterra, tornando-se aliado(a) dos Ocultos.',
         'akas' => ['Wolf-Kissed', 'Drengr']],
        ['nome' => 'Basim Ibn Ishaq', 'era' => 'Bagdá Abássida (861)', 'jogo' => 'Assassin\'s Creed Mirage', 
         'desc' => 'Ladrão de rua em Bagdá que se tornou um membro dos Ocultos, escondendo um segredo ancestral.',
         'akas' => ['O Oculto', 'Loki']],
    ];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagens - AC Database</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        .character-section {
            margin-bottom: 2em;
        }
        .section-header {
            background: var(--title-bg);
            padding: 0.75em 1em;
            margin-bottom: 1em;
            border-left: 4px solid var(--accent-red);
        }
        .section-header h2 {
            color: var(--title-color);
            font-size: 1.1rem;
            text-transform: uppercase;
            margin: 0;
        }
        .character-card {
            background: var(--item-bg);
            display: flex;
            gap: 1.5em;
            padding: 1.5em;
            margin-bottom: 1em;
            transition: all 0.4s;
        }
        .character-card:hover {
            background: var(--active-bg);
            transform: translateX(10px);
        }
        .character-avatar {
            width: 120px;
            height: 150px;
            background: linear-gradient(135deg, #444, #666);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: rgba(255,255,255,0.3);
            flex-shrink: 0;
        }
        .character-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .character-info {
            flex: 1;
        }
        .character-name {
            font-size: 1.25rem;
            font-weight: 500;
            text-transform: uppercase;
            color: #222;
            margin-bottom: 0.25em;
        }
        .character-era {
            font-size: 0.85rem;
            color: var(--accent-red);
            margin-bottom: 0.25em;
        }
        .character-game {
            font-size: 0.75rem;
            color: #888;
            margin-bottom: 0.75em;
        }
        .character-desc {
            font-size: 0.9rem;
            color: #444;
            line-height: 1.6;
            margin-bottom: 0.75em;
        }
        .character-akas {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5em;
        }
        .aka-tag {
            background: rgba(0,0,0,0.1);
            padding: 0.2em 0.6em;
            font-size: 0.7rem;
            text-transform: uppercase;
            border-left: 2px solid var(--accent-red);
        }
        .api-characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1em;
        }
        .api-character-card {
            background: var(--item-bg);
            padding: 1em;
            text-align: center;
            transition: all 0.4s;
        }
        .api-character-card:hover {
            background: var(--active-bg);
        }
        .api-character-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.75em;
        }
        .api-character-card .name {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #222;
        }
        @media (max-width: 768px) {
            .character-card {
                flex-direction: column;
                text-align: center;
            }
            .character-avatar {
                margin: 0 auto;
            }
        }
    </style>
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
                <p>Os <strong>Assassinos</strong> lendários que moldaram a história através dos séculos. Cada um carrega o legado da Irmandade.</p>
            </div>

            <!-- Protagonistas Principais -->
            <section class="character-section">
                <div class="section-header">
                    <h2>Protagonistas da Saga</h2>
                </div>
                
                <?php foreach ($protagonistas as $p): ?>
                <div class="character-card">
                    <div class="character-avatar">👤</div>
                    <div class="character-info">
                        <div class="character-name"><?= htmlspecialchars($p['nome']) ?></div>
                        <div class="character-era">📅 <?= htmlspecialchars($p['era']) ?></div>
                        <div class="character-game">🎮 <?= htmlspecialchars($p['jogo']) ?></div>
                        <div class="character-desc"><?= htmlspecialchars($p['desc']) ?></div>
                        <?php if (isset($p['akas']) && !empty($p['akas'])): ?>
                        <div class="character-akas">
                            <?php foreach ($p['akas'] as $aka): ?>
                            <span class="aka-tag"><?= htmlspecialchars($aka) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>

            <!-- Personagens da API IGDB -->
            <?php if (is_array($apiCharacters) && !empty($apiCharacters) && !isset($apiCharacters['message'])): ?>
            <section class="character-section">
                <div class="section-header">
                    <h2>Outros Personagens (via API IGDB)</h2>
                </div>
                
                <div class="api-characters-grid">
                    <?php foreach ($apiCharacters as $char): ?>
                    <div class="api-character-card">
                        <?php if (isset($char['mug_shot']['url'])): ?>
                        <img src="https:<?= str_replace('t_thumb', 't_micro', $char['mug_shot']['url']) ?>" alt="<?= htmlspecialchars($char['name']) ?>">
                        <?php else: ?>
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: #666; margin: 0 auto 0.75em; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: rgba(255,255,255,0.3);">👤</div>
                        <?php endif; ?>
                        <div class="name"><?= htmlspecialchars($char['name']) ?></div>
                        <?php if (isset($char['games']) && count($char['games']) > 0): ?>
                        <div style="font-size: 0.7rem; color: #888; margin-top: 0.25em;"><?= htmlspecialchars($char['games'][0]['name'] ?? '') ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
