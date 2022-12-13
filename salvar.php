<?php

    require_once("config/config.php");
    session_start();

    $arrayUsuarios["id_usuario"] = $_POST["id_usuario"];
    $arrayUsuarios["senha"] = md5( $_POST["senhaNovaUsuario"] );
    
    require_once("database/ConexaoClass.php");
    $oConexao = new ConexaoClass();
    $oConexao -> openConnect();
    $Conn = $oConexao -> getConnect();
    $sql = "SELECT * FROM pessoas WHERE idPessoa='".$arrayUsuarios["id_usuario"]."'";
    if($resultado = $Conn -> query( $sql )){

        $aUsuario = $resultado -> fetch_assoc();
        
        if( ! isset( $_SESSION[ "usuarioErroEsperar" ] ) ){
            $_SESSION['usuarioErroEsperar'] = .1;
        }
    
        $sql = "UPDATE pessoas SET senhaPessoa='" . $arrayUsuarios['senha'] . "' WHERE idPessoa=" . $arrayUsuarios['id_usuario'] ;
        if( $resultado = $Conn -> query( $sql ) ){
    
            echo('<h2>sua senha foi alterada, com sucesso!</h2>');
        
        }else{
    
            $_SESSION['usuarioSituacao'] = "erro";
            sleep($_SESSION['usuarioErroEsperar']);
            echo('<h2>houve algum problema na tentativa de alterar senha do usuário!');
    
        }

    }else{
        
        $_SESSION['usuarioSituacao'] = "erro";
        sleep($_SESSION['usuarioErroEsperar']);
        echo('<h2>houve algum problema na tentativa de alterar senha do usuário!');

    }

?>