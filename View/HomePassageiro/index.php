<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /ReservaFacil/View/login/index.php");
    exit;
}

$ida = 0;
$volta = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ida = isset($_POST['ida']) ? 1 : 0;
    $volta = isset($_POST['volta']) ? 1 : 0;

    $conn = new mysqli("", "", "", "");

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];

    $sqlVerificaReserva = "SELECT COUNT(*) as total FROM reservas WHERE id_usuario = ? AND data_viagem = CURDATE()";
    $stmtVerificaReserva = $conn->prepare($sqlVerificaReserva);
    $stmtVerificaReserva->bind_param("i", $user_id);
    $stmtVerificaReserva->execute();
    $resultado = $stmtVerificaReserva->get_result()->fetch_assoc();
    $stmtVerificaReserva->close();

    if($resultado['total'] > 0) {
      $mensagem = "Você já possui uma reserva. Não é possível alterar.";
    } else {
      $sql = "INSERT INTO reservas (id_usuario, data_viagem, ida, volta) VALUES (?, CURDATE(), ?, ?)";
      $stmt = $conn->prepare($sql);

      if($stmt){
        $stmt->bind_param("iii", $user_id, $ida, $volta);
        $stmt->execute();
        $stmt->close();
        $mensagem = "Reserva realizada com sucesso!";
      } else {
        $mensagem = "Erro ao realizar reserva.";
      }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="../HomePassageiro/style.css">
</head>
<body>

    <div class="container">
        <h1>Reserva</h1>

        <?php if (!empty($mensagem)) echo "<div class='message'><p>$mensagem</p></div>"; ?>

        <?php 
        $reservaFeita = false;
        $idaMarcada = 0;
        $voltaMarcada = 0;

        $conn = new mysqli("localhost", "root", "", "reservafacil");

        if (!$conn->connect_error) {
            $stmt = $conn->prepare("SELECT ida, volta FROM reservas WHERE id_usuario = ? AND data_viagem = CURDATE()");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_assoc();
            if ($resultado) {
                $reservaFeita = true;
                $idaMarcada = $resultado['ida'];
                $voltaMarcada = $resultado['volta'];
            }
            $stmt->close();
            $conn->close();
        }
        ?>

        <?php if ($reservaFeita): ?>
        <p>Você já fez sua reserva para hoje.</p>
        <?php endif; ?>

        <form action="" method="post">
            <div class="checkbox-container">
                <label>
                    <input type="checkbox" name="ida" value="1"
                        <?php if ($idaMarcada) echo 'checked'; ?>
                        <?php if ($reservaFeita) echo 'disabled'; ?>>
                    Ida
                </label>
                <label>
                    <input type="checkbox" name="volta" value="1"
                        <?php if ($voltaMarcada) echo 'checked'; ?>
                        <?php if ($reservaFeita) echo 'disabled'; ?>>
                    Volta
                </label>
            </div>
            <button type="submit" <?php if ($reservaFeita) echo 'disabled'; ?>>Enviar</button>
        </form>
    </div>
</body>
</html>
