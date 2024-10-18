<?php
require_once 'config.php';
require_once 'functions.php';

// Exibir mensagem de sucesso, se houver
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p>Foto adicionada com sucesso!</p>";
}
?>

<h2>Adicionar Nova Foto</h2>
<form method="post" action="upload.php" enctype="multipart/form-data">
    ID do Enviador: <input type="number" name="id_enviador" required><br>
    ID do Estande: <input type="number" name="id_estande" required><br>
    Selecione a foto: <input type="file" name="fileToUpload" id="fileToUpload" required><br>
    <input type="submit" name="enviar_foto" value="Enviar Foto">
</form>

<h2>Mural de Fotos</h2>
<?php
$fotos = obterFotos();
foreach ($fotos as $foto):
?>
    <div>
        <img src="<?php echo htmlspecialchars($foto['url_foto']); ?>" alt="Foto" style="max-width: 300px;">
        <p>Enviado por: <?php echo htmlspecialchars($foto['id_enviador']); ?></p>
        <p>Estande: <?php echo htmlspecialchars($foto['id_estande']); ?></p>
        <p>Data: <?php echo htmlspecialchars($foto['created_at']); ?></p>
    </div>
<?php endforeach; ?>