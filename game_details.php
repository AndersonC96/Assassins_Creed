<?php
// Obtenha o ID do jogo a partir do URL
$gameId = $_GET['game_id'] ?? null;

if (!$gameId) {
    echo "Jogo não especificado!";
    exit;
}

$accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
$clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';

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
    CURLOPT_POSTFIELDS => "fields name, cover.url, summary, genres.name, platforms.name, release_dates.date, screenshots.url; where id = $gameId;"
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$gameDetails = json_decode($response, true);

if ($err) {
    echo "cURL Error #:" . $err;
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Jogo</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <header class="header">
        <h1>Detalhes do Jogo</h1>
        <p>Explore mais sobre o título selecionado.</p>
    </header>
    <nav class="flex justify-center mt-4">
            <a href="index.php" class="nav-link">Home</a>
            <a href="jogos.php" class="nav-link">Jogos</a>
            <a href="livros.php" class="nav-link">Livros</a>
            <a href="hqs.php" class="nav-link">HQs</a>
            <a href="personagens.php" class="nav-link">Personagens Principais</a>
            <a href="historicos.php" class="nav-link">Personagens Históricos</a>
            <a href="locais.php" class="nav-link">Locais</a>
            <a href="noticias.php" class="nav-link">Notícias</a>
            <a href="database.php" class="nav-link">Banco de Dados</a>
        </nav>
    <div class="game-details">
        <?php if (is_array($gameDetails) && !empty($gameDetails) && !isset($gameDetails['message'])): ?>
            <?php foreach ($gameDetails as $detail): ?>
                <div class="detail-card">
                    <img src="<?= isset($detail['cover']['url']) ? 'https:' . $detail['cover']['url'] : './IMG/default_cover.png'; ?>" alt="Cover Image">
                    <h3><?= htmlspecialchars($detail['name'] ?? 'Nome não disponível') ?></h3>
                    <hr>
                    <?php if (isset($detail['release_dates'][0]['date'])): ?>
                        <p>Data de lançamento: <?= date('d/m/Y', $detail['release_dates'][0]['date']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($detail['platforms'])): ?>
                        <p>Plataformas: <?= implode(', ', array_column($detail['platforms'], 'name')) ?></p>
                    <?php endif; ?>
                    <?php if (isset($detail['genres'])): ?>
                        <p>Gêneros: <?= implode(', ', array_column($detail['genres'], 'name')) ?></p>
                    <?php endif; ?>
                    <hr>
                    <p><?= htmlspecialchars($detail['summary'] ?? 'Descrição não disponível.') ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="detail-card" style="text-align: center;">
                <h3>⚠️ Detalhes não encontrados</h3>
                <p>Não foi possível carregar os detalhes deste jogo.</p>
                <a href="jogos.php" class="exibir-mais-btn" style="display: inline-block; margin-top: 20px;">Voltar para Jogos</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
