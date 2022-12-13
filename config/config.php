<?php

    setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
    date_default_timezone_set( 'America/Sao_Paulo' );

    require_once('passwords.php');

    // Prazo para a sessão expirar:
    // Talvez, deixar até 21600 minutos(15 dias). 
    // Cuidado! 
    // > Dados sensíveis ficarão gravados por todo esse tempo!
    // > Risco de sobrecarga e de falha de segurança!
    //session_cache_expire(1);

    // Detecta se está em modo desenvolvimento/teste 
    // e reajusta variáveis necessárias.
    if( $_SERVER['SERVER_NAME'] == 'localhost' 
    or $_SERVER['SERVER_NAME'] == '127.0.0.1' 
    or $_SERVER['SERVER_NAME'] == '192.168.0.105' 
    or $_SERVER['SERVER_NAME'] == '10.0.0.1' ){

        // Sinaliza modo de desenvolvimento/teste
        define( "_MODO_DE_TRABALHO", "dev" );

        // Exibir todos os detalhes de erros
        ini_set( 'display_errors', 1 );
        ini_set( 'display_startup_errors', 1 );
        error_reporting( E_ALL );

        // Banco de dados
        $sisConfig['banco_de_dados'] = $bd_local;

        // Servidor de email
        $sisConfig['email_servidor'] = $mail_server;

        // Locais de arquivos
        $sisConfig["arquivos"] = "assets/files";
        $sisConfig['imagens'] = "assets/img";

    }else{

        // Sinaliza modo de produção/online
        define( "_MODO_DE_TRABALHO", "prod");

        // Ocultar detalhes dos erros
        ini_set( 'display_errors', 1 );
        ini_set( 'display_startup_errors', 1 );
        error_reporting( E_ERROR );

        // Banco de dados
        $sisConfig['banco_de_dados'] = $bd_remoto;

        // Servidor de email
        $sisConfig['email_servidor'] = $mail_server;

        // Locais de arquivos
        $sisConfig['arquivos'] = "assets/files";
        $sisConfig['imagens'] = "assets/img";

    }


    // Cria as constantes do sistema
    define( "_FMT_DATA", "%d/%m/%Y" );
    define( "_FMT_DATA_HORA", "%d/%m/%Y %Hh%M" );
    define( "_PaginacaoItensPorPagina", 5 );
    define( "_SisConfigGeral", $sisConfig );

    define( "_PROJETO_TITULO", "Monibus" );
    define( "_PROJETO_VERSAO", "0.1.1.1" );
    define( "_PROJETO_AUTORIA", "Luiz Carlos Costa Rodrigues" );
    define( "_PROJETO_COPYRIGHT", "2022 - Luiz Carlos Costa Rodrigues" );
    define( "_PROJETO_WEBSITELINK", '<a href="https://www.monibus.tecnologia.ws/">www.monibus.tecnologia.ws</a>');
    define( "_PROJETO_WEBSITEURL", 'https://www.monibus.tecnologia.ws/');


?>