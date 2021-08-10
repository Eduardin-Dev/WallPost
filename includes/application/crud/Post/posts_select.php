<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getAllPosts_for_idusuario_desc(" . $_SESSION['usuario_logado'] . ")";
    // $comandoSQL =   " select * from post ";
    // $comandoSQL = strtolower($comandoSQL);
    // // Aqui eu insiro os valores 
    // $comandoSQL = $comandoSQL .  " where ";
    // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);
    // $comandoSQL = $comandoSQL . " order by dt_create asc";

    $postDados = $conn->prepare($comandoSQL);

    $postDados->execute();

    $linhas = $postDados->rowCount();

    
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
