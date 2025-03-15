<?php
require_once __DIR__ . '/../../ConexaoBD/Conexao.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box">
            <h2>Entrar na minha Conta</h2>
           
            <form action="#Enivar para o banco">
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" placeholder="Digite o seu email" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" placeholder="Digite sua senha" required>
                </div>

                <div class="input-group">
                    <button>Entrar</button>
                </div>

                <p> Cadastrar como passageiro: <a href="/ReservaFacil/View/CadastroUsuario/cadastroUsuario.php" > Cadastrar </a> </p>

    </div>
</body>
</html>