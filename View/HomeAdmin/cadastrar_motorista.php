<?php
session_start();

require_once(__DIR__ . '/../../ConexaoBD/Conexao.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: /ReservaFacil/View/login/index.php"); 
    exit;
}

$mensagem = "";
$mensagem_tipo = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['confirmar_senha'])) {
        $mensagem = "Todos os campos são obrigatórios.";
        $mensagem_tipo = "error";
    } elseif ($_POST['senha'] !== $_POST['confirmar_senha']) {
        $mensagem = "As senhas não coincidem.";
        $mensagem_tipo = "error";
    } elseif (strlen($_POST['senha']) < 6) { 
        $mensagem = "A senha deve ter pelo menos 6 caracteres.";
        $mensagem_tipo = "error";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Formato de e-mail inválido.";
        $mensagem_tipo = "error";
    } else {
        $conn = Conexao::conectar();
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $tipo_usuario = 2;

        $stmtCheck = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();

        if ($stmtCheck->fetch()) {
            $mensagem = "Este e-mail já está cadastrado.";
            $mensagem_tipo = "error";
        } else {

            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (:nome, :email, :senha, :tipo_usuario)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);

            if ($stmt->execute()) {
                $mensagem = "Motorista cadastrado com sucesso!";
                $mensagem_tipo = "success";
                $_POST = array(); 
            } else {
                $mensagem = "Erro ao cadastrar motorista. Tente novamente.";
                $mensagem_tipo = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Motorista</title>
    <link rel="stylesheet" href="../login/style.css"> 
    <style>

        .form-box {
            width: 35%; 
            max-width: 500px; 
            margin-top: 50px; 
            margin-bottom: 50px;
        }
        .form-box h2 { 
            margin-bottom: 25px;
        }
        .message-box { 
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px; 
            font-size: 15px;
            font-weight: normal;
            text-align: center;
        }
        .message-box.success {
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb;
        }
        .form-box a.back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 15px;
        }
        .form-box a.back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-box {
                width: 90%;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .form-box h2 {
                font-size: 1.8rem;
            }

            
        }

    </style>
</head>
<body>
    <div class="form-box">
        <h2>Cadastrar Novo Motorista</h2>

        <?php if (!empty($mensagem)): ?>
            <div class="message-box <?php echo $mensagem_tipo; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form action="cadastrar_motorista.php" method="POST" novalidate>
            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Nome do motorista" required 
                       value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
            </div>
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="email@example.com" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="input-group">
                <label for="confirmar_senha">Confirmar Senha</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Repita a senha" required>
            </div>
            <div class="input-group">
                <button type="submit">Cadastrar Motorista</button>
            </div>
        </form>
        <a href="index.php" class="back-link">Voltar ao Painel do Administrador</a>
    </div>
</body>
</html>