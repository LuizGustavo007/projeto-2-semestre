<?php
include '../bd/conexao.php';

if (isset($_GET['dia']) && isset($_GET['hora'])) {
    $dia = $_GET['dia'];
    $hora = $_GET['hora'];

    echo "
    <div class='form-container'>
        <h2>Agendar para $dia às $hora</h2>
        <form method='POST'>
            <div class='form-group'>
                <label for='cliente_id'>Cliente:</label>
                <select name='cliente_id' id='cliente_id'>
    ";

    $stmt = $conn->prepare("SELECT id_cliente, nome_cliente FROM clientes");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($clientes as $cliente) {
        echo "<option value='" . $cliente['id_cliente'] . "'>" . $cliente['nome_cliente'] . "</option>";
    }

    echo "
                </select>
            </div>
            <div class='form-group'>
                <button type='submit' class='btn-submit'>Confirmar Agendamento</button>
            </div>
        </form>
    </div>
    ";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
    $cliente_id = $_POST['cliente_id'];

    $stmt = $conn->prepare("INSERT INTO agendamentos (id_cliente, dia_semana, horario, data_agendamento)
                            VALUES (:id_cliente, :dia_semana, :horario, CURDATE())");
    $stmt->execute([
        'id_cliente' => $cliente_id,
        'dia_semana' => $dia,
        'horario' => $hora
    ]);

    echo "<div class='alert success'>Agendamento realizado com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Atendimento - Planeta Pet</title>
    <link rel="stylesheet" href="calendario.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../img/logo.semtextosemfundo.png" alt="Logo Planeta Pet">
            <span>Planeta Pet</span>
        </div>
        <nav>
            <a href="../pagina inicial/paginainicial.php">Início</a>
            <a href="../serviços/serviços.php">Serviços</a>
            <a href="../sobre nos/sobrenos.php">Sobre nós</a>
            <a href="../calendario/agendamento.php">Calendário</a>
            <a href="../index.php">Login</a>
        </nav>
    </header>

    <main>
        <div class="container">
          
        </div>
    </main>

    <footer>
        <div class="footer-info">
            <p><strong>Horário de funcionamento:</strong> De segunda à sexta-feira das 08h às 19:30h</p>
            <p><strong>Entre em contato:</strong><br>
                Telefone: (12) 12345-6789<br>
                WhatsApp: (12) 12345-6789<br>
                contato@planetapet.com</p>
        </div>
        <div class="footer-payment">
            <p><strong>Formas de pagamento</strong></p>
            <div class="payment-icons">
                <div class="visa"></div>
                <div class="mastercard"></div>
                <div class="diners"></div>
                <div class="amex"></div>
                <div class="elo"></div>
                <div class="aura"></div>
                <div class="hipercard"></div>
                <div class="boleto"></div>
            </div>
        </div>
    </footer>
</body>
</html>
