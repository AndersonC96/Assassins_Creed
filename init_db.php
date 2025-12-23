<?php
/**
 * Script de inicialização do banco de dados Assassin's Creed
 * Execute este arquivo uma vez para criar o banco de dados e tabelas
 */

// Conexão sem especificar o banco de dados
$db = new mysqli('localhost', 'root', '');

if ($db->connect_error) {
    die("Falha na conexão: " . $db->connect_error);
}

// Criar o banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS assassins_creed 
        CHARACTER SET utf8mb4 
        COLLATE utf8mb4_unicode_ci";

if ($db->query($sql) === TRUE) {
    echo "✅ Banco de dados 'assassins_creed' criado com sucesso!<br>";
} else {
    die("❌ Erro ao criar banco de dados: " . $db->error);
}

// Selecionar o banco de dados
$db->select_db('assassins_creed');

// Criar tabela de vídeos
$sql = "CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL COMMENT 'Título do vídeo',
    url VARCHAR(500) NOT NULL COMMENT 'Caminho do arquivo de vídeo',
    descricao TEXT NULL COMMENT 'Descrição do vídeo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($db->query($sql) === TRUE) {
    echo "✅ Tabela 'videos' criada com sucesso!<br>";
} else {
    die("❌ Erro ao criar tabela videos: " . $db->error);
}

// Inserir vídeos de exemplo (trailers dos jogos)
$videos = [
    ['Assassin\'s Creed', './Videos/AC.mp4', 'Trailer do primeiro Assassin\'s Creed'],
    ['Assassin\'s Creed II', './Videos/AC_II.mp4', 'Trailer de Assassin\'s Creed II'],
    ['Assassin\'s Creed: Brotherhood', './Videos/AC_BH.mp4', 'Trailer de Assassin\'s Creed Brotherhood'],
    ['Assassin\'s Creed: Revelations', './Videos/AC_R.mp4', 'Trailer de Assassin\'s Creed Revelations'],
    ['Assassin\'s Creed III', './Videos/AC_III.mp4', 'Trailer de Assassin\'s Creed III'],
    ['Assassin\'s Creed IV: Black Flag', './Videos/AC_IV.mp4', 'Trailer de Assassin\'s Creed IV: Black Flag'],
    ['Assassin\'s Creed Rogue', './Videos/AC_Rogue.mp4', 'Trailer de Assassin\'s Creed Rogue'],
    ['Assassin\'s Creed Unity', './Videos/AC_U.mp4', 'Trailer de Assassin\'s Creed Unity'],
    ['Assassin\'s Creed Syndicate', './Videos/AC_S.mp4', 'Trailer de Assassin\'s Creed Syndicate'],
    ['Assassin\'s Creed Origins', './Videos/AC_O.mp4', 'Trailer de Assassin\'s Creed Origins'],
    ['Assassin\'s Creed Odyssey', './Videos/AC_Odyssey.mp4', 'Trailer de Assassin\'s Creed Odyssey'],
    ['Assassin\'s Creed Valhalla', './Videos/AC_V.mp4', 'Trailer de Assassin\'s Creed Valhalla'],
    ['Assassin\'s Creed Mirage', './Videos/AC_M.mp4', 'Trailer de Assassin\'s Creed Mirage']
];

// Verificar se já existem dados
$result = $db->query("SELECT COUNT(*) as count FROM videos");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $stmt = $db->prepare("INSERT INTO videos (titulo, url, descricao) VALUES (?, ?, ?)");
    
    foreach ($videos as $video) {
        $stmt->bind_param("sss", $video[0], $video[1], $video[2]);
        $stmt->execute();
    }
    
    $stmt->close();
    echo "✅ " . count($videos) . " vídeos inseridos com sucesso!<br>";
} else {
    echo "ℹ️ A tabela videos já contém dados. Nenhum dado inserido.<br>";
}

$db->close();

echo "<br><strong>🎮 Banco de dados inicializado com sucesso!</strong><br>";
echo "<a href='index.php'>Ir para o Portal Assassin's Creed</a>";
?>
