<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/mural.css', '../js/mural.js', 'Mural');

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
require_once '../includes/application/crud/Mural/mural_select.php';
require_once '../includes/application/crud/Mural/deletePost.php';
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
                    <section id="titulo_chave">
                        <p id="editavel"><?php echo $nm_mural ?></p>
                        <p>Chave de acesso: <?php echo $chave ?></p>
                    </section>
                    <img src="../img/pencil.svg">
                </div>
                <div class="buttons">
                    <?php
                    require_once '../includes/application/crud/Mural/vinculos_select.php';
                    ?>
                    <a href="#vinculos_modal" id="vinculos" rel="modal" class="depontaponta"><?php echo $rows_vinculos ?> vinculos</a>
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
                require_once '../includes/application/crud/Mural_Post/posts_select.php';

                if ($rows > 0) {
                    while ($countPost = $dadosPost->fetch(PDO::FETCH_ASSOC)) :

                        $nome_post = $countPost['nm_post'];
                        $imagem = $countPost['imagem'];

                        $today = new DateTime();
                        $update = str_replace('-', '/', $countPost['dt_update']);
                        $update = new DateTime($update);

                        // echo $create->format('Y/m/d H:i');

                        $dataUpdate = $today->diff($update);

                ?>
                        <a href="post.php?post=<?php echo $nome_post ?>&mural=<?php echo $nm_mural ?>">
                            <div class="post-item">
                                <p><?php echo $nome_post ?></p>
                                <p>att: <?php echo $dataUpdate->d ?> dias atrás</p>
                                <section class="post depontaponta">
                                    <?php echo '<img class="post-item-img" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                                </section>
                            </div>
                        </a>
                <?php
                    endwhile;
                    $dadosPost->closeCursor();
                }
                $dadosPost->closeCursor();
                ?>
            </section>
        </section>
        <div class="options">
            <div class="text">
                Opções
            </div>
            <div class="content">
                <div class="options_content">
                    <a href="../includes//application/crud/Mural/mural_delete.php?mural_excluido=<?php echo $nm_mural ?>" class="option_buttons">Excluir mural</a>
                    <a href="gerarQRCODE.php?mural=<?php echo $nm_mural ?>" target="_blank" class="option_buttons">Gerar QrCode</a>
                    <a href="#alterar_mural" rel="modal" class="option_buttons">Alterar mural</a>
                </div>
            </div>
        </div>
    </section>

    <section id="alterar_mural" class="window">
        <p class="fechar"><a href="#">x</a></p>
        <h1><?php echo $nm_mural ?></h1>
        <div id="alterar_mural_content">
            <div id="mural">
                <div id="imgmural">
                </div>
                <p>Capa do Mural</p>
            </div>
            <form action="#" method="post" id="form-newmural">
                <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formmural-update" />
                <input type="text" value="<?php echo $nm_mural ?>" id="nome" name="nome" placeholder="Titulo" minlength="5" maxlength="16" class="depontaponta">
                <label name="txtmensagem">Descrição</label>
                <textarea class="mensagem depontaponta" name="descricao" id="descricao" minlength="5" maxlength="300"><?php echo $dsMural ?></textarea>
                <p class="depontaponta">Tipo de Mural</p>
                <div class="depontaponta radios" id="mural<?php echo $icPublic ?>">
                    <input type="radio" id="privado" name="tipo" value="2">
                    <label for="privado">Privado</label>
                    <input type="radio" id="publico" name="tipo" value="1">
                    <label for="publico">Público</label>
                </div>
                <button type="submit" name="btnenviar" id="btnenviar" class="depontaponta">Alterar mural</button>
            </form>
        </div>
    </section>


    <section id="vinculos_modal" class="window">
        <p class="fechar"><a href="#">x</a></p>
        <div class="header_modal">
            <h2 id="mural_modal"><?php echo $nm_mural ?></h2>
            <input type="text" placeholder="Pesquisar">
            <h2 id="qt_vinculos"><?php echo $rows_vinculos ?> vinculos</h2>
        </div>
        <div id="user_vinculos">
            <?php
            require_once '../includes/application/crud/Mural/vinculos_select_modal.php';

            if ($rows_vinculos > 0) {
                while ($count = $vinculosDadosModal->fetch(PDO::FETCH_ASSOC)) :
                    $linha += 1;
                    $usuarioVinculado = $count['Usuario'];

            ?>
                    <section class="vinculo-item">
                        <p><span>#<?php echo $linha ?></span><?php echo $usuarioVinculado ?></p>
                        <a href="../includes/application/crud/Mural/vinculo_delete.php?vinculo=<?php echo $usuarioVinculado ?>&mural=<?php echo $nm_mural ?>">X</a>
                    </section>
            <?php
                endwhile;
                $vinculosDadosModal->closeCursor();
            }
            $vinculosDadosModal->closeCursor();
            ?>
        </div>
    </section>
    <section id="add_post_modal" class="window">
        <p class="fechar"><a href="#">x</a></p>
        <h1><?php echo $nm_mural ?></h1>
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
                            <a href="../includes/application/crud/Mural_Post/Mural_add_post.php?mural=<?php echo $idMural ?>&post=<?php echo $idPost ?>&nomeMural=<?php echo $nm_mural ?>">
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
</div>

<div id="mascara"></div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php
require_once '../includes/application/crud/Mural/mural_update.php';

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
if ($_SESSION['post_mural_delete'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Post deletado do mural",
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

$_SESSION['post_mural_delete'] = null;
?>

<?php
if ($_SESSION['vinculo_excluido'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso!',
            text: "Vinculo excluido",
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

$_SESSION['vinculo_excluido'] = null;
?>