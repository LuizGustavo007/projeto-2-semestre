<?php
// Incluindo o arquivo de conexão
include 'conexao.php'; // Verifique se o caminho para 'conexao.php' está correto

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtendo os dados do formulário
    $nome = $_POST["nome"]; 
    $email = $_POST["email"]; 
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];
    
    // Verificando se a senha e a confirmação correspondem
    if ($senha !== $confirmar_senha) {
        die("As senhas não coincidem.");
    }

    // Verificando se a variável $conexao está definida
    if (!$conexao) {
        die("Erro: A conexão com o banco de dados não foi estabelecida.");
    }

    // Preparando a consulta SQL para inserir os dados
    $sql = "INSERT INTO usuarios (nome, email, telefone, endereco, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql); // $conexao deve estar definido
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }
    
    // Vinculando os parâmetros e executando
    $stmt->bind_param("sssss", $nome, $email, $telefone, $endereco, $senha);
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fechando a declaração
    $stmt->close();
}
?>
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

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
