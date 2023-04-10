<?php
require(__DIR__.'/ConexaoSql.php');
require(__DIR__.'/validacoes.php');
class PostsManager
{

    public function exibirUltimosPosts()
    {


        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();

        $sql = "SELECT * FROM `controle-de-posts` ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $ultimoPost = reset($resultados);
        $ultimosPosts = array_slice($resultados, 1, 4);
        return array($ultimoPost, $ultimosPosts);
    }
    public function exibirUltimosPostsCategoria()
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();
        $sql = "SELECT * FROM `categoria-posts`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $categorias_obtidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categorias_obtidas as $categoria) {
            $sql2 = "SELECT * FROM `controle-de-posts` WHERE categoria_post = :categoria_analisar ORDER BY id DESC LIMIT 5";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindValue(":categoria_analisar", $categoria['categoria']);
            $stmt2->execute();

            $posts_obtidos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            if (!$posts_obtidos) {
                //se nao tiver nada vai para o proximo
            } else {

                echo "<div class='posts-gerados mt-2 p-2 scr_bottom rounded'>";
                echo "<div class='d-flex'><h5>Ultimos posts de <span class='text-success pl-1'>" . $categoria['categoria'] . "</span></h5></div>";

                echo "<div class='d-flex'>";

                foreach ($posts_obtidos as $post) {
                    echo "<a class='m-2' href='./posts/" . $post['id'] . "/" . $post['url_slug'] . "' >";
                    echo "<div class='card border border-primary p-1' style='width:12rem;'>";
                    echo "<img class='card-img-top border border-primary' src='" . $post['imagem_destaque'] . "' alt='" . $post['titulo'] . "'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $post['titulo'] . "</h5>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
                echo "</div>";
                echo "</div>";
            }
        }
    }
    public function carregarComentarios($post_encontrar)
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();

        $post_atual = $post_encontrar['id'];
        $sql_comentarios = "SELECT * FROM comentarios WHERE id_post = :id_post_atual";
        $stmt_comentarios = $pdo->prepare($sql_comentarios);
        $stmt_comentarios->bindValue(":id_post_atual", $post_atual);
        $stmt_comentarios->execute();
        $comentarios_encontrados = $stmt_comentarios->fetchAll(PDO::FETCH_ASSOC);


        foreach ($comentarios_encontrados as $comentario) {
            $usuario = $this->procurarUsuario($comentario['id_usuario']);

            echo "<div class='comentario bg-light row mb-2 rounded p-2'>";

            echo "<div class='col-1'>";
            echo "<div class='mw-100 mh-100 border border-primary'><img class='mw-100 mh-100 w-80 h-80' src='" .  $usuario['foto_perfil'] . "'></div>";
            echo "<h6 class='text-primary text-center'>" . $usuario['cargo'] . "</h6>";
            echo "</div>"; //fim da div col-1

            echo "<div class='col-8'>";
            echo "<h6 class='text-primary'>" . $usuario['nick_usuario'] . "</h6>";
            echo "<h6>" . $comentario['comentario'] . "</h6>";
            echo "</div>"; //fim da div col-4

            echo "<div class='col-2'>";
            echo "<h6>" . $comentario['data'] . "</h6>";
            echo "</div>"; // fim da div col-2
            echo "</div>"; //fim da div comentário
        }
    }
    public function procurarUsuario($id_busca)
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();
        $sql_busca_usuario_comentario = "SELECT * FROM usuarios WHERE id = :id_usuario";
        $stmt_usuario = $pdo->prepare($sql_busca_usuario_comentario);
        $stmt_usuario->bindValue(":id_usuario", $id_busca);
        $stmt_usuario->execute();

        $usuario_encontrado = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
        return $usuario_encontrado;
    }
    public function exibirFormulario()
    {
        
        $Validacoes = new validacoes();

        //Verifica se o usuário está logado
        $resultado_query1 = $Validacoes->validacao_usuario_logado();

        if (!$resultado_query1) {
            //Exibe a div informando que somente usuários podem comentar
            echo "<div class='usuario-nao-logado bg-dark  text-center align-center p-5 rounded-bottom'>";
            echo "<p class='text-white'>Apenas usuários logados podem comentar</p>";
            echo "<a class='btn btn-primary' href='./login-page.php'>Login</a>";
            echo "</div>";
        } else {

            //Exibe o formulário de comentários
            echo "<form class='bg-dark ' action='' method='post'>";
            echo "<div class='row p-4'>";

            //Primeira col
            echo "<div class='col-1'>";
            echo "<div class='container-imagem'><img class='w-100 h-100 mw-100 mh-100 rounded' src='" . $_SESSION['usuario']['foto_perfil'] . "'>";
            echo "<div class='username'><h6 class='text-light'>" .  $_SESSION['usuario']['nickname'] . "</h6></div>";
            echo "</div>"; //fim da div container-imagem
            echo "</div>"; //fim da primeira col

            //Segunda col
            echo "<div class='col'>";
            echo "<div class='form-group'>";
            echo "<label for='comentario_inserir'class='text-light' >Comentário</label>";
            echo "<textarea id='comentario_inserir' name='comentario_inserir' class='form-control' rows='5'></textarea>";
            echo "</div>"; //fim da primeira div form-group

            echo "<div class='form-group'>";
            echo "<input class='btn btn-primary form-control' type='submit' value='Comentar'>";
            echo "</div>"; //fim da segunda col



            echo "</div>"; //
            echo "</form>"; //fim do formulário
        }
    }
    public function encontrarPost()
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();

        //Verificar se foram passados os parâmetros via post
        if (isset($_GET['id']) && isset($_GET['slug'])) {
            $id = $_GET['id'];
            $slug = $_GET['slug'];
            $sql = "SELECT * FROM `controle-de-posts` WHERE id = :id AND url_slug = :slug";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":slug", $slug);
            $stmt->execute();

            //Receives query values
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            //if is not found then atributtes a value true to a variable
            if (!$post) {
                return array($post, $not_found_post = true);
            } else {
                $not_found_post = false;
                return array($post, $not_found_post);
            }
        } else {
            echo "Post não encontrado";
            exit();
        }
    }
    public function comentarPost($post_atual)
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require('./ConexaoSql.php');
            $comentario_inserido = $_POST['comentario_inserir'];
            $id_usuario_que_comenta = $_SESSION['usuario']['id'];
            $id_post_atual = $post_atual['id'];
            $timezone = new DateTimeZone('America/Sao_Paulo');
            $agora = new DateTime('now', $timezone);

            $horario_atual = $agora->format('Y/m/d H:i:s');




            $sql_inserir_comentario = "INSERT INTO `comentarios` (id, id_post, id_usuario, comentario, `data`) VALUES (NULL, :id_post, :id_user, :comentario_inserir, :data_atual)";
            $stmt_comentario_inserir = $pdo->prepare($sql_inserir_comentario);
            $stmt_comentario_inserir->bindValue(":id_post", $id_post_atual);
            $stmt_comentario_inserir->bindValue(":id_user", $id_usuario_que_comenta);
            $stmt_comentario_inserir->bindValue(":comentario_inserir", $comentario_inserido);
            $stmt_comentario_inserir->bindValue(":data_atual", $horario_atual);

            $stmt_comentario_inserir->execute();

            if (!$stmt_comentario_inserir) {
                //Erro ao inserir comentário
                echo "erro ao inserir comentário";
            } else {
                $pagina_atual = "./posts/" . $post_atual['id'] . "/" . $post_atual['url_slug'];
            }
        }
    }

    public function carregarCategorias($parametro)
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();

        $sql = "SELECT * FROM `categoria-posts`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categorias_geradas_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Se o parametro for 1 ele exibe a div
        if ($parametro == 1)
            foreach ($categorias_geradas_consulta as $categoria_gerada) {
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='checkbox'  name='categorias[]' value='{$categoria_gerada['id']}'>";
                echo "<label class='form-check-label' for='{$categoria_gerada['id']}'>{$categoria_gerada['categoria']}</label>";
                echo "</div>";
            }
        //retorna o valor se a categoria for = 0
        if ($parametro == 0) {
            return $categorias_geradas_consulta;
        }
    }
    public function buscarPosts()
    {
        $conexao = new ConexaoSQL();
        $pdo = $conexao->conectar();
        if (isset($_GET['busca'])) {
            
            $termo_busca = $_GET['busca'];
            $sql = "SELECT * FROM `controle-de-posts` WHERE titulo LIKE :termo_busca";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':termo_busca' => '%' . $termo_busca . '%']);
            $posts_buscados_titulo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($posts_buscados_titulo) > 0) {
                foreach ($posts_buscados_titulo as $post_buscado) {
                    echo "<a class='link-to-post' href='./posts/" . $post_buscado['id'] . "/" . $post_buscado['url_slug'] . "'>";
                    echo "<div class='card noticia-gerada' style='width: 18rem;'>";
                    echo "<img class='card-img-top' style='height: 10rem;' src='" . $post_buscado['imagem_destaque'] . "' alt='" . $post_buscado['titulo'] . "'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='post-categoria'>" . $post_buscado['categoria_post'] . "</h5>";
                    echo "<h5 class='card-title'>" . $post_buscado['titulo'] . "</h5>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "<div class='posts-nao-encontrado'>Nenhum post encontrado, tente procurar por outra palavra chave</div>";
            }
        }
        //Verifica se o parametro de consulta foi pelos filtros
        if (isset($_GET['categorias'])) {
            

            //recebe o valor da categoria selecionada por GET
            $categoriasSelecionadas = $_GET['categorias'];

            //recebe o valor da consulta de categorias existentes
            $categorias_geradas_consulta = $this->carregarCategorias(0);


            foreach ($categoriasSelecionadas as $categoria) {

                //Identifica a categoria selecionada                    
                $categoria_selecionada = $categorias_geradas_consulta[$categoria - 2]['categoria'];

                //Faz a consulta no banco de dados 
                $sql_st2 = "SELECT * FROM `controle-de-posts` WHERE `categoria_post` = :categoria";
                $stmt_2 = $pdo->prepare($sql_st2);
                $stmt_2->bindParam(":categoria", $categoria_selecionada);
                $stmt_2->execute();
                $resultado_post_categoria = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

                //Gera um card para cada elemento $post_categoria
                foreach ($resultado_post_categoria as $post_categoria) {
                    //Gera o link <a> para cada card
                    echo "<a class='link-to-post' href='./posts/" . $post_categoria['id'] . "/" . $post_categoria['url_slug'] . "'>";

                    //Estrutura do card
                    echo "<div class='card noticia-gerada' style='width: 18rem;'>";

                    //Imagem do card (src e alt)
                    echo "<img class='card-img-top' style='height: 10rem;' src='" . $post_categoria['imagem_destaque'] . "' alt='" . $post_categoria['titulo'] . "'>";

                    //Corpo do card
                    echo "<div class='card-body'>";

                    //Categoria do post
                    echo "<h5 class='post-categoria'>" . $post_categoria['categoria_post'] . "</h5>";

                    //Titulo do post
                    echo "<h5 class='card-title'>" . $post_categoria['titulo'] . "</h5>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
            }
        }
    }
}
