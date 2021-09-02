<?php
ob_start();
include('../../funcoes/Conexao.php');
include('../../funcoes/Key.php');
include('../db/base.php');
require('../db/Mobile_Detect.php');
$detect = new Mobile_Detect;
$xurl = 'clientedemo';
$site = HOME;
include('FuncoesM.php');
