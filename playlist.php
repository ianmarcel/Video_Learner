<?php
$result = $conn->query("SELECT id, nome, link_aula FROM `tb.aulas`");

if ($result->num_rows > 0) {
    echo "<div style='display: flex; flex-wrap: wrap;'>";
    $counter = 0;
    while ($row = $result->fetch_assoc()) {
        echo "<div style='flex: 0 0 50%; box-sizing: border-box; padding: 10px;'>";
        echo "<h3>{$row['nome']} <input type='checkbox' class='assistido-checkbox'> Ja assisti</h3>";
        echo "<iframe width='100%' height='300' src='{$row['link_aula']}' frameborder='0' allowfullscreen></iframe>";

        // Botão de exclusão estilizado
        include 'delete-button.php';

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
$conn->close();
?>
