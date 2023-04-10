<?php
session_start();

//verifica se foi acessado diretamente
if (basename($_SERVER['SCRIPT_FILENAME']) == 'header.php') {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="./CSS/reset.css">
    <link rel="stylesheet" href="./CSS/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,700&display=swap" rel="stylesheet">

    <!-- ScrollReveal - animação de entrada -->
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./IMAGENS/favicon.ico">

</head>

<div class="container-header">
    <a href='index.php'>
        <div class="container-logo">
            TechNews!
        </div>
    </a>
    <div class="container-menu">
        <ul>
            <li><a href='./index.php'>Início</a></li>
            <li>Ajuda</li>
            <li><a href="./buscar_posts.php">Posts</a></li>

            <?php
            if (isset($_SESSION['usuario']['logado'])) {
                if ($_SESSION['usuario']['logado'] == true) { ?>
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['usuario']['nickname']; ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php if ($_SESSION['usuario']['cargo'] == "admin") { ?>
                                    <a class="dropdown-item red-item" href="./admin_area.php">Painel Administrativo</a>
                                <?php } ?>
                                <a class="dropdown-item" href="./meu_perfil.php">Meu perfil</a>
                                <a class="dropdown-item" href="./logout.php">Sair</a>

                            </div>
                        </div>
                    </li>


                <?php }
            } else {
                ?>

                <li>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Login
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="./login-page.php">Login</a>
                            <a class="dropdown-item" href="./Cadastro.php">Cadastro</a>

                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>

    </div>

</div>

</html>