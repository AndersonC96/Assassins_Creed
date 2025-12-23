<?php
// Debug: verificar tipos de website retornados pela API
require_once __DIR__ . '/app/Config/config.php';
require_once __DIR__ . '/app/Models/ApiClient.php';

$api = new \App\Models\ApiClient();
$game = $api->getGameById(300976); // AC Shadows

echo "<h2>Websites do jogo: " . ($game['name'] ?? 'N/A') . "</h2>";

if (isset($game['websites'])) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Type ID</th><th>URL</th><th>Label Atual</th><th>Icon Atual</th></tr>";
    
    foreach ($game['websites'] as $site) {
        $info = \App\Models\Game::getWebsiteInfo($site['type'] ?? 0);
        echo "<tr>";
        echo "<td><strong>" . ($site['type'] ?? 'N/A') . "</strong></td>";
        echo "<td>" . ($site['url'] ?? 'N/A') . "</td>";
        echo "<td>" . $info['label'] . "</td>";
        echo "<td>" . $info['icon'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum website encontrado.</p>";
}
