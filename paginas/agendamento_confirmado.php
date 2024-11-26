<?php
session_start();

if ($_SESSION['id_cliente']=="" && $_SESSION['usuario_sessao']=="") {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Concluído</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Agendamento Concluído',
            text: 'Seu agendamento foi realizado com sucesso!',
            confirmButtonText: 'Voltar ao Início'
        }).then(() => {
            window.location.href = 'pagina_inicial.php';
        });
    </script>
</body>
</html>
