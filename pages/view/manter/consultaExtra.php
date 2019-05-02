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
     <link rel="stylesheet" type="text/css" href="../../../includes/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

        <link rel="stylesheet" type="text/css" href="../../../includes/DataTables/DataTables-1.10.18/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>

    <?php include('../../corpo/banner.php'); ?>

    <div class="wrapper">
        <div class="canvas">
            <!-- Aqui fica o menu escondido -->

            <?php include('../../corpo/menu.php'); ?>


            <div class="container">
 <div id="divConsulta" style="padding: 20px;">

                <form id="form-id" action="#" method="post">
                    <b><p id="label_empresa"></p></b> <hr>
                    <input type="hidden" id="id_empresa" value="<?php echo $_SESSION['empresa_click'];?>"/>
                    <select id="sel_situacao" onchange="carregaTableConsulta(this.value)" name="sel_situacao">
                        <option value="1">Aguardando Aprovação</option>
                        <option value="2">Aprovada</option>
                        <option value="3">Rejeitada</option>
                        <option value="4">Reprovada</option>
                    </select><br> <br>
                    <hr>
                     <br>
                    <div id="divTableConsulta" > 
                        <table id="table_consulta"  class="display row-border stripe table table-striped table-bordered " style="width:100%">
                            <thead>
                                <tr>
                                    <th>DRT</th>
                                    <th>Colaborador</th>
                                    <th>Setor</th>
                                    <th>Emissão</th>
                                    <th>Data</th>
                                    <th>Início</th>
                                    <th>Término</th>
                                </tr>
                            </thead>
                        </table> </div>
                </form>
            </div>
            </div>     


        </div>			
    </div>

    <?php include('../../corpo/footer.php'); ?>
    <script src="../../../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
     <script type="text/javascript" charset="utf8" src="../../../includes/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>
    <script src="../../../js/jquery.validate.min.js"></script>
    <script src="../../../includes/js/bootstrap.min.js" ></script>
    <script src="../../../js/bootbox.js"></script>
    <script>
    	
		
    	carregaTableConsulta(1);

		function carregaTableConsulta(id_situacao){
		   // $('#table_consulta').DataTable().clear();
		   var id_empresa = $('#id_empresa').val();

		    $('#table_consulta').dataTable().fnClearTable();
		    $('#table_consulta').dataTable().fnDestroy();

		    $('#table_consulta').DataTable({
		        "ajax": {
		            "url": "../../utils/funcoes_hora_extra.php?acao=listagemConsulta&empresa=" + id_empresa + "&id_situacao="+id_situacao,
		            "type": "GET",
		            "dataType": "json",
		            "data": function (d) {
		                return JSON.stringify(d);
		            }
		        },

		        'columnDefs': [{"className": "dt-center", "targets": "_all"}],
		        "columns": [

		            {"data": "ext_DrtFuncionario"},
		            {"data": "ext_NomeDoColaborador"},
		            {"data": "set_Setor"},
		            {"data": "data_extra_br"},
		            {"data": "data_emissao_br"},
		            {"data": "ext_HoraInicial"},
		            {"data": "ext_HoraFinal"}
		        ],
		        "language": {
		            "lengthMenu": "_MENU_ registros por página",
		            "zeroRecords": "Nada encontrado",
		            "info": "Mostrando página _PAGE_ de _PAGES_",
		            "infoEmpty": "Nenhum registro disponível",
		            "infoFiltered": "(filtrado de _MAX_ registros no total)",
		            "search": "Filtrar:",
		            "paginate": {
		                "first": "Primeiro",
		                "last": "Ultimo",
		                "next": "Próximo",
		                "previous": "Anterior"
		            }

		        }
		    });

		    $("#divConsulta").css("display", "block");
		}

    </script>
   
</body>
</html>