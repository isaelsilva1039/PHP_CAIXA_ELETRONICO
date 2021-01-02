<?php 

class Contas extends Conexao1{


    //usuriao logado 
    public function usuarioLogado($id){
        $pdo = parent::get_instace();
        $sql = "SELECT * from contas WHERE id = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":id",$id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
           return $sql->fetchAll();
        }
    }

    //metodo pra efetuar transançoes
    public function getTransoçoes($tipo ,$valor){
        $pdo = parent::get_instace();
        $sql = "INSERT INTO historico (id_conta , tipo , valor , data_operacao )VALUES (:id_conta , :tipo , :valor , NOW())";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":id_conta",$_SESSION['login']);
        $sql->bindValue(":tipo",$tipo);
        $sql->bindValue(":valor",$valor);
        $sql->execute();

        if($tipo == 'Deposito'){
            //Depodito
            $sql = "UPDATE contas set saldo = saldo + :valor Where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":id",$_SESSION['login']);
            $sql->execute();
        }else{
            $sql = "UPDATE contas set saldo = saldo - :valor Where id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":id",$_SESSION['login']);
            $sql->execute();
        }
    }


    //lista historico de transaçoes.
    public function historicoDeTransacao($id){
        $pdo = parent::get_instace();
        $sql = "SELECT * FROM historico WHERE id_conta = :id_conta" ;
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":id_conta", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return  $sql->fetchAll();
        }else{

            
        }
    }

    
    //metodo pra lista as contas 
    public function listaContas(){
        $pdo = parent::get_instace();
        $sql = "SELECT * FROM contas ORDER BY id asc";
        $sql = $pdo->prepare($sql);
        $sql->execute();
        
        if($sql->rowCount() > 0 ){
            return $sql->fetchAll();
        }
    }


    //motodo para seleciona conta
    public function getInfo($id){
        $pdo = parent::get_instace();
        $sql= "SELECT * FROM contas Where id = :id";
        $sql= $pdo->prepare($sql);
        $sql->bindValue(":id",$id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }
    }   


    //metodo login.
    public function getLogged($agencia,$conta,$senha){
        $pdo = parent::get_instace();
        $sql = "SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":agencia",$agencia);
        $sql->bindValue(":conta",$conta);
        $sql->bindValue(":senha",$senha);
        $sql->execute();    
        if($sql->rowCount()){
            $sql = $sql->fetch();

            $_SESSION['login']= $sql['id'];

            header("location: ../index.php?login_secesso");
            }else{
                header("location:../login.php");
            }
        }
    
    
    //metodo pra destroir sessão
    public function logut(){
        session_start();
        unset($_SESSION['login']);
    }
    
    
    //metodo pra fazer controle da sessão
    public function controleDeSessao(){
            
        if(isset($_SESSION['login'])){
            header("location: ../index.php");
        }
    }

}


// class pra conecta no banco - não esta sendo utilizada 
class Conexao1 { 
    public static $instace ;
    public static function get_instace(){

        if(!isset(self::$instace)){
            self::$instace = new PDO("mysql:dbname=caixa_eletronico;host=localhost","root","");
    }
        return self::$instace;        
    }    
}
    
?>