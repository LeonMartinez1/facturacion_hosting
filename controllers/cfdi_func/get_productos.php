<?php 


include("../../models/catalogs.php");


$producto = isset($_POST['producto']) ? $_POST['producto']: false;

$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad']: false;

$precio = isset($_POST['precio']) ? $_POST['precio']: false;

$action = isset($_POST['action']) ? $_POST['action']: false;


$pesokg = isset($_POST['pesokg']) ? $_POST['pesokg']: false;

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
$json = array();

$conn=superConn();

if($action=="addProductoDetalle"){
    
    $query = "SELECT * from productos where id='$producto' limit 1";
    $res=mysqli_query($conn,$query);

    if($res){
        $row=mysqli_fetch_assoc($res);

        $detalleTabla ='';
        $subtotal = 0;
        $impuesto = 0;
        $total = 0;

        $iva = $row['iva'];
        $ieps = $row['ieps'];
        $decimals=4;

        if($iva!=0){
            $impuesto_iva = $iva;
            $impuesto = $iva;
        }elseif($ieps!=0){
            $impuesto_ieps = $ieps;
            $impuesto = $ieps;
        }

        $producto_nombre= $row['codigo']; //
        $producto_desc= $row['producto']; //
        // Precio es precio unitario.

        $precio=(float) bcdiv($precio,"1",$decimals);
        $precio = round($precio, 2);
        $subtotal = $cantidad * number_format($precio,2); //

        /* $tax_ieps=(float)$impuesto;
        $tax_ieps=$tax_ieps*100;
        $tax_ieps=($subtotal*$tax_ieps/100);
        $tax_ieps=(float)number_format($tax_ieps,4); // */

        $tax_ieps_percent=(float) $impuesto;
        //$tax_ieps=$tax_ieps_percent/100;
        $tax_ieps=$subtotal*$tax_ieps_percent;
        $tax_ieps=(float) bcdiv($tax_ieps,"1",$decimals);

        $arrayData = array();

        if($pesokg){
            $detalleTabla="
            <tr class='item'>
                <td class='producto align-middle text-center text-xs'>".$producto."</td>
                <td class='descripcion text-center text-xs'>".$producto_desc."</td>
                <td class='quantity text-center text-xs'>".$cantidad."</td>
                <td class='taxIepsTotal text-center text-xs'>".$tax_ieps."</td>
                <td class='preciou text-center text-xs'>".$precio."</td>
                <td class='pesokg text-center text-xs'><input type='text' name='' id='' value='".$pesokg."'></td>
                <td class='totalSub text-center text-xs'>".$subtotal."</td>

                <td>
                <button type='' onclick='delete_produc(this)' class='delete_produc btn btn-link text-danger text-gradient px-2 mb-0' ><i class='material-icons text-sm me-2'>delete</i><span class='text-xxs'>Borrar</span></button>

                </td>
            </tr>

        ";

        }else{
            
            $detalleTabla="
            <tr class='item'>
                <td class='producto align-middle text-center text-xs'>".$producto."</td>
                <td class='producto_name text-center text-xs'>".$producto_nombre."</td>
                <td class='descripcion text-center text-xs'>".$producto_desc."</td>
                <td class='quantity text-center text-xs'>".$cantidad."</td>
                <td class='taxIepsTotal text-center text-xs'>".$tax_ieps."</td>
                <td class='preciou text-center text-xs'>".$precio."</td>
                <td class='totalSub text-center text-xs'>".$subtotal."</td>

                <td class='acciones'>
                <button type='' onclick='delete_produc(this)' class='delete_produc btn btn-link text-danger text-gradient px-2 mb-0' ><i class='material-icons text-sm me-2'>delete</i><span class='text-xxs'>Borrar</span></button>

                </td>
            </tr>

        ";

        }
        
        
        echo json_encode($detalleTabla);

    }else{
        echo json_encode("Error");
    }

    
}




?>