<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getVinculos_for_idusuario_nmMural(" . $_SESSION['usuario_logado'] . ",'" . $_GET['mural'] . "')";

    $vinculosDados = $conn->prepare($comandoSQL);

    $vinculosDados->execute();

    $rows_vinculos = $vinculosDados->rowCount();

    $linha = 0;

    $vinculosDados->closeCursor();

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
