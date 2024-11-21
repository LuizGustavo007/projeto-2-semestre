<?php
// Iniciar a sessão para verificar o login (caso esteja usando um sistema de autenticação)
session_start();

// Conectar ao banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

// Verificar conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verifica se o id_cliente está presente na sessão ou na URL
if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente']; // Recupera o ID do cliente da sessão
} elseif (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente']; // Recupera o ID do cliente pela URL
} else {
    // Se o id_cliente não for encontrado, exibe um erro ou redireciona para login
    echo "Erro: id_cliente não fornecido.";
    exit;
}

// Consulta para pegar os agendamentos do cliente
$sql = "SELECT dia_semana, horario FROM agendamentos WHERE id_cliente = ?";
$stmt = $mysqli->prepare($sql);
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
</head>
<body>
    <h2>Meus Agendamentos</h2>
    
    <?php if (empty($agendamentos)): ?>
        <p>Você ainda não tem agendamentos.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Horário</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?php echo ucfirst($agendamento['dia_semana']); ?></td>
                        <td><?php echo $agendamento['horario']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
