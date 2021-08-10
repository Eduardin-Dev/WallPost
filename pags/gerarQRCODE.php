<?php
header('Content-Type: image/png');
require_once '../phpqrcode/qrlib.php';
require_once '../includes/db/dbconnection.php';
session_start();

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("../");
    </script>
<?php
}

if (!isset($_GET['mural'])) {
?>
    <script>
        window.location.replace("./murais.php");
    </script>
<?php
}

try {

    $comandoSQL =   " select * from mural ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($_GET['mural']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $rows = $dados->rowCount();

    if ($rows > 0) {
        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

            $idMural = base64_encode($count['idmural']);

            $qrCode = $idMural;
            QRcode::png("$qrCode", null, QR_ECLEVEL_H, 15);

        endwhile;
        $dados->closeCursor();
    }
    $dados->closeCursor();
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}

?>