<?php
$host = 'localhost';
$dbname = 'planeta_pet';
$username = 'root';
$password = ''; // Ajuste a senha conforme necessário

try {
    // Criação da conexão com PDO
    $conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ativa exceções para erros no PDO
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Define o modo de fetch padrão como associativo
} catch (PDOException $e) {
    // Tratamento de erro
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit(); // Interrompe a execução em caso de erro
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet</title>
</head>
<body>
</body>
</html>
