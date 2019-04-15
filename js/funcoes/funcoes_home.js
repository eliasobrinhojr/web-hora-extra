$(document).ready(function () {

    var g_empresa_id, g_nome_empresa;


    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../pages/utils/funcoes_home.php',
        data: {
            acao: 'empresas'
        },
        success: function (dados) {

            for (var i = 0; i < dados.qtd; i++) {
                $('#divForms').append("<form action='manter/hora_extra.php?acao=cadastrar' method='POST'>\n\
                                            <div class='col-md-4'>\n\
                                                <div class='panel panel-default'>\n\
                                                    <div class='panel-heading'>\n\
                                                        <input type='hidden' id='cod_empresa' name='cod_empresa' value='" + dados.empresas[i].emp_CodigoEmpresaFpw + "'/>\n\
                                                        <input type='hidden' id='id_empresa' name='id_empresa' value='" + dados.empresas[i].emp_idEmpresa + "'/>\n\
                                                        <button style='background: #fff;border: 0px;color: blue;' type='submit'>Solicitar</button>\n\
                                                        <button style='background: #fff;border: 1px;color: green;' type='button' onclick='exibeListagem(\"" + dados.empresas[i].emp_idEmpresa + "\",\"" + dados.empresas[i].emp_Descricao + "\")'>Consultar</button>\n\
                                                    </div>\n\
                                                    <div class='panel-body'>\n\
                                                        <p>" + dados.empresas[i].emp_Descricao + "</p>\n\
                                                    </div>\n\
                                                </div>\n\
                                            </div>\n\
                                        </form>");
            }
        }, error: function (result) {
            console.log(result);
        }
    });




});

function recarregaTable(situacaoID){
    $('#label_empresa').html('');
    $('#label_empresa').html(this.g_nome_empresa);

     carregaTableConsulta(this.g_empresa_id, situacaoID);
}

function exibeListagem(id_empresa, nome_empresa){
    $('#label_empresa').html('');
    $('#label_empresa').html(nome_empresa);

    this.g_empresa_id = id_empresa;
    this.g_nome_empresa = nome_empresa;

    var id_situacao = $('#sel_situacao').val();
    carregaTableConsulta(id_empresa, id_situacao);

}


function carregaTableConsulta(id_empresa, id_situacao){
   // $('#table_consulta').DataTable().clear();

    $('#table_consulta').dataTable().fnClearTable();
    $('#table_consulta').dataTable().fnDestroy();

    $('#table_consulta').DataTable({
        "ajax": {
            "url": "../utils/funcoes_hora_extra.php?acao=listagemConsulta&empresa=" + id_empresa + "&id_situacao="+id_situacao,
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

    $("#divConsulta").css("display", "block");
}

function formatChild(d) {

    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Motivo:</td>' +
            '<td>' + d.ext_Motivo + '</td>' +
            '<td>Situação:</td>' +
            '<td>' + d.sit_Tipo + '</td>' +
            '<td>Bairro:</td>' +
            '<td>' + d.ext_Bairro + '</td>' +
            '</tr>' +
            '</table>';
}

