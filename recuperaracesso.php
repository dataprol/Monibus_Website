<?php
    require_once("config/config.php");
    session_start();
?>

<!doctype html>
<html lang="pt">
    <head>

        <title>Recuperar acesso em <?=_PROJETO_TITULO?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Página de recuperação de acesso">
        <meta name="author" content=<?= _PROJETO_COPYRIGHT ?>>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/f80b1e2089.js" crossorigin="anonymous"></script>

        <!--[if lt IE 9]>
        <script src="assets/js/html5.js"></script>
        <![endif]-->

    </head>

    <body class="text-center text-secundary">

        <link href="assets/css/signin.css" rel="stylesheet">

        <?php
            require_once("config/config.php");

            $idrecuperacao = $_GET['idrecuperacao'];

            if( $idrecuperacao != null ){
    
                require_once("database/ConexaoClass.php");
                $oConexao = new ConexaoClass();
                $oConexao -> openConnect();
                $Conn = $oConexao -> getConnect();
                $sql = "SELECT * FROM pessoas WHERE idRecuperacaoAcesso='$idrecuperacao'";
                $resultado = $Conn -> query( $sql );

                if( $linha = $resultado -> fetch_assoc() ){
                    
                    if( $linha[ 'validadeRecuperacaoAcesso' ] >= (new DateTime) -> format('Y-m-d H:i:s') ){
                        ?>

                        <form class="form-signin" action="/salvar.php" method="POST" name="formulario" id="formulario" 
                            onsubmit="return Validar(this);" >
                                    
                            <h2 class="h4 mb-3 font-weight-normal text-dark">
                                <b><?=_PROJETO_TITULO?></b>
                            </h2>
                        
                            <h1 class="h3 mb-3 font-weight-normal text-dark">
                                <b><center>Alterar de Senha</center></b>
                            </h1>
                            <p>
                                Bem vindo(a), <?=$linha["nomePessoa"]?>! A seguir, você poderá fazer a alteração de sua senha.
                            </p>

                            <label for="senhaNovaUsuario" class="sr-only">Nova senha</label>
                            <input type="password" name="senhaNovaUsuario" id="senhaNovaUsuario" class="form-control" 
                            placeholder="Nova senha" required autofocus>

                            <label for="senhaRepetidaUsuario" class="sr-only">Repita a senha</label>
                            <input type="password" name="senhaRepetidaUsuario" id="senhaRepetidaUsuario" class="form-control" 
                            placeholder="Repita a senha" required>

                            <input type="number" name="id_usuario" id="id_usuario" class="form-control" 
                            value=<?=$linha["idPessoa"]?> hidden>        

                            <button class="btn btn-lg btn-success btn-block" type="submit">Confirmar</button>
                            <a class="btn btn-lg btn-danger btn-block" href="#" onclick="window.history.back();">
                                Cancelar
                            </a>

                        </form>

                        <?php
                }else{
                    ?>

                        <h2 class="h4 mb-3 font-weight-normal text-dark text-center">
                            <center>
                                <b>Seu código expirou!</b>
                            </center>
                        </h2>
            
                    <?php
                }
            }else{
                ?>        
                    <h2 class="h4 mb-3 font-weight-normal text-dark text-center">
                        <center>
                            <b>Algo deu errado!</b>
                        </center>
                    </h2>
                <?php
                http_response_code( 500 );
            }
        }else{
            ?>      
                <h2 class="h4 mb-3 font-weight-normal text-dark text-center">
                    <center>
                        <b>Algo deu errado!</b>
                    </center>  
                </h2>
            <?php
                http_response_code( 500 );
        }
            ?>

    </body>
</html>
<script language="javascript">
        function Validar( form1 ){

            // Comparar senhas:
            if( form1.senhaRepetidaUsuario.value != form1.senhaNovaUsuario.value ){
                alert("As senhas digitadas estão diferentes!");
                form1.senhaRepetidaUsuario.focus();
                return false;
            }

/*             if( form1.senhaNovaUsuario.value.match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/') ){
                return true;
            }else{
                alert("A senha requer o mínimo de 6 caracteres, sendo pelo menos 1 letra minúscula, 1 maiúscula, 1 número e 1 outro tipo de caracter($,*,&,@ ou #)");
                return false;
            } */

            if( form1.senhaNovaUsuario.value.length < 6 || form1.senhaRepetidaUsuario.value.length < 6 ){
                alert("A senha ter, no mínimo, 6 caracteres, sendo pelo menos 1 letra minúscula, 1 maiúscula, 1 número e 1 outro tipo de caracter($,*,&,@ ou #)!");
                form1.senhaNovaUsuario.focus();
                return false;
            }

        }
    </script> 
