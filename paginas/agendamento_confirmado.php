<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Concluído</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
