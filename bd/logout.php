<?php
session_start();

if (isset($_SESSION['nome_cliente'])) {
    unset($_SESSION['nome_cliente']); 
}

session_unset();

session_destroy();
header('Location: ../index.php');
exit();
?>