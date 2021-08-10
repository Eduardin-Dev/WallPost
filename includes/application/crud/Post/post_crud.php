<?php

require_once '../includes/db/dbconnection.php';

if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formpost-insert') {

    /******
     * Upload de imagens
     ******/
    // verifica se foi enviado um arquivo
    //Upload de arquivos    
    // verifica se foi enviado um arquivo

    $_SESSION['descricao_salva'] = trim($_POST['descricao']);
    $_SESSION['post_criado'] = null;

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


                    $imagem = file_get_contents($arquivo_tmp);

                    if (isset(
                        $_POST['nome'],
                        $_POST['descricao'],
                        $_POST['link'],
                        $_POST['data']
                    )) {

                        $titulo = trim($_POST['nome']);
                        $descricao = trim($_POST['descricao']);
                        $link = trim($_POST['link']);
                        $data =  trim($_POST['data']);

                        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
                        if (
                            !empty($titulo) &&
                            !empty($descricao) &&
                            !empty($data)
                        ) {
                            $_SESSION['descricao_salva'] = $descricao;

                            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
                            if ((strlen($titulo) <= 20) &&
                                (strlen($descricao) <= 500) &&
                                (strlen($link) <= 500) &&
                                (strlen($data) == 10)
                            ) {
                                $data_hoje = date('Y-m-d');
                                if ($data >= $data_hoje) {

                                    //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                                    if (
                                        preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $titulo)
                                        // preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',  $data)
                                    ) {
                                        $idusuario = $_SESSION['usuario_logado'];

                                        try {

                                            $comandoSQL = "call getPost_for_idusuario(" . $idusuario . ",'" . $titulo . "');";

                                            // $comandoSQL =   " select idusuario, nm_post ";
                                            // $comandoSQL = $comandoSQL .  " from post ";
                                            // $comandoSQL = strtolower($comandoSQL);
                                            // // Aqui eu insiro os valores 
                                            // $comandoSQL = $comandoSQL .  " where ";
                                            // $comandoSQL = $comandoSQL . " idusuario = " . $conn->quote($idusuario) . " AND ";
                                            // $comandoSQL = $comandoSQL . " nm_post = " . $conn->quote($titulo);

                                            $dados = $conn->query($comandoSQL);

                                            $count = $dados->rowCount();
                                            if ($count > 0) {
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

                                                exit();
                                            }
                                            $dados->closeCursor();
                                        } catch (PDOException $Exception) {
                                            echo "SELECT MENSAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                                            exit();
                                        }

                                        try {
                                            $criacao = date('Y/m/d H:i');
                                            $update = date('Y/m/d H:i');

                                            $imagem64 = base64_encode($imagem);

                                            //INSERT
                                            // Aqui eu indico as tabelas e os campos que preciso 
                                            $comandoSQL =   " INSERT INTO post (nm_post, imagem, ds_post, dt_validade, cd_link, dt_create, idusuario, dt_update ) ";
                                            $comandoSQL = $comandoSQL .  " VALUES ";
                                            $comandoSQL = strtolower($comandoSQL);
                                            // Aqui eu insiro os valores 
                                            $comandoSQL = $comandoSQL .  " ( ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($titulo)       .  " , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($imagem64)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                                            $comandoSQL = $comandoSQL .  $conn->quote($descricao)      .  " , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($data)   .  "  , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($link)   .  "  , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($criacao)   .  "  , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($idusuario)   .  "  , ";
                                            $comandoSQL = $comandoSQL .  $conn->quote($update)   .  "  ) ";


                                            $linhasafetadas = $conn->exec($comandoSQL);

                                            $_SESSION['descricao_salva'] = null;
                                            $_SESSION['post_criado'] = 1;

                                            sleep(2);
                                            ?>
                                            <script type="text/javascript">
                                                window.location.replace("./posts.php");
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
    } else {
        ?>
        <script type="text/javascript">
            $.toast({
                heading: 'Erro',
                text: "Selecione uma capa para o Post",
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
