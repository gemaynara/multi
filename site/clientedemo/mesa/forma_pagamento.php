<?php
include_once('header.php');
include_once("../mesa/pag/configuracoes.php");

if (isset($somando->soma)) {
    echo number_format($somando->soma, 2, ',', ' ');
} else {
    print "0,00";
}


$opcionais = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '" . $id_mesa . "' and idu = '$idu' and meioameio = '0'");

$sumx = 0;

while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {

    $quantop = $valork->quantidade;

    $valorop = $valork->valor;

    $totais = $valorop * $quantop;

    $sumx += $totais;

}
$id_transacao = md5(time());


echo $opctg = number_format($sumx, 2, ',', ' ');


if (isset($somando->soma)) {
    $geral = $somando->soma + $sumx;
    echo $gx = number_format($geral, 2);
} else {
    print "0,00";
}
?>

<!DOCTYPE html>
<html lang="pt - br">

<head>
    <meta charset="UTF - 8">
    <meta name="viewport" content="width = device - width, initial - scale = 1.0">
    <link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>"/>

    <title><?php print $dadosempresa->nomeempresa; ?> - Forma de Pagamento </title>
    <link rel="stylesheet" href="../styles/payment-type.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/colors.css">

    <link rel="stylesheet" href="../mesa/pag/css/checkout.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../mesa/pag/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <script src="../mesa/pag/js/jquery.min.js"></script>
    <script src="../mesa/pag/js/bootstrap.bundle.min.js"></script>
    <script src="../mesa/pag/js/blockui.min.js"></script>
    <script type="text/javascript" src="../mesa/pag/js/sweet_alert.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        pre{
            display: none;
        }
    </style>

    <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->
</head>

<body class="payment-type">

<header>
    <div class="background">
        <div class="arrow-back">
            <img src="../assets/icons/arrow-white.png"/>
        </div>
        <div class="container-info-client">
            <img src="../assets/Logo.png"/>
            <h1>Formas de pagamento</h1>
        </div>
    </div>
</header>

<section>

    <!--    <span>Divisão por Nº de pessoas: </span>-->

    <div class="header-total">

        <div class="number-division">

            <!--            <img src="../assets/icons/left-black.png" atl='seta para diminuir preta'/>-->
            <!--            <label>-->
            <!--                1-->
            <!--            </label>-->
            <!--            <img src="../assets/icons/right-black.png" atl='seta para aumentar preta'/>-->

        </div>


        <h1>
            Total: <p>R$ <?= $gx ?>
            </p>
        </h1>

    </div>

    <div class="page-content">
        <div class="content-wrapper">
            <div class="content d-flex justify-content-center align-items-center">
                <form id="form_login" name="form_login" class="checkout-form" action="" autocomplete="off"
                      enctype="application/x-www-form-urlencoded" method="post" onsubmit="return false;">

                    <div class="card mb-0 shadow-0 mt-3 card_sucesso hidden">
                        <div class="card-body card_sucesso_txt">
                            Pagamento concluído com sucesso.
                        </div>
                    </div>
                    <div class="card mb-0 shadow-0 mt-3 card_pagamento">
                        <div class="card-heading">
                            <ul class="nav nav-tabs nav-justified nav-tabs-solid border-0 shadow-0 tabs_checkout">
                                <li class="nav-item"><a id="tab_cartao" href="#tab-cartao"
                                                        class="nav-link text-size-large tab_checkout pt-2 pb-2 active show"
                                                        data-toggle="tab">CRÉDITO</a></li>
                            </ul>
                        </div>
                        <hr>
                        <div class="card-body">

                            <div class="tab-content">

                                <div class="tab-pane active show" id="tab-cartao">

                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" id="cartao_nome"
                                                       placeholder="Nome do titular" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <input class="form-control" id="cartao_celular"
                                                       placeholder="Celular do titular" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-3 col-8">
                                            <div class="form-group">
                                                <input class="form-control" id="cartao_cpf" placeholder="CPF do titular"
                                                       type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-3 col-4">
                                            <div class="form-group">
                                                <input class="form-control" id="cartao_data_nascimento"
                                                       placeholder="Nascimento" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-md-7 col-sm-7 col-6">
                                            <div class="form-group">
                                                <input autocomplete="off" class="form-control" id="cartao_numero"
                                                       placeholder="Número do Cartão" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-3 col-sm-3 col-3">
                                            <div class="form-group">
                                                <input autocomplete="off" class="form-control" id="cartao_validade"
                                                       placeholder="Validade" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-2 col-3">
                                            <div class="form-group">
                                                <input autocomplete="off" class="form-control" id="cartao_cvv"
                                                       placeholder="CVV" type="text" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="cartao_bandeira" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input value="1" id="cartao_parcelas" type="hidden"
                                                       class="form-control hidden">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="id_transacao" value="
                            <?php echo $id_transacao; ?>"/>
                            <input type="hidden" id="total" value="<?php echo $gx; ?>"/>
                            <input type="hidden" id="descricao" value="Aqui vai a descrição do item comprado."/>
                            <input type="hidden" id="forma_de_pagamento" value="Cartão"/>
                            <input type="hidden" id="banco" value="bancodobrasil"/>
                            <button type="submit" id="botao_pagar" class="btn bg-green btn-block"><span>Pagar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
<script type="text/javascript" src="<?php echo $pagseguro_url_js; ?>"></script>
<script type="text/javascript" src="../mesa/pag/js/numeral.min.js"></script>
<script type="text/javascript" src="../mesa/pag/js/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="../mesa/pag/js/pagseguro.js"></script>

</body>

</html>
