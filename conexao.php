<?php
// Dados da conexão
$dbname = 'planeta_pet'; // Verifique se o nome do banco de dados está correto
$username = 'root'; // Verifique o nome do usuário
$password = ''; // Verifique a senha (se estiver vazia mesmo)
$host = 'localhost'; // Verifique o host (para servidor local, geralmente é 'localhost')

// Criando a conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $dbname);

// Verificando se a conexão foi bem-sucedida
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
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