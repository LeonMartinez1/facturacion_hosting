<?php 
include("../../models/catalogs.php");

$conn=superConn();

$data = json_decode($_POST['productos'],true);
//var_dump($data);

foreach ($data as $v) {
    //echo json_encode($value['producto']);

    $query = "SELECT * from productos where id='$v[producto]' limit 1";
    $res=mysqli_query($conn,$query);

    if($res){
        $row=mysqli_fetch_assoc($res);
    }

    /* $clave_unida="E48";
    $unidad = "pieza"; */

    $total = $v['taxIepsTotal']+$v['totalSub'];
    $query = "INSERT INTO traslados_detalle (factura_id, producto_id, cantidad, precio_neto, precio_unitario, tasaDescuentoProducto, importe, descuento, subtotal, tasa_iva, iva, tasa_ieps, ieps, total, clave_unidad, unidad, descripcion, c_objetoimp, c_claveprodserv, pesokg) VALUES ('$v[factura]', '$v[producto]', '$v[cantidad]', '0','$v[preciou]', '0', '$v[totalSub]', '0', '$v[totalSub]', '$row[iva]', '0', '$row[ieps]', '$v[taxIepsTotal]', '$total', '$row[clave_unida]', '$row[unidad]', '$v[descripcion]', '$row[c_objetoimp]', '$row[clave]','$v[pesokg]')";
    $res=mysqli_query($conn,$query);

    echo json_encode(array("status"=>1,"msg"=>"Se guardo con exito","data"=>$data));
}





?>