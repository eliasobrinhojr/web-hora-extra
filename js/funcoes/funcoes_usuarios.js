$(document).ready(function () {

    init();

    $("#form").validate({
        rules: {
            login: {
                required: true,
                minlength: 2
            },
            nome_completo: {
                required: true
            },
            senha: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            login: {
                required: "Por favor, informe o login do usuário",
                minlength: "O login deve ter pelo menos 2 caracteres"
            },
            nome_completo: {
                required: "Por favor, informe o nome do usuário"
            },
            senha: {
                required: "Por favor, informe a senha do usuário",
                minlength: "A senha deve ter pelo menos 2 caracteres"
            }
        }
    });

    $("#usuarios").change(function () {
        carregaComboTipoAcesso();
        // carregaComboEmpresa();
    });
    $("#tipo_acesso").change(function () {
        carregaComboEmpresa();
    });


});

function init() {
    carregaTableUsuarios();
    carregaTableAcessos();
    carregaComboUsuario();
    //carregaAcessos();
}

function getEmpresasAssociadas(id) {

//    

    var text = "";

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_usuarios.php',
        data: {
            id_user: id,
            acao: 'empresasPorUsuario'
        },
        success: function (dados) {
            //console.log(dados);

            for (var i = 0; i < dados.qtd; i++) {
                text += dados.empresas[i].emp_Descricao;
            }
            console.log(text);

        },
        complete: function () {
            return "text";
        }
    });

}

function carregaAcessos() {
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_usuarios.php',
        data: {
            acao: 'acessos'
        },
        success: function (dados) {

            var usuarios = [];

            //console.log(teste);

            var div = document.getElementById('div_acessos');
            div.innerHTML = "";


            for (var i = 0; i < dados.qtd; i++) {
                usuarios.push({id: dados.usuarios[i].log_idLogin, nome: dados.usuarios[i].log_NomeCompleto});

            }

            usuarios = usuarios.filter((thing, index, self) =>
                index === self.findIndex((t) => (t.id === thing.id)));

            //  console.log(usuarios);

            usuarios.forEach(function callback(value) {
                div.innerHTML += "<details> \n\
                                    <summary>  " + value.nome + " </summary>\n\
                                    <br>\n\
                                    <p> Empresa 1 - <b>RH / T.I </b> </p>\n\
                                  </details><hr>";



            });

        }
    });
}



function carregaComboEmpresa() {

    var user_id = $('#usuarios').val();

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_usuarios.php',
        data: {
            acao: 'empresa',
            id: user_id
        },
        success: function (dados) {

            $('select[name=empresas]').html('');
            $('select[name=empresas]').append('<option disabled selected>Selecione</option>');

            if (user_id !== 0 && dados.qtdAcesso > 0) {


                var idsEmpresaJaPossuiAcesso = dados.acessos.filter(function (item) {
                    return item.acs_IdTipoDeAcesso === $('#tipo_acesso').val();
                });
                var idsEmpresa = idsEmpresaJaPossuiAcesso.map(function (item) {
                    return item['acs_idEmpresa'];
                });


                for (var i = 0; i < dados.qtd; i++) {

                    var existeEmpresa = jQuery.inArray(dados.empresas[i].emp_idEmpresa, idsEmpresa);
                    if (existeEmpresa !== -1) {
                        $('select[name=empresas]').append('<option style="padding: 5px; color: green;" disabled value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
                    } else {
                        $('select[name=empresas]').append('<option style="padding: 5px; color: black;" value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
                    }
                }

            } else {
                for (var i = 0; i < dados.qtd; i++) {
                    $('select[name=empresas]').append('<option style="padding: 5px; color: black;" value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');

                }
            }


            $("select[name=empresas]").prop("disabled", false);

        }
    });
}

function carregaComboTipoAcesso() {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_usuarios.php',
        data: {
            acao: 'tipoAcesso'
        },
        success: function (dados) {

            $('select[name=tipo_acesso]').html('');
            $('select[name=tipo_acesso]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {
                $('select[name=tipo_acesso]').append('<option style="padding: 5px;color: black;" value="' + dados[i].acesso.tip_idTipoDeAcesso + '">' + dados[i].acesso.tip_Tipo + '</option>');
            }

            $("select[name=tipo_acesso]").prop("disabled", false);
        }
    });
}

function carregaComboUsuario() {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_usuarios.php',
        data: {
            acao: 'listaUsuarios'
        },
        success: function (dados) {


            $('select[name=usuarios]').html('');
            $('select[name=usuarios]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {
                $('select[name=usuarios]').append('<option style="padding: 5px;color: black;" value="' + dados.id[i] + '">' + dados.nomeCompleto[i] + '</option>');
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
                url: '../../utils/funcoes_usuarios.php',
                data: {
                    acao: 'excluirUsuario',
                    id: id
                },
                success: function (dados) {
                    init();
                    $().message({
                        type: 'success',
                        html: dados.msg,
                        position: 'top-right'
                    });
                    //$('#myModal').modal('hide');
                },
                error: function (result) {
                    init();
                    $().message({
                        type: 'danger',
                        html: 'error, contate o suporte!',
                        position: 'top-right'
                    });
                    console.log(result);
                }
            });
        }
    });
}

function excluirAcesso(id) {
    bootbox.confirm("Excluir ?", function (result) {
        if (result) {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '../../utils/funcoes_usuarios.php',
                data: {
                    acao: 'excluirAcesso',
                    id: id
                },
                success: function (dados) {
                    init();
                    $().message({
                        type: 'success',
                        html: dados.msg,
                        position: 'top-right'
                    });
                    //$('#myModal').modal('hide');
                },
                error: function (result) {
                    init();
                    $().message({
                        type: 'danger',
                        html: 'error, contate o suporte!',
                        position: 'top-right'
                    });
                    console.log(result);
                }
            });
        }
    });

}

function carregaTableUsuarios() {
    $('#tabela').empty(); //Limpando a tabela
    $.ajax({
        type: 'get', // método HTTP usado
        dataType: 'json', // tipo de retorno
        url: '../../utils/funcoes_usuarios.php', //arquivo onde serão buscados os dados
        data: {
            acao: 'listaUsuarios'
        },
        success: function (dados) {
            $('#tabela').empty();
            for (var i = 0; i < dados.qtd; i++) {
                //Adicionando registros retornados na tabela
                $('#tabela').append('<tr><td>' + dados.login[i] + '</td><td>' + dados.nomeCompleto[i] + '</td><td><button type="button" onClick="excluir(' + dados.id[i] + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function carregaTableAcessos() {
    $('#tabela').empty(); //Limpando a tabela
    $.ajax({
        type: 'get', // método HTTP usado
        dataType: 'json', // tipo de retorno
        url: '../../utils/funcoes_usuarios.php', //arquivo onde serão buscados os dados
        data: {
            acao: 'listaAcessos'
        },
        success: function (dados) {

            $('#tabela_acesso').empty();
            for (var i = 0; i < dados.qtd; i++) {
                //Adicionando registros retornados na tabela
                $('#tabela_acesso').append('<tr><td>' + dados[i].acesso.emp_Descricao + '</td><td>' + dados[i].acesso.tip_Tipo + '</td><td>' + dados[i].acesso.log_Login + '</td><td><button type="button" onClick="excluirAcesso(' + dados[i].acesso.acs_idAcesso + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function salvar() {

    var msg = '';

    if ($('#login').val() === '') {
        msg += 'Login nao pode ser vazio!';
    }
    if ($('#nome_completo').val() === '') {
        msg += '\nNome nao pode ser vazio!';
    }
    if ($('#senha').val() === '') {
        msg += '\nsenha nao pode ser vazio!';
    }

    if ($('#login').val() !== '' && $('#nome_completo').val() !== '' && $('#senha').val() !== '') {


        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../../utils/funcoes_usuarios.php',
            data: {
                acao: 'salvarUsuario',
                login: $('#login').val(),
                nomeCompleto: $('#nome_completo').val(),
                senha: $('#senha').val()
            },
            success: function (dados) {
                init();
                $().message({
                    type: 'success',
                    html: dados.msg,
                    position: 'top-right'
                });
                $('#myModal').modal('hide');
                $("#form").trigger('reset');

            },
            error: function (result) {
                init();
                $().message({
                    type: 'danger',
                    html: 'error, contate o suporte !',
                    position: 'top-right'
                });
                console.log(result);
            }
        });



    }

    if (msg !== '') {
        $().message({
            type: 'danger',
            html: msg,
            position: 'top-right'
        });
    }

    msg = '';

}

function salvarAcesso() {
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
    if ($('#usuarios').val() === null) {
        msg += '\nSelecione um Usuário!';
    }

    if ($('#usuarios').val() !== null && array_empresas.length > 0) {

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../../utils/funcoes_usuarios.php',
            data: {
                acao: 'salvarAcesso',
                empresas: array_empresas,
                id_usuario: $('#usuarios').val(),
                id_tipo_acesso: $('#tipo_acesso').val()
            },
            success: function (dados) {
                $('#modalAcesso').modal('hide');
                init();
                $().message({
                    type: 'success',
                    html: dados.msg,
                    position: 'top-right'
                });
            },
            error: function (result) {
                init();
                $().message({
                    type: 'danger',
                    html: 'error, contate o suporte!',
                    position: 'top-right'
                });

                console.log(result);
            }
        });
    }




    if (msg !== '') {
        $().message({
            type: 'danger',
            html: msg,
            position: 'top-right'
        });
    }

    msg = '';
}