<?php
require_once 'database.php';

// Verifica se o formulário foi submetido para exclusão
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Exclusão no banco de dados
    $deleteSql = "DELETE FROM `tb.aulas` WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    $deleteStmt->close();
}

// Verifica se o formulário foi submetido para adição
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome']) && isset($_POST['link_aula'])) {
    // Dados do formulário
    $nome = $_POST['nome'];
    $link_aula = $_POST['link_aula'];

    // Inserção no banco de dados
    $sql = "INSERT INTO `tb.aulas` (nome, link_aula) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $link_aula);
    $stmt->execute();
    $stmt->close();
}

// Seleciona todos os registros da tabela
$result = $conn->query("SELECT id, nome, link_aula FROM `tb.aulas`");

// Fecha a conexão
// $conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoLearner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>A sua Playlist de Aulas do <span class="youtube">YouTube</span></h1>

    <!-- Formulário para inserção de novas aulas -->
    <?php include 'form.php'; ?>

    <hr>

    <!-- Exibe todas as aulas cadastradas -->
    <?php include 'playlist.php'; ?>
</body>
</html>
