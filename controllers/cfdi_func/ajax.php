<?php 
include("../../models/catalogs.php");

$colony = isset($_POST['searchTerm']) ? $_POST['searchTerm']: false;
$colony2 = isset($_POST['colony2']) ? $_POST['colony2']: false;

$articleName = isset($_POST['articleName']) ? $_POST['articleName']: false;

$mun = isset($_POST['mun']) ? $_POST['mun']: false;
$loc = isset($_POST['mun']) ? $_POST['mun']: false;

$desc_art = isset($_POST['desc_art']) ? $_POST['desc_art']: false;

$cliente = isset($_POST['cliente']) ? $_POST['cliente']: false;
$cliente_res = isset($_POST['cliente_res']) ? $_POST['cliente_res']: false;

$uuid_folio = isset($_POST['uuid_folio']) ? $_POST['uuid_folio']: false;

$txt_cod_producto = isset($_POST['txt_cod_producto']) ? $_POST['txt_cod_producto']: false;

$referencia = isset($_POST['referencia']) ? $_POST['referencia']: false;
$referencia_res = isset($_POST['referencia_res']) ? $_POST['referencia_res']: false;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']: 0;
$filtro_fac = isset($_POST['filtro_fac']) ? $_POST['filtro_fac']: 0;
$filtro_trasl = isset($_POST['filtro_trasl']) ? $_POST['filtro_trasl']: 0;

$pagina_i = isset($_POST['pagina_i']) ? $_POST['pagina_i']: 0;
$pagina_limite = isset($_POST['pagina_limite']) ? $_POST['pagina_limite']: 0;

$filtro_truck = isset($_POST['filtro_truck']) ? $_POST['filtro_truck']: 0;
$filtro_driver = isset($_POST['filtro_driver']) ? $_POST['filtro_driver']: 0;

$filtro_cliente = isset($_POST['filtro_cliente']) ? $_POST['filtro_cliente']: 0;

$filtro_producto = isset($_POST['filtro_producto']) ? $_POST['filtro_producto']: 0;

$fraccion_ar = isset($_POST['fraccion_ar']) ? $_POST['fraccion_ar']: false;

$ce_pais = isset($_POST['ce_pais']) ? $_POST['ce_pais']: false;
$ce_pais_res = isset($_POST['ce_pais_res']) ? $_POST['ce_pais_res']: false;

$chofer_id = isset($_POST['chofer_id']) ? $_POST['chofer_id']: false;

$truck_id = isset($_POST['truck_id']) ? $_POST['truck_id']: false;

$producto_id = isset($_POST['producto_id']) ? $_POST['producto_id']: false;

$cliente_res_pago = isset($_POST['cliente_res_pago']) ? $_POST['cliente_res_pago']: false;

$pago_id = isset($_POST['pago_id']) ? $_POST['pago_id']: false;

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
$json = array();

$conn=superConn();

if($colony){
    
    $query = "SELECT * from sat_ce_codigo_p_cfdi where c_codigo_postal like '%$colony%' limit 20";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['id'], 'text'=>$row['c_codigo_postal']];
    }

    echo json_encode($json);
}

if($colony2){
    $query = "SELECT * from sat_ce_codigo_p_cfdi where c_codigo_postal like '%$colony2%' limit 20";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['id'], 'text'=>$row['c_codigo_postal']];
    }

    echo json_encode($json);
}


if($articleName){
    $query = "SELECT * from stock_catalog_articles where id = '%$articleName%' or name like '%$articleName%' and articles_fletes='0' limit 40";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['id'], 'text'=>$row['name']];
    }

    echo json_encode($json);
}


/* Traer descripcion de articulo */

if($desc_art){
    $query = "SELECT id,name,description from stock_catalog_articles where id = '$desc_art' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $json = $row['description'];
    

    echo json_encode($json);
}

if($cliente){
    $query = "SELECT id,cliente,rfc,email from clientes where id like '%$cliente%'  or cliente like '%$cliente%'";
    $res=mysqli_query($conn,$query);

    //$row=mysqli_fetch_assoc($res);
    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['id'], 'text'=>$row['cliente']];
    }
    

    $json[] = ['id'=>$row['id'], 'text'=>$row['cliente']];
    echo json_encode($json);
}

if($cliente_res){
    $query = "SELECT id,cliente,rfc,email from clientes where id = '$cliente_res' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    //$json = $row['description'];
    
    $json['id'] = $row['id'];
    $json['cliente'] = $row['cliente'];
    $json['rfc'] = $row['rfc'];
    $json['email'] = $row['email'];
    echo json_encode($json);
}


if($uuid_folio){

    function get_uuid1($xml_file_path){
    error_reporting(E_ERROR | E_PARSE);
        // $UUID="";
        if(file_exists($xml_file_path)){
        
        $xml_file = simplexml_load_file($xml_file_path); 
        if($xml_file){
            
        $ns = $xml_file->getNamespaces(true);
        $xml_file->registerXPathNamespace('c', $ns['cfdi']);
        $xml_file->registerXPathNamespace('t', $ns['tfd']);
    
        foreach ($xml_file->xpath('//t:TimbreFiscalDigital') as $tfd){
        $UUID=$tfd['UUID'];
        $UUID=(string)$UUID;
        }
        }
        }
        
        return $UUID;
        
    }


    $query="select id,serie,folio,uuid from facturas where id='$uuid_folio' limit 1";
    $res=mysqli_query($conn,$query);

    $data=array();
    if($res){

        while($row=mysqli_fetch_assoc($res)){
            $tmp = array();
        
            $tmp["id"]=$row["id"];
            $tmp["folio"]=$row["folio"];
            
                $filename=$row["serie"].$row["folio"].".xml";
                //$filename="WWWE607.xml";
        
                $xml_path="../../resources/storage/xml/".$filename;
                // EXTRAER EL UUID
                if(file_exists($xml_path)){
                    $tmp["uuid"]=get_uuid1($xml_path);		
                }
        
            
            $dataUuidCancel=$tmp;
        }

        $json[] = ['id'=>$dataUuidCancel['uuid'], 'text'=>$dataUuidCancel['uuid']];

        echo json_encode($json);
        //echo json_encode($dataUuidCancel);

    }

}

if($txt_cod_producto){
    $query = "SELECT id,codigo,producto from productos where id like '%$txt_cod_producto%' or producto like '%$txt_cod_producto%' limit 10";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['id'], 'text'=>$row['producto']];
    }
    
    echo json_encode($json);
}


if($referencia){
    $query = "SELECT id,referencia from ventas where referencia like '%$referencia%' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    //$json = $row['description'];
    

    $json[] = ['id'=>$row['id'], 'text'=>$row['referencia']];
    echo json_encode($json);
}

if($referencia_res){
    $query = "SELECT id,cliente_id from ventas where id = '$referencia_res' limit 1";
    $res=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($res);
    $venta=$row['id'];
    $cliente_id=$row['cliente_id'];

    /* detalle_venta */
    $query="SELECT * FROM venta_detalles where venta_id='$venta'";
    $res=mysqli_query($conn,$query);

	while($row=mysqli_fetch_assoc($res))
	$json['detalles']=$row;

    

    $query = "SELECT id,cliente,rfc,email from clientes where id = '$cliente_id' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    //$json = $row['description'];
    
    $json['id'] = $row['id'];
    $json['cliente'] = $row['cliente'];
    $json['rfc'] = $row['rfc'];
    $json['email'] = $row['email'];

    echo json_encode($json);
}

if($filtro){
    echo $filtro;
    $reg_ventas = getVentas($filtro,$pagina_limite,$pagina_i);

    $res_filtro= array();

    if($reg_ventas){

        foreach($reg_ventas as $_venta ){
            $res_filtro =  '<tr>
              <th class="align-middle text-center text-xs">'.$_venta['id'].' </th>
              <td class="text-xs">'.$_venta['fecha'].'</td>
              <td class="align-middle text-center text-xs">'.$_venta['cliente_id'].' </td>
              <td class="align-middle text-center text-xs">'.$_venta['tipo'].' </td>
              <td class="align-middle text-center text-xs">'.$_venta['referencia'].'</td>
              <td class="text-center text-xs">'.$_venta['estado_factura'].'</td>
              <td class="text-center text-xs">'.$_venta['importe'].'</td>
              <td class="text-center text-xs">'.$_venta['estado'].'</td>
              <td>
              <a href="../../ventas/view/?venta="'.$_venta['id'].' " style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>
              <!-- <a href="../../insert" style="font-size:.6rem;" type="button" class="btn btn-info btn-sm">agregar</a> -->
      
              <a href="../../facturas/insert/?venta="'.$_venta['id'].'" style="font-size:.6rem;" type="button" class="btn btn-warning btn-sm ml-2">Facturar</a>
      
              </td>
          </tr>';
          echo $res_filtro;
      
          }

    }else{
        $res_filtro =  '<tr>
              <th colspan="10" class="align-middle text-center text-xs"> Sin coincidencias </th>
          </tr>';
          echo $res_filtro;

    }

    
}

if($filtro_fac){

    $reg_ventas = getfacturas($filtro_fac,$pagina_limite,$pagina_i);
    $files = get_files_res();

    $res_filtro= array();

    if($reg_ventas){

        foreach($reg_ventas as $r_factura ){
            echo '
            <tr>
                <th class="align-middle text-center text-xs">'.$r_factura['id'].'</th>
                <td class="text-center text-xs">'.$r_factura['fecha'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['cliente_id'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['serie'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['folio'].'</td>
                <td class="text-center text-xs">'.$r_factura['venta_id'].'</td>
                <td class="text-center text-xs">'.$r_factura['importe'].'</td>
                <td class="text-center text-xs">'.$r_factura['estado'].'</td>
                <td>
                <a href="../../facturas/view/?factura='.$r_factura['id'].'" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>
                <a href="../../../resources/pdf/?factura='.$r_factura['id'].'" target="_blank" style="font-size:.6rem; background-color:#B20000; color:#ffffff;" type="button" class="btn btn-sm">PDF</a>';

                
                    $xml_path = in_array($r_factura['serie'].$r_factura['folio'].".xml", $files,false);
                    $xml = strtoupper($r_factura['serie']).$r_factura['folio'].".xml";
                if($xml_path){
                    echo  '<button onclick="abri_xml("'.$xml.'")"  style="font-size:.6rem;" type="button" class="btn btn-success btn-sm">XML</button>';

                    if($r_factura['timbrado']=="PENDIENTE"){
                        echo  '<input type="hidden" class="factura" name="factura" value="'.$r_factura['id'].'">
                        <input type="hidden" class="folio_xml" name="folio_xml" value="'.$r_factura['serie'].$r_factura['folio'].'">
                        <button id="get_xml" onclick="timbrar(this)" style="font-size:.6rem;" type="button" class="btn btn-danger btn-sm">Timbrar</button>';

                    }
                }

                else{
                    echo '<input type="hidden" class="factura" name="factura" value="'.$r_factura['id'].'">
                    <input type="hidden" class="folio_xml" name="folio_xml" value="'.$r_factura['serie'].$r_factura['folio'].'">
                    <button id="get_xml" onclick="timbrar(this)" style="font-size:.6rem;" type="button" class="get_xml btn btn-warning btn-sm">generar</button>';
                }

                echo ' </td>';
                echo '</tr>';
          //echo $res_filtro;
      
          }

    }else{
        $res_filtro =  '<tr>
              <th colspan="10" class="align-middle text-center text-xs"> Sin coincidencias </th>
          </tr>';
          echo $res_filtro;

    }
    //echo $reg_ventas;

    
}

if($filtro_trasl){
    //echo $filtro_trasl;
    $reg_ventas = getTraslados($filtro_trasl,$pagina_limite,$pagina_i);
    $files = get_files_res();

    $res_filtro= array();

    if($reg_ventas){

        foreach($reg_ventas as $r_factura ){
           echo '<tr>
                <th class="align-middle text-center text-xs">'.$r_factura['id'].'</th>
                <td class="text-center text-xs">'.$r_factura['fecha'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['rem_id'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['serie'].'</td>
                <td class="align-middle text-center text-xs">'.$r_factura['folio'].'</td>
                <td class="text-center text-xs">'.$r_factura['factura_id'].'</td>
                <td class="text-center text-xs">'.$r_factura['importe'].'</td>
                <td class="text-center text-xs">'.$r_factura['dest_id'].'</td>
                <td>
                <a href="../../traslados/view/?traslado='.$r_factura['id'].'" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>';


                    $xml_path = in_array($r_factura['serie'].$r_factura['folio'].".xml", $files,false);
                    $xml = $r_factura['serie'].$r_factura['folio'].".xml";

                if($xml_path){

                    echo '<button onclick="abri_xml("'.$xml.'")"  style="font-size:.6rem;" type="button" class="btn btn-success btn-sm">XML</button>';
                    if($r_factura['timbrado']=="PENDIENTE"){

                        echo '<input type="hidden" class="factura" name="factura" value="'.$r_factura['id'].'">
                        <input type="hidden" class="folio_xml" name="folio_xml" value="'.$r_factura['serie'].$r_factura['folio'].'">
                        <button id="get_xml" onclick="timbrar(this)" style="font-size:.6rem;" type="button" class="btn btn-danger btn-sm">Timbrar</button>';

                    }


                }

                    
                else{
                    echo '<input type="hidden" class="factura" name="factura" value="'.$r_factura['id'].'">
                    <input type="hidden" class="folio_xml" name="folio_xml" value="'.$r_factura['serie'].$r_factura['folio'].'">
                    <button id="get_xml" onclick="timbrar(this)"  style="font-size:.6rem;" type="button" class="get_xml btn btn-warning btn-sm">generar</button>';
                

                }

                echo '</td>';
           echo '</tr>';
          //echo $res_filtro;
      
          }

    }else{
        $res_filtro =  '<tr>
              <th colspan="10" class="align-middle text-center text-xs"> Sin coincidencias </th>
          </tr>';
          echo $res_filtro;

    }

    
}


if($filtro_truck){
    //echo $filtro_trasl;
    $reg_trucks = getTrucks($filtro_truck,$pagina_limite,$pagina_i);

    $res_filtro= array();

    if($reg_trucks){

        foreach($reg_trucks as $r_truck ){

           echo ' <tr>
            <th class="align-middle text-center text-xs">'. $r_truck['id'].'</th>
            <td class="align-middle text-center text-xs">'. $r_truck['number'].'</td>
            <td class="align-middle text-center text-xs">'. $r_truck['name'].'</td>
            <td class="align-middle text-center text-xs">'. $r_truck['plaque'].'</td>
            <td class="text-center text-xs">'. $r_truck['year'].'</td>
            <td class="text-center text-xs">'. $r_truck['model'].'</td>
            <td class="text-center text-xs">'. $r_truck['brand'].'</td>
            <td>
            <a href="../../camiones/view/?camion="'. $r_truck['id'].'" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>

            </td>
        </tr>';

        }

    }
}

if($filtro_driver){
    //echo $filtro_trasl;
    $reg_drivers = getDrivers($filtro_driver,$pagina_limite,$pagina_i);

    $res_filtro= array();

    if($reg_drivers){

        foreach($reg_drivers as $r_driver ){

           echo ' <tr>
            <th class="align-middle text-center text-xs">'. $r_driver['id'].'</th>
            <td class="align-middle text-center text-xs">'. $r_driver['name'].'</td>
            <td class="align-middle text-center text-xs">'. $r_driver['rfc'].'</td>
            <td class="align-middle text-center text-xs">'. $r_driver['license'].'</td>
            <td class="text-center text-xs">'. $r_driver['codigo_postal'].'</td>
            <td class="text-center text-xs">'. $r_driver['phone'].'</td>
            <td>
            <a href="../../choferes/view/?chofer="'. $r_driver['id'].'" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>

            </td>
        </tr>';

        }

    }
}

if($filtro_cliente){
    //echo $filtro_trasl;
    $reg_clientes = getClients($filtro_cliente,$pagina_limite,$pagina_i);

    $res_filtro= array();

    if($reg_clientes){

        foreach($reg_clientes as $r_cliente ){

           echo ' <tr>
            <th class="align-middle text-center text-xs">'. $r_cliente['id'].'</th>
            <td class="align-middle text-center text-xs">'. $r_cliente['cliente'].'</td>
            <td class="align-middle text-center text-xs">'. $r_cliente['rfc'].'</td>
            <td class="align-middle text-center text-xs">'. $r_cliente['codigo'].'</td>
            <td class="text-center text-xs">'. $r_cliente['precio'].'</td>
            <td class="text-center text-xs">'. $r_cliente['contacto'].'</td>
            <td class="text-center text-xs">'. $r_cliente['celular'].'</td>

        </tr>';

        }

    }
}


if($filtro_producto){
    //echo $filtro_trasl;
    $reg_productos = getProductos($filtro_producto,$pagina_limite,$pagina_i);

    $res_filtro= array();

    if($reg_productos){

        foreach($reg_productos as $r_pro ){

           echo ' <tr>
            <th class="align-middle text-center text-xs">'. $r_pro['id'].'</th>
            <td class="align-middle text-center text-xs">'. $r_pro['producto'].'</td>
            <td class="align-middle text-center text-xs">'. $r_pro['codigo'].'</td>
            <td class="align-middle text-center text-xs">'. $r_pro['clave'].'</td>
            <td class="text-center text-xs">'. $r_pro['proveedor'].'</td>
            <td class="text-center text-xs">'. $r_pro['estado'].'</td>
            <td>
            <a href="../../procudtos/view/?producto="'. $r_pro['id'].'" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>

            </td>
        </tr>';

        }

    }
}



if($fraccion_ar){
    $query="select clave,name from sat_ce_tariff_fraction where clave like '%$fraccion_ar%' or name like '%$fraccion_ar%' order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['clave'], 'text'=>$row['name']];
    }
    
    echo json_encode($json);
}


if($ce_pais){
    $conn=superConn();

    /* cfdi use */
    $query="select id,name,clavesat from world_region_country where clavesat like '%$ce_pais%' or name like '%$ce_pais%'";
    $res=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['clavesat'], 'text'=>$row['name']];
    }
    
    echo json_encode($json);
}

if($ce_pais_res){

    $query = "SELECT * from world_region_country where clavesat = '$ce_pais_res' limit 1";
    $res=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($res);
    $pais_sel=$row['id'];

    $query = "SELECT * from world_region_state where country = '$pais_sel'";
    $res=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['clavesat'], 'text'=>$row['name']];
    }

    echo json_encode($json);
}

if($chofer_id){
    $get_chofer = getDriver1($chofer_id);

        
    $json['id'] = $get_chofer['id'];
    $json['nombre'] = $get_chofer['name'];
    $json['rfc'] = $get_chofer['rfc'];
    $json['numero_ext'] = $get_chofer['numero_ext'];
    $json['telefono'] = $get_chofer['phone'];
    $json['license'] = $get_chofer['license'];
    $json['calle'] = $get_chofer['calle'];
    $json['codigo_postal'] = $get_chofer['codigo_postal'];
    $json['referencia'] = $get_chofer['reference'];
    $json['unidad'] = $get_chofer['truck'];

    echo json_encode($json);
}

if($truck_id){
    $get_truck = getTruck($truck_id);

        
    $json['id'] = $get_truck['id'];
    $json['nombre'] = $get_truck['name'];
    $json['number'] = $get_truck['number'];
    $json['brand'] = $get_truck['brand'];
    $json['model'] = $get_truck['model'];
    $json['year'] = $get_truck['year'];
    $json['serie'] = $get_truck['serie'];
    $json['plaque'] = $get_truck['plaque'];
    $json['nombre_aseg'] = $get_truck['nombre_aseg'];
    $json['num_poliza_seguro'] = $get_truck['num_poliza_seguro'];

    $json['num_permiso_sct'] = $get_truck['num_permiso_sct'];
    $json['permiso_sct'] = $get_truck['perm_sct'];
    $json['config_vehicular'] = $get_truck['config_vehicular'];

    $json['capacity_cubic_meter'] = $get_truck['capacity_cubic_meter'];
    $json['capacity_tonne'] = $get_truck['capacity_tonne'];
    $json['diesel_performance'] = $get_truck['diesel_performance'];

    echo json_encode($json);
}

if($producto_id){
    $get_producto = getProducto($producto_id);

        
    $json['id'] = $get_producto['id'];
    $json['codigo'] = $get_producto['codigo'];
    $json['barras'] = $get_producto['barras'];
    $json['proveedor'] = $get_producto['proveedor'];
    $json['producto'] = $get_producto['producto'];
    $json['ieps'] = $get_producto['ieps'];
    $json['iva'] = $get_producto['iva'];
    $json['inventario'] = $get_producto['inventario'];
    $json['stock'] = $get_producto['stock'];
    $json['estado'] = $get_producto['estado'];

    echo json_encode($json);
}

if($cliente_res_pago){
    $query = "SELECT id,fecha,total,saldo from facturas where cliente_id = '$cliente_res_pago' and saldo >'0' and metodo_pago='PPD' and estado='VIGENTE' and timbrado='TIMBRADO'";
    $res=mysqli_query($conn,$query);

    if($res){

        while($row=mysqli_fetch_assoc($res)){
            //$facturas_cliente[]=$row;
        /* }

        foreach($facturas_cliente as $f_cliente ){ */

            $detalleTabla[]='<tr>
            <th class="factura align-middle text-center text-xs">'. $row['id'].'</th>
            <td class="align-middle text-center text-xs">'. $row['fecha'].'</td>
            <td class="align-middle text-center text-xs">'. $row['saldo'].'</td>
            <td class="importe_factura align-middle text-center text-xs"><input type="text" value="'. $row['saldo'].'"></td>
            
        </tr>';

        }

        echo json_encode($detalleTabla);

    }
}

if($pago_id){
    $get_pago = getPago1($pago_id);

        
    $json['id'] = $get_pago['id'];
    $json['factura'] = $get_pago['factura'];
    $json['method'] = $get_pago['method'];
    $json['import'] = $get_pago['import'];
    $json['fecha'] = $get_pago['date'];
    $json['comment'] = $get_pago['comment'];
    $json['tipo_moneda'] = $get_pago['tipo_moneda'];
    $json['cliente'] = $get_pago['cliente_res']['cliente'];

    echo json_encode($json);
}

?>