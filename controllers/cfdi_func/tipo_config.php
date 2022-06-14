<?php 

include("../../models/catalogs.php");

$conn=superConn();

$tipo_config = isset($_POST['tipo_config']) ? $_POST['tipo_config']: false;

if($tipo_config){

    
    $query="select id,config_vehicular from catalog_truck where id=$tipo_config limit 1";
    $res=mysqli_query($conn,$query);
    if($res){
    $row=mysqli_fetch_assoc($res);

        $tipo_config=$row['config_vehicular'];

        echo $tipo_config;
    }
    	
            	
}


?>