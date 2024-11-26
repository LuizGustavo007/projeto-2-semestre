<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis da sessão
session_unset();

// Destroi a sessão
session_destroy();

// Define cabeçalhos para impedir cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona para a página de login
header('Location: ../index.php?message=logout_success');
exit();
?>
