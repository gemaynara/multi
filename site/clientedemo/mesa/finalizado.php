<?php////include_once('topo.php');////?>    <!DOCTYPE html>    <html lang="pt-br">    <head>        <meta charset="UTF-8">        <meta http-equiv="X-UA-Compatible" content="IE=edge">        <meta name="viewport" content="width=device-width, initial-scale=1.0">        <title>Pedido Finalizado</title>        <link rel="stylesheet" href="../styles/success-payment.css">        <link rel="stylesheet" href="../styles/global.css">        <link rel="stylesheet" href="../styles/colors.css">        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"              rel="stylesheet">        <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->    </head>    <body class="success-payment">    <header>        <form action="" method="post">            <input type="hidden" name="mesainicial" value="ok">            <div class="background">                <div class="arrow-back"><!--                    <a href="">--><!--                        <img src="../assets/icons/arrow-white.png"/>--><!--                    </a>-->                </div>                <div class="container-logo">                    <img src='../assets/Logo.png' alt='LogoQRCode'/>                </div>            </div>    </header>    <section>        <div>            <img src="../assets/icons/checked.png"/>            <h1>                AGRADECEMOS SUA PREFERÊNCIA<br>            </h1>            <h2>SEU PEDIDO FOI FINALIZADO.</h2>        </div>        <!--        <span>Download não iniciou? Clique aqui</span>-->    </section>    <script src="../lib/jquery/js/jquery.js"></script>    <script src="../lib/bootstrap/js/bootstrap.js"></script>    <script language="JavaScript">        window.onload = function () {            document.addEventListener("contextmenu", function (e) {                e.preventDefault();            }, false);            document.addEventListener("keydown", function (e) {                //document.onkeydown = function(e) {                // "I" key                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {                    disabledEvent(e);                }                // "J" key                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {                    disabledEvent(e);                }                // "S" key + macOS                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {                    disabledEvent(e);                }                // "U" key                if (e.ctrlKey && e.keyCode == 85) {                    disabledEvent(e);                }                // "F12" key                if (event.keyCode == 123) {                    disabledEvent(e);                }            }, false);            function disabledEvent(e) {                if (e.stopPropagation) {                    e.stopPropagation();                } else if (window.event) {                    window.event.cancelBubble = true;                }                e.preventDefault();                return false;            }        };    </script>    </body>    </html><?phpob_end_flush();?>