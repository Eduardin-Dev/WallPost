<?php

require_once '..\includes\db\dbconnection.php';

// COLOCA OS DADOS NAS VARIAVEIS VIA POST
if (isset($_POST['hdncontrole']) && $_POST['hdncontrole'] == 'formphp-colecao-insert') {

    //Vieram os campos do form? //RuleCheckFields // Regra de Checagem de Campos 
    if (isset(
        $_POST['newColecao']
    )) {

        $nmColecao = trim($_POST['newColecao']);

        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
        if (
            !empty($nmColecao)
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if (
                (strlen($nmColecao) <= 15)
            ) {

                //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                if (
                    preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $nmColecao)
                ) {

                    try {
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " select nm_colecao";
                        $comandoSQL = $comandoSQL .  " from colecao ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " where ";
                        $comandoSQL = $comandoSQL . " nm_colecao = " . $conn->quote($nmColecao) . " AND ";
                        $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']);

                        $dados = $conn->query($comandoSQL);

                        $count = $dados->rowCount();
                        if ($count > 0) {
?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Opa!',
                                    text: "Coleção já existe!",
                                    showHideTransition: 'fade',
                                    icon: 'warning',
                                    position: 'top-center',
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
                        //INSERT
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " INSERT INTO colecao (nm_colecao, idusuario) ";
                        $comandoSQL = $comandoSQL .  " VALUES ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " ( ";
                        $comandoSQL = $comandoSQL .  $conn->quote($nmColecao)       .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($_SESSION['usuario_logado'])   .  " ) ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)

                        $linhasafetadas = $conn->exec($comandoSQL);

                        ?>
                        <script>
                            window.location.replace("./colecoes.php");
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
                        heading: 'Erro',
                        text: "Tamanho de campo inválido",
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
                    heading: 'Erro',
                    text: "Campos vazios!",
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
        echo 'mensagem erro ';
    }
}
