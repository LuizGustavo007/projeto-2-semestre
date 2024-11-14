<?php
include '../bd/conexao.php';


$horarios = array();
$horaInicial = 8; 
$minutoInicial = 0; 


for ($i = 0; $i < 15; $i++) {
    $hora = str_pad($horaInicial, 2, "0", STR_PAD_LEFT);
    $minuto = str_pad($minutoInicial, 2, "0", STR_PAD_LEFT);
    $horarios[] = "$hora:$minuto"; 
    
    $minutoInicial += 40;
    if ($minutoInicial >= 60) {
        $minutoInicial = $minutoInicial - 60;
        $horaInicial++;
    }
}

$daysOfWeek = array('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta');


$agendamentos = array();
foreach ($daysOfWeek as $dia) {
    
    $stmt = $conexao->prepare("SELECT horario, id_cliente FROM agendamentos WHERE dia_semana = :dia");
    $stmt->bindParam(':dia', $dia, PDO::PARAM_STR); 
    $stmt->execute();
    $agendamentos[$dia] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet</title>
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
            <a href="../calendario/agendamento.php">Calendario</a>
            <a href="../index.php">Login</a>
        </nav>
    </header>

    <h1>Agendamento de Atendimento</h1>
    
    <form method="POST" action="agendar.php">
        <table>
            <thead>
                <tr>
                    <th>Horário</th>
                    <?php foreach ($daysOfWeek as $dia) { ?>
                        <th><?php echo $dia; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horarios as $hora) { ?>
                    <tr>
                        <td><?php echo $hora; ?></td>
                        <?php foreach ($daysOfWeek as $dia) { 
                            $status = 'available';
                            foreach ($agendamentos[$dia] as $agendamento) {
                                if ($agendamento['horario'] == $hora) {
                                    $status = 'booked';
                                    break;
                                }
                            }
                        ?>
                            <td class="<?php echo $status; ?>" 
                                <?php if ($status == 'available') { ?>
                                    onclick="window.location.href='agendar.php?dia=<?php echo $dia; ?>&hora=<?php echo $hora; ?>'">
                                <?php } ?>
                            >
                                <?php echo $status == 'available' ? 'Disponível' : 'Agendado'; ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>

    <footer>
        <div class="info">
            <p><strong>Horário de funcionamento</strong><br>
                De segunda à sexta-feira das 08h às 19:30h</p>
            <p><strong>Entre em contato</strong><br>
                Telefone: (12) 12345-6789<br>
                WhatsApp: (12) 12345-6789<br>
                contato@planetapet.com</p>
        </div>
        <div class="formas-pagamento">
            <p>Formas de pagamento</p>
            <div class="icones-pagamento">
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
    <script src="script.js"></script>
</body>
</html>