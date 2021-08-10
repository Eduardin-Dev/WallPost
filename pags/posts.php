<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/posts.css', '../js/posts.js', 'Meus posts');

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
require_once '../includes/application/crud/Post/posts_select.php';
?>
<div class="main">
    <?php
    require_once '../includes/sidenav.php';
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <div class="diveditavel">
                <input type="text" id="editavel" maxlength="11" disabled="true" value="Meus Posts">
                <img src="../img/pencil.svg" id="imgeditavel">
            </div>
            <div id="buttons-infos">
            <a href="newpost.php" class="createPost depontaponta">Criar post</a>
            <select id="filtro">
                <option class="option" selected value="recente">Filtrado por: Recente</option>
                <option class="option" value="maisvisto">Filtrado por: ...</option>
                <option class="option" value="teste">Filtrado por: ...</option>
            </select>
            </div>
            <section class="posts depontaponta">
                <?php

                if ($linhas > 0) {
                    while ($count = $postDados->fetch(PDO::FETCH_ASSOC)) :

                        $update = new DateTime();
                        $create = str_replace('-', '/', $count['dt_update']);
                        $create = new DateTime($create);

                        $dataUpdate = $update->diff($create);

                        $nome_post = $count['nm_post'];
                        $descricao = $count['ds_post'];
                        $dataValidade = $count['dt_validade'];
                        $link = $count['cd_link'];
                        $imagem = $count['imagem'];
                ?>
                        <!-- <form id="foo"> -->
                        <a href="post.php?post=<?php echo $nome_post ?>">
                        <input type="hidden" id="input_nmpost" value="<?php echo $nome_post ?>">
                            <div class="post-item">
                                <p id="nome_post"><?php echo $nome_post ?></p>
                                <p>att: <?php echo $dataUpdate->d ?> dias atrás</p>
                                <section class="post depontaponta">
                                    <?php echo '<img class="post-item-img" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                                </section>
                            </div>
                        </a>
                        <!-- </form> -->
                <?php
                    endwhile;
                    $postDados->closeCursor();
                }
                $postDados->closeCursor();
                ?>
            </section>
        </section>
    </section>
    <section id="post_modal" class="window">
        <div id="back_close">
            <p class="voltar"><span>Voltar</span></p>
            <p class="fechar"><a href="#">x</a></p>
        </div>
        <div id="post_header">
            <h1><?php echo $nome_post ?></h1>
            <a href="../includes/application/crud/Post/post_delete.php?post_excluir=<?php echo $nome_post ?>">Excluir Post</a>
        </div>
        <div id="buttons_modal">
            <button id="add_colecao"><img src="../img/folder.svg">Adicionar a uma Coleção</button>
            <button id="add_mural"><img src="../img/mais.svg">Adicionar a um Mural</button>
        </div>
        <div id="content_modal">
            <?php
            require_once '../includes/application/crud/Colecao/colecoes_select.php';
            ?>
            <section id="colecao_modal">
                <?php
                if ($rows > 0) {
                    while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                        $nome_colecao = $count['nm_colecao'];
                ?>
                        <div class="colecao-item">
                            <section class="pasta"></section>
                            <p><?php echo $nome_colecao ?></p>
                        </div>
                <?php
                    endwhile;
                    $dados->closeCursor();
                }
                $dados->closeCursor();
                ?>
            </section>
        </div>
        <?php
        require_once '../includes/application/crud/Mural/murais_select.php';

        ?>
        <div id="mural_modal">
            <?php
            if ($rows_mural > 0) {
                while ($count = $muraisDados->fetch(PDO::FETCH_ASSOC)) :

                    $nome_mural = $count['nm_mural'];
            ?>
                    <div class="mural-item">
                        <p><?php echo $nome_mural ?></p>
                        <section class="mural depontaponta">
                            <!-- Aqui vai a imagem do mural ou uma cor caso não tenha nada -->
                        </section>
                    </div>
            <?php
                endwhile;
                $muraisDados->closeCursor();
            }
            $muraisDados->closeCursor();
            ?>
        </div>
    </section>
</div>

<div id="mascara"></div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php
if ($_SESSION['post_criado'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Seu Post foi criado!",
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

$_SESSION['post_criado'] = null;

?>

<?php
if ($_SESSION['post_excluido'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post excluido!",
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

$_SESSION['post_excluido'] = null;

?>

<?php
// require_once '../includes/application/crud/Post/postModal_select.php';
?>