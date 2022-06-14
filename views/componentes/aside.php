<style>
/*   .bg-gradient-dark {
    background-image: linear-gradient(
    195deg, #5D5D5D 0%, #5D5D5D 100%);
    }
    .navbar .navbar-brand {
        color: #5D5D5D;
        font-size: 0.875rem;
    } */
    .border-radius-xl {
        border-radius: 0.1rem;
    }
</style>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark bg-white" id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/"; ?>" target="_blank"><!-- https://demos.creative-tim.com/material-dashboard/pages/dashboard  -->
          <img src="../../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
          <span class="ms-1 font-weight-bold text-white">Facturación Sys</span>
        </a>
      </div>
      <hr class="horizontal light mt-0 mb-2">
      <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_factura" class="nav-link text-white" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
              </div>
              <span class="nav-link-text ms-1">Facturas</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_pagos" class="nav-link text-white" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/pagos/search/"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">credit_card</i>
              </div>
              <span class="nav-link-text ms-1">Pagos</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_traslado" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/traslados/search/"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">local_shipping</i>
              </div>
              <span class="nav-link-text ms-1">Traslados</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_venta" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/ventas/search"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
              </div>
              <span class="nav-link-text ms-1">Ventas</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_camion" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/camiones/search"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">directions_bus</i>
              </div>
              <span class="nav-link-text ms-1">Camiones</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_chofer" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/choferes/search"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">group</i>
              </div>
              <span class="nav-link-text ms-1">Choferes</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_producto" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/productos/search"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">coffee</i>
              </div>
              <span class="nav-link-text ms-1">Productos</span>
            </a>
          </li>
          <li class="nav-item">
            <a id="menu_cliente" class="nav-link text-white " href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/clientes/search"; ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">view_in_ar</i>
              </div>
              <span class="nav-link-text ms-1">Clientes</span>
            </a>
          </li>
          <!-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
          </li> -->
        </ul>
      </div>
    </aside>
