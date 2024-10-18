<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para adicionar uma nova foto
function adicionarFoto($id_enviador, $id_estande, $url_foto) {
    global $conn;
    $sql = "INSERT INTO fotos_mural (id_enviador, id_estande, url_foto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_enviador, $id_estande, $url_foto);
    return $stmt->execute();
}

// Função para obter todas as fotos
function obterFotos() {
    global $conn;
    $sql = "SELECT * FROM fotos_mural ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Processar o envio de uma nova foto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar_foto"])) {
    $id_enviador = $_POST["id_enviador"];
    $id_estande = $_POST["id_estande"];
    $url_foto = $_POST["url_foto"];
    
    if (adicionarFoto($id_enviador, $id_estande, $url_foto)) {
        echo "Foto adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar foto.";
    }
}

// Exibir o formulário para enviar uma nova foto
?>
<h2>Adicionar Nova Foto</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    ID do Enviador: <input type="number" name="id_enviador" required><br>
    ID do Estande: <input type="number" name="id_estande" required><br>
    URL da Foto: <input type="text" name="url_foto" required><br>
    <input type="submit" name="enviar_foto" value="Enviar Foto">
</form>

<?php
// Exibir o mural de fotos
$fotos = obterFotos();
?>
<h2>Mural de Fotos</h2>
<?php foreach ($fotos as $foto): ?>
    <div>
        <img src="<?php echo htmlspecialchars($foto['url_foto']); ?>" alt="Foto" style="max-width: 300px;">
        <p>Enviado por: <?php echo htmlspecialchars($foto['id_enviador']); ?></p>
        <p>Estande: <?php echo htmlspecialchars($foto['id_estande']); ?></p>
        <p>Data: <?php echo htmlspecialchars($foto['created_at']); ?></p>
    </div>
<?php endforeach; ?>

<?php
// Fechar a conexão
$conn->close();
?>