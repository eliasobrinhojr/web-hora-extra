<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();
$descricao = 'descricao';

if ($_GET['acao'] == 'desc_dias') {
    $sql = $pdo->prepare("SELECT * FROM tab_descricaodia");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();
    while ($ln = $sql->fetchObject()) {

        $retorno[$descricao][$n] = $ln->dia_Descricao;
        $retorno['id'][$n] = $ln->dia_idDescricaoDia;
        $n++;
    }
}

if ($_GET['acao'] == 'setor') {

    $sql = $pdo->prepare("SELECT * FROM tab_setores where set_idEmpresa = " . $_SESSION['empresa_click']);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$descricao][$n] = $ln->set_Setor;
        $retorno['id'][$n] = $ln->set_idSetor;
        $n++;
    }
}

if ($_GET['acao'] == 'verificaUteis') {
    
    $ano = $_GET['ano'];
    $mes = $_GET['mes'];
    
    $sql = $pdo->prepare("select * from tab_diasuteis where diu_mes = '".$mes."' and diu_ano = '".$ano."' and diu_idEmpresa = ". $_SESSION['empresa_click']);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['dias'][$n] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'aprovadores') {

    $sql = $pdo->prepare("SELECT * FROM tab_aprovadores where apr_idLogin != 1 and apr_idEmpresa = " . $_SESSION['empresa_click']);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$descricao][$n] = $ln->arp_NomeDoAprovador;
        $retorno['id'][$n] = $ln->apr_idAprovadores;
        $n++;
    }
}

if ($_GET['acao'] == 'empresaById') {

    $id = $_GET['id'];

    $sql = $pdo->prepare("SELECT * FROM tab_empresas WHERE emp_idEmpresa = :id");
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$descricao][$n] = $ln->emp_Descricao;
        $retorno['id'][$n] = $ln->emp_idEmpresa;
        $retorno['fpw'][$n] = $ln->emp_CodigoEmpresaFpw;
        $n++;
    }
}

if ($_GET['acao'] == 'empresa') {

    $sql = $pdo->prepare("SELECT * FROM tab_empresas");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$descricao][$n] = $ln->emp_Descricao;
        $retorno['id'][$n] = $ln->emp_idEmpresa;
        $retorno['fpw'][$n] = $ln->emp_CodigoEmpresaFpw;
        $n++;
    }
}

if ($_GET['acao'] == 'listagemConsulta') {

    $id = $_SESSION['usuarioId'];
    $id_situacao = $_GET['id_situacao'];
    if (isset($_SESSION['empresa_click'])) {
        $id_empresa = $_SESSION['empresa_click'];
    } else {
        $id_empresa = $_GET['empresa'];
    }

    $sql = $pdo->prepare("SELECT *,  
    DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_extra_br,
    DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_emissao_br
    FROM tab_horaextra
    join tab_setores on tab_setores.set_idSetor = tab_horaextra.ext_IdSetor
    join tab_situacao on tab_situacao.sit_idSituacao = tab_horaextra.ext_IdSituacao
    join tab_empresas on tab_empresas.emp_idEmpresa = tab_horaextra.ext_IdEmpresa
    WHERE ext_idLogin = :id and ext_idEmpresa = :id_empresa and tab_horaextra.ext_IdSituacao = :id_situacao order by data_emissao_br desc;");

    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->bindValue(":id_empresa", $id_empresa, PDO::PARAM_INT);
    $sql->bindValue(":id_situacao", $id_situacao, PDO::PARAM_INT);
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

if ($_GET['acao'] == 'listagem') {

    $id = $_SESSION['usuarioId'];
    if (isset($_SESSION['empresa_click'])) {
        $id_empresa = $_SESSION['empresa_click'];
    } else {
        $id_empresa = $_GET['empresa'];
    }

    $sql = $pdo->prepare("SELECT *,  
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_extra_br,
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_emissao_br
	FROM tab_horaextra
	join tab_setores on tab_setores.set_idSetor = tab_horaextra.ext_IdSetor
	join tab_situacao on tab_situacao.sit_idSituacao = tab_horaextra.ext_IdSituacao
	join tab_empresas on tab_empresas.emp_idEmpresa = tab_horaextra.ext_IdEmpresa
	WHERE ext_idLogin = :id and ext_idEmpresa = :id_empresa and tab_horaextra.ext_IdSituacao = 1 order by data_emissao_br desc;");

    $sql->bindValue(":id", $id, PDO::PARAM_INT);
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

if ($_GET['acao'] == 'listagemAprovar') {


    $id_empresa = $_GET['empresa'];

    $sql = $pdo->prepare("SELECT *,  
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_extra_br,
	DATE_FORMAT(ext_DataHoraExtra,'%d/%m/%Y') as data_emissao_br
	FROM tab_horaextra
	join tab_setores on tab_setores.set_idSetor = tab_horaextra.ext_IdSetor
	join tab_situacao on tab_situacao.sit_idSituacao = tab_horaextra.ext_IdSituacao
	join tab_empresas on tab_empresas.emp_idEmpresa = tab_horaextra.ext_IdEmpresa
	WHERE ext_idEmpresa = :id_empresa and tab_horaextra.ext_IdSituacao = 1 order by data_emissao_br desc;");

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


if ($_GET['acao'] == 'aprovarExtras') {

    $id = $_GET['ids'];
    $situacao_id = $_GET['situacao'];


    $string = implode(',', $id);

    $sql = "update tab_horaextra set ext_IdSituacao = " . $situacao_id . " where ext_idHoraExtra in (" . $string . ");";

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        //success
        $msg = "";
        switch ($situacao_id) {
            case 2:
                $msg = "Aprovado";
                break;
            case 3:
                $msg = "Rejeitada";
                break;
            case 4:
                $msg = "Reprovada";
                break;
            default:
                break;
        }
        $retorno['msg'] = $msg . " com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao atualizar registro no banco de dados.";
    }
}

die(json_encode($retorno));
?>