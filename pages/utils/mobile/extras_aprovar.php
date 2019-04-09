<?php

include_once("../../../config/config.php");

$id_login = $_GET['id_login'];
$id_empresa = $_GET['id_empresa'];
$id_setor = $_GET['id_setor'];
$situacao = 1;

$query = "select ext_idHoraExtra as id, 
                ext_NomeDoColaborador as nome_funcionario, 
		ext_DrtFuncionario as drt_funcionario, 
		ext_HoraInicial as hora_incial,
		ext_HoraFinal as hora_final,
		tab_empresas.emp_Descricao as nome_empresa,
		ext_CustoDaExtra as custo
FROM tab_horaextra
	join tab_setores on tab_setores.set_idSetor = tab_horaextra.ext_IdSetor
	join tab_situacao on tab_situacao.sit_idSituacao = tab_horaextra.ext_IdSituacao
	join tab_empresas on tab_empresas.emp_idEmpresa = tab_horaextra.ext_IdEmpresa
	WHERE tab_horaextra.ext_IdSituacao = 1 and tab_horaextra.ext_idSetor = $id_setor;";

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