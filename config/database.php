<?php

class Database {
    private static $pdo = null;
    
    private static $host = 'localhost';
    private static $port = 3306;
    private static $dbname = 'rolezao_escolar';
    private static $user = 'root';
    private static $password = '';
    
    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    "mysql:host=" . self::$host . 
                    ";port=" . self::$port . 
                    ";dbname=" . self::$dbname . 
                    ";charset=utf8mb4",
                    self::$user,
                    self::$password
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->exec("SET time_zone = '-04:00'");
            } catch (PDOException $e) {
                throw new Exception("Erro na conexão com banco de dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

// Função auxiliar para compatibilidade
function getConnection() {
    return Database::getConnection();
}
?>