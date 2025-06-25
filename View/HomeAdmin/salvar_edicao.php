<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    die("Acesso negado.");
}

require_once(__DIR__ . '/Funcoes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_usuario = (int)$_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $universidade = $_POST['universidade'];
    
    $funcoes = new Funcoes();
    $funcoes->atualizarUsuario($id_usuario, $nome, $email, $cidade, $bairro, $universidade);
    
    header("Location: gerenciarUsuarios.php?status=editado");
    exit;

} else {
    header("Location: gerenciarUsuarios.php");
    exit;
}
?>