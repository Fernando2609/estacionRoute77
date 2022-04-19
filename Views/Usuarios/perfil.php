    <?php headerAdmin($data);
      getModal("modalPerfil",$data)
    ?>
    <div class="content-wrapper" style="min-height: 2645.88px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=base_url();?>/dashboard"><i class="fas fa-home casa"></i></a></li>
              <li> / <?= $data['page_title'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?= media();?>/images//avatar.png" alt="User profile picture">
                  
                </div>

                <h3 class="profile-username text-center"><?=  $_SESSION['userData']['NOMBRES']." ".$_SESSION['userData']['APELLIDOS'];  ?></h3>

                <p class="text-muted text-center"><?=  $_SESSION['userData']['NOM_ROL'] ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Datos Personales</a></li>
                  
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Datos de Sesion</a></li>
                  <li class="nav-item"><button class="ml-2 btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                  <table class="table table-bordered">
                    <tbody>
                      <?php
                        
                        if (!empty($_SESSION['userData']['DNI'])) { 
                      ?>
                      <tr>
                        <td style="width:200px;">Identificación:</td>
                        <td><?= $_SESSION['userData']['DNI']; ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td>Nombres:</td>
                        <td><?= $_SESSION['userData']['NOMBRES']; ?></td>
                      </tr>
                      <tr>
                        <td>Apellidos:</td>
                        <td><?= $_SESSION['userData']['APELLIDOS']; ?></td>
                      </tr>
                      <tr>
                        <td>Teléfono:</td>
                        <td><?= $_SESSION['userData']['TELEFONO']; ?></td>
                      </tr>
                      <tr>
                        <td>Email (Usuario):</td>
                        <td><?= $_SESSION['userData']['EMAIL']; ?></td>
                      </tr>
                     
                      <!-- <?php
                         if ($_SESSION['userData']['COD_ROL']==1) {
                           
                        
                        ?> -->
                      <tr>
                        <td>Sucursal:</td>
                        <td><?=ucwords(strtolower($_SESSION['userData']['Sucursal'] ));?></td>
                      </tr>
                 <!--    <?php } ?> -->
                      <tr>
                        <td>Rol</td>
                        <td><?= ucwords(strtolower($_SESSION['userData']['NOM_ROL'])); ?></td>
                      </tr>

                    </tbody>
                  </table>
                  </div>
                 

                  <div class="tab-pane" id="settings">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td style="width:200px;">Fecha de registro: </td>
                        <td><?= $_SESSION['userData']['fechaRegistro']; ?></td>
                      </tr>
                      <tr>
                        <td>Ultimo Inicio de Sesión:</td>
                        <td><?= $_SESSION['userData']['DATE_LOGIN']; ?></td>
                      </tr>
                      <tr>
                        <td>Ultima modificación:</td>
                        <td><?= $_SESSION['userData']['FECHA_MODIFICACION']; ?></td>
                      </tr>
                     
                    </tbody>
                  </table>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    <?php footerAdmin($data); ?>
    <!-- /.content -->


