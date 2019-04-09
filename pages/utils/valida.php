<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once("../../config/conexao.php");

$loginErro = 'loginErro';
$loginphp = "Location:../view/login.php";

if ((isset($_POST['login'])) && (isset($_POST['senha']))) {
    $usuario = mysqli_real_escape_string($conn, $_POST['login']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);


    $query_usuario = "select * from tab_logins
		where log_Login ='$usuario' 
		and log_senha = '$senha' 
		LIMIT 1";

    $resultado_usuario = mysqli_query($conn, $query_usuario);
    $resultado = mysqli_fetch_assoc($resultado_usuario);

    if ($resultado != NULL && $resultado['log_StatusDoRegistro'] != 'A') {
        $_SESSION[$loginErro] = "Usuário desativado";
        header($loginphp);
        exit;
    }


    if (isset($resultado)) {
        $_SESSION['usuarioId'] = $resultado['log_idLogin'];
        $_SESSION['usuarioNome'] = $resultado['log_NomeCompleto'];
        $_SESSION['usuarioLogin'] = $resultado['log_Login'];


        $query_acessos = "select acs_idEmpresa, acs_IdTipoDeAcesso, tab_empresas.emp_ConexaoBase from tab_acesso
   join tab_empresas on tab_empresas.emp_idEmpresa = tab_acesso.acs_idEmpresa
                            where acs_idLogin = " . $resultado['log_idLogin'];
        $resultado_acessos = mysqli_query($conn, $query_acessos);
        $result = mysqli_fetch_assoc($resultado_acessos);


        $_SESSION['acessos'] = $result;

        if ($result['acs_IdTipoDeAcesso'] == 5) {
            header("Location:../view/portaria.php");
        } else {
            header("Location:../view/index.php");
        }
    } else {
        $_SESSION[$loginErro] = "<div id='errorBox' class='sv-bg-color--red-50 sv-bws--1 sv-bd-color--red-400 sv-br--2 sv-color--red-800 sv-pa--5' style='visibility: visible;'><span>Usuário ou senha inválidos. Verifique os dados e tente novamente.</span></div>";

        header($loginphp);
    }
} else {
    $_SESSION[$loginErro] = "<div id='errorBox' class='sv-bg-color--red-50 sv-bws--1 sv-bd-color--red-400 sv-br--2 sv-color--red-800 sv-pa--5' style='visibility: visible;'><span>Usuário ou senha inválidos. Verifique os dados e tente novamente.</span></div>";
    header($loginphp);
}
?>