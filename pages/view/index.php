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
                                <?php
                               //echo '<pre>';print_r($_SESSION);exit;
                                if (count($_SESSION['acessos']) == 0 ) {

                                    echo '<h3>Nenhum Acesso Cadastrado !</h3>';
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>



            <div  style="padding: 20px;" >
                <form id="form-id" action="#" method="post">
                    <select id="sel_empresas" style="display: none;" name="sel_empresas"></select><br><br><hr>
                    <div id="divTable" style="display: none;"> 
                        <table id="example"  class="display row-border stripe table table-striped table-bordered " style="width:100%">
                            <thead>
                                <tr>

                                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                    <th></th>
                                    <th>Colaborador</th>
                                    <th>Setor</th>
                                    <th>Emissão</th>
                                    <th>Data</th>
                                    <th>Início</th>
                                    <th>Término</th>
                                    <th>Custo</th>
                                </tr>
                            </thead>
                        </table> </div>
                </form>
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
    <script src="../../js/funcoes/funcoes_aprovar.js"></script>
    <script src="../../includes/js/bootstrap.min.js"></script>

    <script>

        var i = 1;
        var table = $('#example').DataTable({
            select: true,
            "bDestroy": true,
            dom: 'Bfrtip',
            "processing": true,
            "lengthChange": true,
            "pageLength": -1,
            "ajax": {
                "url": "../utils/funcoes_hora_extra.php?acao=listagemAprovar&empresa=" + 0,
                "type": "GET",
                "dataType": "json",
                "data": function (d) {
                    return JSON.stringify(d);
                }
            },
            "rowCallback": function (row, data) {

                if (i % 2 === 0) {
                    $('td', row).css('background-color', '#E8E8E8');
                }
                i++;
            },
            'columnDefs': [{"className": "dt-left", "targets": "_all"}, {
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'render': function (data, type, full, meta) {

                        return '<input id="checks[]" type="checkbox" name="checks[]" value="'
                                + data.ext_idHoraExtra + '">';
                    }
                },
                {
                    targets: 2,
                    render: function (data, type, row) {
                        return data;
                    }
                }, {
                    targets: 8,
                    data: 'price',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                }],
            "columns": [
                {

                    "className": 'dt-center',
                    "data": null,
                    "defaultContent": ''
                },
                {
                    "className": 'details-control dt-right',
                    "data": null,
                    "defaultContent": ''
                },
                {"data": "ext_NomeDoColaborador"},
                {"data": "set_Setor"},
                {"data": "data_emissao_br"},
                {"data": "data_extra_br"},
                {"data": "ext_HoraInicial"},
                {"data": "ext_HoraFinal"},
                {"data": "ext_CustoDaExtra"}

            ],
            buttons: [

                {
                    text: 'APROVAR',
                    className: 'green',
                    action: function () {
                        var checks = $('input:checkbox').filter(':checked');
                        var array = Array();
                        for (var i = 0; i < checks.length; i++) {
                            array.push(checks[i].value);
                        }
                        atualizaExtras(array, 2);
                    },
                    enabled: true
                },
                {
                    text: 'REJEITAR',
                    className: 'orange',
                    action: function () {
                        var checks = $('input:checkbox').filter(':checked');
                        var array = Array();
                        for (var i = 0; i < checks.length; i++) {
                            array.push(checks[i].value);
                        }
                        atualizaExtras(array, 3);
                    },
                    enabled: true
                },
                {
                    text: 'REPROVAR',
                    className: 'red',
                    action: function () {
                        var checks = $('input:checkbox').filter(':checked');
                        var array = Array();
                        for (var i = 0; i < checks.length; i++) {
                            array.push(checks[i].value);
                        }
                        atualizaExtras(array, 4);
                    },
                    enabled: true
                },
                'excelHtml5',
                'pdfHtml5'
            ],
            paging: true,
            language: {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Filtrar:",
                "pageLength": "Exibir _MENU_ records",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Ultimo",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                buttons: {
                    colvis: 'Colunas Exibir',
                    pageLength: {
                        _: "Exibir %d registros",
                        '-1': "Exibir Todos"
                    }
                }

            },
            initComplete: function () {

            }


        });

        $('#example tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = $('#example').DataTable().row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(formatChild(row.data())).show();
                tr.addClass('shown');
            }
        });
        function atualizarTable(id) {
             $('#divForms').css('display', 'none');
            table.ajax.url('../utils/funcoes_hora_extra.php?acao=listagemAprovar&empresa=' + id).load();
        }
    </script>

</html>

