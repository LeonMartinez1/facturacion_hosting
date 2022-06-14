<?php 
error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
include("../../../models/catalogs.php");
$conn=superConn();

$res_regimen = getRegimen();
//echo json_encode($res_regimen);
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
    <div class="page-header align-items-start min-vh-100">
      <!-- <span class="mask bg-gradient-dark opacity-6"></span> -->
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Datos de la Empresa</h4>
                  
                </div>
              </div>
              <div class="card-body">
              <form  class="form" style="font-size:.9rem;">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="nombre">Nombre</label>
                              <input type="text" class="form-control" id="nombre" placeholder="" value="">
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="rfc">rfc </label>
                              <input type="text" class="form-control" id="rfc" placeholder="" value="">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="pais">Pais</label>
                              <input type="text" class="form-control" id="pais" placeholder="" value="">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="estado">Estado </label>
                              <input type="text" class="form-control" id="estado" placeholder="" value="">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="ciudad">Ciudad</label>
                              <input type="text" class="form-control" id="ciudad" placeholder="" value="">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="localidad">Localidad </label>
                              <input type="text" class="form-control" id="localidad" placeholder="" value="">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="municipio">Municipio</label>
                              <input type="text" class="form-control" id="municipio" placeholder="" value="">
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-4">
                              <label for="colonia">Colonia </label>
                              <input type="text" class="form-control" id="colonia" placeholder="" value="">
                              </div>
                              <div class="form-group col-md-4">
                              <label for="codigo_postal">Codigo postal</label>
                              <input type="text" class="form-control" id="codigo_postal" placeholder="" value="">
                              </div>

                              <div class="form-group col-md-2">
                              <label for="num_ext">Num Ext.</label>
                              <input type="text" class="form-control" id="num_ext" placeholder="" value="">
                              </div>

                              <div class="form-group col-md-2">
                              <label for="num_int">Num Int.</label>
                              <input type="text" class="form-control" id="num_int" placeholder="" value="">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="calle">Calle</label>
                              <input type="text" class="form-control" id="calle" placeholder="" value="">
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label for="email">Email </label>
                              <input type="text" class="form-control" id="email" placeholder="" value="">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="telefono">Telefono</label>
                              <input type="text" class="form-control" id="telefono" placeholder="" value="">
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="regimen_fiscal">Regimen Fiscal</label>
                              
                              <select id="regimen_fiscal" class="form-control">
                                <option selected>Seleccionar</option>
                                <?php foreach($res_regimen as $r_reg): ?>
                                    <option value="<?php echo $r_reg['id'];?>"><?php echo $r_reg['clave']." - ".$r_reg['description'];?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                          
                      </div>
                      
                  </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>


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