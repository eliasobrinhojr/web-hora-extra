$(document).ready(function () {
    init();

    $(document).ready(function () {
        $("#usuarios").change(function () {
            carregaComboEmpresas($("#usuarios").val());
        });


    });
});

function init() {
    carregaTable();
    carregaComboEmpresas(0);
    carregaComboUsuarios();
}
function excluir(id) {
    bootbox.confirm("Excluir ?", function (result) {
        if (result) {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '../../utils/funcoes_aprovadores.php',
                data: {
                    acao: 'excluirAprovador',
                    id: id
                },
                success: function (dados) {
                    carregaTable();
                    $('#label-alert').hide();
                    $().message({
                        type: 'success',
                        html: dados.msg,
                        position: 'top-right'});
                }, error: function (result) {
                    carregaTable();
                    $('#label-alert').hide();
                    $().message({
                        type: 'danger',
                        html: "error, contate o suporte!",
                        position: 'top-right'});
                    console.log(result);
                }
            });
        }
    });
}

function carregaComboUsuarios() {
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_aprovadores.php',
        data: {
            acao: 'listaUsuarios'
        },
        success: function (dados) {

            $('select[name=usuarios]').html('');
            $('select[name=usuarios]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {
                $('select[name=usuarios]').append('<option style="padding: 5px;" value=' + dados.usuario[i].log_idLogin + '>' + dados.usuario[i].log_NomeCompleto + '</option>');
            }
        }
    });
}

function carregaComboEmpresas(user_selecionado) {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_aprovadores.php',
        data: {
            acao: 'empresa',
            id: user_selecionado
        },
        success: function (dados) {


            console.log(dados);


            $('select[name=empresas]').html('');
            $('select[name=empresas]').append('<option disabled>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {


                if (user_selecionado !== 0 && dados.qtdAprovadores > 0) {

                    var ids = dados.aprovadores.map(function (item) {
                        return item['apr_idEmpresa'];
                    });


                    var existe = jQuery.inArray(dados.empresas[i].emp_idEmpresa, ids);
                    if (existe !== -1) {
                        $('select[name=empresas]').append('<option style="padding: 5px; color: green;" disabled value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
                    } else {
                        $('select[name=empresas]').append('<option style="padding: 5px; color: black;" value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
                    }


                } else {
                    $('select[name=empresas]').append('<option style="padding: 5px; color: black;" value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
                }


            }
        }
    });
}

function carregaTable() {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_aprovadores.php',
        data: {
            acao: 'aprovadorEmpresa'
        },
        success: function (dados) {
            $('#tabela').empty();
            for (var i = 0; i < dados.qtd; i++) {

                $('#tabela').append('<tr><td>' + dados.empresa[i] + '</td><td>' + dados.nome[i] + '</td><td><button type="button" onClick="excluir(' + dados.id[i] + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function salvar() {

    var array_empresas = new Array();
    var msg = '';

    $('#empresas option:selected').each(function () {
        if ($(this).val() != 'Selecione') {
            array_empresas.push($(this).val());
        }
    });


    if (array_empresas.length == 0) {
        msg += 'Selecione uma Empresa!';
    }
    if ($('#usuarios').val() == null) {
        msg += '\nSelecione um Usuário!';
    }

    if ($('#usuarios').val() != null && array_empresas.length > 0) {
        var nomeUsuario = $("#usuarios :selected").text();
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../../utils/funcoes_aprovadores.php',
            data: {
                acao: 'salvarAprovador',
                empresas: array_empresas,
                id_usuario: $('#usuarios').val(),
                nome_usuario: nomeUsuario
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
                    html: 'error, contate o suporte!',
                    position: 'top-right'});
                console.log(result);
            }
        });

    }

    if (msg != '') {
        $('#label-alert').hide();
        $().message({
            type: 'danger',
            html: msg,
            position: 'top-right'});
    }

    msg = '';




}