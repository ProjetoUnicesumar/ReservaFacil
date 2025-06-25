<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    die("Acesso negado.");
}

require_once(__DIR__ . '/Funcoes.php');

if (isset($_GET['id'])) {
    $id_usuario = (int)$_GET['id'];
    $funcoes = new Funcoes();
    
    $funcoes->InativarUsuario($id_usuario);
}

header("Location: gerenciarUsuarios.php");
exit;
?>