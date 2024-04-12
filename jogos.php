<?php
    $accessToken = 'j11t1w7bvlfvv98265bcldopqt33v3';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    //$franchiseID = 571;
    $collections = 18;
    $specificGameIds = "68526,128,21349,68527,18865,10661,127,77265,537,77209,68529,113,68528,3195,1266,68530,1970,20077,8263,8223,5606,7570,17028,64759,3775,14902,14903,251353,28540,103054,111830,81205,41030,26917,109532,135506,133962,133004,215060,152231,251568,216319,216321,216320,64765,64737";
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.igdb.com/v4/games",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Client-ID: $clientID",
            "Authorization: Bearer $accessToken",
            "Accept: application/json"
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary; where id = ($specificGameIds) & collections = ($collections); sort first_release_date asc; limit 100;"
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $games = json_decode($response, true);
    if($err){
        echo "cURL Error #:" . $err;
    }elseif(empty($games) || isset($games['message'])){
        echo "Error or no games found. Response: " . htmlspecialchars(json_encode($games));
    }else{
        //echo "<pre>"; var_dump($games); echo "</pre>";  // Debug: Remove or comment out in production
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assassin's Creed - Jogos</title>
        <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./CSS/style.css">
    </head>
    <body>
        <header class="header">
            <h1>Jogos da Saga Assassin's Creed</h1>
            <p>Explore os títulos da franquia através de diferentes épocas e histórias.</p>
        </header>
        <nav class="flex justify-center mt-4">
            <a href="index.php" class="nav-link">Home</a>
            <a href="livros.php" class="nav-link">Livros</a>
            <a href="hqs.php" class="nav-link">HQs</a>
            <a href="personagens.php" class="nav-link">Personagens Principais</a>
            <a href="historicos.php" class="nav-link">Personagens Históricos</a>
            <a href="locais.php" class="nav-link">Locais</a>
            <a href="noticias.php" class="nav-link">Notícias</a>
            <a href="database.php" class="nav-link">Banco de Dados</a>
        </nav>
        <div class="game-list">
            <?php
                date_default_timezone_set('UTC');
                foreach ($games as $game):
            ?>
            <div class="game-card">
                <img src="<?= isset($game['cover']['url']) ? $game['cover']['url'] : 'path/to/default/cover.jpg'; ?>" alt="Game Cover">
                <h3><b><?= htmlspecialchars($game['name']) ?></b></h3>
                <p><?= isset($game['summary']) ? htmlspecialchars($game['summary']) : 'No summary available'; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>