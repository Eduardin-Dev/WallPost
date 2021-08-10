<?php
require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getPosts_for_idusuario_idmural(" . $_SESSION['usuario_logado'] . "," . $idMural .")";

    $dadosPost = $conn->prepare($comandoSQL);

    $dadosPost->execute();

    $rows = $dadosPost->rowCount();

} catch (PDOException $Exception) {
    echo "SELECT errin MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
