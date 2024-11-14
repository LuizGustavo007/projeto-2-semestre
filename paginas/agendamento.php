<?php
// Conectar ao banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

// Verificar conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Função para gerar os horários
function generate_time_slots() {
    $times = [];
    $start_time = strtotime('08:00');
    $end_time = strtotime('19:30');
    $interval = 40 * 60; // 40 minutos em segundos

    while ($start_time <= $end_time) {
        $times[] = date('H:i', $start_time);
        $start_time += $interval;
    }

    return $times;
}

// Carregar os agendamentos existentes
function get_agendamentos($dia_semana, $horario) {
    global $mysqli;
    $sql = "SELECT horario FROM agendamentos WHERE dia_semana = ? AND horario = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $dia_semana, $horario);
    $stmt->execute();
    $result = $stmt->get_result();
    $agendamentos = [];
    
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row['horario'];
    }

    return $agendamentos;
}

$days_of_week = ['segunda', 'terça', 'quarta', 'quinta', 'sexta'];
$available_times = generate_time_slots(); // Chama a função para gerar os horários
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Agendamento</title>
    <link rel="stylesheet" href="../css/calendario.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../img/logo.semtextosemfundo.png" alt="Logo Planeta Pet">
        <span>Planeta Pet</span>
    </div>
    <nav>
        <a href="pagina_inicial.php">Início</a>
        <a href="serviços.php">Serviços</a>
        <a href="sobre_nos.php">Sobre nós</a>
        <a href="agendamento.php">Calendário</a>
        
    </nav>
</header>

<h2>Agendamento de Consultas</h2>

<table>
    <thead>
        <tr>
            <?php foreach ($days_of_week as $day) { ?>
                <th><?php echo ucfirst($day); ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($available_times as $time) {
            echo "<tr>";

            foreach ($days_of_week as $day) {
                $agendamentos = get_agendamentos($day, $time); // Verifica agendamentos para esse dia e horário
                $is_available = empty($agendamentos); // Verifica se o horário está disponível
                $btn_class = $is_available ? 'btn' : 'btn disabled'; // Se disponível, habilita o botão
                $disabled = $is_available ? '' : 'disabled'; // Desabilita o link se não estiver disponível
                $url = $is_available ? "agenda.php?dia=$day&hora=$time" : "#"; // Link para o agendamento

                echo "<td><a href=\"$url\" class=\"$btn_class\" $disabled>$time</a></td>";
            }

            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
