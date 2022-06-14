<?php 
error_reporting(E_ALL ^ E_NOTICE);

$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"]; //dinamico.
$traslado = $_POST["traslado"] ? $_POST["traslado"] : $_GET["traslado"]; //dinamico.
$ce = $_POST["ce"] ? $_POST["ce"] : $_GET["ce"]; //dinamico.
$folio_xml = $_POST["folio_xml"] ? $_POST["folio_xml"] : $_GET["folio_xml"]; //dinamico.


if($factura){
    include("factura.php");
}elseif($traslado){
    include("carta_porte.php");

}elseif($ce){
    include("comercio_exterior_2.php");
}


if(!$folio_xml){

    if($factura){
        $folio_xml = getFacturaXml($factura);
    }elseif($traslado){
       $folio_xml = getTrasladoXml($traslado);

    }elseif($ce){
        $folio_xml = getFacturaXml($ce);
    }
    
}else{
    $folio_xml = $_POST["folio_xml"] ? $_POST["folio_xml"] : $_GET["folio_xml"]; //dinamico.
}

if($xml_generate){

    include("timbrado.php");

    $xml_timbre = timbre($folio_xml);

    if($factura){
        if($xml_timbre["status"]==0){
            $xml_timbre_true = setTimbradoFalse($factura);
            echo json_encode(array("status"=>0,"msg"=>$xml_timbre["msg"].", \nXML generado pero no timbrado, tiene un limite de 72 horas para hacerlo !","data"=>false));
           
        }else{
    
            $xml_timbre_true = setTimbradoTrue($factura);
            echo json_encode(array("status"=>1,"msg"=>$xml_timbre["msg"]."","data"=>false));
            
        }

    }elseif($ce){
        if($xml_timbre["status"]==0){
            $xml_timbre_true = setTimbradoFalse($ce);
            echo json_encode(array("status"=>0,"msg"=>$xml_timbre["msg"].", \nXML generado pero no timbrado, tiene un limite de 72 horas para hacerlo !","data"=>false));
        
        }else{
    
            $xml_timbre_true = setTimbradoTrue($ce);
            echo json_encode(array("status"=>1,"msg"=>$xml_timbre["msg"]."","data"=>false));
            
        }

    }elseif($traslado){
        if($xml_timbre["status"]==0){
            $xml_timbre_true = setTimbradoTfalse($traslado);
            echo json_encode(array("status"=>0,"msg"=>$xml_timbre["msg"].", \nXML generado pero no timbrado, tiene un limite de 72 horas para hacerlo !","data"=>false));
            
        }else{
    
            $xml_timbre_true = setTimbradoTfalse($traslado);
            echo json_encode(array("status"=>1,"msg"=>$xml_timbre["msg"]."","data"=>false));
            
        }
    }
    

}else{

    echo "Error al generar XML";

}

?>