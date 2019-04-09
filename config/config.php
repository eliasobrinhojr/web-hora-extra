<?php

try {
    $pdo = new PDO('mysql:host=srvmaodb;dbname=dbhoraextra', 'user_horaextra', 'horaextra');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
	