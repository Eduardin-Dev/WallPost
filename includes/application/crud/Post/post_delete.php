<?php
require_once '../../../db/dbconnection.php';

session_start();
if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("http://localhost/WALLPOST/");
    </script>
<?php
}

if (!isset($_GET['post_excluir'])) {
?>
    <script>
        window.location.replace("../../../../pags/posts.php");
    </script>
<?php
}


try {

    $comandoSQL = "call deletePost_for_idusuario(" . $_SESSION['usuario_logado'] . "," . $_GET['post_excluir'] . ")";
    // $comandoSQL =   " delete from post ";
    // $comandoSQL = strtolower($comandoSQL);
    // // Aqui eu insiro os valores 
    // $comandoSQL = $comandoSQL .  " where ";
    // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    // $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($_GET['post_excluir']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['post_excluido'] = 1;
?>
    <script>
        window.location.replace("../../../../pags/posts.php");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
