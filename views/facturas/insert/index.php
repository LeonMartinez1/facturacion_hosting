<?php 
error_reporting(E_ALL ^ E_NOTICE);


include("../../../models/catalogs.php");

$factura = $_POST["factura"] ? $_POST["factura"] : $_GET["factura"];
$venta = $_POST["venta"] ? $_POST["venta"] : $_GET["venta"];

if($factura){
    $res_factura = getFactura($factura);
    $files = get_files();

}elseif($venta){
  $res_factura = getVenta($venta);
}

$res_cfid_use = getUseCfdi();
$res_forma_pago = getFormaPago();
/* ==================== Exportacion ? ======================= */
// version 4.0
$c_exportacions = getExportacion();
/* ========================================================== */
$metodo_pago=getMetodoPago();
$moneda=getMoneda();

/* ======== Catalogos Comercio exterior ======== */
$incoterms=getIncoterm();
$tipo_operacion=getTipoOp();
$tariffs=getTariff();
$pedimets_codes=getPedimentCode();
$aduanas_unid=getAduanaUnid();

//echo json_encode($res_factura);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../../assets/number_format.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        select.form-control:not([size]):not([multiple]) {
            height: calc(1.7rem + 2px);
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
                    <div class="col-sm-12 mb-4">

                      <form id="form_invoice"  class="form" style="font-size:.9rem;">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="referencia">Referencia</label>
                                  <select id="referencia" class="form-control">
                                    <option value="" selected>Seleccionar</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label for="cliente">Buscar de Cliente</label>
                                        <!--  <input type="text" class="form-control" id="cliente" placeholder="Cliente" value="<?php //echo $res_factura['id']?$res_factura['id']:""; ?>"> -->
                                        <select id="cliente" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                      <label for="cliente_rfc">RFC</label>
                                      <input type="text" class="form-control" id="cliente_rfc" placeholder="RFC" value="">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="cliente_nombre">Nombre</label>
                                      <input type="text" class="form-control" id="cliente_nombre" placeholder="Jhon Doe" value="">
                                  </div>
                                  <div class="form-group">
                                      <label for="cliente_email">Email</label>
                                      <input type="email" class="form-control" id="cliente_email" placeholder="Email" value="">
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                          <label for="observaciones">Observaciones</label>
                                          <textarea id="observaciones" class="form-control"></textarea>

                                    </div>
                                  </div>
                                  
                              </div>

                              <!-- ============================ Sengundo col-sm-6 =============================== -->


                              <div class="col-sm-6">
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                      <label for="serie_folio">Serie</label>
                                      <input type="hidden" id="folio" value="">
                                      <input type="text" class="form-control" id="serie_folio" placeholder="Serie" value="FCT">
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                      <label for="fecha">Fecha</label>
                                      <input type="text" class="form-control" id="fecha" placeholder="Cliente" value="Automatico" disabled>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-4">
                                      <label for="metodo_pago">Metodo de Pago</label>
                                      <select id="metodo_pago" class="form-control">
                                          <option value="" selected>Seleccionar</option>
                                          <?php foreach($metodo_pago as $k => $m_pago): ?>
                                              
                                              <option value="<?php echo $m_pago ;?>"><?php echo $k;?></option>
                                          <?php endforeach; ?>
                                      </select>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="forma_pago">Forma de pago</label>
                                      <select id="forma_pago" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                        <?php foreach($res_forma_pago as $f_pago): ?>
                                           
                                            <option value="<?php echo $f_pago['clave'];?>"><?php echo $f_pago['clave']." - ".$f_pago['descripcion'];?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="cfdi_use">Uso cfdi</label>
                                      <select id="cfdi_use" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                        <?php foreach($res_cfid_use as $r_cfdi_u): ?>
                                           
                                            <option value="<?php echo $r_cfdi_u['clave'];?>"><?php echo $r_cfdi_u['clave']." - ".$r_cfdi_u['description'];?></option>
                                        <?php endforeach; ?>
                                        </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                      <label for="moneda">Moneda</label>
                                          <select id="moneda" class="form-control">

                                            <option value="" selected>Seleccionar</option>
                                            <?php foreach($moneda as $k => $c_mon): ?>
                                                
                                                <option value="<?php echo $c_mon ;?>"><?php echo $k;?></option>
                                            <?php endforeach; ?>

                                          </select>
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                      <label for="tipo_cambio">Tipo de cambio</label>
                                      <input type="text" class="form-control" id="tipo_cambio"  value="">
                                      </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                          <label for="c_exportacion">Exportacion ?</label>
                                          <select id="c_exportacion" class="form-control">

                                            <option value="" selected>Seleccionar</option>
                                            <?php foreach($c_exportacions as $k => $c_export): ?>
                                                
                                                <option value="<?php echo $c_export ;?>"><?php echo $k;?></option>
                                            <?php endforeach; ?>

                                          </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                          <label for="uuid_folio">Relacionar factura</label>
                                          <select id="uuid_folio" class="form-control">
                                            <option value="" selected>Seleccionar</option>
                                          </select>
                                    </div>
                                  </div>

                              </div>

                              
                              <div class="col-sm-12 mt-4 mb-4 pt-4" style="border-top:1px solid #f0f2f5;">
                                <div class="form-row">
                                  <div class="form-check form-check-info text-start ps-0">
                                    <input class="form-check-input" type="checkbox" value="" id="ce_check">
                                    <label class="form-check-label" for="ce_check">
                                      Complemento Comercio Exterior
                                    </label>
                                  </div>
                                </div>
                              </div>

                              <!-- ======================= Formulario de comercio exterior ====================== -->

                              <div id="ce_form" style="display:none;" class="ce_form col-sm-12 mb-4">
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label for="ce_tipo_operacion">Tipo operaciòn</label>
                                        
                                          <select id="ce_tipo_operacion" class="form-control">

                                              <option value="" selected>Seleccionar</option>
                                              <?php foreach($tipo_operacion as $tipo_o): ?>
                                                  
                                                  <option value="<?php echo $tipo_o['clave'] ;?>"><?php echo $tipo_o['name'];?></option>
                                              <?php endforeach; ?>

                                            </select>
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                      <label for="ce_divisa">Divisa</label>
                                          <select id="ce_divisa" class="form-control">

                                            <option value="" selected>Seleccionar</option>
                                            <?php foreach($moneda as $k => $c_mon): ?>
                                                
                                                <option value="<?php echo $c_mon ;?>"><?php echo $k;?></option>
                                            <?php endforeach; ?>

                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-4">
                                      <label for="ce_clave_pedimento">Clave pedimento</label>
                                      <select id="ce_clave_pedimento" class="form-control">
                                          <option value="" selected>Seleccionar</option>
                                          <?php foreach($pedimets_codes as $p_code): ?>
                                              
                                              <option value="<?php echo $p_code['clave'] ;?>"><?php echo $p_code['name'];?></option>
                                          <?php endforeach; ?>
                                      </select>
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="ce_certificado_origen">Certificado origen</label>
                                      <input type="text" class="form-control" id="ce_certificado_origen" placeholder="Cert" value="">
                                      </div>
                                      <div class="form-group col-md-4">
                                      <label for="ce_inco_term">IncoTerm</label>
                                      <select id="ce_inco_term" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                        <?php foreach($incoterms as $incot): ?>
                                           
                                            <option value="<?php echo $incot['clave'];?>"><?php echo $incot['name']." - ".$r_cfdi_u['description'];?></option>
                                        <?php endforeach; ?>
                                        </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="ce_subdiv">Subdivisiòn</label>
                                          <input type="text" class="form-control" id="ce_subdiv" placeholder="Serie" value="">
                                      </div>

                                      <div class="form-group col-md-6">
                                      <label for="ce_tipo_cambio">Tipo de Cambio</label>
                                      <input type="text" class="form-control" id="ce_tipo_cambio"  value="">
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                      <label for="total">Total</label>
                                      <input type="text" class="form-control" id="ce_total"  value="">
                                      </div>
                                  </div>

                              </div>

                              <!-- =======================  Receptor ==================== -->

                              <div  id="div_receptor" class="ce_form col-sm-6 mb-4">
                                  <div class="form-row">
                                      <div class="form-group col-sm-12">
                                            <label for="ce_cp_dest">Receptor</label>
                                           
                                      </div>
                                  </div>

                                  <div class="form-row">

                                      <div class="form-group col-md-12">
                                        <label for="ce_num_reg_trib_receptor">Numero Registro Tributario</label>
                                        <input type="text" class="form-control" id="ce_num_reg_trib_receptor" placeholder="Receptor" value="">
                                      </div>
                                      <!-- <div class="form-group col-md-6">
                                        <label for="ce_nombre_receptor">Nombre Receptor</label>
                                        <input type="text" class="form-control" id="ce_nombre_receptor" placeholder="Receptor" value="">
                                      </div> -->


                                      <div class="form-group col-md-6">
                                      <label for="ce_pais_receptor">Pais</label>
                                      <select id="ce_pais_receptor" class="form-control">
                                          
                                      </select>
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                        <label for="ce_estado_receptor">Estado</label>
                                        <select id="ce_estado_receptor" class="form-control">
                                          <option value="" selected>Seleccionar</option>
                                          
                                        </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-3">
                                            <label for="ce_cp_receptor">Codigo Postal</label>
                                            <input type="text" class="form-control" id="ce_cp_receptor" placeholder="Codigo Postal" value="">
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="ce_calle_receptor">Calle</label>
                                          <input type="text" class="form-control" id="ce_calle_receptor" placeholder="Serie" value="">
                                      </div>

                                      <div class="form-group col-md-3">
                                      <label for="ce_num_ext_receptor">Num Ext.</label>
                                      <input type="text" class="form-control" id="ce_num_ext_receptor"  value="">
                                      </div>
                                  </div>

                              </div>


                              <!-- =========================== Emisor ============================ -->

                              <div id="div_emisor"  class=" col-sm-6 mb-4">

                                  <div class="form-row">
                                      <div class="form-group col-sm-12">
                                            <label for="ce_cp_dest">Emisor</label>
                                           
                                      </div>
                                  </div>
                                  <div class="form-row">

                                      <div class="form-group col-md-6">
                                        <label for="ce_curp_emisor">CURP</label>
                                        <input type="text" class="form-control" id="ce_curp_emisor" placeholder="Emisor" value="">
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="ce_nombre_emisor">Nombre Emisor</label>
                                        <input type="text" class="form-control" id="ce_nombre_emisor" placeholder="Emisor" value="">
                                      </div>


                                      <div class="form-group col-md-6">
                                      <label for="ce_pais_emisor">Pais</label>
                                      <select id="ce_pais_emisor" class="form-control">
                                      </select>
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                        <label for="ce_estado_emisor">Estado</label>
                                        <select id="ce_estado_emisor" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                         
                                        </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-3">
                                            <label for="ce_cp_emisor">Codigo Postal</label>
                                            <input type="text" class="form-control" id="ce_cp_emisor" placeholder="Codigo Postal" value="">
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="ce_calle_emisor">Calle</label>
                                          <input type="text" class="form-control" id="ce_calle_emisor" placeholder="Serie" value="">
                                      </div>

                                      <div class="form-group col-md-3">
                                      <label for="ce_num_ext_emisor">Num Ext.</label>
                                      <input type="text" class="form-control" id="ce_num_ext_emisor"  value="">
                                      </div>
                                  </div>

                              </div>


                              <!-- ========================== Destinatario========================== -->
                              <div  style="display:none;" class="ce_form1 col-sm-6 mb-4">

                                  <div class="form-row">

                                      <div class="form-group col-md-6">
                                        <label for="ce_num_reg_trib_dest">Numero Registro Tributario</label>
                                        <input type="text" class="form-control" id="ce_num_reg_trib_dest" placeholder="Destinatario" value="">
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="ce_nombre_dest">Nombre Destinatario</label>
                                        <input type="text" class="form-control" id="ce_nombre_dest" placeholder="Destinatario" value="">
                                      </div>


                                      <div class="form-group col-md-6">
                                      <label for="ce_pais_dest">Pais</label>
                                      <select id="ce_pais_dest" class="form-control">
                                          <!-- <option value="" selected>Seleccionar</option>
                                          <?php //foreach($ce_pais as $c_pais): ?>
                                              
                                              <option value="<?php //echo $c_pais['clavesat'] ;?>"><?php echo $c_pais['name'];?></option>
                                          <?php //endforeach; ?> -->
                                      </select>
                                      </div>
                                      
                                      <div class="form-group col-md-6">
                                        <label for="ce_estado_dest">Estado</label>
                                        <select id="ce_estado_dest" class="form-control">
                                        
                                        </select>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-3">
                                            <label for="ce_cp_dest">Codigo Postal</label>
                                            <input type="text" class="form-control" id="ce_cp_dest" placeholder="Codigo Postal" value="">
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="ce_calle_dest">Calle</label>
                                          <input type="text" class="form-control" id="ce_calle_dest" placeholder="Serie" value="">
                                      </div>

                                      <div class="form-group col-md-3">
                                      <label for="ce_num_ext_dest">Num Ext.</label>
                                      <input type="text" class="form-control" id="ce_num_ext_dest"  value="">
                                      </div>
                                  </div>

                              </div>


                              <div style="display:none;" class="ce_form col-sm-12">
                                <div class="form-group">
                                    <div class="form-check">
                                      <button id="clonar_tabla" style="font-size:.7rem;" type="button" class="btn btn-warning btn-sm">Traer Contenido CE</button>
                                      
                                    </div>
                                </div>


                                <!-- Conacion de tabla -->

                                <div class="row">
                                  <div class="col-sm-12 mt-2">
                                    <div class="card my-4">
                                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                        <div class="bg-gradient-primary shadow-primary border-radius-sm pt-2 pb-2">
                                            <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Comercio exterior</h6>
                                        </div>
                                        </div>
                                        <div class="card-body px-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table id="ce_table" class="articleListContainer table align-items-center justify-content-center mb-0">
                                            <thead>
                                                <tr>

                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Num Identificacion</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor U. Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor DLLS</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unidad Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clave Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fracción Arancelaria</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ce_table_body" >
                                                
                                            </tbody>

                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                              </div>
                              
                          </div>
                          

                          <div class="form-group">
                              <div class="form-check">
                                <input type="hidden" id="factura" name="factura" value="<?php echo $res_factura['id']; ?>">
                                <!-- <button id="gen_t" style="font-size:.6rem;" type="button" class="btn btn-warning btn-sm">Generar Traslado</button> -->

                                <button id="enviar_traslado" style="font-size:.7rem;" type="button" class="btn btn-warning btn-sm">Crear Factura</button>
                                
                              <!-- <button type="submit" class="btn btn-warning btn-sm">Generar Traslado</button> -->
                              </div>
                          </div>
                      </form>

                      <!-- <div style="border-top: 1px solid #f0f2f5; border-bottom: 1px solid #f0f2f5;" class="form-group mt-4 pt-4 pb-2">
                          <div class="form-check">
                            <input type="hidden" id="factura" name="factura" value="<?php echo $res_factura['id']; ?>">
                            <button id="add_producto_venta" onclick=' article.itemAdd(null,{edition:true});' style="font-size:.6rem;" type="button" class="btn btn-info btn-sm">Agregar Producto</button>
                            
                          </div>
                      </div> -->

                    </div>
                  </div>

                  <!-- buscar y agregar productos -->

                  <div class="row">
                      <div class="col-12 mt-2">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-primary shadow-primary border-radius-sm pt-2 pb-2">
                              <h6 class="text-white text-capitalize ps-3 mb-0">Agregar Producto</h6>
                          </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                          <div class="table-responsive p-0">
                              <table class="articleListContainer table align-items-center justify-content-center mb-0">
                              <thead>
                                  <tr>

                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Producto</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">P.unitario</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                  </tr>
                              </thead>
                              <tbody >
                                  <?php //foreach($res_factura['detalles'] as $f_detalle): ?>

                                      <tr class="">
                                      <td class="text-xs">
                                        <!-- <input type="text" name="" id="txt_cod_producto"> -->
                                        <select id="txt_cod_producto" class="form-control">
                                            <option value="" selected>Seleccionar</option>
                                        </select>
                                      </td>
                                      <td class=" text-xs"><input type="text" name="" id="txt_cant_producto"></td>
                                      <td class="text-xs"><input type="text" name="" id="txt_precio_u"></td>

                                      <td>
                                      <button id="add_producto_venta" class="btn btn-link text-info px-2 mb-0"><i class="material-icons text-sm me-2">add</i><span class="text-xxs">Agregar</span></button>
                                      </td>
                                      </tr>

                                  <?php //endforeach; ?>
                              </tbody>

                              </table>
                          </div>
                          </div>
                      </div>
                      </div>
                  </div>

                  <!-- table plantilla -->

                  <div class="row">
                      <div class="col-12 mt-2">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-primary shadow-primary border-radius-sm pt-2 pb-2">
                              <h6 class="text-white text-capitalize ps-3 mb-0">Detalles de Articulos</h6>
                          </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                          <div class="table-responsive p-0">
                              <table id="table_merc" class="articleListContainer table align-items-center justify-content-center mb-0">
                              <thead>
                                  <tr>

                                  <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Producto</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tax Ieps</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">P.unitario</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                  </tr>
                              </thead>
                              <tbody class="data" id="data">
                                  <?php 
                                    if($res_factura['detalles']):
                                      $decimals=4;
                                      $impuesto=0.08;
                                    foreach($res_factura['detalles'] as $f_detalle): 

                                      //$tax_ieps=(float) bcdiv($f_detalle['ieps'],"1",$decimals);
                                      //$total_sub=(float) bcdiv($f_detalle['subtotal'],"1",$decimals);
                                      $precio=(float) bcdiv($f_detalle['precio'],"1",$decimals);
                                      
                                      $precio = round($precio, 2);
                                      $subtotal = $f_detalle['cantidad'] * number_format($precio,2);

                                      $tax_ieps_percent=(float) $impuesto;
                                      $tax_ieps=$subtotal*$tax_ieps_percent;
                                      $tax_ieps=(float) bcdiv($tax_ieps,"1",$decimals);

                                      //echo $tax_ieps;
                                      
                                  ?>

                                  <tr class='item'>
                                      <td class='producto align-middle text-center text-xs'><?php echo $f_detalle['producto_id']; ?></td>
                                      <td class='producto_name text-center text-xs'><?php echo $f_detalle['producto_nombre']; ?></td>
                                      <td class='descripcion text-center text-xs'><?php echo $f_detalle['producto_id']; ?></td>
                                      <td class='quantity text-center text-xs'><?php echo $f_detalle['cantidad']; ?></td>
                                      <td class='taxIepsTotal text-center text-xs'><?php echo $tax_ieps; ?></td>
                                      <td class='preciou text-center text-xs'><?php echo $precio; ?></td>
                                      <td class='totalSub text-center text-xs'><?php echo $subtotal; ?></td>

                                      <td class="acciones">
                                      <button type='' onclick='delete_produc(this)' class='delete_produc btn btn-link text-danger text-gradient px-2 mb-0' ><i class='material-icons text-sm me-2'>delete</i><span class='text-xxs'>Borrar</span></button>

                                      </td>
                                  </tr>

                                  <?php 
                                      endforeach; 
                                    endif;
                                  ?>
                                  
                              </tbody>

                              <tfoot>
                                <tr>
                                  <!-- <td colspan="2">
                                    <div class="form-group">
                                        <div class="form-check">
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                        </div>
                                    </div>
                                  </td> -->

                                  <td  class="align-middle text-s text-right py-4 px-4" colspan="8">
                                  <div class="articleListSummaryContainer">

                                    <div class=" area2 align-item-left">
                                        <div class="part" style="display:none;">
                                            <span class="number"></span>
                                        </div>
                                        <div class="quantity" style="display:none;">
                                            <span class="number"></span>
                                        </div>
                                        <div id="divsubTotal" class="totalSub">
                                            <span class="col-sm-6 name text-left font-weight-bolder">Subtotal</span><span class="currencySign">$</span><span class="col-sm-1 number text-primary pl-0"></span>
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
                                        <div id="divTotal" class="total">
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


//$("#gen_t").click(function () { 
function timbrar(factura_id){

  if($("#ce_check").is(":checked")){

    var factura = factura_id;
    $.ajax({
        data:{
            ce: factura
        },
        url:"../../../controllers/cfdi_func/invoice-electronic-generate.php",
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
              if(requests.status!=2){
                if (result.isConfirmed) {
                  location.href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/"; ?>";
                }

              }else{
                return;
              }
              
            })
            console.log(rslt2);
            
        }
    });



  }else{

    var factura = factura_id;
    $.ajax({
        data:{
            factura: factura
        },
        url:"../../../controllers/cfdi_func/invoice-electronic-generate.php",
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
              if(requests.status!=2){
                if (result.isConfirmed) {
                  location.href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/"; ?>";
                }

              }else{
                return;
              }
              
            })
            console.log(rslt2);
            
        }
    });
  }


}

//});

function abri_xml(xml){
            var xml = xml;
            window.open("../../../resources/storage/xml/"+xml, "_blank");
        }

</script>

<script>
   $('#enviar_traslado').click(function () {
     
    var filas = $("#table_merc").find('tbody#data tr').length;
    if(filas==0){
      Swal.fire(
        '',
        'Debe ingresar al menos un articulo ',
        'warning'
      )
      //alert("Debe ingresar al menos un articulo "+filas);
      return;
    }
    
    var query_string="";

    var divSubtotal = $("#divsubTotal > .number").text();
    divSubtotal = divSubtotal.replace(/,/g, "");

    var divTotal = $("#divTotal > .number").text();
    divTotal = divTotal.replace(/,/g, "");

    query_string+="&folio="+encodeURIComponent($("#folio:eq(0)").val())
					+"&serie_folio="+$("#serie_folio:eq(0)").val()

					// Version 4.0 Exportacion 
					+"&c_exportacion="+$("#c_exportacion:eq(0)").val()
					+"&invoice_folio="+$("#invoice_folio:eq(0)").val()
					+"&cliente="+$("#cliente:eq(0)").val()
					
					+"&referencia="+encodeURIComponent($("#referencia:eq(0)").val())
					+"&forma_pago="+$("#forma_pago:eq(0)").val() 
					+"&payment_agreement="+$("#payment_agreement:eq(0)").val() 
					+"&condicion_pago="+$("#condicion_pago:eq(0)").val()
					+"&metodo_pago="+$("#metodo_pago:eq(0)").val()
					+"&fecha="+$("#fecha:eq(0)").val()
          +"&moneda="+$("#moneda:eq(0)").val()
          +"&tipo_cambio="+$("#tipo_cambio:eq(0)").val()
          +"&observaciones="+$("#observaciones:eq(0)").val()

					//+"&reemplazofactura="+(UUIDREMP)
					//+"&reemplazofactura_folio="+(FOLIOREMP)

           // +"&multiUid="+encodeURIComponent(allFolioRemp)
           // +"&multiUid2="+encodeURIComponent(allUuidRemp)
           // +"&replaceUid="+encodeURIComponent($("#replaceUid1:eq(0)").val())
            
					+"&cfdi_use="+$("#cfdi_use:eq(0)").val()
					+"&complemento="+$("#complemento:eq(0)").val()
				  +"&cliente_nombre="+encodeURIComponent($("#cliente_nombre:eq(0)").val())
					+"&cliente_email="+encodeURIComponent($("#cliente_email:eq(0)").val())
					+"&cliente_RFC="+encodeURIComponent($("#cliente_RFC:eq(0)").val())
          +"&divSubtotal="+divSubtotal
          +"&divTotal="+divTotal
					
					;


          if($("#ce_check").is(":checked")){

            query_string+="&c_type_of_operation="+$("#ce_tipo_operacion:eq(0)").val()
            +"&c_clave_pedimento="+$("#ce_clave_pedimento:eq(0)").val()
            +"&c_cert_origen="+$("#ce_certificado_origen:eq(0)").val()
            +"&c_incoterm="+$("#ce_inco_term:eq(0)").val()
            +"&c_subdivision="+$("#ce_subdiv:eq(0)").val()
            //+"&c_num_export_conf="+$("#cliente_RFC:eq(0)").val()
            //+"&c_observaciones="+$("#cliente_RFC:eq(0)").val()


            /* ===== Destinatario ==== */
            /* +"&c_numregistro_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_nombre_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_pais_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_estado_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_cp_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_calle_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_int_dest="+$("#cliente_RFC:eq(0)").val()
            +"&c_ext_dest="+$("#cliente_RFC:eq(0)").val() */

            query_string+="&c_numregistro_recep="+$("#ce_num_reg_trib_receptor:eq(0)").val()
            //+"&c_residencia_recep="+$("#cliente_RFC:eq(0)").val()
            +"&c_pais_recep="+$("#ce_pais_receptor:eq(0)").val()
            +"&c_estado_recep="+$("#ce_estado_receptor:eq(0)").val()
            +"&c_cp_recep="+$("#ce_cp_receptor:eq(0)").val()
            +"&c_calle_recep="+$("#ce_calle_receptor:eq(0)").val()
            //+"&c_int_recep="+$("#cliente_RFC:eq(0)").val()
            +"&c_ext_recep="+$("#ce_num_ext_receptor:eq(0)").val()
            
            +"&c_curp="+$("#ce_curp_emisor:eq(0)").val()
            +"&c_pais_emisor="+$("#ce_pais_emisor:eq(0)").val()
            +"&c_estado_emisor="+$("#ce_estado_emisor:eq(0)").val()
            +"&c_cp_emisor="+$("#ce_cp_emisor:eq(0)").val()
            +"&c_calle_emisor="+$("#ce_calle_emisor:eq(0)").val()
            //+"&c_int_emisor="+$("#cliente_RFC:eq(0)").val()
            +"&c_ext_emisor="+$("#ce_num_ext_emisor:eq(0)").val();



            var ce_productos = [];
            
            document.querySelectorAll('#ce_table tbody#ce_table_body tr').forEach(function(e){
              var i=0;
              var fila = {
              // factura: requests.data,pesokg: e.querySelector('.pesokg input').value,
                c_numident: e.querySelector('.producto').innerText,
                c_fraccion_arancelaria: e.querySelector('.c_fraccion_arancelaria .fracc_ar').value,
                c_cantidad_aduana: e.querySelector('.c_cantidad_aduana input').value,
                c_valor_unitario_aduana: e.querySelector('.c_valor_unitario_aduana input').value,
                c_valor_dolares: e.querySelector('.c_valor_dolares input').value,
                c_unidad_aduana: e.querySelector('.c_unidad_aduana input').value,
                c_clave_aduana: e.querySelector('.c_clave_aduana input').value,
              };
              ce_productos.push(fila);
              i++;
            });


            query_string+="&ce_details="+JSON.stringify(ce_productos);




          }

            var productos = [];

            document.querySelectorAll('#table_merc tbody#data tr').forEach(function(e){
              var i=0;
              var fila = {
               // factura: requests.data,
                producto: e.querySelector('.producto').innerText,
                productonombre: e.querySelector('.producto_name').innerText,
                descripcion: e.querySelector('.descripcion').innerText,
                cantidad: e.querySelector('.quantity').innerText,
                taxIepsTotal: e.querySelector('.taxIepsTotal').innerText,
                preciou: e.querySelector('.preciou').innerText,
                totalSub: e.querySelector('.totalSub').innerText
              };
              productos.push(fila);
              i++;
            });


						query_string+="&detalles="+JSON.stringify(productos);
          

          //alert(query_string);
          console.log(query_string);
          //return;
          
      $.ajax({
      url:"../../../controllers/cfdi_func/factura_insert.php",
			type: "POST",
      dataType:"text",
        data: query_string,
        success: function (rslt2) { 
          //alert('Datos enviados !!!'); 
          console.log(rslt2);

          var requests=JSON.parse(rslt2), request=( requests && typeof requests ==='object' ? requests[0] : null ), class_name="", msg="";

          var option ="";
          if(requests.status==1){
            option='success';

            /* var productos = [];

            document.querySelectorAll('#table_merc tbody#data tr').forEach(function(e){
              var i=0;
              var fila = {
                factura: requests.data,
                producto: e.querySelector('.producto').innerText,
                productonombre: e.querySelector('.producto_name').innerText,
                descripcion: e.querySelector('.descripcion').innerText,
                cantidad: e.querySelector('.quantity').innerText,
                taxIepsTotal: e.querySelector('.taxIepsTotal').innerText,
                preciou: e.querySelector('.preciou').innerText,
                totalSub: e.querySelector('.totalSub').innerText
              };
              productos.push(fila);
              i++;
            });

            $.ajax({
              url:"../../../controllers/cfdi_func/factura_detalle_insert.php",
              type: "POST",
              data: {
                "productos":JSON.stringify(productos)
              },
              async: true,
              success: function (rslt2) { 
                  console.log(rslt2);
                
              } 
            }); */

            
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
            if(requests.status!=2){
              if (result.isConfirmed) {
                //location.reload();
                timbrar(requests.data);
              }

            }else{
              return;
            }
            
          })

        } 
      });

   });


   $("#add_producto_venta").click(function () { 
     //e.preventDefault();
     //alert("test");

     var cant_pro_lngt = $("#txt_cant_producto").val();
     if(cant_pro_lngt.length > 0){

       var producto = $("#txt_cod_producto").val();
       var cantidad = $("#txt_cant_producto").val();
       var precio = $("#txt_precio_u").val();
       var action = "addProductoDetalle";

       $.ajax({
        url:"../../../controllers/cfdi_func/get_productos.php",
			  type: "POST",
        data: {
          action: action,
          producto: producto,
          precio: precio,
          cantidad: cantidad
        },
        async: true,
        success: function (rslt2) { 
          //alert('Datos enviados !!!'); 

          if(rslt2!="Error"){
            var info = JSON.parse(rslt2);
            //console.log(info);
            $("#data").append(info);

            detailsCalculateSummary();

            /* limpiar inputs */
            $("#txt_cod_producto").val('');
            $("#txt_cod_producto").find('option').remove();
            $("#txt_cant_producto").val('');
            $("#txt_precio_u").val('');

          }else{
            console.log("No exite registro");
          }
          
        } 
      });
     }
     
   });


  function delete_produc(xml){
      var xml = xml;

      $(xml).parent().parent().remove();
      detailsCalculateSummary();

  }

  $("#moneda").change(function (e) { 
    if($(this).val()=="MXN"){
      $("#tipo_cambio").val(1);

    }else{
      $("#tipo_cambio").val(2);
    }
    
  });


  $("#cliente").select2({
        placeholder: 'Selecciona el cliente',
        //minimumInputLength: 1,
        formatInputTooShort: "", 
        ajax: { 
          
          url: "../../../controllers/cfdi_func/ajax.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          async:false,
          data: function (params) {
            return {
              cliente: params.term // search term
            };
          },
          processResults: function (response) {
            console.log(response);
            return {
            results: response
            
            };
          },
          cache: true
        },
        
  }); 


  $('#cliente').on("select2:select", function(e) { 
		var cliente_res = $("#cliente").val();
 		$.ajax({
			data:{
				cliente_res: cliente_res
			},
			url:"../../../controllers/cfdi_func/ajax.php",
			type: "POST",
			success: function(rslt2){
				rslt2 = JSON.parse(rslt2);
				//console.log(rslt2);

				$("#cliente_rfc").empty();
				$("#cliente_nombre").empty();
				$("#cliente_email").empty();

        $("#cliente_rfc").val(rslt2.rfc);
				$("#cliente_nombre").val(rslt2.cliente);
				$("#cliente_email").val(rslt2.email);

        if($("#cliente_rfc").val()=="XEXX010101000"){
          $(".ce_form").show();
          $('#ce_check').prop('checked',true);
          $("#moneda").val("USD");

          $("#div_emisor").css("display","block");
          $("#div_receptor").css("display","block");

        }else{
          $(".ce_form").hide();
          $('#ce_check').prop('checked',false);

          $("#div_emisor").css("display","none");
          $("#div_receptor").css("display","none");

          $("#moneda").val("");
        }

        
				
			}
		}); 

	});




$("#uuid_folio").select2({
    placeholder: 'Selecciona Factura',
    //minimumInputLength: 1,
    formatInputTooShort: "",
    ajax: { 
      
      url: "../../../controllers/cfdi_func/ajax.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      async:false,
      data: function (params) {
        return {
          uuid_folio: params.term // search term
        };
      },
      processResults: function (response) {
        //console.log(response);
        return {
        results: response
        
        };
      },
      cache: true
    },
        
});  

$("#txt_cod_producto").select2({
    placeholder: 'Selecciona Producto',
    //minimumInputLength: 1,
    formatInputTooShort: "",
    ajax: { 
      
      url: "../../../controllers/cfdi_func/ajax.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      async:false,
      data: function (params) {
        return {
          txt_cod_producto: params.term // search term
        };
      },
      processResults: function (response) {
        //console.log(response);
        return {
        results: response
        
        };
      },
      cache: true
    },
        
}); 

 </script>


<script>


$("#referencia").select2({
    placeholder: 'buscar venta',
    //minimumInputLength: 1,
    formatInputTooShort: "",
    ajax: { 
      
      url: "../../../controllers/cfdi_func/ajax.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      async:false,
      data: function (params) {
        return {
          referencia: params.term // search term
        };
      },
      processResults: function (response) {
        //console.log(response);
        return {
        results: response
        
        };
      },
      cache: true
    },
        
});  



$('#referencia').on("select2:select", function(e) { 
		var referencia_res = $("#referencia").val();
    //alert($referencia_res);

    location.href = "<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>/views/facturas/insert/?venta="+referencia_res;


});

$("#ce_pais_emisor").select2({
    placeholder: 'Buscar Pais',
    //minimumInputLength: 1,
    formatInputTooShort: "",
    ajax: { 
      
      url: "../../../controllers/cfdi_func/ajax.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      async:false,
      data: function (params) {
        return {
          ce_pais: params.term // search term
        };
      },
      processResults: function (response) {
        //console.log(response);
        return {
        results: response
        
        };
      },
      cache: true
    },
        
});

$('#ce_pais_emisor').on("select2:select", function(e) { 
		var pais_res = $("#ce_pais_emisor").val();
 		$.ajax({
			data:{
				ce_pais_res: pais_res
			},
			url:"../../../controllers/cfdi_func/ajax.php",
			type: "POST",
			success: function(rslt2){
				rslt2 = JSON.parse(rslt2);
				//console.log(rslt2);
        $("#ce_estado_emisor").val('');
        $("#ce_estado_emisor").find('option').remove();

				$("#ce_estado_emisor").prop("disabled",false);
					$("#ce_estado_emisor").append('<option value="0" selected disabled>Seleccione un estado</option>');
					$.each(rslt2,function(key, registro) {
						$("#ce_estado_emisor").append('<option value='+registro.id+'>'+registro.text+'</option>');
					}); 
        
				
			}
		}); 

});

  /* ===================================================== */

$("#ce_pais_receptor").select2({
    placeholder: 'Buscar Pais',
    //minimumInputLength: 1,
    formatInputTooShort: "",
    ajax: { 
      
      url: "../../../controllers/cfdi_func/ajax.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      async:false,
      data: function (params) {
        return {
          ce_pais: params.term // search term
        };
      },
      processResults: function (response) {
        //console.log(response);
        return {
        results: response
        
        };
      },
      cache: true
    },
        
});

$('#ce_pais_receptor').on("select2:select", function(e) { 
		var pais_res = $("#ce_pais_receptor").val();
 		$.ajax({
			data:{
				ce_pais_res: pais_res
			},
			url:"../../../controllers/cfdi_func/ajax.php",
			type: "POST",
			success: function(rslt2){
				rslt2 = JSON.parse(rslt2);
				//console.log(rslt2);
        $("#ce_estado_receptor").val('');
        $("#ce_estado_receptor").find('option').remove();

				$("#ce_estado_receptor").prop("disabled",false);
					$("#ce_estado_receptor").append('<option value="0" selected disabled>Seleccione un estado</option>');
					$.each(rslt2,function(key, registro) {
						$("#ce_estado_receptor").append('<option value='+registro.id+'>'+registro.text+'</option>');
					}); 
        
				
			}
		}); 

});


</script>
 

<script>
  $(document).ready(function () {
    $("#div_emisor").css("display","none");
    $("#div_receptor").css("display","none");

    <?php if($venta or $factura):?>

      var cliente_res = "<?php echo $res_factura['cliente_id']; ?>";
 		$.ajax({
			data:{
				cliente_res: cliente_res
			},
			url:"../../../controllers/cfdi_func/ajax.php",
			type: "POST",
			success: function(rslt2){
				rslt2 = JSON.parse(rslt2);
				//console.log(rslt2);

				$("#cliente_rfc").empty();
				$("#cliente_nombre").empty();
				$("#cliente_email").empty();

        $("#cliente_rfc").val(rslt2.rfc);
				$("#cliente_nombre").val(rslt2.cliente);
				$("#cliente_email").val(rslt2.email);

        $("#cliente").append('<option selected="selected" value='+rslt2.id+'>'+rslt2.id+'</option>');

        if($("#cliente_rfc").val()=="XEXX010101000"){
          $(".ce_form").show();
          $('#ce_check').prop('checked',true);
          $("#moneda").val("USD");

          $("#div_emisor").css("display","block");
          $("#div_receptor").css("display","block");

        }else{
          $(".ce_form").hide();
          $('#ce_check').prop('checked',false);
          $("#moneda").val("");

          $("#div_emisor").css("display","none");
          $("#div_receptor").css("display","none");
        }

				
			}
		}); 


    <?php endif;?>


    /* Comercio exterior */

    $("#ce_check").click(function (e) { 
      if($("#cliente_rfc").val()=="XEXX010101000"){
        $('#ce_check').prop('checked',true);
        $(".ce_form").show();
        $("#moneda").val("USD");

        $("#div_emisor").css("display","block");
        $("#div_receptor").css("display","block");

      }else{
        //alert("Cliente no extranjero, revise el RFC");
        Swal.fire(
        'Comercio Exterior',
        'Cliente no extranjero, verifique el RFC',
        'info'
        ) 
        $('#ce_check').prop('checked',false);
        return;
      }
      
    });



    /* ================= */
    
  });


  /* ================== Clonar tabla para comercio exterior ==================== */


    $('#clonar_tabla').click(function (e) { 

      var filas = $("#table_merc").find('tbody#data tr').length;

      if(filas==0){
        Swal.fire(
          '',
          'Debe ingresar al menos un articulo para usar esta opciòn',
          'warning'
        )
        //alert("Debe ingresar al menos un articulo "+filas);
        return;
      }

      $('#table_merc tbody#data').children("tr").clone().appendTo("#ce_table tbody#ce_table_body").find(':text').val('');
      $("#ce_table tbody#ce_table_body tr").find('td.descripcion').remove();
      $("#ce_table tbody#ce_table_body tr").find('td.taxIepsTotal').remove();
      $("#ce_table tbody#ce_table_body tr").find('td.preciou').remove();
      $("#ce_table tbody#ce_table_body tr").find('td.totalSub').remove();
      $("#ce_table tbody#ce_table_body tr").find('td.acciones').remove();
      //$("#ce_table tbody#ce_table_body tr").find('td.delete_produc').remove();
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_cantidad_aduana text-center text-xs'><input class='form-control' type='text' value=''></td>");
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_valor_unitario_aduana text-center text-xs'><input class='form-control' type='text' value=''></td>");
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_valor_dolares text-center text-xs'><input class='form-control' type='text' value=''></td>");
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_unidad_aduana text-center text-xs'><input class='form-control' type='text' value=''></td>");
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_clave_aduana text-center text-xs'><input class='form-control' type='text' value=''></td>");
      $("#ce_table tbody#ce_table_body tr").append("<td class='c_fraccion_arancelaria text-center text-xs'><select class='fracc_ar form-control'><option value='' selected>Seleccionar</option></select></td>");
  

        $(".fracc_ar").select2({
            placeholder: 'buscar Fraccion',
            //minimumInputLength: 1,
            formatInputTooShort: "",
            ajax: { 
              
              url: "../../../controllers/cfdi_func/ajax.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              async:false,
              data: function (params) {
                return {
                  fraccion_ar: params.term // search term
                };
              },
              processResults: function (response) {
                //console.log(response);
                return {
                results: response
                
                };
              },
              cache: true
            },
                
        });  

        $(this).prop("disabled",true);
  });
</script>

</body>
</html>