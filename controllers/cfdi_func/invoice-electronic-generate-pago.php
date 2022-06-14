<?php 
error_reporting(E_ALL ^ E_NOTICE);

$pago = $_POST["pago"] ? $_POST["pago"] : $_GET["pago"]; //dinamico.
$folio_xml = $_POST["folio_xml"] ? $_POST["folio_xml"] : $_GET["folio_xml"]; //dinamico.

//echo json_encode(array("status"=>1,"msg"=>$pago."","data"=>false));
if($pago){
    include("pagos.php");
}

if($xml_generate){

    include("timbrado.php");
    $path_folio="/pagos".$folio_xml;

    $xml_timbre = timbre($path_folio);

    if($pago){
        echo json_encode(array("status"=>1,"msg"=>$xml_timbre["msg"]."","data"=>false));

    }
    

}else{

    echo "Error al generar XML";

}

?>