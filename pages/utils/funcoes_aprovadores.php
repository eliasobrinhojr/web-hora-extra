<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();

if ($_GET['acao'] == 'salvarAprovador') {


    $array_empresas = $_GET['empresas'];
    $idLogin = $_GET['id_usuario'];
    $data_cadastro = date('Y-m-d');
    $nomeAprovador = $_GET['nome_usuario'];
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';

    $sql_insert = 'insert into tab_aprovadores (apr_idLogin, apr_idEmpresa, arp_NomeDoAprovador, apr_DataDeCadastro, apr_Evento, apr_StatusDoRegistro)
        values ';

    for ($i = 0; $i < count($array_empresas); $i++) {
        $sql_insert .= "(" . $idLogin . "," . $array_empresas[$i] . ", '" . $nomeAprovador . "','" . $data_cadastro . "', '" . $evento . "', '" . $status_registro . "'),";
    }

    $sql_insert = substr($sql_insert, 0, strlen($sql_insert) - 1);
    $sql_insert .= ';';



    $stmt = $pdo->prepare($sql_insert);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Cadastrado com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao inserir registro no banco de dados.";
    }
}

if ($_GET['acao'] == 'excluirAprovador') {

    $id = $_GET['id'];

    $sql = "delete from tab_aprovadores where apr_idAprovadores = " . $id;

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Excluído com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao excluir registro no banco de dados.";
    }
}

if ($_GET['acao'] == 'empresa') {

    $id = $_GET['id'];

    $sql = $pdo->prepare("select * from tab_empresas;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();


    while ($ln = $sql->fetchObject()) {
        $retorno['empresas'][$n] = $ln;
        $n++;
    }


    $sql_aprovadores = $pdo->prepare("select apr_idEmpresa from tab_aprovadores where apr_idLogin = :id;");
    $sql_aprovadores->bindValue(":id", $id, PDO::PARAM_INT);
    $sql_aprovadores->execute();
    $idx = 0;
    $retorno['qtdAprovadores'] = $sql_aprovadores->rowCount();

    while ($ln = $sql_aprovadores->fetchObject()) {
        $retorno['aprovadores'][$idx] = $ln;
        $idx++;
    }
}

if ($_GET['acao'] == 'listaUsuarios') {

    $sql = $pdo->prepare("select * from tab_logins where log_idLogin != 1;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['usuario'][$n] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'aprovadorEmpresa') {

    $sql = $pdo->prepare("SELECT * FROM tab_aprovadores 
        join tab_empresas on tab_empresas.emp_idEmpresa = tab_aprovadores.apr_idEmpresa
        where tab_aprovadores.apr_idLogin != 1;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['empresa'][$n] = $ln->emp_Descricao;
        $retorno['nome'][$n] = $ln->arp_NomeDoAprovador;
        $retorno['id'][$n] = $ln->apr_idAprovadores;
        $n++;
    }
}


die(json_encode($retorno));
?>