<?php
include_once('header.php');

if (isset($somando->soma)) {
    echo number_format($somando->soma, 2, ',', ' ');
} else {
    print "0,00";
}


$opcionais = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '" . $id_mesa . "' AND idu='$idu' AND meioameio='0'");

$sumx = 0;

while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {

    $quantop = $valork->quantidade;

    $valorop = $valork->valor;

    $totais = $valorop * $quantop;

    $sumx += $totais;

}

echo $opctg = number_format($sumx, 2, ',', ' ');


if (isset($somando->soma)) {
    $geral = $somando->soma + $sumx;
    echo $gx = number_format($geral, 2, ',', '.');
} else {
    print "0,00";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>"/>

    <title><?php print $dadosempresa->nomeempresa; ?> - Forma de Pagamento </title>
    <link rel="stylesheet" href="../styles/payment-type.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/colors.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">

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

    <form action="" method="post">
        <label for="credit-card">
            <div class="payment-box">
                <img src='../assets/icons/credit-card.png' alt=''/>

                <div class="description">
                    <p>Cartão de crédito</p>
                    <span>visa, mastercard, paypal</span>
                </div>

                <input type="radio" name='payment-method' value="credit-card" id="credit-card"/>


            </div>
        </label>


        <label for="debit-card">
            <div class="payment-box">
                <img src='../assets/icons/debit-card.png' alt=''/>

                <div class="description">
                    <p>Cartão de débito</p>
                    <span>visa, mastercard, paypal</span>
                </div>

                <input type="radio" name='payment-method' value="debit-card" id='debit-card'/>


            </div>
        </label>


        <label for="money">
            <div class="payment-box">
                <img src='../assets/icons/money.png' alt=''/>

                <div class="description">
                    <p>Dinheiro</p>
                </div>

                <input type="radio" name='payment-method' value="money" id='money'/>


            </div>
        </label>

        <label for="money-and-card">
            <div class="payment-box">
                <img src='../assets/icons/credit-and-money.png' alt=''/>

                <div class="description">
                    <p>Cartão + Dinheiro</p>
                    <span>visa, mastercard, paypal</span>
                </div>

                <input type="radio" name='payment-method' value="money-and-card" id='money-and-card'/>


            </div>
        </label>


        <button type="submit">
            <input type="hidden" name="pagamento" class="form-control">
            <input type="hidden" name="valor_total" class="form-control" value="<?= $geral; ?>">
            <a>
                Prosseguir Pagamento
            </a>
        </button>
    </form>

</section>


</body>

</html>
