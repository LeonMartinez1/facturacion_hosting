<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();

include("conn.php");

function fiscalName(){

    $conn=superConn();
    $query="SELECT * FROM empresa where id='1' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row;


return $data;

}

function getLastFolio(){
    $conn=superConn();

    $query1="SELECT MAX(id) as last_id FROM facturas";
    $res=mysqli_query($conn,$query1);

    $row1=mysqli_fetch_assoc($res);

    $query="SELECT folio FROM facturas where id='$row1[last_id]' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row['folio']+1;

    return $data;
}

function getLastFolioT(){
    $conn=superConn();

    $query1="SELECT MAX(id) as last_id FROM traslados";
    $res=mysqli_query($conn,$query1);

    $row1=mysqli_fetch_assoc($res);

    $query="SELECT folio FROM traslados where id='$row1[last_id]' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row['folio']+1;

    return $data;
}

function getLastFolioP(){
    $conn=superConn();

    $query1="SELECT MAX(id) as last_id FROM pagos_facturas";
    $res=mysqli_query($conn,$query1);

    $row1=mysqli_fetch_assoc($res);

    $query="SELECT folio FROM pagos_facturas where id='$row1[last_id]' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row['folio']+1;

    return $data;
}

function getVentas($filtro,$limite,$paginaI){

		$conn=superConn();

        if($filtro!="empty"){

            $query="SELECT * FROM ventas where factura = '1' and tipo like '%$filtro%' or cliente_id like '%$filtro%' or referencia like '%$filtro%' or fecha like '%$filtro%' or referencia like '%$filtro%' or estado_factura like '%$filtro%' or importe like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
		    $res=mysqli_query($conn,$query);
            

        }else{
            $query="SELECT * FROM ventas where factura = '1' ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
            $res=mysqli_query($conn,$query);
            
        }
		

		while($row=mysqli_fetch_assoc($res))
		$data[]=$row;


        return $data;
	
}

function getVentasPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM ventas where factura = '1' and tipo like '%$filtro%' or cliente_id like '%$filtro%' or referencia like '%$filtro%' or fecha like '%$filtro%' or referencia like '%$filtro%' or estado_factura like '%$filtro%' or importe like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM ventas where factura = '1'";
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}


function getVenta($venta){

    $conn=superConn();
    $query="SELECT * FROM ventas where id='$venta' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row;

    $res_detalle=getVentaDetalle($venta);

	$data['detalles']=$res_detalle;


return $data;

}

function getVentaDetalle($venta){

    $conn=superConn();
    $query="SELECT * FROM venta_detalles where venta_id='$venta'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}


function getfacturas($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM facturas where serie like '%$filtro%' or cliente_id like '%$filtro%' or folio like '%$filtro%' or fecha like '%$filtro%' or venta_id like '%$filtro%' or estado like '%$filtro%' or importe like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM facturas ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}

function getfacturasPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM facturas where serie like '%$filtro%' or cliente_id like '%$filtro%' or folio like '%$filtro%' or fecha like '%$filtro%' or venta_id like '%$filtro%' or estado like '%$filtro%' or importe like '%$filtro%' order by id desc limit 10";
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM facturas ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}

function getFactura($factura){

    $conn=superConn();
    $query="SELECT * FROM facturas where id='$factura' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row;


    $query="select * from sat_ce where sale='$factura'";	
	$res=mysqli_query($conn,$query);
	if($res){

	while ($row_complement=mysqli_fetch_assoc($res))
	$data["complement_export"]=$row_complement;

	}
	if($data['complement_export']['id']){
        $res_detalle=setFacturaDetalle($factura);

	    $data['detalles']=$res_detalle;

        $query="select * from sat_ce_details where sat_ce='".$data['complement_export']['id']."'";	
        $res=mysqli_query($conn,$query);
        if($res){
        while ($row_complement=mysqli_fetch_assoc($res))
        $data["complement_export_articles"][]=$row_complement;
        }

    }else{
        $res_detalle=setFacturaDetalle($factura);

	    $data['detalles']=$res_detalle;
    }

    $res_empresa=fiscalName();
    $data['empresa']=$res_empresa;



return $data;

}

function getFacturaXml($factura){

    $conn=superConn();
    $query="SELECT serie,folio FROM facturas where id='$factura' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row['serie'].$row['folio'];

return $data;

}


function setFactura($venta){

    $conn=superConn();
    $query="SELECT * FROM facturas where factura_id='$venta' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row;

	$res_detalle=setFacturaDetalle($venta);

	$data['detalles']=$res_detalle;


return $data;

}

function setFacturaDetalle($factura){

    $conn=superConn();
    $query="SELECT * FROM facturas_detalle where factura_id='$factura'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function get_files(){


    if ($handle2 = opendir("../../../resources/storage/xml/")){
            
        while (false !== ($entry2 = readdir($handle2))) {
                if ($entry2!="." && $entry2!=".."){
                    
                        $regs[]=$entry2;  
                }
        
        }

        return $regs;
    }   

}

function get_filesT(){


    if ($handle2 = opendir("../../../resources/storage/xml/traslados/")){
            
        while (false !== ($entry2 = readdir($handle2))) {
                if ($entry2!="." && $entry2!=".."){
                    
                        $regs[]=$entry2;  
                }
        
        }

        return $regs;
    }   

}

function get_filesP(){


    if ($handle2 = opendir("../../../resources/storage/xml/pagos")){
            
        while (false !== ($entry2 = readdir($handle2))) {
                if ($entry2!="." && $entry2!=".."){
                    
                        $regs[]=$entry2;  
                }
        
        }

        return $regs;
    }   

}

function get_files_res(){


    if ($handle2 = opendir("../../resources/storage/xml/")){
            
        while (false !== ($entry2 = readdir($handle2))) {
                if ($entry2!="." && $entry2!=".."){
                    
                        $regs[]=$entry2;  
                }
        
        }

        return $regs;
    }   

}


function getAppliance(){

    $conn=superConn();

    //appliances
    $query="select id,number from catalog_truck";
    $res=mysqli_query($conn,$query);
    //die(json_encode($query));
    if($res){
        while($row=mysqli_fetch_assoc($res))
		$data[]=$row;
        
    }
	


return $data;

}


function getRem(){

    $conn=superConn();

    /* Remolques */
    $tipoRem= array();
    $query="select * from container_catalog";
    $res=mysqli_query($conn,$query);
    if($res){
        while($row=mysqli_fetch_assoc($res))
        $data[]=$row;
        
    }
    
return $data;

}

function getDriver(){

    $conn=superConn();

    /* drivers */
    $query="select id,name from catalog_driver";
    $res=mysqli_query($conn,$query);
    if($res){
        while($row=mysqli_fetch_assoc($res))
        $data[]=$row;
        
    }
    
return $data;

}

function setTimbradoTrue($factura){

    $conn=superConn();

    /* drivers */
    $query="UPDATE facturas SET timbrado='TIMBRADO' WHERE id='$factura'";
    $res=mysqli_query($conn,$query);
    if($res){
        $data=1;
        
    }else{
        $data = 0;
    }
    
return $data;

}

function setTimbradoFalse($factura){

    $conn=superConn();

    /* drivers */
    $query="UPDATE facturas SET timbrado='PENDIENTE' WHERE id='$factura'";
    $res=mysqli_query($conn,$query);
    if($res){
        $data=1;
        
    }else{
        $data = 0;
    }
    
return $data;

}

function getRegimen(){

    $conn=superConn();
    $query="SELECT * FROM sat_regimen_fiscal";
    $res=mysqli_query($conn,$query);
	if($res){
        while($row=mysqli_fetch_assoc($res))
        $data[]=$row;
        
    }

return $data;

}

function getUseCfdi(){
    $conn=superConn();

    /* cfdi use */
    $query="select id,clave,description from sat_cfdi_use";
    $res=mysqli_query($conn,$query);
    if($res){
        while($row=mysqli_fetch_assoc($res))
        $data[]=$row;
        
    }
    
return $data;
}
function getUseCfdiPdf($id_cfdi_use){
    $conn=superConn();

    /* cfdi use */
    $query="SELECT * FROM sat_cfdi_use where clave='$id_cfdi_use' limit 1";
    $res=mysqli_query($conn,$query);
    
    if($res){
        $row=mysqli_fetch_assoc($res);
        $data=$row;
        
    }
    
return $data;
}

function getFormaPago(){
    $conn=superConn();

    /* cfdi use */
    $query="select id,clave,descripcion from forma_pago";
    $res=mysqli_query($conn,$query);
    if($res){
        while($row=mysqli_fetch_assoc($res))
        $data[]=$row;
        
    }
    
return $data;
}

function getFormaPagoPdf($id_forma){
    $conn=superConn();

    /* cfdi use */
    $query="SELECT * FROM forma_pago where clave='$id_forma' limit 1";
    $res=mysqli_query($conn,$query);
    
    if($res){
        $row=mysqli_fetch_assoc($res);
        $data=$row;
        
    }
    
return $data;
}

function getMetodoPago(){
    $conn=superConn();

    $data=array("Pago en una sola exhibición"=>"PUE","Pago en parcialidades o diferido"=>"PPD");
    
return $data;
}

function getExportacion(){
    $conn=superConn();

    $data=array("No aplica."=>"01","Definitiva."=>"02","Temporal."=>"03");
    
return $data;
}

function getMoneda(){
    $conn=superConn();

    $data=array("MXN - Peso mexicano"=>"MXN","USD - Dolar americano"=>"USD");
    
return $data;
}


/* =========== Traslados ========== */
function getTraslados($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM traslados where serie like '%$filtro%' or rem_id like '%$filtro%' or folio like '%$filtro%' or fecha like '%$filtro%' or factura_id like '%$filtro%' or importe like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM traslados ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);    
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}


function getTrasldosPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM traslados where serie like '%$filtro%' or rem_id like '%$filtro%' or folio like '%$filtro%' or fecha like '%$filtro%' or factura_id like '%$filtro%' or importe like '%$filtro%' order by id desc limit 10";
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM traslados ORDER BY id DESC limit 40";
        $res=mysqli_query($conn,$query);    
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}


function getTraslado($factura){

    $conn=superConn();
    $query="SELECT * FROM traslados where id='$factura' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row;
    $rem_id=$row['rem_id'];
    $dest_id=$row['dest_id'];
    $appliance=$row['appliance'];
    $driver=$row['driver'];
    $type_rem=$row['type_rem'];

    $res_detalle=setTrasladoDetalle($factura);

    $res_rem=setTrasladoRem($rem_id);
    $res_dest=setTrasladoDest($dest_id);
    $res_appliance=setTrasladoApliance($appliance);
    $res_driver=setTrasladoDriver($driver);
    $res_type_rem=setTrasladoTipoRem($type_rem);

	$data['detalles']=$res_detalle;
    $data['rem']=$res_rem;
    $data['dest']=$res_dest;

    $data['appliance']=$res_appliance;
    $data['driver']=$res_driver;
    $data['type_rem']=$res_type_rem;

    $query = "select id,c_localidad,description from sat_ce_localidad WHERE id ='$row[rem_localidad]' limit 1";
    $res=mysqli_query($conn,$query);
    $row_rem_loc = mysqli_fetch_assoc($res);
    $data['rem_localidad']=$row_rem_loc['c_localidad'];

    $query = "select id,c_municipio,description from sat_ce_municipio WHERE id ='$row[rem_municipio]' limit 1";
    $res=mysqli_query($conn,$query);
    $row_rem_mun = mysqli_fetch_assoc($res);
    $data['rem_municipio']=$row_rem_mun['c_municipio'];


    /* Destinatario */

    $query = "select id,c_localidad,description from sat_ce_localidad WHERE id ='$row[dest_localidad]' limit 1";
    $res=mysqli_query($conn,$query);
    $row_dest_loc = mysqli_fetch_assoc($res);
    $data['dest_localidad']=$row_dest_loc['c_localidad'];

    $query = "select id,c_municipio,description from sat_ce_municipio WHERE id ='$row[dest_municipio]' limit 1";
    $res=mysqli_query($conn,$query);
    $row_dest_mun = mysqli_fetch_assoc($res);
    $data['dest_municipio']=$row_dest_mun['c_municipio'];

    $res_empresa=fiscalName();
    $data['empresa']=$res_empresa;


return $data;

}

function setTrasladoDetalle($factura){

    $conn=superConn();
    $query="SELECT * FROM traslados_detalle where factura_id='$factura'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function setTrasladoRem($cliente_id){

    $conn=superConn();
    $query="SELECT * FROM clientes where id='$cliente_id' limit 1";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function setTrasladoDest($cliente_id){

    $conn=superConn();
    $query="SELECT * FROM clientes where id='$cliente_id'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function setTrasladoApliance($appliance){

    $conn=superConn();
    $query="SELECT * FROM catalog_truck where id='$appliance'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function setTrasladoDriver($driver){

    $conn=superConn();
    $query="SELECT name,rfc,license FROM catalog_driver where id='$driver'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}

function setTrasladoTipoRem($type_rem){

    $conn=superConn();
    $query="SELECT * FROM container_catalog where id='$type_rem'";
    $res=mysqli_query($conn,$query);


	while($row=mysqli_fetch_assoc($res))
		$data[]=$row;



return $data;

}



function getTrasladoXml($factura){

    $conn=superConn();
    $query="SELECT serie,folio FROM traslados where id='$factura' limit 1";
    $res=mysqli_query($conn,$query);

    $row=mysqli_fetch_assoc($res);
    $data=$row['serie'].$row['folio'];

return $data;

}

function setTimbradoTfalse($traslado){

    $conn=superConn();

    /* drivers */
    $query="UPDATE traslados SET timbrado='PENDIENTE' WHERE id='$traslado'";
    $res=mysqli_query($conn,$query);
    if($res){
        $data=1;
        
    }else{
        $data = 0;
    }
    
return $data;

}


function getIncoterm(){

    $conn=superConn();

    $query="select clave,name from sat_ce_incoterm order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getTipoOp(){

    $conn=superConn();

    //get tipo operacion

    $query="select clave,name from sat_ce_operation_type order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getTariff(){

    $conn=superConn();

    //tariff fraction
    $query="select clave,name from sat_ce_tariff_fraction order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getPedimentCode(){

    $conn=superConn();

    //get clave de pedimento

    $query="select clave,name from sat_ce_pediment_code order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getAduanaUnid(){

    $conn=superConn();

    $query="select clave,name from sat_ce_unity_aduana";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getTrucks($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM catalog_truck where name like '%$filtro%' or brand like '%$filtro%' or number like '%$filtro%' or plaque like '%$filtro%' or model like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM catalog_truck ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getTrucksPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM catalog_truck where name like '%$filtro%' or brand like '%$filtro%' or number like '%$filtro%' or plaque like '%$filtro%' or model like '%$filtro%' order by id desc limit 10";
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM catalog_truck ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}

function getTruck($truck_id){

    $conn=superConn();
    $query="SELECT * FROM catalog_truck where id='$truck_id'";
    $res=mysqli_query($conn,$query);


	$row=mysqli_fetch_assoc($res);
	$data=$row;



return $data;

}


function getDrivers($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM catalog_driver where name like '%$filtro%' or rfc like '%$filtro%' or codigo_postal like '%$filtro%' or license like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM catalog_driver ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getDriversPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM catalog_driver where name like '%$filtro%' or rfc like '%$filtro%' or codigo_postal like '%$filtro%' or license like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM catalog_driver ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getDriver1($driver_id){

    $conn=superConn();
    $query="SELECT * FROM catalog_driver where id='$driver_id'";
    $res=mysqli_query($conn,$query);


	$row=mysqli_fetch_assoc($res);
	$data=$row;



return $data;

}

function getClients($filtro,$limite,$paginaI){

    $conn=superConn();
    if($filtro!="empty"){

        $query="SELECT * FROM clientes where cliente like '%$filtro%' or codigo like '%$filtro%' or rfc like '%$filtro%' or cp like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM clientes ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getClientsArray(){

    $conn=superConn();

    $query="SELECT * FROM clientes";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[$row["cliente"]]=$row["id"];
    //$data[]=$row;
    
return $data;

}

function getClientsPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM clientes where cliente like '%$filtro%' or codigo like '%$filtro%' or rfc like '%$filtro%' or cp like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM clientes ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}



function getProductos($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM productos where producto like '%$filtro%' or codigo like '%$filtro%' or clave like '%$filtro%' or proveedor like '%$filtro%' or estado like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM productos ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getProductosPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM productos where producto like '%$filtro%' or codigo like '%$filtro%' or clave like '%$filtro%' or proveedor like '%$filtro%' or estado like '%$filtro%' order by id desc limit 10";
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM productos ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }


    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;


return $data;

}

function getProducto($producto_id){

    $conn=superConn();
    $query="SELECT * FROM productos where id='$producto_id'";
    $res=mysqli_query($conn,$query);


	$row=mysqli_fetch_assoc($res);
	$data=$row;



return $data;

}

function getConfV(){

    $conn=superConn();

    //get clave de pedimento

    $query="select clave,description from sat_ce_conf_autotransporte order by id asc";
    $res=mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function get_uuid($xml_file_path){
    error_reporting(E_ERROR | E_PARSE);
        // $UUID="";
        if(file_exists($xml_file_path)){
        
        $xml_file = simplexml_load_file($xml_file_path); 
            if($xml_file){
                
            $ns = $xml_file->getNamespaces(true);
            $xml_file->registerXPathNamespace('c', $ns['cfdi']);
            $xml_file->registerXPathNamespace('t', $ns['tfd']);
            $CFDI=array();

                foreach ($xml_file->xpath('//c:Comprobante') as $cfdi){
                    $CFDI["cfdi"]['n_certificado_comp']=$cfdi['NoCertificado'];
                }
                foreach ($xml_file->xpath('//t:TimbreFiscalDigital') as $tfd){
                $CFDI["cfdi"]['uuid']=$tfd['UUID'];
                $CFDI["cfdi"]['fecha_timbre']=$tfd['FechaTimbrado'];
                $CFDI["cfdi"]['version_sat']=$tfd['Version'];
                $CFDI["cfdi"]['n_Cert_sat']=$tfd['NoCertificadoSAT'];
                $CFDI["cfdi"]['sello_cfd_sat']=$tfd['SelloCFD'];
                $CFDI["cfdi"]['sello_sat']=$tfd['SelloSAT'];
                $UUID=$tfd['UUID'];
                $UUID=(string)$UUID;
                }

                foreach ($xml_file->xpath('//c:Emisor') as $cfdi){
					$CFDI["cfdi"]['emisor_rfc']=$cfdi['Rfc'];
                    $CFDI["cfdi"]['emisor_rfc']=$cfdi['Rfc'];
					//$CFDI["cfdi"]=(string)$VERSION_CFDI;
				}
                foreach ($xml_file->xpath('//c:Receptor') as $cfdi){
					$CFDI["cfdi"]['receptor_rfc']=$cfdi['Rfc'];
				}

                foreach ($xml_file->xpath('//c:Impuestos') as $cfdi){
					$CFDI["cfdi"]['total_traslado']=$cfdi['TotalImpuestosTrasladados'];
				}
            }
        }
        
        return $CFDI;
        
}

function getPagos($filtro,$limite,$paginaI){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM pagos_facturas where factura like '%$filtro%' or import like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM pagos_facturas ORDER BY id DESC limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}

function getPagosPag($filtro){

    $conn=superConn();

    if($filtro!="empty"){

        $query="SELECT * FROM pagos_facturas where factura like '%$filtro%' or import like '%$filtro%' order by id desc limit " . (($paginaI - 1) * $limite)  . "," . $limite;
        $res=mysqli_query($conn,$query);
        

    }else{
        $query="SELECT * FROM pagos_facturas ORDER BY id DESC";
        $res=mysqli_query($conn,$query);
        
    }

    while($row=mysqli_fetch_assoc($res))
    $data[]=$row;
    
return $data;

}
function getPago1($pago_id){

    $conn=superConn();
    $query="SELECT * FROM pagos_facturas where id='$pago_id'";
    $res=mysqli_query($conn,$query);
	$row=mysqli_fetch_assoc($res);
	$data=$row;
    $pagos_relacionados=$row['pagos_relacionados'];

    $fiscal_n=fiscalName();
    $data['fiscal_n']=$fiscal_n;

    $query = "select * from clientes WHERE id ='$row[cliente]' limit 1";
    $res=mysqli_query($conn,$query);
    $cliente = mysqli_fetch_assoc($res);
    $data['cliente_res']=$cliente;

    
    $pagos_rel=json_decode($pagos_relacionados,TRUE); 
    

    foreach ($pagos_rel as &$valor) {
        //$impo_ieps +=$pagos_rel[$i]['ieps'];

        $query="SELECT * FROM pagos_facturas where id='$valor'";
        $res=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($res);
        $data['payment_relations'][]=$row;
    }


return $data;

}


?>