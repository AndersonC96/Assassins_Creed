<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline - AC Database</title>
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
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item active">Timeline</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Timeline</div>
            
            <div class="description">
                <p>A cronologia do <strong>conflito milenar</strong> entre Assassinos e Templários através das eras.</p>
                <p><strong>Passe o mouse</strong> sobre um evento para ver o efeito de seleção.</p>
            </div>

            <!-- Timeline -->
            <div class="timeline">
                <?php
                $eventos = [
                    ['ano' => '431 a.C.', 'titulo' => 'Assassin\'s Creed Odyssey', 'desc' => 'Guerra do Peloponeso. Kassandra/Alexios descobre os ancestrais da Ordem.'],
                    ['ano' => '49 a.C.', 'titulo' => 'Assassin\'s Creed Origins', 'desc' => 'Bayek e Aya fundam a Irmandade dos Assassinos no Egito.'],
                    ['ano' => '861', 'titulo' => 'Assassin\'s Creed Mirage', 'desc' => 'Basim se torna um Oculto na Bagdá da Era de Ouro.'],
                    ['ano' => '873', 'titulo' => 'Assassin\'s Creed Valhalla', 'desc' => 'Eivor lidera os vikings na invasão da Inglaterra.'],
                    ['ano' => '1191', 'titulo' => 'Assassin\'s Creed', 'desc' => 'Altaïr luta na Terceira Cruzada na Terra Santa.'],
                    ['ano' => '1476', 'titulo' => 'Assassin\'s Creed II', 'desc' => 'Ezio inicia sua jornada no Renascimento italiano.'],
                    ['ano' => '1500', 'titulo' => 'Assassin\'s Creed Brotherhood', 'desc' => 'Ezio reconstrói a Ordem em Roma.'],
                    ['ano' => '1511', 'titulo' => 'Assassin\'s Creed Revelations', 'desc' => 'Ezio viaja a Constantinopla buscando os segredos de Altaïr.'],
                    ['ano' => '1715', 'titulo' => 'Assassin\'s Creed IV: Black Flag', 'desc' => 'Edward Kenway navega o Caribe pirata.'],
                    ['ano' => '1754', 'titulo' => 'Assassin\'s Creed III', 'desc' => 'Connor luta na Revolução Americana.'],
                    ['ano' => '1789', 'titulo' => 'Assassin\'s Creed Unity', 'desc' => 'Arno busca redenção na Revolução Francesa.'],
                    ['ano' => '1868', 'titulo' => 'Assassin\'s Creed Syndicate', 'desc' => 'Jacob e Evie Frye libertam Londres.'],
                ];
                
                foreach ($eventos as $e): ?>
                <div class="timeline-item">
                    <div class="timeline-year"><?= htmlspecialchars($e['ano']) ?></div>
                    <div class="timeline-title"><?= htmlspecialchars($e['titulo']) ?></div>
                    <div class="timeline-desc"><?= htmlspecialchars($e['desc']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
