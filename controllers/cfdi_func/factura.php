<?php
include("../../models/catalogs.php");

//$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"]; //dinamico.

//$factura = "0000000610";

$res_factura = getFactura($factura);

//echo json_encode($res_factura);
$xml_generate = satxmlsv40($res_factura,false,"../../resources/storage/xml/","","");

// {{{  satxmlsv40
function satxmlsv40($arr, $edidata=false, $dir="../../resources/storage/xml/",$nodo="",$addenda="") {
global $xml, $cadena_original, $sello, $texto, $ret;
error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
satxmlsv40_genera_xml($arr,$edidata,$dir,$nodo,$addenda);
satxmlsv40_genera_cadena_original();
satxmlsv40_sella($arr);
$ret = satxmlsv40_termina($arr,$dir);
//echo json_encode($arr);
return $ret;
}
 
// {{{  satxmlsv40_genera_xml
function satxmlsv40_genera_xml($arr, $edidata, $dir,$nodo,$addenda) {
global $xml, $ret;
$xml = new DOMdocument("1.0","UTF-8");
satxmlsv40_generales($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_InformacionGlobal($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_relacionados($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_emisor($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_receptor($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_conceptos($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_impuestos($arr, $edidata, $dir,$nodo,$addenda);
 
}
// }}}
 
// {{{  Datos generales del Comprobante
function satxmlsv40_generales($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
$root = $xml->createElement("cfdi:Comprobante");
$root = $xml->appendChild($root);
 
satxmlsv40_cargaAtt($root, array("xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/4",
                          "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
                          "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd"
                         )
                     );


//$fecha_acual = $document_data["registred_on"];
//$dias_menos = date("Y-m-d H:i:s", strtotime($fecha_acual."- 7 hours"));

$mifecha = date('Y-m-d H:i:s'); 
$fecha_acual = strtotime ( '-7 hour' , strtotime ($mifecha) ) ;
$fecha_acual = date ( 'Y-m-d H:i:s' , $fecha_acual); 
 
satxmlsv40_cargaAtt($root, array("Version"=>"4.0",
                      "Serie"=>$arr['serie'],
                      "Folio"=>$arr['folio'],
                      //"fecha"=>satxmlsv40_xml_fech(date),
                      //"Fecha"=>date("Y-m-d"). "T" .date("H:i:s"),
                      "Fecha"=>str_replace(" ","T", $fecha_acual),
                      "Sello"=>"@",
                      "FormaPago"=>$arr['forma_pago'],
                      "NoCertificado"=>no_Certificado(),
                      "Certificado"=>"@",
                      //"CondicionesDePago"=>"CONDICIONES",
                      "SubTotal"=>$arr['subtotal'],
                      //"Descuento"=>"22500.00",
                      "Moneda"=>$arr['moneda'],
                      "TipoCambio"=>$arr['tipo_cambio'],
                      "Total"=>$arr['total'],
                      "TipoDeComprobante"=>$arr['tipoComprobante'],
                      "Exportacion"=>$arr['c_exportacion'],
                      "MetodoPago"=>$arr['metodo_pago'],
                      "LugarExpedicion"=>$arr['lugarExpedicion'],
                   )
                );
}
 
// Datos de InformacionGlobal
function satxmlsv40_InformacionGlobal($arr, $edidata, $dir,$nodo,$addenda) {
    global $root, $xml;
        $iglobal = false; // indicamos si el nodo existira dentro del XML (true= existe, false = se omite)
        if ($iglobal == true)
        {
            $iglobal = $xml->createElement("cfdi:InformacionGlobal");
            $iglobal = $root->appendChild($iglobal);
            satxmlsv40_cargaAtt($iglobal, array("Periodicidad"=>"01",
                                          "Meses"=>"01",
                                          "Año"=>"2022",
                                        )
                                    );
        }
}
 
// {{{ Datos de documentos relacionados
function satxmlsv40_relacionados($arr, $edidata, $dir,$nodo,$addenda) {
    global $root, $xml;

    if ($arr['tipo_relacion'] != 00) 
    {
        $cfdis = $xml->createElement("cfdi:CfdiRelacionados");
        $cfdis = $root->appendChild($cfdis);
        satxmlsv40_cargaAtt($cfdis, array("TipoRelacion"=>$arr['tipo_relacion']));
        $cfdi = $xml->createElement("cfdi:CfdiRelacionado");
        $cfdi = $cfdis->appendChild($cfdi);

        $uuid_Rel=json_decode($arr['uuid_relacionados']); // Pendiente.
        satxmlsv40_cargaAtt($cfdi, array("UUID"=>$arr['uuid_relacionados']));
        //echo $uuid_Rel[0];
    }
 
}
// }}}
 
 
// Datos del Emisor
function satxmlsv40_emisor($arr, $edidata, $dir,$nodo,$addenda) {
  global $root, $xml;
  $emisor = $xml->createElement("cfdi:Emisor");
  $emisor = $root->appendChild($emisor);
  satxmlsv40_cargaAtt($emisor, array("Rfc"=>$arr['rfc'],
                                     "Nombre"=>$arr['emisor'],
                                     "RegimenFiscal"=>"601",
                                    )
                                );
}
 
// Datos del Receptor
 
function satxmlsv40_receptor($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
$receptor = $xml->createElement("cfdi:Receptor");
$receptor = $root->appendChild($receptor);
satxmlsv40_cargaAtt($receptor, array("Rfc"=>$arr['rfc_receptor'],
                                     "Nombre"=>$arr['nombre_receptor'],
                                     "UsoCFDI"=>$arr['uso_cfdi'],
                                     "RegimenFiscalReceptor"=>$arr['regimen_fiscal_rec'],
                                     "DomicilioFiscalReceptor"=>$arr['dom_receptor'],
                      )
                  );
}
 
// 
// Detalle de los conceptos/productos de la factura
function satxmlsv40_conceptos($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
$conceptos = $xml->createElement("cfdi:Conceptos");
$conceptos = $root->appendChild($conceptos);

//echo count($arr['detalles']);

//for ($i=1; $i<=sizeof(1); $i++) {
for ($i=0; $i<count($arr['detalles']); $i++) {
    
    $concepto = $xml->createElement("cfdi:Concepto");
    $concepto = $conceptos->appendChild($concepto);
    satxmlsv40_cargaAtt($concepto, array(
                              "ClaveProdServ" => $arr['detalles'][$i]['c_claveprodserv'],// pendiente
                              //"NoIdentificacion"=>"NO123"
                              "Cantidad" => $arr['detalles'][$i]['cantidad'],
                              "ClaveUnidad" => $arr['detalles'][$i]['clave_unidad'],
                              "NoIdentificacion" => $arr['detalles'][$i]['producto_id'],
                              "Unidad" => $arr['detalles'][$i]['unidad'],
                              "Descripcion" => $arr['detalles'][$i]['descripcion'],
                              "ValorUnitario" => $arr['detalles'][$i]['precio_unitario'],
                              "Importe"=>$arr['detalles'][$i]['importe'],
                              //"Descuento" => "22500.00",
                              "ObjetoImp" => $arr['detalles'][$i]['c_objetoimp']
        )
    );
    $impuestos = true; // indicamos si el nodo existirá dentro del XML (true= existe, false = se omite)
    if ($impuestos == true) 
    {
        $impuestos = $xml->createElement("cfdi:Impuestos");
        $impuestos = $concepto->appendChild($impuestos);
 
        $traslados = true;
        if ($traslados = true) 
        {
            if ($arr['detalles'][$i]['iva'] !=0 and $arr['detalles'][$i]['ieps']==0){
                $traslados = $xml->createElement("cfdi:Traslados");
                $traslados = $impuestos->appendChild($traslados);
                $traslado = $xml->createElement("cfdi:Traslado");
                $traslado = $traslados->appendChild($traslado);
                satxmlsv40_cargaAtt(
                    $traslado,
                    array(
                        "Base" => $arr['detalles'][$i]['importe'],
                        "Impuesto" => "002",
                        "TipoFactor" => "Tasa",
                        "TasaOCuota" => "0.160000",
                        "Importe" => $arr['detalles'][$i]['iva'],
                    )
                );

            }elseif($arr['detalles'][$i]['iva'] ==0 and $arr['detalles'][$i]['ieps']!=0){

                $traslados = $xml->createElement("cfdi:Traslados");
                $traslados = $impuestos->appendChild($traslados);
                $traslado = $xml->createElement("cfdi:Traslado");
                $traslado = $traslados->appendChild($traslado);
                satxmlsv40_cargaAtt(
                    $traslado,
                    array(
                        "Base" => $arr['detalles'][$i]['importe'],
                        "Impuesto" => "003",
                        "TipoFactor" => "Tasa",
                        "TasaOCuota" => "0.080000",
                        "Importe" => $arr['detalles'][$i]['ieps'],
                    )
                );

            }
            
        }
 
        $retenciones = false; // indicamos si el nodo existira dentro del XML (true= existe, false = se omite)
        if ($retenciones == true) 
        {
            $retenciones = $xml->CreateElement("cfdi:Retenciones");
            $retenciones = $impuestos->appendChild($retenciones);
            $retencion = $xml->CreateElement("cfdi:Retencion");
            $retencion = $retenciones->appendChild($retencion);
            satxmlsv40_cargaAtt(
                $retencion,
                array(
                    "Base" => "1000.00",
                    "Importe" => "40.00",
                    "Impuesto" => "002",
                    "TasaOCuota" => "0.040000",
                    "TipoFactor" => "Tasa",
 
                )
            );
        }
    }
  }
}
// 
// Impuesto (IVA)
function satxmlsv40_impuestos($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
    $impuestos2 = true; // indicamos si el nodo existira dentro del XML (true= existe, false = se omite)
    if ($impuestos2 == true) 
    {

        for ($i=0; $i<count($arr['detalles']); $i++) {
            $impo_ieps +=$arr['detalles'][$i]['ieps'];

            $impo_iva +=$arr['detalles'][$i]['iva'];

            //$impo_base +=$arr['detalles'][$i]['importe'];
        }

        //$impo_ieps +=$arr['detalles'][$i]['ieps'];
        if ($impo_iva !=0 and $impo_ieps==0){

            $impuesto_total = $impo_iva;

        }elseif($impo_iva==0 and $impo_ieps!=0){

            $impuesto_total = $impo_ieps;

        }
        $impuestos2 = $xml->CreateElement("cfdi:Impuestos");
        $impuestos2 = $root->appendChild($impuestos2);
        $impuestos2->SetAttribute("TotalImpuestosTrasladados",$impuesto_total);
        //$impuestos2->SetAttribute("TotalImpuestosRetenidos","3599.99");
 
        $retenciones2 = false; // indicamos si el nodo existira dentro del XML (true= existe, false = se omite)
        if ($retenciones2 == true)
        {
 
            $retenciones2 = $xml->CreateElement("cfdi:Retenciones");
            $retenciones2 = $impuestos2->appendChild($retenciones2);
            for ($c = 1; $c <= sizeof(1); $c++) {
                
                $retencion2 = $xml->CreateElement("cfdi:Retencion");
                $retencion2 = $retenciones2->appendChild($retencion2);
                satxmlsv33_cargaAtt($retencion2, array("Importe" => "40.00",
                                                       "Impuesto" => "002",
                ));
            }
        }
        $traslados2 = true; // indicamos si el nodo existira dentro del XML (true= existe, false = se omite)
 
        if ($traslados2 == true) 
        {
            $traslados2 = $xml->CreateElement("cfdi:Traslados");
            $traslados2 = $impuestos2->appendChild($traslados2);
            
            //for ($c = 1; $c <= sizeof(1); $c++) {
            for ($i=0; $i<count($arr['detalles']); $i++) {
                $impo_ieps +=$arr['detalles'][$i]['ieps'];

                $impo_iva +=$arr['detalles'][$i]['iva'];

                $impo_base +=$arr['detalles'][$i]['importe'];
                /* $traslado2 = $xml->CreateElement("cfdi:Traslado");
                $traslado2 = $traslados2->appendChild($traslado2);
                satxmlsv40_cargaAtt($traslado2, array("Base" => "6474.81",
                                                      "Importe" => $impo_ieps,
                                                      "Impuesto" => "002",
                                                      "TasaOCuota" => "0.160000",
                                                      "TipoFactor" => "Tasa",
                                                    )
                                                ); */
            }

            //$impo_ieps +=$arr['detalles'][$i]['ieps'];
            if ($impo_iva !=0 and $impo_ieps==0){

                $traslado2 = $xml->CreateElement("cfdi:Traslado");
                $traslado2 = $traslados2->appendChild($traslado2);
                satxmlsv40_cargaAtt($traslado2, array("Base" => $impo_base,
                                                      "Importe" => $impuesto_total,
                                                      "Impuesto" => "002",
                                                      "TasaOCuota" => "0.160000",
                                                      "TipoFactor" => "Tasa",
                                                    )
                                                );

            }elseif($impo_iva==0 and $impo_ieps!=0){

                $traslado2 = $xml->CreateElement("cfdi:Traslado");
                $traslado2 = $traslados2->appendChild($traslado2);
                satxmlsv40_cargaAtt($traslado2, array("Base" => $impo_base,
                                                      "Importe" => $impuesto_total,
                                                      "Impuesto" => "003",
                                                      "TasaOCuota" => "0.080000",
                                                      "TipoFactor" => "Tasa",
                                                    )
                                                );

            }

                
        }
 
    }
}
 
function no_Certificado()
{
    $cer = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753s.cer"; //Ruta del archivo .cer
    $noCertificado = shell_exec("openssl x509 -inform DER -in " . $cer . " -noout -serial");
    $noCertificado = str_replace(' ', ' ', $noCertificado);
    $arr1 = str_split($noCertificado);
    $certificado = '';
    for ($i = 7; $i < count($arr1); $i++) {
        # code...
        if ($i % 2 == 0) {
            $certificado = ($certificado . ($arr1[$i]));
        }
    }
    return $certificado;
}
 
 
// genera_cadena_original
function satxmlsv40_genera_cadena_original() {
global $xml, $cadena_original;
$paso = new DOMDocument;
$paso->loadXML($xml->saveXML());
$xsl = new DOMDocument;
$file="../../resources/storage/shcp_files/sat/cadenaoriginal_4_0.xslt";  // Ruta al archivo
$xsl->load($file);
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);
$cadena_original = $proc->transformToXML($paso);
$cadena_original = str_replace(array("\r", "\n"), '', $cadena_original);
#echo $cadena_original;
}
// 
 
// Calculo de sello
function satxmlsv40_sella($arr) {
global $root, $cadena_original, $sello;
$certificado = no_Certificado();
$file="../../resources/storage/shcp_files/llave.key.pem";      // Ruta al archivo
// Obtiene la llave privada del Certificado de Sello Digital (CSD),
//    Ojo , Nunca es la FIEL/FEA
$pkeyid = openssl_get_privatekey(file_get_contents($file));
openssl_sign($cadena_original, $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
openssl_free_key($pkeyid);
 
$file="../../resources/storage/shcp_files/certi.cer.pem";      // Ruta al archivo de Llave publica
$datos = file($file);
$certificado = ""; $carga=false;
for ($i=0; $i<sizeof($datos); $i++) {
    if (strstr($datos[$i],"END CERTIFICATE")) $carga=false;
    if ($carga) $certificado .= trim($datos[$i]);
    if (strstr($datos[$i],"BEGIN CERTIFICATE")) $carga=true;
}

/* ============================================================== */

//$sello = base64_encode($crypttext);      // lo codifica en formato base64
$file_key_password="12345678a"; // pendiente
$file_key_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753.key"; //Ruta del archivo .key
$private_key=getPrivateKey($file_key_path,$file_key_password);

$sello = signData3($private_key,$cadena_original,$file_key_path,$file_key_password);
$root->setAttribute("Sello",$sello);

$file_cer_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753s.cer"; //Ruta del archivo .cer
    
$certificado=getCertificate($file_cer_path,false);
// El certificado como base64 lo agrega al XML para simplificar la validacion
$root->setAttribute("Certificado",$certificado);
}
 
 
// {{{ Termina, graba en edidata o genera archivo en el disco
function satxmlsv40_termina($arr,$dir) {

// Datos deben ser dinamicos desde $arr
/* $arr['serie']="A";
$arr['folio']="167ABC";  */
global $xml, $conn;
//$dir="../../resources/storage/xml/";
$xml->formatOutput = true;
$todo = $xml->saveXML();
$nufa = $arr['serie'].$arr['folio'];    // Junta el numero de factura   serie + folio
$paso = $todo;
file_put_contents("../../resources/storage/xml/CFDI40.xml",$todo);
 
    $xml->formatOutput = true;
    $file=$dir.$nufa.".xml";
    $xml->save($file);
 //echo $arr['folio'];
return($todo);
}
// {{{ Funcion que carga los atributos a la etiqueta XML
function satxmlsv40_cargaAtt(&$nodo, $attr) {
$quitar = array('Sello'=>1,'NoCertificado'=>1,'Certificado'=>1);
foreach ($attr as $key => $val) {
    $val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c
    $val = trim($val);                           // Regla 5b
    if (strlen($val)>0) {   // Regla 6
        $val = utf8_encode(str_replace("|","/",$val)); // Regla 1
        $nodo->setAttribute($key,$val);
    }
}
}


function getPrivateKey($key_path,$password,$to_string=true) {

	$cmd='openssl pkcs8 -inform DER -in '.$key_path.' -passin pass:'.$password;

	if($result=shell_exec($cmd)) {
	unset($cmd);

	if($to_string)
	return $result;

	$split=preg_split('/-*(END|\sKEY)-*\s/',$result);
	unset($result);

	 return preg_replace('/\n/','',$split[1]);

	}
}

function signData3($key,$data,$key_path,$password) {
    $path_tmp=dirname(__FILE__)."/tmp/";
    //$data= utf8_encode($data);
    $fp = fopen("/tmp/cadena_original.txt", "w");
    fputs($fp, $data);
    fclose($fp);

    $key_path_pem="/tmp/key.pem";

     // $cmd="openssl dgst -binary -sha256 -out ".$path_tmp."sign.bin.txt -sign ".KEY_PATH.$arr['prefijo'].'.key.pem'." ".$path_tmp."cadena_original.txt";
    
    $cmd='openssl pkcs8 -inform DER -in '.$key_path.' -passin pass:'.$password.' -out PEM -out /tmp/key.pem';
    if ( $result = shell_exec( $cmd ) )
    unset($cmd);

    $cmd='openssl dgst -binary -sha256 -out /tmp/sign.bin.txt -sign '.$key_path_pem.' /tmp/cadena_original.txt';
    if ( $result = shell_exec( $cmd ) )
    unset($cmd);

        # verificar la firma 
      // $cmd="openssl dgst -sha256 -verify " .KEY_PATH.$arr['prefijo'].'.key.pem'." -signature ".$path_tmp."sign.bin.txt ".$path_tmp."cadena_original.txt";
    //if ( $result = shell_exec( $cmd ) ) unset( $cmd );
    # base64
     $cmd="openssl enc -base64 -in /tmp/sign.bin.txt -a -A -out /tmp/sello.txt";
        if ( $result = shell_exec( $cmd ) ) unset( $cmd );

       $sign=file_get_contents("/tmp/sello.txt");
        @unlink("/tmp/sign.bin.txt");
        @unlink("/tmp/sello.txt");
        @unlink("/tmp/key.pem");
        @unlink("/tmp/cadena_original.txt");

        return $sign;
}

function getCertificate($cer_path,$to_string=true) {

    $cmd='openssl x509 -inform DER -outform PEM -in '.$cer_path.' -pubkey';

    if($result=shell_exec($cmd)) {

        unset($cmd);

        if($to_string)
         return $result;

        $split=preg_split('/\n(-*(BEGIN|END)\sCERTIFICATE-*\n)/',$result);
        unset($result);

        return preg_replace('/\n/','',$split[1]);

    }

    return false;

}
 
 
?>