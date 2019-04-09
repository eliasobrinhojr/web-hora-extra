<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$str_cod_empresa = 'cod_empresa';
if ($_SESSION[$str_cod_empresa] == NULL) {
    header("Location:../index.php");
}
?>
<html lang="en" class="no-js">

    <?php include('../../corpo/header.php'); ?>
    <link rel="stylesheet" href="../../../includes/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../../css/jquery.bootstrap.message.css" >
    <link rel="stylesheet" href="../../../css/style_crud.css" >
    <body>

        <?php include('../../corpo/banner.php'); ?>

        <div class="wrapper">
            <div class="canvas">
                <!-- Aqui fica o menu escondido -->

                <?php include('../../corpo/menu.php'); ?>

                <div class="container">

                    <table width="98%" style="margin-left: 5px; height: 40px; font-size: 20px; border-bottom:1px solid; line-height: 34px;">
                        <tr>
                            <td>Cadastros > Descrição de Dias</td>
                        </tr>
                    </table>
                    <br> 

                    <form id="form" method="post" action="#">
                        <label>Descrição</label>
                        <input required type="text" id="descricao" name="descricao"  class="form-control" placeholder="Descrição"/>
                        <br>
                        <label>Custo Encargo</label>
                        <select required class="form-control" id="custoencargo" name="custoencargo">


                        </select>

                        <div class="modal-footer">
                            <button type="button" onclick="salvar()" class="btn btn-success" >Salvar</button>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th scope="col">Custo de Encargos</th>
                                <th scope="col">Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela" >

                        </tbody>
                    </table>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <!--                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title">Formulário</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                            
                                                                        <form id="form" method="post" action="#">
                                                                            <label>Custo Encargo</label>
                                                                            <select required class="form-control" id="custoencargo" name="custoencargo">
                            
                            
                                                                            </select><br>
                                                                            <label>Descrição</label>
                                                                            <input required type="text" id="descricao" name="descricao" class="form-control" placeholder="Descrição"/>
                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" onclick="salvar()" class="btn btn-success" >Salvar</button>
                                                                            </div>
                                                                        </form>
                            
                                                                    </div>
                            
                                                                </div>-->

                        </div>
                    </div>



                </div>    

            </div>			
        </div>

        <?php include('../../corpo/footer.php'); ?>
        <script src="../../../js/jquery-1.11.1.min.js"></script>
        <script src="../../../js/funcoes/funcoes_desc_dias.js"></script>
        <script src="../../../includes/js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
        <script src="../../../js/jquery.validate.min.js"></script>
        <script src="../../../js/bootbox.js"></script>
    </body>
</html>