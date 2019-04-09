<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once("../../../config/config.php");

$id =  isset($_GET['id']) ? $_GET['id'] : 0;

$query = "select setor.set_idSetor as id, 
	   setor.set_idEmpresa as id_empresa, 
	   setor.set_Setor as descricao 
from tab_horaextra ex
join tab_aprovadores ap on ex.ext_idAprovadores = ex.ext_idAprovadores
join tab_empresas emp on emp.emp_idEmpresa = ex.ext_IdEmpresa
join tab_setores setor on setor.set_idSetor = ex.ext_IdSetor
where ap.apr_idLogin = $id
and  ap.apr_idAprovadores in (select tab_horaextra.ext_idAprovadores from tab_horaextra) 
and ex.ext_IdSituacao = 1 
group by (id);";


$sql = $pdo->prepare($query);
$sql->execute();
$n = 0;
$msg = '';
if ($sql->rowCount() > 0) {
    $retorno['cod'] = 1;
    $msg = "sucesso";
} else {
    $retorno['cod'] = 0;
    $retorno['dados'] = [];
    $msg = "lista vazia";
}

while ($ln = $sql->fetchObject()) {
    $retorno['dados'][$n] = $ln;
    $n++;
}
$retorno['msg'] = $msg;

echo json_encode($retorno);
?>