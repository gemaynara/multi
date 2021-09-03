<?php
require 'C:\laragon\www\demo\vendor\autoload.php';
use Twilio\Rest\Client;

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';

$data['email'] = 'geannemaynaraas@outlook.com';
$data['token'] = '7D664B993221472EB13860268584C5D9';
$data['currency'] = 'BRL';
$data['itemId1'] = '1';
$data['itemDescription1'] = tirarAcentos("Produto teste");
$data['itemAmount1'] = number_format(20,2,'.','');;
$data['itemQuantity1'] = 1;
$data['itemWeight1'] = 0;
$data['reference'] = 'id_pagseguro'; //aqui vai o código que será usado para receber os retornos das notificações
$data['senderName'] = tirarAcentos("Geanne");
$data['senderEmail'] = "gmaynara@gmailcom";
$data['redirectURL'] = 'http://localhost:8000/site/clientedemo/mesa/confirmar_celular.php';
$data['notificationURL'] = 'https://ingressoevento.com.br/admin/dist/funcoes/f38a_notificacaoPagto.php';

$data = http_build_query($data);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$xml= curl_exec($curl);


if($xml == 'Unauthorized'){
    echo "Unauthorized";
    exit();
}

curl_close($curl);

$xml= simplexml_load_string($xml);

if(count($xml->error) > 0){
    echo "XML ERRO";
    exit();
}

$cod =$xml->code;

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}


?>