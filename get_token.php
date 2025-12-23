<?php
    $client_id = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    $client_secret = '96jjy0evbequ6u4n34vhg6rvt5xe6k';
    $token_url = 'https://id.twitch.tv/oauth2/token';
    $data = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if(curl_errno($ch)){
        echo 'Erro no cURL: ' . curl_error($ch);
    }else{
        $decoded = json_decode($response, true);
        if(isset($decoded['access_token'])){
            echo "Token de Acesso: " . $decoded['access_token'];
        }else{
            echo "Não foi possível obter o token de acesso. Resposta: " . $response;
        }
    }
    curl_close($ch);
?>