<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aula_youtube";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Não conectou: " . $conn->connect_error);
}

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST['nome'];
    $link_aula = $_POST['link_aula'];

    // Inserção no banco de dados
    $sql = "INSERT INTO `tb.aulas` (nome, link_aula) VALUES ('$nome', '$link_aula')";
    $conn->query($sql);
}

// Seleciona todos os registros da tabela
$result = $conn->query("SELECT id, nome, link_aula FROM `tb.aulas`");

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoLearner</title>
    <style>
        /* Estilo para o botão Excluir */
        .delete-button,button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
        }
        .youtube{
            color: red;
        }
        h1{
         text-align: center;
        }
        .formularioInicial {
           margin-left: 25%;
        }
        body{
            background-color: lightgray;
        }
       
    </style>
</head>
<body>
    <h1>A sua Playlist de Aulas do <span class="youtube">YouTube</span>  </h1>

    <!-- Formulário para inserção de novas aulas -->
    <form class="formularioInicial" method="post" action="">
        <label for="nome">Nome da Aula:</label>
        <input type="text" name="nome" required>

        <label for="link_aula">Link da Aula:</label>
        <input type="text" name="link_aula" required>

        <button type="submit">Adicionar Aula</button>
    </form>

    <hr>

    <!-- Exibe todas as aulas cadastradas -->
    <?php
    if ($result->num_rows > 0) {
        echo "<div style='display: flex; flex-wrap: wrap;'>";
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<div style='flex: 0 0 50%; box-sizing: border-box; padding: 10px;'>";
            echo "<h3>{$row['nome']} <input type='checkbox' class='assistido-checkbox'> Ja assisti</h3>";
            echo "<iframe width='100%' height='300' src='{$row['link_aula']}' frameborder='0' allowfullscreen></iframe>";

            // Botão de exclusão estilizado
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='delete_id' value='{$row['id']}'>";
            echo "<button type='submit' class='delete-button'>Excluir</button>";
            echo "</form>";

            echo "</div>";

            // Adiciona uma linha horizontal após cada par de vídeos
            $counter++;
            if ($counter % 2 == 0 && $counter != $result->num_rows) {
                echo "<hr style='width: 100%; border: 1px solid #ccc; margin: 10px 0;'>";
            }
        }
        echo "</div>";
    } else {
        echo "Nenhuma aula cadastrada.";
    }
    ?>
</body>
</html>
