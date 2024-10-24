<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Cadastro</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./main.js"></script>
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
        <form id="register-form">
            <img class="imagemlogin"  src="./img/logo_pet-removebg-preview.png" alt="">
            <h1>Planeta Pet</h1>
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Senha :</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm-password">Confirmar Senha :</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <button type="submit">Confirmar</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
