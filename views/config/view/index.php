<?php 
error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
include("../../../models/catalogs.php");
$conn=superConn();

$empresa = fiscalName();
$res_regimen = getRegimen();
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

        <style>
          .form-control{
              font-size:.76rem !important;
              border: 1px solid #d2d6da !important;
              padding: 0.05rem 0.35rem !important;
          }
          .form-control[disabled] {
            line-height: 2 !important;
          }
          .navbar-vertical.navbar-expand-xs .navbar-collapse {
              height: calc(120vh - 360px) !important;
          }
          .page-item.active .page-link {
              z-index: 3;
              color: #fff;
              background-color: #1A73E8;
              border-color: #1A73E8;
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
    
    <title>Config</title>

</head>

<body class="g-sidenav-show bg-gray-200">

<!-- aside -->

<?php include ('../../componentes/aside.php')?>

<!-- =====  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">-->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>">Inicio</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Config Empresa</li>
            </ol>
            <!-- <h6 class="font-weight-bolder mb-0">Tables</h6> -->
          </nav>
          <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          
        </div>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <div class="input-group input-group-outline">
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


    <div class="page-header align-items-start min-vh-100 py-4">
      <!-- <span class="mask bg-gradient-dark opacity-6"></span> -->
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Datos de Empresa</h4>
                  
                </div>
              </div>
              <div class="card-body">
              <form  class="form" style="font-size:.9rem;">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="name">Nombre</label>
                              <input type="text" class="form-control" id="name" placeholder="" value="<?php echo $empresa['nombre_comercial'];?>" disabled>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="rfc">rfc </label>
                              <input type="text" class="form-control" id="rfc" placeholder="" value="<?php echo $empresa['rfc'];?>" disabled>
                              </div>
                              <div class="form-group col-md-6">
                              <label for="pais">Pais</label>
                              <input type="text" class="form-control" id="pais" placeholder="" value="<?php echo $empresa['pais'];?>" disabled>
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="estado">Estado </label>
                              <input type="text" class="form-control" id="estado" placeholder="" value="<?php echo $empresa['entidad'];?>" disabled>
                              </div>
                              <div class="form-group col-md-6">
                              <label for="ciudad">Ciudad</label>
                              <input type="text" class="form-control" id="ciudad" placeholder="" value="<?php echo $empresa['localidad'];?>" disabled>
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="localidad">Localidad </label>
                              <input type="text" class="form-control" id="localidad" placeholder="" value="<?php echo $empresa['localidad'];?>" disabled>
                              </div>
                              <div class="form-group col-md-6">
                              <label for="municipio">Municipio</label>
                              <input type="text" class="form-control" id="municipio" placeholder="" value="<?php echo $empresa['municipio'];?>" disabled>
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-4">
                              <label for="colonia">Colonia </label>
                              <input type="text" class="form-control" id="colonia" placeholder="" value="<?php echo $empresa['colonia'];?>" disabled>
                              </div>
                              <div class="form-group col-md-4">
                              <label for="codigo_postal">Codigo postal</label>
                              <input type="text" class="form-control" id="codigo_postal" placeholder="" value="<?php echo $empresa['cp'];?>" disabled>
                              </div>

                              <div class="form-group col-md-2">
                              <label for="num_ext">Num Ext.</label>
                              <input type="text" class="form-control" id="num_ext" placeholder="" value="<?php echo $empresa['noext'];?>" disabled>
                              </div>

                              <div class="form-group col-md-2">
                              <label for="num_int">Num Int.</label>
                              <input type="text" class="form-control" id="num_int" placeholder="" value="<?php echo $empresa['noint'];?>" disabled>
                              </div>
                          </div>
                          
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input type="text" class="form-control" id="calle" placeholder="" value="<?php echo $empresa['calle'];?>" disabled>
                            </div>
                          
                          

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="email">Email </label>
                              <input type="text" class="form-control" id="email" placeholder="" value="<?php echo $empresa['email_contacto'];?>" disabled>
                              </div>
                              <div class="form-group col-md-6">
                              <label for="telefono">Telefono</label>
                              <input type="text" class="form-control" id="phone" placeholder="" value="<?php echo $empresa['telefono'];?>" disabled>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="regimen_fiscal">Regimen Fiscal</label>
                              <!-- <input type="text" class="form-control" id="regimen_fiscal" placeholder="" value="<?php echo $empresa['regimen_fiscal'];?>" disabled> -->
                              <select id="regimen_fiscal" class="form-control" disabled>
                                <option  selected value="<?php echo $empresa['regimen_fiscal'];?>"><?php echo $empresa['regimen_fiscal'];?></option>
                                <?php foreach($res_regimen as $r_reg): ?>
                                    <option value="<?php echo $r_reg['clave'];?>"><?php echo $r_reg['clave']." - ".$r_reg['description'];?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                          
                      </div>
                      
                  </div>
                  <div id="botones">
                      <button id="enviar_empresa" type="button" class="btn btn-primary" style="display:none;">Guardar</button>
                      <button id="editar_empresa" type="button" class="btn btn-info">Editar</button>
                  </div>
                  
              </form>

              <div style="display:block; margin-top:1rem;  margin-bottom:1rem; width: 100%;">
                  <table class="table customers2">
                  <thead>
                    <tr>
                      <th>Subir archivos SHCP</th>
                    </tr>
                  </thead>
                  <tbody style="width:100%;">
                  <tr><td>
                  <form method="POST" action="upload.php" enctype="multipart/form-data">
                  <input type="file" name="uploadedFile" id="up_zip_xmls">
                  <input type="submit" name="uploadBtn" value="Subir archivo CER" class="btn btn-dark"/>
                  </form>
                  </td></tr>

                  <tr><td>
                  <form method="POST" action="upload.php" enctype="multipart/form-data">
                  <input type="file" name="uploadedFile2" id="up_zip_xmls2">
                  <input type="submit" name="uploadBtn" value="Subir archivo KEY" class="btn btn-dark"/>
                  </form>
                  </td></tr>

                  </tbody>
                  </table>
              </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script>

$("#editar_empresa").click(function () { 
      $(".form-control[disabled]").removeAttr("disabled");
      $("#enviar_empresa").show();
      $(this).hide();
      
});
</script>

<script>

$(document).ready(function () {

  $('#enviar_empresa').click(function () {
  var query_string="";

  query_string+="&id=<?php echo $empresa['id'];?>"
          +"&name="+$("#name:eq(0)").val()
          +"&regimen_fiscal="+$("#regimen_fiscal:eq(0)").val()
          +"&rfc="+$("#rfc:eq(0)").val()
          +"&email="+$("#email:eq(0)").val()
          +"&phone="+$("#phone:eq(0)").val()

          +"&pais="+$("#pais:eq(0)").val()
          +"&estado="+$("#estado:eq(0)").val()
          +"&localidad="+$("#localidad:eq(0)").val()
          +"&municipio="+$("#municipio:eq(0)").val()

          +"&colonia="+$("#colonia:eq(0)").val()
          +"&calle="+$("#calle:eq(0)").val()
          +"&numero_ext="+$("#num_ext:eq(0)").val()
          +"&numero_int="+$("#num_int:eq(0)").val()
          +"&codigo_postal="+$("#codigo_postal:eq(0)").val()
          ;

        //console.log(query_string);
        //return;
        
    $.ajax({
      url:"../../../controllers/cfdi_func/empresa.php",
            type: "POST",
      dataType:"text",
        data: query_string,
        success: function (rslt2) { 
          //console.log(rslt2);

          var requests=JSON.parse(rslt2), request=( requests && typeof requests ==='object' ? requests[0] : null ), class_name="", msg="";

          var option ="";
          if(requests.status==1){
            option='success';

          }else{
            option = 'warning'
          }

          Swal.fire({
            title: 'Empresa',
            text: requests.msg,
            icon: option,
            showCancelButton: false,
            confirmButtonText: 'OK!'
          }).then((result) => {
            if(requests.status!=2){
              if (result.isConfirmed) {
                location.href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/config/view/"; ?>";
              }

            }else{
              return;
            }
            
          })

        } 
    });

});
      
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