<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();

if ($_GET['acao'] == 'salvarDescDias') {

    $id_custo_encargo = $_GET['id_custo'];
    $descricao_dia = $_GET['descricao'];
    $data_cadastro = date('Y-m-d');
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';


    $sql_insert = "insert into tab_descricaodia (dia_idCustoDeEncargos, dia_Descricao, dia_DataDeCadastro, dia_Evento, dia_StatusDoRegistro)
    values (" . $id_custo_encargo . ",'" . $descricao_dia . "', '" . $data_cadastro . "', '" . $evento . "', '" . $status_registro . "');";


    $stmt = $pdo->prepare($sql_insert);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Cadastrado com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao inserir registro no banco de dados.";
    }
}

if ($_GET['acao'] == 'excluirDescDias') {

    $id = $_GET['id'];


    $sql = "delete from tab_descricaodia where dia_idDescricaoDia = " . $id;


    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        //success

        $retorno['msg'] = "Excluído com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao excluir registro no banco de dados.";
    }
}

if ($_GET['acao'] == 'custoencargo') {

    $sql = $pdo->prepare("select * from tab_custoencargos;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['custo'] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'encargoDias') {

    $sql = $pdo->prepare("select * from tab_descricaodia
    join tab_custoencargos on tab_custoencargos.enc_idCustoDeEncargos = tab_descricaodia.dia_idCustoDeEncargos;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['dia_descricao'][$n] = $ln->dia_Descricao;
        $retorno['enc_descricao'][$n] = $ln->enc_Descricao;
        $retorno['id'][$n] = $ln->dia_idDescricaoDia;
        $n++;
    }
}


die(json_encode($retorno));
?>