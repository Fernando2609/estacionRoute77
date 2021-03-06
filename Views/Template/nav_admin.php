<!-- Main Sidebar Container -->
<?php
 $nombre=explode(" ",$_SESSION['userData']['NOMBRES']);
 $apellido=explode(" ",$_SESSION['userData']['APELLIDOS']);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url();?>/dashboard" class="brand-link">
      <img src="<?= media();?>/images//logo3.png" alt="Route77 Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Estación Route77</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image ">
          <img src="<?= media();?>/images//avatar.png" class="img-circle elevation-2 user " alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$nombre[0]." ".$apellido[0];?></a>
          <a href="#" class="d-block"><?=ucwords(strtolower($_SESSION['userData']['NOM_ROL']))  ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?= base_url();?>/" class="nav-link">
            <i class="nav-icon fa fas fa-globe"></i>
              <p>
                Ver sitio web
              </p>
            </a>
          </li>

      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         

          <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>

    <li class="nav-item">
            <a href="<?= base_url();?>/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php } ?>
          <!-- Usuarios-->
          <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
          <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
             <i class=" nav-icon fas fa-users"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url();?>/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url();?>/roles" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

          <!-- Clientes-->
          <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url();?>/clientes" class="nav-link">
            <i class=" nav-icon fas fa-user"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <?php } ?>


          <!-- Productos-->
          <?php if(!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][6]['r'])){ ?>
            <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
             <i class=" nav-icon fas fa-store"></i>
              <p>
                Tienda
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
              <li class="nav-item">
                <a href="<?= base_url();?>/productos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
              <?php } ?>
              <?php if(!empty($_SESSION['permisos'][6]['r'])){ ?>
              <li class="nav-item">
                <a href="<?= base_url();?>/categorias" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <!-- Pedidos-->
          <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url();?>/pedidos" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Pedidos
              </p>
            </a>
          </li>

          <?php } ?>

          
          <?php if(!empty($_SESSION['permisos'][14]['r'])){ ?>
          
          <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
             <i class="nav-icon fa-solid fa-building"></i>
              <p>
                Empresa
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url();?>/empresa" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empresa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url();?>/telEmpresa" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Teléfonos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url();?>/redesSociales" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Redes Sociales</p>
                </a>
              </li>
              <!-- Sucursales -->
              <?php if(!empty($_SESSION['permisos'][16]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url();?>/adminsucursales" class="nav-link">
           
            <i class="far fa-circle nav-icon"></i>
              <p>
                Sucursales
              </p>
            </a>
          </li>
          <?php } ?>
            </ul>
          </li>
          <?php } ?>

          <?php if(!empty($_SESSION['permisos'][15]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url();?>/proveedores" class="nav-link">
            <i class="nav-icon fa-solid fa-truck-fast"></i>
              <p>
                Proveedores
              </p>
            </a>
          </li>
          <?php } ?>
          
        
          
        <?php if(!empty($_SESSION['permisos'][9]['r'])){ ?>
          <li class="nav-item">
            <a href="<?= base_url();?>/inventario" class="nav-link"> 
            <i class=" nav-icon fa-solid fa-boxes-stacked"></i>
              <p>
                Inventario
              </p>
            </a>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][17]['r'])){ ?>
          <!-- Calendario-->
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-dolly"></i>
              <p>
                Compras
              </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url();?>/ordenCompra" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Compra</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url();?>/Compras" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ver Compras</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][14]['r'])){ ?>
          <!-- Calendario-->
          <li class="nav-item">
            <a href="<?= base_url();?>/calendario" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendario
              </p>
            </a>
          </li>
          <?php } ?>

          <!-- Suscriptores-->

          <?php if(!empty($_SESSION['permisos'][MSUSCRIPTORES]['r'])){ ?>
            <li class="nav-item">
            <a href="<?= base_url();?>/suscriptores" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Suscriptores
              </p>
            </a>
          </li>
         <?php } ?>
         <?php if(!empty($_SESSION['permisos'][MCONTACTO]['r'])){ ?>
            <li class="nav-item">
            <a href="<?= base_url();?>/contactos" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
              <p>
                Mensajes
              </p>
            </a>
          </li>
         <?php } ?>
         <?php if(!empty($_SESSION['permisos'][MPÁGINAS]['r'])){ ?>
            <li class="nav-item">
            <a href="<?= base_url();?>/paginas" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Páginas
              </p>
            </a>
          </li>
         <?php } ?>


          <!-- Logout-->
          <li class="nav-item">
            <a href="<?= base_url();?>/logout" class="nav-link">
            <i class=" nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
