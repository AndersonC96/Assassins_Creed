<?php
$db = new mysqli('localhost', 'root', '', 'assassins_creed');
if ($db->connect_error) {
    die("Falha na conexão: " . $db->connect_error);
}
$query = "SELECT * FROM videos ORDER BY RAND() LIMIT 1"; // Seleciona um vídeo aleatório
$result = $db->query($query);
$video = $result->fetch_assoc();
$db->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assassin's Creed - Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #211714;
            color: #fc9b70;
            font-family: 'Cinzel', serif;
        }
        .nav-link, .video-control {
            background-color: #fc9b70;
            color: #211714;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-link:hover, .video-control:hover {
            background-color: #211714;
            color: #fc9b70;
        }
        .header, .video-container {
            background: linear-gradient(90deg, #211714 0%, #fc9b70 100%);
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #fc9b70;
        }
        .video-container {
            width: 80%;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }
        video {
            width: 100%;
            border-radius: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Bem-vindo ao Portal Assassin's Creed</h1>
        <p>Explore a saga através de diferentes mídias</p>
    </header>
    <nav class="flex justify-center mt-4">
        <a href="jogos.php" class="nav-link">Jogos</a>
        <a href="livros.php" class="nav-link">Livros</a>
        <a href="hqs.php" class="nav-link">HQs</a>
        <a href="personagens.php" class="nav-link">Personagens Principais</a>
        <a href="historicos.php" class="nav-link">Personagens Históricos</a>
        <a href="locais.php" class="nav-link">Locais</a>
        <a href="noticias.php" class="nav-link">Notícias</a>
        <a href="database.php" class="nav-link">Banco de Dados</a>
    </nav>
    <div class="video-container">
        <button class="video-control" id="playPauseBtn" onclick="togglePlayPause();">Play</button>
        <span style="margin-left: 10px; color: #ffffff;"><?= $video['titulo'] ?></span>
        <video id="videoPlayer" controls>
            <source src="<?= htmlspecialchars($video['url']) ?>" type="video/mp4">Seu navegador não suporta vídeo.
        </video>
    </div>
    <script>
        var videoPlayer = document.getElementById('videoPlayer');
        var playPauseBtn = document.getElementById('playPauseBtn');

        function togglePlayPause() {
            if (videoPlayer.paused || videoPlayer.ended) {
                videoPlayer.play();
                playPauseBtn.textContent = 'Pausar';
            } else {
                videoPlayer.pause();
                playPauseBtn.textContent = 'Play';
            }
        }
    </script>
</body>
</html>
