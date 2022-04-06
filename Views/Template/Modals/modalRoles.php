<!-- Modal -->
<div class="modal fade" id="ModalFormRol" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <!-- Div Centrar Modal -->
  <div class="modal-dialog modal-dialog-centered bounceInDown animated" role="document">
    <div class="modal-content" ><!-- Div Contenido Modal -->
      <div class="modal-header headerRegister "> <!-- Encabezado Modal -->
        <h5 class="modal-title" id="titleModal">Registro De Nuevo Rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- Termina Encabezado Modal -->
      <!-- abre Modal Body -->
      <div class="modal-body">
          <!-- Card -->
        <div class="card">
          
          <!-- formulario Modal -->
          <form id="formRol" name="formRol">
              <input type="hidden" id="idRol" name="idRol" value="">
                <div class="card-body"><!-- Card Body-->
                  <!-- Div Text -->
                  <div class="form-group">
                    <label for="exampleInputNombre">Nombre</label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" placeholder="Nombre del rol" required="">
                  </div>
                  <!-- Cierra Text -->

                  <!-- Div Text -->
                  <div class="form-group">
                    <label for="exampleInputDescrip">Descripción</label>
                    <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción del rol" required="">
                  </div>
                  <!-- Cierra Div Text -->
                  <!-- Div Form-Group -->
                  <div class="form-group">
                        <label>Estado</label>
                        <select class="custom-select" id="listStatus" name="listStatus" required="">
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                        </select>
                  </div>
                  <!-- Div Form-Group -->
                </div>
                <!-- /.Cierra card-body -->

            <div class="card-footer">
              <button id="btnActionForm" class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal" ><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
            </div>
          </form>
        </div> <!-- /.Cierra card -->
      </div><!-- /. Cierra  Div body Modal -->
    </div><!-- /. Cierra  Div Centrar Modal -->
  </div><!-- /. Cierre Div Centrar Modal -->
</div>
<!-- Cierra Modal -->

