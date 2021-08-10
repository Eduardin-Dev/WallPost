<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL =   " select nm_mural, cd_chave, idmural, ds_mural, ic_public from mural ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($_GET['mural']);

    $dadosMural = $conn->prepare($comandoSQL);

    $dadosMural->execute();

    $rowsMural = $dadosMural->rowCount();

    if ($rowsMural > 0) {
        while ($count = $dadosMural->fetch(PDO::FETCH_ASSOC)) :

            $nm_mural = $count['nm_mural'];
            $chave = $count['cd_chave'];
            $idMural = $count['idmural'];
            $dsMural = $count['ds_mural'];
            $icPublic = $count['ic_public'];

        endwhile;
        $dadosMural->closeCursor();
    }
    $dadosMural->closeCursor();

} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
