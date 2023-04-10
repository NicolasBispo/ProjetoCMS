<?php
function atualizarInformacoesUsuario()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include('./ConexaoSql.php');
        $nome_alterado = $_POST['nome_user'];
        $email_alterado = $_POST['email_user'];
        $telefone_alterado = $_POST['tel_user'];

        $id_user = $_SESSION['usuario']['id'];
        $sql_1 = "UPDATE usuarios SET nome_usuario = :nome_inserir, email = :email_inserir, telefone = :telefone_inserir WHERE `usuarios`.id = :id_user";
        $stmt_recebe_dados = $pdo->prepare($sql_1);
        $stmt_recebe_dados->bindValue(":nome_inserir", $nome_alterado);
        $stmt_recebe_dados->bindValue(":email_inserir", $email_alterado);
        $stmt_recebe_dados->bindValue("telefone_inserir", $telefone_alterado);
        $stmt_recebe_dados->bindValue(":id_user", $id_user);
        
        if(!$stmt_recebe_dados->execute()){
            //Erro na execução
        }
        else{
            $_SESSION['usuario']['nome'] = $nome_alterado;
            $_SESSION['usuario']['email'] = $email_alterado;
            $_SESSION['usuario']['telefone'] = $telefone_alterado;
        }



    }
}

?>
<html>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body class="bg-info">
    <header>
        <?php
        include('./header.php');
        atualizarInformacoesUsuario();
        ?>
    </header>

    <main class="container bg-light mt-2 p-4 rounded">
        <div class="row">
            <div class="col-4">
                <div class="row border border-primary mb-2 p-2 rounded text-center" style="display: flex; flex-direction: column; align-items: center; justify-content:center">
                    <img class="img-thumbnail w-50 h-50 rounded-circle mx-auto d-block" src="<?php echo $_SESSION['usuario']['foto_perfil'] ?>" alt='foto perfil'>
                    <h5 class="text-black font-weight-bold"><?php echo $_SESSION['usuario']['nome'] ?></h5>
                    <h5 class="text-muted" style="display:flex; align-items:center;"><span class="material-symbols-outlined">account_box</span> <?php echo $_SESSION['usuario']['nickname'] ?></h5>
                    <h5 class="text-muted" style="display:flex; align-items:center;"><span class="material-symbols-outlined">mail</span> <?php echo $_SESSION['usuario']['email'] ?></h5>

                </div>
                <div class="row border border-primary p-2 rounded">
                    <div class="col">
                        <h6 class="text-uppercase text-muted font-weight-bold">Meus links:</h6>
                        <div class="d-flex flex-column justify-content-center">
                            <?php if (!empty($_SESSION['usuario']['github'])) : ?>
                                <a href="<?php echo $_SESSION['usuario']['github'] ?>" target="_blank" class="btn btn-outline-dark mx-2">

                                    <span class="ml-1">GitHub</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['usuario']['twitter'])) : ?>
                                <a href="<?php echo $_SESSION['usuario']['twitter'] ?>" target="_blank" class="btn btn-outline-dark mx-2">

                                    <span class="ml-1">Twitter</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['usuario']['instagram'])) : ?>
                                <a href="<?php echo $_SESSION['usuario']['instagram'] ?>" target="_blank" class="btn btn-outline-dark mx-2">

                                    <span class="ml-1">Instagram</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['usuario']['linkedin'])) : ?>
                                <a href="<?php echo $_SESSION['usuario']['linkedin'] ?>" target="_blank" class="btn btn-outline-dark mx-2">

                                    <span class="ml-1">LinkedIn</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-7 ml-5">
                <div class="row  border border-primary mb-2 p-4 rounded text-center">
                    <form action="" method="post">
                        <div class="row p-2" >
                            <div class="form-group d-flex text-nowrap">
                                <label for="nome_user">Nome completo</label>
                                <input class="form-control ml-2" type="text" name="nome_user" value="<?php echo $_SESSION['usuario']['nome']; ?>">
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="form-group d-flex text-nowrap">
                                <label for="email_user">Email</label>
                                <input class="form-control ml-2" type="text" name="email_user" value="<?php echo $_SESSION['usuario']['email']; ?>">
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="form-group d-flex text-nowrap">
                                <label for="tel_user">Telefone</label>
                                <input class="form-control  ml-2" type="text" name="tel_user" value="<?php echo $_SESSION['usuario']['telefone']; ?>">
                            </div>
                        </div>
                        <input  class='btn btn-info  justify-self-right' type="submit" value="Salvar">


                    </form>
                </div>
            </div>
        </div>

    </main>



</body>
<?php
require("./PHP-CLASSES/validacoes.php");
$Validacoes = new validacoes();
$verificacao_usuario = $Validacoes->validacao_usuario_logado();
if (!$verificacao_usuario) {
    //redireciona usuário para o index
    header('Location: index.php');
}
?>

</html>