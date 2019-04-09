

<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <title>Sair</title>
    </head>

    <body>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }

        unset(
               $_SESSION['acessos'], $_SESSION['empresas_aprovar'], $_SESSION['usuarioId'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['empresas'], $_SESSION['loginErro'], $_SESSION['empresa_click'], $_SESSION['errorBox'], $_SESSION['cod_empresa']
        );

        $_SESSION['logindeslogado'] = "<div id='errorBox' class='sv-bg-color--green-50 sv-bws--1 sv-bd-color--green-400 sv-br--2 sv-color--green-700 sv-pa--5' style='visibility: visible;'><span>Usuário deslogado com sucesso.</span></div>";

        //greenirecionar o usuario para a página de login
        header("Location:../view/login.php");
        ?>
    </body>
</html> 


