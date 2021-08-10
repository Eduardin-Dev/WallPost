<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/murais.css', '../js/murais.js', 'Meus murais');

session_start();

?>
<link rel="stylesheet" href="../css/jquery.toast.css">
<?php

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("../");
    </script>
<?php
}

?>
<!-- Bloco da página -->
<?php
require_once '../includes/application/crud/Mural/murais_select.php';
?>
<div class="main">
    <?php
    require_once '../includes/sidenav.php';
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <div class="diveditavel">
                <input type="text" id="editavel" maxlength="11" disabled="true" value="Meus Murais">
                <img src="../img/pencil.svg" id="imgeditavel">
            </div>
            <div id="buttons-infos">
            <a href="newmural.php" class="createMural depontaponta">Criar mural</a>
            <select id="filtro" class="depontaponta">
                <option class="option" selected value="recente">Filtrado por: Recente</option>
                <option class="option" value="maisvisto">Filtrado por: ...</option>
                <option class="option" value="teste">Filtrado por: ...</option>
            </select>
            </div>
        </section>
        <section class="murais depontaponta">
            <?php

            if ($rows_mural > 0) {
                while ($count = $muraisDados->fetch(PDO::FETCH_ASSOC)) :
                    $update = new DateTime();
                    $create = str_replace('-', '/', $count['dt_updateMural']);
                    $create = new DateTime($create);

                    $dataUpdate = $update->diff($create);

                    $nome_mural = $count['nm_mural'];
                    $descricao = $count['ds_mural'];
                    $id_mural = $count['idmural'];
            ?>
                    <div class="mural-item">
                        <a id="ancora_mural" href="mural.php?mural=<?php echo $nome_mural ?>">

                            <div class="form-mural" alt="bibibibobobo">
                                <p><?php echo $nome_mural ?></p>
                                <p>att: <?php echo $dataUpdate->d ?> dias atrás</p>
                                <section class="mural depontaponta">
                                    <!-- Aqui vai a imagem do mural ou uma cor caso não tenha nada -->
                                </section>
                                <?php $_GET['idmural'] = $id_mural; ?>
                            </div>
                        </a>

                    </div>
            <?php
                endwhile;
                $muraisDados->closeCursor();
            }
            $muraisDados->closeCursor();
            ?>

        </section>
    </section>
    </section>
</div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php
if ($_SESSION['mural_criado'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Seu mural foi criado!",
            showHideTransition: 'fade',
            icon: 'success',
            position: 'top-center',
            bgColor: '#F15A24',
            loaderBg: 'white',
            hideAfter: 5000
        });
    </script>
<?php
}

$_SESSION['mural_criado'] = null;

?>

<?php
if ($_SESSION['mural_excluido'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso',
            text: "Mural excluido!",
            showHideTransition: 'fade',
            icon: 'success',
            position: 'top-center',
            bgColor: '#F15A24',
            loaderBg: 'white',
            hideAfter: 5000
        });
    </script>
<?php
}

$_SESSION['mural_excluido'] = null;

?>