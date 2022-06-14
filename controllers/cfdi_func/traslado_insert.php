<?php 
include("../../models/catalogs.php");

$cliente = isset($_POST['cliente']) ? $_POST['cliente']: false;
$cliente_nombre = isset($_POST['cliente_nombre']) ? $_POST['cliente_nombre']: false;
$cliente_email = isset($_POST['cliente_email']) ? $_POST['cliente_email']: false;
$cliente_rfc = isset($_POST['cliente_rfc']) ? $_POST['cliente_rfc']: false;
$c_exportacion = isset($_POST['c_exportacion']) ? $_POST['c_exportacion']: false;
$serie_folio = isset($_POST['serie_folio']) ? $_POST['serie_folio']: false;
$referencia = isset($_POST['referencia']) ? $_POST['referencia']: false;
$fecha = isset($_POST['fecha']) ? $_POST['fecha']: false;
$forma_pago = isset($_POST['forma_pago']) ? $_POST['forma_pago']: false;
$cfdi_use = isset($_POST['cfdi_use']) ? $_POST['cfdi_use']: false;
$metodo_pago = isset($_POST['metodo_pago']) ? $_POST['metodo_pago']: false;
$moneda = isset($_POST['moneda']) ? $_POST['moneda']: false;
$tipo_cambio = isset($_POST['tipo_cambio']) ? $_POST['tipo_cambio']: false;
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones']: false;

$uuid = isset($_POST['uuid']) ? $_POST['uuid']: false;
$factura_id = isset($_POST['factura_id']) ? $_POST['factura_id']: false;

$tipo_relacion = isset($_POST['tipo_relacion']) ? $_POST['tipo_relacion']: "00";
$uuid_relacionados = isset($_POST['uuid_relacionados']) ? $_POST['uuid_relacionados']: false;

$subtotal = isset($_POST['divSubtotal']) ? $_POST['divSubtotal']: false;
$importe = isset($_POST['importe']) ? $_POST['importe']: false;
$total = isset($_POST['divTotal']) ? $_POST['divTotal']: false;

$cuenta_pago = isset($_POST['cuenta_pago']) ? $_POST['cuenta_pago']: false;

$productos = isset($_POST['productos']) ? $_POST['productos']: false;


$estado1 = isset($_POST['estado']) ? $_POST['estado']: false;
$localidad = isset($_POST['localidad']) ? $_POST['localidad']: false;
$municipio = isset($_POST['municipio']) ? $_POST['municipio']: false;
$colonia = isset($_POST['colonia']) ? $_POST['colonia']: false;
$codigo_postal = isset($_POST['codigo_postal']) ? $_POST['codigo_postal']: false;

$estado2 = isset($_POST['estado2']) ? $_POST['estado2']: false;
$localidad2 = isset($_POST['localidad2']) ? $_POST['localidad2']: false;
$municipio2 = isset($_POST['municipio2']) ? $_POST['municipio2']: false;
$colonia2 = isset($_POST['colonia2']) ? $_POST['colonia2']: false;
$codigo_postal2 = isset($_POST['codigo_postal2']) ? $_POST['codigo_postal2']: false;

$driver = isset($_POST['driver']) ? $_POST['driver']: false;
$appliance = isset($_POST['appliance']) ? $_POST['appliance']: false;
$type_rem = isset($_POST['type_rem']) ? $_POST['type_rem']: false;

$rem_id = isset($_POST['rem_id']) ? $_POST['rem_id']: false;
$dest_id = isset($_POST['dest_id']) ? $_POST['dest_id']: false;



if(!$cliente || !$c_exportacion || !$serie_folio || !$forma_pago || !$cfdi_use || !$metodo_pago || !$moneda || !$tipo_cambio){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos","data"=>false));
    return;
}




/* else{
    echo json_encode(array("status"=>1,"msg"=>"cfdi_use si existe","data"=>false));
} */

$json = array();

$conn=superConn();

$query="SELECT * FROM clientes WHERE id = '$cliente' limit 1";
    $res=mysqli_query($conn,$query);
    if($res){
        while($row=mysqli_fetch_assoc($res))
        $cliente_res=$row;
        
}

/* ============== Datos mi empresa emisor ================ */
$fiscal=fiscalName();
$folio = getLastFolioT();

$emisor = $fiscal['nombre_comercial'];
$rfc = $fiscal['rfc'];
$lugar_expedicion = $fiscal['cp'];
$version = "4.0";
$tipo_comprobante = "T";

$estado = "ACTIVO";
$timbrado = "TIMBRADO";

$fecha = date("Y-m-d H:i:s");
$regimen_fiscal = "601";


/* Insertar en tabla */
    $query="INSERT INTO traslados (emisor, rfc, version, uso_cfdi, enviado, serie, folio, uuid, fecha, venta_id, cliente_id, rfc_receptor, subtotal, importe, total, saldo, email, forma_pago, cuenta_pago,metodo_pago, tipoComprobante, moneda, tipoCambio, lugarExpedicion, observaciones, tipo_relacion, uuid_relacionados, estado, timbrado, c_exportacion, dom_receptor, nombre_receptor, regimen_fiscal_rec, rem_estado, rem_localidad, rem_municipio, rem_colonia, rem_codigo_postal, dest_estado, dest_localidad, dest_municipio, dest_colonia, dest_codigo_postal, driver, appliance, type_rem, rem_id, dest_id) VALUES ('$emisor', '$rfc', '$version', '$cfdi_use', '0', '$serie_folio', '$folio', '$uuid', '$fecha', '$factura_id', '0', '$rfc', '$subtotal', '$subtotal', '$total', '$saldo', '', '$forma_pago', '$cuenta_pago', '$metodo_pago','$tipo_comprobante' ,'$moneda', '$tipo_cambio', '$lugar_expedicion', '$observaciones', '$tipo_relacion', '$uuid_relacionados', '$estado', '$timbrado', '$c_exportacion', '$lugar_expedicion', '$emisor', '$regimen_fiscal','$estado2','$localidad2','$municipio2','$colonia2','$codigo_postal2','$estado1','$localidad','$municipio','$colonia','$codigo_postal','$driver','$appliance','$type_rem','$rem_id','$dest_id')";
    $res=mysqli_query($conn,$query);

    if($res){

        
        $query1="SELECT MAX(id) as last_id FROM traslados";
        $res=mysqli_query($conn,$query1);

        $reg_ids=$row=mysqli_fetch_assoc($res);
        $data=$reg_ids['last_id'];


        echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>$data));
    }else{
        echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
    }




?>