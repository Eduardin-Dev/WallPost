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
if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formmural-insert') {

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
                        if ($count > 0) {
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
                            exit();
                        }
                    } catch (PDOException $Exception) {
                        echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                    }

                    try {

                        $comandoSQL =   " select cd_chave";
                        $comandoSQL = $comandoSQL .  " from mural ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 

                        $dados = $conn->prepare($comandoSQL);

                        $dados->execute();

                        $rows = $dados->rowCount();


                        if ($rows >= 1) {
                            while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                                do {
                                    $chave = random_string(8);
                                } while ($chave == $count['cd_chave']);

                            endwhile;
                        }

                        if ($rows == 0) {
                            $chave = random_string(8);
                        }


                        $data_create = date('Y/m/d H:i');
                        $data_update = date('Y/m/d H:i');
                        //INSERT
                        //Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " INSERT INTO mural (nm_mural, ds_mural, ic_public, dt_create, idusuario, cd_chave, dt_updateMural) ";
                        $comandoSQL = $comandoSQL .  " VALUES ";
                        $comandoSQL = strtolower($comandoSQL);
                        //Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " ( ";
                        $comandoSQL = $comandoSQL .  $conn->quote($nome_mural)       .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($descricao_mural)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                        $comandoSQL = $comandoSQL .  $conn->quote($tipo_mural)      .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($data_create)      .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($_SESSION['usuario_logado'])      .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($chave)      .  " , ";
                        $comandoSQL = $comandoSQL .  $conn->quote($data_update)      .  " ) ";


                        $linhasafetadas = $conn->exec($comandoSQL);
                        $_SESSION['mural_criado'] = 1;
                        sleep(2);
                        ?>
                        <script type="text/javascript">
                            window.location.replace("./murais.php");
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
        echo 'mensagem erro';
    }
}
