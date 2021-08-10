<?php

require_once './includes/db/dbconnection.php';

require_once './src/PHPMailer.php';
require_once './src/SMTP.php';
require_once './src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['hdncontrole']) && $_POST['hdncontrole'] == 'formphp-conta-esqueci') {

    if (
        isset($_POST['email'])
    ) {

        $email = $_POST['email'];

        if (
            !empty($email)
        ) {


            if (
                preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)
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

                    $row = $dados->rowCount();

                    if ($row > 0) {
                        while ($count = $dados->fetch(PDO::FETCH_ASSOC)) :

                            $chave = $count['ds_email'];

                        endwhile;

                        $chave = base64_encode($chave);

                        $mensagem = '<a href="localhost/WALLPOST/alterarSenha.php?chave=' . $chave . '">Alterar Senha</a>';

                        $mail = new PHPMailer(true);

                        try {

                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'eduwarddossantos@gmail.com';
                            $mail->Password = '07jul2003';
                            $mail->Port = 587;

                            $mail->setFrom('eduwarddossantos@gmail.com');
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Redefinir senha - WALLPOST';
                            $mail->Body = '<h1>' . $mensagem . '</h1>';
                            $mail->AltBody = $mensagem;

                            if ($mail->send()) {
?>
                                <script type="text/javascript">
                                    $.toast({
                                        heading: 'Sucesso',
                                        text: "Email enviado!",
                                        textColor: 'white',
                                        showHideTransition: 'fade',
                                        icon: 'error',
                                        position: 'bottom-left',
                                        bgColor: '#F15A24',
                                        loaderBg: 'white',
                                        hideAfter: 5000
                                    });
                                </script>

                            <?php
                            } else {
                            ?>
                                <script type="text/javascript">
                                    $.toast({
                                        heading: 'Erro',
                                        text: "Email não enviado!",
                                        textColor: 'white',
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
                        } catch (Exception $e) {
                            echo "Erro ao enviar mensagem pro email: {$mail->ErrorInfo}";
                        }
                    } else {
                        ?>
                        <script type="text/javascript">
                            $.toast({
                                heading: 'Erro',
                                text: "Email não existe!",
                                textColor: 'white',
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
                        text: "Formato de email incorreto!",
                        textColor: 'white',
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
                    heading: 'Opa',
                    text: "Campo vazio!",
                    textColor: 'white',
                    showHideTransition: 'fade',
                    icon: 'warning',
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
        <script>
            window.location.replace("./");
        </script>
<?php
    }
}
?>

<div class="main">

</div>