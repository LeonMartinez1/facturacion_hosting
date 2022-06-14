<?php 
include("../../models/catalogs.php");


$number=isset($_POST['number']) ? $_POST['number']: false;
$name=isset($_POST['name']) ? $_POST['name']: false;

$brand=isset($_POST['brand']) ? $_POST['brand']: false;
$model=isset($_POST['model']) ? $_POST['model']: false;
$year=isset($_POST['year']) ? $_POST['year']: false;
$serie=isset($_POST['serie']) ? $_POST['serie']: false;

$plaque=isset($_POST['plaque']) ? $_POST['plaque']: false;
$capacity_cubic_meter=isset($_POST['capacity_cubic_meter']) ? $_POST['capacity_cubic_meter']: false;
$capacity_tonne=isset($_POST['capacity_tonne']) ? $_POST['capacity_tonne']: false;

$diesel_performance=isset($_POST['diesel_performance']) ? $_POST['diesel_performance']: false;

$nombre_aseg=isset($_POST['nombre_aseg']) ? $_POST['nombre_aseg']: false;
$num_permiso_sct=isset($_POST['num_permiso_sct']) ? $_POST['num_permiso_sct']: false;
$num_poliza_seguro=isset($_POST['num_poliza_seguro']) ? $_POST['num_poliza_seguro']: false;
$perm_sct=isset($_POST['perm_sct']) ? $_POST['perm_sct']: false;
$config_vehicular=isset($_POST['config_vehicular']) ? $_POST['config_vehicular']: false;

$nombre_aseg_med_amb=isset($_POST['nombre_aseg_med_amb']) ? $_POST['nombre_aseg_med_amb']: false;
$num_poliza_seg_med_amb=isset($_POST['num_poliza_seg_med_amb']) ? $_POST['num_poliza_seg_med_amb']: false;

$timestamp=!isset($timestamp) ? date("Y-m-d H:i:s",time()): date("Y-m-d H:i:s",time()); // only can be defined internally, not by http param



if(!$number || !$plaque || !$config_vehicular){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos".json_encode($detls)."","data"=>false));
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



/* Insertar en tabla */
$query="insert into catalog_truck (subsidiary,number,name,brand,model,year,serie,plaque,nombre_aseg,num_permiso_sct,num_poliza_seguro,perm_sct,config_vehicular,nombre_aseg_med_amb,num_poliza_seg_med_amb,capacity_cubic_meter,capacity_tonne,is_local,is_foreign,diesel_performance,availableinzone,module_units_enabled,registred_by,registred_on,updated_by,updated_on) values ('$subsidiary','$number','$name','$brand','$model','$year','$serie','$plaque','$nombre_aseg','$num_permiso_sct','$num_poliza_seguro','$perm_sct','$config_vehicular','$nombre_aseg_med_amb','$num_poliza_seg_med_amb','$capacity_cubic_meter','$capacity_tonne','$flete_checkbox1','$flete_checkbox','$diesel_performance','$availableinzone','$module_units_enabled','$user[id]','$timestamp','$user[id]','$timestamp')";
$res=mysqli_query($conn,$query);

    if($res){

        echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>false));
    }else{
        echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
    }




?>