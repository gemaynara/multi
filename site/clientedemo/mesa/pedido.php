<?php

include_once('header.php');


$opcionais = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '" . $id_mesa . "' AND status = '0' AND idu='$idu' AND meioameio='0'");

$sumx = 0;

while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {

    $quantop = $valork->quantidade;

    $valorop = $valork->valor;

    $totais = $valorop * $quantop;

    $sumx += $totais;

}


?>

    <!DOCTYPE html>

    <html lang="pt-br">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>"/>


        <title><?php print $dadosempresa->nomeempresa; ?> - Cardápio de pedidos Online via Whatsapp</title>


        <link rel="stylesheet" href="../styles/my-account.css">
        <link rel="stylesheet" href="../styles/global.css">
        <link rel="stylesheet" href="../styles/colors.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
              rel="stylesheet">


        <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

        <link href="../lib/SpinKit/css/spinkit.css" rel="stylesheet">

        <link rel="stylesheet" href="../css/slim.css">

    </head>

    <body class="my-account">

    <header>
        <div class="background">
            <div class="arrow-back">
                <img src="../assets/icons/arrow-white.png"/>
            </div>
            <div class="container-info-client">
                <img src="../assets/Logo.png"/>
                <h1>Minha conta</h1>
            </div>
        </div>
    </header>

    <section>


        <h1>
            Meu pedidos
        </h1>

        <div class="list-itens">

            <?php

            while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) {


                $nomepro = $connect->query("SELECT nome FROM produtos WHERE id = '" . $carpro->produto_id . "' AND idu='$idu' ");

                $nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);

                ?>

                <div>
                    <p><?php print $carpro->quantidade; ?> x <?php print $nomeprox->nome; ?>
                        <?php echo "<strong >R$: " . $carpro->valor . " un. </strong >"; ?>
                    </p>
                </div>

            <?php } ?>


            <div class="value-total">

                <label>Total: <strong>R$ <?php if (isset($somando->soma)) {
                            $geral = $somando->soma + $sumx;
                            echo $gx = number_format($geral, 2, ',', '.');
                        } else {
                            print "0,00";
                        } ?></strong></label>

            </div>

            <form action="" method="post">
                <input type="hidden" name="mesapedido" value="ok">

                <input type="hidden" name="idloja" value="<?= $id_mesa; ?>">

                <input type="hidden" name="pnome" value="<?php print $_COOKIE['nomeM']; ?>">

                <input type="hidden" name="mesa" value="<?php print $_COOKIE['mesaM']; ?>">

                <input type="hidden" name="placa" value="<?php print $_COOKIE['placaM']; ?>">

                <input type="hidden" name="ppessoas" value="<?php print $_COOKIE['pessoasM']; ?>">

                <input type="hidden" name="pcelular" value="<?php print $_COOKIE['celularM']; ?>">

                <input type="hidden" name="subtotal" class="form-control" value="<?= $somando->soma; ?>">

                <input type="hidden" name="adcionais" class="form-control" value="<?= $sumx; ?>">

                <input type="hidden" name="totalg" class="form-control" value="<?= $geral; ?>">


                <button type="submit" class="btn btn-success btn-block mg-b-10"> Ir Para Pagamento</button>
                <!--                <button type="submit" class="btn btn-success btn-block mg-b-10"> Encerrar Conta</button>-->

            </form>


    </section>

    <!--    --><?php //require '../include/fundo.php'; ?>


    <script src="../lib/jquery/js/jquery.js"></script>


    <script src="../lib/bootstrap/js/bootstrap.js"></script>

    <script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>

    <script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>

    <script src="../js/moeda.js"></script>

    <script>

        $(function () {

            'use strict';


            // Input Masks

            $('#cel').mask('(99)99999-9999');


            // Input Masks

            $('#numb').mask('9999');


        });

    </script>

    <script>

        function verifica(value) {

            var input = document.getElementById("troco");


            if (value == 'DINHEIRO') {

                input.disabled = false;

            } else if (value == 'CARTAO') {

                input.disabled = true;

            }

        };

    </script>

    <script>

        $(document).on('click', '.number-spinner button', function () {

            var btn = $(this),

                oldValue = btn.closest('.number-spinner').find('input').val().trim(),

                newVal = 0;


            if (btn.attr('data-dir') == 'up') {

                newVal = parseInt(oldValue) + 1;

            } else {

                if (oldValue > 1) {

                    newVal = parseInt(oldValue) - 1;

                } else {

                    newVal = 1;

                }

            }

            btn.closest('.number-spinner').find('input').val(newVal);

        });

    </script>

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

    <script>

        $(document).ready(function () {

            $(window).scroll(function () {

                if ($(this).scrollTop() > 100) {

                    $('a[href="#top"]').fadeIn();

                } else {

                    $('a[href="#top"]').fadeOut();

                }

            });


            $('a[href="#top"]').click(function () {

                $('html, body').animate({scrollTop: 0}, 800);

                return false;

            });

        });

    </script>

    <script>


        $(document).ready(function () {

            $(document).on('click', '.view_data', function () {

                var user_id = $(this).attr("id");

                //alert(user_id);

                //Verificar se há valor na variável "user_id".

                if (user_id !== '') {

                    var dados = {

                        user_id: user_id

                    };

                    $.post('ajax/produtom.php', dados, function (retorna) {

                        //Carregar o conteúdo para o usuário

                        $("#visul_usuario").html(retorna);

                        $('#visulUsuarioModal').modal('show');

                    });

                }

            });

        });


    </script>

    <script>

        $('.dinheiro').mask('#.##0,00', {reverse: true});

    </script>

    <script>

        $('#select-taxa').change(function () {

            window.location = $(this).val();

        });

    </script>

    </body>

    </html>

<?php

ob_end_flush();

?>