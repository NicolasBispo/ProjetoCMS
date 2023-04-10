<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('./../PHP_CLASSES/validacoes.php');
require_once('./../PHP_CLASSES/AdminTools.php');

$Validacoes = new validacoes();

$cargo = $Validacoes->validacao_cargo_usuario();
if ($cargo == 100) {
} else {
    header("Location: ./header.php");
}


header('Content-Type: application/json');
if (isset($_POST['action'])) {
    $adminTools = new AdminTools();

    switch ($_POST['action']) {
            //Recebe os posts
        case 'getPosts':

            $posts = $adminTools->mostrarPosts();
            $monta_saida = array('data' => $posts);
            $saida = json_encode($monta_saida);
            echo $saida;
            break;

            //Deleta o post pelo id
        case 'deletePost':
            if (isset($_POST['id'])) {

                $resultado = $adminTools->deletarPost($_POST['id']);
                if (!$resultado) {
                    echo json_encode(array('success' => false, 'message' => 'Erro ao deletar post.'));
                } else {
                    echo json_encode(array('success' => true, 'message' => 'Post deletado com sucesso.'));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Erro ao deletar post.'));
            }
            break;

            //Recebe os valores totais do post para edita-lo
        case 'editarPost':
            if (isset($_POST['id'])) {
                $id_post = $_POST['id'];

                $resultado_post = $adminTools->editarPost($id_post);

                if (!$resultado_post) {
                    //Erro na consulta do post
                    echo json_encode(array('data' => false));
                } else {
                    $saida = array('data' => $resultado_post);
                    echo json_encode($saida);
                }
            } else {

                echo json_encode(array('success' => false, 'message' => 'Erro ao deletar post.'));
            }
            break;

        default:

            echo "Ação não reconhecida.";
            break;
    }
} else {
    echo "Api conectada";
}
