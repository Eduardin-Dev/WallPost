<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/colecao.css', '../js/colecao.js', 'Coleções');

session_start();

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script>
        window.location.replace("../");
    </script>
<?php
}

?>
<link rel="stylesheet" href="../css/jquery.toast.css">
<!-- Bloco Página -->
<script src="../js/jquery.toast.js"></script>
<div class="main">
    <?php
    require_once '../includes/sidenav.php';
    require_once '../includes/application/crud/Colecao/colecoes_select.php';
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <h1>Coleções</h1>
            <div class="colecao">
                <?php
                if ($rows > 0) {
                    while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                        $nome_colecao = $count['nm_colecao'];

                ?>
                        <a id="ancora_colecao" href="colecao.php?colecao=<?php echo $nome_colecao ?>">

                            <div class="colecao-item">
                                <section class="pasta"></section>
                                <p><?php echo $nome_colecao ?></p>
                            </div>
                        </a>

                <?php

                    endwhile;
                    $dados->closeCursor();
                }
                $dados->closeCursor();
                ?>
                <a href="#colecao_modal" rel="modal">
                    <div class="colecao-create">
                        <section id="new-pasta"><img src="../img/mais.svg"></section>
                    </div>
                </a>
            </div>
        </section>
    </section>
    <div id="colecao_modal" class="window">
        <section id="modal_colecao">
            <p class="fechar"><a href="#">x</a></p>
            <h1>Criar coleção</h1>
            <form method="post" action="#" id="form_colecao">
                <input type="hidden" name="hdncontrole" value="formphp-colecao-insert">
                <input type="text" name="newColecao" id="newColecao" placeholder="Nome da coleção" maxlength="15">
                <button type="submit" id="criar_colecao">Criar</button>
            </form>
        </section>
    </div>
</div>

<?php
require_once '../includes/application/crud/Colecao/colecao_crud.php';
?>

<div id="mascara"></div>

<script type="text/javascript">
    $(document).ready(function() {

        <?php
        if ($_SESSION['colecao_excluida'] == 1) {
        ?>
            $.toast({
                heading: 'Sucesso',
                text: "Coleção excluida!",
                showHideTransition: 'fade',
                icon: 'success',
                position: 'top-center',
                bgColor: '#F15A24',
                loaderBg: 'white',
                hideAfter: 5000
            });
        <?php
            $_SESSION['colecao_excluida'] = null;
        }
        ?>
    });
</script>