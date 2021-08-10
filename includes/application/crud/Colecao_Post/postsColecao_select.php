<?php
require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getPosts_for_idusuario_idcolecao(" . $_SESSION['usuario_logado'] . "," . $idColecao .")";

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $rows = $dados->rowCount();

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
