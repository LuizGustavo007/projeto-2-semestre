<?php
include './bd/conexao.php'; // Conexão com o banco de dados
session_start();

if (isset($_SESSION['email_cliente'])) {
    // Usuário já logado
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($email) || empty($senha)) {
        $error_message = "Por favor, preencha todos os campos.";
    } else {
        // Preparar consulta segura
        $sql = "SELECT id_cliente, nome_cliente, senha FROM clientes WHERE email_cliente = ?";
        if ($stmt = $conexao->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id_cliente, $nome_cliente, $senha_hashed);

            if ($stmt->fetch()) {
                if (password_verify($senha, $senha_hashed)) {
                    // Login bem-sucedido
                    $_SESSION['id_cliente'] = $id_cliente;
                    $_SESSION['nome_cliente'] = htmlspecialchars($nome_cliente);
                    $_SESSION['email_cliente'] = htmlspecialchars($email);

                    header("Location: ../index.php");
                    exit();
                } else {
                    $error_message = "Senha incorreta. Tente novamente.";
                }
            } else {
                $error_message = "E-mail não encontrado.";
            }

            $stmt->close();
        } else {
            $error_message = "Erro ao processar sua solicitação. Tente novamente mais tarde.";
        }
    }
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Planeta Pet</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img class="imagemheader" src="./img/logo_pet-removebg-preview.png" alt="Planeta Pet">
        </div>
        <div class="titulo">
            <p>Planeta Pet</p>
        </div>
    </div>

    <div class="login-container">
        <form action="" method="POST">
            <img class="imgdologin" src="./img/logo_pet-removebg-preview.png" alt="Planeta Pet Logo" width="60" height="40">
            <h1>Planeta Pet</h1>
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit">Acessar</button>
            <p><a href="./paginas/cadastro.php">Novo por aqui? Crie sua conta.</a></p>
        </form>
    </div>  
</body>
</html>
