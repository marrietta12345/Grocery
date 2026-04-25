<?php
require 'user_management.php'; // include your PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (first_name, middle_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $middle_name, $last_name, $email, $password]);

    echo "Registration successful!";
}
?>