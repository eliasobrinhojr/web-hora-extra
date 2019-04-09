<?php

try {
    $pdo = new PDO('mysql:host=srvmaodb;dbname=dbhoraextra', 'user_horaextra', 'horaextra');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
$errorBox = 'errorBox';


if ($_GET['acao'] == 'salvar') {

    $sql = $pdo->prepare("SELECT * FROM `tab_horaextra` WHERE `ext_IdSituacao` = 1 
                                    and ext_DrtFuncionario = " . $_POST['drt'] . " 
                                    and ext_IdEmpresa = " . $_SESSION['empresa_click'] . " 
                                    and ext_DataHoraExtra = '" . $_POST['data_extra'] . "'");
    $sql->execute();
    $registros = $sql->rowCount();

    //verifica extras existentes por drt, empresa e data.. 
    if ($registros > 0) {
        $_SESSION[$errorBox] = " <div class='alert alert-danger alert-dismissible' style='visibility: visible; width: 100%; text-align: center;'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Colaborador " . $nome_completo . " ja possui solicitação em aberto.</strong>
                                </div>";
    } else {
        $somaCustoParaCalculo = 0;

        $id_empresa = $_SESSION['empresa_click'];
        $id_login = $_SESSION['usuarioId'];
        $id_situacao = 1;
        $drt = $_POST['drt'];

        $bairro = $_POST['bairro'];
        $salario = $_POST['salario'];


        $evento = 'inserido por ' . $_SESSION['usuarioNome'] . ' em ' . date('d/m/Y');
        $statusRegistro = 'A';


        //input type text
        $desc_empresa = $_POST['descricao_empresa'];
        $motivo = $_POST['motivo'];
        $nome_colaborador = $_POST['nome_colaborador'];

        //input type date
        $data_emissao = $_POST['data_emissao'];
        $data_extra = $_POST['data_extra'];


        //horarios
        $hora_inicio = $_POST['hora_inicio'];
        $hora_termino = $_POST['hora_termino'];


        $partes = explode("-", $data_extra);
        $ano = $partes[0];
        $mes = $partes[1];

        $sql_dias = $pdo->prepare("select * from tab_diasuteis where diu_mes = '" . $mes . "' and diu_ano = '" . $ano . "' and diu_idEmpresa = " . $_SESSION['empresa_click']);
        $sql_dias->execute();
        $n = 0;

        while ($ln = $sql_dias->fetchObject()) {
            $obj_dias = $ln;
        }


        //vale transporte
        $transporte_valor = !isset($_POST['valor_transporte']) ? $_POST['valor_transporte'] : 0;
        $transporte_quantidade = !isset($_POST['quantidade_transporte']) ? $_POST['quantidade_transporte'] : 0;

        //troca caracter de , para . (campo do banco é float)
        $transporte_valor = str_replace(",", ".", $transporte_valor);
        $somaCustoParaCalculo += ($transporte_valor * $transporte_quantidade);

        //select options
        $setor = $_POST['setor'];
        $aprovador = $_POST['aprovadores'];
        $desc_dia = $_POST['dias'];


        $sql_encargos = $pdo->prepare("select enc_BaseDeCalculo from tab_custoencargos where enc_idCustoDeEncargos = " . $desc_dia);
        $sql_encargos->execute();
        $obj_encargo = $sql_encargos->fetchObject();

        //checkbox providencias
        if (isset($_POST['almoco'])) {
            $almoco = 1;
            $somaCustoParaCalculo += 14;
        } else {
            $almoco = 0;
        }

        $conducao = isset($_POST['conducao']) ? 1 : 0;

        if (isset($_POST['jantar'])) {
            $jantar = 1;
            $somaCustoParaCalculo += 11;
        } else {
            $jantar = 0;
        }

        $lanche = isset($_POST['lanche']) ? 1 : 0;


        $valor_hora = ($salario / 220);
        $qtd_horas = ($hora_termino - $hora_inicio);
        $qtd_horas = ($qtd_horas > 5 ? $qtd_horas -= 1 : $qtd_horas);


        //$valorDia = floor($valor_hora * $qtd_horas);
        $valorComEncargosAposOitoHoras = 0;

        if ($qtd_horas > 8) {
            for ($i = 8; $i > 0; $i--) {
                $qtd_horas--;
            }
            $valorComEncargosAposOitoHoras = ($valor_hora * 150 / 100) * $qtd_horas;
        }

        $valorHoraComTipoDia = ((($valor_hora * $obj_encargo->enc_BaseDeCalculo) / 100) + $valorComEncargosAposOitoHoras);

        $dsr = (($salario / $obj_dias->diu_QtdeDiasUteis) * ($obj_dias->diu_QtdeDeDomingos + $obj_dias->diu_QtdeFeriados));
        $total = (($somaCustoParaCalculo + $dsr + $valorHoraComTipoDia) / $obj_dias->diu_QtdeDiasUteis);

        $custo_extra = number_format($total, 2, ".", "");


        $string_sql = "INSERT INTO tab_horaextra 
                    (ext_idAprovadores,
                    ext_idDescricaoDia,
                    ext_IdEmpresa, 
                    ext_IdSetor, 
                    ext_IdLogin, 
                    ext_IdSituacao, 
                    ext_DataCadastro, 
                    ext_DataHoraExtra, 
                    ext_HoraInicial, 
                    ext_HoraFinal, 
                    ext_DrtFuncionario, 
                    ext_NomeDoColaborador, 
                    ext_Motivo, 
                    ext_Bairro, 
                    ext_QtdeValeTransporte, 
                    ext_ValorValeTransporte, 
                    ext_ProvidenciaAlmoco, 
                    ext_ProvidenciaLanche, 
                    ext_ProvidenciaJantar, 
                    ext_ProvidenciaTransporte, 
                    ext_CustoDaExtra, 
                    ext_DataDeCadastro, 
                    ext_Evento, 
                    ext_StatusDoRegistro) 
                    VALUES 
                    ( $aprovador,
                        $desc_dia,
                        $id_empresa,
                        $setor,
                        $id_login,
                        $id_situacao,
                        '$data_emissao',
                        '$data_extra',
                        '$hora_inicio',
                        '$hora_termino',
                        '$drt',
                        '$nome_colaborador',
                        '$motivo',
                        '$bairro',
                        '$transporte_quantidade',
                        '$transporte_valor',
                        " . $almoco . "," . $lanche . ",
                        " . $jantar . ",
                        " . $conducao . ",
                        '$custo_extra',
                        '$data_emissao',
                        '$evento',
                        '$statusRegistro')";

       $empresa_url = $_POST['descricao_empresa']; 
        $partes_emp = explode("-", $empresa_url);
        $partes_emp_nome = explode(' ', $partes_emp[1]);
//        echo '<pre>';print_r();
//        exit;
        
        $stmt = $pdo->prepare($string_sql);
        if ($stmt->execute()) {
            //success
            $_SESSION[$errorBox] = "<div class='alert alert-success alert-dismissible' style='visibility: visible; width: 100%; text-align: center;'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                        <strong>Cadastrado com sucesso.</strong></div>";
            
             $url = "http://dev.grupois.mao/horaextra/web-hora-extra/pages/utils/mobile/firebase/notification.php?empresa=".$partes_emp_nome[1]."&setor=".$_POST['descricao_setor'];
       
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            
        } else {
            // error
            $_SESSION[$errorBox] = "<div class='alert alert-info alert-dismissible' style='visibility: visible; width: 100%; text-align: center;'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Error ao inserir registro na base.</strong></div>";
        }
    }
    

    
}


if ($_GET['acao'] == 'excluir') {
    $sql = "DELETE FROM tab_horaextra WHERE ext_idHoraExtra =" . $_GET['id'];

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute()) {
        //success
        echo json_encode(array("success" => true));
    } else {
        // error
        echo json_encode(array("success" => false));
    }
}

if ($_GET['acao'] == 'teste') {
    
}




