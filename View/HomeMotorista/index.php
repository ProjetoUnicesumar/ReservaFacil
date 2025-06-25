<?php
session_start();

require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');

if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'motorista') {
    header("Location: /ReservaFacil/View/login/index.php");
    exit;
}

$conn = Conexao::conectar();
$motorista_nome = $_SESSION['user_nome'];

$stmtIda = $conn->prepare("
    SELECT u.nome, u.email, u.telefone 
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id_usuario
    WHERE r.ida = 1 AND r.data_viagem = CURDATE() AND u.tipo_usuario = 3 
    ORDER BY u.nome ASC
");
$stmtIda->execute();
$passageirosIda = $stmtIda->fetchAll(PDO::FETCH_ASSOC);

$stmtVolta = $conn->prepare("
    SELECT u.nome, u.email, u.telefone
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
    <title>Painel do Motorista</title>
    <link rel="stylesheet" href="../login/style.css"> 
    <style>
        body {
            flex-direction: column; 
            justify-content: flex-start; 
            align-items: center; 
            min-height: 100vh;
        }
        .panel-header {
            width: 100%;
            background-color: var(--primary-color);
            color: var(--background-light);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .panel-header h1 {
            font-size: 1.5em;
            margin: 0;
        }
        .panel-header a { 
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
        .panel-header a:hover {
            background-color: #167f8c; 
        }
        .main-container {
            background-color: var(--background-light);
            padding: 30px 40px;
            width: 80%; 
            max-width: 1200px; 
            margin-top: 30px; 
            border-radius: 20px; 
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .main-container h2 {
            font-size: 24px; 
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
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
            .main-container { width: 95%; padding: 20px; }
            .panel-header { padding: 15px 20px; flex-direction: column; align-items: flex-start; }
            .panel-header h1 { margin-bottom: 10px; }
            .passenger-lists-container { flex-direction: column; }
            .passenger-list { min-width: 100%; }
        }
    </style>
</head>
<body>
    <header class="panel-header">
        <h1>ReservaFácil - Motorista</h1>
        <a href="/ReservaFacil/View/login/index.php">Sair</a>
    </header>

    <div class="main-container">
        <h2>Bem-vindo(a), <?php echo htmlspecialchars($motorista_nome); ?>!</h2>

        <h2>Lista de Passageiros para Hoje (<?php echo date("d/m/Y"); ?>)</h2>
        <div class="passenger-lists-container">
            <div class="passenger-list">
                <h3>Passageiros - Ida</h3>
                <?php if (count($passageirosIda) > 0): ?>
                    <ul>
                        <?php foreach ($passageirosIda as $passageiro): ?>
                            <li><?php echo htmlspecialchars($passageiro['nome']); ?> (<?php echo htmlspecialchars($passageiro['telefone']); ?>)</li>
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
                             <li><?php echo htmlspecialchars($passageiro['nome']); ?> (<?php echo htmlspecialchars($passageiro['telefone']); ?>)</li>
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