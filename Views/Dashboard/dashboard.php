<?php headerAdmin($data); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $data['page_title'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="<?=base_url();?>/dashboard">Dashboard </a></li>
            </ol>

             <?php // dep($_SESSION['userData']);        
                   /* dep($_SESSION['permisos']);
                   dep($_SESSION['permisosMod']); */
                    //dep(nombreEmpresa()['nombreEmpresa']);
                  
                 

                  //uncomment to test
            

                    
                   ?>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Titulo</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          Página de inicio
        </div>
        <!-- /.card-body -->
        <?php
         /*  $requestApi = CurlConnectionGet(URLPAYPAL."/v2/checkout/orders/2K531646036585830","application/json",getTokenPaypal());
        dep($requestApi); 
        $requestPost = CurlConnectionPost(URLPAYPAL."/v2/payments/captures/9EV2586557328140W/refund","application/json",getTokenPaypal());
        dep($requestPost);  */

        dep($_SESSION['userData']);
        dep($_SESSION['permisos']);
        ?>
        
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php footerAdmin($data); ?>