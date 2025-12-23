<?php
    $accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    
    // Personagens organizados por categoria com dados completos
    $categorias = [
        'assassinos' => [
            'titulo' => 'Assassinos & Protagonistas',
            'desc' => 'Os heróis que carregam o legado da Irmandade através dos séculos',
            'icon' => 'bi-person-badge',
            'personagens' => [
                ['nome' => 'Altaïr Ibn-La\'Ahad', 'era' => 'Terceira Cruzada (1191)', 
                 'jogo' => 'Assassin\'s Creed', 'game_id' => 128, 'ano' => 1191,
                 'desc' => 'Mestre Assassino sírio que redesenhou completamente a Irmandade dos Assassinos. Autor do Codex que guiou a Ordem por séculos. Descobriu os segredos da Maçã do Éden e reformou os rituais da Irmandade.',
                 'akas' => ['O Mentor', 'Águia de Masyaf'],
                 'tipo' => 'Mentor', 'nacionalidade' => 'Sírio'],
                 
                ['nome' => 'Ezio Auditore da Firenze', 'era' => 'Renascimento Italiano (1476-1524)', 
                 'jogo' => 'AC II, Brotherhood, Revelations', 'game_id' => 127, 'ano' => 1476,
                 'desc' => 'Nobre florentino que se tornou o mais célebre Mentor da Irmandade Italiana. Sua história abrange três jogos principais, desde sua vingança pessoal até se tornar o líder supremo dos Assassinos.',
                 'akas' => ['O Profeta', 'Il Mentore'],
                 'tipo' => 'Mentor', 'nacionalidade' => 'Italiano'],
                 
                ['nome' => 'Connor Kenway', 'era' => 'Revolução Americana (1754-1783)', 
                 'jogo' => 'Assassin\'s Creed III', 'game_id' => 1266, 'ano' => 1754,
                 'desc' => 'Ratonhnhaké:ton, meio-mohawk e meio-inglês, lutou pela liberdade durante a Revolução Americana. Enfrentou seu próprio pai, o Templário Haytham Kenway, na luta pelo futuro da América.',
                 'akas' => ['Ratonhnhaké:ton'],
                 'tipo' => 'Assassino', 'nacionalidade' => 'Mohawk/Inglês'],
                 
                ['nome' => 'Edward Kenway', 'era' => 'Era de Ouro da Pirataria (1715)', 
                 'jogo' => 'AC IV: Black Flag', 'game_id' => 1970, 'ano' => 1715,
                 'desc' => 'Pirata galês que buscava fortuna no Caribe e acabou descobrindo a guerra secreta entre Assassinos e Templários. Avô de Connor Kenway e pai de Haytham Kenway.',
                 'akas' => ['Capitão Kenway', 'O Pirata'],
                 'tipo' => 'Pirata/Assassino', 'nacionalidade' => 'Galês'],
                 
                ['nome' => 'Shay Patrick Cormac', 'era' => 'Guerra dos Sete Anos (1752-1760)', 
                 'jogo' => 'AC Rogue', 'game_id' => 7570, 'ano' => 1752,
                 'desc' => 'Ex-Assassino que se tornou Templário após descobrir que a Irmandade causou um terremoto devastador em Lisboa. Caçou e eliminou vários Assassinos, incluindo mentores.',
                 'akas' => ['O Caçador de Assassinos'],
                 'tipo' => 'Ex-Assassino/Templário', 'nacionalidade' => 'Irlandês'],
                 
                ['nome' => 'Arno Dorian', 'era' => 'Revolução Francesa (1789)', 
                 'jogo' => 'Assassin\'s Creed Unity', 'game_id' => 5606, 'ano' => 1789,
                 'desc' => 'Órfão criado pelo Grão-Mestre Templário François de la Serre. Após a morte de seu pai adotivo, juntou-se aos Assassinos buscando redenção, enquanto amava a Templária Élise.',
                 'akas' => ['O Órfão'],
                 'tipo' => 'Assassino', 'nacionalidade' => 'Francês'],
                 
                ['nome' => 'Jacob Frye', 'era' => 'Era Vitoriana (1868)', 
                 'jogo' => 'AC Syndicate', 'game_id' => 8263, 'ano' => 1868,
                 'desc' => 'Gêmeo impulsivo e carismático que fundou os Rooks, uma gangue para combater a influência Templária em Londres. Prefere ação direta e combate corpo a corpo.',
                 'akas' => ['Líder dos Rooks'],
                 'tipo' => 'Assassino', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Evie Frye', 'era' => 'Era Vitoriana (1868)', 
                 'jogo' => 'AC Syndicate', 'game_id' => 8263, 'ano' => 1868,
                 'desc' => 'Gêmea calculista e estudiosa de Jacob. Focada em encontrar um Pedaço do Éden enquanto libertava Londres. Especialista em furtividade e infiltração.',
                 'akas' => ['A Sombra'],
                 'tipo' => 'Assassina', 'nacionalidade' => 'Inglesa'],
                 
                ['nome' => 'Bayek de Siwa', 'era' => 'Egito Ptolemaico (49 a.C.)', 
                 'jogo' => 'AC Origins', 'game_id' => 28540, 'ano' => -49,
                 'desc' => 'Último Medjay do Egito que, junto com sua esposa Aya, fundou a Irmandade dos Ocultos (predecessora dos Assassinos) após a morte de seu filho Khemu.',
                 'akas' => ['O Medjay', 'Fundador dos Ocultos'],
                 'tipo' => 'Medjay/Fundador', 'nacionalidade' => 'Egípcio'],
                 
                ['nome' => 'Aya de Alexandria', 'era' => 'Egito Ptolemaico (49 a.C.)', 
                 'jogo' => 'AC Origins', 'game_id' => 28540, 'ano' => -49,
                 'desc' => 'Esposa de Bayek e cofundadora dos Ocultos. Tornou-se Amunet, uma das Assassinas mais lendárias, responsável pela morte de Cleópatra.',
                 'akas' => ['Amunet'],
                 'tipo' => 'Fundadora', 'nacionalidade' => 'Egípcia/Grega'],
                 
                ['nome' => 'Kassandra', 'era' => 'Grécia Antiga (431 a.C.)', 
                 'jogo' => 'AC Odyssey', 'game_id' => 103054, 'ano' => -431,
                 'desc' => 'Mercenária espartana, descendente de Leônidas e portadora de sua lança. Graças ao Bastão de Hermes, viveu por mais de 2.400 anos, encontrando Layla Hassan em 2018.',
                 'akas' => ['Misthios', 'Eagle Bearer', 'Guardiã'],
                 'tipo' => 'Mercenária/Imortal', 'nacionalidade' => 'Espartana'],
                 
                ['nome' => 'Eivor Varinsdottir', 'era' => 'Era Viking (873)', 
                 'jogo' => 'AC Valhalla', 'game_id' => 133004, 'ano' => 873,
                 'desc' => 'Viking norueguês(a) que liderou o clã do Corvo na conquista da Inglaterra. Tornou-se aliado(a) dos Ocultos e descobriu a verdade sobre a reencarnação de Odin.',
                 'akas' => ['Wolf-Kissed', 'Drengr'],
                 'tipo' => 'Viking/Aliado dos Ocultos', 'nacionalidade' => 'Norueguês(a)'],
                 
                ['nome' => 'Basim Ibn Ishaq', 'era' => 'Bagdá Abássida (861)', 
                 'jogo' => 'AC Mirage', 'game_id' => 215060, 'ano' => 861,
                 'desc' => 'Ladrão de rua em Bagdá que se tornou membro dos Ocultos. Esconde um segredo ancestral: é a reencarnação de Loki, o deus nórdico da trapaça.',
                 'akas' => ['O Oculto', 'Loki'],
                 'tipo' => 'Oculto', 'nacionalidade' => 'Árabe'],
                 
                // AC Shadows (2024)
                ['nome' => 'Naoe', 'era' => 'Japão Feudal (1579)', 
                 'jogo' => 'AC Shadows', 'game_id' => 300976, 'ano' => 1579,
                 'desc' => 'Shinobi japonesa e filha de um líder ninja. Especialista em furtividade, infiltração e uso de kunais. Representa o estilo clássico de assassinato da franquia.',
                 'akas' => ['A Shinobi', 'Filha das Sombras'],
                 'tipo' => 'Shinobi', 'nacionalidade' => 'Japonesa'],
                 
                ['nome' => 'Yasuke', 'era' => 'Japão Feudal (1579)', 
                 'jogo' => 'AC Shadows', 'game_id' => 300976, 'ano' => 1579,
                 'desc' => 'Samurai africano histórico que serviu Oda Nobunaga. Especialista em combate direto e força bruta. Primeiro samurai negro documentado na história do Japão.',
                 'akas' => ['O Samurai Negro', 'Yasuke de Nobunaga'],
                 'tipo' => 'Samurai', 'nacionalidade' => 'Africano/Japonês'],
                 
                // Outros protagonistas importantes
                ['nome' => 'Alexios', 'era' => 'Grécia Antiga (431 a.C.)', 
                 'jogo' => 'AC Odyssey', 'game_id' => 103054, 'ano' => -431,
                 'desc' => 'Irmão de Kassandra e protagonista alternativo de Odyssey. Se não for escolhido como protagonista, torna-se o antagonista Deimos, líder do Culto de Kosmos.',
                 'akas' => ['Deimos', 'O Demigod'],
                 'tipo' => 'Mercenário/Antagonista', 'nacionalidade' => 'Espartano'],
                 
                ['nome' => 'Aveline de Grandpré', 'era' => 'Revolução Americana (1765)', 
                 'jogo' => 'AC Liberation, AC III', 'game_id' => 1266, 'ano' => 1765,
                 'desc' => 'Assassina afro-francesa de Nova Orleans. Primeira protagonista feminina da série principal. Lutou contra a escravidão e a influência Templária no sul.',
                 'akas' => ['A Libertadora'],
                 'tipo' => 'Assassina', 'nacionalidade' => 'Afro-Francesa'],
                 
                ['nome' => 'Adéwalé', 'era' => 'Era da Pirataria (1715-1735)', 
                 'jogo' => 'AC IV, Freedom Cry', 'game_id' => 1970, 'ano' => 1715,
                 'desc' => 'Ex-escravo que se tornou pirata ao lado de Edward Kenway e depois Assassino. Protagonista de Freedom Cry, lutou contra o tráfico de escravos.',
                 'akas' => ['O Libertador'],
                 'tipo' => 'Pirata/Assassino', 'nacionalidade' => 'Trinidadiano'],
                 
                ['nome' => 'Roshan', 'era' => 'Bagdá Abássida (861)', 
                 'jogo' => 'AC Mirage', 'game_id' => 215060, 'ano' => 861,
                 'desc' => 'Mentora de Basim e líder dos Ocultos em Bagdá. Uma das Assassinas mais habilidosas de sua era, treinou Basim desde jovem.',
                 'akas' => ['A Mentora'],
                 'tipo' => 'Mentora', 'nacionalidade' => 'Persa'],
                 
                ['nome' => 'Sigurd Styrbjornsson', 'era' => 'Era Viking (873)', 
                 'jogo' => 'AC Valhalla', 'game_id' => 133004, 'ano' => 873,
                 'desc' => 'Irmão adotivo de Eivor e líder do clã do Corvo. Reencarnação de Tyr, deus nórdico da guerra e justiça.',
                 'akas' => ['Tyr'],
                 'tipo' => 'Viking/Isu', 'nacionalidade' => 'Norueguês'],
            ]
        ],
        
        'templarios' => [
            'titulo' => 'Templários Notáveis',
            'desc' => 'Os antagonistas que buscam ordem através do controle',
            'icon' => 'bi-shield-fill',
            'personagens' => [
                ['nome' => 'Haytham Kenway', 'era' => 'Revolução Americana (1754)', 
                 'jogo' => 'AC III, Rogue', 'game_id' => 1266, 'ano' => 1754,
                 'desc' => 'Grão-Mestre Templário da Colônia Americana e pai de Connor. Filho de Edward Kenway, foi criado como Templário após a morte de seu pai.',
                 'akas' => ['Grão-Mestre Colonial'],
                 'tipo' => 'Grão-Mestre', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Rodrigo Borgia', 'era' => 'Renascimento (1492)', 
                 'jogo' => 'AC II', 'game_id' => 127, 'ano' => 1492,
                 'desc' => 'Papa Alexandre VI e Grão-Mestre dos Templários Italianos. Principal antagonista de Ezio, buscou os Pedaços do Éden para conquistar poder absoluto.',
                 'akas' => ['Papa Alexandre VI', 'O Espanhol'],
                 'tipo' => 'Grão-Mestre', 'nacionalidade' => 'Espanhol'],
                 
                ['nome' => 'Cesare Borgia', 'era' => 'Renascimento (1500)', 
                 'jogo' => 'AC Brotherhood', 'game_id' => 113, 'ano' => 1500,
                 'desc' => 'Filho de Rodrigo Borgia e comandante dos exércitos papais. Conquistou Roma e grande parte da Itália até ser derrotado por Ezio.',
                 'akas' => ['O Príncipe'],
                 'tipo' => 'Comandante Templário', 'nacionalidade' => 'Italiano'],
                 
                ['nome' => 'Al Mualim', 'era' => 'Terceira Cruzada (1191)', 
                 'jogo' => 'Assassin\'s Creed', 'game_id' => 128, 'ano' => 1191,
                 'desc' => 'Mentor de Altaïr que secretamente buscava usar a Maçã do Éden para controlar a humanidade. Foi morto por Altaïr após sua traição ser revelada.',
                 'akas' => ['O Velho da Montanha'],
                 'tipo' => 'Mentor Traidor', 'nacionalidade' => 'Sírio'],
                 
                ['nome' => 'Crawford Starrick', 'era' => 'Era Vitoriana (1868)', 
                 'jogo' => 'AC Syndicate', 'game_id' => 8263, 'ano' => 1868,
                 'desc' => 'Grão-Mestre que controlava Londres através de negócios e política. Sua queda veio pelas mãos dos gêmeos Frye.',
                 'akas' => ['O Magnata'],
                 'tipo' => 'Grão-Mestre', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Charles Lee', 'era' => 'Revolução Americana (1754)', 
                 'jogo' => 'AC III', 'game_id' => 1266, 'ano' => 1754,
                 'desc' => 'Braço direito de Haytham Kenway e principal antagonista de Connor. Responsável pelo ataque à vila de Connor quando era criança.',
                 'akas' => ['O Perseguidor'],
                 'tipo' => 'Templário', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Laureano de Torres y Ayala', 'era' => 'Era da Pirataria (1715)', 
                 'jogo' => 'AC IV: Black Flag', 'game_id' => 1970, 'ano' => 1715,
                 'desc' => 'Governador espanhol de Cuba e Grão-Mestre dos Templários do Caribe. Buscava o Observatório para controlar o mundo.',
                 'akas' => ['O Governador'],
                 'tipo' => 'Grão-Mestre', 'nacionalidade' => 'Espanhol'],
                 
                ['nome' => 'François-Thomas Germain', 'era' => 'Revolução Francesa (1789)', 
                 'jogo' => 'AC Unity', 'game_id' => 5606, 'ano' => 1789,
                 'desc' => 'Grão-Mestre dissidente que usou a Revolução Francesa para destruir a velha Ordem Templária e reconstruí-la sob seus ideais.',
                 'akas' => ['O Artesão'],
                 'tipo' => 'Grão-Mestre', 'nacionalidade' => 'Francês'],
                 
                ['nome' => 'Flavius Metellus', 'era' => 'Egito Ptolemaico (48 a.C.)', 
                 'jogo' => 'AC Origins', 'game_id' => 28540, 'ano' => -48,
                 'desc' => 'Leão da Ordem dos Antigos e verdadeiro assassino de Khemu, filho de Bayek. Portador da Maçã do Éden.',
                 'akas' => ['O Leão'],
                 'tipo' => 'Líder da Ordem', 'nacionalidade' => 'Romano'],
                 
                ['nome' => 'Élise de la Serre', 'era' => 'Revolução Francesa (1789)', 
                 'jogo' => 'AC Unity', 'game_id' => 5606, 'ano' => 1789,
                 'desc' => 'Templária francesa e amor de Arno. Filha do Grão-Mestre François de la Serre, buscava vingança pela morte de seu pai.',
                 'akas' => ['A Templária'],
                 'tipo' => 'Templária', 'nacionalidade' => 'Francesa'],
            ]
        ],
        
        'historicos' => [
            'titulo' => 'Personagens Históricos',
            'desc' => 'Figuras reais da história que cruzaram caminhos com os Assassinos',
            'icon' => 'bi-book',
            'personagens' => [
                ['nome' => 'Leonardo da Vinci', 'era' => 'Renascimento (1476)', 
                 'jogo' => 'AC II, Brotherhood', 'game_id' => 127, 'ano' => 1476,
                 'desc' => 'Gênio renascentista e grande amigo de Ezio. Decifrou as páginas do Codex de Altaïr e criou gadgets e armas para os Assassinos.',
                 'akas' => ['O Gênio'],
                 'tipo' => 'Aliado', 'nacionalidade' => 'Italiano'],
                 
                ['nome' => 'Cleópatra VII', 'era' => 'Egito Ptolemaico (48 a.C.)', 
                 'jogo' => 'AC Origins', 'game_id' => 28540, 'ano' => -48,
                 'desc' => 'Última faraó do Egito. Inicialmente aliada de Bayek e Aya, revelou-se membro da Ordem dos Antigos (Templários).',
                 'akas' => ['A Última Faraó'],
                 'tipo' => 'Aliada/Inimiga', 'nacionalidade' => 'Egípcia'],
                 
                ['nome' => 'Júlio César', 'era' => 'Roma Antiga (47 a.C.)', 
                 'jogo' => 'AC Origins', 'game_id' => 28540, 'ano' => -47,
                 'desc' => 'Ditador romano e membro da Ordem dos Antigos. Foi assassinado por Aya/Amunet nos Idos de Março.',
                 'akas' => ['O Ditador'],
                 'tipo' => 'Inimigo', 'nacionalidade' => 'Romano'],
                 
                ['nome' => 'Sócrates', 'era' => 'Grécia Antiga (431 a.C.)', 
                 'jogo' => 'AC Odyssey', 'game_id' => 103054, 'ano' => -431,
                 'desc' => 'Filósofo grego que frequentemente ajudava Kassandra/Alexios com seus questionamentos éticos e debates filosóficos.',
                 'akas' => ['O Filósofo'],
                 'tipo' => 'Aliado', 'nacionalidade' => 'Grego'],
                 
                ['nome' => 'Barba Negra', 'era' => 'Era da Pirataria (1715)', 
                 'jogo' => 'AC IV: Black Flag', 'game_id' => 1970, 'ano' => 1715,
                 'desc' => 'Edward Thatch, o pirata mais temido do Caribe e amigo de Edward Kenway. Morreu lutando contra a Marinha Britânica.',
                 'akas' => ['Edward Thatch'],
                 'tipo' => 'Aliado', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Benjamin Franklin', 'era' => 'Revolução Americana (1754)', 
                 'jogo' => 'AC III, Rogue', 'game_id' => 1266, 'ano' => 1754,
                 'desc' => 'Inventor e Pai Fundador americano que auxiliou Connor durante a Revolução Americana.',
                 'akas' => ['O Inventor'],
                 'tipo' => 'Aliado', 'nacionalidade' => 'Americano'],
                 
                ['nome' => 'Napoleão Bonaparte', 'era' => 'Revolução Francesa (1789)', 
                 'jogo' => 'AC Unity', 'game_id' => 5606, 'ano' => 1789,
                 'desc' => 'Jovem oficial que cruzou caminhos com Arno durante a Revolução Francesa, antes de se tornar Imperador.',
                 'akas' => ['O Pequeno Cabo'],
                 'tipo' => 'Neutro', 'nacionalidade' => 'Francês'],
            ]
        ],
        
        'modernos' => [
            'titulo' => 'Mundo Moderno',
            'desc' => 'Os protagonistas contemporâneos que revivem as memórias dos Assassinos',
            'icon' => 'bi-cpu',
            'personagens' => [
                ['nome' => 'Desmond Miles', 'era' => 'Era Moderna (2012)', 
                 'jogo' => 'AC I-III', 'game_id' => 128, 'ano' => 2012,
                 'desc' => 'Descendente de vários Assassinos lendários. Através do Animus, reviveu as memórias de Altaïr, Ezio e Connor. Sacrificou sua vida para salvar o mundo.',
                 'akas' => ['Sujeito 17'],
                 'tipo' => 'Protagonista Moderno', 'nacionalidade' => 'Americano'],
                 
                ['nome' => 'Layla Hassan', 'era' => 'Era Moderna (2017-2020)', 
                 'jogo' => 'AC Origins, Odyssey, Valhalla', 'game_id' => 28540, 'ano' => 2017,
                 'desc' => 'Ex-funcionária da Abstergo que desenvolveu seu próprio Animus portátil. Tornou-se a nova Guardiã após eventos em Valhalla.',
                 'akas' => ['A Engenheira'],
                 'tipo' => 'Protagonista Moderna', 'nacionalidade' => 'Americana/Egípcia'],
                 
                ['nome' => 'Shaun Hastings', 'era' => 'Era Moderna (2012-presente)', 
                 'jogo' => 'AC II-Valhalla', 'game_id' => 127, 'ano' => 2012,
                 'desc' => 'Historiador britânico e membro da célula de Assassinos. Fornece informações históricas e suporte técnico.',
                 'akas' => ['O Historiador Sarcástico'],
                 'tipo' => 'Suporte', 'nacionalidade' => 'Inglês'],
                 
                ['nome' => 'Rebecca Crane', 'era' => 'Era Moderna (2012-presente)', 
                 'jogo' => 'AC II-Valhalla', 'game_id' => 127, 'ano' => 2012,
                 'desc' => 'Especialista em tecnologia que criou o Animus 2.0. Trabalha ao lado de Shaun dando suporte aos protagonistas.',
                 'akas' => ['A Técnica'],
                 'tipo' => 'Suporte', 'nacionalidade' => 'Americana'],
                 
                ['nome' => 'William Miles', 'era' => 'Era Moderna (2012-presente)', 
                 'jogo' => 'AC III-Valhalla', 'game_id' => 1266, 'ano' => 2012,
                 'desc' => 'Pai de Desmond e líder da Irmandade dos Assassinos moderna. Coordena operações globais contra a Abstergo.',
                 'akas' => ['O Mentor Moderno'],
                 'tipo' => 'Mentor', 'nacionalidade' => 'Americano'],
            ]
        ],
    ];
    
    // Buscar personagens adicionais da API IGDB
    $allGameIds = [
        // Principal
        128, 127, 113, 537, 1266, 1970, 7570, 5606, 8263, 28540, 103054, 133004, 215060, 300976,
        // Spin-offs
        68526, 21349, 68527, 10661, 18865, 68528, 68529, 77209, 77265, 3195, 68530, 20077, 3775, 64759, 8223, 14902, 14903, 251353, 41030, 251568, 135506, 133962, 152231, 26917, 64765,
        // Remastered, Coleções, etc
        20864, 81205, 109532, 109533, 22754, 43015, 22815, 23954, 122236, 64737, 61278, 17028, 216319, 216321
    ];
    $idsString = implode(',', $allGameIds);
    
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
        CURLOPT_POSTFIELDS => "fields name, description, mug_shot.url, games.name, games.id; where games = ($idsString); sort name asc; limit 500;"
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    $apiCharacters = json_decode($response, true);
    
    // Nomes dos personagens manuais para evitar duplicatas
    $manualNames = [];
    foreach ($categorias as $cat) {
        foreach ($cat['personagens'] as $p) {
            $manualNames[] = strtolower($p['nome']);
        }
    }
    
    // Filtrar personagens da API (remover duplicatas)
    $filteredApiChars = [];
    if (is_array($apiCharacters) && !isset($apiCharacters['message'])) {
        foreach ($apiCharacters as $char) {
            $nameLower = strtolower($char['name'] ?? '');
            // Verificar se não é duplicata e tem nome válido
            $isDuplicate = false;
            foreach ($manualNames as $manualName) {
                if (strpos($manualName, $nameLower) !== false || strpos($nameLower, $manualName) !== false) {
                    $isDuplicate = true;
                    break;
                }
            }
            if (!$isDuplicate && !empty($char['name'])) {
                $filteredApiChars[] = $char;
            }
        }
    }
    
    // Coletar todos os jogos únicos para o filtro
    $jogosUnicos = [];
    foreach ($categorias as $cat) {
        foreach ($cat['personagens'] as $p) {
            if (!isset($jogosUnicos[$p['game_id']])) {
                $jogosUnicos[$p['game_id']] = $p['jogo'];
            }
        }
    }
    // Adicionar jogos dos personagens da API
    foreach ($filteredApiChars as $char) {
        if (isset($char['games']) && !empty($char['games'])) {
            foreach ($char['games'] as $game) {
                if (!isset($jogosUnicos[$game['id']])) {
                    $jogosUnicos[$game['id']] = $game['name'];
                }
            }
        }
    }
    asort($jogosUnicos);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagens - AC Database</title>
    <meta name="description" content="Conheça todos os personagens da franquia Assassin's Creed: Assassinos, Templários, figuras históricas e protagonistas modernos.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        /* Busca e Filtros */
        .search-filters-container {
            background: var(--title-bg);
            padding: 1.5em;
            margin-bottom: 2em;
            border-left: 4px solid var(--accent-red);
        }
        .search-box {
            display: flex;
            gap: 0.5em;
            margin-bottom: 1em;
        }
        .search-input {
            flex: 1;
            padding: 0.75em 1em;
            border: none;
            background: rgba(255,255,255,0.9);
            font-size: 1rem;
            color: #333;
        }
        .search-input:focus {
            outline: 2px solid var(--accent-red);
        }
        .search-btn {
            padding: 0.75em 1.5em;
            background: var(--accent-red);
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.25em;
        }
        .filter-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
        }
        .filter-select {
            padding: 0.5em 1em;
            border: none;
            background: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            min-width: 180px;
            cursor: pointer;
        }
        .clear-filters-btn {
            padding: 0.5em 1em;
            background: transparent;
            border: 1px solid #666;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
        }
        .clear-filters-btn:hover {
            background: #666;
            color: #fff;
        }
        .results-info {
            margin-top: 0.75em;
            font-size: 0.85rem;
            color: #666;
        }
        .results-info strong {
            color: var(--accent-red);
        }
        
        /* Seções */
        .character-section {
            margin-bottom: 2.5em;
        }
        .character-section.hidden {
            display: none;
        }
        .section-header {
            background: var(--title-bg);
            padding: 1em 1.25em;
            margin-bottom: 1em;
            border-left: 4px solid var(--accent-red);
            display: flex;
            align-items: center;
            gap: 0.75em;
        }
        .section-header i {
            font-size: 1.5rem;
            color: var(--accent-red);
        }
        .section-header h2 {
            color: #fff;
            font-size: 1.1rem;
            text-transform: uppercase;
            margin: 0;
            flex: 1;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .section-header .count {
            background: var(--accent-red);
            color: #fff;
            padding: 0.25em 0.6em;
            font-size: 0.75rem;
        }
        .section-desc {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.85);
            margin-top: 0.25em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        /* Cards de Personagem */
        .character-card {
            background: var(--item-bg);
            display: flex;
            gap: 1.5em;
            padding: 1.5em;
            margin-bottom: 1em;
            transition: all 0.4s;
            position: relative;
        }
        .character-card:hover {
            background: var(--active-bg);
            transform: translateX(10px);
            box-shadow: -5px 0 15px rgba(112, 0, 0, 0.2);
        }
        .character-card.hidden {
            display: none;
        }
        .character-avatar {
            width: 120px;
            height: 150px;
            background: linear-gradient(135deg, #555, #333);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        .character-avatar i {
            font-size: 3.5rem;
            color: rgba(255,255,255,0.2);
        }
        .character-avatar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.1) 50%, transparent 60%);
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .character-info {
            flex: 1;
        }
        .character-name {
            font-size: 1.25rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #222;
            margin-bottom: 0.25em;
        }
        .character-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            margin-bottom: 0.5em;
            font-size: 0.8rem;
        }
        .character-meta span {
            display: flex;
            align-items: center;
            gap: 0.3em;
            color: #666;
        }
        .character-meta i {
            color: var(--accent-red);
        }
        .character-type {
            background: var(--accent-red);
            color: #fff;
            padding: 0.2em 0.5em;
            font-size: 0.7rem;
            text-transform: uppercase;
            margin-left: 0.5em;
        }
        .character-desc {
            font-size: 0.9rem;
            color: #444;
            line-height: 1.6;
            margin-bottom: 0.75em;
        }
        .character-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75em;
            margin-top: 0.75em;
        }
        .aka-tag {
            background: rgba(0,0,0,0.1);
            padding: 0.2em 0.6em;
            font-size: 0.7rem;
            text-transform: uppercase;
            border-left: 2px solid var(--accent-red);
        }
        .game-link {
            margin-left: auto;
            background: var(--accent-red);
            color: #fff;
            padding: 0.4em 0.8em;
            text-decoration: none;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.3em;
            transition: background 0.3s;
        }
        .game-link:hover {
            background: #8a0000;
        }
        
        /* Timeline indicator */
        .timeline-year {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 0.25em 0.75em;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* No results */
        .no-results {
            text-align: center;
            padding: 3em;
            color: #666;
        }
        .no-results i {
            font-size: 4rem;
            display: block;
            margin-bottom: 0.5em;
            opacity: 0.3;
        }
        
        @media (max-width: 768px) {
            .character-card {
                flex-direction: column;
                text-align: center;
            }
            .character-avatar {
                margin: 0 auto;
            }
            .character-footer {
                justify-content: center;
            }
            .game-link {
                margin-left: 0;
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
                <li><a href="livros.php" class="item">Livros & Mídia</a></li>
            </ul>
            
            <!-- Sub-navegação de categorias -->
            <div class="title" style="margin-top: 2em; font-size: 100%;">Categorias</div>
            <ul class="items">
                <?php foreach ($categorias as $key => $cat): ?>
                <li><a href="#<?= $key ?>" class="item"><i class="bi <?= $cat['icon'] ?>"></i> <?= $cat['titulo'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Personagens</div>
            
            <div class="description">
                <p>Explore os <strong>heróis e vilões</strong> que moldaram a história através dos séculos. Dos Assassinos lendários aos Templários ambiciosos, das figuras históricas aos protagonistas modernos.</p>
            </div>

            <!-- Busca e Filtros -->
            <div class="search-filters-container">
                <div class="search-box">
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar personagem por nome..." autocomplete="off">
                    <button class="search-btn" onclick="applyFilters()"><i class="bi bi-search"></i> Buscar</button>
                </div>
                
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="bi bi-funnel"></i> Categoria</label>
                        <select id="categoryFilter" class="filter-select" onchange="applyFilters()">
                            <option value="">Todas as Categorias</option>
                            <?php foreach ($categorias as $key => $cat): ?>
                            <option value="<?= $key ?>"><?= htmlspecialchars($cat['titulo']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="bi bi-controller"></i> Jogo</label>
                        <select id="gameFilter" class="filter-select" onchange="applyFilters()">
                            <option value="">Todos os Jogos</option>
                            <?php foreach ($jogosUnicos as $id => $nome): ?>
                            <option value="<?= $id ?>"><?= htmlspecialchars($nome) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label><i class="bi bi-clock-history"></i> Ordenar</label>
                        <select id="sortFilter" class="filter-select" onchange="applyFilters()">
                            <option value="default">Por Categoria</option>
                            <option value="name">Por Nome (A-Z)</option>
                            <option value="chronological">Cronológico (Histórico)</option>
                        </select>
                    </div>
                    
                    <button class="clear-filters-btn" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i> Limpar
                    </button>
                </div>
                
                <div class="results-info" id="resultsInfo"></div>
            </div>

            <div id="noResults" class="no-results" style="display: none;">
                <i class="bi bi-person-x"></i>
                <h3>Nenhum personagem encontrado</h3>
                <p>Tente ajustar seus filtros ou termo de busca.</p>
            </div>

            <!-- Seções de Personagens -->
            <?php foreach ($categorias as $key => $categoria): ?>
            <section class="character-section" id="<?= $key ?>" data-category="<?= $key ?>">
                <div class="section-header">
                    <i class="bi <?= $categoria['icon'] ?>"></i>
                    <div>
                        <h2><?= htmlspecialchars($categoria['titulo']) ?></h2>
                        <div class="section-desc"><?= htmlspecialchars($categoria['desc']) ?></div>
                    </div>
                    <span class="count"><?= count($categoria['personagens']) ?></span>
                </div>
                
                <?php foreach ($categoria['personagens'] as $p): ?>
                <div class="character-card" 
                     data-name="<?= htmlspecialchars(strtolower($p['nome'])) ?>"
                     data-game-id="<?= $p['game_id'] ?>"
                     data-year="<?= $p['ano'] ?>"
                     data-category="<?= $key ?>">
                    <div class="timeline-year"><?= $p['ano'] < 0 ? abs($p['ano']) . ' a.C.' : $p['ano'] ?></div>
                    <div class="character-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="character-info">
                        <div class="character-name">
                            <?= htmlspecialchars($p['nome']) ?>
                            <span class="character-type"><?= htmlspecialchars($p['tipo']) ?></span>
                        </div>
                        <div class="character-meta">
                            <span><i class="bi bi-calendar3"></i> <?= htmlspecialchars($p['era']) ?></span>
                            <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($p['nacionalidade']) ?></span>
                        </div>
                        <div class="character-desc"><?= htmlspecialchars($p['desc']) ?></div>
                        <div class="character-footer">
                            <?php if (isset($p['akas']) && !empty($p['akas'])): ?>
                                <?php foreach ($p['akas'] as $aka): ?>
                                <span class="aka-tag"><?= htmlspecialchars($aka) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <a href="game_details.php?game_id=<?= $p['game_id'] ?>" class="game-link">
                                <i class="bi bi-controller"></i> <?= htmlspecialchars($p['jogo']) ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endforeach; ?>
            
            <!-- Personagens da API IGDB -->
            <?php if (!empty($filteredApiChars)): ?>
            <section class="character-section" id="api_personagens" data-category="api_personagens">
                <div class="section-header">
                    <i class="bi bi-cloud-download"></i>
                    <div>
                        <h2>Outros Personagens (via IGDB)</h2>
                        <div class="section-desc">Personagens adicionais encontrados na base de dados IGDB</div>
                    </div>
                    <span class="count"><?= count($filteredApiChars) ?></span>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1em;">
                    <?php foreach ($filteredApiChars as $char): 
                        $gameName = isset($char['games'][0]['name']) ? $char['games'][0]['name'] : 'AC';
                        $gameId = isset($char['games'][0]['id']) ? $char['games'][0]['id'] : 0;
                    ?>
                    <div class="character-card" 
                         data-name="<?= htmlspecialchars(strtolower($char['name'])) ?>"
                         data-game-id="<?= $gameId ?>"
                         data-year="0"
                         data-category="api_personagens"
                         style="flex-direction: column; padding: 1em;">
                        <div style="display: flex; gap: 1em; align-items: center;">
                            <?php if (isset($char['mug_shot']['url'])): ?>
                            <img src="https:<?= str_replace('t_thumb', 't_micro', $char['mug_shot']['url']) ?>" 
                                 alt="<?= htmlspecialchars($char['name']) ?>"
                                 style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #555, #333); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill" style="font-size: 1.5rem; color: rgba(255,255,255,0.3);"></i>
                            </div>
                            <?php endif; ?>
                            <div style="flex: 1;">
                                <div class="character-name" style="font-size: 1rem;"><?= htmlspecialchars($char['name']) ?></div>
                                <div style="font-size: 0.75rem; color: #888;">
                                    <i class="bi bi-controller"></i> <?= htmlspecialchars($gameName) ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($char['description'])): ?>
                        <div class="character-desc" style="font-size: 0.8rem; margin-top: 0.75em; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars(substr($char['description'], 0, 200)) ?><?= strlen($char['description']) > 200 ? '...' : '' ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const gameFilter = document.getElementById('gameFilter');
        const sortFilter = document.getElementById('sortFilter');
        const resultsInfo = document.getElementById('resultsInfo');
        const noResults = document.getElementById('noResults');
        
        searchInput.addEventListener('input', debounce(applyFilters, 300));
        searchInput.addEventListener('keypress', e => { if (e.key === 'Enter') applyFilters(); });
        
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
        
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedCategory = categoryFilter.value;
            const selectedGame = gameFilter.value;
            const sortBy = sortFilter.value;
            
            const allCards = document.querySelectorAll('.character-card');
            let visibleCards = [];
            let sectionVisibility = {};
            
            allCards.forEach(card => {
                const name = card.dataset.name || '';
                const gameId = card.dataset.gameId || '';
                const category = card.dataset.category || '';
                
                const matchesSearch = !searchTerm || name.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;
                const matchesGame = !selectedGame || gameId === selectedGame;
                
                const isVisible = matchesSearch && matchesCategory && matchesGame;
                card.classList.toggle('hidden', !isVisible);
                
                if (isVisible) {
                    visibleCards.push(card);
                    sectionVisibility[category] = (sectionVisibility[category] || 0) + 1;
                }
            });
            
            // Atualizar visibilidade das seções
            document.querySelectorAll('.character-section').forEach(section => {
                const catId = section.dataset.category;
                const visible = sectionVisibility[catId] || 0;
                section.classList.toggle('hidden', visible === 0);
            });
            
            // Ordenação (se não for por categoria)
            if (sortBy === 'name' || sortBy === 'chronological') {
                visibleCards.sort((a, b) => {
                    if (sortBy === 'name') {
                        return a.dataset.name.localeCompare(b.dataset.name);
                    } else {
                        return parseInt(a.dataset.year) - parseInt(b.dataset.year);
                    }
                });
                
                // Mover cards ordenados para o container
                const container = document.querySelector('#content');
                visibleCards.forEach(card => {
                    card.parentElement.appendChild(card);
                });
            }
            
            // Mostrar/esconder mensagem de sem resultados
            noResults.style.display = visibleCards.length === 0 ? 'block' : 'none';
            
            // Atualizar info de resultados
            const total = allCards.length;
            if (searchTerm || selectedCategory || selectedGame) {
                resultsInfo.innerHTML = `<strong>${visibleCards.length}</strong> de ${total} personagens encontrados`;
            } else {
                resultsInfo.innerHTML = '';
            }
        }
        
        function clearFilters() {
            searchInput.value = '';
            categoryFilter.value = '';
            gameFilter.value = '';
            sortFilter.value = 'default';
            applyFilters();
        }
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
