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
$venta__id = isset($_POST['venta__id']) ? $_POST['venta__id']: false;

$tipo_relacion = isset($_POST['tipo_relacion']) ? $_POST['tipo_relacion']: "00";
$uuid_relacionados = isset($_POST['uuid_relacionados']) ? $_POST['uuid_relacionados']: false;

$subtotal = isset($_POST['divSubtotal']) ? $_POST['divSubtotal']: false;
$importe = isset($_POST['importe']) ? $_POST['importe']: false;
$total = isset($_POST['divTotal']) ? $_POST['divTotal']: false;

$cuenta_pago = isset($_POST['cuenta_pago']) ? $_POST['cuenta_pago']: false;

$productos = isset($_POST['productos']) ? $_POST['productos']: false;

$detalles = isset($_POST['detalles']) ? $_POST['detalles']: false;

$detalles=json_decode($detalles,TRUE);   

//PARAMSCOMPLEMENTS
$c_type_of_operation= isset($_POST['c_type_of_operation']) ? $_POST['c_type_of_operation']: false;
$c_clave_pedimento= isset($_POST['c_clave_pedimento']) ? $_POST['c_clave_pedimento']: false; 
$c_cert_origen= isset($_POST['c_cert_origen']) ? $_POST['c_cert_origen']: false;
$c_incoterm= isset($_POST['c_incoterm']) ? $_POST['c_incoterm']: false;
$c_subdivision= isset($_POST['c_subdivision']) ? $_POST['c_subdivision']: false;
$c_num_export_conf= isset($_POST['c_num_export_conf']) ? $_POST['c_num_export_conf']: false;
$c_observaciones= isset($_POST['c_observaciones']) ? $_POST['c_observaciones']: false;

$c_numregistro_dest= isset($_POST['c_numregistro_dest']) ? $_POST['c_numregistro_dest']: false;
$c_nombre_dest= isset($_POST['c_nombre_dest']) ? $_POST['c_nombre_dest']: false;
$c_pais_dest= isset($_POST['c_pais_dest']) ? $_POST['c_pais_dest']: false;
$c_estado_dest= isset($_POST['c_estado_dest']) ? $_POST['c_estado_dest']: false;
$c_cp_dest= isset($_POST['c_cp_dest']) ? $_POST['c_cp_dest']: false;
$c_calle_dest= isset($_POST['c_calle_dest']) ? $_POST['c_calle_dest']: false;
$c_int_dest= isset($_POST['c_int_dest']) ? $_POST['c_int_dest']: false;
$c_ext_dest= isset($_POST['c_ext_dest']) ? $_POST['c_ext_dest']: false;

$c_numident= isset($_POST['c_numident']) ? $_POST['c_numident']: false;
$c_cantidad_aduana= isset($_POST['c_cantidad_aduana']) ? $_POST['c_cantidad_aduana']: false;
$c_valor_dolares= isset($_POST['c_valor_dolares']) ? $_POST['c_valor_dolares']: false;
$c_clave_aduana= isset($_POST['c_clave_aduana']) ? $_POST['c_clave_aduana']: false;
$c_fraccion_arancelaria= isset($_POST['c_fraccion_arancelaria']) ? $_POST['c_fraccion_arancelaria']: false;
$c_valor_unitario_aduana= isset($_POST['c_valor_unitario_aduana']) ? $_POST['c_valor_unitario_aduana']: false;
$c_unidad_aduana= isset($_POST['c_unidad_aduana']) ? $_POST['c_unidad_aduana']: false;
$c_Marca= isset($_POST['c_Marca']) ? $_POST['c_Marca']: false;
$c_sub_modelo= isset($_POST['c_sub_modelo']) ? $_POST['c_sub_modelo']: false;
$c_modelo= isset($_POST['c_modelo']) ? $_POST['c_modelo']: false;
$c_num_serie= isset($_POST['c_num_serie']) ? $_POST['c_num_serie']: false;

$c_numregistro_recep= isset($_POST['c_numregistro_recep']) ? $_POST['c_numregistro_recep']: false;
$c_residencia_recep= isset($_POST['c_residencia_recep']) ? $_POST['c_residencia_recep']: false;
$c_pais_recep= isset($_POST['c_pais_recep']) ? $_POST['c_pais_recep']: false;
$c_estado_recep= isset($_POST['c_estado_recep']) ? $_POST['c_estado_recep']: false;
$c_cp_recep= isset($_POST['c_cp_recep']) ? $_POST['c_cp_recep']: false;
$c_calle_recep= isset($_POST['c_calle_recep']) ? $_POST['c_calle_recep']: false;
$c_int_recep= isset($_POST['c_int_recep']) ? $_POST['c_int_recep']: false;
$c_ext_recep= isset($_POST['c_ext_recep']) ? $_POST['c_ext_recep']: false;

$c_pais_emisor= isset($_POST['c_pais_emisor']) ? $_POST['c_pais_emisor']: false;
$c_estado_emisor= isset($_POST['c_estado_emisor']) ? $_POST['c_estado_emisor']: false;
$c_cp_emisor= isset($_POST['c_cp_emisor']) ? $_POST['c_cp_emisor']: false;
$c_calle_emisor= isset($_POST['c_calle_emisor']) ? $_POST['c_calle_emisor']: false;
$c_int_emisor= isset($_POST['c_int_emisor']) ? $_POST['c_int_emisor']: false;
$c_ext_emisor= isset($_POST['c_ext_emisor']) ? $_POST['c_ext_emisor']: false;

$ce_details = isset($_POST['ce_details']) ? $_POST['ce_details']: false;
$ce_details1=json_decode($ce_details,TRUE); 

if(!$cliente || !$c_exportacion || !$serie_folio || !$forma_pago || !$cfdi_use || !$metodo_pago || !$moneda || !$tipo_cambio){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos".json_encode($detls)."","data"=>false));
    return;
}


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
$folio = getLastFolio();

$emisor = $fiscal['nombre_comercial'];
$rfc = $fiscal['rfc'];
$lugar_expedicion = $fiscal['cp'];
$version = "4.0";
$tipo_comprobante = "I";
$estado = "VIGENTE";
$timbrado = "TIMBRADO";

$fecha = date("Y-m-d H:i:s");



/* Insertar en tabla */
    $query="INSERT INTO facturas (emisor, rfc, version, uso_cfdi, enviado, serie, folio, uuid, fecha, venta_id, cliente_id, rfc_receptor, subtotal, importe, total, saldo, email, forma_pago, cuenta_pago,metodo_pago, tipoComprobante, moneda, tipoCambio, lugarExpedicion, observaciones, tipo_relacion, uuid_relacionados, estado, timbrado, c_exportacion, dom_receptor, nombre_receptor, regimen_fiscal_rec) VALUES ('$emisor', '$rfc', '$version', '$cfdi_use', '0', '$serie_folio', '$folio', '$uuid', '$fecha', '$venta_id', '$cliente', '$cliente_res[rfc]', '$subtotal', '$subtotal', '$total', '$total', '$cliente_res[email]', '$forma_pago', '$cuenta_pago', '$metodo_pago','$tipo_comprobante' ,'$moneda', '$tipo_cambio', '$lugar_expedicion', '$observaciones', '$tipo_relacion', '$uuid_relacionados', '$estado', '$timbrado', '$c_exportacion', '$cliente_res[cp]', '$cliente_res[cliente]', '$cliente_res[regimen_fiscal]')";
    $res=mysqli_query($conn,$query);

    if($res){

        
        $query1="SELECT MAX(id) as last_id FROM facturas";
        $res=mysqli_query($conn,$query1);

        $reg_ids=$row=mysqli_fetch_assoc($res);
        $data=$reg_ids['last_id'];


        foreach ($detalles as $v) {
            $v['factura']=$reg_ids['last_id'];

            $query = "SELECT * from productos where id='$v[producto]' limit 1";
            $res=mysqli_query($conn,$query);
        
            if($res){
                $row=mysqli_fetch_assoc($res);
            }
        
            $total = $v['taxIepsTotal']+$v['totalSub'];
            $query = "INSERT INTO facturas_detalle (factura_id, producto_id, cantidad, precio_neto, precio_unitario, tasaDescuentoProducto, importe, descuento, subtotal, tasa_iva, iva, tasa_ieps, ieps, total, clave_unidad, unidad, descripcion, c_objetoimp, c_claveprodserv) VALUES ('$v[factura]', '$v[producto]', '$v[cantidad]', '0','$v[preciou]', '0', '$v[totalSub]', '0', '$v[totalSub]', '$row[iva]', '0', '$row[ieps]', '$v[taxIepsTotal]', '$total', '$row[clave_unida]', '$row[unidad]', '$v[descripcion]', '$row[c_objetoimp]', '$row[clave]')";
            $res=mysqli_query($conn,$query);
        }

        //COMPLEMENTS
        if($c_type_of_operation){
            $query="insert into sat_ce (sale, type_of_operation, pediment_key, origin_certificate, incoterm, subdivision, num_export_conf, observations, destinary_register_num, destinary_name, destinary_country, destinary_state, destinary_pc, destinary_street, destinary_int, destinary_ext, products_id, products_tarrif_rate, aduana_cuantity, unitary_aduana_value, dollars_value, aduana_unity, aduana_key, products_brand, products_model, products_sub_model, products_serial_number, clients_register_number, clients_fiscal_residency, clients_country, clients_state, clients_pc, clients_street, clients_int, clients_ext, issuer_country, issuer_state, issuer_pc, issuer_street, issuer_int, issuer_ext) values ('$reg_ids[last_id]','$c_type_of_operation','$c_clave_pedimento','$c_cert_origen','$c_incoterm','$c_subdivision','$c_num_export_conf','$c_observaciones','$c_numregistro_dest','$c_nombre_dest','$c_pais_dest','$c_estado_dest','$c_cp_dest','$c_calle_dest','$c_int_dest','$c_ext_dest','$c_numident','$c_fraccion_arancelaria','$c_cantidad_aduana','$c_valor_unitario_aduana','$c_valor_dolares','$c_unidad_aduana','$c_clave_aduana','$c_Marca','$c_modelo','$c_sub_modelo','$c_num_serie','$c_numregistro_recep','$c_residencia_recep','$c_pais_recep','$c_estado_recep','$c_cp_recep','$c_calle_recep','$c_int_recep','$c_ext_recep','$c_pais_emisor','$c_estado_emisor','$c_cp_emisor','$c_calle_emisor','$c_int_emisor','$c_ext_emisor')";
            $res=mysqli_query($conn,$query);

            $query="SELECT MAX(id) as last_ids FROM sat_ce";
            $res=mysqli_query($conn,$query);
            
            $reg_ids=$row=mysqli_fetch_assoc($res);
            $ultimo_fracc=$reg_ids['last_ids'];
                if($ce_details1){
            
                    foreach($ce_details1 as $v) {
            
                        $query="insert into sat_ce_details (sat_ce, products_id, products_tarrif_rate, aduana_cuantity, unitary_aduana_value, dollars_value, aduana_unity, aduana_key) values ('$ultimo_fracc','$v[c_numident]','$v[c_fraccion_arancelaria]','$v[c_cantidad_aduana]','$v[c_valor_unitario_aduana]','$v[c_valor_dolares]','$v[c_unidad_aduana]','$v[c_clave_aduana]')";
                        $res=mysqli_query($conn,$query);
            
                    }
            
            
                }
            
        }


        echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>$data));
    }else{
        echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
    }




?>