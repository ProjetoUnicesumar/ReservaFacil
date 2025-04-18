<?php
require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');

class Passageiro {
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $senha;
    private $cidade;
    private $bairro;
    private $universidade;
    private $tipo_usuario;
    private $conn;

    public function __construct() {
        $this->conn = Conexao::conectar();
    }

    // Getters e Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getTelefone() { return $this->telefone; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; }

    public function getCidade() { return $this->cidade; }
    public function setCidade($cidade) { $this->cidade = $cidade; }

    public function getBairro() { return $this->bairro; }
    public function setBairro($bairro) { $this->bairro = $bairro; }

    public function verificaExisteEmail() {
        $sql = "SELECT * FROM Usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CadastrarPassageiro() {
        $sql = "INSERT INTO Usuarios (nome, email, senha, telefone, cidade, bairro, universidade, tipo_usuario) 
                VALUES (:nome, :email, :senha, :telefone, :cidade, :bairro, :universidade, :tipo_usuario)";

        $stmt = $this->conn->prepare($sql);
        $tipo_usuario = 3;
        $senhaCriptografada = $this->senha;

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $senhaCriptografada);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':bairro', $this->bairro);
        $stmt->bindParam(':universidade', $this->universidade);
        $stmt->bindParam(':tipo_usuario', $tipo_usuario);

        return $stmt->execute();
    }

    public function EditarPassageiro($flag) {
        if ($flag) {
            $sql = "UPDATE Usuarios SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, cidade = :cidade, bairro = :bairro, universidade = :universidade WHERE id = :id";
        } else {
            $sql = "UPDATE Usuarios SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, cidade = :cidade, bairro = :bairro, universidade = :universidade WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':bairro', $this->bairro);
        $stmt->bindParam(':universidade', $this->universidade);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    public function DeletarPassageiro() {
        $sql = "DELETE FROM Usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function InativarPassageiro() {
        $sql = "UPDATE Usuarios SET status = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function ListarPassageiro() {
        $sql = "SELECT * FROM Usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>