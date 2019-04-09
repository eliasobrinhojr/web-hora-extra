$(document).ready(function () {
    carregaEmpresas();

    var table = tableExtras();

    $("#sel_empresas").change(function () {
        table.ajax.url('../utils/funcoes_portaria.php?acao=listagem&empresa=' + $(this).val()).load();
    });

});

function carregaEmpresas() {
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../utils/funcoes_portaria.php',
        data: {
            acao: 'empresas'
        },
        success: function (dados) {

            $('select[name=sel_empresas]').html('');
            $('select[name=sel_empresas]').append('<option value="0"  selected>Selecione</option>');


            for (var i = 0; i < dados.length; i++) {
                if (dados.length === 1) {
                    $('select[name=sel_empresas]').append('<option selected style="padding: 5px;color: black;" value="' + dados[i].empresa.emp_idEmpresa + '">' + dados[i].empresa.emp_Descricao + '</option>');
                   
                     $('#table_historico').DataTable().ajax.url('../utils/funcoes_portaria.php?acao=listagem&empresa=' + $('#sel_empresas').val()).load();
                } else {
                    $('select[name=sel_empresas]').append('<option style="padding: 5px;color: black;" value="' + dados[i].empresa.emp_idEmpresa + '">' + dados[i].empresa.emp_Descricao + '</option>');
                }
            }

        }
    });
}

function tableExtras() {
    return  $('#table_historico').DataTable({
        "ajax": {
            "url": "../utils/funcoes_portaria.php?acao=listagem&empresa=" + 0,
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
            {"data": "data_emissao_br"},
            {"data": "data_extra_br"},
            {"data": "set_Setor"},
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
}
