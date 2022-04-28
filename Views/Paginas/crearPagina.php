
<?php 
    headerAdmin($data); 
    $imgPortada='';
?>
    <!-- Content Header (Sección de Encabezado) -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid"><!-- Div Container-Fluid -->
          <div class="row mb-2"> <!-- Div row y margen abajo de 2-->
            <div class="col-sm-6 d-flex"><!-- Div 6 columnas derecha-->
              <!--Titulo-->
              <h1><i class="fas fa-file-alt"></i> <?= $data['page_title'] ?> </h1>
             
            </div><!-- / termina Div 6 columnas derecha-->
            <div class="col-sm-6"> <!-- Div 6 columnas Izquierda-->
              <ol class="breadcrumb float-sm-right">
                <!--Icono Casa-->
              <li class="breadcrumb-item"><a href="<?=base_url();?>/paginas"><i class="fas fa-home casa"></i></a></li>
          <!--     <li> / <?= $data['page_title'] ?></li> -->
            
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
               
                <!-- /.card-body -->
                <div class="card-body">
                 <form id="formPagina" name="formPagina" class="form-horizontal">
                   
                  
                    <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                    <div class="row">
                        <div class="col-md-10">
                            <!-- Div Text -->
                            <div class="form-group">
                                <label for="exampleInputNombre">Título  (<span class="required">*</span>)</label>
                                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Título de la Página" value="" required onkeypress="return controlTagLetraNumero(event);">
                            </div>
                            <!-- Cierra Text -->

                            <!-- Div Text -->
                            <div class="form-group">
                                <label for="txtContenido">Contenido</label>
                                <input type="text" class="form-control" id="txtContenido" name="txtContenido" value="" placeholder="Descripción del Producto" >
                            </div>
                            <!-- Cierra Div Text -->
                        </div>
                    
                    
                        <div class="col-md-2">
                            
                           
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="listStatus">Estado <span class="required">*</span></label>
                                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button id="btnActionForm" class="btn btn-success btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                                </div>
                              
                            </div>
                            </div>
                        </div>
                    <div class="tile-footer">
                        <div class="form-group col-md-12">
                        <div id="containerGallery">
                            <h4>Portada</h4>
                            <span>Tamaño Sugerido (1920px x 239px)</span>
                            <button class="btnAddImage btn btn-info btn-sm" type="button">
                            <i class="fa fa-plus" ></i>
                            </button>
                        </div>
                        <hr>
                        <div id="containerImage">
             
                        <div class="photo">
                            <div class="prevPhoto prevPortada">
                            <?php
                                if ($imgPortada!='') {
                            ?>
                            <span class="delPhoto ">X</span>
                            <?php }else{

                             ?>
                              <span class="delPhoto notBlock">X</span>
                              <?php } ?>
                            <label for="foto"></label>
                            <div>
                               
                    <!--<img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">--> 
                            </div>
                            </div>
                            <div class="upimg">
                            <input type="file" name="foto" id="foto">
                            </div>
                            <div id="form_alert"></div>
                        </div>
             

                        </div>
                        </div>
                        
              </div>
            </form>
                  
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
 