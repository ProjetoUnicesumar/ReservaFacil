<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: /ReservaFacil/View/login/index.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="../login/style.css"> 
    <style>
        body { display: flex; flex-direction: column; align-items: center; justify-content: flex-start; }
        .admin-header { width: 100%; background-color: var(--primary-color); color: var(--background-light); padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .admin-header h1 { font-size: 1.5em; margin: 0; }
        .admin-header a { color: var(--background-light); text-decoration: none; padding: 8px 15px; border-radius: 20px; background-color: var(--secondary-color); font-size: 16px; height: 47px; line-height: calc(47px - 16px); border: none; }
        .admin-header a:hover{ background-color: #167f8c; }

        .content-area { background-color: #fff; padding: 30px; margin-top: 30px; border-radius: 15px; width: 80%; max-width: 800px; text-align: center; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .content-area h2 { color: var(--primary-color); margin-bottom: 15px;}
        .content-area p { margin-bottom: 10px; line-height: 1.6;}
        .content-area a.back-link { 
            display: inline-block; 
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-size: 16px;
        }
        .content-area a.back-link:hover {
             background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>Gerenciar Usuários</h1>
        <a href="index.php">Voltar ao Painel</a>
    </header>
    <div class="content-area">
        <h2>Gerenciamento de Usuários</h2>
        <p>Esta página permitirá ao administrador visualizar, editar, ativar/inativar e excluir usuários (passageiros e motoristas).</p>
        <p><strong>Funcionalidade em desenvolvimento.</strong></p>

        <a href="index.php" class="back-link">Retornar ao Painel Principal</a>
    </div>
</body>
</html>