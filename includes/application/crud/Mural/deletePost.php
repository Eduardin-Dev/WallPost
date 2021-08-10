<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL =   " select * from post ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . ' AND ';
    $comandoSQL = $comandoSQL . " dt_validade < curdate()";

    $muraisDados = $conn->prepare($comandoSQL);

    $muraisDados->execute();

    $rows_Posts = $muraisDados->rowCount();

    if ($rows_Posts >= 1) {
        while ($count = $muraisDados->fetch(PDO::FETCH_ASSOC)) :

            $comandoSQL =   " delete from mural_post ";
            $comandoSQL = strtolower($comandoSQL);
            // Aqui eu insiro os valores 
            $comandoSQL = $comandoSQL .  " where ";
            $comandoSQL = $comandoSQL . " idpost = " . $count['idpost'] . ' AND ';
            $comandoSQL = $comandoSQL . " idmural = " . $idMural;

            $deletePost = $conn->prepare($comandoSQL);

            $deletePost->execute();

        endwhile;
        $muraisDados->closeCursor();
    }
    $muraisDados->closeCursor();
} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
