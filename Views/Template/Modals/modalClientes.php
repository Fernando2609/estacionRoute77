<div class="modal fade" id="modalFormCliente" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <!-- Div Centrar Modal -->
  <div class="modal-dialog modal-lg bounceInDown animated" role="document">
    <div class="modal-content">
      <!-- Div Contenido Modal -->
      <div class="modal-header headerRegister ">
        <!-- Encabezado Modal -->
        <h5 class="modal-title" id="titleModal">Registro De Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- Termina Encabezado Modal -->
      <!-- abre Modal Body -->
      <div class="modal-body">
          <!-- Card -->
        


        <!-- formulario Modal -->
        <form id="formCliente" name="formCliente" class="form-horizontal">
          <input type="hidden" id="idUsuario" name="idUsuario" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>)son obligatorios. </p>

          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres<span class="required"> *</span></label>
              <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos<span class="required"> *</span></label>
              <input type="text" class="form-control valid validText" maxlength="10" id="txtApellido" name="txtApellido" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono<span class="required"> *</span></label>
              <input type="text" class="form-control valid validNumberTel" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmail">Email<span class="required"> *</span></label>
              <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
            </div>
          </div>

            <div class="form-group col-md-6">
              <label for="listStatus">Status<span class="required"> *</span></label>
              <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtPassword">Password<span class="required"> *</span></label>
              <input type="password" class="form-control valid ValidContra" id="txtPassword" name="txtPassword">
            </div>
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

<!-- Modal -->
<div class="modal fade" id="modalViewCliente" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <!-- Div Centrar Modal -->
  <div class="modal-dialog bounceInDown animated" role="document">
    <div class="modal-content">
      <!-- Div Contenido Modal -->
      <div class="modal-header header-primary">
        <!-- Encabezado Modal -->
        <h5 class="modal-title" id="titleModal">Datos del Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- Termina Encabezado Modal -->
      <!-- abre Modal Body -->
      <div class="modal-body">
        <!-- Card -->
        <table class="table table-bordered">
          <tbody>
            
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Cliente):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <!-- <tr>
              <td>Rol Usuario:</td>
              <td id="celTipoUsuario">Larry</td>
            </tr> -->
            
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
            <tr>
              <td>Creado por:</td>
              <td id="celCreadoPor">Larry</td>
            </tr>
            <tr>
              <td>Ult. Vez Modificado: </td>
              <td id="celDateModificado">Larry</td>
            </tr>
            <tr>
              <td>Modificado por:</td>
              <td id="celModPor">Larry</td>
            </tr>
            <tr>
              <td>Ult. Vez Login:</td>
              <td id="celDateLogin">Larry</td>
            </tr>
           
          </tbody>
        </table>

      </div><!-- /. Cierra  Div body Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /. Cierra  Div Centrar Modal -->
  </div><!-- /. Cierre Div Centrar Modal -->
</div>
<!-- Cierra Modal -->