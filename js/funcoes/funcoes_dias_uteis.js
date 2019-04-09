$(document).ready(function () {
    init();
    $("#empresas").change(function () {
        carregaTable($('#empresas').val());
        carregaComboAnos();
        carregaComboMeses(2099);
        $("select[name=ano]").prop("disabled", false);
    });

    $("#ano").change(function () {
        carregaComboMeses($("#ano").val());
        $("select[name=mes]").prop("disabled", false);
    });
});

//carregar combo ano via js
function init() {
    carregaTable(0);
    carregaComboEmpresas(0);
    carregaComboAnos();
     carregaComboMeses(2099);
}


function carregaComboMeses(ano) {

    var id_empresa = 0;
    if($('#empresas').val() !== null){
        id_empresa = $('#empresas').val();
    }
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_dias_uteis.php',
        data: {
            acao: 'meses',
            ano: ano,
            empresa: id_empresa
        },
        success: function (dados) {

            if (dados.mesPorAno !== undefined) {

                var filtrados = dados.meses.filter(f => !dados.mesPorAno.includes(f.numeroMes));

                $('select[name=mes]').html('');
                $('select[name=mes]').append('<option disabled selected>Selecione</option>');

                for (var i = 0; i < filtrados.length; i++) {
                    $('select[name=mes]').append('<option style="padding: 5px;color: black;" value="' + filtrados[i].numeroMes + '">' + filtrados[i].nomeMes + '</option>');
                }

            } else {
                $('select[name=mes]').html('');
                $('select[name=mes]').append('<option disabled selected>Selecione</option>');

                for (var i = 0; i < dados.meses.length; i++) {
                    $('select[name=mes]').append('<option style="padding: 5px;color: black;" value="' + dados.meses[i].numeroMes + '">' + dados.meses[i].nomeMes + '</option>');
                }
            }
        }
    });
}
function carregaComboEmpresas() {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_dias_uteis.php',
        data: {
            acao: 'empresa'
        },
        success: function (dados) {

            $('select[name=empresas]').html('');
            $('select[name=empresas]').append('<option disabled value="0" selected>Selecione</option>');

            for (var i = 0; i < dados.qtd; i++) {
                $('select[name=empresas]').append('<option style="padding: 5px;color: black;" value="' + dados.empresas[i].emp_idEmpresa + '">' + dados.empresas[i].emp_Descricao + '</option>');
            }

        }
    });
}

function carregaComboAnos() {

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_dias_uteis.php',
        data: {
            acao: 'anos'
        },
        success: function (dados) {

            $('select[name=ano]').html('');
            $('select[name=ano]').append('<option disabled selected>Selecione</option>');

            for (var i = 0; i < dados.anos.length; i++) {
                $('select[name=ano]').append('<option style="padding: 5px;color: black;" value="' + dados.anos[i] + '">' + dados.anos[i] + '</option>');
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
                url: '../../utils/funcoes_dias_uteis.php',
                data: {
                    acao: 'excluirDiu',
                    id: id
                },
                success: function (dados) {
                    carregaTable($('#empresas').val());
                }, error: function (result) {
                    carregaTable($('#empresas').val());
                  
                    alert('error, contate o suporte !');
                    console.log(result);
                }
            });
        }
    });
}

function carregaTable(id_empresa) {
    $('#tabela').empty(); //Limpando a tabela
    $.ajax({
        type: 'get', // método HTTP usado
        dataType: 'json', // tipo de retorno
        url: '../../utils/funcoes_dias_uteis.php', //arquivo onde serão buscados os dados
        data: {
            acao: 'listaDiasUteis',
            idEmpresa: id_empresa
        },
        success: function (dados) {
            $('#tabela').empty();

            for (var i = 0; i < dados.qtd; i++) {
                //Adicionando registros retornados na tabela
                $('#tabela').append('<tr><td>' + mesExnteso(dados.lista[i].diu_Mes) + '</td><td>' + dados.lista[i].diu_Ano + '</td><td>' + dados.lista[i].diu_QtdeDiasUteis + '</td><td>' + dados.lista[i].diu_QtdeDeDomingos + '</td><td>' + dados.lista[i].diu_QtdeFeriados + '</td><td><button type="button" onClick="excluir(' + dados.lista[i].diu_idDiasUteis + ')" class="btn btn-danger btn-sm" data-action="delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button></td></tr>');
            }
        }
    });
}

function mesExnteso(mes) {
    var mes_extenso = '';

    switch (mes) {
        case '1':
            mes_extenso = 'Janeiro';
            break;
        case '2':
            mes_extenso = 'Fevereiro';
            break;
        case '3':
            mes_extenso = 'Março';
            break;
        case '4':
            mes_extenso = 'Abril';
            break;
        case '5':
            mes_extenso = 'Maio';
            break;
        case '6':
            mes_extenso = 'Junho';
            break;
        case '7':
            mes_extenso = 'Julho';
            break;
        case '8':
            mes_extenso = 'Agosto';
            break;
        case '9':
            mes_extenso = 'Setembro';
            break;
        case '10':
            mes_extenso = 'Outubro';
            break;
        case '11':
            mes_extenso = 'Novembro';
            break;
        case '12':
            mes_extenso = 'Dezembro';
            break;
        default:
            mes_extenso = 'inválido';
    }

    return mes_extenso;

}

function salvar() {

    var id_empresa = $('#empresas').val();
    var ano = $('#ano').val();
    var mes = $('#mes').val();
    var uteis = $('#qtdUteis').val();
    var domingos = $('#qtdDomingos').val();
    var feriados = $('#qtdFeriados').val();

    var msg = '';


    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../../utils/funcoes_dias_uteis.php',
        data: {
            acao: 'salvarDiasUteis',
            empresa: id_empresa,
            ano: ano,
            mes: mes,
            qtdUteis: uteis,
            qtdDomingos: domingos,
            qtdFeriados: feriados
        },
        success: function (dados) {
            carregaTable(id_empresa);
            alert(dados.msg);
            $('#qtdUteis').val(0);
            $('#qtdDomingos').val(0);
            $('#qtdFeriados').val(0);
            carregaComboAnos();
            carregaComboMeses(2099);

        }, error: function (result) {
            
            alert('error, contate o suporte !');
         
            console.log(result);
        }
    });



    if (msg !== '') {
       alert(msg);
    }
    msg = '';

}

