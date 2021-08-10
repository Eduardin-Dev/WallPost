<?php

require_once '../includes/db/dbconnection.php';

if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formperfil-alter-senha') {

    if (isset(
        $_POST['oldSenha'],
        $_POST['newSenha'],
        $_POST['confirmSenha']
    )) {

        $newSenha = trim($_POST['newSenha']);
        $oldSenha = trim($_POST['oldSenha']);
        $confirmSenha = trim($_POST['confirmSenha']);

        if (
            !empty($newSenha) &&
            !empty($oldSenha) &&
            !empty($confirmSenha)
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if ((strlen($newSenha) <= 45) &&
                (strlen($oldSenha) <= 45) &&
                (strlen($confirmSenha) <= 45)
            ) {

                if ($newSenha != $oldSenha) {

                    if ($newSenha == $confirmSenha) {

                        if (password_verify($oldSenha, $_SESSION['senha_user'])) {

                            // CRIPTOGRAFAR SENHA
                            $options = [
                                'cost' => 12,
                            ];

                            $hash = password_hash($newSenha, PASSWORD_BCRYPT, $options);


                            try {
                                // Aqui eu indico as tabelas e os campos que preciso 
                                $comandoSQL =   " UPDATE usuario ";
                                $comandoSQL = strtolower($comandoSQL);
                                // Aqui eu insiro os valores 
                                $comandoSQL = $comandoSQL .  "SET cd_senha = " . $conn->quote($hash);
                                $comandoSQL = $comandoSQL .  " WHERE idusuario = " . $conn->quote($_SESSION['usuario_logado']);

                                $dados = $conn->prepare($comandoSQL);

                                $dados->execute();

                                $_SESSION['senha_user'] = $hash;

?>
                                <script type="text/javascript">
                                    $.toast({
                                        heading: 'Sucesso',
                                        text: "Senha alterada",
                                        showHideTransition: 'fade',
                                        icon: 'success',
                                        position: 'top-center',
                                        bgColor: '#F15A24',
                                        loaderBg: 'white',
                                        hideAfter: 5000
                                    });
                                </script>

                                <!-- <script>
                                    window.location.replace("http://localhost/WALLPOST/pags/conta.php");
                                </script> -->
                            <?php
                            } catch (PDOException $Exception) {
                                echo "UPDATE IMAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                            }
                        } else {
                            ?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Opa!',
                                    text: "Senha atual errada",
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
                    } else {
                        ?>
                        <script type="text/javascript">
                            $.toast({
                                heading: 'Opa!',
                                text: "Confirmação de senha não condiz",
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
                } else {
                    ?>
                    <script type="text/javascript">
                        $.toast({
                            heading: 'Opa!',
                            text: "Senha atual e nova são iguais",
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
            } else {
                ?>
                <script type="text/javascript">
                    $.toast({
                        heading: 'Erro!',
                        text: "Tamanho de campo invalido",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-center',
                        bgColor: '#F15A24',
                        loaderBg: 'white',
                        hideAfter: 5000
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                $.toast({
                    heading: 'Erro!',
                    text: "Campos vazios",
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-center',
                    bgColor: '#F15A24',
                    loaderBg: 'white',
                    hideAfter: 5000
                });
            </script>
        <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            $.toast({
                heading: 'Erro!',
                text: "Campos não foram setados",
                showHideTransition: 'fade',
                icon: 'error',
                position: 'top-center',
                bgColor: '#F15A24',
                loaderBg: 'white',
                hideAfter: 5000
            });
        </script>
<?php
    }
}
