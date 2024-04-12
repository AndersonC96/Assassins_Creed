<?php
// As credenciais do cliente obtidas após registrar sua aplicação no Twitch
$client_id = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
$client_secret = 'y228ys2g967elwh834wfxo491lzjp7';

// URL para solicitar o token
$token_url = 'https://id.twitch.tv/oauth2/token';

// Parâmetros da solicitação
$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'client_credentials'
);

// Configuração do cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Codifica os parâmetros para a solicitação POST
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executar o cURL
$response = curl_exec($ch);

// Verifica se ocorreu algum erro durante a execução do cURL
if (curl_errno($ch)) {
    echo 'Erro no cURL: ' . curl_error($ch);
} else {
    // Tenta decodificar a resposta JSON
    $decoded = json_decode($response, true);

    if (isset($decoded['access_token'])) {
        echo "Token de Acesso: " . $decoded['access_token'];
    } else {
        echo "Não foi possível obter o token de acesso. Resposta: " . $response;
    }
}

// Fecha a sessão cURL
curl_close($ch);
?>
