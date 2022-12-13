<?php

class ConexaoClass{
    
    var $oConexaoInterna;

    public function OpenConnect(){

		$servername = _SisConfigGeral["banco_de_dados"]["hostname"];
        $username = _SisConfigGeral["banco_de_dados"]["username"];
        $password = _SisConfigGeral["banco_de_dados"]["password"];
		$dbname = _SisConfigGeral["banco_de_dados"]["database"];

        $this -> oConexaoInterna = new mysqli( $servername, $username, $password, $dbname, null, null );
        if( $this -> oConexaoInterna -> connect_error ){
            die( "Conexão com banco de dados $dbname falhou: " . $this -> oConexaoInterna -> connect_error );
        }
        $this -> oConexaoInterna -> set_charset('utf8');
    }

    public function GetConnect(){
        return $this -> oConexaoInterna;
    }

    public function CloseConnect(){

        if( isset( $oConexaoInterna ) ){
            $oConexaoInterna -> close();
        }

    }

}