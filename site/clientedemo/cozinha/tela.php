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


	header("location: tela.php");  

	}



	$setor = $_COOKIE['setorx'];

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta name="author" content="ThemePixels">

    <title>RECEBIMENTO DE PEDIDOS</title>

    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

	<link href="../lib/datatables/css/jquery.dataTables.css" rel="stylesheet">

    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

	<link href="../lib/SpinKit/css/spinkit.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/slim.css">

  </head>

  <body>

    

	<div class="slim-navbar">

      <div class="container">

        <ul class="nav">

		  <li class="nav-item">

            <a class="nav-link" href="#">

              <i class="icon ion-ios-home-outline"></i>

              <span>RECEBIMENTO DE PEDIDOS</span>

            </a>

          </li>

		  <li class="nav-item">

            <a class="nav-link" href="#">

              <span>

                <div class="sk-wave">

                  <div class="sk-rect sk-rect1 bg-gray-800"></div>

                  <div class="sk-rect sk-rect2 bg-gray-800"></div>

                  <div class="sk-rect sk-rect3 bg-gray-800"></div>

                  <div class="sk-rect sk-rect4 bg-gray-800"></div>

                  <div class="sk-rect sk-rect5 bg-gray-800"></div>

                </div>

			  </span>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="sair.php">

              <i class="icon ion-ios-analytics-outline"></i>

              <span>SAIR</span>

            </a>

          </li>

        </ul>

      </div>

    </div>



    <div class="slim-mainpanel">

      <div class="container">

          
		<div class="row">
			<div class="col-12 text-center" style="padding-top: 1%;">
				<h2><?print($_SESSION["setor_desc"]);?></h2>
			</div>
		</div>
	 

          <div class="row row-sm mg-t-20">

           

				<?php
					
					$dia 	 = date("d-m-Y"); 

					$setor = $_SESSION['setor'];

					$pedidoss = $connect->query("SELECT p.* FROM pedidos p, store s, produtos p2 WHERE p.idu='".$cod_id."' and p.idpedido = s.idsecao and s.produto_id = p2.id  AND p.data = '".$dia."' AND p.status='2' and s.status <> '7' and p2.setor_id=$setor GROUP by p.idpedido ORDER BY p.id ASC");
					
					$z = 0;
					
					

					while ($pedidossx = $pedidoss->fetch(PDO::FETCH_OBJ)) {

						
						$tempoTot = 0;
						$horaPed = $pedidossx->hora;
					
						
				?>

				

				<div class="col-lg-4 mg-b-20">

					<div class="card card-info" style="background-color:#fdfbe3">

						<div class="card-body pd-40">

						    

						  <div class="row">

						      

						       <div class="col-md-12" align="left">

								    <center><span class="tx-18" style="color:#00CC00"><b>PEDIDO</b></span></center>

								    <center><span class="tx-13"><?=$pedidossx->idpedido;?></span></center>

	 

								</div>

								

								<div class="col-md-12" align="left">

                                    <span class="tx-12"><b>Cliente: </b><?=$pedidossx->nome;?></span><br />

	                                <span class="tx-12"><b>Celular: </b><?=$pedidossx->celular;?></span><br />

								</div>



								<div class="col-md-12" align="left">

								    <span class="tx-12"><?=$pedidossx->data;?></span><br />

	                                <span class="tx-12"><?=$pedidossx->hora;?></span><br />

									 

								</div> 

								

								<div class="col-md-12" align="left">



	                                <a href="tela.php?confirmar=<?=$pedidossx->idpedido;?>&setor=<?print $setor;?>"><button class="btn btn-success btn-block mg-t-10"> CONFIRMAR PREPARO</button></a>

									 

								</div> 

						        

						        

						  </div>

							

							

						<hr />	

							

							

							<div class="row">

								

								

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

				

								<div class="col-md-12" align="left">

									

	<span class="tx-14" style="color:#FF0000"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <b>Ítem:</b> <?php print $nomeprox2->nome;?></span><br />

	

	<?php if($carpro2->tamanho != "N" ) { ?>

	

	<span class="tx-12"><b>- Tamanho:</b> <?php print $carpro2->tamanho;?></span><br />

	

	<?php } ?>

	

	<span class="tx-12"><b>- Qnt:</b> <?php print $carpro2->quantidade; ?></span><br />

	

	

	<?php if($carpro2->obs) {?>

	<span class="tx-12"><b>- Obs:</b> <?php echo $carpro2->obs; ?></span><br />

	<?php } else { ?>

	<span class="tx-12"><b>- Obs:</b> Não</span><br />

	

	<?php } ?>

	

	<?php

		$meiom2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='1'"); 

		$meiomc2 = $meiom2->rowCount();

	?>

	

	<?php if($meiomc2>0){ ?>

	<span class="tx-12"><b>* <?=$meiomc2;?> Sabores:</b></span><br />

	<span class="tx-12">

	<?php while ($meiomv2 = $meiom2->fetch(PDO::FETCH_OBJ)) { ?>

	<?=$meiomv2->nome."<br>";?>

	<?php } ?>

	</span>

	<?php } ?>

	

	<?php

		$adcionais2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='0'"); 

		$adcionaisc2 = $adcionais2->rowCount();

	?>

	

	<?php if($adcionaisc2>0){ ?>

	<span class="tx-12"><b>* Adicionais/Ingredientes:</b></span><br />

    <span class="tx-12">

	<?php while ($adcionaisv2 = $adcionais2->fetch(PDO::FETCH_OBJ)) { ?>

	<?="-  R$: ".$adcionaisv2->valor." | ".$adcionaisv2->nome."<br>";?>

	<?php } ?>

	</span><br />



	<?php } ?>

	
	
	

	

		<br />

		<br />

	</div>
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

		

		


		// Soma 30 Minutos

	
		//echo date('i:s', strtotime($temp_seconds, strtotime(time())));
		 	
	?>
	
	<span class="tx-12"><b>* Tempo Total (em minutos):</b> <?print  date('i:s', strtotime($temp_seconds, strtotime(time())));?> </span><br />
	<span class="tx-12"><b>* Prazo (em minutos):</b> <div style="display :inline" id="a<?php echo $a[$z]['tagHtml'];?>timer"></div> </span><br />
	<span class="tx-12"><b>* Tempo de Espera (em minutos):</b> <div style="display :inline" id="a<?php echo $a[$z]['tagHtml'];?>timer2"> </span><br />


	
		

							<?php $z++; } ?>			

									

								

							</div>

						</div>

					</div>

				</div>

				</div>
			
	<?php } ?>			

			 

		 	 	 

				

			</div>

	  



          

          

          

          

          

           

      </div><!-- container -->

    </div><!-- slim-mainpanel -->

	

	 



    <script src="../lib/jquery/js/jquery.js"></script>

     <script src="../lib/datatables/js/jquery.dataTables.js"></script>

    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>

    <script src="../lib/select2/js/select2.min.js"></script>

    

    <script>

      $(function(){

        'use strict';



        $('#datatable1').DataTable({

          responsive: true,

          language: {

            searchPlaceholder: 'Buscar...',

            sSearch: '',

            lengthMenu: '_MENU_ ítens',

          }

        });



        $('#datatable2').DataTable({

          bLengthChange: false,

          searching: false,

          responsive: true

        });



        // Select2

        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });



      });

    </script>

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



  </body>

</html>