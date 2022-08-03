<?php

$host = 'localhost';
$database = 'moviestar';
$user = 'root';
$password = 'root123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    $error = $e->getMessage();
    echo "Erro: $error";
}
    