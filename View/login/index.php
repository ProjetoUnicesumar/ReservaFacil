<?php
require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');

$mensagem = "";
$conn = Conexao::conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $mensagem = "Preencha seu e-mail";
    } elseif (empty($_POST['senha'])) {
        $mensagem = "Digite sua senha";
    } else {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                session_start();
                $mensagem = "Login bem-sucedido!";
                $_SESSION['user_id'] = (int) $user['id_usuario'];
                $_SESSION['user_nome'] = $user['nome'];
                $tipos = [1 => 'admin', 2 => 'motorista', 3 => 'passageiro'];
                $_SESSION['usuario'] = $tipos[$user['tipo_usuario']] ?? 'desconhecido';

                if ($_SESSION['usuario'] === 'admin') {
                    header("Location: /reservaFacil/ReservaFacil/View/HomeAdmin/index.php");
                } elseif ($_SESSION['usuario'] === 'motorista') {
                    header("Location: /reservaFacil/ReservaFacil/View/HomeMotorista/index.php");
                } else {
                    header("Location: /reservaFacil/ReservaFacil/View/HomePassageiro/index.php");
                }

                exit();
            } else {
                $mensagem = "Senha incorreta!";
            }
        } else {
            $mensagem = "Usuário não encontrado!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box">
        <h2>Entrar na minha Conta</h2>

        <?php if (!empty($mensagem)) { ?>
            <p style="color: <?php echo ($mensagem == "Login bem-sucedido!") ? 'green' : 'red'; ?>;">
                <?php echo $mensagem; ?>
            </p>
        <?php } ?>

        <form action="" method="POST">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite o seu email" required>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="input-group">
                <button type="submit">Entrar</button>
            </div>

            <div class="input-group">
                <button class="cadastrar" type="button" onclick="window.location.href='/reservaFacil/ReservaFacil/View/CadastroUsuario/cadastroUsuario.php'">
                    Cadastrar como Passageiro
                </button>
            </div>
        </form>
    </div>
</body>
</html>