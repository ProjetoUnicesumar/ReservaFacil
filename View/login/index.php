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

        $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                $mensagem = "Login bem-sucedido!";
                
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];

                // Redirecionamento opcional após login bem-sucedido
                header("Location: /ReservaFacil/View/HomePassageiro/index.html");
                exit;
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
           
            <form action="#Enviar para o banco">
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" placeholder="Digite o seu email" required>
                </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="input-group">
                <button type="submit">Entrar</button>
            </div>

                <div class ="input-group">
                    <button class="cadastrar">Cadastrar como Passageiro</button>
                </div>  
            </form>
            <div class="input-group">
                <button class="cadastrar" type="button" onclick="window.location.href='/ReservaFacil/View/CadastroUsuario/cadastroUsuario.php'">
                    Cadastrar como Passageiro
                </button>
            </div>
        </form>
    </div>
</body>
</html>