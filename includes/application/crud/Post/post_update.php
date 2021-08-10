<?php

require_once '../includes/db/dbconnection.php';

if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formpost-update') {

    /******
     * Upload de imagens
     ******/
    // verifica se foi enviado um arquivo
    //Upload de arquivos    
    // verifica se foi enviado um arquivo

    if (
        isset($_FILES['arquivo']['name']) &&
        $_FILES["arquivo"]["error"] == 0
    ) {

        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $nome = $_FILES['arquivo']['name'];
        $foto = $_FILES['arquivo'];
        // Pega a extensao
        $extensao = strrchr($nome, '.');

        // Converte a extensao para mimusculo
        $extensao = strtolower($extensao);

        // Somente imagens, .jpg;.jpeg;.gif;.png
        // Aqui eu enfileiro as extensões permitidas e separo por ';'
        // Isso serve apenas para eu poder pesquisar dentro desta String
        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            //Verificando o tamanho da imagem para determina se 
            //realmente é uma imagem e não um arquivo com extensão 
            //modificada --> PREVENTIVO !! <-- 
            if (getimagesize($arquivo_tmp)[0] > 0) {

                if ($foto['size'] < 2000000) {


                    $imagemPost = file_get_contents($arquivo_tmp);


                    if (isset(
                        $_POST['nome'],
                        $_POST['descricao'],
                        $_POST['link'],
                        $_POST['data']
                    )) {

                        $tituloPost = trim($_POST['nome']);
                        $descricaoPost = trim($_POST['descricao']);
                        $linkPost = trim($_POST['link']);
                        $dataPost =  trim($_POST['data']);

                        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
                        if (
                            !empty($tituloPost) &&
                            !empty($descricaoPost) &&
                            !empty($dataPost)
                        ) {

                            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
                            if ((strlen($tituloPost) <= 20) &&
                                (strlen($descricaoPost) <= 500) &&
                                (strlen($linkPost) <= 500) &&
                                (strlen($dataPost) == 10)
                            ) {
                                $data_hoje = date('Y-m-d');
                                if ($dataPost >= $data_hoje) {

                                    //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                                    if (
                                        preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $tituloPost)
                                        // preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',  $data)
                                    ) {
                                        $idusuario = $_SESSION['usuario_logado'];

                                        try {

                                            $comandoSQL = "call getPost_for_idusuario(" . $idusuario . ",'" . $tituloPost . "');";

                                            // $comandoSQL =   " select idusuario, nm_post ";
                                            // $comandoSQL = $comandoSQL .  " from post ";
                                            // $comandoSQL = strtolower($comandoSQL);
                                            // // Aqui eu insiro os valores 
                                            // $comandoSQL = $comandoSQL .  " where ";
                                            // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($idusuario) . " AND ";
                                            // $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($titulo);

                                            $dados = $conn->query($comandoSQL);

                                            $count = $dados->rowCount();
                                            if ($count > 1) {
?>
                                                <script type="text/javascript">
                                                    $.toast({
                                                        heading: 'Opa!',
                                                        text: "Postagem com nome já existente",
                                                        showHideTransition: 'fade',
                                                        icon: 'warning',
                                                        position: 'top-center',
                                                        bgColor: '#F15A24',
                                                        loaderBg: 'white',
                                                        hideAfter: 5000
                                                    });
                                                </script>
                                            <?php
                                                $dados->closeCursor();
                                            }
                                            $dados->closeCursor();
                                        } catch (PDOException $Exception) {
                                            echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                                            exit();
                                        }

                                        try {
                                            $updatePost = date('Y/m/d H:i');

                                            $imagem64 = base64_encode($imagemPost);

                                            //INSERT
                                            // Aqui eu indico as tabelas e os campos que preciso 
                                            $comandoSQL =   " UPDATE post ";
                                            $comandoSQL = strtolower($comandoSQL);
                                            // Aqui eu insiro os valores 
                                            $comandoSQL = $comandoSQL . "SET nm_post = " .  $conn->quote($tituloPost)       .  " , ";
                                            $comandoSQL = $comandoSQL . " imagem = " .  $conn->quote($imagem64)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                                            $comandoSQL = $comandoSQL . " ds_post = " .  $conn->quote($descricaoPost)      .  " , ";
                                            $comandoSQL = $comandoSQL . " dt_validade = " .  $conn->quote($dataPost)   .  "  , ";
                                            $comandoSQL = $comandoSQL . " cd_link = " .  $conn->quote($linkPost)   .  "  , ";
                                            $comandoSQL = $comandoSQL . " dt_update = " .  $conn->quote($updatePost);
                                            $comandoSQL = $comandoSQL . " WHERE nm_post = " . $conn->quote($_GET['post']);

                                            $linhasafetadas = $conn->prepare($comandoSQL);

                                            $linhasafetadas->execute();

                                            $_SESSION['post_alterado'] = 1;

                                            if (!isset($_GET['colecao']) && !isset($_GET['mural'])) {

                                            ?>
                                                <script type="text/javascript">
                                                    window.location.replace("./post.php?post=<?php echo $tituloPost ?>");
                                                </script>
                                            <?php
                                            }

                                            if (isset($_GET['colecao'])) {

                                            ?>
                                                <script type="text/javascript">
                                                    window.location.replace("./post.php?post=<?php echo $tituloPost ?>&colecao=<?php echo $_GET['colecao'] ?>");
                                                </script>
                                            <?php
                                            }

                                            if (isset($_GET['mural'])) {
                                            ?>
                                                <script type="text/javascript">
                                                    window.location.replace("./post.php?post=<?php echo $tituloPost ?>&mural=<?php echo $_GET['mural'] ?>");
                                                </script>
                                        <?php
                                            }
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
                                            text: "Data de validade incorreta!",
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
                } else {
                    ?>
                    <script type="text/javascript">
                        $.toast({
                            heading: 'Erro',
                            text: "A imagem deve ser de no máximo 2MB!",
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
                        text: "Arquivo de imagem inválido ou corrompido.",
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
                    text: "Você só pode enviar arquivos .jpg; .jpeg; .png; .gif",
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

    if (isset(
        $_POST['nome'],
        $_POST['descricao'],
        $_POST['link'],
        $_POST['data']
    )) {

        $tituloPost = trim($_POST['nome']);
        $descricaoPost = trim($_POST['descricao']);
        $linkPost = trim($_POST['link']);
        $dataPost =  trim($_POST['data']);

        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
        if (
            !empty($tituloPost) &&
            !empty($descricaoPost) &&
            !empty($dataPost)
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if ((strlen($tituloPost) <= 20) &&
                (strlen($descricaoPost) <= 500) &&
                (strlen($linkPost) <= 500) &&
                (strlen($dataPost) == 10)
            ) {
                $data_hoje = date('Y-m-d');
                if ($dataPost >= $data_hoje) {

                    //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                    if (
                        preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $tituloPost)
                        // preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',  $data)
                    ) {
                        $idusuario = $_SESSION['usuario_logado'];

                        try {

                            $comandoSQL = "call getPost_for_idusuario(" . $idusuario . ",'" . $tituloPost . "');";

                            // $comandoSQL =   " select idusuario, nm_post ";
                            // $comandoSQL = $comandoSQL .  " from post ";
                            // $comandoSQL = strtolower($comandoSQL);
                            // // Aqui eu insiro os valores 
                            // $comandoSQL = $comandoSQL .  " where ";
                            // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($idusuario) . " AND ";
                            // $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($titulo);

                            $dados = $conn->query($comandoSQL);

                            $count = $dados->rowCount();
                            if ($count == 1) {
            ?>
                                <script type="text/javascript">
                                    $.toast({
                                        heading: 'Opa!',
                                        text: "Postagem com nome já existente",
                                        showHideTransition: 'fade',
                                        icon: 'warning',
                                        position: 'top-center',
                                        bgColor: '#F15A24',
                                        loaderBg: 'white',
                                        hideAfter: 5000
                                    });
                                </script>
                                <?php
                                $dados->closeCursor();
                            }
                            $dados->closeCursor();
                        } catch (PDOException $Exception) {
                            echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                            exit();
                        }
                        if ($count == 0) {
                            try {
                                $updatePost = date('Y/m/d H:i');

                                // Aqui eu indico as tabelas e os campos que preciso 
                                $comandoSQL =   " UPDATE post ";
                                $comandoSQL = strtolower($comandoSQL);
                                // Aqui eu insiro os valores 
                                $comandoSQL = $comandoSQL . "SET nm_post = " .  $conn->quote($tituloPost)       .  " , ";
                                $comandoSQL = $comandoSQL . " ds_post = " .  $conn->quote($descricaoPost)      .  " , ";
                                $comandoSQL = $comandoSQL . " dt_validade = " .  $conn->quote($dataPost)   .  "  , ";
                                $comandoSQL = $comandoSQL . " cd_link = " .  $conn->quote($linkPost)   .  "  , ";
                                $comandoSQL = $comandoSQL . " dt_update = " .  $conn->quote($updatePost);
                                $comandoSQL = $comandoSQL . " WHERE nm_post = " . $conn->quote($_GET['post']);

                                $linhasafetadas = $conn->prepare($comandoSQL);

                                $linhasafetadas->execute();

                                $_SESSION['post_alterado'] = 1;

                                if (!isset($_GET['colecao']) && !isset($_GET['mural'])) {

                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>");
                                    </script>
                                <?php
                                }

                                if (isset($_GET['colecao'])) {

                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>&colecao=<?php echo $_GET['colecao'] ?>");
                                    </script>
                                <?php
                                }

                                if (isset($_GET['mural'])) {
                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>&mural=<?php echo $_GET['mural'] ?>");
                                    </script>
                                <?php
                                }
                            } catch (PDOException $Exception) {
                                echo "INSERT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                            } catch (Exception $Exception) {
                                echo "Erro GERAL  - " . $Exception;
                            }
                        }

                        if ($count == 1) {
                            try {
                                $updatePost = date('Y/m/d H:i');

                                // Aqui eu indico as tabelas e os campos que preciso 
                                $comandoSQL =   " UPDATE post ";
                                $comandoSQL = strtolower($comandoSQL);
                                // Aqui eu insiro os valores 
                                $comandoSQL = $comandoSQL . " SET ds_post = " .  $conn->quote($descricaoPost)      .  " , ";
                                $comandoSQL = $comandoSQL . " dt_validade = " .  $conn->quote($dataPost)   .  "  , ";
                                $comandoSQL = $comandoSQL . " cd_link = " .  $conn->quote($linkPost)   .  "  , ";
                                $comandoSQL = $comandoSQL . " dt_update = " .  $conn->quote($updatePost);
                                $comandoSQL = $comandoSQL . " WHERE nm_post = " . $conn->quote($_GET['post']);

                                $linhasafetadas = $conn->prepare($comandoSQL);

                                $linhasafetadas->execute();

                                $_SESSION['post_alterado'] = 1;

                                if (!isset($_GET['colecao']) && !isset($_GET['mural'])) {

                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>");
                                    </script>
                                <?php
                                }

                                if (isset($_GET['colecao'])) {

                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>&colecao=<?php echo $_GET['colecao'] ?>");
                                    </script>
                                <?php
                                }

                                if (isset($_GET['mural'])) {
                                ?>
                                    <script type="text/javascript">
                                        window.location.replace("./post.php?post=<?php echo $tituloPost ?>&mural=<?php echo $_GET['mural'] ?>");
                                    </script>
                        <?php
                                }
                            } catch (PDOException $Exception) {
                                echo "INSERT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                            } catch (Exception $Exception) {
                                echo "Erro GERAL  - " . $Exception;
                            }
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
                            text: "Data de validade incorreta!",
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
