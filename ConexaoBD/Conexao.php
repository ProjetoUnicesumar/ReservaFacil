<?php
class Conexao {
    private static $host = 'localhost';
    private static $dbname = 'reservafacil';
    private static $username = 'root';
    private static $password = '';
    private static $pdo = null;

    public static function conectar() {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8";
                self::$pdo = new PDO($dsn, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
