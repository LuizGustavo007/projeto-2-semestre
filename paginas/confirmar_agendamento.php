<?php
session_start();

if ($_SESSION['id_cliente']=="" && $_SESSION['usuario_sessao']=="") {
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../index.php?error=login_required'); 
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

if ($mysqli->connect_error) {
    die("Erro de conexão com o banco de dados: " . $mysqli->connect_error);
}


$id_cliente = $_SESSION['id_cliente'];
$dia = $_GET['dia'] ?? '';
$hora = $_GET['hora'] ?? '';


if (!$dia || !$hora) {
    header('Location: agendamentos.php?error=missing_data');
    exit();
}


$sql = "SELECT * FROM agendamentos WHERE dia_semana = ? AND horario = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ss', $dia, $hora);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die('Esse horário já foi reservado.');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO agendamentos (dia_semana, horario, id_cliente) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssi', $dia, $hora, $id_cliente);

    if ($stmt->execute()) {
        header('Location: agendamento_confirmado.php');
        exit();
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
    <link rel="stylesheet" href="../css/tudodeagendamento.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
