<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['usuarioNome'])) {
    header("Location: index.php");
}
$str_login_error = 'loginErro';
$str_login_deslogado = 'logindeslogado';
?>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sistema de Cadastro de Hora Extra v0.1</title>
        <link rel="stylesheet" href="../../includes/css/bootstrap.min.css" >
        <link rel="shortcut icon" href="../../img/grupois1.png">
        <link href="../../css/styles.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <style>
            body {
                margin-top: 60px;
            }

            .login-box {
                -webkit-box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, 0.7);
                -moz-box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, 0.7);
                box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, 0.7);
                background: #fff;
                height: 450px;
                width: 550px;
                margin: 0 auto;
                border-bottom: 15px solid;
            }

            .logo {
                display: flex;
            }

            .logo img {
                align-self: center;
                margin: auto;
            }
        </style>
    </head>
    <body class="sv-bg-color--steel-800">
        <div class="login-box sv-bd-color--blue-grupois">
            <div class="sv-row sv-bg-color--blue-grupois sv-no-margins">
                <!--sv-column sv-pv--50-->
                <div class="sv-text-center sv-column">
                    <img src="../../img/grupois.png" width="30%" height="auto" style="padding-top:10px; padding-bottom:10px;"/>
                </div>
            </div>
            <div class="sv-row">
                <div class="sv-column sv-pa--20">
                    <form role="form" method="POST" action="../utils/valida.php">
                        <p class="text-center text-danger">
                            <?php
                            if (isset($_SESSION[$str_login_error])) {
                                echo $_SESSION[$str_login_error];
                                unset($_SESSION[$str_login_error]);
                            }
                            ?>
                        </p>
                        <p class="text-center text-success">
                            <?php
                            if (isset($_SESSION[$str_login_deslogado])) {
                                echo $_SESSION[$str_login_deslogado];
                                unset($_SESSION[$str_login_deslogado]);
                            }
                            ?>
                        </p>
                        <fieldset>
                            <div class="form-group">
                                <label for="usuario">Usuário:</label>
                                <input class="form-control" placeholder="Usuário" name="login" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input class="form-control" placeholder="Senha" name="senha" type="password" value="">
                            </div>
                            <button class="btn btn-primary" type="submit">Acessar</button>
                        </fieldset>
                    </form>
                    <div id="loader" class="sv-hidden">
                        <div class="sv-spin-loader"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../js/jquery-1.11.1.min.js"></script>
    </body>
</html>

