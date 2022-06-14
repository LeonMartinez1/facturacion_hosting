<?php

// required libraries

require_once("CNumeroaLetra.php");

// ...

$tmp=new CNumeroaletra;
$tmp->setMayusculas(1);
$tmp->setPrefijo(" ");
$tmp->setSufijo("$res_factura[moneda] ");
$tmp->setMoneda($currency["text"]);
$tmp->setNumero($res_factura['total']);

$tmp=$tmp->letra();

$total_with_letter=$tmp;

?>