<?php
require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');
require_once(__DIR__ . '/Passageiro.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['cidade'], $_POST['bairro'], $_POST['senha'], $_POST['confirmarsenha'])) {
        
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmarsenha'];

        if ($senha !== $confirmarSenha) {
            $erro = "As senhas não coincidem!";
        } else {
            $passageiro = new Passageiro();
            $passageiro->setNome($_POST['nome']);
            $passageiro->setEmail($_POST['email']);
            $passageiro->setTelefone($_POST['telefone']);
            $passageiro->setCidade($_POST['cidade']);
            $passageiro->setBairro($_POST['bairro']);
            $passageiro->setSenha(password_hash($senha, PASSWORD_DEFAULT));

            $resultado = $passageiro->verificaExisteEmail();

            if ($resultado) {
                $erro = "Este e-mail já está cadastrado!";
            } else {
                $salvo = $passageiro->CadastrarPassageiro();
                if ($salvo) {
                    $mensagem = "Cadastro realizado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar. Tente novamente.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro de Passageiros</title>
</head>

<body>
    <div class="form-box">
        <h2>Criar Conta</h2>
        <p> Já possuo um cadastro? <a href="/ReservaFacil/View/login/"> Login </a> </p>
        <form action="" method="POST">
            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o seu nome completo" required>
            </div>

            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite o seu email" required>
            </div>

            <div class="input-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Digite o seu telefone" required>
            </div>

            <div class="input-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade onde mora" required>
            </div>

            <div class="input-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite o seu bairro" required>
            </div>

            <div class="input-group w50">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="input-group w50">
                <label for="confirmarsenha">Confirmar Senha</label>
                <input type="password" id="confirmarsenha" name="confirmarsenha" placeholder="Confirme a senha" required>
            </div>

            <div class="input-group">
                <button type="submit">Cadastrar</button>
            </div>
        </form>
    </div>
</body>
</html>