<?php 


//get rfc cliente
$query="select rfc from clients where id=$cliente";
$res=sql_dq($query,$sys["db_access"]["main"]);
$row=mysqli_fetch_assoc($res);
if($row["rfc"]!="XEXX010101000"){
echo "<script type='text/javascript'>alert('Cliente no extranjero, revise el RFC');</script>;";
$rfccerrar=1;
}
//get direccion cliente
$query="select country,state,zip_code,inside_number,outside_number,street from clients_subsidiaries where client=$cliente";
$res=sql_dq($query,$sys["db_access"]["main"]);

// while($row=mysqli_fetch_assoc($res))
$data["cliente"]=mysqli_fetch_assoc($res);
$tmp=intval($data["cliente"]["country"]);
$query="select name from world_region_country where id=$tmp";
$res=sql_dq($query,$sys["db_access"]["main"]);
$data["cliente1"]["country"]=mysqli_fetch_assoc($res);

$tmp=intval($data["cliente"]["state"]);
$query="select name from world_region_state where id=$tmp";
$res=sql_dq($query,$sys["db_access"]["main"]);
$data["cliente1"]["state"]=mysqli_fetch_assoc($res);






?>