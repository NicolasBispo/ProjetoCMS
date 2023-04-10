<?php
require('./ConexaoSql.php');
// Criar uma nova instância da classe ConexaoSQL
$conexao = new ConexaoSQL();

// Conectar ao banco de dados
$pdo = $conexao->conectar();

// Inserir um novo usuário na tabela 'usuarios'
$sql = "INSERT INTO usuarios (nome_usuario, email, senha) VALUES (:nome, :email, :senha)";
$statement = $pdo->prepare($sql);
$statement->bindValue(':nome', 'João');
$statement->bindValue(':email', 'joao@example.com');
$statement->bindValue(':senha', '123456');
$statement->execute();

// Fechar a conexão com o banco de dados
$conexao->fecharConexao();
