$(document).ready(function () {

    $("#sel_empresas").change(function () {


        if ($('#divTable').css('display') === 'none') {
            $("#divTable").css('display', '');
        }

        atualizarTable($(this).val());
       

    });

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '../utils/funcoes_home.php',
        data: {
            acao: 'empresa_aprovar'
        },
        success: function (dados) {

            $('select[name=sel_empresas]').html('');
            $('select[name=sel_empresas]').append('<option value="0"  selected>Selecione</option>');

            if (dados.length > 0) {
                if ($('#sel_empresas').css('display') === 'none') {
                    $('#sel_empresas').css('display', '');
                }
            }

            if (dados.length === 1) {
                $('select[name=sel_empresas]').append('<option selected style="padding: 5px;color: black;" value="' + dados[0].empresa.emp_idEmpresa + '">' + dados[0].empresa.emp_Descricao + '</option>');
                if ($('#divTable').css('display') === 'none') {
                    $("#divTable").css('display', '');
                }
                atualizarTable($('#sel_empresas').val());
            } else {
                for (var i = 0; i < dados.length; i++) {

                    $('select[name=sel_empresas]').append('<option style="padding: 5px;color: black;" value="' + dados[i].empresa.emp_idEmpresa + '">' + dados[i].empresa.emp_Descricao + '</option>');

                }
            }



        }
    });


    $('#example-select-all').on('click', function (idx, rowid) {
        // Check/uncheck all checkboxes in the table
        var rows = table.rows({
            'search': 'applied'
        }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);


    });

    $('#example tbody').on('change', 'input[type="checkbox"]', function () {

        if (!this.checked) {
            var el = $('#example-select-all').get(0);
            //el.checked = false;

            if (el && el.checked && ('indeterminate' in el)) {
                el.indeterminate = true;
            }
        }
    });

});


function atualizaExtras(arr, situacao_id) {
    if (arr.length > 0) {
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '../utils/funcoes_hora_extra.php',
            data: {
                acao: 'aprovarExtras',
                ids: arr,
                situacao: situacao_id
            },
            success: function (dados) {
                alert(dados.msg);
                $('#example').DataTable().ajax.reload();
            },
            error: function (result) {

                console.log(result);
            }
        });
    } else {
        alert('selecione ao menos um registro');
    }

}