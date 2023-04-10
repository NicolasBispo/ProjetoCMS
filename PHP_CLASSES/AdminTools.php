<?php
require(__DIR__.'/ConexaoSql.php');
require(__DIR__.'/ControladorLog.php');
class AdminTools
{
    public function mostrarPosts()
    {
        
        $conexao = new ConexaoSQL();
        $log = new ControladorLog();
        $pdo = $conexao->conectar();


        $sql = "SELECT * FROM `controle-de-posts`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $resultado_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        $log->registraLog("Requisição para gerar posts página admin", date('Y-m-d H:i:s'));


        return $resultado_consulta;
    }
    public function deletarPost($id_post)
    {
    
        $conexao = new ConexaoSQL();
        $log = new ControladorLog();

        $pdo = $conexao->conectar();
        $sql = "DELETE FROM `controle-de-posts` WHERE id = :id_analisar";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_analisar", $id_post);
        $resultado = $stmt->execute();
        $pdo = null;
        return $resultado ? true : false;
        $conexao->fecharConexao();
    }

    public function editarPost($id_post)
    {
    
        $log = new ControladorLog();
        $conexao = new ConexaoSQL();

        $pdo = $conexao->conectar();
        $sql = "SELECT * FROM `controle-de-posts` WHERE id = :id_analisar";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_analisar", $id_post);
        $stmt->execute();
        $resultado_consulta = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $conexao->fecharConexao();

        $resultado_consulta['id_criador_post'] = "lucas";

        if (!$resultado_consulta) {
            $log = new ControladorLog();
            $log->registraLog("Resultados não obtidos no método 'editarPost' da classe AdminTools", date('Y-m-d H:i:s'));
            return false;
        } else {
            $log->registraLog("Resultados obtidos no método 'editarPost' da classe AdminTools", date('Y-m-d H:i:s'));
            return $resultado_consulta;
        }
    }
}
