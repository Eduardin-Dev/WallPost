<?php

require_once '../includes/db/dbconnection.php';

function random_string($length)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

// COLOCA OS DADOS NAS VARIAVEIS VIA POST
if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formmural-update') {

    //Vieram os campos do form? //RuleCheckFields // Regra de Checagem de Campos 
    if (isset(
        $_POST['nome'],
        $_POST['descricao'],
        $_POST['tipo']
    )) {

        $nome_mural = trim($_POST['nome']);
        $descricao_mural = trim($_POST['descricao']);
        $tipo_mural = trim($_POST['tipo']);

        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
        if (
            !empty($nome_mural) &&
            !empty($descricao_mural) &&
            !empty($tipo_mural)
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if ((strlen($nome_mural) <= 16) &&
                (strlen($descricao_mural) <= 300) &&
                (strlen($tipo_mural) <= 2)
            ) {

                //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                if (
                    preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $nome_mural) &&
                    preg_match('/^[0-9]+$/',  $tipo_mural)
                ) {

                    try {
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " select nm_mural, idusuario, cd_chave";
                        $comandoSQL = $comandoSQL .  " from mural ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " where ";
                        $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
                        $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($nome_mural);

                        $dados = $conn->query($comandoSQL);

                        $count = $dados->rowCount();
                        if ($count > 1) {
?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Opa!',
                                    text: "Mural com nome já existente!",
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
                    } catch (PDOException $Exception) {
                        echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                    }

                    try {
                        if ($count == 1 || $count == 0) {
                            $data_create = date('Y/m/d H:i');
                            $data_update = date('Y/m/d H:i');
                            //INSERT
                            //Aqui eu indico as tabelas e os campos que preciso 
                            $comandoSQL =   " UPDATE mural ";
                            $comandoSQL = strtolower($comandoSQL);
                            //Aqui eu insiro os valores 
                            $comandoSQL = $comandoSQL .  " SET ";
                            $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($nome_mural)       .  " , ";
                            $comandoSQL = $comandoSQL . " ds_mural = " . $conn->quote($descricao_mural)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                            $comandoSQL = $comandoSQL . " ic_public = " . $conn->quote($tipo_mural)      .  " , ";
                            $comandoSQL = $comandoSQL . " dt_updateMural =" . $conn->quote($data_update);
                            $comandoSQL = $comandoSQL . " where idusuario = " . $conn->quote($_SESSION['usuario_logado']) . " AND ";
                            $comandoSQL = $comandoSQL . " nm_mural = " . $conn->quote($nm_mural);


                            $linhasafetadas = $conn->prepare($comandoSQL);

                            $linhasafetadas->execute();

                            $linhasafetadas->closeCursor();

                        ?>
                            <script type="text/javascript">
                                window.location.replace("./mural.php?mural=<?php echo $nome_mural ?>");
                            </script>
                    <?php
                        }
                    } catch (PDOException $Exception) {
                        echo "UPDATE MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
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
        echo 'mensagem erro';
    }
}
