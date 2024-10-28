<?php
include '../conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT senha FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($senha_hashed);
    
    if ($stmt->fetch() && password_verify($senha, $senha_hashed)) {
        $_SESSION['email'] = $email;  // Inicia a sessão para o usuário logado
        header("Location: ../index.php");
        exit();
    } else {
        echo "Email ou senha incorretos.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet</title>
    <link rel="stylesheet" href="./style.css">
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
        <form action="login.php" method="POST">
            <img class="imgdologin" src="./img/logo_pet-removebg-preview.png" alt="" width="60" height="40">
            <h1>Planeta Pet</h1>
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email">
            <label for="senha">Senha :</label>
            <input type="password" id="senha" name="senha">
            <button type="submit">Acessar</button>
            <p><a href="../cadastro/cadastro.php">Novo por aqui? Crie sua conta.</a></p>
        </form>
    </div>
</body>
</html>

