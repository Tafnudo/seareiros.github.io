<?php
session_start();

$senhaCorreta = "seareiros123";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senha = $_POST['password'];
    if ($senha === $senhaCorreta) {
        $_SESSION['loggedin'] = true;
        header("Location: admin.html");
        exit;
    } else {
        header("Location: login.html?error=1");
        exit;
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

// Aqui vai o conteúdo do seu `admin.html`
?>