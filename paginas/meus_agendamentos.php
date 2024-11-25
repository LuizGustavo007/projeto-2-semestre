<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../index.php');
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit;
}

$id_cliente = $_SESSION['id_cliente'];

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
    <link rel="stylesheet" href="../css/style.css"> <!-- Ajuste o caminho do CSS -->
</head>
<body>
    <header>
        <nav>
            <a href="pagina_inicial.php">Início</a>
            <a href="serviços.php">Serviços</a>
            <a href="sobre_nos.php">Sobre nós</a>
            <a href="agendamento.php">Calendário</a>
            <a href="../bd/logout.php">Sair<img id="logout" src="../img/sair.png" alt=""></a>
        </nav>
    </header>

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
