<?php
include '../bd/conexao.php';

$status = ''; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    $endereco = trim($_POST["endereco"]);
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];

    if ($senha !== $confirmar_senha) {
        $status = 'senha_nao_confere';
    } else {
        $sql_check = "SELECT id FROM clientes WHERE email = ?";
        $stmt_check = $conexao->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $status = 'email_existente';
        } else {
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO clientes (nome, email, telefone, endereco, senha) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conexao->prepare($sql_insert);
            $stmt_insert->bind_param("sssss", $nome, $email, $telefone, $endereco, $senha_hashed);

            if ($stmt_insert->execute()) {
                $status = 'sucesso';
                header("Location: cadastro.php?status=$status");  
                exit();
            } else {
                $status = 'erro_insercao';
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Cadastro</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="./img/logo_pet-removebg-preview.png" alt="Planeta Pet">
        </div>
        <div class="titulo">
            <p>Planeta Pet</p>
        </div>
    </div>

    <div class="register-container">
        <form id="register-form" action="cadastro.php" method="POST">
            <img class="imagemlogin" src="./img/logo_pet-removebg-preview.png" alt="Logo">
            <h1>Planeta Pet</h1>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required><br><br>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required><br><br>

            <label for="senha">Senha:</label>
            <input name="senha" type="password" id="senha" required><br><br>

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input name="confirmar_senha" type="password" id="confirmar_senha" required><br><br>

            <button type="submit" id="submit-button">Cadastrar</button>
            <p><a href="../login/login.php">Já tem uma conta? Faça login.</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAlertBasedOnStatus() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            switch (status) {
                case 'sucesso':
                    Swal.fire({
                        title: 'Cadastro realizado com sucesso!',
                        text: 'Você será redirecionado para o login.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        window.location.href = '../login/login.php';  
                    });
                    break;
                case 'email_existente':
                    Swal.fire({
                        title: 'Erro',
                        text: 'Este e-mail já está cadastrado. Tente fazer login.',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    break;
                case 'senha_nao_confere':
                    Swal.fire({
                        title: 'Erro',
                        text: 'As senhas não coincidem. Tente novamente.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    break;
                case 'erro_insercao':
                    Swal.fire({
                        title: 'Erro',
                        text: 'Erro ao cadastrar. Tente novamente mais tarde.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    break;
                default:
                    break;
            }
        }

        window.onload = showAlertBasedOnStatus;
    </script>
</body>
</html>
