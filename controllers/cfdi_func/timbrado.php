<?php
 


# Username and Password, assigned by FINKOK
/* $username = 'username@demo.com';
$password = '12345678a'; */


function timbre($xml){

    $pac_user="ing.ricardomtzl@gmail.com";
    $pac_password="2Leones.";
    
    # Read the xml file and encode it on base64
    $invoice_path = "../../resources/storage/xml/".$xml.".xml";
    $xml_file = fopen($invoice_path, "rb");
    $xml_content = fread($xml_file, filesize($invoice_path));
    fclose($xml_file);
    
    # In newer PHP versions the SoapLib class automatically converts FILE parameters to base64, so the next line is not needed, otherwise uncomment it
    #$xml_content = base64_encode($xml_content);


    # Consuming the stamp service
    $params = array(
        "xml" => $xml_content,
        "username" => $pac_user,
        "password" => $pac_password
    );
    
    $client = new SoapClient("https://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl", array('trace' => 1));
    $response = $client->__soapCall("stamp", array($params));

    //print_r($response);
    
    ####Guardar XMLtimbrado
    /* $file = fopen("../../resources/storage/xml/stampResult.xml", "a");
    fwrite($file, $response->stampResult->xml);
    fclose($file); */

    /* $file = fopen($invoice_path, "a");
    fwrite($file, $response->stampResult->xml);
    fclose($file); */

    if($response->stampResult->Incidencias->Incidencia->CodigoError)
    if($response->stampResult->Incidencias->Incidencia->CodigoError!=307)
    return array("status"=>0,"msg"=>$response->stampResult->Incidencias->Incidencia->MensajeIncidencia." ".$response->stampResult->Incidencias->Incidencia->ExtraInfo,"data"=>false);


    file_put_contents($invoice_path, $response->stampResult->xml);


    $file = fopen("../../resources/storage/xml/SoapResponse.xml", "a");
    fwrite($file, $client->__getLastResponse() . "\n");
    fclose($file);

    $file = fopen("../../resources/storage/xml/SoapRequest.xml", "a");
    fwrite($file, $client->__getLastRequest() . "\n");
    fclose($file);

    ####mostrar el código de error en caso de presentar alguna incidencia
    #print $response->stampResult->Incidencias->Incidencia->CodigoError;
    ####mostrar el mensaje de incidencia en caso de presentar alguna
    #print $response->stampResult->Incidencias->Incidencia->MensajeIncidencia;


    return array("status"=>1,"msg"=>"Proceso de timbrado realizado exitosamente.","data"=>false);

}


?>