<?php
session_start();

$tempoTot = 0;
$horaPed;
$a = [];

if(isset($_COOKIE['pdvx'])){

    $cod_id = $_COOKIE['pdvx'];


} else {

    header("location: sair.php");

}



include_once('../../funcoes/Conexao.php');

include_once('../../funcoes/Key.php');





if(isset($_GET["confirmar"]))  {

    $setor = $_GET['setor'];

    //$update = $connect->query("UPDATE pedidos SET status='7' WHERE id='".$_GET["confirmar"]."'");


    // Update itens da tela
    $update = $connect->query ("update store set status = '7' where idsecao ='".$_GET["confirmar"]."' and produto_id in (select id from produtos where setor_id = $setor) ");

    // Se tds os itens estiverem ok, update pedidos
    $update = $connect->query ("UPDATE pedidos SET status='7' WHERE idpedido='".$_GET["confirmar"]."' and ((select count(*) from store where  idsecao = '".$_GET["confirmar"]."' and status = '7') = (select count(*) from store where  idsecao = '".$_GET["confirmar"]."'))");


    header("location: painel.php");

}



//$setor = $_COOKIE["setorx"];

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozinha - Produção</title>
    <link rel="stylesheet" href="../styles/painel-cozinha.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/colors.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->
</head>
<body class="painel-cozinha">

<header>
    <div class="background">
        <div class="container-logo">
            <img src='../assets/Logo.png' alt='LogoQRCode' />
            <h1><?print($_SESSION["setor_desc"]);?></h1>
        </div>
        <div class="container-exit-app">
            <a href="index.php">
                <i class="large material-icons">exit_to_app</i>
                <h2>Sair</h2>
            </a>
        </div>
    </div>
</header>

<section >
    <div class="container-one" >

        <?php

        $dia 	 = date("d-m-Y");

        $setor = $_SESSION['setor'];

        $pedidoss = $connect->query("SELECT p.* FROM pedidos p, store s, produtos p2 WHERE p.idu='".$cod_id."' and p.idpedido = s.idsecao and s.produto_id = p2.id  AND p.data = '".$dia."' AND p.status='2' and s.status <> '7' and p2.setor_id=$setor GROUP by p.idpedido ORDER BY p.id ASC");

        $z = 0;



        while ($pedidossx = $pedidoss->fetch(PDO::FETCH_OBJ)) {


            $tempoTot = 0;
            $horaPed = $pedidossx->hora;


            ?>



            <!--  -->

            <div  class="card">

                <h1><?=$pedidossx->idpedido;?></h1>

                <ul>
                    <?php

                    $setor = $_SESSION['setor'];




                    $produtoscaxy = $connect->query("SELECT * FROM store, produtos WHERE idsecao = '$pedidossx->idpedido' AND produtos.setor_id=$setor and store.status = '1' and produtos.id = store.produto_id ORDER BY store.id ASC");




                    while ($carpro2 = $produtoscaxy->fetch(PDO::FETCH_OBJ)) {

                        $nomepro2  = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro2->produto_id."' and setor_id=".$_SESSION["setor"]);

                        $nomeprox2 = $nomepro2->fetch(PDO::FETCH_OBJ);

                        $tempo  = $connect->query("SELECT tempo_padrao FROM produtos WHERE id = '".$carpro2->produto_id."' and setor_id=".$_SESSION["setor"]);

                        $tempo2 = $tempo->fetch(PDO::FETCH_OBJ);

                        $tempoTot = $tempoTot + $tempo2->tempo_padrao;


                        $a[$z]['tagHtml'] = $pedidossx->idpedido;
                        $a[$z]['tempTot'] = $tempoTot;

                        ?>

                        <!--Início do item-->

                        <li><?php print $nomeprox2->nome;?></li>

                        <address>
                            <!--Verifica se tem tamanho-->

                            <?php if($carpro2->tamanho != "N" ) { ?>
                            <p>Tamanho: <span><?php print $carpro2->tamanho;?></span><p>
                                <?php } ?>

                            <p><span >Qnt: <?php print $carpro2->quantidade; ?></span></p>

                            <?php if($carpro2->obs) {?>

                                <p><span>Obs:<?php echo $carpro2->obs; ?></span></p>

                            <?php } else { ?>

                                <p><span>Obs: Não</span></p>

                            <?php } ?>

                            <?php

                            $meiom2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='1'");

                            $meiomc2 = $meiom2->rowCount();

                            ?>

                            <?php if($meiomc2>0){ ?>

                                <p><span>* <?=$meiomc2;?> Sabores:</span></p>

                                <p>
                                <span>

                                <?php while ($meiomv2 = $meiom2->fetch(PDO::FETCH_OBJ)) { ?>

                                    <?=$meiomv2->nome."<br>";?>

                                <?php } ?>

                                </span>
                                </p>

                            <?php } ?>

                            <?php

                            $adcionais2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='0'");

                            $adcionaisc2 = $adcionais2->rowCount();
                            ?>

                            <?php if($adcionaisc2>0){ ?>

                                <span><b>* Adicionais/Ingredientes:</b></span><br />

                                <p>
                                    <span>

                                    <?php while ($adcionaisv2 = $adcionais2->fetch(PDO::FETCH_OBJ)) { ?>

                                        <?="-  R$: ".$adcionaisv2->valor." | ".$adcionaisv2->nome."<br>";?>

                                    <?php } ?>

                                    </span>
                                </p>

                            <?php } ?>
                        </address>

                    <?}?> <!--Fim do item-->

                </ul>

                <?php

                $hora = '10:00:00';
                $dataped = date('d- M -Y',time());
                $temp_seconds = "$tempoTot minute";

                $hped = date('H', strtotime($horaPed));
                $mped = date('i', strtotime($horaPed));

                $ha = date('H', time());
                $ma = date('i', time());

                $temp_espera = ($ha - $hped)*60 + ($ma - $mped);

                $a[$z]['temp_espera'] = $temp_espera;

                ?>

                <address>
                    <p>Hora do pedido: <span><?=$pedidossx->hora;?></span></p>
                    <p>Tempo de espera: <span id="a<?php echo $a[$z]['tagHtml'];?>timer2"></span></p>
                    <p>Tempo limite padrão: <span> <?print  date('i:s', strtotime($temp_seconds, strtotime(time())));?></span></p>
                </address>


                <h2>Prazo <div style="display :inline" id="a<?php echo $a[$z]['tagHtml'];?>timer"></div></h2>

                <a href="painel.php?confirmar=<?=$pedidossx->idpedido;?>&setor=<?print $setor;?>"><button>Confirmar pedido</button></a>


            </div> <!--Fim Card-->
            <?php $z++; ?>

        <?php } ?>


    </div>


</section>



<footer >

    <div class="container-button-group">
        <button class="production gradient">
            Em produção
        </button>
        <a  href="finalized.php">
            <button class="finalized green-disabled" >

                Finalizados

            </button>
        </a>
    </div>


    <div class="container-infos-group">
        <p>
            Dia: <span>DD/MM/YYYY</span>
        </p>

        <p>
            Hora: <span>HH:MM</span>
        </p>
    </div>

</footer>

</body>
<script type="text/javascript">

    setTimeout(function() {

        //window.location.reload(1);

    }, 15000);

    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10)<0?parseInt(timer % 60*-1, 10):parseInt(timer % 60, 10);
            minutes = minutes < 10 ? minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;


            display.textContent = minutes + ":" + seconds;

            --timer;

        }, 1000);
    }
    window.onload = function () {

        <?for ($b=0; $b<sizeof($a); $b++){?>

        var duration ;
        var duration2;

        duration = 60 * <?php echo $a[$b]['tempTot'] - $a[$b]['temp_espera']?>; // Converter para segundos
        display = document.querySelector('#a<?echo $a[$b]['tagHtml'];?>timer'); // selecionando o timer
        startTimer((duration), display); // iniciando o timer

        duration2 = 60 * <?php echo $a[$b]['temp_espera'];?>; // Converter para segundos
        display = document.querySelector('#a<?echo $a[$b]['tagHtml'];?>timer2'); // selecionando o timer
        sTimer(duration2, display); // iniciando o timer


        <?}?>

    };

    function sTimer(duration, display) {
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = minutes + ":" + seconds;
            if (++timer < 0) {
                timer = duration;
            }
        }, 1000);
    }



</script>

</html>