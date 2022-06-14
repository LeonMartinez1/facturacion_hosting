<?php 
error_reporting(E_ALL ^ E_NOTICE);

include("../../../models/catalogs.php");


$conf_v = getConfV();
//echo json_encode($res_venta);
//echo $venta;

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

    <title>Camiones</title>
</head>
<body class="bg-gray-200">
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>">Inicio</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a class="opacity-5 text-dark" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/camiones/search/"; ?>">Camiones</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Agregar camion</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Agregar Camion</h6>
    </nav>
<!--     <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
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
    </div> -->
    </div>
</nav>

<div class="container px-2 px-md-4 bs-white">
    <div class="row">
        <div class="col-sm-12">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-4">
                            <form clas="form">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="number">Numero economico</label>
                                    <input type="text" class="form-control" id="number" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="brand">Marca</label>
                                    <input type="text" class="form-control" id="brand" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="model">Modelo</label>
                                    <input type="text" class="form-control" id="model" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="year">Año</label>
                                    <input type="text" class="form-control" id="year" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="serie">Serie</label>
                                    <input type="text" class="form-control" id="serie" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                    <label for="plaque">Placa</label>
                                    <input type="text" class="form-control" id="plaque" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="nombre_aseg">Nombre Aseguradora</label>
                                    <input type="text" class="form-control" id="nombre_aseg" placeholder="Password">
                                    </div>
                                    <div class="form-group col-md-4">
                                    <label for="num_poliza_seguro">Nimero de Poliza</label>
                                    <input type="text" class="form-control" id="num_poliza_seguro" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    
                                    <div class="form-group col-md-6">
                                    <label for="nombre_aseg_med_amb">Aseguradora Medio Amb.</label>
                                    <input type="text" class="form-control" id="nombre_aseg_med_amb" placeholder="Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="num_poliza_seg_med_amb">Numero de Poliza Med. Amb.</label>
                                    <input type="text" class="form-control" id="num_poliza_seg_med_amb" placeholder="Email">
                                    </div>

                                </div>

                                <div class="form-row">
                                    
                                    <div class="form-group col-md-6">
                                    <label for="num_permiso_sct">Numero permiso SCT</label>
                                    <input type="text" class="form-control" id="num_permiso_sct" placeholder="Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="perm_sct">Permiso SCT</label>
                                    <input type="text" class="form-control" id="perm_sct" placeholder="Email">
                                    </div>

                                </div>

                                <div class="form-row">
                                    
                                <div class="form-group col-md-12">
                                    <label for="config_vehicular">Configuracion Vehicular</label>
                                    <select id="config_vehicular" class="form-control">
                                        <option value="" selected>Seleccionar</option>
                                        <?php foreach($conf_v as $c_v): ?>
                                            <option value="<?php echo $c_v['clave'];?>"><?php echo $c_v['clave']." - ".$c_v['description'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                    <label for="capacity_cubic_meter">Capacidad Volumetrica  (Mts3)</label>
                                    <input type="text" class="form-control" id="capacity_cubic_meter">
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                    <label for="capacity_tonne">Capacidad Carga (Tonelada)</label>
                                    <input type="text" class="form-control" id="capacity_tonne">
                                    </div>

                                    <div class="form-group col-md-4">
                                    <label for="diesel_performance">Rendimiento Km/Lt</label>
                                    <input type="text" class="form-control" id="diesel_performance">
                                    </div>
                                </div>
                                <button id="enviar_camion" type="button" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $('#enviar_camion').click(function () {
     
     
     var query_string="";

     query_string+="&number="+$("#number:eq(0)").val()
						+"&name="+$("#name:eq(0)").val()
						+"&brand="+$("#brand:eq(0)").val()
						+"&model="+$("#model:eq(0)").val()
						+"&year="+$("#year:eq(0)").val()
						+"&serie="+$("#serie:eq(0)").val()
						+"&plaque="+$("#plaque:eq(0)").val()
						+"&capacity_cubic_meter="+$("#capacity_cubic_meter:eq(0)").val()
						+"&capacity_tonne="+$("#capacity_tonne:eq(0)").val()
						+"&diesel_performance="+$("#diesel_performance:eq(0)").val()

						+"&nombre_aseg="+$("#nombre_aseg:eq(0)").val()
						+"&num_permiso_sct="+$("#num_permiso_sct:eq(0)").val()
						+"&num_poliza_seguro="+$("#num_poliza_seguro:eq(0)").val()
						+"&perm_sct="+$("#perm_sct:eq(0)").val()
						+"&config_vehicular="+$("#config_vehicular:eq(0)").val()

						+"&nombre_aseg_med_amb="+$("#nombre_aseg_med_amb:eq(0)").val()
						+"&num_poliza_seg_med_amb="+$("#num_poliza_seg_med_amb:eq(0)").val()
                        ;
 
 
           
 
           //alert(query_string);
           console.log(query_string);
           //return;
           
       $.ajax({
       url:"../../../controllers/cfdi_func/camion_insert.php",
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
             title: 'Camiòn',
             text: requests.msg,
             icon: option,
             showCancelButton: false,
             confirmButtonText: 'OK!'
           }).then((result) => {
             if(requests.status!=2){
               if (result.isConfirmed) {
                 location.href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/camiones/search/"; ?>";
               }
 
             }else{
               return;
             }
             
           })
 
         } 
       });
 
    });
</script>
</body>
</html>