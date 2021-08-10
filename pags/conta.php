<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/forms/conta.css', '../js/conta.js', 'Conta');

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
            <h1 class="depontaponta">Conta</h1>
            <div id="infos1">
                <form action="#" method="post" id="form" enctype="multipart/form-data">
                    <div>
                        <div id="imguser">
                            <img id="ifimg" src="..\img\mais.svg">
                            <?php
                            if ($_SESSION['imagem_user'] != null) {
                            ?>
                                <script type="text/javascript">
                                    $('#ifimg').hide();
                                    $('#user-img').hide();

                                    $(document).ready(function() {
                                        $('#arquivo').change(function() {

                                            $('#user-img').hide();
                                            $('#user-imgOn').show();
                                            $("#ifimg").hide();

                                            const file = $(this)[0].files[0]

                                            const fileReader = new FileReader()

                                            fileReader.onloadend = function() {
                                                $('#user-imgOn').attr('src', fileReader.result);
                                            }

                                            fileReader.readAsDataURL(file)
                                        });
                                    });
                                </script>
                            <?php
                                echo '<img id="user-imgOn" src="data:image/jpg;base64,' . $_SESSION['imagem_user'] . '">';
                            } else {
                            ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#user-img').hide();

                                        $('#arquivo').change(function() {

                                            $('#user-img').show();
                                            $("#ifimg").hide();

                                            const file = $(this)[0].files[0]

                                            const fileReader = new FileReader()

                                            fileReader.onloadend = function() {
                                                $('#user-img').attr('src', fileReader.result);
                                            }

                                            fileReader.readAsDataURL(file)
                                        });
                                    });
                                </script>
                            <?php
                            }
                            ?>
                            <img id="user-img">
                        </div>
                        <label id="addphoto" for="arquivo">Adicionar Foto</label>
                        <input name="arquivo" id="arquivo" type="file">
                    </div>
                    <div id="form-newpost">
                        <input class="depontaponta nm_usuario" type="text" name="nome" id="nome" value="">
                        <input class="depontaponta" type="email" name="email" id="email" value="">
                        <input type="tel" name="telefone" id="telefone" value="">
                        <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formperfil-alter" />
                        <a href="#senha_modal" rel="modal" class="depontaponta">Alterar Senha</a>
                        <button type="submit" id="btnenviar" class="depontaponta">Salvar</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
    <section id="senha_modal" class="window">
        <div class="modal_senha">
            <p class="fechar"><a href="#">x</a></p>
            <h1>Alterar Senha</h1>
            <form method="post" action="#" id="form_senha">
                <input type="hidden" class="depontaponta" id="hdnoperacao" name="hdnoperacao" value="formperfil-alter-senha" />
                <input type="password" name="oldSenha" id="oldSenha" placeholder="Senha antiga">
                <input type="password" name="newSenha" id="newSenha" placeholder="Nova senha">
                <input type="password" name="confirmSenha" id="confirmSenha" placeholder="Confirmar senha">
                <button type="submit" id="alter_senha">Confirmar</button>
            </form>
        </div>
    </section>
</div>

<script type="text/javascript" src="../js/jquery.toast.js"></script>

<div id="mascara"></div>

<script type="text/javascript">
    $(document).ready(function() {

        $(".nm_usuario").val('<?php echo $_SESSION['nome_user']; ?>');
        $("#email").val('<?php echo $_SESSION['email_user']; ?>');
        $("#telefone").val('<?php echo $_SESSION['cel_user']; ?>');

    });
</script>

<?php
require_once '../includes/application/crud/Conta/Alterar_senha.php';

if ($_SESSION['reload'] == 1) {
?>
    <script type="text/javascript">
        $.toast({
            heading: 'Sucesso',
            text: "Informações de conta alteradas!",
            showHideTransition: 'fade',
            icon: 'success',
            position: 'top-center',
            bgColor: '#F15A24',
            loaderBg: 'white',
            hideAfter: 5000
        });
    </script>
<?php
    $_SESSION['reload'] = 0;
}
?>

<?php
require_once '../includes\application\crud\Conta\Alterar_conta.php';
?>