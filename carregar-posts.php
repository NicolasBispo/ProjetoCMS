<?php
require('./ConexaoSql.php');

$offset = $_GET['offset'];
$sql = "SELECT * FROM `controle-de-posts` ORDER BY id DESC LIMIT 4 OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($resultados);
?>