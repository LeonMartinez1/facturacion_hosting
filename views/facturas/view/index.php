<?php 
error_reporting(E_ALL ^ E_NOTICE);


include("../../../models/catalogs.php");
$conn=superConn();

$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"];

if($factura){
    $res_factura = getFactura($factura);

    $files = get_files();



    $filename=$res_factura["serie"].$res_factura["folio"].".xml";
        //$filename="WWWE607.xml";
    
    $xml_path="../../../resources/storage/xml/".$filename;
    // EXTRAER EL UUID
    if(file_exists($xml_path)){
      $tmp["uuid"]=get_uuid($xml_path);		

    }
    $uuid_this=$tmp;

}

//echo json_encode($res_factura);

function get_uuid_view($xml_file_path){
  error_reporting(E_ERROR | E_PARSE);
    // $UUID="";
    if(file_exists($xml_file_path)){
    
      $xml_file = simplexml_load_file($xml_file_path); 
      if($xml_file){
        
      $ns = $xml_file->getNamespaces(true);
      $xml_file->registerXPathNamespace('c', $ns['cfdi']);
      $xml_file->registerXPathNamespace('t', $ns['tfd']);
  
      foreach ($xml_file->xpath('//t:TimbreFiscalDigital') as $tfd){
      $UUID=$tfd['UUID'];
      $UUID=(string)$UUID;
      }
      }
    }
    
    return $UUID;
    
  }

 if($res_factura['uuid']){
  $query="select id,serie,folio,uuid from facturas where uuid_relacionados='$res_factura[uuid]' limit 1";
  $res=mysqli_query($conn,$query);
  
  $data=array();
  if($res){
  
    while($row=mysqli_fetch_assoc($res)){
      $tmp = array();
    
      $tmp["id"]=$row["id"];
      $tmp["folio"]=$row["folio"];
      
        $filename=$row["serie"].$row["folio"].".xml";
        //$filename="WWWE607.xml";
    
        $xml_path="../../../resources/storage/xml/".$filename;
        // EXTRAER EL UUID
        if(file_exists($xml_path)){
          $tmp["uuid"]=get_uuid_view($xml_path);		
        }
    
      
      $dataUuidCancel=$tmp;
    }
  
  }
  

 } 


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../../assets/number_format.js"></script>

      <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
        <!-- Nucleo Icons -->
        <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <!-- CSS Files -->
        <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .form-control{
            font-size:.76rem !important;
            border: 1px solid #d2d6da !important;
            padding: 0.05rem 0.35rem !important;
        }
        .form-control[disabled] {
          line-height: 2 !important;
        }
        .btn{
          border-radius: 0.1rem !important;
        }
        .btn-sm, .btn-group-sm > .btn {
            border-radius: 0.1rem !important;
        }

        #lista3 {
            counter-reset: li; 
            list-style: none; 
            *list-style: decimal; 
            font: 15px 'trebuchet MS', 'lucida sans';
            padding: 0;
            margin-bottom: 4em;
            text-shadow: 0 1px 0 rgba(255,255,255,.5);
        }

        #lista3 ol {
            margin: 0 0 0 2em; 
        }

        #lista3 li{
            position: relative;
            display: block;
            padding: .4em .4em .4em .8em;
            *padding: .4em;
            margin: .5em 0 .5em 2.5em;
            background: #ddd;
            color: #444;
            text-decoration: none;
            transition: all .3s ease-out;   
        }

        #lista3 li:hover{
            background: #eee;
        }   

        #lista3 li:before{
            content: counter(li);
            counter-increment: li;
            position: absolute; 
            left: -2.5em;
            top: 50%;
            margin-top: -1em;
            background: #fa8072;
            height: 2em;
            width: 2em;
            line-height: 2em;
            text-align: center;
            font-weight: bold;
        }

        #lista3 li:after{
            position: absolute; 
            content: '';
            border: .5em solid transparent;
            left: -1em;
            top: 50%;
            margin-top: -.5em;
            transition: all .3s ease-out;               
        }

        #lista3 li:hover:after{
            left: -.5em;
            border-left-color: #fa8072;             
        }
    </style>

    <title>Facturas</title>
</head>
<body class="bg-gray-200">
<header>
        <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand">Navbar</a>
        <!-- <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
        </nav>
</header>

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>">Inicio</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Facturas</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Crear Factura</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Buscar...</label>
              <input type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1" aria-hidden="true"></i>
                <span class="d-sm-inline d-none">Iniciar sesion</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" aria-hidden="true"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer" aria-hidden="true"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1" aria-hidden="true"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1" aria-hidden="true"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1" aria-hidden="true"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div class="container px-2 px-md-4 bs-white">
      <!-- <div class="card card-body mx-3 mx-md-4 mt-n6"></div> -->
        <div class="row">
            <div class="col-sm-12">
              <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">

                      <form  class="form" style="font-size:.9rem;">
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                      <label for="cliente">Codigo de Cliente</label>
                                      <input type="text" class="form-control" id="cliente" placeholder="Cliente" value="<?php echo $res_factura['cliente_id']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-6">
                                      <label for="cliente_rfc">RFC</label>
                                      <input type="text" class="form-control" id="cliente_rfc" placeholder="RFC" value="<?php echo $res_factura['rfc_receptor']; ?>" disabled>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="cliente_nombre">Nombre</label>
                                      <input type="text" class="form-control" id="cliente_nombre" placeholder="Jhon Doe" value="<?php echo $res_factura['nombre_receptor']; ?>" disabled>
                                  </div>
                                  <div class="form-group">
                                      <label for="cliente_email">Email</label>
                                      <input type="email" class="form-control" id="cliente_email" placeholder="Email" value="<?php echo $res_factura['email']; ?>" disabled>
                                  </div>
                                  
                              </div>

                              <!-- ============================ Sengundo col-sm-6 =============================== -->


                              <div class="col-sm-6">
                                  <div class="form-row">
                                      <div class="form-group col-md-4">
                                      <label for="serie_folio">Serie</label>
                                      <input type="text" class="form-control" id="serie_folio" value="<?php echo $res_factura['serie'].$res_factura['folio']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="referencia">Referencia</label>
                                      <input type="text" class="form-control" id="referencia" placeholder="RFC" value="<?php echo $res_factura['rfc_receptor']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="fecha">Fecha</label>
                                      <input type="text" class="form-control" id="fecha" value="<?php echo $res_factura['fecha']; ?>" disabled>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-4">
                                      <label for="metodo_pago">Metodo de Pago</label>
                                      <input type="text" class="form-control" id="metodo_pago" value="<?php echo $res_factura['forma_pago']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="forma_pago">Forma de pago</label>
                                      <input type="text" class="form-control" id="forma_pago"  value="<?php echo $res_factura['metodo_pago']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="cfdi_use">Uso cfdi</label>
                                      <input type="text" class="form-control" id="cfdi_use" value="<?php echo $res_factura['uso_cfdi']; ?>" disabled>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                      <label for="moneda">Moneda</label>
                                      <input type="text" class="form-control" id="moneda"  value="<?php echo $res_factura['moneda']; ?>" disabled>
                                      </div>
                                      <div class="form-group col-md-6">
                                      <label for="tipo_cambio">Tipo de cambio</label>
                                      <input type="text" class="form-control" id="tipo_cambio"  value="<?php echo $res_factura['tipoCambio']; ?>" disabled>
                                      </div>
                                  </div>
                              </div>

                              <?php
                                  //$xml_path = in_array($res_factura['serie'].$res_factura['folio'].".xml", $files,false);
                                  $xml_path = in_array("A167ABC.xml", $files,false);
                                  
                                  $xml = $res_factura['serie'].$res_factura['folio'].".xml";
                              ?>
                              
                              <div style="border-top: 1px solid #f0f2f5; border-bottom: 1px solid #f0f2f5;" class="form-group mt-4 pt-4 pb-2">
                                  <div class="form-check">
                                    <input type="hidden" id="factura" name="factura" value="<?php echo $res_factura['id']; ?>">
                                    <!-- <button id="gen_t" style="font-size:.6rem;" type="button" class="btn btn-info btn-sm">Generar XML Traslado</button> -->
                                    <a href="../../traslados/insert/?factura=<?php echo $res_factura['id']; ?>" style="font-size:.6rem;" type="button" class="btn btn-warning btn-sm">Crear Traslado</a>

                                    <button style="font-size:.6rem;" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">Cancelar Factura</button>


                                    <?php if($xml_path) :?>

                                      <button onclick='abri_xml("<?php echo $xml; ?>")'  style="font-size:.6rem;" type="button" class="btn btn-success btn-sm">XML</button>

                                    <?php endif; ?>

                                  </div>
                              </div>
                              
                          </div>
                      </form>

                    </div>
                  </div>

                  <!-- table plantilla -->

                  <div class="row">
                      <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-primary shadow-primary border-radius-sm pt-2 pb-2">
                              <h6 class="text-white text-capitalize ps-3 mb-0">Detalles de Articulos</h6>
                          </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                          <div class="table-responsive p-0">
                              <table class="articleListContainer table align-items-center justify-content-center mb-0">
                              <thead>
                                  <tr>

                                  <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Producto</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tax Ieps</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">P.unitario</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                  <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th> -->
                                  </tr>
                              </thead>
                              <tbody class="data" id="data">
                                  <?php foreach($res_factura['detalles'] as $f_detalle): ?>

                                      <tr class="item">
                                      <th class="align-middle text-center text-xs"><?php echo $f_detalle['id']; ?></th>
                                      <td class="text-center text-xs"><?php echo $f_detalle['producto_id']; ?></td>
                                      <td class="text-center text-xs"><?php echo $f_detalle['descripcion']; ?></td>
                                      <td class="text-center quantity text-xs"><?php echo $f_detalle['cantidad']; ?></td>
                                      <td class="text-center taxIepsTotal text-xs"><?php echo $f_detalle['ieps'];?></td>
                                      <td class="text-center text-xs"><?php echo $f_detalle['precio_unitario']; ?></td>
                                      <td class="totalSub text-center text-xs"><?php echo $f_detalle['subtotal']; ?></td>

                                      <!-- <td>
                                      <a href="#" style="font-size:.6rem;" type="button" class="btn btn-primary btn-sm ml-2">ver</a>

                                      </td> -->
                                      </tr>

                                  <?php endforeach; ?>
                              </tbody>

                              <tfoot>
                                <tr>
                                  <td  class="align-middle text-s text-right py-4 px-4" colspan="8">
                                  <div class="articleListSummaryContainer">

                                    <div class=" area2 align-item-left">
                                        <div class="part" style="display:none;">
                                            <span class="number"></span>
                                        </div>
                                        <div class="quantity" style="display:none;">
                                            <span class="number"></span>
                                        </div>
                                        <div class="totalSub">
                                            <span class="col-sm-6 name text-left font-weight-bolder">Subtotal</span><span class="currencySign">$</span><span class="col-sm-1 number text-info pl-0"></span>
                                        </div>
                                        <div class="discount">
                                            <span class="name text-left">Descuento</span><span class="currencySign">&nbsp;$&nbsp;</span><span class="number"></span>
                                        </div>
                                        <div class="totalSubWithDiscount">
                                            <span class="name text-left">Subtotal.</span><span class="currencySign">&nbsp;$&nbsp;</span><span class="number"></span>
                                        </div>
                                        <div class="taxIeps">
                                            <span class="col-sm-6 name text-left font-weight-bolder">IEPS</span><span class="currencySign">$</span><span class="col-sm-1 number text-warning pl-0"></span>
                                        </div>
                                        <div class="taxIva text-danger">
                                            <span class="col-sm-6 name">IVA</span><span class="currencySign">$</span><span style="width:2rem;" class="col-sm-1 number pl-0"></span>
                                        </div>
                                        <div class="taxIvaRetained">
                                            <span class="col-sm-6 name font-weight-bolder">iva retenido</span><span class="currencySign">$</span><span class="col-sm-1 number pl-0"></span>
                                        </div>
                                        <div class="taxIsr">
                                            <span class="name">isr</span><span class="currencySign">&nbsp;$&nbsp;</span><span class="number"></span>
                                        </div>
                                        <div class="total">
                                            <span class="col-sm-6 name font-weight-bolder">Total</span><span class="currencySign">$</span><span class="col-sm-1 number text-success pl-0"></span>
                                        </div>
                                    </div>


                                    </div>
                                  </td>
                                </tr>
                              </tfoot>

                              </table>
                          </div>
                          </div>
                      </div>
                      </div>
                  </div>
                  
                </div>
              </div>
            </div>
        </div>

    </div>

  <script>
	  /* ================================================================================================================== */


		// details calculate summary, CODEID "DECASU0991199"

		detailsCalculateSummary=function() {

			// totals global
	
			// get values
	 
			var quantity=0, part=0, total_sub=0, discount=0, total_sub_with_discount=0, tax_ieps=0, tax_iva=0, tax_iva_retained=0, tax_isr=0, total=0,
				quantity_tmp=null, part_tmp=null, discount_tmp=null, tax_ieps_tmp=null, tax_iva_tmp=null, tax_iva_retained_tmp=null, tax_isr_tmp=null, total_sub_tmp=null;
	
			$("#data > tr.item").each(function() {
	
				// element maybe stay in "edition"?, CODEID "DEMA0993"
	
				var cond=$(this).find("td.quantity").length;
	            
				part_tmp=parseFloat( $(this).children("div.part").text() );
				quantity_tmp=parseFloat( !cond ? $(this).children("td.quantity").text() : $(this).find("td.quantity").text(),10 );
				total_sub_tmp=parseFloat( $(this).children("td.totalSub").text() );
				discount_tmp=parseFloat( $(this).children("td.discountTotal").text() );
				tax_ieps_tmp=parseFloat( $(this).children("td.taxIepsTotal").text() );
				tax_iva_tmp=parseFloat( $(this).children("td.taxIvaTotal").text() );
				tax_iva_retained_tmp=parseFloat( $(this).children("td.taxIvaRetainedTotal").text() );
				tax_isr_tmp=parseFloat( $(this).children("td.taxIsrTotal").text() );

                //alert(total_sub_tmp);
	
				part=!isNaN(part_tmp) ? part_tmp : 0 ;
				quantity+=!isNaN(quantity_tmp) ? quantity_tmp : 0 ;
				total_sub+=!isNaN(total_sub_tmp) ? total_sub_tmp : 0 ;
				discount+=!isNaN(discount_tmp) ? discount_tmp : 0 ;
				tax_ieps+=!isNaN(tax_ieps_tmp) ? tax_ieps_tmp : 0 ;
				tax_iva+=!isNaN(tax_iva_tmp) ? tax_iva_tmp : 0 ;
				tax_iva_retained+=!isNaN(tax_iva_retained_tmp) ? tax_iva_retained_tmp : 0 ;
				tax_isr+=!isNaN(tax_isr_tmp) ? tax_isr_tmp : 0 ;
	
			});
	
	function toFixed(num, fixed) {
		fixed = fixed || 0;
		fixed = Math.pow(10, fixed);
		return Math.floor(num * fixed) / fixed;
	}
			// additional calculation
		//ESTO SE HIZO PORQUE ARREGLE LO DEL .01 PERO AFECTA LAS FACTURAS YA REGISTRADAS ES POR ESO QUE LE PUSE LA VALIDACION DEL REGISTRED ON 
		// PARA LAS QUE YA ESTABAN SE COMPORTEN COMO ERAN 
	
		//var registred_on="<?php echo $registred_on?>";
	

			quantity=parseFloat(number_format(quantity,4,".",""));
			total_sub=parseFloat(number_format(total_sub,4,".",""));


            // Pendiente descuentos.
			/* <?php //if($sys["config"]["show_discount_items"]): ?>
			total_sub_with_discount=total_sub;
			<?php //else: ?>
			total_sub_with_discount=total_sub-discount;
			<?php //endif; ?> */
	
	
			tax_ieps=parseFloat(number_format(tax_ieps,4,".","")); /* individual tax should preserve all decimals ( at most 4 ) */
			tax_iva=parseFloat(number_format(tax_iva,4,".","")); /* individual tax should preserve all decimals ( at most 4 ) */
			tax_iva_retained=parseFloat(number_format(tax_iva_retained,4,".","")); /* individual tax should preserve all decimals ( at most 4 ) */
			tax_isr=parseFloat(number_format(tax_isr,4,".","")); /* individual tax should preserve all decimals ( at most 4 ) */
	
			<?php if($sys["config"]["show_discount_items"]): ?>
			total=(((total_sub)+(tax_ieps+tax_iva))-tax_iva_retained)-tax_isr;
			<?php else: ?>
			total=(((total_sub-discount)+(tax_ieps+tax_iva))-tax_iva_retained)-tax_isr;
			<?php endif; ?>
			
			total=parseFloat(number_format(total,4,".",""));
		
			// set visual
	
			var el=$("div.articleListSummaryContainer > div.area2").get(0);
	
			$(el).find("div.quantity > span.number").html( quantity );
			$(el).find("div.part > span.number").html( part );
	
			<?php if($sys["config"]["show_discount_items"]): ?>
			$(el).find("div.totalSub > span.number").html( number_format(toFixed(total_sub+discount,3),2,".",",") );
			<?php else: ?>
			$(el).find("div.totalSub > span.number").html( number_format(toFixed(total_sub,3),2,".",",") );
			<?php endif; ?>
	
			
	
			$(el).children("div.discount").css("display",( !discount ? "none" : "block" )).children("span.number").html( number_format(toFixed(discount,2),2,".",",") );
			$(el).children("div.totalSubWithDiscount").css("display",( (!total_sub || !discount) ? "none" : "block" )).children("span.number").html( number_format(toFixed(total_sub_with_discount,2),2,".",",") );
			$(el).children("div.taxIeps").css("display",( !tax_ieps ? "none" : "block" )).children("span.number").html( number_format(toFixed(tax_ieps,2),2,".",",") );
			
			$(el).find("div.taxIva > span.number").html(number_format(toFixed(tax_iva, 3),2,'.',','));
			$(el).children("div.taxIvaRetained").css("display",( !tax_iva_retained ? "none" : "block" )).children("span.number").html( number_format(toFixed(tax_iva_retained,2),2,".",",") );
			$(el).children("div.taxIsr").css("display",( !tax_isr ? "none" : "block" )).children("span.number").html( number_format(toFixed(tax_isr,2),2,".",",") );
			// $(el).find("div.total > span.number").html(number_format(toFixed(total, 2),2,".",","));
			$(el).find("div.total > span.number").html(number_format(toFixed(total, 3),2,".",","));
	
			
	
		};
	
		// should be done, to set default values
	
		detailsCalculateSummary();

	/* ================================================================================================================== */


$("#gen_t").click(function () { 

var traslado = $("#factura").val();

$.ajax({
    data:{
        traslado: traslado
    },
    url:"../../../controllers/cfdi_func/invoice-electronic-generate.php",
    type: "POST",
    success: function(rslt2){
        //alert(rslt2);
        Swal.fire(
          'Traslado',
          rslt2,
          'success'
        )
        //rslt2 = JSON.parse(rslt2);
        console.log(rslt2);
        
    }
});

});

function abri_xml(xml){
            var xml = xml;
            window.open("../../../resources/storage/xml/"+xml, "_blank");
        }       

</script>



<!-- =================================== Cancelar ============================================ -->


<script>

function cancelDocument() { // Version 4.0

  var uuid_this = "<?php echo $uuid_this['uuid']; ?>";

      var comment=$("#comment").val();

      //if( (comment=prompt("Motivo de Cancelacion?\n Escriba solo el numero correspondiente\n1 - Comprobante emitido con errores con relación.\n2 - Comprobante emitido con errores sin relación.\n3 - No se llevó a cabo la operación.\n4 - Operación nominativa relacionada en la factura global."))===null )
      //return;

      var motivo_lengh = comment.length;
      // d0!

      if(motivo_lengh==0){
       // alert("Debe elegir un motivo de cancelacion");
        Swal.fire(
            'Motivo Cancelación',
            'Debe elegir un motivo de cancelacion',
            'info'
        ) 
        return;
      }else if(comment!=1 && comment!=2 && comment!=3 && comment!=4){
        //alert("Debe elegir una opcion de cancelacion valida");

        Swal.fire(
            'Motivo Cancelación',
            'Debe elegir una opcion de cancelacion valida',
            'info'
        ) 
        return;
      }

      if(comment==1){
        comment=="1";

        <?php if($dataUuidCancel['uuid']):?>
        var uuid_cancel = "<?php echo $dataUuidCancel['uuid'];?>";
        var folio_cancel1 = "<?php echo $dataUuidCancel['folio'];?>";

        alert("Esta factura se reemplazara con la factura de folio : "+folio_cancel1+", UUID : "+uuid_cancel); 


          /* Swal.fire({
            title: 'CFDI',
            text: "Esta factura se reemplazara con la factura de folio : "+folio_cancel1+", UUID : "+uuid_cancel,
            icon: 'info',
            showCancelButton: false,
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
              return;
            }else{
              return;
            }
          }) */
           Swal.fire(
            'Motivo Cancelación',
            'Esta factura se reemplazara con la factura de folio : ',
            'info'
            ) 
            
        
        <?php else:?>
          //alert("No existe ninguna Factura relacionada para esta opción !\nPara esta opción se debe:\n Crear previamente la factura por la que se reemplazará,\n en la opción de REMPLAZO FACTURA deberá elegir la\n factura que se quiere reemplazar.");
          Swal.fire(
            'Motivo Cancelación',
            'No existe ninguna Factura relacionada para esta opción !\nPara esta opción se debe:\n Crear previamente la factura por la que se reemplazará,\n en la opción de RELACIONAR FACTURA deberá elegir la\n factura que se quiere reemplazar.',
            'info'
            )
          
          return;
        <?php endif;?>

      }else if(comment==2){
        comment=="2";

      }else if(comment==3){
        comment=="3";

      }else if(comment==4){
        comment=="4";
      }
      // set vars

      var button=$("form#dinamic #cancel:eq(0)").get(0),
        query_string="id=<?php echo $uuid_this['uuid']; ?>"
              +"&motivo="+encodeURIComponent(comment)
              +"&source_module=11"
              <?php if($dataUuidCancel['uuid']):?>
              +"&uuid_folio="+encodeURIComponent(uuid_cancel)
              <?php endif;?>
              ;


      // d0!
      //alert(query_string);
      //return;

      $.ajax({
        data:query_string,
        url:"../../../controllers/cfdi_func/invoice-electronic-generate-cancel.php",
        type: "POST",
        success: function(rslt2){

          var requests=JSON.parse(rslt2), request=( requests && typeof requests ==='object' ? requests[0] : null ), class_name="", msg="";

            var option ="";
            if(requests.status==1){
              option='success';
              
            }else{
              option = 'warning'
            }

            Swal.fire({
              title: 'CFDI',
              text: requests.msg,
              icon: option,
              showCancelButton: false,
              confirmButtonText: 'OK!'
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            })
            console.log(requests.status); 
        }

      });

};


</script>

<script>
  $(document).ready(function () {
    
  });
</script>


<!-- ========================================================================================== -->


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Motivo de Cancelacion?</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h6>Escriba solo el numero correspondiente</h6> 
      <ol id="lista3">
				<li id="tutTraslado">Comprobante emitido con errores con relación.</li>
        <li id="tutTraslado">Comprobante emitido con errores sin relación.</li>
        <li id="tutTraslado">No se llevó a cabo la operación.</li>
        <li id="tutTraslado">Operación nominativa relacionada en la factura global.</li>
		  </ol>

      <input type="text" name="" id="comment">
      </div>
      <div class="modal-footer">
        <button id="enviar_motivo" type="button" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

<script>
$("#enviar_motivo").click(function () { 
  cancelDocument();
});

$('#myModal').on('hidden.bs.modal', function (e) {
    $("#myModal input").val("");
});
</script>

</body>
</html>