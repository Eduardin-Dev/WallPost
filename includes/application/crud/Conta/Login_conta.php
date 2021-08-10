<?php

require_once 'includes\db\dbconnection.php';

// COLOCA OS DADOS NAS VARIAVEIS VIA POST
if (isset($_POST['hdncontrole']) && $_POST['hdncontrole'] == 'formphp-conta-login') {

    //Vieram os campos do form? //RuleCheckFields // Regra de Checagem de Campos 
    if (isset($_POST['txtnome'], $_POST['password'])) {

        $nome = trim($_POST['txtnome']);
        $senha =  trim($_POST['password']);

        if (
            !empty($nome) &&
            !empty($senha)
        ) {

            try {
                // Aqui eu indico as tabelas e os campos que preciso 
                $comandoSQL =   " select * ";
                $comandoSQL = $comandoSQL .  " from usuario ";
                $comandoSQL = strtolower($comandoSQL);
                // Aqui eu insiro os valores 
                $comandoSQL = $comandoSQL .  " where ";
                $comandoSQL = $comandoSQL . " ds_email = " . $conn->quote($nome);

                $dados = $conn->prepare($comandoSQL);

                $dados->execute();

                $rows = $dados->rowCount();

                if ($rows == 1) {
                    while ($count = $dados->fetch(PDO::FETCH_ASSOC)) {

                        if (password_verify($senha, $count['cd_senha'])) {

                            $_SESSION['usuario_logado'] = $count['idusuario'];
                            $_SESSION['nome_user'] = $count['nm_usuario'];
                            $_SESSION['email_user'] = $count['ds_email'];
                            $_SESSION['cel_user'] = $count['ds_celular'];
                            $_SESSION['senha_user'] = $count['cd_senha'];

?>

                            <script>
                                window.location.replace("./pags/home.php");
                            </script>

                        <?php
                        } else {
                        ?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Erro',
                                    text: "Senha inválida!",
                                    showHideTransition: 'fade',
                                    icon: 'error',
                                    position: 'bottom-left',
                                    bgColor: '#F15A24',
                                    loaderBg: 'white',
                                    hideAfter: 5000
                                });
                            </script>
                    <?php
                        }
                    }
                    exit();
                } else {
                    ?>
                    <script type="text/javascript">
                        $.toast({
                            heading: 'Erro',
                            text: "Conta inexistente!",
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'bottom-left',
                            bgColor: '#F15A24',
                            loaderBg: 'white',
                            hideAfter: 5000
                        });
                    </script>
            <?php
                }
            } catch (PDOException $Exception) {
                echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
            }
        } else {
            ?>
            <script type="text/javascript">
                $.toast({
                    heading: 'Erro',
                    text: "Campos vazios!",
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'bottom-left',
                    bgColor: '#F15A24',
                    loaderBg: 'white',
                    hideAfter: 5000
                });
            </script>
<?php
        }
    }
}