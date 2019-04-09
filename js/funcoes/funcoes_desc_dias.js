$(document).ready(function () {
    init();
    $("#form").validate({
        rules: {
            descricao: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            descricao: {
                required: "Por favor, informe o nome do setor",
                minlength: "A descrição deve ter pelo menos 2 caracteres"
            }
        }
    });
});

function init() {
    carregaTable();
    carregaComboCustoEncargos();
}

function carregaComboCustoEncargos() {
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_desc_dias.php',
        data: {
            acao: 'custoencargo'
        },
        success: function (dados) {

            $('select[name=custoencargo]').html('');
            $('select[name=custoencargo]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {
                $('select[name=custoencargo]').append('<option style="padding: 5px;" value="' + dados[i].custo.enc_idCustoDeEncargos + '">' + dados[i].custo.enc_Descricao + '</option>');
            }
        }
    });
}

function validaDescricao(event) {
    alert(event.value);
    carregaComboCustoEncargos();
}

function excluir(id) {

    bootbox.confirm("Excluir ?", function (result) {
        if (result) {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '../../utils/funcoes_desc_dias.php',
                data: {
                    acao: 'excluirDescDias',
                    id: id
                },
                success: function (dados) {
                    carregaTable();
                    $('#label-alert').hide();
                    $().message({
                        type: 'success',
                        html: dados.msg,
                        position: 'top-right'});
                    //$('#myModal').modal('hide');
                }, error: function (result) {
                    carregaTable();
                    $('#label-alert').hide();
                    $().message({
                        type: 'danger',
                        html: 'erro, contate o suporte !',
                        position: 'top-right'});
                    console.log(result);
                }
            });
        }
    });
}

function carregaTable() {
    $('#tabela').empty(); //Limpando a tabela
    $.ajax({
        type: 'get', // método HTTP usado
        dataType: 'json', // tipo de retorno
        url: '../../utils/funcoes_desc_dias.php', //arquivo onde serão buscados os dados
        data: {
            acao: 'encargoDias'
        },
        success: function (dados) {
            $('#tabela').empty();
            for (var i = 0; i < dados.qtd; i++) {
                //Adicionando registros retornados na tabela
                $('#tabela').append('<tr><td>' + dados.enc_descricao[i] + '</td><td>' + dados.dia_descricao[i] + '</td><td><button type="button" onClick="excluir(' + dados.id[i] + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function salvar() {

    var msg = '';
    var id_custo = '';

    id_custo = $('#custoencargo option:selected').val();

    if (id_custo === 'Selecione') {
        msg += 'Selecione um custo!';
    }
    if ($('#descricao').val() === '') {
        msg += '\n Descrição de Dia!';
    }

    if ($('#descricao').val() !== '' && id_custo !== 'Selecione') {

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../../utils/funcoes_desc_dias.php',
            data: {
                acao: 'salvarDescDias',
                id_custo: id_custo,
                descricao: $('#descricao').val()
            },
            success: function (dados) {
                init();
                $('#label-alert').hide();
                $().message({
                    type: 'success',
                    html: dados.msg,
                    position: 'top-right'});
                $("#form").trigger('reset');
            }, error: function (result) {
                $('#label-alert').hide();
                $().message({
                    type: 'danger',
                    html: 'error, contate o suporte !',
                    position: 'top-right'});
                console.log(result);
            }
        });

    }

    if (msg !== '') {
        $('#label-alert').hide();
        $().message({
            type: 'danger',
            html: msg,
            position: 'top-right'});
    }

    msg = '';
}