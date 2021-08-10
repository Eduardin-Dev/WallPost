<?php
date_default_timezone_set('America/Sao_Paulo');
function get_header($cssCaminho = '', $jsCaminho = '', $title = '')
{
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//db.onlinewebfonts.com/c/65482afbeb61af43c403d0fec1fdb679?family=Neo+Sans+Pro" rel="stylesheet" type="text/css" />

        <?php
        if (!empty(trim($cssCaminho))) {
            echo "<link rel='stylesheet' href='$cssCaminho'>";
        }
        ?>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>


        <script src="js/scripts.js"></script>

        <?php
        //Aqui vai o JS personalizado sugerido pela cópia da ideia da CAROL
        if (!empty(trim($jsCaminho))) {
            echo "<script src='$jsCaminho'></script>";
        }
        ?>


        <title>
            <?php
            //Aqui vai o Título  personalizado sugerido pela cópia da ideia da CAROL
            if (!empty(trim($title))) {
                echo "$title";
            }
            ?>
        </title>

    </head>

    <body>

    <?php
}