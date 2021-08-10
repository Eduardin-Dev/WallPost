<?php

require_once '../includes/db/dbconnection.php';

try {

    $comandoSQL = "call getPost_for_idusuario(" . $_SESSION['usuario_logado'] . ",'" . $_GET['post'] . "')";
    // $comandoSQL =   " select * from post ";
    // $comandoSQL = strtolower($comandoSQL);
    // // Aqui eu insiro os valores 
    // $comandoSQL = $comandoSQL .  " where ";
    // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);
    // $comandoSQL = $comandoSQL . " order by dt_create asc";

    $postDados = $conn->prepare($comandoSQL);

    $postDados->execute();

    $linhas = $postDados->rowCount();

    if ($linhas > 0) {
        while ($count = $postDados->fetch(PDO::FETCH_ASSOC)) :

            $nome_post = $count['nm_post'];
            $idPost = $count['idpost'];
            $imagem = $count['imagem'];
            $descricao = $count['ds_post'];
            $dataValidade = $count['dt_validade'];
            $link = $count['cd_link'];
        endwhile;
        $postDados->closeCursor();
    }
    $postDados->closeCursor();
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
