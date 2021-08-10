<?php

require_once '../../../db/dbconnection.php';

session_start();
$dadosPost = null;
echo "<script>console.log('Funfo!');</script>";

if (isset($_POST['postNome'])) {

    $nomePost = $_POST['postNome'];

    echo "<script>console.log('". $nomePost . "')</script>";
    try {

        $comandoSQL =   " select * from post ";
        $comandoSQL = strtolower($comandoSQL);
        // Aqui eu insiro os valores 
        $comandoSQL = $comandoSQL .  " where ";
        $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
        $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($nomePost);


        $dadosPostModal = $conn->prepare($comandoSQL);

        $dadosPostModal->execute();

        $rows = $dadosPostModal->rowCount();

        if ($rows > 0) {
            $dadosPost = ($dadosPostModal->fetchAll(PDO::FETCH_BOTH));

            echo json_encode(array('sucesso' => ($dadosPost != null ? true : false),  'dados' => $dadosPost));
        }
        // $dadosPostModal->closeCursor();
} catch (PDOException $Exception) {
        echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    }
}
