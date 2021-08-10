<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/colecaoDentro.css', '../js/colecaoDentro.js', 'Coleção');

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
<div class="main">
    <?php
    require_once '../includes/sidenav.php';
    require_once '../includes/application/crud/Colecao/colecao_select.php';
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <div class="infos1">
                <div class="diveditavel">
                    <?php
                    if ($rows > 0) {
                        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                            $nm_colecao = $count['nm_colecao'];
                            $idColecao = $count['idcolecao'];

                    ?>
                            <section id="titulo_chave">
                                <p id="editavel"><?php echo $nm_colecao ?></p>
                            </section>
                            <img src="../img/pencil.svg">
                    <?php
                        endwhile;
                        $dados->closeCursor();
                    }
                    $dados->closeCursor();
                    ?>
                </div>
                <div class="buttons">
                    <a href="../includes/application/crud/Colecao/colecao_delete.php?colecao_excluir=<?php echo $nm_colecao ?>" id="vinculos" class="depontaponta">Excluir coleção</a>
                    <a href="#add_post_modal" rel="modal" id="addpost" class="depontaponta">Adicionar Post</a>
                    <select id="filtro" class="depontaponta">
                        <option class="option" selected value="recente">Filtrado por: Recente</option>
                        <option class="option" value="maisvisto">Filtrado por: ...</option>
                        <option class="option" value="teste">Filtrado por: ...</option>
                    </select>
                </div>
            </div>
            <section class="posts depontaponta">
                <?php
                require_once '../includes/application/crud/Colecao_Post/postsColecao_select.php';

                if ($rows > 0) {
                    while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :
                        $postColecao = $count['nm_post'];
                        $imagem = $count['imagem'];

                        $update = new DateTime();
                        $create = str_replace('-', '/', $count['dt_update']);
                        $create = new DateTime($create);

                        $dataUpdate = $update->diff($create);
                ?>
                        <a id="ancora_post" href="post.php?post=<?php echo $postColecao ?>&colecao=<?php echo $nm_colecao ?>">
                            <div class="post-item">
                                <p><?php echo $postColecao ?></p>
                                <p>att: <?php echo $dataUpdate->d ?> dias atrás</p>
                                <section class="post depontaponta">
                                    <?php echo '<img class="post-item-img" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                                </section>
                            </div>
                        </a>
                <?php
                    endwhile;
                    $dados->closeCursor();
                }
                $dados->closeCursor();
                ?>
            </section>
        </section>
        <a href="#alter_colecao" rel="modal" id="alterar_colecao">Alterar</a>
    </section>
    <section id="add_post_modal" class="window">
        <p class="fechar"><a href="#">x</a></p>
        <h1><?php echo $nm_colecao ?></h1>
        <div id="all_modal">
            <h2>Todos os Posts</h2>
            <section class="flex_content">
                <?php
                require_once '../includes/application/crud/Post/posts_select.php';

                if ($linhas > 0) {
                    while ($count = $postDados->fetch(PDO::FETCH_ASSOC)) :

                        $nome_post = $count['nm_post'];
                        $idPost = $count['idpost'];
                        $imagem = $count['imagem'];
                ?>
                        <div class="post-item_modal">
                            <a id="ancora_post" href="../includes/application/crud/Colecao_Post/colecao_add_post.php?colecao=<?php echo $idColecao ?>&post=<?php echo $idPost ?>&nomeColecao=<?php echo $nm_colecao ?>">
                                <p><?php echo $nome_post ?></p>
                                <section class="post_modal depontaponta">
                                    <?php echo '<img class="post-item-img" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                                </section>
                            </a>
                        </div>
                <?php
                    endwhile;
                    $postDados->closeCursor();
                }
                $postDados->closeCursor();
                ?>
            </section>
        </div>
    </section>
    <div id="alter_colecao" class="window alter_colecao">
        <section id="modal_colecao">
            <p class="fechar"><a href="#">x</a></p>
            <h1>Alterar coleção</h1>
            <form method="post" action="#" id="form_colecao">
                <input type="hidden" name="hdncontrole" value="formphp-colecao-update">
                <input type="text" value="<?php echo $_GET['colecao'] ?>" name="newColecao" id="newColecao" placeholder="Nome da coleção" maxlength="15">
                <button type="submit" id="criar_colecao">Alterar</button>
            </form>
        </section>
    </div>
</div>

<div id="mascara"></div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php

require_once '../includes/application/crud/Colecao/colecao_update.php';

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
if ($_SESSION['post_colecao_delete'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post deletado da coleção",
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

$_SESSION['post_colecao_delete'] = null;

?>

<?php
if ($_SESSION['post_colecao_update'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Coleção alterada",
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

$_SESSION['post_colecao_update'] = null;

?>