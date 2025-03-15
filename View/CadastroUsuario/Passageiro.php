<?php
require_once __DIR__ . '/../../ConexaoBD/Conexao.php';

class Passageiro extends Conexao {
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $senha;
    private $cidade;
    private $bairro;

    // Getter e Setter para $id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter e Setter para $nome
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    // Getter e Setter para $email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Getter e Setter para $telefone
    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    // Getter e Setter para $senha
    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    // Getter e Setter para $tipoUsuario
    public function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    public function setTipoUsuario($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

    // Getter e Setter para $cidade
    public function getCidade() {
        return $this->cidade;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    // Getter e Setter para $bairro
    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function verificaExisteEmail(){
        $sql = "select * from cadastro_de_passageiros where email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CadastrarPassageiro(){
        $sql = "insert into cadastro_de_passageiros (nome, email, telefone, cidade, bairro, senha) 
        values (:nome, :email, :telefone, :cidade, :bairro, :senha)";

        $smtp = $this -> conn -> prepare($sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':bairro', $this->bairro);
        $stmt->bindParam(':senha', $this->senha);
        return $stmt->execute();
    }

    public function EditarPassageiro($flag){
        
    }    
}
?>