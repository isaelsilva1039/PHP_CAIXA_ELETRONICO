<?php
session_start();

include '../model/Class.contas.php';
include '../model/Conexao.class.php';
$cobtas = new Contas();
$tipo = addslashes($_POST['tipo']);
$valor =str_replace(",", ".", $_POST['valor']);
$valor = floatval($valor);

if (isset($_POST['tipo']) & !empty($_POST['valor'])) {
	
	$cobtas->getTransoçoes($tipo,$valor);
}

header("location: ../index.php")


?>