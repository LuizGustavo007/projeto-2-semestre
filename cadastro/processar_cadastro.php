<?php
// Inclui o arquivo de conexão
include 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome_cliente = $_POST['nome'];
    $email_cliente = $_POST['email'];
    $telefone_cliente = $_POST['telefone'];
    $endereco_cliente = $_POST['endereco'];
    $senha_cliente = $_POST['senha'];

    
    $sql = "INSERT INTO clientes (nome_cliente, email_cliente, telefone_cliente, endereco_cliente, senha_cliente) 
            VALUES ('$nome_cliente', '$email_cliente', '$telefone_cliente', '$endereco_cliente', '$senha_cliente')";

    if($conexao -> query($sql) === TRUE){
        echo "<script>alert('Usuario cadastrado com sucesso');</script>";
    }else{
        echo "<script>alert('Usuario não cadastrado');</script>";
        echo "Erro no cadastro" . $conexao -> error;
    }
    $conexao->close();
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
