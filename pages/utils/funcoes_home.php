<?php

if (!isset($_SESSION)) {
    session_start();
}
require("../../config/config.php");


$retorno = array();
$descricao = 'descricao';

if ($_GET['acao'] == 'empresas') {


    $id = $_SESSION['usuarioId'];

    $sql = $pdo->prepare("select emp_idEmpresa, emp_CodigoEmpresaFpw, emp_Descricao, emp_ConexaoBase, emp_DataDeCadastro, emp_Evento, emp_StatusDoRegistro from tab_acesso
			join tab_empresas on tab_empresas.emp_idEmpresa = tab_acesso.acs_idEmpresa
			where acs_idLogin = :id and acs_IdTIpoDeAcesso = 1");
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['empresas'][] = $ln;
    }
}


if ($_GET['acao'] == 'empresa_aprovar') {


    $idUser = $_SESSION['usuarioId'];

      $sql_str = "select emp_idEmpresa, 
	   emp_CodigoEmpresaFpw , 
	   emp_Descricao, 
	   emp_ConexaoBase 
                 from tab_horaextra ex
                    join tab_aprovadores ap on ex.ext_idAprovadores = ex.ext_idAprovadores
                    join tab_empresas emp on emp.emp_idEmpresa = ex.ext_IdEmpresa
                    join tab_setores setor on setor.set_idSetor = ex.ext_IdSetor
                    where ap.apr_idLogin = $idUser
                    and  ap.apr_idAprovadores in (select tab_horaextra.ext_idAprovadores from tab_horaextra) 
                    and ex.ext_IdSituacao = 1 
                    group by (emp_idEmpresa);";
    $sql = $pdo->prepare($sql_str);
    $sql->execute();
    $n = 0;

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['empresa'] = $ln;
        $n++;
    }
}

die(json_encode($retorno));
?>