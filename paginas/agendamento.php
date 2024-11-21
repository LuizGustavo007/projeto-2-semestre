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

// Carregar os agendamentos existentes para um determinado dia
function get_agendamentos($dia_semana) {
    global $mysqli;
    $sql = "SELECT horario FROM agendamentos WHERE dia_semana = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $dia_semana);
    $stmt->execute();
    $result = $stmt->get_result();
    $agendamentos = [];

    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row['horario'];
    }

    return $agendamentos;
}

// Gerar todos os horários
$available_times = generate_time_slots(); // Chama a função para gerar os horários
$days_of_week = ['segunda', 'terça', 'quarta', 'quinta', 'sexta'];
$agendamentos_por_dia = [];

// Preencher o array de agendamentos por dia
foreach ($days_of_week as $day) {
    $agendamentos_por_dia[$day] = get_agendamentos($day);
}
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
    <script>
        // Passando as informações de agendamentos e horários disponíveis para o JavaScript
        const agendamentosPorDia = <?php echo json_encode($agendamentos_por_dia); ?>;
        const availableTimes = <?php echo json_encode($available_times); ?>;

        function updateAvailableTimes() {
            const day = document.getElementById('dia').value;
            const timeSelect = document.getElementById('horario');
            const availableTimesForDay = availableTimes.filter(time => {
                return !agendamentosPorDia[day].includes(time); // Filtra os horários disponíveis
            });

            // Limpar os horários anteriores
            timeSelect.innerHTML = '<option value="">Escolha o horário</option>';
            
            if (day) {
                availableTimesForDay.forEach(function(time) {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });

                // Habilitar o dropdown de horários
                timeSelect.disabled = false;
            } else {
                timeSelect.disabled = true;
            }

            // Habilitar ou desabilitar o botão de prosseguir
            toggleProceedButton();
        }

        function toggleProceedButton() {
            const day = document.getElementById('dia').value;
            const time = document.getElementById('horario').value;
            const proceedButton = document.getElementById('proceed-button');
            
            // O botão só ficará habilitado se o dia e o horário forem selecionados
            if (day && time) {
                proceedButton.disabled = false;
            } else {
                proceedButton.disabled = true;
            }
        }
    </script>
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

<!-- Seletor de Dia -->
<div class="selector-container">
    <label for="dia">Escolha o dia:</label>
    <select id="dia" name="dia" onchange="updateAvailableTimes()">
        <option value="">Selecione o dia</option>
        <?php foreach ($days_of_week as $day) { ?>
            <option value="<?php echo $day; ?>"><?php echo ucfirst($day); ?></option>
        <?php } ?>
    </select>
</div>

<!-- Seletor de Horário -->
<div class="selector-container">
    <label for="horario">Escolha o horário:</label>
    <select id="horario" name="horario" disabled onchange="toggleProceedButton()">
        <option value="">Escolha o horário</option>
    </select>
</div>

<!-- Botão de Prosseguir -->
<div class="selector-container">
<button id="proceed-button" disabled 
    onclick="location.href='confirmar_agendamento.php?dia=' + document.getElementById('dia').value + '&hora=' + document.getElementById('horario').value;">
    Prosseguir
</button>
</div>

</body>
</html>
