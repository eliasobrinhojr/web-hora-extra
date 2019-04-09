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
    carregaComboEmpresas(new Array());
    $('#descricao').val('');
}


function verificaSetorEmpresa(obj) {
    var array_emp = new Array();
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_setores.php',
        data: {
            acao: 'verificaSetorEmpresa',
            descricao_setor: obj.value
        },
        success: function (dados) {
            for (var i = 0; i < dados.qtd; i++) {
                array_emp.push(dados[i].setor.set_idEmpresa);
            }
            carregaComboEmpresas(array_emp);
        }
    });
}


function carregaComboEmpresas(array_emp) {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_setores.php',
        data: {
            acao: 'empresa'
        },
        success: function (dados) {
            var filtrados = dados.empresas.filter(f => !array_emp.includes(f.emp_idEmpresa));

            $('select[name=empresas]').html('');
            $('select[name=empresas]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < filtrados.length; i++) {
                $('select[name=empresas]').append('<option style="padding: 5px;color: black;" value="' + filtrados[i].emp_idEmpresa + '">' + filtrados[i].emp_Descricao + '</option>');
            }


        }
    });
}


function excluir(id) {
    bootbox.confirm("Excluir ?", function (result) {
        if (result) {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '../../utils/funcoes_setores.php',
                data: {
                    acao: 'excluirSetor',
                    id: id
                },
                success: function (dados) {
                    carregaTable();
                    alert(dados.msg);

                    //$('#myModal').modal('hide');
                }, error: function (result) {
                    carregaTable();
                    alert('error, contate o suporte !');
                  
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
        url: '../../utils/funcoes_setores.php', //arquivo onde serão buscados os dados
        data: {
            acao: 'setorEmpresa'
        },
        success: function (dados) {
            $('#tabela').empty();
            for (var i = 0; i < dados.qtd; i++) {
                //Adicionando registros retornados na tabela
                $('#tabela').append('<tr><td>' + dados.empresa[i] + '</td><td>' + dados.descricao[i] + '</td><td><button type="button" onClick="excluir(' + dados.id[i] + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function salvar() {

    var array_empresas = new Array();
    var msg = '';

    $('#empresas option:selected').each(function () {
        if ($(this).val() !== 'Selecione') {
            array_empresas.push($(this).val());
        }
    });


    if (array_empresas.length === 0) {
        msg += 'Selecione uma Empresa!';
    }
    if ($('#descricao').val() === '') {
        msg += '\nDescrição Setor!';
    }

    if ($('#descricao').val() !== '' && array_empresas.length > 0) {

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../../utils/funcoes_setores.php',
            data: {
                acao: 'salvarSetor',
                empresas: array_empresas,
                descricao: $('#descricao').val()
            },
            success: function (dados) {
                init();
                alert(dados.msg);
                $("#form").trigger('reset');
            }, error: function (result) {
                $('#label-alert').hide();
                alert('erro, contate o suporte !');
                console.log(result);
            }
        });

    }

    if (msg !== '') {
       alert(msg);
    }
    msg = '';

}

