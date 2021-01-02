<?php

class Conexao{ 

    public static $instace ;

    public static function get_instace(){

        if(!isset(self::$instace)){
        self::$instace = new PDO("mysql:dbname=caixa_eletronico;host=localhost","root","");
    }
  
        return self::$instace;    

    }

}


