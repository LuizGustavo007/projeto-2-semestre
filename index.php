<?php
include './bd/conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']); 

    // Atualização para tabela e colunas do banco de dados atualizado
    $query = "SELECT * FROM clientes WHERE nome_cliente = '$nome'";
    $result = mysqli_query($conexao, $query);

    if ($result && $result->num_rows > 0) {
        $usuario_logado = mysqli_fetch_assoc($result);

        // Validação da senha
        if (password_verify($senha, $usuario_logado['senha'])) {
            $_SESSION['usuario_sessao'] = $usuario_logado['nome_cliente']; // Nome do cliente
            header('Location: ./paginas/pagina_inicial.php'); // Redireciona após login bem-sucedido
            exit();
        } else {
            echo '<script>alert("Senha incorreta.");</script>';
        }
    } else {
        echo '<script>alert("Usuário não encontrado.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal História - Login</title>
    <link rel="icon" href="../img/img_para_colocar_no_title-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="login">
        <img src="../img/logo_semfundo.png" alt="" class="logo">
        
        <form action="" method="POST">
            <label for="nome">Nome:</label>
            <input name="nome" type="text" required>

            <label for="senha">Senha:</label>
            <input name="senha" type="password" required>

            <button type="submit">Enviar</button>

            <a id="cadastro" href="../paginas/cadastro.php">Cadastre-se</a>
        </form>
    </div>
</body>
</html>
