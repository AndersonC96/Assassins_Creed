<?php
    $accessToken = 'j11t1w7bvlfvv98265bcldopqt33v3';
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
        CURLOPT_POSTFIELDS => "fields name, franchises; where name = \"Assassin's Creed Odyssey\"; limit 1;"
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if($err){
        echo "cURL Error #:" . $err;
    }else{
        $games = json_decode($response, true);
        if(!empty($games)){
            echo "<pre>"; print_r($games); echo "</pre>";
        }else{
            echo "No results found or bad query.";
        }
    }
?>