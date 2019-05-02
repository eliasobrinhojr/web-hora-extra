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
                                                        <input type='hidden' id='conexao_base' name='conexao_base' value='" + dados.empresas[i].emp_ConexaoBase + "'/>\n\
                                                        <button style='background: #fff;border: 0px;color: blue;' type='submit'>Acessar</button>\n\
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

