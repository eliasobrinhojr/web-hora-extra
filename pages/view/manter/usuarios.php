<!DOCTYPE html>
<?php
$str_cod_empresa = 'cod_empresa';
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION[$str_cod_empresa] == NULL) {
    header("Location:../../index.php");
}
?>
<html lang="en" class="no-js">

    <?php include('../../corpo/header.php'); ?>
    <link rel="stylesheet" href="../../../includes/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../../css/jquery.bootstrap.message.css" >
    <link rel="stylesheet" href="../../../css/style_crud.css" >
    <style>
        summary{
            font-size: 17px;
        }
        summary::-webkit-details-marker {
            display: none
        }

        summary:after {
            background: url(../../../img/details_open.png);
            float: left; 
            height: 20px;
            width: 20px;
            content: " ";
        }

        details[open] summary:after {
            background: url(../../../img/details_close.png);
        }

        p{
            margin-left: 20px;
        }
    </style>
    <body>

        <?php include('../../corpo/banner.php'); ?>

        <div class="wrapper">
            <div class="canvas">
                <!-- Aqui fica o menu escondido -->

                <?php include('../../corpo/menu.php'); ?>

                <div class="container">
                    <table width="98%" style="margin-left: 5px; height: 40px; font-size: 20px; border-bottom:1px solid; line-height: 34px;">
                        <tr>
                            <td>Cadastros > Usuários</td>
                        </tr>
                    </table>
                    <br>
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h2><b>Usuários</b></h2></div>
                            <div class="col-sm-4">
                                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info add-new"><i class="fa fa-plus"></i>Novo Usuário</button>
                            </div>
                        </div>
                    </div>


                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th scope="col">Login</th>
                                <th scope="col">Nome Completo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela" >

                        </tbody>
                    </table>


                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Formulário</h4>
                                </div>
                                <div class="modal-body">

                                    <form id="form" method="post" action="#">
                                        <label>Login</label>
                                        <input required type="text" id="login" name="login" class="form-control" placeholder="Login"/>
                                        <br>
                                        <label>Nome Completo</label>
                                        <input required type="text" id="nome_completo" name="nome_completo" class="form-control" placeholder="Nome"/>
                                        <br>
                                        <label>Senha</label>
                                        <input required type="password" id="senha" name="senha" class="form-control" placeholder="Senha"/>

                                        <div class="modal-footer">
                                            <button type="button" onclick="salvar()" class="btn btn-success" >Salvar</button>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>



                </div>  


                <hr>
                <div class="container">

                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h2><b>Acessos</b></h2></div>
                            <div class="col-sm-4">
                                <button type="button" data-toggle="modal" data-target="#modalAcesso" class="btn btn-info add-new"><i class="fa fa-plus"></i>Novo Acesso</button>
                            </div>
                        </div>



                    </div>

                    <div id="div_acessos">

                    </div>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th scope="col">Empresa</th>
                                <th scope="col">Tipo de Acesso</th>
                                <th scope="col">Login</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela_acesso" >

                        </tbody>
                    </table>

                    <div class="modal fade" id="modalAcesso" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Formulário</h4>
                                </div>
                                <div class="modal-body">

                                    <form id="form_acesso" method="post" action="#">


                                        <label>Usuário</label>
                                        <select required class="form-control" id="usuarios" name="usuarios">


                                        </select>

                                        <br>
                                        <select required disabled class="form-control" id="tipo_acesso" name="tipo_acesso">


                                        </select><br>
                                        <label>Empresa</label>
                                        <select required class="form-control" multiple disabled id="empresas" name="empresas">


                                        </select>
                                        <div class="modal-footer">
                                            <button type="button" onclick="salvarAcesso()" class="btn btn-success" >Salvar</button>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>


                </div>   
            </div>			
        </div>

        <?php include('../../corpo/footer.php'); ?>
        <script src="../../../js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
        <script src="../../../js/jquery.validate.min.js"></script>
        <script src="../../../js/funcoes/funcoes_usuarios.js"></script>
        <script src="../../../includes/js/bootstrap.min.js" ></script>
        <script src="../../../js/bootbox.js"></script>
    </body>
</html>