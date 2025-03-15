<?php
$host = 'localhost';
$dbname = 'reservafacil';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexão com o banco de dados realizada com sucesso!";
} catch (PDOException $e) {

    echo "Erro de conexão: " . $e->getMessage();
}
?>