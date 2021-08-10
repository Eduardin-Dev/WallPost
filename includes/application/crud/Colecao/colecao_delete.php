<?php
require_once '../../../db/dbconnection.php';

session_start();
try {

    $comandoSQL =   " delete from colecao ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
    $comandoSQL = $comandoSQL . " nm_colecao = " . $conn->quote($_GET['colecao_excluir']);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['colecao_excluida'] = 1;
?>
    <script>
        window.location.replace("../../../../pags/colecoes.php");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
