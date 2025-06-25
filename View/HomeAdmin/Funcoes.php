<?php 

require_once(__DIR__ . '/../../ConexaoBD/Conexao.php');

class Funcoes {

    private $conn;

    public function __construct() {
        $this->conn = Conexao::conectar();
    }

    

    public function AtivarUsuario($id_usuario){
        $sql = "UPDATE usuarios SET status = 1 WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function InativarUsuario($id_usuario){
        $sql = "UPDATE usuarios SET status = 0 WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function ListarUsuarios(){
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarUsuarioPorId($id_usuario) {
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function ExcluirUsuario($id_usuario){
        $this->conn->beginTransaction();
        
        try {
            $sql_reservas = "DELETE FROM reservas WHERE id_usuario = :id_usuario";
            $stmt_reservas = $this->conn->prepare($sql_reservas);
            $stmt_reservas->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt_reservas->execute();
            
            $sql_usuario = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt_usuario = $this->conn->prepare($sql_usuario);
            $stmt_usuario->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt_usuario->execute();
            
            $this->conn->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function atualizarUsuario($id_usuario, $nome, $email, $cidade, $bairro, $universidade) {
        $sql = "UPDATE Usuarios SET 
                    nome = :nome, 
                    email = :email,
                    cidade = :cidade,
                    bairro = :bairro,
                    universidade = :universidade 
                WHERE id_usuario = :id_usuario";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        
        $stmt->bindParam(':universidade', $universidade, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}


?>