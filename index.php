<?php
include './bd/conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha']; 

    $query = "SELECT * FROM clientes WHERE nome_clientes = '$nome'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        $usuario_logado = mysqli_fetch_assoc($result);

        if (password_verify($senha, $usuario_logado['pass_usuario'])) {
            $_SESSION['usuario_sessao'] = $usuario_logado['nome_clientes'];
            $_SESSION['tipo_sessao'] = $usuario_logado['tipo_clientes'];
            header('Location: ./paginas/pagina_inicial.php');
        } else {
            echo 'Senha incorreta';
        }
    } else {
        echo 'Usuário não encontrado';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal História</title>
    <link rel="icon" href="../img/img_para_colocar_no_title-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="login">
        <img src="./img/logo_semfundo.png" alt="Logo do Portal História" class="logo">
        
        <form action="" method="POST">
            <label for="nome">Nome:</label>
            <input name="nome" type="text" required>

            <label for="senha">Senha:</label>
            <input name="senha" type="password" required>

            <button type="submit">Enviar</button>

            <a id="cadastro" href="./paginas/cadastro.php">Cadastre-se</a>
        </form>
    </div>
</body>
</html>