<?php
session_start();

if ($_SESSION['id_cliente']=="" && $_SESSION['usuario_sessao']=="") {
    header("Location: ../index.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'planeta_pet');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function generate_time_slots() {
    $times = [];
    $start_time = strtotime('08:00');
    $end_time = strtotime('19:30');
    $interval = 40 * 60; 

    while ($start_time <= $end_time) {
        $times[] = date('H:i', $start_time);
        $start_time += $interval;
    }

    return $times;
}

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

$available_times = generate_time_slots();
$days_of_week = ['segunda', 'terça', 'quarta', 'quinta', 'sexta'];
$agendamentos_por_dia = [];

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
        const agendamentosPorDia = <?php echo json_encode($agendamentos_por_dia); ?>;
        const availableTimes = <?php echo json_encode($available_times); ?>;

        function updateAvailableTimes() {
            const day = document.getElementById('dia').value;
            const timeSelect = document.getElementById('horario');
            const availableTimesForDay = availableTimes.filter(time => {
                return !agendamentosPorDia[day].includes(time); 
            });

            timeSelect.innerHTML = '<option value="">Escolha o horário</option>';
            
            if (day) {
                availableTimesForDay.forEach(function(time) {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });

                timeSelect.disabled = false;
            } else {
                timeSelect.disabled = true;
            }

            toggleProceedButton();
        }

        function toggleProceedButton() {
            const day = document.getElementById('dia').value;
            const time = document.getElementById('horario').value;
            const proceedButton = document.getElementById('proceed-button');
            
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
        <a href="meus_agendamentos.php">Agendamentos</a>
        <a href="sobre_nos.php">Sobre nós</a>
        <a href="../bd/logout.php">Sair</a>

    </nav>
</header>

<h2>Agendamento de Consultas</h2>

<div class="selector-container">
    <label for="dia">Escolha o dia:</label>
    <select id="dia" name="dia" onchange="updateAvailableTimes()">
        <option value="">Selecione o dia</option>
        <?php foreach ($days_of_week as $day) { ?>
            <option value="<?php echo $day; ?>"><?php echo ucfirst($day); ?></option>
        <?php } ?>
    </select>
</div>

<div class="selector-container">
    <label for="horario">Escolha o horário:</label>
    <select id="horario" name="horario" disabled onchange="toggleProceedButton()">
        <option value="">Escolha o horário</option>
    </select>
</div>

<div class="selector-container">
<button id="proceed-button" disabled 
    onclick="location.href='confirmar_agendamento.php?dia=' + document.getElementById('dia').value + '&hora=' + document.getElementById('horario').value;">
    Prosseguir
</button>
</div>

</body>
</html>
