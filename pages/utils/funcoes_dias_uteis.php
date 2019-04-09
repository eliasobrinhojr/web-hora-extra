<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();

if ($_GET['acao'] == 'salvarDiasUteis') {

    $id_empresa = $_GET['empresa'];
    $ano = $_GET['ano'];
    $mes = $_GET['mes'];

    $diasUteis = $_GET['qtdUteis'];
    $domingos = $_GET['qtdDomingos'];
    $feriados = $_GET['qtdFeriados'];

    $data_cadastro = date('Y-m-d');
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';


    $sql_insert = "insert tab_diasuteis 
                        (diu_idEmpresa, 
                         diu_Mes,
                         diu_Ano,
                         diu_QtdeDiasUteis,
                         diu_QtdeDeDomingos,
                         diu_QtdeFeriados,
                         diu_DataDeCadastro,
                         diu_Evento,
                         diu_StatusDoRegistro)
                    values(" . $id_empresa . ",
                           '" . $mes . "',
                           '" . $ano . "',
                           " . $diasUteis . ",
                           " . $domingos . ",
                           " . $feriados . ",
                           '" . $data_cadastro . "',
                           '" . $evento . "',
                           '" . $status_registro . "');";

    $stmt = $pdo->prepare($sql_insert);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Cadastrado com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao inserir registro no banco de dados.";
    }
}

if ($_GET['acao'] == 'listaDiasUteis') {
    $id_empresa = $_GET['idEmpresa'];
    $sql = $pdo->prepare("SELECT * FROM tab_diasuteis
                        where tab_diasuteis.diu_idEmpresa = " . $id_empresa);
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['lista'][$n] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'meses') {


    $ano = $_GET['ano'];
    $id_empresa = $_GET['empresa'];
    $sql = $pdo->prepare("SELECT diu_Mes FROM tab_diasuteis
                        where tab_diasuteis.diu_Ano = " . $ano . " and diu_idEmpresa = ".$id_empresa);
    
   
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['mesPorAno'][$n] = $ln->diu_Mes;
        $n++;
    }

    $arrayMeses = array(
        ["numeroMes" => "1", "nomeMes" => "Janeiro"],
        ["numeroMes" => "2", "nomeMes" => "Fevereiro"],
        ["numeroMes" => "3", "nomeMes" => "Março"],
        ["numeroMes" => "4", "nomeMes" => "Abril"],
        ["numeroMes" => "5", "nomeMes" => "Maio"],
        ["numeroMes" => "6", "nomeMes" => "Junho"],
        ["numeroMes" => "7", "nomeMes" => "Julho"],
        ["numeroMes" => "8", "nomeMes" => "Agosto"],
        ["numeroMes" => "9", "nomeMes" => "Setembro"],
        ["numeroMes" => "10", "nomeMes" => "Outubro"],
        ["numeroMes" => "11", "nomeMes" => "Novembro"],
        ["numeroMes" => "12", "nomeMes" => "Dezembro"]);

    $retorno['meses'] = $arrayMeses;
}

if ($_GET['acao'] == 'anos') {
    $n = 0;
    for ($i = 18; $i < 100; $i++) {
        $retorno['anos'][$n] = '20' . $i;
        $n++;
    }
}



if ($_GET['acao'] == 'excluirDiu') {
    $id = $_GET['id'];
    $sql = "delete from tab_diasuteis where diu_idDiasUteis = " . $id;

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

die(json_encode($retorno));
?>