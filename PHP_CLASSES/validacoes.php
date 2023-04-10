<?php

class validacoes{

    public function validacao_usuario_logado(){
        if(isset($_SESSION['usuario']['logado'])){
            //Verifica se existe uma sessão definida de login!
            if($_SESSION['usuario']['logado'] == true){
                //Verifica se a sessão está definida como verdadeira
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function validacao_cargo_usuario(){
        if($_SESSION['usuario']['cargo'] == "admin"){
            return 100;
        }
        if($_SESSION['usuario']['cargo'] == "usuario"){
            return 10;
        }
    }
    public function Login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require("./PHP_CLASSES/ConexaoSql.php");
        
            $conexao = new ConexaoSQL();
            $pdo = $conexao->conectar();
            
            $email_login = $_POST['email_login'];
            $senha_login = $_POST['senha_login'];
        
        
        
            $sql = "SELECT * FROM usuarios WHERE email = :email_comparar";
            $stmt_login = $pdo->prepare($sql);
            $stmt_login->bindValue(":email_comparar", $email_login);
            $stmt_login->execute();
            $registros_obtidos = $stmt_login->fetch(PDO::FETCH_ASSOC);
            if (!$registros_obtidos) {
                $status_senha = "Senha incorreta";
                
            } else {
                $hash_obtido = $registros_obtidos['senha'];
                if (password_verify($senha_login, $hash_obtido)) {
                    //Login correto
                    session_start();
                    $_SESSION['usuario']['logado'] = true;
                    $_SESSION['usuario']['nome'] = $registros_obtidos['nome_usuario'];
                    $_SESSION['usuario']['email'] = $registros_obtidos['email'];
                    $_SESSION['usuario']['telefone'] = $registros_obtidos['telefone'];
                    $_SESSION['usuario']['id'] = $registros_obtidos['id'];
                    $_SESSION['usuario']['cargo'] = $registros_obtidos['cargo'];
                    $_SESSION['usuario']['nickname'] = $registros_obtidos['nick_usuario'];
                    $_SESSION['usuario']['foto_perfil'] = $registros_obtidos['foto_perfil'];
                    $_SESSION['usuario']['linkedin'] = $registros_obtidos['linkedin'];
                    $_SESSION['usuario']['github'] = $registros_obtidos['github'];
                    $_SESSION['usuario']['twitter'] = $registros_obtidos['twitter'];
                    $_SESSION['usuario']['instagram'] = $registros_obtidos['instagram'];
                    header('Location: index.php');
                } else {
                    $status_senha  = "Senha incorreta";
                    
                }
            }
        }
    }
}
