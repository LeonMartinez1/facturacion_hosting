<?php 

include("../../models/catalogs.php");

$conn=superConn();

$estado = isset($_POST['estado']) ? $_POST['estado']: false;
$mun = isset($_POST['mun']) ? $_POST['mun']: false;
$loc = isset($_POST['mun']) ? $_POST['mun']: false;


///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
$json = array();
$query = "SELECT * from sat_ce_localidad where c_estado like '%".$estado."%'";
$res=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($res)){
    $json['estado']['localidad'][] = ['id'=>$row['id'], 'text'=>$row['description']];
}

$query = "SELECT * from sat_ce_municipio where c_estado like '%".$estado."%'";
$res=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($res)){
    $json['estado']['municipio'][] = ['id'=>$row['id'], 'text'=>$row['description']];
}

$query = "SELECT * from sat_ce_municipio where c_estado like '%".$estado."%' and description like '%".$mun."%' limit 1";
$res=mysqli_query($conn,$query);
$row2=mysqli_fetch_assoc($res);
$json['estado']['mun'] = ['id'=>$row2['id'], 'text'=>$row2['description']];

$query = "SELECT * from sat_ce_localidad where c_estado like '%".$estado."%' and description like '%".$loc."%' limit 1";
$res=mysqli_query($conn,$query);
$row2=mysqli_fetch_assoc($res);
$json['estado']['loc'] = ['id'=>$row2['id'], 'text'=>$row2['description']];

//$json[estado][mun]=$mun;
echo json_encode($json);

?>