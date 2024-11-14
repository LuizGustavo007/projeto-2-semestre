<?php
session_start(); // Inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet</title>
    <link rel="stylesheet" href="../css/pagina_inicial.css">
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
                <a href="sobre_nos.php">Sobre nós</a>
                <a href="agendamento.php">Calendário</a>

                <?php if (isset($_SESSION['email'])): ?>
                    <!-- Exibe o ícone de usuário se o usuário estiver logado -->
                    <a href="perfil.php" class="user-icon">
                        <img src="../img/user-icon.png" alt="Ícone de usuário" />
                    </a>
                    <a href="logout.php" class="logout">Sair</a> <!-- Link para o logout -->
                <?php else: ?>
                    <a href="login.php">Login</a> <!-- Link para o login caso não esteja logado -->
                <?php endif; ?>
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
            <p>
                Você sabia que a tosa não serve apenas para deixar os cães mais bonitos?<br>
                Esse procedimento é muito importante para a saúde e higiene desses animais! <br>
                Por isso, conhecer os tipos de tosa pode ser muito útil para os cuidados com o pet.
            </p><br>
            <div class="service-options">
                <div class="service-item">
                    <img src="../img/dogbranco.PNG" alt="Tosa Higiênica">
                    <h3>Tosa Higiênica</h3>
                </div>
                <div class="service-item">
                    <img src="../img/dogbranco.PNG" alt="Tosa na Tesoura">
                    <h3>Tosa na tesoura</h3>
                </div>
                <div class="service-item">
                    <img src="../img/dogbranco.PNG" alt="Tosa na Máquina">
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
