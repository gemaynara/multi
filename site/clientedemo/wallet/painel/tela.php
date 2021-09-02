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



	include_once('../../../funcoes/Conexao.php');

	include_once('../../../funcoes/Key.php');





	if(isset($_GET["confirmar"]))  {

	$update = $connect->query("UPDATE carros SET status='3' WHERE id='".$_GET["confirmar"]."'");

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

    <title>Wallet</title>

    <link href="../../lib/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../lib/Ionicons/css/ionicons.css" rel="stylesheet">

	<link href="../../lib/datatables/css/jquery.dataTables.css" rel="stylesheet">

    <link href="../../lib/select2/css/select2.min.css" rel="stylesheet">

	<link href="../../lib/SpinKit/css/spinkit.css" rel="stylesheet">

    <link rel="stylesheet" href="../../css/slim.css">

  </head>

  <body>

    

	<div class="slim-navbar">

      <div class="container">

        <ul class="nav">

		  <li class="nav-item">

            <a class="nav-link" href="#">

              <i class="icon ion-ios-home-outline"></i>

              <span>Wallet - Solicitação</span>

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
				

	
					$pedidoss = $connect->query("SELECT carros.* FROM carros, wallet WHERE idu=".$cod_id." and carros.status = 2 and carros.wallet = wallet.id");

					
				
					
					

					while ($pedidossx = $pedidoss->fetch(PDO::FETCH_OBJ)) {
					
						
				?>

				

				<div class="col-lg-4 mg-b-20">

					<div class="card card-info" style="background-color:#fdfbe3">

						<div class="card-body pd-40">

						    

						  <div class="row">

						      

						       <div class="col-md-12" align="left">

								    <center><span class="tx-18" style="color:#00CC00"><b>Carro</b></span></center>

								    <center><span class="tx-13"><?=$pedidossx->id;?></span></center>

	 

								</div>

								

								<div class="col-md-12" align="left">

                                    <span class="tx-12"><b>Cliente: </b><?=$pedidossx->nome;?></span><br />

	                                <span class="tx-12"><b>placa: </b><?=$pedidossx->placa;?></span><br />


									<span class="tx-12"><b>marca: </b><?=$pedidossx->marca;?></span><br />

	                                <span class="tx-12"><b>modelo: </b><?=$pedidossx->modelo;?></span><br />

								</div>



								
								

								<div class="col-md-12" align="left">



	                                <a href="tela.php?confirmar=<?=$pedidossx->id;?>"><button class="btn btn-success btn-block mg-t-10"> CONFIRMAR</button></a>

									 

								</div> 

						        <hr />	
						
						        

						  </div>
						  </div>
						  </div>


							

							

						

						</div>

							

							



				<?php } ?>

	
		


		</div>

		

									

								


	  

      </div><!-- container -->

    </div><!-- slim-mainpanel -->

	

	 



    <script src="../../lib/jquery/js/jquery.js"></script>

     <script src="../../lib/datatables/js/jquery.dataTables.js"></script>

    <script src="../../lib/datatables-responsive/js/dataTables.responsive.js"></script>

    <script src="../../lib/select2/js/select2.min.js"></script>

    

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

 



</script>	



  </body>

</html>