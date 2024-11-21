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

// Buscar os agendamentos do cliente
$sql = "SELECT dia_semana, horario FROM agendamentos WHERE id_cliente = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$agendamentos = [];
while ($row = $result->fetch_assoc()) {
    $agendamentos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
</head>
<body>
    <h2>Meus Agendamentos</h2>
    <?php if (count($agendamentos) > 0): ?>
        <ul>
            <?php foreach ($agendamentos as $agendamento): ?>
                <li>
                    <strong>Dia:</strong> <?= ucfirst($agendamento['dia_semana']); ?>,
                    <strong>Horário:</strong> <?= $agendamento['horario']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Você não possui agendamentos.</p>
    <?php endif; ?>

    <button onclick="location.href='pagina_inicial.php'">Voltar para a Página Inicial</button>
</body>
</html>
