<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['usuarioNome'])) {
    $_SESSION['loginErro'] = "";
    header("Location:login.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sistema de Cadastro de Hora Extra v0.1</title>
        <link rel="stylesheet" href="../../includes/css/bootstrap.css" >
        <link href="../../css/styles.css" rel="stylesheet">
        <link rel="shortcut icon" href="../../img/grupois1.png">
        <link rel="stylesheet" type="text/css" href="../../includes/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

        <link rel="stylesheet" type="text/css" href="../../includes/DataTables/DataTables-1.10.18/css/buttons.dataTables.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <style>
            .dt-button.red {
                color: red;
            }

            .dt-button.orange {
                color: orange;
            }

            .dt-button.green {
                color: green;
            }


            .loading-overlay {
                display: table;
                opacity: 0.7;
            }

            .loading-overlay-content {
                text-transform: uppercase;
                letter-spacing: 0.4em;
                font-size: 1.15em;
                font-weight: bold;
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .loading-overlay.loading-theme-light {
                background-color: #fff;
                color: #000;
            }

            .loading-overlay.loading-theme-dark {
                background-color: #000;
                color: #fff;
            }

            td.details-control {
                background: url('../../img/details_open.png') no-repeat center;
                cursor: pointer;
            }
            tr.shown td.details-control {
                background: url('../../img/details_close.png') no-repeat center;
                cursor: pointer;
            }


        </style>
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>   
        <table width="100%" class="empresas-box sv-no-margins sv-bg-color--blue-grupois">
            <tr>
                <td width="120" >
                    <div class="sv-row sv-bg-color--blue-grupois sv-no-margins" style="border-right: 1px solid; color:white;" >
                        <!--sv-column sv-pv--50-->
                        <div class="sv-text-left sv-column">
                            <img src="../../img/grupois.png" width="98" height="auto" style="padding-top:5px; padding-left:5px; padding-bottom:5px;"/>							 
                        </div>			
                    </div>
                </td>
                <td>
                    <div class="sv-row sv-bg-color--blue-grupois sv-no-margins">
                        <!--sv-column sv-pv--50-->
                        <div class="sv-text-left sv-column">
                            <div class="coluna-1"><span style="color:white; padding-left:5px; font-size:30px; line-height:1.45">SISTEMA DE CADASTRO DE HORA EXTRA.</span></div>
                             <!--<span style="color:white; vertical-align:middle; padding-top:110px; padding-left:10px; font-size:30px;">SISTEMA DE CADASTRO DE HORA EXTRA.</span>-->
                        </div>			
                    </div>
                </td>
                <td width="120" >
                    <div class="sv-row sv-bg-color--blue-grupois sv-no-margins" style="border-style:solid; border-weight:1px; border:0px; border-color:white;" >
                        <!--sv-column sv-pv--50-->
                        <div class="sv-text-right sv-column">						
                            <a href="../utils/sair.php"><img src="../../img/power.png" width="82" height="auto" style="padding-top:5px; padding-left:5px; padding-bottom:5px;"/></a>						
                        </div>			
                    </div>
                </td>
            </tr>
        </table>
        <br/>
        <div id="div_load">
            <div  class="lista_empresa" style="display: visible;">
                <table width="100%" class="empresas-box-item">
                    <tr>
                        <td>
                            <div id="divForms">

                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div  style="padding: 20px;" >
                <form id="form-id" action="#" method="post">
                    <select style="display: none;" id="sel_empresas" name="sel_empresas"></select><br><br><hr>
                    <div id="divTable" style="display: none;" > 
                        <table id="table_historico" class="display nowrap table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>DRT</th>
                                    <th>Colaborador</th>
                                    <th>Emissão</th>
                                    <th>Data</th>
                                    <th>Setor</th>
                                    <th>Início</th>
                                    <th>Término</th>
                                </tr>
                            </thead>
                            <tbody>	</tbody>
                        </table> </div>
                </form>
            </div>

            <div id="divMsg"  style="display: none;" >
                <p style="padding: 20px;">Sem extras aprovadas para data de Hoje <?php echo date('m/d/Y');?></p>
            </div>

        </div>
    </body>
    <script type="text/javascript" charset="utf8" src="../../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../js/funcoes/funcoes_home.js"></script>
    <script type="text/javascript" charset="utf8" src="../../js/loading.js"></script>
    <script>

        var load = $('body').loading();
        setTimeout('update(load)', 2000);
        function update(load) {
            load.loading('stop');
        }

    </script>

    <script type="text/javascript" charset="utf8" src="../../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/buttons.colVis.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="../../includes/DataTables/DataTables-1.10.18/js/buttons.html5.min.js"></script>
    <script src="../../js/funcoes/funcoes_portaria.js"></script>
    <script src="../../includes/js/bootstrap.min.js"></script>

</html>

