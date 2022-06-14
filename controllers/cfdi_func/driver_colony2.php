<?php 

include("../../models/catalogs.php");

$colony = isset($_POST['colony']) ? $_POST['colony']: false;

$conn=superConn();


$query = "SELECT * from sat_ce_codigo_p_cfdi where id like '%$colony%' limit 1";
$res=mysqli_query($conn,$query);

$row=mysqli_fetch_assoc($res);
$c_cod_p = $row['c_codigo_postal'];
$c_est = $row['c_estado'];
$c_mun = $row['c_municipio'];
$c_loc = $row['c_localidad'];

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////

$query = "SELECT * from sat_ce_colonia1 where c_codigo_postal like '%$c_cod_p%'
UNION
SELECT * from sat_ce_colonia2 where c_codigo_postal like '%$c_cod_p%'
UNION
SELECT * from sat_ce_colonia3 where c_codigo_postal like '%$c_cod_p%'
LIMIT 20";
$res=mysqli_query($conn,$query);
$json = [];

//die(json_encode($query));
while($row=mysqli_fetch_assoc($res)){
    //$json[] = $row;
    $json['estado']['colonia'][] = ['id'=>$row['c_colonia'], 'text'=>$row['description']];
}


/* =============================================================================================== */

$query = "SELECT * from world_region_state where clavesat = '$c_est' limit 1";
$res=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($res);
$json['estado']['estado'][] = ['id'=>$row['clavesat'], 'text'=>$row['name']];


$query = "SELECT * from sat_ce_municipio where c_estado ='$c_est' and c_municipio = '$c_mun'";
$res=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($res)){
    $json['estado']['municipio'][] = ['id'=>$row['id'], 'text'=>$row['description']];
}

$query = "SELECT * from sat_ce_localidad where c_estado = '$c_est' and c_localidad ='$c_loc'";
$res=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($res)){
    $json['estado']['localidad'][] = ['id'=>$row['id'], 'text'=>$row['description']];
}


echo json_encode($json);

?>