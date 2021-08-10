<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getVinculos_for_idusuario_nmMural(" . $_SESSION['usuario_logado'] . ",'" . $_GET['mural'] . "')";

    $vinculosDadosModal = $conn->prepare($comandoSQL);

    $vinculosDadosModal->execute();

    $rows_vinculos = $vinculosDadosModal->rowCount();

    $linha = 0;

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
