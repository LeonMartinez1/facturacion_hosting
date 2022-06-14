<?php
include("../../models/catalogs.php");
//$pago=1;
$res_pago = getPago1($pago);

$xml_generate = satxmlsv40($res_pago,false,"../../resources/storage/xml/pagos","","");

//echo json_encode($res_pago);
// {{{  satxmlsv40
function satxmlsv40($arr, $edidata=false, $dir="",$nodo="",$addenda="") {
global $xml, $cadena_original, $sello, $texto, $ret;
error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
satxmlsv40_genera_xml($arr,$edidata,$dir,$nodo,$addenda);
satxmlsv40_genera_cadena_original();
satxmlsv40_sella($arr);
$ret = satxmlsv40_termina($arr,$dir);
//echo $ret;
return $ret;
}
 
// {{{  satxmlsv40_genera_xml
function satxmlsv40_genera_xml($arr, $edidata, $dir,$nodo,$addenda) {
global $xml, $ret;
$xml = new DOMdocument("1.0","UTF-8");
satxmlsv40_generales($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_relacionados($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_emisor($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_receptor($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_conceptos($arr, $edidata, $dir,$nodo,$addenda);
satxmlsv40_Recepcion_Pagos20($arr, $edidata, $dir,$nodo,$addenda);
 
}
// }}}
 
// {{{  Datos generales del Comprobante
function satxmlsv40_generales($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
$root = $xml->createElement("cfdi:Comprobante");
$root = $xml->appendChild($root);
 
satxmlsv40_cargaAtt($root, array("xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/4",
                          "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
                          "xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd",
                          "xmlns:pago20" => "http://www.sat.gob.mx/Pagos20",
                         )
                     );
 
$mifecha = date('Y-m-d H:i:s'); 
$fecha_acual = strtotime ( '-7 hour' , strtotime ($mifecha) ) ;
$fecha_acual = date ( 'Y-m-d H:i:s' , $fecha_acual); 
satxmlsv40_cargaAtt($root, array("Version"=>"4.0",
                      "Serie"=>$arr['serie'],
                      "Folio"=>$arr['folio'],
                      //"fecha"=>satxmlsv40_xml_fech(date),
                      "Fecha"=>str_replace(" ","T", $fecha_acual),
                      "Sello"=>"@",                    
                      "NoCertificado"=>no_Certificado(),
                      "Certificado"=>"@",
                      "SubTotal"=>"0",
                      "Moneda"=>"XXX",
                      "Total"=>"0",
                      "TipoDeComprobante"=>"P",
                      "Exportacion"=> "01",
                      "LugarExpedicion"=>$arr['fiscal_n']['cp'],
                   )
                );
}
 
 
// {{{ Datos de documentos relacionados
function satxmlsv40_relacionados($arr, $edidata, $dir,$nodo,$addenda) {
    global $root, $xml;
 
      $cfdis = false;
 
      if ($cfdis == true){
        $cfdis = $xml->createElement("cfdi:CfdiRelacionados");
        $cfdis = $root->appendChild($cfdis);
        satxmlsv40_cargaAtt($cfdis, array("TipoRelacion"=>"01"));
        $cfdi = $xml->createElement("cfdi:CfdiRelacionado");
        $cfdi = $cfdis->appendChild($cfdi);
        satxmlsv40_cargaAtt($cfdi, array("UUID"=>"A39DA66B-52CA-49E3-879B-5C05185B0EF7"));
      }    
 
}
// }}}
 
 
// Datos del Emisor
function satxmlsv40_emisor($arr, $edidata, $dir,$nodo,$addenda) {
  global $root, $xml;
  $emisor = $xml->createElement("cfdi:Emisor");
  $emisor = $root->appendChild($emisor);
  satxmlsv40_cargaAtt($emisor, array("Rfc"=>$arr['fiscal_n']['rfc'],
                                     "Nombre"=>$arr['fiscal_n']['nombre_comercial'],
                                     "RegimenFiscal"=>$arr['fiscal_n']['regimen_fiscal'],
                                    )
                                );
}
 
// Datos del Receptor
 
function satxmlsv40_receptor($arr, $edidata, $dir,$nodo,$addenda) {
global $root, $xml;
$receptor = $xml->createElement("cfdi:Receptor");
$receptor = $root->appendChild($receptor);
satxmlsv40_cargaAtt($receptor, array("Rfc"=>$arr['cliente_res']['rfc'],
                                      "Nombre"=>$arr['cliente_res']['cliente'],
                                      "UsoCFDI"=>"CP01",
                                      "RegimenFiscalReceptor"=>$arr['cliente_res']['regimen_fiscal'],
                                      "DomicilioFiscalReceptor"=>$arr['cliente_res']['cp'],
                      )
                  );
}
 
// 
// Detalle de los conceptos/productos de la factura
function satxmlsv40_conceptos($arr, $edidata, $dir,$nodo,$addenda) 
{
  global $root, $xml;
  $conceptos = $xml->createElement("cfdi:Conceptos");
  $conceptos = $root->appendChild($conceptos);
  $concepto = $xml->createElement("cfdi:Concepto");
  $concepto = $conceptos->appendChild($concepto);
  satxmlsv40_cargaAtt($concepto, array(
                              "ClaveProdServ"=>"84111506",                              
                              "Cantidad"=>"1",
                              "ClaveUnidad"=>"ACT",
                              //"NoIdentificacion"=>"00001",
                              "Descripcion"=>"Pago",
                              "ValorUnitario"=>"0",
                              "Importe"=>"0",
                              "ObjetoImp"=>"01",
                            ));
}
 
 
// Complemento recepcion de pagos
 
function satxmlsv40_Recepcion_Pagos20($arr, $edidata, $dir,$nodo,$addenda){
  global $root, $xml;
  $complemento_rp = $xml->createElement("cfdi:Complemento");
  $complemento_rp = $root->appendChild($complemento_rp);
  $recep_pagos20 = $xml->createElement("pago20:Pagos");
  $recep_pagos20 = $complemento_rp->appendChild($recep_pagos20);
  satxmlsv40_cargaAtt($recep_pagos20, array(
    "Version" => "2.0",
  ));

  for ($i=0; $i<count($arr['payment_relations']); $i++) {
      $MontoTotalPagos +=$arr['payment_relations'][$i]['import'];

  }
 
  //creamos el nodo TOTALES
  $totales = $xml->createElement("pago20:Totales");
  $totales = $recep_pagos20->appendChild($totales);
  satxmlsv40_cargaAtt($totales, array(
    "TotalRetencionesIVA"=>false,
    "TotalRetencionesISR"=>false,
    "TotalRetencionesIEPS"=>false,
    //"TotalTrasladosBaseIVA16"=>"33000.00",
    //"TotalTrasladosImpuestoIVA16"=>"5280.00",
    "TotalTrasladosBaseIVA8"=>false,
    "TotalTrasladosImpuestoIVA8"=>false,
    "TotalTrasladosBaseIVA0"=>false,
    "TotalTrasladosImpuestoIVA0"=>false,
    "TotalTrasladosBaseIVAExento"=>false,
    "MontoTotalPagos"=>$MontoTotalPagos,
  ));
 
  //creamos el nodo Pago
 
  $mifecha = date('Y-m-d H:i:s'); 
$fecha_acual = strtotime ( '-7 hour' , strtotime ($mifecha) ) ;
$fecha_acual = date ( 'Y-m-d H:i:s' , $fecha_acual); 

  for ($p20=1; $p20<=sizeof(1); $p20++){
    $pago = $xml->createElement("pago20:Pago");
    $pago = $recep_pagos20->appendChild($pago);
    satxmlsv40_cargaAtt($pago, array(
      //"FechaPago"=>"2021-11-23T00:00:00",
      "FechaPago"=>str_replace(" ","T", $fecha_acual),
      "FormaDePagoP"=>$arr['method'],
      "MonedaP"=>$arr['tipo_moneda'],
      "TipoCambioP"=>"1",
      "Monto"=>$MontoTotalPagos,
      "NumOperacion"=>false,
      "RfcEmisorCtaOrd"=>false,
      "NomBancoOrdExt"=>false,
      "CtaOrdenante"=>false,
      "RfcEmisorCtaBen"=>false,
      "CtaBeneficiario"=>false,
      "TipoCadPago"=>false,
      "CertPago"=>false,
      "CadPago"=>false,
      "SelloPago"=>false,
    ));
 
    //Nodo DoctoRelacionado
    for ($dr=0; $dr<count($arr['payment_relations']); $dr++){
      $doc_relacionado = $xml->createElement("pago20:DoctoRelacionado");
      $doc_relacionado = $pago->appendChild($doc_relacionado);
      satxmlsv40_cargaAtt($doc_relacionado, array(
        "IdDocumento"=>$arr['payment_relations'][$dr]['uuid_factura'],
        //"Serie"=>$arr['payment_relations'][$dr]['serie'],
        //"Folio"=>$arr['payment_relations'][$dr]['folio'],
        "MonedaDR"=>$arr['payment_relations'][$dr]['tipo_moneda'],
        "EquivalenciaDR"=>"1",
        "NumParcialidad"=>"1",
        "ImpSaldoAnt"=>$arr['payment_relations'][$dr]['import'],
        "ImpPagado"=>$arr['payment_relations'][$dr]['import'],
        "ImpSaldoInsoluto"=>"0.00",  
        "ObjetoImpDR"=>"01",
      ));
 
      //Nodo ImpuestosDR
      $impuestosDR = false; 
      if($impuestosDR == null){
      } else {        
          $impuestosDR = $xml->createElement("pago20:ImpuestosDR");
          $impuestosDR = $doc_relacionado->appendChild($impuestosDR);        
      }
 
      // Nodo retencionesDR
      $retencionesDR =  false;
      if ($retencionesDR == null){
      }else {        
          $retencionesDR = $xml->createElement("pago20:RetencionesDR");
          $retencionesDR = $impuestosDR->appendChild($retencionesDR);
 
          for($r=1; $r<= sizeof(1); $r++){
          $retencionDR = $xml->createElement("pago20:RetencionDR");
          $retencionDR = $retencionesDR->appendChild($retencionDR);
          satxmlsv40_cargaAtt($retencionDR, array(
            "BaseDR"=>false,
            "ImpuestoDR"=>false,
            "TipoFactorDR"=>false,
            "TasaOCuotaDR"=>false,
            "ImporteDR"=>false,
          ));
        }
      }
 
      //Nodo TrasladosDR 
      $trasladosDR = false;
      if($trasladosDR == null){            
      }else {
        $trasladosDR = $xml->createElement("pago20:TrasladosDR");
        $trasladosDR = $impuestosDR->appendChild($trasladosDR);
        for($i=1; $i<= sizeof(1); $i++){
          $trasladoDR = $xml->createElement("pago20:TrasladoDR");
          $trasladoDR = $trasladosDR->appendChild($trasladoDR);
          satxmlsv40_cargaAtt($trasladoDR, array(
            "BaseDR"=>"33000.00",
            "ImpuestoDR"=>"002",
            "TipoFactorDR"=>"Tasa",
            "TasaOCuotaDR"=>"0.160000",
            "ImporteDR"=>"5280.00",
         ));
        }
      } 
 
      $impuestosP = false;
      if($impuestosP == null){        
      }else{
        $impuestosP = $xml->createElement("pago20:ImpuestosP");
        $impuestosP = $pago->appendChild($impuestosP);
 
        $retencionesP = false;
        if($retencionesP == null){
          }else{
            $retencionesP = $xml->createElement("pago20:RetencionesP");
            $retencionesP = $impuestosP->appendChild($retencionesP);
 
            $retencionP = $xml->createElement("pago20:RetencionP");
            $retencionP = $retencionesP->appendChild($retencionP);
            satxmlsv40_cargaAtt($retencionP, array(
              "ImpuestoP"=>false,
              "ImporteP"=>false,
            ));
          } 
        $trasladosP = false;
        if($trasladosP == null){
          }else{
            $trasladosP = $xml->createElement("pago20:TrasladosP");
            $trasladosP = $retencionesP->appendChild($trasladosP);
 
            $trasladoP = $xml->createElement("pago20:TrasladoP");
            $trasladoP = $trasladosP->appendChild($trasladoP);
            satxmlsv40_cargaAtt($trasladoP, array(
              "BaseP"=>false,
              "ImpuestoP"=>false,
              "TipoFactorP"=>false,
              "TasaOCuotaP"=>false,
              "ImporteP"=>false,
            ));
          } 
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
 
$sello = base64_encode($crypttext);      // lo codifica en formato base64
$root->setAttribute("Sello",$sello);
 
$file="../../resources/storage/shcp_files/certi.cer.pem";    // Ruta al archivo de Llave publica
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
global $xml, $conn;
$dir="../../resources/storage/xml/pagos/";
$xml->formatOutput = true;
$todo = $xml->saveXML();

/* $arr['Serie']="A";
$arr['Folio']="167ABC"; */
$nufa = $arr['serie'].$arr['folio'];    // Junta el numero de factura   serie + folio

$paso = $todo;
file_put_contents("../../resources/storage/xml/pagos/CFDI40_REP20.xml",$todo);
//file_put_contents("/home/Documentos/CFDI40_REP20.xml",$todo);
 
    $xml->formatOutput = true;
    $file=$dir.$nufa.".xml";
    $xml->save($file);
 
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