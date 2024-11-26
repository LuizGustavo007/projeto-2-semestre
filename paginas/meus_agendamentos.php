<?php
session_start();

if ($_SESSION['id_cliente']=="" && $_SESSION['usuario_sessao']=="") {
    header("Location: ../index.php");
    exit();
}
?>
<?php
session_start();


if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

if ($mysqli->connect_error) {
    die("Erro de conexão com o banco de dados: " . $mysqli->connect_error);
}


$id_cliente = $_SESSION['id_cliente'];


$sql = "SELECT dia_semana, horario FROM agendamentos WHERE id_cliente = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $mysqli->error);
}

$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();


$agendamentos = [];
while ($row = $result->fetch_assoc()) {
    $agendamentos[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
    <link rel="stylesheet" href="../css/tudodeagendamento.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <a href="pagina_inicial.php">Início</a>
            <a href="serviços.php">Serviços</a>
            <a href="meus_agendamentos.php">Agendamentos</a> 
            <a href="sobre_nos.php">Sobre nós</a>
            <a href="../bd/logout.php">Sair</a>
        </nav>
    </header>

    <h2>Meus Agendamentos</h2>
    <div class="agendamentos-list">
        <?php if (count($agendamentos) > 0): ?>
            <ul>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <li>
                        <strong>Dia:</strong> <?= ucfirst($agendamento['dia_semana']); ?><br>
                        <strong>Horário:</strong> <?= $agendamento['horario']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você não possui agendamentos.</p>
        <?php endif; ?>
    </div>
</body>
</html>
