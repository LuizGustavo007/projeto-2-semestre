<?php
include './bd/conexao.php';
session_start();

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($senha)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {
        try {
            // Buscar o cliente pelo nome
            $query = "SELECT * FROM clientes WHERE nome_cliente = :nome";
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();

            // Verificar se o cliente foi encontrado
            if ($stmt->rowCount() > 0) {
                $usuario_logado = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificar a senha com password_verify
                if (password_verify($senha, $usuario_logado['senha'])) {
                    $_SESSION['id_cliente'] = $usuario_logado['id_cliente'];
                    $_SESSION['usuario_sessao'] = $usuario_logado['nome_cliente'];

                    // Redirecionar para a página inicial
                    header('Location: ./paginas/pagina_inicial.php');
                    

                    // echo "Redirecionando para ./paginas/pagina_inicial.php";
                    exit();

                } else {
                    $mensagem = "Senha incorreta.";
                }
            } else {
                $mensagem = "Usuário não encontrado.";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Login</title>
    <link rel="icon" href="../img/img_para_colocar_no_title-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="login">
        <img src="./img/logo_semfundo.png" alt="Logo do Planeta Pet" class="logo">

        <form action="" method="POST">
            <?php if (!empty($mensagem)): ?>
                <div class="error-message"><?= htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>

            <label for="nome">Nome:</label>
            <input name="nome" type="text" required placeholder="Digite seu nome">

            <label for="senha">Senha:</label>
            <input name="senha" type="password" required placeholder="Digite sua senha">

            <button type="submit">Enviar</button>

            <p class="register-link">
                Não possui uma conta? <a href="./paginas/cadastro.php">Cadastre-se</a>
            </p>
        </form>
    </div>
</body>
</html>
