<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/forms/newmural.css', '../js/newmural.js', 'Novo Mural');

session_start();

?>
<link rel="stylesheet" href="../css/jquery.toast.css">
<?php

if (!isset($_SESSION['usuario_logado'])) {
?>
    <script type="text/javascript">
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
            <h1 class="depontaponta">Novo Mural</h1>
            <div id="infos1">
                <div id="mural">
                    <div id="imgmural">
                    </div>
                    <p>Capa do Mural</p>
                </div>
                <form action="#" method="post" id="form-newmural">
                    <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formmural-insert" />
                    <input type="text" id="nome" name="nome" placeholder="Titulo" minlength="5" maxlength="16" class="depontaponta">
                    <label name="txtmensagem">Descrição</label>
                    <textarea class="mensagem depontaponta" name="descricao" id="descricao" minlength="5" maxlength="300"></textarea>
                    <p class="depontaponta">Tipo de Mural</p>
                    <div class="depontaponta radios">
                        <input type="radio" id="privado" name="tipo" value="2">
                        <label for="privado">Privado</label>
                        <input type="radio" id="publico" checked name="tipo" value="1">
                        <label for="publico">Público</label>
                    </div>
                    <button type="submit" name="btnenviar" id="btnenviar" class="depontaponta">Criar novo Mural</button>
                </form>
            </div>
        </section>
    </section>
</div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<?php

require_once '../includes\application\crud/Mural/mural_crud.php';

?>