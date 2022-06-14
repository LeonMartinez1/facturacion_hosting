<?php 
include("../../models/catalogs.php");

$id = isset($_POST['id']) ? $_POST['id']: false;
$name=isset($_POST['name']) ? $_POST['name']: false;

$rfc=isset($_POST['rfc']) ? $_POST['rfc']: false;

$regimen_fiscal=isset($_POST['regimen_fiscal']) ? $_POST['regimen_fiscal']: false;
$phone=isset($_POST['phone']) ? $_POST['phone']: false;
$email=isset($_POST['email']) ? $_POST['email']: false;

$pais=isset($_POST['pais']) ? $_POST['pais']: false;
$estado=isset($_POST['estado']) ? $_POST['estado']: false;
$localidad=isset($_POST['localidad']) ? $_POST['localidad']: false;
$municipio=isset($_POST['municipio']) ? $_POST['municipio']: false;

$colonia=isset($_POST['colonia']) ? $_POST['colonia']: false;
$calle=isset($_POST['calle']) ? $_POST['calle']: false;
$numero_ext=isset($_POST['numero_ext']) ? $_POST['numero_ext']: false;
$numero_int=isset($_POST['numero_int']) ? $_POST['numero_int']: false;
$codigo_postal=isset($_POST['codigo_postal']) ? $_POST['codigo_postal']: false;

$timestamp=!isset($timestamp) ? date("Y-m-d H:i:s",time()): date("Y-m-d H:i:s",time()); // only can be defined internally, not by http param



if(!$name || !$rfc || !$regimen_fiscal){
    echo json_encode(array("status"=>2,"msg"=>"Faltan llenar campos requeridos","data"=>false));
    return;
}


$json = array();

$conn=superConn();


/* Insertar en tabla */

if($id){

    $query="update empresa set nombre_comercial='$name',regimen_fiscal='$regimen_fiscal',rfc='$rfc',calle='$calle',noext='$numero_ext',noint='$numero_int',pais='$pais',entidad='$estado',localidad='$localidad',municipio='$municipio',colonia='$colonia',cp='$codigo_postal',email_contacto='$email',telefono='$phone',updated_at='$timestamp' where id='$id' limit 1";
    $res=mysqli_query($conn,$query);
    if($res){
        
        echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>false));
    }else{
        echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
    }

}else{
    $query="insert into empresa (nombre_comercial,regimen_fiscal,rfc,calle,noext,noint,pais,entidad,localidad,municipio,colonia,cp,email_contacto,telefono,created_at) values ('$name','$regimen_fiscal','$rfc','$calle','$num_ext','$num_int','$pais','$estado','$localidad','$municipio','$colonia','$codigo_postal','$email','$phone','$timestamp')";
    $res=mysqli_query($conn,$query);
    
        if($res){
    
            echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>false));
        }else{
            echo json_encode(array("status"=>2,"msg"=>"$query Error al inserta en la base de datos","data"=>false));
        }
}

?>