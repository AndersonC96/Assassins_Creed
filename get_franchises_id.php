<?php
    $accessToken = 'j11t1w7bvlfvv98265bcldopqt33v3';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    //$dlcIDs = [140174,140175,185706];
    $expansionsIDs = [140174,140175,185706];
    //$idsString = implode(',', $dlcIDs);
    $idsString = implode(',', $expansionsIDs);
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
        // Inclua todos os subcampos de 'cover' que você deseja obter
        //CURLOPT_POSTFIELDS => "fields name, franchises, collections, first_release_date, created_at, cover.url, cover.width, cover.height, cover.image_id, cover.game, cover.animated, alternative_names.name, artworks.url, game_engines, aggregated_rating, expanded_games, aggregated_rating_count, artworks, bundles, dlcs, expansions; where name = \"Assassin's Creed Valhalla\"; limit 1;"
        CURLOPT_POSTFIELDS => "fields name, release_dates.date, summary, cover.url; where id = ($idsString);"
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
