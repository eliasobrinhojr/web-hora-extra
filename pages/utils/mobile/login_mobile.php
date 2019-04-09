<?php

include_once("../../../config/conexao.php");


$entityBody = file_get_contents('php://input');
$usuario = json_decode($entityBody);

if ((isset($usuario->login)) && (isset($usuario->senha))) {


    $query_usuario = "select * from tab_logins
		where log_Login ='$usuario->login' 
		and log_senha = '$usuario->senha' 
		LIMIT 1";

    $resultado_usuario = mysqli_query($conn, $query_usuario);
    $resultado = mysqli_fetch_assoc($resultado_usuario);


    if ($resultado != null) {
        echo json_encode(array("cod" => 0,
                                "id" => $resultado['log_idLogin'],
                                "chave" => generateRandomString(12),
                                "nome_completo" => $resultado['log_NomeCompleto'],
                                "senha" => $resultado['log_senha'],
                                "tipo_autenticacao" => $resultado['log_TipoDeAutenticacao'],
                                "status_registro" => $resultado['log_StatusDoRegistro'],
            "msg" => "sucesso"));
    } else {
        echo json_encode(array("cod" => 2, "msg" => "usuário ou senha inválidos", "usuario" => array()));
    }
} else {
    echo json_encode(array("cod" => 1, "msg" => "usuário ou senha inválidos", "usuario" => array()));
}

function generateRandomString($size) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789!@#$%¨&*";
    $randomString = '';
    for ($i = 0; $i < $size; $i = $i + 1) {
        $randomString .= $chars[mt_rand(0, 60)];
    }
    return $randomString;
}

?>