<?php

$conn = new mysqli("srvmaodb", "user_horaextra", "horaextra", "dbhoraextra");
$conn->query("SET NAMES 'utf-8'");
$conn->query("SET character_set_connction=utf-8");
$conn->query("SET character_set_client=utf-8");
$conn->query("SET character_set_results=utf-8");

if (!$conn) {
    die("Falha na conexao: " . mysqli_connect_error());
} else {
    //echo "Conexao realizada com sucesso";
}	