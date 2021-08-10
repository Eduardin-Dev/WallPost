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

try {

    $comandoSQL =   " select idpost ";
    $comandoSQL = $comandoSQL .  " from post ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($_GET['post']);

    $dadoPost = $conn->prepare($comandoSQL);

    $dadoPost->execute();

    $rows = $dadoPost->rowCount();

    if ($rows > 0) {
        while ($count = $dadoPost->fetch(PDO::FETCH_ASSOC)) :
            $idPost = $count['idpost'];
        endwhile;
        $dadoPost->closeCursor();
    } else {
        $dadoPost->closeCursor();
    ?>
        <script>
            window.location.replace("../../../../pags/mural.php?mural=<?php echo $_GET['mural'] ?>");
        </script>
    <?php
    }

    $comandoSQL =   " select idmural ";
    $comandoSQL = $comandoSQL .  " from mural ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($_GET['mural']);

    $dadosMural = $conn->prepare($comandoSQL);

    $dadosMural->execute();

    $linhas = $dadosMural->rowCount();

    if ($linhas > 0) {
        while ($count = $dadosMural->fetch(PDO::FETCH_ASSOC)) :
            $idMural = $count['idmural'];
        endwhile;
        $dadosMural->closeCursor();
    } else {
        $dadosMural->closeCursor();
    ?>
        <script>
            window.location.replace("../../../../pags/mural.php?mural=<?php echo $_GET['mural'] ?>");
        </script>
    <?php
    }
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}

try {

    $comandoSQL =   " DELETE FROM mural_post ";
    $comandoSQL = $comandoSQL . " where ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL . " idmural = " . $conn->quote($idMural) . " AND ";
    $comandoSQL = $comandoSQL . " idpost = " . $conn->quote($idPost);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['post_mural_delete'] = 1;
    ?>
    <script>
        window.location.replace("../../../../pags/mural.php?mural=<?php echo $_GET['mural'] ?>");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
