<?php
require_once '../../../db/dbconnection.php';

session_start();

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("../../../../");
    </script>
    <?php
}

try {

    $comandoSQL =   " SELECT idmural, idpost";
    $comandoSQL = $comandoSQL . " from mural_post ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL . " where ";
    $comandoSQL = $comandoSQL . " idmural = " .  $conn->quote($_GET['mural']) . " AND ";
    $comandoSQL = $comandoSQL . " idpost = " . $conn->quote($_GET['post']);

    $dados = $conn->query($comandoSQL);

    $count = $dados->rowCount();
    if ($count > 0) {
        
        $_SESSION['post_mural'] = 2; // POST JA ESTA NO MURAL
    ?>
        <script>
            window.location.replace("../../../../pags/post.php?post=<?php echo $_GET['nomePost'] ?>");
        </script>
    <?php
        $dados->closeCursor();

        exit();
    }
    $dados->closeCursor();
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}


try {

    $comandoSQL =   " INSERT INTO mural_post (idmural, idpost)";
    $comandoSQL = $comandoSQL . "VALUES (";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  $conn->quote($_GET['mural']) . " , ";
    $comandoSQL = $comandoSQL . $conn->quote($_GET['post']) . ")";

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['post_mural'] = 1;
    ?>
    <script>
        window.location.replace("../../../../pags/post.php?post=<?php echo $_GET['nomePost'] ?>");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "INSERT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
