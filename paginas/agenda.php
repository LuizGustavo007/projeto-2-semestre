<?php
// Iniciar a sessão para verificar o login (caso esteja usando um sistema de autenticação)
session_start();

// Conectar ao banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

// Verificar conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Função para realizar o agendamento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia = $_POST['dia'];
    $hora = $_POST['hora'];
    $id_cliente = $_POST['id_cliente']; // O ID do cliente

    // Inserir o agendamento no banco de dados
    $sql = "INSERT INTO agendamentos (id_cliente, dia_semana, horario) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iss', $id_cliente, $dia, $hora);

    if ($stmt->execute()) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro ao realizar o agendamento: " . $stmt->error;
    }

    $stmt->close();
}

// Verifica se o id_cliente está presente na URL ou na sessão
if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente']; // Recupera o ID do cliente da sessão
} elseif (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente']; // Recupera o ID do cliente pela URL
} else {
    // Se o id_cliente não for encontrado, exibe um erro ou redireciona para login
    echo "Erro: id_cliente não fornecido.";
    exit;
}

// Pega o dia e hora passados na URL (parâmetros)
$dia = $_GET['dia'];
$hora = $_GET['hora'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
</head>
<body>
    <h2>Confirmar Agendamento</h2>
    <form method="POST" action="">
        <!-- Campos ocultos para passar o id_cliente, dia e hora para o servidor -->
        <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>"> <!-- ID do cliente -->
        <input type="hidden" name="dia" value="<?php echo htmlspecialchars($dia); ?>"> <!-- Dia da semana -->
        <input type="hidden" name="hora" value="<?php echo htmlspecialchars($hora); ?>"> <!-- Horário escolhido -->
        
        <p>Você deseja agendar para: <strong><?php echo ucfirst($dia) . " às " . $hora; ?></strong>?</p>
        <button type="submit">Confirmar Agendamento</button>
    </form>
</body>
</html>
