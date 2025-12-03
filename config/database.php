<?php

$host = 'localhost';
$port = 3306;
$dbname = 'rolezao_escolar';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET time_zone = '-04:00'");
    
    function getConnection() {
        global $pdo;
        return $pdo;
    }
    
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>