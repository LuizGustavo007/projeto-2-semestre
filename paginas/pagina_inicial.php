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
    <title>Planeta Pet</title>
    <link rel="stylesheet" href="../css/pagina_inicial.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
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

        <section class="promo">
            <div class="carousel">
                
                <div class="carousel-content">
                    <a href="serviços.php">
                    <img src="../img/ImgCarrossel.PNG" alt="Promoção de rações">
                    </a>
                </div>
                
            </div>
        </section>

        <section class="services">
            <h2>Tipos de tosa</h2><br>
            <p class="x1">
                Você sabia que a tosa não serve apenas para deixar os cães mais bonitos?<br>
                Esse procedimento é muito importante para a saúde e higiene desses animais! <br>
                Por isso, conhecer os tipos de tosa pode ser muito útil para os cuidados com o pet.
            </p><br>
            <div class="service-options">
                <div class="service-item">
                    <img src="../img/tosehigienica.PNG" alt="Tosa Higiênica">
                    <h3>Tosa Higiênica</h3>
                </div>
                <div class="service-item">
                    <img src="../img/tosatesoura1.PNG" alt="Tosa na Tesoura">
                    <h3>Tosa na tesoura</h3>
                </div>
                <div class="service-item">
                    <img src="../img/maquinatosa.PNG" alt="Tosa na Máquina">
                    <h3>Tosa na máquina</h3>
                </div>
            </div>
        </section>
    </div>
    
    <footer>
        <div class="footer-content">
            <div class="contact-info">
                <h4>Horário de funcionamento</h4>
                <p>De segunda a sexta-feira das 08h às 19:30h</p><br>
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
