<?php 
error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
include("../../../models/catalogs.php");
$conn=superConn();
$forma_pago_cat = getFormaPago();
$moneda=getMoneda();

if(!$_GET["pagina"]){
  header("Location:?pagina=1");

}

$paginaI=$_GET["pagina"];
$limite=10;
$filtro="empty";
$reg_pagos = getPagos($filtro,$limite,$paginaI);

if($reg_pagos){
  $reg_pagopag = getPagosPag($filtro);

  $registros = count($reg_pagopag); 
  //$cant_art= $registros;
  $paginas=$registros/10;
  $paginas=ceil($paginas);

  $files = get_filesP();
}



//echo json_encode($forma_pago_cat);
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
    
    <script src="https://use.fontawesome.com/60a59d8345.js"></script>

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
          .navbar-vertical.navbar-expand-xs .navbar-collapse {
              height: calc(120vh - 360px) !important;
          }
          .page-item.active .page-link {
              z-index: 3;
              color: #fff;
              background-color: #1A73E8;
              border-color: #1A73E8;
          }
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
          .select2-container {
            /* width:100% !important; */
          }
        </style>
    
    <title>Pagos</title>

</head>

<body class="g-sidenav-show bg-gray-200">

<!-- aside -->

<?php include ('../../componentes/aside.php')?>

<!-- ===== -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>">Inicio</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pagos</li>
            </ol>
            <!-- <h6 class="font-weight-bolder mb-0">Tables</h6> -->
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <div class="input-group input-group-outline">
                <label class="form-label">Buscar...</label>
                <input id="filtro" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
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
              <?php include ('../../componentes/config.php')?>
              <li class="nav-item dropdown pe-2 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell cursor-pointer" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                  <li class="mb-2">
                    <a class="dropdown-item border-radius-md" href="javascript:;">
                      <div class="d-flex py-1">
                        <div class="my-auto">
                          <img src="../../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
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
                          <img src="../../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
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

      <div class="container-fluid py-4">

        <div class="row">
              <div class="col-12">
                  <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 position-relative">
                            <div class="container">
                              <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                  <h6 class="mb-0 text-white text-capitalize ps-1">Pagos</h6>
                                </div>
                                <div class="col-sm-4 col-md-6 text-end">
                                  <button class="btn bg-gradient-info mb-0" data-toggle="modal" data-target="#exampleModal"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Agregar Pago</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                              <table id="table_res" class="table align-items-center justify-content-center mb-0">
                                  <thead>
                                      <tr>

                                          <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Factura</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Importe</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Observaciones</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Moneda</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>

                                      </tr>
                                  </thead>
                                  <tbody id="tbody_res">
                                  <?php if($reg_pagos): ?>
                                  <?php foreach($reg_pagos as $r_pago): ?>

                                      <tr>
                                          <th class="align-middle text-center text-xs"><?php echo $r_pago['id']; ?></th>
                                          <td class="align-middle text-center text-xs"><?php echo $r_pago['factura']; ?></td>
                                          <td class="align-middle text-center text-xs text-success"><?php echo "$ ".sprintf('%01.2f', $r_pago['import']); ?></td>
                                          <td class="align-middle text-center text-xs"><?php echo $r_pago['comment']; ?></td>
                                          <td class="text-center text-xs text-info"><?php echo $r_pago['tipo_moneda']; ?></td>
                                          <td class="text-center text-xs"><?php echo $r_pago['status']; ?></td>
                                          <td>
                                          <button onclick='ver_pago(<?php echo $r_pago["id"]; ?>)' style="font-size:.6rem;" type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal" data-target="#pagoModal2">ver</button>

                                          <?php 
                                              //$xml_path = array_search($r_factura['serie'].$r_factura['folio'].".xml",$files,false); 
                                              $xml_path = in_array($r_pago['serie'].$r_pago['folio'].".xml", $files,false);
                                              $xml = $r_pago['serie'].$r_pago['folio'].".xml";
                                          ?>

                                          <?php if($xml_path) :?>

                                              <button onclick='abri_xml("<?php echo $xml; ?>")'  style="font-size:.6rem;" type="button" class="btn btn-success btn-sm">XML</button>
                                              
                                              <input type="hidden" class="factura" name="factura" value="<?php echo $r_pago['id']; ?>">
                                              <input type="hidden" class="folio_xml" name="folio_xml" value="<?php echo $r_pago['serie'].$r_pago['folio']; ?>">
                                                  
                                              <button id="get_xml" onclick='timbrar(this)' style="font-size:.6rem;" type="button" class="get_xml btn btn-warning btn-sm">Reconstruir</button>
                                              
                                          <?php else:?>

                                                  <input type="hidden" class="factura" name="factura" value="<?php echo $r_pago['id']; ?>">
                                                  <input type="hidden" class="folio_xml" name="folio_xml" value="<?php echo $r_pago['serie'].$r_pago['folio']; ?>">
                                                  
                                                  <button id="get_xml" onclick='timbrar(this)' style="font-size:.6rem;" type="button" class="get_xml btn btn-warning btn-sm">generar</button>
                                                  

                                          <?php endif; ?>

                                          </td>
                                      </tr>

                                  <?php endforeach; ?>
                                  <?php endif; ?>
                                  </tbody>
                              </table>
                                
                            </div>
                        </div>
                          <!-- paginacion -->

                          <div class="card-footer p-3">
                          <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                              <li class="page-item <?php echo $_GET['pagina']<=1?'disabled':''; ?>">
                                <a class="page-link" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>/views/pagos/search/?pagina=<?php echo $_GET['pagina']-1; ?>" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                  <span class="sr-only">Previous</span>
                                </a>
                              </li>
                              <?php 
                                $sig_pag =9;
                              for ($i = 0; $i < ($paginas>8?8:$paginas); $i++) :
                              ?>
                              <li class="page-item <?php echo $_GET['pagina']==$i+1 ? "active":""; ?>"><a class="page-link" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>/views/pagos/search/?pagina=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></li>
                              <?php endfor; ?>
                              <span class="mx-2">...</span>

                              <?php if($_GET['pagina']>=$sig_pag): ?>
                              <li class="page-item  active"><a class="page-link" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>/views/pagos/search/?pagina=<?php echo $i+1; ?>"><?php echo $_GET['pagina']; ?></a></li>
                              <?php endif; ?>
                              
                              <li class="page-item <?php echo $_GET['pagina']>=$paginas?'disabled':''; ?>">
                                <a class="page-link" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>/views/pagos/search/?pagina=<?php echo $_GET['pagina']+1; ?>" aria-label="Next">
                                  <span aria-hidden="true">&raquo;</span>
                                  <span class="sr-only">Next</span>
                                </a>
                              </li>
                            </ul>
                          </nav>
                        </div>

                        <!-- Fin paginacion -->

                  </div>
              </div>
        </div>

      </div>

    </div>

        <!-- ======================= Modal agregar ========================== -->
      <div class="modal fade bd-example-modal-lg" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Agregando Pago</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="container px-2 px-md-4 bs-white">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="card z-index-0 fadeIn3 fadeInBottom">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-sm-12 mb-4">
                                        <form id="form_modal" class="form">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                <label for="cliente">Cliente</label><br>
                                                <select id="cliente" class="form-control">
                                                <option value="" selected>Seleccionar</option>
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

                                                  <label for="forma_pago">Forma de Pago</label><br>
                                                    <!-- <input type="text" class="form-control" id="forma_pago" placeholder=""> -->
                                                    <select id="forma_pago" class="form-control">
                                                    <option value="0" selected disabled>Seleccionar</option>
                                                      <?php foreach($forma_pago_cat as $forma_pago): ?>
                                                        <option value="<?php echo $forma_pago['clave']; ?>" ><?php echo $forma_pago['clave']." - ".$forma_pago['descripcion']; ?></option>
                                                      <?php endforeach;?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-12">
                                                  <label for="observaciones">Observaciones</label>
                                                  <textarea id="observaciones" class="form-control"></textarea>

                                            </div>
                                            </div>
                                        </form>
                                      </div>
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
                              <h6 class="text-white text-capitalize ps-3 mb-0">Facturas</h6>
                          </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                          <div class="table-responsive p-0">
                              <table id="table_fact" class="articleListContainer table align-items-center justify-content-center mb-0">
                              <thead>
                                  <tr>

                                  <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Factura</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto a Pagar</th>
                                  </tr>
                              </thead>
                              <tbody class="data" id="data">

                              </tbody>

                              </table>
                          </div>
                          </div>
                      </div>
                      </div>
                  </div>

                  <button id="enviar_pago" type="button" class="btn btn-info">Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>


              <!-- Modal ver -->
      <div class="modal fade bd-example-modal-lg" id="pagoModal2" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="pagoModalLabel">Información de Pago</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="container px-2 px-md-4 bs-white">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="card z-index-0 fadeIn3 fadeInBottom">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-sm-12 mb-4">
                                        <form id="form_modal" class="form">
                                            <div class="form-row">
                                              <div class="form-group col-md-12">
                                              <label for="cliente">Cliente</label>
                                              <input type="text" class="form-control" id="cliente" placeholder="">
                                              </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                <label for="name">Factura</label>
                                                <input type="text" class="form-control" id="factura" placeholder="">
                                                </div>
                                                <div class="form-group col-md-3">
                                                <label for="moneda_v">Moneda</label>
                                                <input type="text" class="form-control" id="moneda_v" placeholder="">
                                                </div>
                                                <div class="form-group col-md-3">
                                                <label for="fecha_v">Fecha</label>
                                                <input type="text" class="form-control" id="fecha_v" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                <label for="metodo">Metodo</label>
                                                <input type="text" class="form-control" id="metodo" placeholder="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                <label for="import">Importe</label>
                                                <input type="text" class="form-control" id="import" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">

                                                <div class="form-group col-md-12">
                                                <label for="comment">comment</label>
                                                  <textarea id="comment" class="form-control" disabled></textarea>
                                                </div>
                                                
                                            </div>

                                            <!-- <button id="enviar_chofer" type="button" class="btn btn-info">Guardar</button> -->
                                        </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ==================================================================== -->
     <script>
        //$(".get_xml").click(function () { 
        function timbrar(pago_id){

          var pago = $(pago_id).siblings('.factura').val();
          var folio_xml = $(pago_id).siblings('.folio_xml').val();

          //var pago = pago_id;
          //console.log(pago);
          $.ajax({
              data:{
                  pago: pago,
                  folio_xml:folio_xml
              },
              url:"../../../controllers/cfdi_func/invoice-electronic-generate-pago.php",
              type: "POST",
              success: function(rslt2){
                  console.log(rslt2);
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
                        location.href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/pagos/search"; ?>";
                      }

                    }else{
                      return;
                    }
                    
                  })
                  console.log(rslt2);
                  
              }
          });
          
        }
            
        //});
        

        function abri_xml(xml){
            var xml = xml;
            window.open("../../../resources/storage/xml/pagos/"+xml, "_blank");
        }



        $( "#filtro" ).keyup(function() {
          //alert( $(this).val() );

          var filtro = $(this).val();
          var fil_length = filtro.length;

          var paginas =<?php echo $paginaI;?>;
          var limite = "<?php echo $limite;?>";
         // alert(fil_length);

          if(fil_length>0){
            filtro1=filtro;

          }else{
            filtro1="empty";
          }

          //return;
          $.ajax({
                data:{
                  filtro_driver: filtro1,
                  pagina_limite:limite,
                  pagina_i:paginas
                },
                url:"../../../controllers/cfdi_func/ajax.php",
                type: "POST",
                success: function(rslt2){

                  $("#tbody_res").html(rslt2);
                    //console.log(rslt2); 
                    
                }
            });
        });
 		
    </script>

    <script>

$('#enviar_pago').click(function () {
     
     var filas = $("#table_fact").find('tbody#data tr').length;
     if(filas==0){
       Swal.fire(
         '',
         'Debe ingresar al menos una factura ',
         'warning'
       )
       //alert("Debe ingresar al menos un articulo "+filas);
       return;
     }
     
     var query_string="";
 
     query_string+="&cliente="+$("#cliente:eq(0)").val()
           +"&forma_pago="+$("#forma_pago:eq(0)").val() 
           +"&fecha="+$("#fecha:eq(0)").val()
           +"&moneda="+$("#moneda:eq(0)").val()
           +"&observaciones="+$("#observaciones:eq(0)").val()
           
           ;
 
             var facturas_id = [];
 
             document.querySelectorAll('#table_fact tbody#data tr').forEach(function(e){
               var i=0;
               var fila = {
                // factura: requests.data,
                 factura: e.querySelector('.factura').innerText,
                 importe_pago: e.querySelector('.importe_factura input').value
               };
               facturas_id.push(fila);
               i++;
             });
 
 
             query_string+="&facturas="+JSON.stringify(facturas_id);
           
 
           //alert(query_string);
           //console.log(query_string);
           //return;
           
       $.ajax({
       url:"../../../controllers/cfdi_func/pago_insert.php",
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
             
           }else{
             option = 'warning'
           }
 
           Swal.fire({
             title: 'Pago',
             text: requests.msg,
             icon: option,
             showCancelButton: false,
             confirmButtonText: 'OK!'
           }).then((result) => {
             if(requests.status!=2){
               if (result.isConfirmed) {
                 location.reload();
                 //timbrar(requests.data);
               }
 
             }else{
               return;
             }
             
           })
 
         } 
       });
 
    });

    </script>

    <script>

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
                  //console.log(response);
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
              cliente_res_pago: cliente_res
            },
            url:"../../../controllers/cfdi_func/ajax.php",
            type: "POST",
            success: function(rslt2){
              var info = JSON.parse(rslt2);
              console.log(rslt2);
              $("#data").append(info);      
              
            }
          }); 

        });


      /* ============== Editar Chofer ================ */

      function ver_pago(pago_id){
        //alert("test");
        $.ajax({
            data:{
              pago_id: pago_id,
            },
            url:"../../../controllers/cfdi_func/ajax.php",
            type: "POST",
            success: function(rslt2){
              rslt2 = JSON.parse(rslt2);
              console.log(rslt2)
              $("#factura").empty();
              $("#metodo").empty();
              $("#comment").empty();
              $("#fecha_v").empty();
              $("#import").empty();
              $("#moneda_v").empty();
              $("#cliente").empty();

              $("#pagoModal2 #factura").val(rslt2.factura);
              $("#pagoModal2 #metodo").val(rslt2.method);
              $("#pagoModal2 #comment").val(rslt2.comment);

              $("#pagoModal2 #fecha_v").val(rslt2.fecha);
              $("#pagoModal2 #import").val("$ "+rslt2.import);
              $("#pagoModal2 #moneda_v").val(rslt2.tipo_moneda);
              $("#pagoModal2 #cliente").val(rslt2.cliente);
                
            }
        });

      }


      /* ============================================ */

    </script>

    <script>

    $(document).ready(function () {


            $('li.nav-item a').removeClass("active");
            $('li.nav-item a').removeClass("bg-gradient-primary");
            $("#menu_pagos").addClass("active");
            $("#menu_pagos").addClass("bg-gradient-primary");

            $("#pagoModal2 input").prop('disabled', true);

      
    });
    </script>

      <!--   Core JS Files   -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>
</html>