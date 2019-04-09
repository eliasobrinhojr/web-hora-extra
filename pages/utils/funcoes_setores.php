<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();

if ($_GET['acao'] == 'salvarSetor') {

    $array_empresas = $_GET['empresas'];
    $descricao_setor = $_GET['descricao'];
    $data_cadastro = date('Y-m-d');
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';


    $sql_insert = 'insert into tab_setores 
        (set_idEmpresa, set_Setor, set_DataDeCadastro, set_Evento, set_StatusDoRegistro)
        values ';

    for ($i = 0; $i < count($array_empresas); $i++) {
        $sql_insert .= "(" . $array_empresas[$i] . ",'" . $descricao_setor . "', '" . $data_cadastro . "','" . $evento . "', '" . $status_registro . "'),";
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

if ($_GET['acao'] == 'excluirSetor') {

    $id = $_GET['id'];
    $sql = "delete from tab_setores where set_idSetor = " . $id;

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

    $sql = $pdo->prepare("SELECT * FROM tab_empresas");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['empresas'][$n] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'verificaSetorEmpresa') {

    $sql = $pdo->prepare('SELECT * FROM tab_setores where set_Setor = "' . $_GET['descricao_setor'] . '" ;');
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['setor'] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'setorEmpresa') {

    $sql = $pdo->prepare("SELECT * FROM tab_setores 
        join tab_empresas on tab_empresas.emp_idEmpresa = tab_setores.set_idEmpresa;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['empresa'][$n] = $ln->emp_Descricao;
        $retorno['descricao'][$n] = $ln->set_Setor;
        $retorno['id'][$n] = $ln->set_idSetor;
        $n++;
    }
}


die(json_encode($retorno));
?>