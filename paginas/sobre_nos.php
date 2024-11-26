<?php
session_start();

if ($_SESSION['id_cliente']=="" && $_SESSION['usuario_sessao']=="") {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Sobre nós - Planeta Pet</title>
    <link rel="stylesheet" href="../css/sobre_nos.css">
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
    
        <section class="sobre">
            <h2>Sobre nós</h2>
            <div class="sobrec">
                <img id="imglogo" src="../img/logo.png" alt="Planeta Pet Logo Grande">
            </div>
            <p id="apres">
                Somos apaixonados por animais, nossa equipe de especialistas está sempre pronta para ajudar.
                Oferecemos serviços de banho e tosa. <br> Venha nos visitar e descubra por que somos o favorito
                dos amantes de pets!
            </p>
            <div class="missao-visao-valores">
                <div class="missao">
                    <h3>Missão</h3>
                    <p>Proporcionar bem-estar e qualidade de vida aos pets, oferecendo produtos, serviços e atendimento de excelência que garantam a felicidade e saúde dos animais e a satisfação dos seus tutores.</p>
                </div>
                <div class="visao">
                    <h3>Visão</h3>
                    <p>Ser referência no cuidado e na inovação no setor pet, reconhecido por proporcionar uma experiência diferenciada e completa para animais de estimação e seus donos, buscando sempre evolução e responsabilidade social.</p>
                </div>
                <div class="valores">
                    <h3>Valores</h3>
                    <p>Amor pelos Animais, excelência no atendimento, sustentabilidade, inovação, transparência e ética, responsabilidade Social</p>
                </div>
            </div>
        </section>
        <footer>
            <div class="footer-content">
                <div class="contact-info">
                    <h4>Horário de funcionamento</h4>
                    <p>De segunda a sexta-feira das 08h às 19:30h</p>
                    <h4>Entre em contato</h4>
                    <p>Telefone: (12) 12345-6789</p>
                    <p>WhatsApp: (12) 12345-6789</p>
                    <p>Email: contato@planetapet.com</p>
                </div>
                <div class="pagamento">
                    <h4>Formas de pagamento</h4><br>
                    <img src="../img/pagamento.png" alt="Formas de Pagamento">
                </div>
            </div>
        </footer>
    </body>
</html>