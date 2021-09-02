<?php

    include_once('header.php');

    if($produtoscx>0){

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
    <title>Wallett</title>
    <link rel="stylesheet" href="../styles/wallett.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/colors.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- https://www.figma.com/file/FPnjW0My7jn4sC207LtNWS/Prot%C3%B3tipo-QR-Chef -->
</head>

<body class="wallett">

    <header>
        <div class="background">
            <div class="container-logo">
                <img src='../assets/Logo.png' alt='LogoQRCode' />
                <h1>Wallet</h1>
            </div>
        </div>
    </header>

    <section>

        <form action="" method="post">

            <input type="hidden" name="Cadwallet" value="ok">
            <input type="text" class="form-control" name="wallet" style="font-size:26px; display: none;" maxlength="11" value="<?print $_GET["idwallet"];?>">

            <label>
                Nome <br />
                <input type="text" placeholder="Inserir nome" name="nome" required/>
            </label>

            <label>
                Placa de veículo <br />
                <input type="text" placeholder="Inserir placa" name="placa" required/>
            </label>

            <label>
                Marca de Veículo <br />
                <input type="text" placeholder="Inserir marca" name="marca" required/>
            </label>

            <label>
                Modelo de veículo <br />
                <input type="text" placeholder="Inserir modelo" name="modelo" required/>
            </label>

            <button type="submit">Cadastrar veículo</button>
        </form>


    </section>





</body>

</html>