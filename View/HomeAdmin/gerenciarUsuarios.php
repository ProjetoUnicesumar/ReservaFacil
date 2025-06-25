<?php


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: /View/login/index.php"); 
    exit;
}

require_once (__DIR__  . "/Funcoes.php");

$funcoes = new Funcoes();

$users = $funcoes->ListarUsuarios();

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

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        .user-table th, .user-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .user-table th {
            background-color: #f2f2f2;
            color: var(--primary-color);
            font-weight: bold;
        }

        .user-table td.actions {
            text-align: center;
        }

        .user-table td.actions a {
            margin-right: 0 8px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: bold;
            padding: 5px 8px;
            border-radius: 5px;
        }

        .user-table td.actions a:hover {
            background-color: #e9e9e9;
        }

        .user-table td.actions a.delete {
            color: #d9534f;
        }

        .user-table td.actions a.delete:hover {
            color: #d9534f;
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }
            .admin-header h1 {
                margin-bottom: 15px;
            }
            .admin-header a {
                text-align: center;
                width: 100%;
            }

            .user-table th, .user-table td {
                padding: 10px 5px;
                font-size: 14px;
                text-align: center;
            }

            .user-table td.actions a {
                display: block;
                margin-bottom: 5px;
                padding: 6px;
            }
            .user-table td.actions a:last-child {
                margin-bottom: 0;
            }
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

        <h2>Lista de Usuários</h2>
    <div class="users-list">
    <?php if (!empty($users)): ?>
        <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nome do Usuário</th>
                    <th>Status</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo $usuario['status'] == 1 ? 'Ativo' : 'Inativo'; ?></td>
                        <td class="actions">
                            <a href="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>">Editar</a>
                            <?php if ($usuario['status'] == 0): ?>
                                <a href="ativar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>">Ativar</a>
                            <?php else: ?>
                                <a href="inativar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>">Inativar</a>
                            <?php endif; ?>
                            <a href="excluir_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="delete" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php else: ?>
        <p>Nenhum usuário encontrado.</p>
    <?php endif; ?>
</div>
    <a href="index.php" class="back-link">Retornar ao Painel Principal</a>
</div>
</body>
</html>