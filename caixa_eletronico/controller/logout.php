
<?php 

include '../model/Class.contas.php';
include '../model/Conexao.class.php';

$Contas = new Contas();
$Contas->logut();
header("location: ../login.php");


