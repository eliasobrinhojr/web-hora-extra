$(function () {

    /* */

    $("#setor").change(function () {
        $("#descricao_setor").val($("#setor option:selected").text());
    });

    // Aprovadores
    function aprovadores() {

        $.ajax({
            type: 'GET',
            url: '../../../pages/utils/funcoes_hora_extra.php',
            data: {
                acao: 'aprovadores'
            },
            dataType: 'json',
            success: function (data) {

                if (data.qtd === 1) {
                    $('#aprovadores').prop('readonly', 'readonly');
                }

                $('select[name=aprovadores]').html('');
                $('select[name=aprovadores]').append('<option disabled selected>Selecione</option>');
                for (i = 0; i < data.qtd; i++) {

                    if ($('#selectAprovadores').val() === data.id[i]) {
                        $('select[name=aprovadores]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else if (data.qtd > 1) {
                        $('select[name=aprovadores]').append('<option value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else {
                        $('select[name=aprovadores]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    }



                }
            }, error: function (result) {
                console.log(result);
            }
        });
    }
    aprovadores();

    // setor
    function setor() {
        $.ajax({
            type: 'GET',
            url: '../../../pages/utils/funcoes_hora_extra.php',
            data: {
                acao: 'setor'
            },
            dataType: 'json',
            beforeSend: function () {
                $('select[name=setor]').html('<option>Carregando...</option>');
            },
            success: function (data) {
                $('select[name=setor]').html('');
                $('select[name=setor]').append('<option  disabled selected>Selecione</option>');

                if (data.qtd === 1) {
                    $('#setor').prop('readonly', 'readonly');
                }

                for (i = 0; i < data.qtd; i++) {


                    if ($('#selectSetor').val() === data.id[i]) {
                        $('select[name=setor]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else if (data.qtd > 1) {
                        $('select[name=setor]').append('<option value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else {
                        $('select[name=setor]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    }


                }
                $("#descricao_setor").val($("#setor option:selected").text());

            }, error: function (result) {
                console.log(result);
            }
        });
    }
    setor();

    // desc_dias
    function dias() {


        $.ajax({
            type: 'GET',
            url: '../../../pages/utils/funcoes_hora_extra.php',
            data: {
                acao: 'desc_dias'
            },
            dataType: 'json',
            beforeSend: function () {
                $('select[name=dias]').html('<option>Carregando...</option>');
            },
            success: function (data) {

                if (data.qtd === 1) {
                    $('#dias').prop('readonly', 'readonly');
                }

                $('select[name=dias]').html('');
                $('select[name=dias]').append('<option disabled selected>Selecione</option>');
                for (i = 0; i < data.qtd; i++) {

                    if ($('#selectDias').val() === data.id[i]) {
                        $('select[name=dias]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else if (data.qtd > 1) {
                        $('select[name=dias]').append('<option value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    } else {
                        $('select[name=dias]').append('<option selected value="' + data.id[i] + '">' + data.descricao[i] + '</option>');
                    }
                }
            }, error: function (result) {
                console.log(result);
            }
        });
    }
    dias();

    function getEmpresaPorId() {

        $.ajax({
            type: 'GET',
            url: '../../../pages/utils/funcoes_hora_extra.php',
            data: {
                acao: 'empresaById',
                id: $("#id_empresa").val()
            },
            dataType: 'json',
            success: function (data) {

                for (i = 0; i < data.qtd; i++) {
                    $("#descricao_empresa").val(data.fpw[i] + " - " + data.descricao[i]);
                }
            }, error: function (result) {
                console.log(result);
            }
        });
    }
    getEmpresaPorId();

    $("#drt").on('keyup', function (e) {
        if (e.keyCode === 13) {
            pesquisaColaborador();
        }
    });

});

function escondeDiv(checkboxElem) {
    if (checkboxElem.checked) {
        $('#transporte').hide();
        $('#valor_transporte').val("");
        $('#quantidade_transporte').val("");
        $('#lb_transporte').hide();
    } else {
        $('#transporte').show();
        $('#lb_transporte').show();
    }
}

function pesquisaColaborador() {

    var drt = $('#drt').val();
    var conexao = "SP";

    if ($('#conexao_base').val() == 'CEMAZ_AM') {
        conexao = "AM";
    }

    if (drt !== '') {

        $.ajax({
            type: 'GET',
            url: 'http://dev.grupois.mao/horaextra/funcionarios/listar.php',
            dataType: 'json',
            data: {
                uf: conexao,
                drt: $('#drt').val(),
                emp: $('#cod_empresa').val()
            },
            success: function (data) {
                console.log(data);
                if (data.data[0] !== undefined) {
                    $("#nome_colaborador").val(data.data[0].nome);
                    $("#bairro").val(data.data[0].bairro);
                    $("#salario").val(data.data[0].salario);
                    $('#btnCadastrar').prop('disabled', '');
                } else {
                    $("#nome_colaborador").val('');
                }

            }, error: function (result) {
                console.log(result);
            }
        });

    } else {
        $("#nome_colaborador").val('');
    }
}


function validaDataSelecionada(event) {
    var data_extra = event.value;
    var data_emissao = document.getElementById("data_emissao").value;

    var dataExtraVerificar = new Date(data_extra);

    verificaUteisData(dataExtraVerificar);
}

function verificaUteisData(data) {
    var ano = data.getFullYear();
    var mes = data.getMonth() + 1;


    $.ajax({
        type: 'GET',
        url: '../../../pages/utils/funcoes_hora_extra.php',
        data: {
            acao: 'verificaUteis',
            ano: ano,
            mes: mes
        },
        dataType: 'json',
        success: function (data) {

            console.log(data);

            if (data.qtd === 0) {
                if (!alert("Não há registro de dias Úteis para o Mês Atual !!"))
                    document.location = '../index.php';
            } else {
                console.log(data);
            }

        }, error: function (result) {
            console.log(result);
        }
    });
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

function excluir(id, nome) {
    bootbox.confirm("Deseja excluir a hora extra do colaborador " + nome + " ?", function (result) {
        if (result) {
            $.ajax({
                type: 'GET',
                url: '../../../pages/utils/manter_hora_extra.php',
                data: {
                    acao: 'excluir',
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('#table_historico').DataTable().ajax.reload();
                    } else {
                        alert('erro ao excluir registro do bd !');
                    }
                }, error: function (result) {
                    console.log(result);
                }
            });
        }
    });

}
