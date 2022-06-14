<?php 

include("../../models/catalogs.php");


$colony = isset($_POST['searchTerm']) ? $_POST['searchTerm']: false;

$conn=superConn();
///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////

if($colony){
    $query = "SELECT * from sat_ce_colonia1 where c_codigo_postal like '%$colony%'
    UNION
    SELECT * from sat_ce_colonia2 where c_codigo_postal like '%$colony%'
    UNION
    SELECT * from sat_ce_colonia3 where c_codigo_postal like '%$colony%'
    GROUP BY c_codigo_postal ";
    $res=mysqli_query($conn,$query);
    $json = [];
    while($row=mysqli_fetch_assoc($res)){
        $json[] = ['id'=>$row['c_codigo_postal'], 'text'=>$row['c_codigo_postal']];
    }

echo json_encode($json);

}


?>