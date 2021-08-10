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

    $comandoSQL =   " SELECT idcolecao, idpost";
    $comandoSQL = $comandoSQL . " from post_colecao ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL . " where ";
    $comandoSQL = $comandoSQL . " idcolecao = " .  $conn->quote($_GET['colecao']) . " AND ";
    $comandoSQL = $comandoSQL . " idpost = " . $conn->quote($_GET['post']);

    $dados = $conn->query($comandoSQL);

    $count = $dados->rowCount();
    if ($count > 0) {

        $_SESSION['post_colecao'] = 2; // POST JA ESTA NA COLEÇÃO

    ?>
        <script type="text/javascript">
            window.location.replace("../../../../pags/colecao.php?colecao=<?php echo $_GET['nomeColecao'] ?>");
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

    $comandoSQL =   " INSERT INTO post_colecao (idcolecao, idpost)";
    $comandoSQL = $comandoSQL . "VALUES (";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  $conn->quote($_GET['colecao']) . " , ";
    $comandoSQL = $comandoSQL . $conn->quote($_GET['post']) . ")";

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['post_colecao'] = 1;
    ?>
    <script>
        window.location.replace("../../../../pags/colecao.php?colecao=<?php echo $_GET['nomeColecao'] ?>");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "INSERT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
