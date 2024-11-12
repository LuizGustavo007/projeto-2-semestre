<?php
include './bd/conexao.php';
session_start();

if (isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        $sql = "SELECT senha FROM usuarios WHERE email = ?";
        if ($stmt = $conexao->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($senha_hashed);

            if ($stmt->fetch() && password_verify($senha, $senha_hashed)) {
                $_SESSION['email'] = htmlspecialchars($email);  // Protege a sessão contra injeções
                header("Location: ../index.php");
                exit();
            } else {
                echo "Credenciais incorretas. Verifique o e-mail e a senha.";
            }

            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta. Por favor, tente novamente mais tarde.";
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
    <title>Planeta Pet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img class="imagemheader" src="./img login/logo_pet-removebg-preview.png" alt="Planeta Pet">
        </div>
        <div class="titulo">
            <p>Planeta Pet</p>
        </div>
    </div>

    <div class="login-container">
        <form action="./pagina inicial/paginainicial.php" method="POST">
            <img class="imgdologin" src="./img login/logo_pet-removebg-preview.png" alt="Planeta Pet Logo" width="60" height="40">
            <h1>Planeta Pet</h1>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit">Acessar</button>
            <p><a href="../cadastro/cadastro.php">Novo por aqui? Crie sua conta.</a></p>
        </form>
    </div>
</body>
</html>

