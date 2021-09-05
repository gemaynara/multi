<?php


$empresa = $connect->query("SELECT * FROM config WHERE url='$xurl'");

$dadosempresa = $empresa->fetch(PDO::FETCH_OBJ);

$idu = $dadosempresa->id;

$bloc = $dadosempresa->status;


date_default_timezone_set('' . $dadosempresa->fuso . '');


$dataatual = date('w');

$horaatual = date('H:i:s');


$logo = $connect->query("SELECT foto FROM logo WHERE idu='$idu' ORDER BY id DESC LIMIT 1");

$dadoslogo = $logo->fetch(PDO::FETCH_OBJ);


$fundo = $connect->query("SELECT * FROM fundotopo WHERE idu='$idu' ORDER BY id DESC LIMIT 1");

$dadosfundo = $fundo->fetch(PDO::FETCH_OBJ);


$categorias = $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");

$maisPedidos = $connect->query("SELECT produtos.nome,produtos.valor,produtos.foto,produtos.id ,sum(store_o.quantidade) FROM marci487_ifoodcliente.store_o
INNER JOIN marci487_ifoodcliente.produtos ON produtos.idu = store_o.idu
GROUP BY nome");
$maisPedidos1 = $maisPedidos->fetchAll(PDO::FETCH_ASSOC);


$bebidas = $connect->query("SELECT * FROM marci487_ifoodcliente.produtos where categoria = 109");
$bebidasAll = $bebidas->fetchAll(PDO::FETCH_ASSOC);

$sobremesas = $connect->query("SELECT * FROM marci487_ifoodcliente.produtos where categoria = 108");
$sobremesasAll = $sobremesas->fetchAll(PDO::FETCH_ASSOC);

$pratoPricipal = $connect->query("SELECT * FROM marci487_ifoodcliente.produtos where categoria = 107");
$pratoPricipalAll = $pratoPricipal->fetchAll(PDO::FETCH_ASSOC);


$categoriasm = $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");


$categoriasd = $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");


$destaques = $connect->query("SELECT * FROM produtos WHERE destaques = '1' AND idu='$idu' AND (visivel='G' OR visivel='$dataatual') AND status='1' ORDER BY nome ASC");


$produtosca = $connect->query("SELECT * FROM store WHERE idsecao = '$id_mesa' AND idu='$idu' AND status != '5' ORDER BY id DESC");

$produtoscx = $produtosca->rowCount();


$produtoscax = $connect->query("SELECT * FROM store WHERE idsecao = '$id_mesa' AND idu='$idu'");


//


if ($produtoscx > 0) {

    $somando = $connect->query("SELECT valor, SUM(valor * quantidade) AS soma FROM store WHERE idsecao='" . $id_mesa . "' and idu='$idu'");

    $somando = $somando->fetch(PDO::FETCH_OBJ);

    $somandop = $connect->query("SELECT quantidade, SUM(quantidade) AS somap FROM store WHERE idsecao='" . $id_mesa . "' and idu='$idu'");

    $somandop = $somandop->fetch(PDO::FETCH_OBJ);

}


//


if (isset($_GET["apagaritem"])) {

    $idel = $_GET['apagaritem'];

    $delitem = $connect->query("DELETE FROM store WHERE idpedido='$idel'");

    $delopci = $connect->query("DELETE FROM store_o WHERE idp='$idel'");

    if ($delitem) {

        header("location: pedido.php&retirado=ok");

        exit;

    }

}


//


if (isset($_POST["mesainicial"])) {


    $mesa = $_POST['mesa'];

    $pessoas = $_POST['pessoas'];

    $nome = $_POST['nome'];

    $celular = $_POST['celular'];

    $placa = $_POST['placa'];


    $cookie_mesa = "mesaM";

    $cookie_vmesa = $mesa;

    setcookie($cookie_mesa, $cookie_vmesa, time() + (3600 * 5));


    $cookie_pessoas = "pessoasM";

    $cookie_vpessoas = $pessoas;

    setcookie($cookie_pessoas, $cookie_vpessoas, time() + (3600 * 5));


    $cookie_nome = "nomeM";

    $cookie_vnome = $nome;

    setcookie($cookie_nome, $cookie_vnome, time() + (3600 * 5));


    $cookie_cel = "celularM";

    $cookie_vcel = $celular;

    setcookie($cookie_cel, $cookie_vcel, time() + (3600 * 5));


    $cookie_placa = "placaM";

    $cookie_vplaca = $placa;

    setcookie($cookie_placa, $cookie_vplaca, time() + (3600 * 5));


//    header("location: confirmar_celular.php");
    header("location: menu.php");

    exit;


}


if (isset($_POST["mesapedido"])) {


    $data = date("d-m-Y");

    $hora = date("H:i:s");


    $idloja = $_POST['idloja'];

    $pnome = $_POST['pnome'];

    $mesa = $_POST['mesa'];

    $ppessoas = $_POST['ppessoas'];

    $pcelular = $_POST['pcelular'];

    $pplaca = $_POST['placa'];


    $subtotalx = $_POST['subtotal'];

    $adcionaisx = $_POST['adcionais'];

    $totalgx = $_POST['totalg'];


    $inst = $connect->query("INSERT INTO pedidos(idu, idpedido, fpagamento, cidade, numero, complemento, rua, bairro, troco, nome, data, hora, celular, taxa, mesa, pessoas, obs, vsubtotal, vadcionais, vtotal,placa,status) VALUES ('$idu','$idloja','MESA','0','0','0','0','0','0.00','$pnome','$data','$hora','$pcelular','0','$mesa','$ppessoas','N','$subtotalx','$adcionaisx','$totalgx','$pplaca','2')");


    $update = $connect->query("UPDATE store SET status='1' WHERE idsecao='$idloja'");

    $update = $connect->query("UPDATE store_o SET status='1' WHERE ids='$idloja'");


//    header("location: acompanhar_pedido.php");
    header("location: forma_pagamento.php");


}


if (isset($_POST["pagamento"])) {

    $total_valor = $_POST['valor_total'];
    $forma_pag = $_POST['payment-method'];

    if ($forma_pag != 'money'){

    }
    var_dump($total_valor, $forma_pag);
    exit();


}

