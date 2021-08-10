<?php

require_once 'includes\db\dbconnection.php';

// COLOCA OS DADOS NAS VARIAVEIS VIA POST
if (isset($_POST['hdncontrole']) && $_POST['hdncontrole'] == 'formphp-conta-insert') {

    //Vieram os campos do form? //RuleCheckFields // Regra de Checagem de Campos 
    if (isset(
        $_POST['txtnome'],
        $_POST['password'],
        $_POST['email'],
        $_POST['celular']
    )) {

        $nome = trim($_POST['txtnome']);
        $celular = trim($_POST['celular']);
        $email = trim($_POST['email']);
        $senha =  trim($_POST['password']);

        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
        if (
            !empty($nome) &&
            !empty($celular) &&
            !empty($email) &&
            !empty($senha)
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if ((strlen($nome) <= 25) &&
                (strlen($celular) == 15) &&
                (strlen($email) <= 100) &&
                (strlen($senha) <= 45)
            ) {

                //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                if (
                    preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $nome) &&
                    preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email) &&
                    preg_match('/^\([0-9]{2}\) [0-9]{4,5}\-[0-9]{4}$/',  $celular)
                ) {

                    try {
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " select ds_email ";
                        $comandoSQL = $comandoSQL .  " from usuario ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " where ";
                        $comandoSQL = $comandoSQL . " ds_email = " . $conn->quote($email);

                        $dados = $conn->query($comandoSQL);

                        $count = $dados->rowCount();
                        if ($count > 0) {
?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Opa!',
                                    text: "e-mail já cadastrado!",
                                    showHideTransition: 'fade',
                                    icon: 'warning',
                                    position: 'bottom-left',
                                    bgColor: '#F15A24',
                                    loaderBg: 'white',
                                    hideAfter: 5000
                                });
                            </script>
                        <?php
                            exit();
                        }
                    } catch (PDOException $Exception) {
                        echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                    }

                    try {

                        // CRIPTOGRAFAR SENHA
                        $options = [
                            'cost' => 12,
                        ];

                        $hash = password_hash($senha, PASSWORD_BCRYPT, $options);

                        //INSERT
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " INSERT INTO usuario (nm_usuario, cd_senha, ds_email, ds_celular) ";
                        $comandoSQL = $comandoSQL .  " VALUES ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " ( ";
                        $comandoSQL = $comandoSQL .  $conn->quote($nome)       .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($hash)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                        $comandoSQL = $comandoSQL .  $conn->quote($email)      .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($celular)   .  "  ) ";

                        $linhasafetadas = $conn->exec($comandoSQL);

                        ?>
                        <script type="text/javascript">
                            $.toast({
                                heading: 'Sucesso',
                                text: "Cadastro realizado!",
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'bottom-left',
                                bgColor: '#F15A24',
                                loaderBg: 'white',
                                hideAfter: 5000
                            });
                        </script>
                    <?php
                    } catch (PDOException $Exception) {
                        echo "INSERT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                    } catch (Exception $Exception) {
                        echo "Erro GERAL  - " . $Exception;
                    }
                } else {
                    ?>
                    <script type="text/javascript">
                        $.toast({
                            heading: 'Erro',
                            text: "Formato de campo incorreto!",
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
            } else {
                ?>
                <script type="text/javascript">
                    $.toast({
                        heading: 'Erro',
                        text: "Tamanho de campo inválido",
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
    } else {
        echo 'mensagem erro ';
    }
}
