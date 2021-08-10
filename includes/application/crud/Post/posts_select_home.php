<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getPosts_for_idusuario_home(" . $_SESSION['usuario_logado'] . ")";

    $postDados = $conn->prepare($comandoSQL);

    $postDados->execute();

    $linhas = $postDados->rowCount();

    
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
