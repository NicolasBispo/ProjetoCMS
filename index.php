<?php
require('./PHP_CLASSES/PostManager.php');
$PostManager = new PostsManager();


$posts_busca = $PostManager->exibirUltimosPosts();
$ultimoPost = $posts_busca[0];
$ultimosPosts = $posts_busca[1];
?>



<!DOCTYPE html>
<html>
<?php
require('./header.php');
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="stylesheet" href="./CSS/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="./IMAGENS/favicon.ico">
    <title>TechNews!</title>
</head>

<body>

    <div class="container pt-4">
        <div class="container p-4 bg-light rounded">
            <h4>Ultimas notícias</h1>
                <div class="row">
                    <div class="col-7 ultima-noticia">
                        <?php
                        echo "<a href='./posts/" . $ultimoPost['id'] . "/" . $ultimoPost['url_slug'] . "'>";
                        echo "<div class='post-gerado bg-dark row d-flex flex-column align-items-center border border-dark rounded justify-content-center p-2'>";
                        echo "<div class='w-100 h-100' style='text-align: center;'><img class='w-100 h-100 m-0 rounded' src='" . $ultimoPost['imagem_destaque'] . "'></div>";
                        echo "<h4 class='text-light font-weight-bold w-100 m-0 text-center'>" . $ultimoPost['titulo'] . "</h4>";
                        echo "</div>";
                        echo "</a>";
                        ?>
                    </div>
                    <div class="col-5 noticias-anteriores">
                        <?php
                        foreach ($ultimosPosts as $post_gerado) {
                            echo "<a href='./posts/" . $post_gerado['id'] . "/" . $post_gerado['url_slug'] . "'>";
                            echo "<div class='post-gerado w-100 h-25 d-flex w-100 align-items-center bg-dark p-1 mb-1 rounded'>";
                            echo "<div class='w-25 h-100 p-0 m-0 mr-2'><img class='w-100 h-100 rounded' src='" . $post_gerado['imagem_destaque'] . "'></div>";
                            echo "<div class=''><h6 class='text-light  h-100 p-auto'>" . $post_gerado['titulo'] . "</h6></div>";
                            echo "</div>";
                            echo "</a>";
                        }

                        ?>
                    </div>
                </div>

        </div>
    </div>
    <div class="container noticias-categorias mt-2">
        
            <?php
                $PostManager->exibirUltimosPostsCategoria();
            ?>
        
    </div>




    <?php
    include('./footer.php');
    ?>
    <script src="./JS/ScrollReveal.js"></script>
</body>


</html>