<?php
session_start();

require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');

if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {

    header("Location: /reservaFacil/ReservaFacil/View/login/index.php");
    exit;
}

$conn = Conexao::conectar();
$admin_nome = $_SESSION['user_nome'];
$mensagem_geral = "";

$stmtIda = $conn->prepare("
    SELECT u.nome, u.email 
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    WHERE r.ida = 1 AND r.data_viagem = CURDATE() AND u.tipo_usuario = 3 
    ORDER BY u.nome ASC
");
$stmtIda->execute();
$passageirosIda = $stmtIda->fetchAll(PDO::FETCH_ASSOC);

$stmtVolta = $conn->prepare("
    SELECT u.nome, u.email
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    WHERE r.volta = 1 AND r.data_viagem = CURDATE() AND u.tipo_usuario = 3
    ORDER BY u.nome ASC
");
$stmtVolta->execute();
$passageirosVolta = $stmtVolta->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../login/style.css"> 
    <style>
        
        body {
            flex-direction: column; 
            justify-content: flex-start; 
            align-items: center; 
            min-height: 100vh;
        }

        .admin-header {
            width: 100%;
            background-color: var(--primary-color);
            color: var(--background-light);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .admin-header h1 {
            font-size: 1.5em;
            margin: 0;
        }

        .admin-header a { 
            color: var(--background-light);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px; 
            background-color: var(--secondary-color);
            transition: background-color 0.3s ease;
            font-size: 16px; 
            height: 47px;
            line-height: calc(47px - 16px); 
            border: none;
        }
        .admin-header a:hover {
            background-color: #167f8c; 
        }

        .admin-container {
            background-color: var(--background-light);
            padding: 30px 40px;
            width: 80%; 
            max-width: 1200px; 
            margin-top: 30px; 
            border-radius: 20px; 
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .admin-container h2 {
            font-size: 24px; 
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
        }
        
        .admin-menu {
            margin-bottom: 30px;
        }
        .admin-menu h3 {
            font-size: 20px;
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .admin-menu-buttons {
            display: flex;
            gap: 15px; 
            flex-wrap: wrap; 
        }

        .admin-menu-buttons button { 
            width: auto; 
            padding: 0 25px; 
            height: 47px;
            background: var(--primary-color);
            border-radius: 20px;
            outline: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .admin-menu-buttons button.cadastrar-motorista {
            background: var(--secondary-color);
        }

        .admin-menu-buttons button:hover {
            opacity: 0.9;
        }
         .admin-menu-buttons button.cadastrar-motorista:hover {
            background: #167f8c;
        }


        .passenger-lists-container {
            display: flex;
            justify-content: space-between;
            gap: 30px; 
            flex-wrap: wrap; 
        }

        .passenger-list {
            flex: 1; 
            min-width: 300px; 
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid var(--input-border);
        }

        .passenger-list h3 {
            font-size: 20px;
            color: var(--text-color);
            margin-top: 0;
            margin-bottom: 15px;
        }

        .passenger-list ul {
            list-style-type: none; 
            padding: 0;
        }

        .passenger-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            color: var(--text-color);
            font-size: 15px;
        }
        .passenger-list li:last-child {
            border-bottom: none;
        }
        .passenger-list .no-passengers {
            color: #777;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .admin-container { width: 95%; padding: 20px; }
            .admin-header { padding: 15px 20px; flex-direction: column; align-items: flex-start; }
            .admin-header h1 { margin-bottom: 10px; }
            .admin-menu-buttons { flex-direction: column; }
            .admin-menu-buttons button { width: 100%; }
            .passenger-lists-container { flex-direction: column; }
            .passenger-list { min-width: 100%; }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>ReservaFácil - Admin</h1>
        <a href="/ReservaFacil/View/login/logout.php">Sair</a>
    </header>

    <div class="admin-container">
        <h2>Bem-vindo(a), <?php echo htmlspecialchars($admin_nome); ?>!</h2>

        <?php if (!empty($mensagem_geral)): ?>
            <p class="form-box-message <?php echo (strpos(strtolower($mensagem_geral), 'sucesso') !== false) ? 'success' : 'error'; ?>">
                <?php echo $mensagem_geral; ?>
            </p>
        <?php endif; ?>

        <div class="admin-menu">
            <h3>Menu de Gerenciamento:</h3>
            <div class="admin-menu-buttons">
                <button onclick="window.location.href='gerenciarUsuarios.php'">Gerenciar Usuários</button>
                <button class="cadastrar-motorista" onclick="window.location.href='cadastrar_motorista.php'">Cadastrar Motorista</button>
            </div>
        </div>

        <h2>Lista de Passageiros para Hoje (<?php echo date("d/m/Y"); ?>)</h2>
        <div class="passenger-lists-container">
            <div class="passenger-list">
                <h3>Passageiros - Ida</h3>
                <?php if (count($passageirosIda) > 0): ?>
                    <ul>
                        <?php foreach ($passageirosIda as $passageiro): ?>
                            <li><?php echo htmlspecialchars($passageiro['nome']); ?> (<?php echo htmlspecialchars($passageiro['email']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-passengers">Nenhum passageiro confirmado para ida hoje.</p>
                <?php endif; ?>
            </div>

            <div class="passenger-list">
                <h3>Passageiros - Volta</h3>
                <?php if (count($passageirosVolta) > 0): ?>
                    <ul>
                        <?php foreach ($passageirosVolta as $passageiro): ?>
                            <li><?php echo htmlspecialchars($passageiro['nome']); ?> (<?php echo htmlspecialchars($passageiro['email']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-passengers">Nenhum passageiro confirmado para volta hoje.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>