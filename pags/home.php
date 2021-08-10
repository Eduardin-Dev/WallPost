<?php // Bloco do Header
require_once '../includes/header.php';
get_header('../css/home.css', '../js/home.js', 'Home');

session_start();

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
    <?php
    require_once '../includes/application/crud/Conta/Select_conta.php';
    ?>

    <section class="pagina">
        <p class="sair"><a href="../">Sair</a></p>
        <section class="infos">
            <div class="header">
                <section class="mural">
                    <p>Murais</p>
                    <p>Digitais</p>
                    <p>Divulgação inteligente</p>
                </section>
                <section class="userphoto">
                    <div id="photo">
                        <?php
                        if ($_SESSION['imagem_user'] != null) {
                            echo '<img id"user-img" src="data:image/jpg;base64,' . $_SESSION['imagem_user'] . '">';
                        }
                        ?>
                    </div>
                    <a href="conta.php" class="nm_usuario"><?php echo $_SESSION['nome_user'] ?></a>
                </section>
            </div>
            <div class="buttons">
                <form action="newmural.php">
                    <button id="novomural">Novo Mural</button>
                </form>
                <form action="murais.php">
                    <button id="meusmurais">Meus Murais</button>
                </form>
            </div>
            <div class="posts">
                <div class="post-tem newpost">
                    <a href="./newpost.php"><img class="imgpost" src="../img/mais.svg">
                        <p>Novo <span>Post</span></p>
                    </a>
                </div>
                <?php
                require_once '../includes/application/crud/Post/posts_select_home.php';

                if ($linhas > 0) {
                    while ($count = $postDados->fetch(PDO::FETCH_ASSOC)) :

                        $imagem = $count['imagem'];
                        $nomePost = $count['nm_post'];

                        if ($linhas > 0) {
                ?>
                            <div id="post-item1" class="post-item">
                                <a href="post.php?post=<?php echo $nomePost ?>">
                                    <?php echo '<img id="home-img" src="data:image/jpg;base64,' . $imagem . '">'; ?>
                                </a>
                            </div>
                <?php
                        }
                    endwhile;
                    $postDados->closeCursor();
                }
                $postDados->closeCursor();
                ?>
            </div>
        </section>
    </section>
</div>