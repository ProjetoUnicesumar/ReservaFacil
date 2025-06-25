<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    die("Acesso negado. Você não tem permissão para executar esta ação.");
}

require_once(__DIR__ . '/Funcoes.php');

if (isset($_GET['id'])) {
    
    $id_usuario = (int)$_GET['id'];

    $funcoes = new Funcoes();
    
    $funcoes->AtivarUsuario($id_usuario);
}

header("Location: gerenciarUsuarios.php");
exit;
?>