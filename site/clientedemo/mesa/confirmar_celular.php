<?php

include_once('header.php');
require_once('/site/Class/Sms.php')
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>"/>

        <title><?php print $dadosempresa->nomeempresa; ?> - Envio de SMS</title>
        <link rel="stylesheet" href="../styles/send-sms.css">
        <link rel="stylesheet" href="../styles/global.css">
        <link rel="stylesheet" href="../styles/colors.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
              rel="stylesheet">

        <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->
    </head>

    <body class="command-sms" >

    <header>
        <div class="background">
            <div class="container-logo">
                <img src='../assets/Logo.png' alt='LogoQRCode'/>
                <h1>Abrir comanda</h1>
                <p>Mesa nº <span><?php print $_COOKIE['mesaM']; ?></span></p>
            </div>
        </div>
    </header>

    <section>
        <form>
            <h1>
                Enviamos uma confirmação via SMS
            </h1>


            <div class="sms-code">
                <input type="text" placeholder="•" maxlength="1" minlength="1"/>

                <input type="text" placeholder="•" maxlength="1" minlength="1"/>

                <input type="text" placeholder="•" maxlength="1" minlength="1"/>

                <input type="text" placeholder="•" maxlength="1" minlength="1"/>
            </div>


            <span>Não recebi o código</span>


            <button>
                <a href="menu.php">
                    Abrir comanda
                </a>
            </button>

        </form>


    </section>


    <script src="../lib/jquery/js/jquery.js"></script>


    <script src="../lib/bootstrap/js/bootstrap.js"></script>

    <script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>


    </body>
    </html>

<?php

ob_end_flush();

?>