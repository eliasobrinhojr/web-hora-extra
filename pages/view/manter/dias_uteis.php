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
    <link rel="stylesheet" href="../../../css/style_crud.css" >
    <link rel="stylesheet" href="../../../css/jquery.bootstrap.message.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>

    <?php include('../../corpo/banner.php'); ?>
    <style>
        #divSelect {
            display: flex;   /* Magic begins */
            flex-wrap: wrap; /* Allow multiple lines */
        }
        #left {
            flex: 1 300px; 
            min-width: 0;    
            margin-left: 10px;
        }
        #right {
            flex: 1 300px;  
            min-width: 0; 
        }

        #parent-div {
            background: #555;
        }
        #parent-div  > div{

            float:left;
            width:33%;
            padding: 10px;
        }
        #div1 {
            float: left; /* Commenting this out results in another weird result*/



            //  background: blue;
            box-sizing: border-box;
        }

        #div2 {

            //  background: red;
            box-sizing: border-box;
        }

        #div3 {

            box-sizing: border-box;
            //  background: green;

        }
        h4{
            margin: 1em;
        }



    </style>

    <div class="wrapper">
        <div class="canvas">
            <!-- Aqui fica o menu escondido -->

            <?php include('../../corpo/menu.php'); ?>


            <div class="container">
                <table width="98%" style="margin-left: 5px; height: 40px; font-size: 20px; border-bottom:1px solid; line-height: 34px;">
                    <tr>
                        <td>Cadastros > Dias</td>
                    </tr>
                </table>
                <form method="post" id="form" >
                    <br>
                    <label>Empresas</label>
                    <select required class="form-control" id="empresas" name="empresas"></select>

                    <div id="divSelect">
                        <div id="right">

                            <br> 
                            <label>Ano</label>

                            <select disabled required class="form-control" id="ano" name="ano">
                                
                               
                            </select> <br>

                        </div>
                        <div id="left">
                            <br> 
                            <label>Mês</label>
                            <select disabled required class="form-control" id="mes" name="mes">


                            </select> <br>
                        </div>


                    </div>


                    <div id="parent-div">
                        <div id="div1" class="child-div">

                            <label for="example-number-input" class="col-2 col-form-label">Dias úteis</label>
                            <div class="col-10">
                                <input required class="form-control" type="number"  pattern="^[0-9]*$" id="qtdUteis">
                            </div>
                        </div>

                        <div id="div2" class="child-div">

                            <label for="example-number-input" class="col-2 col-form-label">Domingos</label>
                            <div class="col-10">
                                <input required class="form-control" type="number"  pattern="^[0-9]*$" id="qtdDomingos">
                            </div>
                        </div>

                        <div id="div3" class="child-div">

                            <label for="example-number-input" class="col-2 col-form-label">Feriados</label>
                            <div class="col-10">
                                <input required class="form-control" type="number"  pattern="^[0-9]*$" id="qtdFeriados">
                            </div>
                        </div>

                    </div>

                    <br><br><br><br><br>

                    <div class="modal-footer">
                        <button type="button" onclick="salvar()"  class="btn btn-success" >Salvar</button>
                    </div>
                </form>
                <br>
                <div>
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h2><b>Dias por Empresa</b></h2></div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th scope="col">Mês</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Úteis</th>
                                <th scope="col">Domingos</th>
                                <th scope="col">Feriados</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela" >

                        </tbody>
                    </table>
                </div>
            </div>     


        </div>			
    </div>

    <?php include('../../corpo/footer.php'); ?>
    <script src="../../../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
    <script src="../../../js/jquery.validate.min.js"></script>
    <script src="../../../includes/js/bootstrap.min.js" ></script>
    <script src="../../../js/bootbox.js"></script>
    <script src="../../../js/funcoes/funcoes_dias_uteis.js"></script>

</body>
</html>