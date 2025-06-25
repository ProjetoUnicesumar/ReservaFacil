<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: /View/login/index.php"); 
    exit;
}

require_once(__DIR__ . '/Funcoes.php');

if (!isset($_GET['id'])) {
    header("Location: gerenciarUsuarios.php");
    exit;
}

$id_usuario = (int)$_GET['id'];
$funcoes = new Funcoes();
$usuario = $funcoes->buscarUsuarioPorId($id_usuario);

if (!$usuario) {
    header("Location: gerenciarUsuarios.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../login/style.css"> <style>
        .form-container { width: 100%; max-width: 600px; margin: 30px auto; padding: 30px; background-color: #fff; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .form-container h2 { text-align: center; color: var(--primary-color); margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        .form-group button { width: 100%; padding: 15px; background-color: var(--primary-color); color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; }
        .form-group button:hover { background-color: var(--secondary-color); }
        .back-link-form { display: block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Usuário: <?php echo htmlspecialchars($usuario['nome']); ?></h2>
        
        <form action="salvar_edicao.php" method="POST">
        
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
            
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($usuario['cidade']); ?>">
            </div>

            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" value="<?php echo htmlspecialchars($usuario['bairro']); ?>">
            </div>

            <div class="form-group">
                <label for="universidade">Universidade:</label>
                <input type="text" id="universidade" name="universidade" value="<?php echo htmlspecialchars($usuario['universidade']); ?>">
            </div>
            
            <div class="form-group">
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
        <a href="gerenciarUsuarios.php" class="back-link-form">Cancelar e Voltar</a>
    </div>
</body>
</html>