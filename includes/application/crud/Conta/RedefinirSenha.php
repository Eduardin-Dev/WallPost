<?php

require_once './includes/db/dbconnection.php';

if (isset($_GET['chave'])) {

    $chave = $_GET['chave'];

    $chave = base64_decode($chave);

    if (isset($_POST['hdncontrole']) && $_POST['hdncontrole'] == 'formphp-conta-redefinir') {

        if (
            isset($_POST['cd_novaSenha']) &&
            isset($_POST['cd_confirma'])
        ) {
            $novaSenha = $_POST['cd_novaSenha'];
            $confirma = $_POST['cd_confirma'];

            if (
                !empty($novaSenha) &&
                !empty($confirma)
            ) {

                if ($novaSenha == $confirma) {


                    // CRIPTOGRAFAR SENHA
                    $options = [
                        'cost' => 12,
                    ];

                    $hash = password_hash($confirma, PASSWORD_BCRYPT, $options);

                    try {
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " UPDATE usuario ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  "SET cd_senha = " . $conn->quote($hash);
                        $comandoSQL = $comandoSQL .  " WHERE ds_email = " . $conn->quote($chave);

                        $dados = $conn->prepare($comandoSQL);

                        $dados->execute();

?>
                        <script type="text/javascript">
                            $.toast({
                                heading: 'Sucesso',
                                text: "Senha alterada",
                                textColor: '#F15A24',
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'bottom-left',
                                bgColor: 'white',
                                loaderBg: '#F15A24',
                                hideAfter: 5000
                            });
                        </script>

                    <?php
                    } catch (PDOException $Exception) {
                        echo "UPDATE SENHA - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                    }
                } else {
                    ?>
                    <script type="text/javascript">
                        $.toast({
                            heading: 'Erro',
                            text: "Senhas incompativeis!",
                            textColor: '#F15A24',
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'bottom-left',
                            bgColor: 'white',
                            loaderBg: '#F15A24',
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
                        text: "Campos vazios",
                        textColor: '#F15A24',
                        showHideTransition: 'fade',
                        icon: 'warning',
                        position: 'bottom-left',
                        bgColor: 'white',
                        loaderBg: '#F15A24',
                        hideAfter: 5000
                    });
                </script>

            <?php
            }
        } else {
            ?>
            <script>
                window.location.replace("./");
            </script>
    <?php
        }
    }
} else {
    ?>
    <script>
        window.location.replace("./");
    </script>
<?php
}
