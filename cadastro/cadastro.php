<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $senha = $_POST["senha"];

    // Verifica se o email já está cadastrado
    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Este email já está cadastrado.";
    } else {
        // Código para hash e inserção do novo usuário
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO usuarios (nome, email, telefone, endereco, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conexao->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $nome, $email, $telefone, $endereco, $senha_hashed);
        
        if ($stmt_insert->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }
    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Cadastro</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="./img/logo_pet-removebg-preview.png" alt="Planeta Pet">
        </div>
        <div class="titulo">
            <p>Planeta Pet</p>
        </div>
    </div>

    <div class="register-container">
        <form id="register-form" action="cadastro.php" method="POST">
            <img class="imagemlogin"  src="./img/logo_pet-removebg-preview.png" alt="">
            <h1>Planeta Pet</h1>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required><br><br>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required><br><br>

            <label for="senha">Senha:</label>
            <input name="senha" type="password" id="senha" required><br><br>

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input name="confirmar_senha" type="password" id="confirmar_senha" required><br><br>

            <button type="submit"><a href="../login/login.php">Cadastrar</button>
        </form>
    </div>
</body>
</html>
