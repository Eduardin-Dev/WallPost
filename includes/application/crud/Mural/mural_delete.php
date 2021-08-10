<?php
require_once '../../../db/dbconnection.php';

session_start();
try {

    $comandoSQL =   " delete from mural ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($_GET['mural_excluido']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['mural_excluido'] = 1;
?>
    <script>
        window.location.replace("../../../../../pags/murais.php");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
