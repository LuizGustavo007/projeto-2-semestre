<?php
session_start();

// Conectar ao banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

// Verificar conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verificar autenticação do cliente
if (!isset($_SESSION['id_cliente'])) {
    die('Cliente não autenticado.');
}

$id_cliente = $_SESSION['id_cliente']; // ID do cliente autenticado
$dia = $_GET['dia'] ?? '';
$hora = $_GET['hora'] ?? '';

if (!$dia || !$hora) {
    die('Dia e horário são obrigatórios.');
}

// Verificar se o horário já está reservado
$sql = "SELECT * FROM agendamentos WHERE dia_semana = ? AND horario = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ss', $dia, $hora);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die('Esse horário já foi reservado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inserir o agendamento com o ID do cliente
    $sql = "INSERT INTO agendamentos (dia_semana, horario, id_cliente) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssi', $dia, $hora, $id_cliente);

    if ($stmt->execute()) {
        header('Location: agendamento_confirmado.php');
        exit;
    } else {
        die('Erro ao agendar.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Agendamento</title>
</head>
<body>
    <h2>Confirme seu Agendamento</h2>
    <p><strong>Dia:</strong> <?= ucfirst($dia); ?></p>
    <p><strong>Horário:</strong> <?= $hora; ?></p>

    <form method="POST">
        <button type="submit">Confirmar Agendamento</button>
        <button type="button" onclick="location.href='agendamento.php'">Cancelar</button>
    </form>
</body>
</html>
