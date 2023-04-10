<?php
require('./PHP_CLASSES/PostManager.php');
$PostManager = new PostsManager();
?>
<!DOCTYPE html>
<html>

<head>
  <?php
  $resultado_post = $PostManager->encontrarPost();
  $post = $resultado_post[0];
  $not_found_post = $resultado_post[1];
  ?>
  <meta charset="UTF-8">
  <title>

  </title>
  <base href="https://localhost/ProjetoCMS/">
  <link rel="stylesheet" href="./CSS/PostContainer.css">
</head>

<body>
  <header>
    <?php require_once("./Header.php"); ?>
  </header>
  <div class="corpo-texto align-center">

    <?php if ($not_found_post == true) { ?>
      <div class="nao-encontrado align-center">
        <div>
          <h1>Post não encontrado, verifique se o post existe</h1>
          <button onclick="redirectPage('index.php')">Retornar para a página inicial</button>
        </div>
      </div>


    <?php } else { ?>
      <div class="postcontainer-area">
        <!--Titulo post -->
        <h1>
          <?php echo $post['titulo']; ?>
        </h1>

        <!--Post text-->
        <p>
          <?php echo $post['texto_post']; ?>
        </p>
      </div>
    <?php } 
    if($not_found_post){

    }
    else{?>
    
    <div class="comentarios-area">
      <div class="comentarios-existentes">

        <h5 class="text-">Área de comentários</h5>
        <?php
        
        
        $PostManager->comentarPost($post);
        $PostManager->carregarComentarios($post);
        $PostManager->exibirFormulario();
        
        ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <script src="./JS/navigate_functions.js"></script>

  <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
  <script src="./ckeditor5/build/ckeditor.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/translations/pt-br.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#comentario_inserir'), {
        // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.
        language: 'pt-br'
      })
      .then(editor => {
        console.log(editor);
      })
      .catch(error => {
        console.error(error);
      });
  </script>



</body>

</html>