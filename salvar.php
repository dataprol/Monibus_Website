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
    
        $sql = "UPDATE pessoas "
        . 'SET senhaPessoa = "' . $arrayUsuarios['senha'] . '", '
        . 'idRecuperacaoAcesso = "", ' 
        . 'validadeRecuperacaoAcesso = "" ' 
        . 'WHERE idPessoa = ' . $arrayUsuarios['id_usuario'] ;
        if( $resultado = $Conn -> query( $sql ) ){
    
            echo('<h2>Senha alterada, com sucesso!</h2>');
            echo('<h3>Agora, você já pode entrar no aplicativo com sua nova senha.</h3>');
        
        }else{
    
            $_SESSION['usuarioSituacao'] = "erro";
            sleep($_SESSION['usuarioErroEsperar']);
            echo('<h2>Houve algum problema na tentativa de alterar senha do usuário!</h2>');
    echo $Conn -> error.' | ' . $sql;
        }

    }else{
        
        $_SESSION['usuarioSituacao'] = "erro";
        sleep($_SESSION['usuarioErroEsperar']);
        echo('<h2>Usuário não encontrado para alterar senha do mesmo!</h2>');
        echo $Conn -> error.' | ' . $sql;
    }

?>