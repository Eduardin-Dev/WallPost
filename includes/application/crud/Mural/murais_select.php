<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getAllMurais_for_idusuario_desc(" . $_SESSION['usuario_logado'] . ")";

    // $comandoSQL =   " select * from mural ";
    // $comandoSQL = strtolower($comandoSQL);
    // // Aqui eu insiro os valores 
    // $comandoSQL = $comandoSQL .  " where ";
    // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);
    // $comandoSQL = $comandoSQL . " order by dt_create asc";

    $muraisDados = $conn->prepare($comandoSQL);

    $muraisDados->execute();

    $rows_mural = $muraisDados->rowCount();

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
