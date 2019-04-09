<!DOCTYPE html>

<html lang="en" class="no-js">
    <?php
    include('../../corpo/header.php');
    include('../../utils/manter_hora_extra.php');
    $str_cod_empresa = 'cod_empresa';
    $_SESSION['empresa_click'] = isset($_POST['id_empresa']) ? $_POST['id_empresa'] : $_SESSION['empresa_click'];
    $_SESSION[$str_cod_empresa] = isset($_POST[$str_cod_empresa]) ? $_POST[$str_cod_empresa] : $_SESSION[$str_cod_empresa];
    ?>

    <link rel="stylesheet" href="../../../includes/css/bootstrap.min.css" >

    <!-- falta esse aq-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="../../../css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/jquery.bootstrap.message.css" >
    <link rel="stylesheet" type="text/css" href="../../../includes/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">


    <style>
        td.details-control {
            background: url('../../../img/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../../../img/details_close.png') no-repeat center center;
        }

        td {			
            vertical-align: bottom;
            /*vertical-align: top;			*/
            text-align: left;
        }

    </style>

    <body>	
<?php include('../../corpo/banner.php'); ?>		
        <div class="wrapper">

            <div class="canvas">
                <!-- Aqui fica o menu escondido -->
<?php include('../../corpo/menu.php'); ?>
                <table width="98%" style="margin-left: 5px; height: 40px; font-size: 20px; border-bottom:1px solid; line-height: 34px;">
                    <tr>
                        <td>Cadastros > Solicitação Hora Extra</td>
                    </tr>
                </table>
                <table border='0' width="90%" style="margin-left: 5px;">			
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>					
                    <form role="form" method="post" action="hora_extra.php?acao=salvar">
                        <tr>
                            <td width="400">
                                <div tabindex="0">
                                    <label>Empresa:</label>
                                    <input id="conexao_base" name="conexao_base" type="hidden" value="<?php echo $_SESSION['emp_ConexaoBase']; ?>"/>
                                    <input id="cod_empresa" name="cod_empresa" type="hidden" value="<?php echo $_SESSION['cod_empresa']; ?>"/>
                                    <input id="descricao_setor" name="descricao_setor" type="hidden" value="<?php
if (isset($_POST['descricao_setor'])) {
    echo $_POST['descricao_setor'];
}
?>"/>
                                    <input id="id_empresa" name="id_empresa" type="hidden" value="<?php echo $_SESSION['empresa_click']; ?>"/>
                                    <input id="descricao_empresa" name="descricao_empresa" class="form-control" readonly value=""/>
                                </div>
                            </td>
                            <td width="100" style="padding-left: 5px;">
                                <div tabindex="1">
                                    <label>Data de Emissão:</label>
                                    <input type="date" style="line-height: 20px;" id="data_emissao" name="data_emissao" class="form-control" readonly value="<?php echo date('Y-m-d'); ?>"/>
                                </div>
                            </td>
                            <td width="200"  style="padding-left: 5px;">
                                <div tabindex="2">
                                    <label>Data da Extra:</label>
                                    <input required="required" style="line-height: 20px;" type="date" id="data_extra" name="data_extra" onchange="validaDataSelecionada(this)" class="form-control" value="<?php
                                    if (isset($_POST['data_extra'])) {
                                        echo $_POST['data_extra'];
                                    }
?>"/>
                                </div>
                            </td>
                            <td width="100"  style="padding-left: 5px;">
                                <div tabindex="3">
                                    <label>Setor</label>
                                    <input id="selectSetor" name="selectSetor" type="hidden" value="<?php
                                    if (isset($_POST['setor'])) {
                                        echo $_POST['setor'];
                                    } else {
                                        echo "";
                                    }
?>">
                                    <select required="required" id="setor" name="setor" class="form-control"></select>
                                </div>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr>
                            <td width="400"><div ><label>Motivo:</label></div></td>
                            <td width="100" style="padding-left: 5px;"><div><label style="text-decoration: underline;">Providências</label></div></td>
                            <td width="200" style="padding-left: 5px;"><div><label style="text-decoration: underline;">Período</label></div></td>					
                            <td width="100" style="padding-left: 5px;"><div id="lb_transporte" name="transporte" <?php
                                    if (isset($_POST['conducao'])) {
                                        echo 'style="display: none;"';
                                    }
?>><label style="text-decoration: underline;">Vale Transporte</label></div></td>
                        </tr>				

                        <!-- Fim da linhas dos primeiros campos-->
                        <!-- Segunda linha dos campos-->
                        <tr>
                            <td width="400">
                                <div tabindex="4">
                                    <textarea id="motivo" name="motivo"   class="form-control" required rows="3" ><?php
                                if (isset($_POST['motivo'])) {
                                    echo $_POST['motivo'];
                                }
?></textarea>
                                </div>
                            </td>
                            <td width="100">
                                <table border="0" width="100%" >
                                    <tr>
                                        <td width="100"  style="padding-left: 5px;"><div tabindex="5" class="checkbox"><label><input type="checkbox"  id="almoco" <?php
                                        if (isset($_POST['almoco'])) {
                                            echo 'checked';
                                        }
?> name="almoco" >Almoço</label></div></td>
                                        <td width="100"  style="padding-left: 5px;"><div tabindex="6" class="checkbox"><label><input  type="checkbox" name="conducao" <?php
                                                    if (isset($_POST['conducao'])) {
                                                        echo 'checked';
                                                    }
                                                    ?> id="conducao" onchange="escondeDiv(this)">Condução</label></div></td>
                                    </tr>
                                    <tr>
                                        <td width="100"  style="padding-left: 5px;"><div tabindex="7" class="checkbox"><label><input id="jantar" name="jantar" type="checkbox" <?php
                                                    if (isset($_POST['jantar'])) {
                                                        echo 'checked';
                                                    }
                                                    ?>>Jantar</label></div></td>
                                        <td width="100"  style="padding-left: 5px;"><div tabindex="8" class="checkbox"><label><input id="lanche" name="lanche" type="checkbox" <?php
                                                    if (isset($_POST['lanche'])) {
                                                        echo 'checked';
                                                    }
                                                    ?> >Lanche</label></div></td>
                                    </tr>
                                </table>
                            </td>												
                            <td width="200">
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="50%" style="padding-top: 0px; padding-left: 5px;">
                                            <label for="email">Início (hh:mm):</label>
                                            <div tabindex="9" class="form-group has-default" >
                                                <input required style="line-height: 20px;" id="hora_inicio" name="hora_inicio" type="time" name="hora_inicio" value="<?php
                                                    if (isset($_POST['hora_inicio'])) {
                                                        echo $_POST['hora_inicio'];
                                                    }
                                                    ?>" class="form-control"/>
                                            </div>
                                        </td>
                                        <td width="50%" style="padding-top: 0px; padding-left: 5px;">
                                            <label for="senha">Término (hh:mm):</label>
                                            <div tabindex="10" class="form-group has-default" >
                                                <input style="line-height: 20px;" id="hora_termino" name="hora_termino" required type="time" class="form-control" placeholder="Término" value="<?php
                                                if (isset($_POST['hora_termino'])) {
                                                    echo $_POST['hora_termino'];
                                                }
                                                    ?>"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="100">
                                <div id="transporte" name="transporte" <?php
                                                if (isset($_POST['conducao'])) {
                                                    echo 'style="display: none;"';
                                                }
                                                    ?>>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td width="50%" style="padding-left: 5px;">
                                                <label>Quantidade:</label>
                                                <div tabindex="11" class="form-group has-default" >
                                                    <input id="quantidade_transporte" name="quantidade_transporte" class="form-control" placeholder="Quantidade" value="<?php
                                if (isset($_POST['quantidade_transporte'])) {
                                    echo $_POST['quantidade_transporte'];
                                }
                                                    ?>">
                                                </div>
                                            </td>
                                            <td width="50%" style="padding-left: 5px;">
                                                <label>Valor:</label>
                                                <div tabindex="12" class="form-group has-default">
                                                    <input id="valor_transporte" name="valor_transporte" class="form-control" placeholder="Valor" onkeydown="FormataMoeda(this, 10, event)" onkeypress="return maskKeyPress(event)" value="<?php
                                                    if (isset($_POST['valor_transporte'])) {
                                                        echo $_POST['valor_transporte'];
                                                    }
                                                    ?>">
                                                </div>											
                                            </td>											
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <!-- Fim da segunda linha de campos-->
                        <!-- Terceira linha de campos-->
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr>
                            <td width="400">
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="20">
                                            <div tabindex="13">
                                                <label>Colaborador</label>
                                                <input required type="text" class="form-control" id="drt" name="drt" onblur="pesquisaColaborador()"  placeholder="DRT"/>
                                            </div>
                                        </td>
                                        <td width="480">
                                            <div tabindex="14">
                                                <input required id="nome_colaborador" name="nome_colaborador" class="form-control" readonly />
                                                <input id="bairro" name="bairro" type="hidden" class="form-control" />
                                                <input id="salario" name="salario" type="hidden" class="form-control" />
                                            </div>								
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="100" style="padding-left: 5px;">
                                <div tabindex="15">
                                    <label>Descrição do Dia</label>
                                    <input id="selectDias" name="selectDias" type="hidden" value="<?php
                                                    if (isset($_POST['dias'])) {
                                                        echo $_POST['dias'];
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>">
                                    <select required="required" name="dias" id="dias" class="form-control" value="4" ></select>
                                </div>
                            </td>
                            <td width="200" style="padding-left: 5px;">
                                <div tabindex="16">
                                    <label>Aprovadores</label>
                                    <input id="selectAprovadores" name="selectAprovadores" type="hidden" value="<?php
                                    if (isset($_POST['aprovadores'])) {
                                        echo $_POST['aprovadores'];
                                    } else {
                                        echo "";
                                    }
                                                    ?>">
                                    <select required="required" id="aprovadores" name="aprovadores" class="form-control" ></select>
                                </div>					
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td><div style="display:inline-block">
                                    <div style="display: inherit;width: calc(100% - 400px);overflow: auto;">
                                        <span>
                                            <button id="btnCadastrar" name="btnCadastrar" tabindex="17" type="submit" disabled class="btn btn-primary">Cadastrar</button>
                                        </span>
                                    </div>
                                    <div style="float: right; width: 400px;">
<?php
if (isset($_SESSION['errorBox'])) {
    echo $_SESSION['errorBox'];
    unset($_SESSION['errorBox']);
}
?>

                                    </div> </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </form>
                </table>			
                </br>
                <table width="98%" style="margin-left: 5px; height: 40px; font-size: 20px; border-bottom:1px solid; line-height: 34px;">
                    <tr>
                        <td>Registros cadastrados.</td>
                    </tr>
                </table>
                <table border='0' width="98%" style="margin-left: 5px; margin-top: 5px; " >
                    <tr>
                        <td>					
                            <!-- Tabela de registros cadastrados-->
                            <div> 
                                <table id="table_historico" class="display nowrap table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>DRT</th>
                                            <th>Colaborador</th>
                                            <th>Emissão</th>
                                            <th>Data</th>
                                            <th>Setor</th>
                                            <th>Início</th>
                                            <th>Término</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>	</tbody>
                                </table> 
                            </div>
                        </td>
                    </tr>
                </table> 
            </div><!-- /.panel-->
        </div><!-- /.col-->


<?php include('../../corpo/footer.php'); ?>
        <script src="../../../js/jquery-1.11.1.min.js"></script>
        <script src="../../../includes/js/bootstrap.min.js" ></script>
        <script src="../../../js/funcoes/funcoes_hora_extra.js"></script>
        <script src="../../../js/formataReal.js"></script>
        <script src="../../../js/bootbox.js"></script>
        <script type="text/javascript" src="../../../js/jquery.bootstrap.message.js"></script>
        <script type="text/javascript" charset="utf8" src="../../../includes/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>
        <script>

                                                    $(document).ready(function () {
                                                        $('#table_historico').DataTable({
                                                            "ajax": {
                                                                "url": "../../utils/funcoes_hora_extra.php?acao=listagem",
                                                                "type": "GET",
                                                                "dataType": "json",
                                                                "data": function (d) {
                                                                    return JSON.stringify(d);
                                                                }
                                                            },

                                                            'columnDefs': [{"className": "dt-center", "targets": "_all"}],
                                                            "columns": [
                                                                {
                                                                    "className": 'details-control',
                                                                    "data": null,
                                                                    "defaultContent": ''
                                                                },
                                                                {"data": "ext_DrtFuncionario"},
                                                                {"data": "ext_NomeDoColaborador"},
                                                                {"data": "data_emissao_br"},
                                                                {"data": "data_extra_br"},
                                                                {"data": "set_Setor"},
                                                                {"data": "ext_HoraInicial"},
                                                                {"data": "ext_HoraFinal"},
                                                                {
                                                                    "data": null,
                                                                    "width": "5%",
                                                                    "responsivePriority": 2,
                                                                    "class": "vert-align text-center",
                                                                    "render": function (data, type, full, meta) {
                                                                        if (data.ext_IdSituacao == 1 || data.ext_IdSituacao == 3) {
                                                                            return "<button type='button' onClick='excluir(\"" + data.ext_idHoraExtra + "\",\"" + data.ext_NomeDoColaborador + "\")' class='btn btn-danger btn-sm' data-action='delete'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
                                                                        } else {
                                                                            return "<button disabled type='button' class='btn btn-danger btn-sm' data-action='delete'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>";
                                                                        }

                                                                    }
                                                                }
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


                                                        $('#table_historico tbody').on('click', 'td.details-control', function () {
                                                            var tr = $(this).closest('tr');

                                                            var row = $('#table_historico').DataTable().row(tr);

                                                            if (row.child.isShown()) {
                                                                row.child.hide();
                                                                tr.removeClass('shown');
                                                            } else {
                                                                row.child(formatChild(row.data())).show();
                                                                tr.addClass('shown');
                                                            }
                                                        });

                                                    });

                                                    $(document).ready(function () {
                                                        $(window).keydown(function (event) {
                                                            if (event.keyCode === 13) {
                                                                event.preventDefault();
                                                                return false;
                                                            }
                                                        });
                                                    });


        </script>

        <script type="text/javascript">
            $(function () {
                $(window).bind('hashchange', function () {
                    console.log(':D');
                }).trigger('hashchange');
            });
        </script>
    </body>
</html>