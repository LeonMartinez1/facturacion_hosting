<?php 
include("../../models/catalogs.php");


$name=isset($_POST['name']) ? $_POST['name']: false;

$rfc=isset($_POST['rfc']) ? $_POST['rfc']: false;

$direction=isset($_POST['direction']) ? $_POST['direction']: false;
$phone=isset($_POST['phone']) ? $_POST['phone']: false;
$license=isset($_POST['license']) ? $_POST['license']: false;
$license_attachment=isset($_POST['license_attachment']) ? $_POST['license_attachment']: false;

$reference=isset($_POST['reference']) ? $_POST['reference']: false;
$truck=isset($_POST['truck']) ? $_POST['truck']: false;
$module_units_enabled=isset($_POST['module_units_enabled']) ? $_POST['module_units_enabled']: false;


$pais=isset($_POST['pais']) ? $_POST['pais']: false;
$estado=isset($_POST['estado']) ? $_POST['estado']: false;
$localidad=isset($_POST['localidad']) ? $_POST['localidad']: false;
$municipio=isset($_POST['municipio']) ? $_POST['municipio']: false;

$colonia=isset($_POST['colonia']) ? $_POST['colonia']: false;
$calle=isset($_POST['calle']) ? $_POST['calle']: false;
$numero_ext=isset($_POST['numero_ext']) ? $_POST['numero_ext']: false;
$codigo_postal=isset($_POST['codigo_postal']) ? $_POST['codigo_postal']: false;

$timestamp=!isset($timestamp) ? date("Y-m-d H:i:s",time()): date("Y-m-d H:i:s",time()); // only can be defined internally, not by http param



if(!$name || !$rfc || !$license){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos".json_encode($detls)."","data"=>false));
    return;
}


$json = array();

$conn=superConn();


/* Insertar en tabla */
$query="insert into catalog_driver (subsidiary,name,rfc,direction,pais,estado,localidad,municipio,colonia,calle,numero_ext,codigo_postal,phone,license,license_attachment,reference,truck,is_local,is_foreign,module_units_enabled,registred_by,registred_on,updated_by,updated_on) values ('$subsidiary','$name','$rfc','$direction','$pais','$estado','$localidad','$municipio','$colonia','$calle','$numero_ext','$codigo_postal','$phone','$license','$license_attachment','$reference','$truck','$is_local','$is_foreign','$module_units_enabled','$user[id]','$timestamp','$user[id]','$timestamp')";
$res=mysqli_query($conn,$query);

    if($res){

        echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>false));
    }else{
        echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
    }




?>