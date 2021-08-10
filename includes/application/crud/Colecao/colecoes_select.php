<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getAllColecoes_for_idusuario(" . $_SESSION['usuario_logado'] .")";
    // $comandoSQL =   " select nm_colecao, idcolecao from colecao ";
    // $comandoSQL = strtolower($comandoSQL);
    // // Aqui eu insiro os valores 
    // $comandoSQL = $comandoSQL .  " where ";
    // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);
    // $comandoSQL = $comandoSQL . " order by nm_colecao asc";

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $rows = $dados->rowCount();


} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
