<?php
session_start();

if ($_SESSION['id_cliente'] == "" && $_SESSION['usuario_sessao'] == "") {
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

if ($mysqli->connect_error) {
    die("Erro de conexão com o banco de dados: " . $mysqli->connect_error);
}

$id_cliente = $_SESSION['id_cliente'];

// Manipulação de exclusão de agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_agendamento'])) {
    $id_agendamento = intval($_POST['id_agendamento']);
    
    // Deletar agendamento se pertencer ao cliente
    $delete_sql = "DELETE FROM agendamentos WHERE id_agendamento = ? AND id_cliente = ?";
    $delete_stmt = $mysqli->prepare($delete_sql);
    if ($delete_stmt === false) {
        die("Erro ao preparar a consulta de exclusão: " . $mysqli->error);
    }
    $delete_stmt->bind_param('ii', $id_agendamento, $id_cliente);
    $delete_stmt->execute();
    $delete_stmt->close();
    
    // Redireciona para evitar reenvio do formulário
    header("Location: meus_agendamentos.php");
    exit();
}

// Buscar agendamentos
$sql = "SELECT id_agendamento, dia_semana, horario FROM agendamentos WHERE id_cliente = ?";
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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Meus Agendamentos - Planeta Pet</title>
    <link rel="stylesheet" href="../css/tudodeagendamento.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../img/logo.semtextosemfundo.png" alt="Logo Planeta Pet">
        <span id="site">Planeta Pet</span>
    </div>
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
                        <strong>Horário:</strong> <?= $agendamento['horario']; ?><br>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_agendamento" value="<?= $agendamento['id_agendamento']; ?>">
                            <button type="submit" class="delete-button">Excluir</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você não possui agendamentos.</p>
        <?php endif; ?>
    </div>
</body>
</html>
