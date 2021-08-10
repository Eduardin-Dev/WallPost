<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/forms/newpost.css', '../js/newpost.js', 'Novo Post');

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
    ?>
    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <h1 class="depontaponta">Novo Post</h1>
            <div id="infos1">
                <form method="post" action="#" id="form" enctype="multipart/form-data">
                    <div>
                        <div id="newpost">
                            <div id="imgpost">
                                <img src="../img/mais.svg">
                            </div>
                            <img id="postimg">
                        </div>
                        <label id="ifimg" for="arquivo">Adicionar Foto</label>
                        <input name="arquivo" id="arquivo" type="file">
                    </div>
                    <div id="form-newpost">
                        <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formpost-insert" />
                        <input type="text" id="nome" name="nome" placeholder="Titulo" maxlength="20" class="depontaponta">
                        <label for="descricao">Descrição</label>
                        <textarea class="mensagem depontaponta" name="descricao" id="descricao" minlenght="5" maxlength="300"></textarea>
                        <input type="text" id="link" name="link" placeholder="Link" maxlength="500" class="depontaponta">
                        <label id="ativo" for="data">Post ativo até:</label>
                        <input id="data" type="date" name="data">
                        <button type="submit" id="btnenviar" class="depontaponta">Criar novo Post</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
</div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php
require_once '../includes/application/crud/post/post_crud.php';

if($_SESSION['descricao_salva'] != null){

    ?> <script type="text/javascript">
    $(document).ready(function(){
        $('#descricao').text('<?php echo $_SESSION['descricao_salva']; ?>');
    });

    </script>
    <?php
} else {
    $_SESSION['descricao_salva'] = null;
}

?>