<?php
include("../../models/catalogs.php");

$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"];
$traslado = $_POST["traslado"] ? $_POST["traslado"] : $_GET["traslado"]; //dinamico.
if($factura){
	$res_factura = getFactura($factura);

}elseif($traslado){
	$res_factura = getTraslado($traslado);
}
    

$empresa = fiscalName();
$name_comp = $empresa['razon_social'];
require_once('TCPDF/tcpdf.php');
require('../../resources//numero-a-letra/total-with-letter.php');


/* ============= Generar qr y sellos ================ */

// traer folio fiscal.
$filename=$res_factura["serie"].$res_factura["folio"].".xml";


if($factura){
	$xml_path="../../resources/storage/xml/".$filename;

}elseif($traslado){
	$xml_path="../../resources/storage/xml/traslados/".$filename;
}


// EXTRAER EL UUID
$cfdi=array();
if(file_exists($xml_path)){
	$cfdi=get_uuid($xml_path);		
}

/* ===================== Impuestos ================= */
$total_traslados=$cfdi["cfdi"]['total_traslado'];
/* ================================================= */

$tmp=array();
$tmp[]=$cfdi['cfdi']["version_sat"];
$tmp[]=$cfdi['cfdi']["uuid"];
$tmp[]=$cfdi['cfdi']["fecha_timbre"];
$tmp[]=$cfdi['cfdi']["sello_cfd_sat"];
$tmp[]=$cfdi['cfdi']["n_Cert_sat"];

$tmp="||".implode("|",$tmp)."||";

$returned["data"]["original_string"]=$tmp;
$returned["data"]["original_string_name"]="cadena original del complemento de certificación digital del SAT";

// ...

$tmp=$xmlData[$xmlkey]["@attributes"]["Total"];
$tmp=explode(".",$tmp);
$tmp[0]=str_pad($tmp[0],10,"0",STR_PAD_LEFT);
$tmp[1]=str_pad($tmp[1],6,"0",STR_PAD_RIGHT);
$tmp=implode(".",$tmp);

$tmp2=array();
if($cfdi['cfdi']["uuid"])
$tmp2[]="id=".$cfdi['cfdi']["uuid"];

$tmp2[]="re=".$cfdi['cfdi']["emisor_rfc"];
$tmp2[]="rr=".$cfdi['cfdi']["receptor_rfc"];
$tmp2[]="tt=".$tmp;
$tmp2[]="fe=YgEE7Q==";

//$tmp2="?".implode("&",$tmp2);
$tmp2=implode("&",$tmp2);

$returned["data"]["qrcode_cbb"]="https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?&".$tmp2;

//echo json_encode($res_factura);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	public $Comprobante;
	public $color;
	public $fuente;

    //Page header
    public function Header() {
        // Logo
		$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"];
		$traslado = $_POST["traslado"] ? $_POST["traslado"] : $_GET["traslado"]; //dinamico.

        $image_file = K_PATH_IMAGES.'logo_example.jpg';

		if($factura){
			$res_factura = getFactura($factura);
			$empresa = fiscalName();
			$cfdi_use_array = getUseCfdiPdf($res_factura['uso_cfdi']);
			$id_forma = getFormaPagoPdf($res_factura['forma_pago']);
			$receptor_id = $res_factura['cliente_id'];
			$recep_id=setTrasladoRem($receptor_id);
			$metod_pago=$res_factura['serie'];
			$moneda_id=$res_factura['moneda'];
	
			// traer folio fiscal.
			$filename=$res_factura["serie"].$res_factura["folio"].".xml";
	
			$xml_path="../../resources/storage/xml/".$filename;
		
		}elseif($traslado){
			$res_factura = getTraslado($traslado);
			//$res_factura = getFactura($factura);
			$empresa = fiscalName();
			$cfdi_use_array = getUseCfdiPdf($res_factura['uso_cfdi']);
			$id_forma = getFormaPagoPdf($res_factura['forma_pago']);
			$receptor_id = $res_factura['cliente_id'];
			$recep_id=setTrasladoRem($receptor_id);
			$metod_pago=$res_factura['serie'];
			$moneda_id=$res_factura['moneda'];
	
			// traer folio fiscal.
			$filename=$res_factura["serie"].$res_factura["folio"].".xml";
	
			$xml_path="../../resources/storage/xml/traslados/".$filename;
		}


		// EXTRAER EL UUID
		$cfdi=array();
		if(file_exists($xml_path)){
			$cfdi=get_uuid($xml_path);		
		}

		if($metod_pago=="PUE"){
			$metod_pago="( PUE ) Pago en una sola exhibicíon";
		}else{
			$metod_pago="( PPD ) Pago en pacialidades o diferido";
		}

		if($moneda_id=="USD"){
			$moneda_id="( USD ) Dolar americano";
		}else{
			$moneda_id="( MXN ) Peso mexicano";
		}
		// create some HTML content
		$this->SetY(10);
			$subtable = '<table  cellpadding="6">
				<tr color="#ffffff" bgcolor="#00446a">
				<th style="font-size:12px;text-align:center;">Receptor</th>
				</tr>
				<tr style="font-size:9px;">
				<td><span style="font-size:12px; font-weight:bold;">'.$res_factura['rfc_receptor'].'</span><br><span style="font-size:10px; font-weight:bold;">'.$res_factura['nombre_receptor']."</span><br>".$recep_id[0]['noext']." ".$recep_id[0]['calle'].", ".$recep_id[0]['cp']."<br>".$recep_id[0]['localidad'].", ".$recep_id[0]['entidad'].", ".$recep_id[0]['pais'].'</td>
				</tr>
			</table>';

			/* ========================== Sub Tabla 2 ====================== */
			$subtable2 = '<table>

			<tr style="font-size:12px;">
			<th colspan="3"  style="border:1px  solid #00446a;" color="#ffffff" bgcolor="#00446a" align="center" ><h4>FACTURA ELECTRÓNICA CFDI ( v4.0 )</h4></th>
			</tr>

			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;"><span style="font-size:8.4px; font-weight:bolder;">Serie y / o Folio</span><br>'.$res_factura['serie']." ".$res_factura['folio'].'</td>
				<td style="border-bottom:1px solid #00446a;"><span style="font-size:8px; font-weight:bolder;">Tipo de Comprobante</span><br>'.$res_factura['tipoComprobante'].'</td>
				<td style="border-bottom:1px solid #00446a;"><span style="font-size:8.4px; font-weight:bolder;">Version CFDI</span><br>'.$res_factura['version'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="3"><span style="font-size:8.4px; font-weight:bolder;">Folio Fiscal</span><br>'.$cfdi['cfdi']['uuid'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="3"><span style="font-size:8.4px; font-weight:bolder;">No de Serie del Certificado del CSD</span><br>'.$cfdi["cfdi"]['n_certificado_comp'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="2"><span style="font-size:8.4px; font-weight:bolder;">Fecha y Hora de emision</span><br>'.$res_factura['fecha'].'</td>
				<td style="border-bottom:1px solid #00446a;"><span style="font-size:8px; font-weight:bolder;">Lugar de Expediciòn</span><br>'.$res_factura['lugarExpedicion'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="3"><span style="font-size:8.4px; font-weight:bolder;">Uso de CFDI</span><br>('.$res_factura['uso_cfdi'].") ".$cfdi_use_array['description'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="3"><span style="font-size:8.4px; font-weight:bolder;">Forma de Pago</span><br>('.$res_factura['forma_pago'].") ".$id_forma['descripcion'].'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td style="border-bottom:1px solid #00446a;" colspan="3"><span style="font-size:8.4px; font-weight:bolder;">Metodo de Pago</span><br>'.$metod_pago.'</td>
			</tr>
			<tr style="text-align:center;font-size:8.4px;">
				<td colspan="2"><span style="font-size:8.4px; font-weight:bolder;">Moneda</span><br>'.$moneda_id.'</td>
				<td ><span style="font-size:8px; font-weight:bolder;">Tipo de cambio</span><br>'.$res_factura['tipoCambio'].'</td>
			</tr>
		</table>';

		$subtable1 = '<table>
				<tr style="font-size:8px;">
					<td style="width:40%;text-align:center;border-top:3px solid #ffffff;"><br><br><img src="'.$image_file.'" border="0" height="61" width="61" /><br></td>
					<td style="width:60%; text-align:center "><br><br><span style="font-size:10px; font-weight:bold;">'.$empresa['razon_social']."<br>".$empresa['rfc']."</span><br>".$empresa['regimen_fiscal']."<br>".$empresa['calle'].", ".$empresa['noext'].", ".$empresa['colonia'].",".$empresa['cp']."<br>".$empresa['localidad'].", ".$empresa['municipio']."<br>".$empresa['entidad'].", ".$empresa['pais'].'<br></td>
				</tr>
				<tr><br>
					<td style="border-bottom:1px solid #00446a;border-left:1px solid #00446a;" colspan="3">'.$subtable.'</td>
				</tr>
			</table>';

			$html = '
			<table>
				
				<tr style="font-size:9px;">
					<td style="width:60%; ">'.$subtable1.'</td>
					<td style="width:40%; border:1px solid #00446a;">'.$subtable2.'</td>
	
				</tr>

			</table>';

		$this->writeHTML($html, true, false, false, false, '');
    }


	protected $last_page_flag = false;

	public function Close() {
	  $this->last_page_flag = true;
	  parent::Close();
	}  

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
			$html = '
			<table>
				<tr>
					<td style="width:20%;">'.'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'</td>
					<td style="width:60%; text-align:center;">Este documento es una representacion impresa de un CFDI</td>
					<td style="width:20%;">[Saytec ERP Plus Rey 2.0]</td>
				</tr>
			</table>';
			$this->writeHTML($html, true, false, false, false, '');


    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Factura');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, chocolate, Rey Amargo, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 64, 5);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(true); //Ahora si imprimirá cabecera
$pdf->setPrintFooter(true); //Ahora si imprimirá pie de página

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 47);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();

$pdf->SetY(62.8);
$yLimitLimited=153.5;
	$yLimitFull=$doc["yLimit"];
// Print some HTML Cells


$pdf->SetFont('dejavusans', '', 7);
$pdf->setFont('Helvetica','',8);

//Establecer el color a poner
$pdf->SetFillColor(0,68,106);// Red Green Blue
//Habilitamos el color de fondo en las celdas

$doc["config"]["cell_fill"] = false;

if($res_factura['detalles']){
	$html1='

	<table style="width:100%;font-size:10px; padding:2px 2px; border-bottom:1px solid #aaa;" align="center">
		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:center;">
			<th style="width:40%;">Descripción</th>
			<th style="width:15%;">Cantidad</th>
			<th style="width:15%;">Valor unitario</th>
			<th style="width:15%;">Importe</th>
			<th style="width:15%;">Descuento</th>
		</tr>
		</table>
		
	';   
	$pdf->writeHTML($html1, true, false, false, false, '');

	foreach($res_factura['detalles'] as $value){

			$id_producto= getProducto($value['producto_id']);
 
			$html2 = '<table style="width:100%;font-size:10px; padding:2px 2px; border-bottom:1px solid #aaa;" align="center">
			<tr>
				<td style="width:40%; text-align:left;">'.$value['descripcion'].'</td>
				<td style="width:15%;">'.$value['cantidad'].'</td>
				<td style="width:15%;">'.$value['precio_unitario'].'</td>
				<td style="width:15%;">'.$value['importe'].'</td>
				<td style="width:15%;">'.$value['descuento'].'</td><br>

			</tr>
			<tr>
			<td colspan="4">
				<table>
					<tr style="font-size:10px; text-align:center;">

					<td style="width:30%;text-align:left;"><span style="font-weight:bold;">Codigo</span> '.$id_producto['codigo'].'</td>
					<td style="width:40%;"><span style="font-weight:bold;">Codigo de producto o servicio</span> '.$id_producto['clave'].'</td>
					<td style="width:15%;"><span style="font-weight:bold;">Clave Unidad</span>  '.$id_producto['clave_unida'].'</td>
					<td style="width:15%;"><span style="font-weight:bold;">Unidad</span>  '.$id_producto['unidad'].'</td>
					</tr>
				</table>
			
			</td>

			</tr>
			';
			$html2.='
					<tr>
					<td colspan="1"></td>
						<td colspan="4">
							<table>
								<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:center;">

								<td style="width:50%;">Impuestos traslados del concepto</td>
								<td style="width:25%;">Base</td>
								<td style="width:25%;">Importe</td>
								</tr>

								<tr>

								<td >( 002 ) IVA - Tasa 0.000000</td>
								<td >$ '.$value['subtotal'].'</td>
								<td >$ 0.00</td>
								</tr>
							</table>
						
						</td>

					</tr>
					
					</table>'; 

				//$html2 .= '</table>';


				$pdf->writeHTML($html2, true, false, false, false, '');
	}

$total_t_f=$traslado?"0.00":$res_factura['total'];
$subtotal_t_f=$traslado?"0.00":$res_factura['subtotal'];
$total_letra_t_f=$traslado?"==CERO PESOS 00/100 M.N ==":$total_with_letter;
$tbl = '
<table style="border:1px solid #00446a;" cellspacing="0" cellpadding="4">
    <tr>
        <td style="width:60%; font-weight:bold; font-size:10px;" color="#ffffff" bgcolor="#00446a">Importe con letra</td>
        <td style="width:25%; border-bottom:1px solid #FFFFFF;">Sutotal</td>

		<td style="width:5%; border-left:1px solid #00446a; border-top:1px solid #00446a; text-align:center">$</td>
		<td style="width:10%; text-align:right">'.$subtotal_t_f.'</td>
    </tr>
    <tr>
        <td style="width:60%; border-right:1px solid #00446a; text-align:center;" rowspan="2">'.$total_letra_t_f.'</td>
        <td style="width:25%; border-bottom:1px solid #FFFFFF;">Total de impuestos traslados</td>

		<td style="width:5%; border-left:1px solid #00446a; border-top:1px solid #00446a; text-align:center">$</td>
		<td style="width:10%; border-top:1px solid #00446a; text-align:right">'.$total_traslados.'</td>
    </tr>
    <tr>
       <td style="width:25%;border-top:1px solid #FFFFFF;">Total</td>

	   <td style="width:5%; border-left:1px solid #00446a; border-top:1px solid #00446a; text-align:center">$</td>
	   <td style="width:10%; border-top:1px solid #00446a; text-align:right">'.$total_t_f.'</td>
    </tr>

</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');



}


/* ============================ Complemento Comercio Exterior ============================ */

if($res_factura['complement_export']){


$datostrans='

<table style="width:100%;font-size:10px; padding:2px 2px;" align="center">
	<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:center;">
		<th colspan="4">COMPLEMENTO COMERCIO EXTERIOR</th>
	</tr>

    <tr style="font-size:10px;">

		<td>VERSION DE CE</td>
        <td>TIPO DE OPERACION</td>
		<td>CLAVE PEDIMENTO</td>
		<td>CERTIFICADO DE ORIGEN</td>

    </tr>';    

    $datostrans .= "<tr>
				<td>Version 1.1</td>
				<td>".$res_factura['complement_export']['type_of_operation']."</td>
				<td>".$res_factura['complement_export']['pediment_key']."</td>
				<td>".$res_factura['complement_export']['origin_certificate']."</td>

    </tr>";
    $datostrans .= '</table>';

	$pdf->writeHTML($datostrans, true, false, false, false, '');


/* =========================================================================== */


$datostrans='

<table style="width:100%;font-size:10px; padding:2px 2px;" align="center">
	<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:left;">
	<th colspan="4"></th>
	</tr>

    <tr style="font-size:10px;">

		<td>INCOTERM</td>
        <td>SUBDIVISION</td>
		<td>TIPO DE CAMBIO USD</td>
		<td>TOTAL USD</td>

    </tr>';    

    $datostrans .= "<tr>
				<td>".$res_factura['complement_export']['incoterm']."</td>
				<td>".$res_factura['complement_export']['subdivision']."</td>
				<td>".$res_factura['complement_export']['pediment_key']."</td>
				<td>".$res_factura['complement_export']['totals']."</td>

    </tr>";
    $datostrans .= '</table>';

	$pdf->writeHTML($datostrans, true, false, false, false, '');

/* ========================================= DOMICILIOS EMISOR / RECEPTOR ============================================= */

//Establecer el color a poner
$pdf->SetFillColor(0,68,106);// Red Green Blue
//Habilitamos el color de fondo en las celdas


$row_truck['num_permiso_sct']="0111230";
$row_truck['perm_sct']="TCPDF109";
$row_truck['year']="10";
$row_truck['config_vehicular']="C3";
$row_truck['plaque']="TREF123";

$doc["config"]["cell_fill"] = false;
$html2='

<table style="width:100%;font-size:10px; padding:2px 2px;" align="center">
	<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:center;">
		<th colspan="5">EMISOR</th>
	</tr>

    <tr style="font-size:10px;">
        <td>NumPermisoSCT</td>
		<td>PermSCT</td>
        <td>AnioModeloVM</td>
        <td>ConfigVehicular</td>
        <td>PlacaVM</td>

    </tr>';    

    $html2 .= "<tr>
				<td>$row_truck[num_permiso_sct]</td>
				<td>$row_truck[perm_sct]</td>
				<td>$row_truck[year]</td>
				<td>$row_truck[config_vehicular]</td>
				<td>$row_truck[plaque]</td>

    </tr>";
    $html2 .= '</table>';

//Establecer el color a poner
$pdf->SetFillColor(0,68,106); // Red Green Blue
//Habilitamos el color de fondo en las celdas

$row_rem['clave']="test";
$row_rem['plaque']="test";
$row_truck['nombre_aseg']="test";
$row_truck['num_poliza_seguro']="test";
$html2='

<table style="width:100%; margin-left:10%; font-size:10px; padding:2px 2px;" align="center">

	<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a;">
		<th colspan="4">RECEPTOR</th>
	</tr>
    <tr style="font-size:10px;">
        <td>SubTipoRem</td>
        <td>Placa</td>
		<td>AseguraRespCivil</td>
        <td>PolizaRespCivil</td>

    </tr>';    

    $html2 .= "<tr>
				<td>$row_rem[clave]</td>
				<td>$row_rem[plaque]</td>
				<td>$row_truck[nombre_aseg]</td>
				<td>$row_truck[num_poliza_seguro]</td>

    </tr>";
    $html2 .= '</table>';

	$pdf->writeHTML($html, true, false, false, false, '');
/* ============================================ MERCANCIAS =============================================== */

	if($res_factura['complement_export_articles']){

		$html='

		<table style="width:100%; font-size:10px; padding:2px 2px;" align="center">

		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:center; padding-left:10rem;">
			<th colspan="6">MERCANCIAS</th>
		</tr>
		<tr style="font-size:10px;">
			<td >N. Identificacion</td>
			<td>Fracción Arancelaria</td>
			<td>Cantidad Aduana</td>
			<td>Unidad Aduana</td>
			<td>Valor Unitario Aduana</td>
			<td>Valor Dolares</td>

		</tr>';    
		

			foreach($res_factura['complement_export_articles'] as $value) {
				
		
			$html .= '<tr>
					<td style="padding: 0;">'.$value["products_id"].'</td>
					<td style="padding: 0;">'.$value["products_tarrif_rate"].'</td>
					<td style="padding: 0;">'.$value["aduana_cuantity"].'</td>
					<td style="padding: 0;">'.$value["aduana_unity"].'</td>
					<td style="padding: 0;">'.$value["unitary_aduana_value"].'</td>
					<td style="padding: 0;">'.$value["dollars_value"].'</td>
		
			</tr>';
			} 

		//Cierra foreach
		$html .= '</table>';

		$pdf->writeHTML($html, true, false, false, false, '');

	}

}

/* ======================================================================================================= */




/* ================================ Complemento Carta Porte - Traslado =================================== */

if($traslado){


	$doc["config"]["cell_fill"] = false;

	//if($tipo_comp_cfdi=="T"){
		$tipo_cfdi="CFDI Traslado";
		$tipo_moneda="XXX";

	//}
/* 	else{
		$tipo_cfdi="CFDI Ingreso";
		$tipo_moneda=$currency["wid"];
	} */

	$datostrans='
	<table style="width:100%;font-size:10px; padding:2px 2px;" align="center" cellspacing="0" cellpadding="1">
		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:left;">
			<th colspan="4">DATOS COMPROBANTE</th>
		</tr>

		<tr style="font-size:9px;">

			<td>TIPO DE COMPROBANTE</td>
			<td>MONEDA</td>
			<td>USO CFDI</td>
			<td>VERSION</td>

		</tr>';    

		$datostrans .= "<tr style='font-size:8px;'>
					<td>$tipo_cfdi</td>
					<td>$tipo_moneda</td>
					<td>$cfdi_use</td>
					<td>2.0</td>

		</tr>";
		$datostrans .= '</table>';

		$pdf->writeHTML($datostrans, true, false, false, false, '');


		
	/* ============================================ MERCANCIAS =============================================== */

	$html='

	<table style="width:100%; font-size:10px; padding:2px 2px;" align="center">

		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:left; padding-left:10rem;">
			<th colspan="7">MERCANCIAS</th>
		</tr>
		<tr style="font-size:9px;">
			<td >Codigo</td>
			<td>Cantidad</td>
			<td>Unidad</td>
			<td>Articulo</td>
			<td>Descripcion</td>
			<td>Peso en Kg</td>
			<td>Valor Mercancia</td>

		</tr>';    
		
		if($res_factura['detalles']){
			//foreach($mercancias as $k => $value) {
			foreach($res_factura['detalles'] as $value){	
				$conn=superConn();
				$query = "select producto FROM productos WHERE id='$value[producto_id]' limit 1";
				$res=mysqli_query($conn,$query);
				$row_pro = mysqli_fetch_assoc($res);
				$row_emb_art_ps = $row_pro["producto"];
		
			$html .= '<tr style="font-size:8px;">
					<td style="padding: 0;">'.$value["c_claveprodserv"].'</td>
					<td style="padding: 0;">'.$value["cantidad"].'</td>
					<td style="padding: 0;">'.$value["unidad"].'</td>
					<td style="padding: 0;">'.$row_pro["producto"].'</td>
					<td style="padding: 0;">'.$value["descripcion"].'</td>
					<td style="padding: 0;">'.$value["pesokg"].'</td>
					<td style="padding: 0;">'."0.00".'</td>
		
			</tr>';
			} 

		} 
		//Cierra foreach
		$html .= '</table>';

		$pdf->writeHTML($html, true, false, false, false, '');

		//$yTmp=$yTmp+$ext_sp;
	/* ========================================= AUTO TRANSPORTE ============================================= */

	//Establecer el color a poner
	$pdf->SetFillColor(0,68,106);// Red Green Blue
	//Habilitamos el color de fondo en las celdas
	$fondo_original = $doc["config"]["cell_fill"];
	$doc["config"]["cell_fill"] = true;

	$doc["config"]["cell_fill"] = false;
	$html2='
	<table style="width:100%;font-size:10px; padding:2px 2px;" align="center">
		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:left;">
			<th colspan="5">AUTOTRANSPORTE</th>
		</tr>

		<tr style="font-size:9px;">
			<td>NumPermisoSCT</td>
			<td>PermSCT</td>
			<td>AnioModeloVM</td>
			<td>ConfigVehicular</td>
			<td>PlacaVM</td>

		</tr>';    

		//$test1=$['num_permiso_sct'];

		foreach($res_factura['appliance'] as $value){	
		$html2 .= '<tr style="font-size:8px;">
					<td>'.$value['num_permiso_sct'].'</td>
					<td>'.$value['perm_sct'].'</td>
					<td>'.$value['year'].'</td>
					<td>'.$value['config_vehicular'].'</td>
					<td>'.$value['plaque'].'</td>

		</tr>';
		}
		$html2 .= '</table>';

		$pdf->writeHTML($html2, true, false, false, false, '');



	/* ====================================== Remolques ====================================================== */	


	//Establecer el color a poner
	$pdf->SetFillColor(0,68,106); // Red Green Blue
	//Habilitamos el color de fondo en las celdas
	$fondo_original = $doc["config"]["cell_fill"];
	$doc["config"]["cell_fill"] = true;
	$yTmp=$yTmp+18;
	$doc["config"]["cell_fill"] = false;
	$html2='
	<table style="width:100%; margin-left:10%; font-size:10px; padding:2px 2px;" align="center">

		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a;">
			<th colspan="2">REMOLQUE</th>
			<th colspan="2">SEGUROS</th>
		</tr>
		<tr style="font-size:9px;">
			<td>SubTipoRem</td>
			<td>Placa</td>
			<td>AseguraRespCivil</td>
			<td>PolizaRespCivil</td>

		</tr>';    
		foreach($res_factura['type_rem'] as $value){	
		$html2 .= '<tr style="font-size:8px;">
					<td>'.$value['type_rem']['clave'].'</td>
					<td>'.$value['type_rem']['plaque'].'</td>
					<td>'.$value['appliance']['nombre_aseg'].'</td>
					<td>'.$value['appliance']['num_poliza_seguro'].'</td>

		</tr>';
		}
		$html2 .= '</table>';

		$pdf->writeHTML($html2, true, false, false, false, '');


		/* ====================================== CHOFER ====================================================== */	


	//Establecer el color a poner
	$pdf->SetFillColor(0,68,106); // Red Green Blue
	//Habilitamos el color de fondo en las celdas
	$fondo_original = $doc["config"]["cell_fill"];
	$doc["config"]["cell_fill"] = true;
	$yTmp=$yTmp+18;
	$doc["config"]["cell_fill"] = false;
	$html2='
	<table style="width:100%; margin-left:10%; font-size:10px; padding:2px 2px;" align="center">

		<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a; text-align:left;">
			<th colspan="3">FIGURA TRANSPORTE</th>
		</tr>
		<tr style="font-size:9px;">
			<td>Numero Licencia</td>
			<td>RFC Figura</td>
			<td>Tipo Figura</td>

		</tr>';    
		foreach($res_factura['driver'] as $value){
		$html2 .= '<tr style="font-size:8px;">
					<td>'.$value['license'].'</td>
					<td>'.$value['rfc'].'</td>
					<td>01</td>

		</tr>';
		}
		$html2 .= '</table>';

		$pdf->writeHTML($html2, true, false, false, false, '');

}
/* ======================================================================================================= */



$pdf->lastPage();
// reset pointer to the last page
if($cfdi['cfdi']["uuid"]):

	$style=array(
		'border'=>0,
		'padding'=>0,
		'hpadding'=>0,
		'hpadding'=>0,
		'fgcolor'=>array(0,0,0),
		'bgcolor'=>false, //array(255,255,255)
		'module_width'=>1, // width of a single module in points
		'module_height'=>1 // height of a single module in points
	);

	$pdf->write2DBarcode($returned["data"]["qrcode_cbb"],"QRCODE,H", 10, 196, 27.5,27.5,$style,"N"); // QRCODE,H : QR-CODE Best error correction


$pdf->setY($pdf->y1);
$pdf->setX(50);
$pdf->SetFont('', '', 6);
$pdf->MultiCell(55, 5, 'Timbre Fiscal Digital:  '."1.1", '', '', 0, 1, 40, 196, true);

$pdf->MultiCell(70, 5, 'Fecha de certificación: '.$cfdi['cfdi']["fecha_timbre"], '', '', 0, 1, 80, 196, true);
$pdf->MultiCell(100, 5, 'UUID:  '.$cfdi['cfdi']["uuid"], '', '', 0, 1, 140, 196, true);

$pdf->MultiCell(100, 5, 'No. Certificado del SAT: '.$cfdi['cfdi']["n_Cert_sat"], '', '', 0, 1, 40, 198.5, true);
$pdf->MultiCell(100, 5, 'RFC del proveedor de certificación: '."-------", '', '', 0, 1, 120, 198.5, true);

$pdf->MultiCell(170, 5, 'Sello digital del emisor: '.$cfdi['cfdi']["sello_cfd_sat"], '', '', 0, 1, 40, 200.5, true);

$pdf->MultiCell(170, 5, 'Sello digital del SAT: '.$cfdi['cfdi']["sello_sat"], '', '', 0, 1, 40, 209.4, true);
$pdf->MultiCell(170, 5, 'Cadena original del complemento de certificación digital del SAT: '.$returned["data"]["original_string"], '', '', 0, 1, 40, 218, true);

endif;


$html2='

<table style="width:100%; margin-left:10%; font-size:10px; padding:2px 2px;" align="center">

	<tr style="font-weight:bold; font-size:10px;color:#ffffff; background-color:#00446a;">
		<th colspan="4">RECEPTOR</th>
	</tr>
    <tr style="font-size:10px;">
        <td>SubTipoRem</td>
        <td>Placa</td>
		<td>AseguraRespCivil</td>
        <td>PolizaRespCivil</td>

    </tr>';    

    $html2 .= "<tr>
				<td>$row_rem[clave]</td>
				<td>$row_rem[plaque]</td>
				<td>$row_truck[nombre_aseg]</td>
				<td>$row_truck[num_poliza_seguro]</td>

    </tr>";
    $html2 .= '</table>';

	//$pdf->writeHTML($html2, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('factura.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+