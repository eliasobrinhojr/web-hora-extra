<?php

require("../../config/config.php");
if (!isset($_SESSION)) {
    session_start();
}

$retorno = array();

if ($_GET['acao'] == 'salvarUsuario') {

    $login = $_GET['login'];
    $nome_completo = $_GET['nomeCompleto'];
    $senha = $_GET['senha'];
    $data_cadastro = date('Y-m-d');
    $tipoAutenticacao = 'Local';
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';

    $sql_insert = "insert into tab_logins 
           (log_Login, 
            log_NomeCompleto,
            log_DataDeCadastro, 
            log_Evento,
            log_TipoDeAutenticacao,
            log_StatusDoRegistro,
            log_senha)
        values ('" . $login . "', '" . $nome_completo . "', '" . $data_cadastro . "', '" . $evento . "', '" . $tipoAutenticacao . "', 
                '" . $status_registro . "', 
                '" . $senha . "')";


    $stmt = $pdo->prepare($sql_insert);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Cadastrado com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao inserir registro no banco de dados.";
    }
}


if ($_GET['acao'] == 'salvarAcesso') {

    $array_empresas = $_GET['empresas'];
    $id_usuario = $_GET['id_usuario'];
    $id_tipo_acesso = $_GET['id_tipo_acesso'];
    $data_cadastro = date('Y-m-d');
    $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
    $status_registro = 'A';


    $sql_insert = "insert into tab_acesso (acs_idEmpresa, acs_IdTipoDeAcesso, acs_idLogin, acs_DataDeCadastro, acs_Evento, acs_StatusDoRegistro)
            values ";

    for ($i = 0; $i < count($array_empresas); $i++) {
        $sql_insert .= "(" . $array_empresas[$i] . "," . $id_tipo_acesso . ", " . $id_usuario . ",'" . $data_cadastro . "','" . $evento . "', '" . $status_registro . "'),";
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

if ($_GET['acao'] == 'excluirUsuario') {

    $id = $_GET['id'];
    $sql = "delete from tab_logins where log_idLogin = " . $id;


    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        //success
        $retorno['msg'] = "Excluído com sucesso!";
    } else {
        // error
        $retorno['msg'] = "Erro ao excluir registro no banco de dados.";
    }
}
if ($_GET['acao'] == 'excluirAcesso') {

    $id = $_GET['id'];
    $sql = "delete from tab_acesso where acs_idAcesso = " . $id;


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

    $sql_acesso = $pdo->prepare("select acs_idEmpresa, acs_IdTipoDeAcesso from tab_acesso where acs_idLogin = :id;");
    $sql_acesso->bindValue(":id", $id, PDO::PARAM_INT);
    $sql_acesso->execute();
    $idx = 0;
    $retorno['qtdAcesso'] = $sql_acesso->rowCount();

    while ($ln = $sql_acesso->fetchObject()) {
        $retorno['acessos'][$idx] = $ln;
        $idx++;
    }
}

if ($_GET['acao'] == 'tipoAcesso') {

    $sql = $pdo->prepare("SELECT * FROM tab_tipodeacesso;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['acesso'] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'listaUsuarios') {

    $sql = $pdo->prepare("select * from tab_logins where log_idLogin != 1;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno['nomeCompleto'][$n] = $ln->log_NomeCompleto;
        $retorno['login'][$n] = $ln->log_Login;
        $retorno['id'][$n] = $ln->log_idLogin;
        $n++;
    }
}

if ($_GET['acao'] == 'listaAcessos') {

    $sql = $pdo->prepare("select * from tab_acesso
                            join tab_empresas on tab_empresas.emp_idEmpresa = tab_acesso.acs_idEmpresa
                            join tab_tipodeacesso on tab_tipodeacesso.tip_idTipoDeAcesso = tab_acesso.acs_IdTipoDeAcesso
                            join tab_logins on tab_logins.log_idLogin = tab_acesso.acs_idLogin where tab_logins.log_idLogin != 1;");
    $sql->execute();
    $n = 0;
    $retorno['qtd'] = $sql->rowCount();

    while ($ln = $sql->fetchObject()) {
        $retorno[$n]['acesso'] = $ln;
        $n++;
    }
}

if ($_GET['acao'] == 'acessos') {
    $sql_usuarios = $pdo->prepare("select lg.log_idLogin, lg.log_NomeCompleto, emp.emp_idEmpresa, emp.emp_Descricao, acs_IdTipoDeAcesso, tp.tip_Tipo from tab_acesso acs
                                    join tab_empresas emp on emp.emp_idEmpresa = acs.acs_idEmpresa
                                    join tab_logins lg on lg.log_idLogin = acs.acs_idLogin
                                    join tab_tipodeacesso tp on tp.tip_idTipoDeAcesso = acs.acs_IdTipoDeAcesso
                                    where acs_idLogin != 1;");
    $sql_usuarios->execute();
    $n = 0;
    $retorno['qtd'] = $sql_usuarios->rowCount();

    while ($ln = $sql_usuarios->fetchObject()) {
        $retorno['usuarios'][$n] = $ln;
        $n++;
    }
    
    
}





die(json_encode($retorno));
