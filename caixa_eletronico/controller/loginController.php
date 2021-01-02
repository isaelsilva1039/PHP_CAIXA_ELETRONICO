<?php 
session_start();

include '../model/Class.contas.php';
include '../model/Conexao.class.php';

$cobtas = new Contas();
$agencia= addslashes($_POST['agencia']);
$conta= addslashes($_POST['conta']);
$senha= addslashes($_POST['senha']);

if(isset($_POST['conta']) & !empty('conta') ){
    
    $cobtas->getLogged($agencia,$conta,$senha);
     

};

?>