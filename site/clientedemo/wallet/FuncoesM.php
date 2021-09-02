<?php



$empresa 		= $connect->query("SELECT * FROM config WHERE url='$xurl'"); 

$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);

$idu 			= $dadosempresa->id;

$bloc 			= $dadosempresa->status;



date_default_timezone_set( ''.$dadosempresa->fuso.'' );



$dataatual  	=   date('w');

$horaatual  	=   date('H:i:s');



$logo 			= $connect->query("SELECT foto FROM logo WHERE idu='$idu' ORDER BY id DESC LIMIT 1"); 

$dadoslogo 		= $logo->fetch(PDO::FETCH_OBJ);



$fundo 			= $connect->query("SELECT * FROM fundotopo WHERE idu='$idu' ORDER BY id DESC LIMIT 1"); 

$dadosfundo 	= $fundo->fetch(PDO::FETCH_OBJ);


//



if($produtoscx>0){

$somando 	= $connect->query("SELECT valor, SUM(valor * quantidade) AS soma FROM store WHERE idsecao='".$id_mesa."' and idu='$idu'");

$somando 	= $somando->fetch(PDO::FETCH_OBJ);

$somandop 	= $connect->query("SELECT quantidade, SUM(quantidade) AS somap FROM store WHERE idsecao='".$id_mesa."' and idu='$idu'");

$somandop 	= $somandop->fetch(PDO::FETCH_OBJ);

}



//



if(isset($_GET["apagaritem"])){

$idel = $_GET['apagaritem'];

$delitem = $connect->query("DELETE FROM store WHERE idpedido='$idel'");

$delopci = $connect->query("DELETE FROM store_o WHERE idp='$idel'");

if ( $delitem ) {

header("location: pedido.php&retirado=ok"); 

exit;

}

}



//

 

if(isset($_POST["Cadwallet"])){



$wallet  = $_POST['wallet'];

$nome 	 = $_POST['nome'];

$placa 	= $_POST['placa'];

$marca 	= $_POST['marca'];

$modelo 	= $_POST['modelo'];


$inst = $connect->query("INSERT INTO carros (wallet, nome, placa, `timestamp`, marca, modelo, status) VALUES ('$wallet','$nome','$placa',current_timestamp(),'$marca','$modelo','1')");


header("location: index.php?idwallet=$wallet"); 


}









if(isset($_POST["mesapedido"])){



$data		= date("d-m-Y");

$hora		= date("H:i:s");



$idloja		= $_POST['idloja'];

$pnome 		= $_POST['pnome'];

$mesa 		= $_POST['mesa'];

$ppessoas 	= $_POST['ppessoas'];

$pcelular 	= $_POST['pcelular'];



$subtotalx 	= $_POST['subtotal'];

$adcionaisx 	= $_POST['adcionais'];

$totalgx 	= $_POST['totalg'];



$inst = $connect->query("INSERT INTO pedidos(idu, idpedido, fpagamento, cidade, numero, complemento, rua, bairro, troco, nome, data, hora, celular, taxa, mesa, pessoas, obs, vsubtotal, vadcionais, vtotal) VALUES ('$idu','$idloja','MESA','0','0','0','0','0','0.00','$pnome','$data','$hora','$pcelular','0','$mesa','$ppessoas','N','$subtotalx','$adcionaisx','$totalgx')");



$update = $connect->query("UPDATE store SET status='1' WHERE idsecao='$idloja'");

$update = $connect->query("UPDATE store_o SET status='1' WHERE ids='$idloja'");



header("location: acompanhar_pedido.php"); 



}

