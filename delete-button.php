<form method='post' action=''>
    <?php
    // Verifica se o id está presente antes de exibir o botão
    $id = $row['id'];
    if ($conn->query("SELECT id FROM `tb.aulas` WHERE id = $id")->num_rows > 0) {
        echo "<input type='hidden' name='delete_id' value='$id'>";
        echo "<button type='submit' class='delete-button'>Excluir</button>";
    } else {
        echo "<button type='button' class='delete-button' style='color: red;'>Excluído</button>";
    }
    ?>
</form>
