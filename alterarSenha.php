<?php  // Bloco HEADER
require_once 'includes/header.php';
get_header('css/alterSenha.css', '', 'Alterar Senha');

?>

<link rel="stylesheet" href="./css/jquery.toast.css">
<!-- Bloco Página -->
<script src="./js/jquery.toast.js"></script>

<div class="main">
    <h1 id="title">WALLPOST</h1>
    <section class="block-alter">
        <h1>Redefinir Senha</h1>
        <form method="POST" action="#">
        <input type="hidden" name="hdncontrole" value="formphp-conta-redefinir">
        <section class="inputs">
            <input type="password" placeholder="Nova Senha" name="cd_novaSenha" minlength="5">
            <input type="password" placeholder="Confirmar senha" name="cd_confirma" minlength="5">
            <button type="submit" id="button-redefinir">Redefinir</button>
        </section>
        </form>
    </section>
</div>

<?php
require_once './includes/application/crud/Conta/RedefinirSenha.php';
?>