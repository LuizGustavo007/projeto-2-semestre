<?php
session_start();

$host = 'localhost'; 
$user = 'root';
$password = ''; 
$dbname = 'planeta_pet'; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_cliente = mysqli_real_escape_string($conn, $_POST['nome_cliente']);
    $senha_cliente = mysqli_real_escape_string($conn, $_POST['senha_cliente']);

    $senha_hash = password_hash($senha_cliente, PASSWORD_DEFAULT);

    $sql_check = "SELECT id_cliente FROM clientes WHERE nome_cliente = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nome_cliente);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['status'] = 'nome_existente';
    } else {
        $sql_insert = "INSERT INTO clientes (nome_cliente, senha) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $nome_cliente, $senha_hash);

        if ($stmt_insert->execute()) {
            $_SESSION['status'] = 'sucesso';
        } else {
            $_SESSION['status'] = 'erro';
            $_SESSION['erro_msg'] = $conn->error;
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
    $conn->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo-nav">
            <img src="../img/logo_pet-removebg-preview.png" alt="Logo Planeta Pet">
            <span id="site">Planeta Pet</span>
        </div>
    </header>

    <div class="cadastro">
        <img src="../img/logo_pet-removebg-preview.png" alt="Logo do Planeta Pet" class="logo">
        <h1>Planeta Pet</h1>

        <form method="POST">
            <?php if (!empty($mensagem)): ?>
                <div class="error-message"><?= htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>

            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" required placeholder="Digite seu nome"><br><br>
    
            <label for="senha_cliente">Senha:</label>
            <input type="password" id="senha_cliente" name="senha_cliente" required placeholder="Digite sua senha"><br><br>
    
            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <?php if (isset($_SESSION['status'])): ?>
        <script>
            <?php if ($_SESSION['status'] == 'sucesso'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastro realizado com sucesso!',
                    text: 'O cliente foi registrado com sucesso.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = '../index.php';
                });
            <?php elseif ($_SESSION['status'] == 'nome_existente'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Erro ao cadastrar',
                    text: 'Este nome já está cadastrado. Tente outro.',
                    confirmButtonText: 'Ok'
                });
            <?php elseif ($_SESSION['status'] == 'erro'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao cadastrar',
                    text: '<?php echo $_SESSION['erro_msg']; ?>',
                    confirmButtonText: 'Tentar novamente'
                });
            <?php endif; ?>
        </script>
        <?php unset($_SESSION['status']); ?>
    <?php endif; ?>
</body>
</html>
