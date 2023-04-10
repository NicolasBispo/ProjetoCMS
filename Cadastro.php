<?php
session_start();
if (isset($_SESSION['usuario']['logado'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include('./ConexaoSql.php');
    // Recupera os valores do formulário
    $nome = $_POST['nome_inserir'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email_inserir'];
    $nickname = $_POST['nickname_inserir'];
    $senha = $_POST['senha_registro'];


    //Verificar se o email já está cadastrado
    $sql_email = "SELECT * FROM usuarios WHERE email = :email_consulta";
    $stmt_consulta_email = $pdo->prepare($sql_email);
    $stmt_consulta_email->bindValue(":email_consulta", $email);
    $stmt_consulta_email->execute();
    $resultado_email_consultado = $stmt_consulta_email->fetch(PDO::FETCH_ASSOC);
    if (!$resultado_email_consultado) {
        //Email não encontrado na consulta significa que pode ser cadastrado
        // Criptografa a senha usando PASSWORD_ARGON2ID
        $senha_hash = password_hash($senha, PASSWORD_ARGON2ID);

        //Junta nome e sobrenome
        $nome = $nome . ' ' . $sobrenome;
        $cargo = "usuario";
        $url_foto = "https://static.vecteezy.com/ti/vetor-gratis/p3/5228939-avatar-homem-rosto-silhueta-usuario-sinal-pessoa-perfil-imagem-masculino-icone-preto-cor-ilustracao-estilo-plano-imagem-vetor.jpg";
        // Prepara a instrução SQL
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome_usuario, foto_perfil, nick_usuario, email, senha, cargo) VALUES (:nome, :foto_url, :nickname, :email, :senha, :cargo)");

        // Define os valores dos parâmetros da instrução SQL
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(":foto_url", $url_foto);
        $stmt->bindValue(':nickname', $nickname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha_hash);
        $stmt->bindValue(":cargo", $cargo);

        // Executa a instrução SQL
        if ($stmt->execute()) {
            $sql_consulta_atual = "SELECT * FROM usuarios WHERE email = :email_consulta AND nome_usuario = :nome_consulta";
            $stmt_consulta_usuario_pos_registro = $pdo->prepare($sql_consulta_atual);
            $stmt_consulta_usuario_pos_registro->bindValue(":email_consulta", $email);
            $stmt_consulta_usuario_pos_registro->bindValue(":nome_consulta", $nome);
            $stmt_consulta_usuario_pos_registro->execute();
            $usuario_buscado = $stmt_consulta_usuario_pos_registro->fetch(PDO::FETCH_ASSOC);



            session_start();
            $_SESSION['usuario']['logado'] = true;
            $_SESSION['usuario']['nome'] = $usuario_buscado['nome_usuario'];
            $_SESSION['usuario']['id'] = $usuario_buscado['id'];
            $_SESSION['usuario']['cargo'] = $usuario_buscado['cargo'];
            $_SESSION['usuario']['nickname'] = $usuario_buscado['nick_usuario'];
            header('Location: index.php');
        } else {
            $erro_cadastro = true;
        }
    } else {
        $email_ja_cadastrado = 1;
    }
}

?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="./CSS/reset.css">
    <link rel="stylesheet" href="./CSS/cadastro.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="./IMAGENS/favicon.ico">
</head>

<body>

    <div class="container-login">
        <form action="" class="form-registro" method="post">
            <div class="form-group">
                <label for="email_inserir">Email</label>
                <input type="email" class="form-control" name='email_inserir' aria-describedby="email_cadastro" placeholder="Insira seu email">
                <?php if (isset($email_ja_cadastrado)) {
                    if ($email_ja_cadastrado == 1) { ?>
                        <small id="email_cadastro" class="form-text text-danger font-weight-bold">Email já está em uso, tente outro.</small>

                <?php
                    }
                }  ?>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome_inserir" placeholder="Nome" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="nickname_inserir">Nickname</label>
                <input type="text" class="form-control" name='nickname_inserir' placeholder="Insira seu nick" required>
            </div>
            <div class="form-group">
                <label for="senha_registro">Senha</label>
                <input type="password" class="form-control" placeholder="Insira sua senha" name="senha_registro" required>
            </div>


            <button type="submit" class="btn btn-primary form-control" aria-labelledby="erroCadastro">Cadastrar</button>
            <?php
            if (isset($erro_cadastro)) {
                if ($erro_cadastro == true) {
            ?>
                 <small id="email_cadastro" class="form-text text-danger font-weight-bold">Erro ao realizar o cadastro</small>
            <?php }
            }
            ?>

        </form>
    </div>
</body>

</html>