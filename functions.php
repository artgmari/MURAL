<?php
require_once 'config.php';

function adicionarFoto($id_enviador, $id_estande, $url_foto) {
    global $conn;
    $sql = "INSERT INTO fotos_mural (id_enviador, id_estande, url_foto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_enviador, $id_estande, $url_foto);
    return $stmt->execute();
}

function obterFotos() {
    global $conn;
    $sql = "SELECT * FROM fotos_mural ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>