<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assassin's Creed - Portal</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body{
                background-color: #211714; /* Cor de fundo escura */
                color: #fc9b70; /* Cor de texto coral */
                font-family: 'Cinzel', serif; /* Aplicação da fonte Cinzel para todo o texto */
            }
            .nav-link{
                background-color: #fc9b70; /* Cor de fundo dos links coral */
                color: #211714; /* Cor de texto dos links escura */
                padding: 10px 15px;
                margin: 5px;
                border-radius: 5px;
                text-decoration: none;
                transition: background-color 0.3s, color 0.3s;
            }
            .nav-link:hover{
                background-color: #211714; /* Hover do fundo dos links escura */
                color: #fc9b70; /* Hover do texto dos links coral */
            }
            .header{
                background: linear-gradient(90deg, #211714 0%, #fc9b70 100%); /* Gradiente do cabeçalho */
                padding: 20px;
                text-align: center;
                border-bottom: 3px solid #fc9b70; /* Borda do cabeçalho coral */
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
    </body>
</html>