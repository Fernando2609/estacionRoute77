
<?php 
    headerAdmin($data); 
   
?>
    <!-- Content Header (Sección de Encabezado) -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid"><!-- Div Container-Fluid -->
          <div class="row mb-2"> <!-- Div row y margen abajo de 2-->
            <div class="col-sm-6 d-flex"><!-- Div 6 columnas derecha-->
              <!--Titulo-->
              <h1><i class="fas fa-file-alt"></i> <?= $data['page_title'] ?> </h1>
              <!--Boton Nuevo-->
              <?php if($_SESSION['permisosMod']['w']){ ?>
              <a href="<?=  base_url()  ?>/paginas/crear" class="btn btn-success btn-nuevo"><i class="fas fa-plus-square"></i>  Crear Página</a>
              <?php } ?> 
            </div><!-- / termina Div 6 columnas derecha-->
            <div class="col-sm-6"> <!-- Div 6 columnas Izquierda-->
              <ol class="breadcrumb float-sm-right">
                <!--Icono Casa-->
              <li class="breadcrumb-item"><a href="<?=base_url();?>/pagins"><i class="fas fa-home casa"></i></a></li>
              <li> / <?= $data['page_title'] ?></li>
              </ol>
            </div><!-- Termina Div 6 columnas Izquierda-->
          </div><!-- termina Div row y margen abajo de 2-->
        </div><!-- /. Termina container-fluid -->
      </section><!-- / Content Header (/. Sección de Encabezado) -->
      
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12"><!-- div 12 -->
              <div class="card"><!-- div card -->
                <!-- Encabezado -->
                <div class="card-header">
                  <h2 class="card-title">Tabla de Usuarios</h2>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                  <!-- Tabla -->
                  <table id="tablePaginas" class="table table-hover table-bordered  dataTable dtr-inline collapsed" role="grid">
                    <!-- Encabezado de la tabla-->
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                      
                      </tr>
                    </thead>
                    <!--Termina Encabezado -->
                    <tbody>
                  
                    </tbody>
                    
                  </table>
                  
                <!-- termina Tabla -->
                </div>
                <!-- /.termina card-body -->
              </div>
              <!-- /.termina card -->
            </div>
            <!-- /.termina col -->
          </div>
          <!-- /. termina ow -->
        </div>
        <!-- /. termina container-fluid -->
      </section>
      <!-- /. termina content -->
    </div>
    <!-- /.content-wrapper / Div Principal -->
 
  <?php footerAdmin($data); ?>
    