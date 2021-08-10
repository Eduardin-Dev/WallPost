<?php

require_once '../../../db/dbconnection.php';

session_start();
try {

    $comandoSQL =   " select idmural ";
    $comandoSQL = $comandoSQL .  " from mural ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($_GET['mural']);

    $dadosMural = $conn->prepare($comandoSQL);

    $dadosMural->execute();

    while($count = $dadosMural->fetch(PDO::FETCH_ASSOC)) :

        $idMural = $count['idmural'];
    endwhile;

    $dadosMural->closeCursor();

    $comandoSQL =   " select idusuario ";
    $comandoSQL = $comandoSQL .  " from usuario ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " nm_usuario = " . $conn->quote($_GET['vinculo']);

    $dadosUsuario = $conn->prepare($comandoSQL);

    $dadosUsuario->execute();

    while($count = $dadosUsuario->fetch(PDO::FETCH_ASSOC)) :

        $idUsuario = $count['idusuario'];
    endwhile;

    $dadosUsuario->closeCursor();

    $comandoSQL =   " delete from murais_vinculados ";
    $comandoSQL = strtolower($comandoSQL);
    // Aqui eu insiro os valores 
    $comandoSQL = $comandoSQL .  " where ";
    $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($idUsuario) . " AND ";
    $comandoSQL = $comandoSQL . " idmural = " . $conn->quote($idMural);

    $dados = $conn->prepare($comandoSQL);

    $dados->execute();

    $_SESSION['vinculo_excluido'] = 1;
?>
    <script>
        window.location.replace("../../../../pags/mural.php?mural=<?php echo $_GET['mural'] ?>");
    </script>
<?php

} catch (PDOException $Exception) {
    echo "DELETE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
    exit();
}
