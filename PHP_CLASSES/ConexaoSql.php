<?php
class ConexaoSQL
{
    private $pdo;

    public function conectar()
    {
        $host = 'localhost';
        $dbname = 'cmsNicolas';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Falha na conexão: " . $e->getMessage();
        }
    }

    public function fecharConexao()
    {
        $this->pdo = null;
    }
}

?>
