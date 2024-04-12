<?php
    $db = new mysqli('localhost', 'root', '', 'assassins_creed');
    if($db->connect_error){
        die("Falha na conexão: " . $db->connect_error);
    }
    $query = "SELECT * FROM videos ORDER BY RAND() LIMIT 1";
    $result = $db->query($query);
    $video = $result->fetch_assoc();
    $db->close();
?>