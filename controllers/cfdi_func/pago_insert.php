<?php 
include("../../models/catalogs.php");

$cliente = isset($_POST['cliente']) ? $_POST['cliente']: false;
$forma_pago = isset($_POST['forma_pago']) ? $_POST['forma_pago']: false;
$moneda = isset($_POST['moneda']) ? $_POST['moneda']: false;
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones']: false;
$fecha = date("Y-m-d");
$serie = "CP";
$folio = getLastFolioP();

$facturas = isset($_POST['facturas']) ? $_POST['facturas']: false;
$facturas=json_decode($facturas,TRUE);  
$timestamp=!isset($timestamp) ? date("Y-m-d H:i:s",time()): date("Y-m-d H:i:s",time()); // only can be defined internally, not by http param

if(!$forma_pago || !$moneda){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos".json_encode($detls)."","data"=>false));
    return;
}


$json = array();
$pagos_rel = array();
$conn=superConn();


/* Insertar en tabla */
foreach($facturas as $v) {
    $pagos_rel[]=$v['factura'];
}
$pagos_rel=json_encode($pagos_rel);

foreach($facturas as $v) {
    if($v['importe_pago']>0){

        if($v['factura']){
            
            $query = "SELECT id,serie,folio from facturas where id='$v[factura]' limit 1";
            $res=mysqli_query($conn,$query);
            $row=mysqli_fetch_assoc($res);

            $filename=$row['serie'].$row['folio'].".xml";
            $xml_path="../../resources/storage/xml/".$filename;
        
        }
        
        // EXTRAER EL UUID
        $cfdi=array();
        if(file_exists($xml_path)){
            $cfdi=get_uuid($xml_path);		
        }
        $uuid_fact=$cfdi['cfdi']["uuid"];
        $query="insert into pagos_facturas (factura,cliente,folio,serie,method,import,date,comment,tipo_moneda,status,pagos_relacionados,uuid_factura,registred_on) values ('$v[factura]','$cliente','$folio','$serie','$forma_pago','$v[importe_pago]','$fecha','$observaciones','$moneda','1','','$uuid_fact','$timestamp')";
        $res=mysqli_query($conn,$query);
        //echo json_encode(array("status"=>2,"msg"=>"$query  Se guardo con exito","data"=>false));

        if($res){
            $query1="SELECT MAX(id) as last_id FROM pagos_facturas";
            $res=mysqli_query($conn,$query1);
    
            $reg_ids=$row=mysqli_fetch_assoc($res);
            $id_pagos[]=$reg_ids['last_id'];

            $query = "SELECT id,total,saldo from facturas where id='$v[factura]' limit 1";
            $res=mysqli_query($conn,$query);
        
            if($res){
                $row=mysqli_fetch_assoc($res);
                $residuary=$row['saldo']-$v['importe_pago'];
                $query="UPDATE facturas SET saldo='$residuary' WHERE id='$row[id]'";
                $res=mysqli_query($conn,$query);

            }

            //echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>false));
        }
        /* else{
            echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
        } */
        
    }
}

foreach ($id_pagos as &$valor) {
    //$impo_ieps +=$pagos_rel[$i]['ieps'];
    $pagos_id=json_encode($id_pagos);

    $query="UPDATE pagos_facturas SET pagos_relacionados='$pagos_id' WHERE id='$valor'";
    $res=mysqli_query($conn,$query);

}
echo json_encode(array("status"=>1,"msg"=>"Se aplico con exito","data"=>false));

?>