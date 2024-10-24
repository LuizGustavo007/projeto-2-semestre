<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img class="imagemheader" src="./img/logo_pet-removebg-preview.png" alt="Planeta Pet" >
        </div>

        <div class="titulo">
            <p>Planeta Pet</p>
        </div>
    </div>

    <div class="login-container">
        <form>
            <img class="imgdologin" src="./img/logo_pet-removebg-preview.png" alt="" width="60" height="40">
            <h1>Planeta Pet</h1>
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email">
            <label for="password">Senha :</label>
            <input type="password" id="password" name="password">
            <!-- <button type="submit" >Acessar</button> -->
              <input type="button" value="Acessar" id="botao" onclick="window.location.href='../index.html';"/>
            <p><a href="../cadastro/index.html">Novo por aqui? Crie sua conta.</a></p>
        </form>
    </div>
</body>
</html>
