<?php

require_once '../includes/db/dbconnection.php';

if (isset($_POST['hdnoperacao']) && $_POST['hdnoperacao'] == 'formperfil-alter') {

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

                    $imagem = file_get_contents($arquivo_tmp);

                    $imagem64 = base64_encode($imagem);
                    if ($imagem64 != $_SESSION['imagem_user']) {
                        try {
                            // Aqui eu indico as tabelas e os campos que preciso 
                            $comandoSQL =   " UPDATE usuario ";
                            $comandoSQL = strtolower($comandoSQL);
                            // Aqui eu insiro os valores 
                            $comandoSQL = $comandoSQL .  "SET imagem_user = " . $conn->quote($imagem64);
                            $comandoSQL = $comandoSQL .  " WHERE idusuario = " . $conn->quote($_SESSION['usuario_logado']);

                            $dados = $conn->prepare($comandoSQL);

                            $dados->execute();

                            $_SESSION['imagem_user'] = $imagem64;
?>
                            <script>
                                window.location.replace("./conta.php");
                            </script>
                    <?php
                        } catch (PDOException $Exception) {
                            echo "UPDATE IMAGEM - Erro: " . $Exception->getMessage() . " . Código" . $Exception->getCode();
                        } catch (Exception $Exception) {
                            echo "Erro GERAL  - " . $Exception;
                        }
                    } else {
                        echo 'exit';
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
        $_POST['email'],
        $_POST['telefone']
    )) {

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $celular = trim($_POST['telefone']);

        //Campos estão preenchidos? //RuleRequired //Regra de Dados Obrigatórios 
        if (
            $nome != $_SESSION['nome_user'] or
            $email != $_SESSION['email_user'] or
            $celular != $_SESSION['cel_user']
        ) {

            //Campos estão com o tamanho adequado?  //RuleMaxLength  //Regra de Tamanho Máximo dos Dados
            if ((strlen($nome) <= 25) &&
                (strlen($email) <= 100) &&
                (strlen($celular) == 15)
            ) {
                //Campos estão com os caracteres corretos e formato correto?  //RuleValidCharset  //Regra de Cadeia de Caracteres Corretos
                if (
                    preg_match('/^[a-zA-ZÀ-ú0-9-\s]+$/u',  $nome) &&
                    preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email) &&
                    preg_match('/^\([0-9]{2}\) [0-9]{4,5}\-[0-9]{4}$/',  $celular)
                ) {

                    try {

                        $comandoSQL =   " select * ";
                        $comandoSQL = $comandoSQL .  " from usuario ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " where ";
                        $comandoSQL = $comandoSQL . " ds_email = " . $conn->quote($email);


                        $dados = $conn->prepare($comandoSQL);

                        $dados->execute();

                        $count = $dados->rowCount();
                        if ($count > 1) {
            ?>
                            <script type="text/javascript">
                                $.toast({
                                    heading: 'Opa!',
                                    text: "e-mail já cadastrado",
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
                    }

                    try {
                        // Aqui eu indico as tabelas e os campos que preciso 
                        $comandoSQL =   " UPDATE usuario ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  "SET nm_usuario = " . $conn->quote($nome)       .  " , ";
                        $comandoSQL = $comandoSQL .  "ds_email = " . $conn->quote($email)   .  " , ";         //Quote coloca entre aspas e é um método / função do PDO ($conn)
                        $comandoSQL = $comandoSQL .  "ds_celular = " . $conn->quote($celular);
                        $comandoSQL = $comandoSQL .  " WHERE idusuario = " . $conn->quote($_SESSION['usuario_logado']);

                        $linhasafetadas = $conn->exec($comandoSQL);

                        $comandoSQL =   " select * ";
                        $comandoSQL = $comandoSQL .  " from usuario ";
                        $comandoSQL = strtolower($comandoSQL);
                        // Aqui eu insiro os valores 
                        $comandoSQL = $comandoSQL .  " where ";
                        $comandoSQL = $comandoSQL . " nm_usuario = " . $conn->quote($nome) . " OR ";
                        $comandoSQL = $comandoSQL . " ds_email = " . $conn->quote($email);


                        $dados = $conn->query($comandoSQL);

                        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                            $_SESSION['nome_user'] = $count['nm_usuario'];
                            $_SESSION['email_user'] = $count['ds_email'];
                            $_SESSION['cel_user'] = $count['ds_celular'];
                        endwhile;

                        $_SESSION['reload'] = 1;
                        ?>


                        <script>
                            window.location.replace("./conta.php");
                        </script>

                    <?php
                        exit();
                    } catch (PDOException $Exception) {
                    ?>
                        <script type="text/javascript">
                            $.toast({
                                heading: 'Opa!',
                                text: "e-mail já cadastrado",
                                showHideTransition: 'fade',
                                icon: 'warning',
                                position: 'top-center',
                                bgColor: '#F15A24',
                                loaderBg: 'white',
                                hideAfter: 5000
                            });
                        </script>
                    <?php
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
        }
    }
}
