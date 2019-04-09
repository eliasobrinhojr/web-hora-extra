<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['usuarioNome'])) {
    $_SESSION['loginErro'] = "";

    header("Location:login.php");
}
?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Extra</title>

    <link rel="shortcut icon" href="../../../img/grupois1.png">
    <link rel="stylesheet" type="text/css" href="../../../css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/demo.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/component.css" />
    <link href="../../../includes/css/font-awesome.min.css" rel="stylesheet">
    <script src="../../../js/modernizr.custom.js"></script>		

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>