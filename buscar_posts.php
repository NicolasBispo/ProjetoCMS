<?php
require('./PHP_CLASSES/PostManager.php');
$PostManager = new PostsManager();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Buscar post</title>
    <link rel="stylesheet" href="./CSS/buscar_posts.css">
    <link rel="shortcut icon" type="image/x-icon" href="./IMAGENS/favicon.ico">
</head>
<body>
    <header>
        <?php
        include("./header.php")
        ?>
    </header>
    <main>
        <div class="container-page">
            <div class="container-form-post-titulo">
                <form class="form-group" action="" method="get">

                    <div class="input-group">
                        <input type="text" class="form-control" id="busca" name="busca" placeholder="Procurar post por título">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container-posts-area">
                <div class="filtros-pesquisa">
                    <form class="" action="" method="get">
                        <div class="tag-tipos-busca">
                            <h5>Categorias de post</h5>
                            <?php
                            $resultados = $PostManager->carregarCategorias(1);
                            ?>
                        </div>
                        <input class="btn btn-outline-primary left" type="submit" value="Filtrar">
                    </form>
                </div>
                <div class="posts-encontrados">
                    <?php
                    $PostManager->buscarPosts();
                    ?>
                </div>
            </div>
        </div>
    </main>
</html>