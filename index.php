<?php  // Bloco HEADER
require_once 'includes/header.php';
get_header('css/style.css', 'js/script.js', 'Wallpost');
session_start();
$_SESSION['descricao_salva'] = null;
$_SESSION['usuario_logado'] = null;
$_SESSION['post_criado'] = null;
$_SESSION['reload'] = null;
$_SESSION['imagem_user'] = null;
$_SESSION['mural_criado'] = null;
$_SESSION['colecao_excluida'] = null;
$_SESSION['post_excluido'] = null;
$_SESSION['mural_excluido'] = null;
$_SESSION['post_mural'] = null;
$_SESSION['post_colecao'] = null;
$_SESSION['post_mural_delete'] = null;
$_SESSION['post_colecao_delete'] = null;
$_SESSION['post_alterado'] = null;
$_SESSION['vinculo_excluido'] = null;
$_SESSION['post_colecao_update'] = null;
?>
<link rel="stylesheet" href="./css/jquery.toast.css">
<!-- Bloco Página -->
<script src="./js/jquery.toast.js"></script>
<div class="main">

    <section class="apresentation">

        <section class="navbar">
            <button id="inicio">Início</button>

            <button id="como">Como funciona?</button>

            <button id="quem">Quem somos?</button>
        </section>

        <h1 class="title">WALLPOST</h1>
        <p class="comop">Crie murais digitais e faça suas postagens online, baixe o Aplicativo do WallPost e fique por cima das informações postadas nos murais em seu celular! Organize suas postagens em coleções e tenha o poder de definir até quando a postagem estará ativa no mural.</p>
        <p class="quemp">Um grupo de 4 jovens, com o objetivo de criar um jeito de as informações chegarem mais facilmente até as pessoas.</p>
    </section>
    <section class="login">
        <p class="pWelcome para">Bem vindo de volta,</p>
        <p class="pLc para2">Login</p>

        <form action="." method="post" id="fLogin">
            <input type="hidden" name="hdncontrole" value="formphp-conta-login">
            <input class="depontaponta" type="text" name="txtnome" id="txtnome" placeholder="Email">
            <input class="depontaponta" type="password" name="password" id="password" placeholder="Senha">
            <button id="inplogin" type="submit"></button>
        </form>
        <button id="btnesqueci">Esqueceu sua senha?</button>

        <form action="." method="post" id="fesqueci">
            <input type="hidden" name="hdncontrole" value="formphp-conta-esqueci">
            <input class="depontaponta" type="email" id="emailEsqueci" name="email" id="email" placeholder="Informe seu email">
            <button type="submit">Enviar</button>
        </form>

        <form action="." method="post" id="fCadastro" ajax="true">
            <input type="hidden" name="hdncontrole" value="formphp-conta-insert">
            <input class="depontaponta" type="text" name="txtnome" id="txtnome" placeholder="Nome de usuário" maxlength="45">
            <input class="depontaponta" type="password" name="password" id="password" placeholder="Senha" minlength="5" maxlength="25">
            <input class="depontaponta" type="email" name="email" id="email" placeholder="Email" maxlength="200">
            <input class="celular" type="tel" name="celular" id="celular" value="" placeholder="Celular" minlength="11" maxlength="11">
            <button id="inpcadastro" type="submit"></button>
        </form>

        <section class="buttonsLogin">
            <button id="btnLogin">Login</button>
            <button id="btnCadastro">Criar conta</button>
        </section>
    </section>
</div>
<script type="text/javascript">
    $(".comop").hide();
    $(".quemp").hide();
    $("#fCadastro").hide();
    $("#fesqueci").hide();
    $("#inplogin").hide();
    $("#inpcadastro").hide();
</script>

<!-- ------------------------------
    Fim Bloco Página -->

<?php // Bloco FOOTER
require_once './includes/application/crud/Conta/Login_conta.php';
require_once 'includes/application/crud/Conta/Criar_conta.php';
require_once './includes/application/crud/Conta/envia.php';
require_once 'includes/footer.php';
?>