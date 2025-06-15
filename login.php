<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanifica input base
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: homepage.php");
        exit;
    } else {
        // Puoi aggiungere logging degli accessi falliti se vuoi
        header("Location: login.html?errore=credenziali");
        exit;
    }
}
// Nessun HTML dopo, solo PHP puro per la login!
?>