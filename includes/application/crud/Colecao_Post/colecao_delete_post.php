<?php
require_once '../../../db/dbconnection.php';

session_start();

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("../../");
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

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $rows = $dados->rowCount();

    if ($rows > 0) {
        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :
            $idPost = $count['idpost'];
        endwhile;
        $dados->closeCursor();
    } else {
        $dados->closeCursor();
    ?>
        <script>
            window.location.replace("../../../../pags/colecao.php?colecao=<?php echo $_GET['colecao'] ?>");
        </script>
    <?php
    }

    $comandoSQL =   " select idcolecao ";
    $comandoSQL = $comandoSQL .  " from colecao ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " nm_colecao = " . $conn->quote($_GET['colecao']);

    $dadosColecao = $conn->prepare($comandoSQL);

    $dadosColecao->execute();

    $linhas = $dadosColecao->rowCount();

    if ($linhas > 0) {
        while ($count = $dadosColecao->fetch(PDO::FETCH_ASSOC)) :
            $idColecao = $count['idcolecao'];
        endwhile;
        $dadosColecao->closeCursor();
    } else {
        $dadosColecao->closeCursor();
    ?>
        <script>
            window.location.replace("../../../../pags/colecao.php?colecao=<?php echo $_GET['colecao'] ?>");
        </script>
    <?php
    }
    
} catch (PDOException $Exception) {
    echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}

try {

    $comandoSQL =   " DELETE FROM post_colecao ";
    $comandoSQL = $comandoSQL . " where ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL . " idcolecao = " . $conn->quote($idColecao) . " AND ";
    $comandoSQL = $comandoSQL . " idpost = " . $conn->quote($idPost);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['post_colecao_delete'] = 1;
    ?>
    <script>
        window.location.replace("../../../../pags/colecao.php?colecao=<?php echo $_GET['colecao'] ?>");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
