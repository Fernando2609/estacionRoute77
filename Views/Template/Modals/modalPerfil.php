<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <!-- Div Centrar Modal -->
  <div class="modal-dialog modal-lg bounceInDown animated" role="document">
    <div class="modal-content">
      <!-- Div Contenido Modal -->
      <div class="modal-header headerUpdate ">
        <!-- Encabezado Modal -->
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- Termina Encabezado Modal -->
      <!-- abre Modal Body -->
      <div class="modal-body">
          <!-- Card -->
        


        <!-- formulario Modal -->
        <form id="formPerfil" name="formPerfil" class="form-horizontal">
         
          <!-- <p class="text-success">Todos los campos son obligatorios</p> -->
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
          <div class="form-row">
          <?php
          if ($_SESSION['userData']['COD_ROL']!=RCLIENTES) {
          ?>
            <div class="form-group col-md-6">
              <label for="txtIdentificacion">DNI <span class="required">*</span></label>
              <input type="text" value="<?=  $_SESSION['userData']['DNI'];  ?>"  class="form-control valid validNumber" id="txtIdentificacion" name="txtIdentificacion" required="" onkeypress="return controlTag(event);">
            </div>
          <?php } ?>
            <div class="form-group col-md-6">
              <label for="txtEmail">Email <span class="required">*</span></label>
              <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail"  value="<?=  $_SESSION['userData']['EMAIL'];  ?>"  readonly disabled required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres <span class="required">*</span></label>
              <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre"  value="<?=  $_SESSION['userData']['NOMBRES'];  ?>" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos <span class="required">*</span></label>
              <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido"  value="<?=  $_SESSION['userData']['APELLIDOS'];  ?>" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono"  value="<?=  $_SESSION['userData']['TELEFONO'];  ?>" required="" onkeypress="return controlTag(event);">
            </div>
            <?php
             if ($_SESSION['userData']['COD_ROL']!=RCLIENTES) {
            ?>
            <div class="form-group col-md-6">
              <label for="listGenero">Genero</label>
              <select class="form-control " id="listGenero"  value="<?=  $_SESSION['userData']['COD_GENERO'];  ?>" name="listGenero">
              </select>
            </div>
            <?php } ?>
        </div>
        <?php
         if ($_SESSION['userData']['COD_ROL']!=RCLIENTES) {
        ?>
          <div class="form-row">
           
            <div class="form-group col-md-6">
              <label for="listSucursal">Sucursal</label>
              <select class="form-control"  value="<?=  $_SESSION['userData']['COD_SUCURSAL'];  ?>" id="listSucursal" name="listSucursal">
              </select>
            </div>
          </div>
         <?php } ?>
         
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtPassword">Password</label>
              <input type="password" class="form-control" id="txtPassword" name="txtPassword">
            </div>
            <div class="form-group col-md-6">
                <label for="txtPasswordConfirm">Confirmar Password</label>
                <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" >
            </div>
          </div>

          <!-- /.Cierra card-body -->

          <div class="card-footer">
            <button id="btnActionForm" class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;

            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>

      </div><!-- /. Cierra  Div body Modal -->
    </div><!-- /. Cierra  Div Centrar Modal -->
  </div><!-- /. Cierre Div Centrar Modal -->
</div>
<!-- Cierra Modal -->

