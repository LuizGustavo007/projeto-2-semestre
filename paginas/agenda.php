<?php
// Conectar ao banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

// Verificar conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Obter os parâmetros da URL
$dia_semana = $_GET['dia'];
$horario = $_GET['hora'];

// ID do cliente, que pode ser obtido após login, por exemplo
$id_cliente = 1;  // Exemplo: você pode pegar isso de um formulário de login ou sessão

// Verificar se o cliente existe na tabela
$sql_cliente = "SELECT id_cliente FROM clientes WHERE id_cliente = ?";
$stmt_cliente = $mysqli->prepare($sql_cliente);
$stmt_cliente->bind_param('i', $id_cliente);
$stmt_cliente->execute();
$stmt_cliente->store_result();

// Se o cliente não existir, mostrar um erro
if ($stmt_cliente->num_rows == 0) {
    die("Erro: Cliente não encontrado!");
}

// Inserir o agendamento no banco de dados
$sql = "INSERT INTO agendamentos (id_cliente, dia_semana, horario, data_agendamento) VALUES (?, ?, ?, CURDATE())";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iss', $id_cliente, $dia_semana, $horario);
$stmt->execute();

// Redirecionar para a página de sucesso
header("Location: sucesso.php");
exit;
?>
