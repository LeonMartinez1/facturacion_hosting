<?php



function cancelCfdi($id,$motivo,$uuid_folio){
        /* $pac_user=da_xcess("fill",$pac_user);
        $pac_password=da_xcess("fill",$pac_password); */

        // el .key y su contenido desencritado de password
        $file_key_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753.key"; //Ruta del archivo .key

        // el .cer y su contenido 
        $file_cer_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753s.cer"; //Ruta del archivo .cer

        $file_key_password="12345678a"; // pendiente

        //$invoice_electronic_xml_file_path=da_xcess("fill",$invoice_electronic_xml_file_path);
        // return array("status"=>0,"msg"=>var_export($key_content,true),"data"=>false);
        //die(json_encode($motivo));

        $uuid_folio=$uuid_folio;
        //return array("status"=>0,"msg"=>"motivo = $comment.","data"=>false);
        $data=array();

        // $taxpayer_id = 'CSO050217EA1'; # The RFC of the Emisor
        $taxpayer_id = str_replace("-", "", strtoupper("EKU9003173C9") ) ;

        // $invoices = array("6308DF45-0D7F-4060-9121-6C8639FE1C14"); # A list of UUIDs
        if(is_array($UUID))
        $invoices = $UUID; # A list of UUIDs
        else
        $invoices = array(0=> (trim($UUID)));
        // return array("status"=>0,"msg"=>var_export($invoices,true),"data"=>false);

        /* =========================== Comentado 21-01-22 ===================== */ // Codigo para produccion.


        /*
        // Nueva version.
        $client = new SoapClient("https://facturacion.finkok.com/servicios/soap/cancel.wsdl", array('trace' => 1));
        
        $uuids = array("UUID" => $invoices[0], "Motivo" => "02", "FolioSustitucion" => "");
        $uuid_ar = array('UUID' => $uuids);
        $uuids_ar = array('UUIDS' => $uuid_ar);

        
        $params = array("UUIDS"=>$uuid_ar,
            "username" => $pac_user,
            "password" => $pac_password,
            "taxpayer_id" => $taxpayer_id,
            "cer" => $cer_content,
            "key" => $key_content,
        );

        //return array("status"=>0,"msg"=>"".json_encode($invoices[0])."","data"=>false);
        //return array("status"=>0,"msg"=>var_export($timbre,true),"data"=>false);

        $timbre = $client->__soapCall("cancel", array($params));

        */


        /* ============================== Codigo para pruebas =================================== */

        # Generar el certificado y llave en formato .pem
        shell_exec("openssl x509 -inform DER -outform PEM -in ".$file_cer_path." -pubkey -out ../../resources/storage/shcp_files/certificado.pem");
        shell_exec("openssl pkcs8 -inform DER -in ".$file_key_path." -passin pass:12345678a -out ../../resources/storage/shcp_files/llave.key.pem");
        shell_exec("openssl rsa -in ../../resources/storage/shcp_files/llave.key.pem -des3 -out ../../resources/storage/shcp_files/llave.enc -passout pass:2Leones.");
        

        $pac_user="ing.ricardomtzl@gmail.com";
        $pac_password="2Leones.";

        # Read the x509 certificate file on PEM format and encode it on base64
        $cer_path = "../../resources/storage/shcp_files/certificado.pem"; 
        $cer_file = fopen($cer_path, "r");
        $cer_content = fread($cer_file, filesize($cer_path));
        fclose($cer_file);
        # In newer PHP versions the SoapLib class automatically converts FILE parameters to base64, so the next line is not needed, otherwise uncomment it
        #$cer_content = base64_encode($cer_content);

        # Read the Encrypted Private Key (des3) file on PEM format and encode it on base64
        $key_path = "../../resources/storage/shcp_files/llave.enc";
        $key_file = fopen($key_path, "r");
        $key_content = fread($key_file,filesize($key_path));
        fclose($key_file);
        # In newer PHP versions the SoapLib class automatically converts FILE parameters to base64, so the next line is not needed, otherwise uncomment it
        #$key_conte

        $client = new SoapClient("https://demo-facturacion.finkok.com/servicios/soap/cancel.wsdl", array('trace' => 1));
        
        //$uuids = array("UUID" => $invoices[0], "Motivo" => "$comment", "FolioSustitucion" => "$uuid_folio");
        $uuids = array("UUID" => $id, "Motivo" => "0$motivo", "FolioSustitucion" => "$uuid_folio");

        $uuid_ar = array('UUID' => $uuids);
        $uuids_ar = array('UUIDS' => $uuid_ar);

        
        $params = array("UUIDS"=>$uuid_ar,
            "username" => $pac_user,
            "password" => $pac_password,
            "taxpayer_id" => $taxpayer_id,
            "cer" => $cer_content,
            "key" => $key_content,
        );

        //return array("status"=>0,"msg"=>"".json_encode($invoices[0])."","data"=>false);
        //return array("status"=>0,"msg"=>var_export($timbre,true),"data"=>false);

        $timbre = $client->__soapCall("cancel", array($params));

        /* ======================================================================================= */


        $status_cancel_result = $timbre->cancelResult->Folios->Folio->EstatusUUID;

        if(!$timbre)
        return array("status"=>0,"msg"=>"proceso de cancelacion timbrado con pac 'finkok', no se pudo realizar la petición debido a ".( curl_error($process)?: "error desconocido" ),"data"=>false);



        // $timbre->stampResult->xml
        if($timbre->stampResult->xml)
        @$server_response=XML2Array::createArray($timbre->stampResult->xml); // "@" is required to avoid less importance class warnings


        $data["acuse"]=$timbre->cancelResult->Acuse;

        //return array("status"=>0,"msg"=>json_encode($status_cancel_result),"timbre"=>$data);

        $server_response_result=$server_response;

        if(strpos(json_encode($timbre->cancelResult),"No Encontrado")){
        return array("status"=>0,"msg"=>"proceso de cancelacion timbrado con pac 'finkok', no se pudo realizar la petición,no fue encontrado, intentelo de nuevo más tarde","data"=>false);

        }
        /* else if($data["acuse"]==null){
        return array("status"=>0,"msg"=>"proceso de cancelacion timbrado con pac 'finkok', no se pudo realizar la petición, intentelo de nuevo más tarde","data"=>false);

        } */


        //Este request contiene los datos de usuario y contraseña del pac asi como los errores que sierven solo para el desarrollador.

        /*  $file = fopen("../../../../storage/invoice/electronic/cfdi/xmlcanceled/SoapRequest.xml", "a");
        fwrite($file, $client->__getLastRequest() . "\n");
        fclose($file); */
        

        if($timbre){

            $file = fopen("../../resources/storage/xmlcanceled/".$taxpayer_id."_".$id.".xml", "a");
            fwrite($file, $client->__getLastResponse() . "\n");
            fclose($file);

            # Generación de archivo .xml con el Request de timbrado
            $file = fopen("../../resources/storage/xmlcanceled/SoapRequest.xml", "a");
            fwrite($file, $client->__getLastRequest() . "\n");
            fclose($file);
            
            $file = fopen("../../resources/storage/xmlcanceled/SoapResponse.xml", "a");
            fwrite($file, $client->__getLastResponse() . "\n");
            fclose($file);

            return array("status"=>1,"msg"=>"Proceso de cancelaciòn realizado exitosamente.","data"=>false);

        }else{
            return array("status"=>0,"msg"=>"Proceso de cancelacion con pac 'finkok', no se pudo realizar la petición, intentelo de nuevo más tarde","data"=>false);
        
        }




        //return array("status"=>1,"msg"=>"proceso de timbrado con pac 'finkok', proceso realizado exitosamente.","data"=>false);

}

?>