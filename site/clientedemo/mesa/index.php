<?php

include_once('header.php');

if ($produtoscx > 0) {
    header("location: acompanhar_pedido.php");
    exit;
}
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>"/>

        <title><?php print $dadosempresa->nomeempresa; ?> - Cardápio de pedidos Online via Whatsapp</title>
        <link rel="stylesheet" href="../styles/command.css">
        <link rel="stylesheet" href="../styles/global.css">
        <link rel="stylesheet" href="../styles/colors.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
              rel="stylesheet">

        <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->
    </head>
    <body class="command">

    <header>
        <div class="background">
            <div class="container-logo">
                <img src='../assets/Logo.png' alt='LogoQRCode'/>
                <h1>Abrir comanda</h1>
            </div>
        </div>
    </header>

    <section>
        <form action="" method="post">
            <input type="hidden" name="mesainicial" value="ok">
            <div class="container-main">
                <label>
                    Nº da Mesa
                    <?php if (isset($_GET["idmesa"])) { ?>
                        <input type="number" required max="3" min="2" <?= $_GET["idmesa"]; ?>/>
                        <input type="hidden" name="mesa" value="<?= $_GET["idmesa"]; ?>">

                    <?php } else {
                        header("location: erro.php");
                    } ?>


                </label>

                <label>
                    Qnt. de Pessoas
                    <input type="number" maxlength="2" minlength="1" name="pessoas" required/>

                </label>

            </div>

            <div class="container-input">
                <label>
                    Nome
                    <input type="text" placeholder="Inserir nome" name="nome" required/>

                </label>

                <label>
                    Celular
                    <input type="text" placeholder="(XX) XXXXX-XXXX" name="celular" required/>

                </label>

                <label class="checkbox">

                    <input type="checkbox"/>
                    Veiculo no estacionamento

                    <strong class="info">
                        <p>i</p>
                    </strong>

                </label>

                <div class="box-info">
                    <span>X</span>
                    <p>
                        Marque essa opção e selecione abaixo o
                        seu veículo para que ele seja vinculado à
                        essa comanda
                    </p>

                </div>

                <label>
                    Placa
                    <input type="text" placeholder="ABC-1234" name="placa" required/>

                </label>
            </div>

            <button>
                <a type="submit">
                    Prosseguir
                </a>
            </button>

        </form>


    </section>


    </body>


    <!--    --><?php //require '../include/fundo.php'; ?>

    <script src="../lib/jquery/js/jquery.js"></script>

    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script language="JavaScript">

        window.onload = function () {

            document.addEventListener("contextmenu", function (e) {

                e.preventDefault();

            }, false);

            document.addEventListener("keydown", function (e) {

                //document.onkeydown = function(e) {

                // "I" key

                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {

                    disabledEvent(e);

                }

                // "J" key

                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {

                    disabledEvent(e);

                }

                // "S" key + macOS

                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {

                    disabledEvent(e);

                }

                // "U" key

                if (e.ctrlKey && e.keyCode == 85) {

                    disabledEvent(e);

                }

                // "F12" key

                if (event.keyCode == 123) {

                    disabledEvent(e);

                }

            }, false);

            function disabledEvent(e) {

                if (e.stopPropagation) {

                    e.stopPropagation();

                } else if (window.event) {

                    window.event.cancelBubble = true;

                }

                e.preventDefault();

                return false;

            }

        };

    </script>

    </body>

    </html>

<?php

ob_end_flush();

?>