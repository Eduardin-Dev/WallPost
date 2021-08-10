<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL =   " select * from colecao ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    $comandoSQL = $comandoSQL . " nm_colecao = " . $conn->quote($_GET['colecao']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $rows = $dados->rowCount();

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
