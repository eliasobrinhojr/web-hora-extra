<?php

include_once("../../../config/config.php");


$entityBody = file_get_contents('php://input');
$obj = json_decode($entityBody);

$string = implode(',', $obj->ids);
$situacao = $obj->situacao;


$sql = "update tab_horaextra set ext_IdSituacao = $situacao where ext_idHoraExtra in (" . $string . ");";


$stmt = $pdo->prepare($sql);
if ($stmt->execute()) {
    //success
    $retorno['cod'] = 1;
    $retorno['msg'] = "Sucesso !";
} else {
    // error
    $retorno['cod'] = 0;
    $retorno['msg'] = "ERRO contate o suporte !";
}

echo json_encode($retorno);
