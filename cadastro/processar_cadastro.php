<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_cliente = $_POST['nome'];
    $email_cliente = $_POST['email'];
    $telefone_cliente = $_POST['telefone'];
    $endereco_cliente = $_POST['endereco'];
    $senha_cliente = $_POST['senha'];

    $senha_cliente_hashed = password_hash($senha_cliente, PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (nome_cliente, email_cliente, telefone_cliente, endereco_cliente, senha_cliente) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }
    
    $stmt->bind_param("sssss", $nome_cliente, $email_cliente, $telefone_cliente, $endereco_cliente, $senha_cliente_hashed);
    if ($stmt->execute()) {
        echo "<script>alert('Usuario cadastrado com sucesso');</script>";
    } else {
        echo "<script>alert('Usuario não cadastrado');</script>";
        echo "Erro no cadastro: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
