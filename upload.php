<?php
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar_foto"])) {
    $id_enviador = $_POST["id_enviador"];
    $id_estande = $_POST["id_estande"];
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Verificações de upload aqui (como no exemplo anterior)

    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi enviado.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $url_foto = $target_file;
            if (adicionarFoto($id_enviador, $id_estande, $url_foto)) {
                header("Location: foto_mural.php?success=1");
                exit();
            } else {
                echo "Desculpe, houve um erro ao adicionar a foto ao mural.";
            }
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    }
}
?>