<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/post.css', '../js/post.js', 'Post');

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
require_once '../includes/application/crud/Post/post_select.php';

?>

<div class="main">
    <?php
    require_once '../includes/sidenav.php';
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <div class="infos1">
                <div class="diveditavel">
                    <p id="editavel"><?php echo $nome_post ?></p>
                    <img src="../img/pencil.svg">
                </div>
                <div class="buttons">
                    <?php
                    if(isset($_GET['mural'])){
                        require_once '../includes/application/crud/buttons/excluir_do_mural.php';
                    }

                    if(isset($_GET['colecao'])){
                        require_once '../includes/application/crud/buttons/excluir_da_colecao.php';
                    }
                    ?>
                    <a href="../includes/application/crud/Post/post_delete.php?post_excluir=<?php echo $idPost ?>" id="vinculos" class="depontaponta">Deletar Post</a>
                    <a href="#add_post_modal" rel="modal" id="addpost" class="depontaponta">Adicionar Post</a>
                </div>
            </div>
            <form action="#" method="post" id="form" enctype="multipart/form-data">
                <div id="div_newpost">
                    <div id="newpost">
                        <?php echo '<img id="postimg" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                    </div>
                    <label id="ifimg" for="arquivo">Alterar imagem</label>
                    <input name="arquivo" id="arquivo" type="file" value="<?php echo $imagem ?>">
                </div>
                <div id="form-newpost">
                    <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formpost-update" />
                    <input value="<?php echo $nome_post ?>" type="text" id="nome" name="nome" placeholder="Titulo" maxlength="20" class="depontaponta">
                    <label for="descricao">Descrição</label>
                    <textarea class="mensagem depontaponta" name="descricao" id="descricao" maxlength="300"><?php echo $descricao; ?></textarea>
                    <input value="<?php echo $link ?>" type="text" id="link" name="link" placeholder="Link" maxlength="20" class="depontaponta">
                    <label id="ativo" for="data">Post ativo até:</label>
                    <input value="<?php echo $dataValidade ?>" id="data" type="date" name="data">
                    <button type="submit" id="btnenviar" class="depontaponta">Alterar</button>
                </div>
            </form>
        </section>
    </section>
    <section id="add_post_modal" class="window">
        <div id="back_close">
            <p class="voltar voltar_add"><span>Voltar</span></p>
            <p class="fechar"><a href="#">x</a></p>
        </div>
        <h1><?php echo $nome_post ?></h1>
        <div class="buttons_modal buttons_modal_add">
            <button id="select_colecao"><img src="../img/folder.svg">Adicionar a uma coleção</button>
            <button id="select_posts"><img src="../img/add.svg">Adicionar a um mural</button>
        </div>
        <div id="all_modal">
            <h2>Murais</h2>
            <section class="flex_content">
                <?php
                require_once '../includes/application/crud/Mural/murais_select.php';
                if ($rows_mural > 0) {
                    while ($count = $muraisDados->fetch(PDO::FETCH_ASSOC)) :

                        $nome_mural = $count['nm_mural'];
                        $id_mural = $count['idmural'];
                ?>

                        <div class="mural-item">
                            <a id="ancora_mural" href="../includes/application/crud/Mural_Post/post_add.php?mural=<?php echo $id_mural ?>&post=<?php echo $idPost ?>&nomePost=<?php echo $nome_post ?>">
                                <p><?php echo $nome_mural ?></p>
                                <section class="mural depontaponta">
                                    <!-- Aqui vai a imagem do mural ou uma cor caso não tenha nada -->
                                </section>
                            </a>

                        </div>
                <?php
                    endwhile;
                    $muraisDados->closeCursor();
                }
                $muraisDados->closeCursor();
                ?>

            </section>
        </div>
        <?php
        require_once '../includes/application/crud/Colecao/colecoes_select.php';
        ?>
        <div id="colecao_modal_add">
            <h2>Coleções</h2>
            <section class="flex_content">
                <?php
                if ($rows > 0) {
                    while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                        $nome_colecao = $count['nm_colecao'];
                        $idColecao = $count['idcolecao'];
                ?>
                        <a id="ancora_colecao" href="../includes/application/crud/Colecao_Post/post_add.php?colecao=<?php echo $idColecao ?>&post=<?php echo $idPost ?>&nomePost=<?php echo $nome_post ?>">
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

            </section>
        </div>
    </section>
</div>

<div id="mascara"></div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php
require_once '../includes/application/crud/Post/post_update.php';

if ($_SESSION['post_mural'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post adicionado ao mural",
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
?>

<?php
if ($_SESSION['post_mural'] == 2) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Opa!',
            text: "Post já existe no mural",
            showHideTransition: 'fade',
            icon: 'warning',
            position: 'top-center',
            bgColor: '#F15A24',
            loaderBg: 'white',
            hideAfter: 5000
        });
    </script>
<?php
}

$_SESSION['post_mural'] = null;

?>

<?php
if ($_SESSION['post_colecao'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post adicionado na coleção",
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
?>

<?php
if ($_SESSION['post_colecao'] == 2) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Opa!',
            text: "Post já existe na coleção",
            showHideTransition: 'fade',
            icon: 'warning',
            position: 'top-center',
            bgColor: '#F15A24',
            loaderBg: 'white',
            hideAfter: 5000
        });
    </script>
<?php
}

$_SESSION['post_colecao'] = null;

?>

<?php
if ($_SESSION['post_alterado'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post alterado",
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

$_SESSION['post_alterado'] = null;

?>