<?php

if (!isset($_SESSION)) {
    session_start();
}
require("../../config/config.php");


$retorno = array();
$descricao = 'descricao';



if ($_GET['acao'] == 'empresas') {

      $sql_str = "select emp_idEmpresa, 
	   emp_CodigoEmpresaFpw , 
	   emp_Descricao, 
	   emp_ConexaoBase 
                 from tab_empresas
                 where emp_idEmpresa in (select ext.ext_IdEmpresa from tab_horaextra ext where ext.ext_IdSituacao = 2 and ext.ext_DataHoraExtra = current_date);";
    $sql = $pdo->prepare($sql_str);
    $sql->execute();
    $n = 0;

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['empresa'] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'listagem') {


    $id_empresa = $_GET['empresa'];

    $sql = $pdo->prepare("SELECT *,  
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_extra_br,
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_emissao_br
	FROM tab_horaextra
	join tab_setores on tab_setores.set_idSetor = tab_horaextra.ext_IdSetor
	join tab_situacao on tab_situacao.sit_idSituacao = tab_horaextra.ext_IdSituacao
	join tab_empresas on tab_empresas.emp_idEmpresa = tab_horaextra.ext_IdEmpresa
	WHERE ext_idEmpresa = :id_empresa 
        and tab_horaextra.ext_IdSituacao = 2 
        and ext_DataHoraExtra = current_date 
        order by data_emissao_br desc;");

    //echo '<pre>';print_r($sql);exit;
    $sql->bindValue(":id_empresa", $id_empresa, PDO::PARAM_INT);
    $sql->execute();
    $n = 0;
    $retorno['recordsTotal'] = $sql->rowCount();
    $retorno['recordsFiltered'] = $retorno['recordsTotal'];

    $retorno['data'] = array();

    while ($ln = $sql->fetchObject()) {
        $retorno['data'][$n] = $ln;
        $n++;
    }
}


die(json_encode($retorno));
?>