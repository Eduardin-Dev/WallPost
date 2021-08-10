<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL =   " select imagem_user from usuario ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

            if ($count['imagem_user'] != null) {
                $_SESSION['imagem_user'] = $count['imagem_user'];
            }
        endwhile;
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
