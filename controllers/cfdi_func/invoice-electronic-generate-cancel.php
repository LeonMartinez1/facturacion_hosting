<?php 
error_reporting(E_ALL ^ E_NOTICE);

$id = $_POST["id"] ? $_POST["id"] : $_GET["id"]; //dinamico.
$uuid_folio = $_POST["uuid_folio"] ? $_POST["uuid_folio"] : $_GET["uuid_folio"]; //dinamico.
$motivo = $_POST["motivo"] ? $_POST["motivo"] : $_GET["motivo"]; //dinamico.

    include("cancel_factura.php");

    $xml_timbre = cancelCfdi($id,$motivo,$uuid_folio);

    if($id){
        if($xml_timbre["status"]==0){
           
            echo json_encode(array("status"=>0,"msg"=>$xml_timbre["msg"].", \nXML gNo se pudo timbrar !","data"=>false));
            
    
        }else{
    
            echo json_encode(array("status"=>1,"msg"=>$xml_timbre["msg"]."","data"=>false));
         
        }

    }
    

?>