<!-- Modal -->
<div class="modal fade" id="modalFormCategorias" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCategoria" name="formCategoria" class="form-horizontal">
             <input type="hidden" id="idCategoria" name="idCategoria" value="">
             <input type="hidden" id="foto_actual" name="foto_actual" value="">
             <input type="hidden" id="foto_remove" name="foto_remove" value="0">



              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

             <div class="row">
                 <div class="col-md-6">
                    

                  
                    <!-- Div Text -->
                    <div class="form-group">
                        <label for="exampleInputNombre">Nombre  (<span class="required">*</span>)</label>
                        <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre de la Categoría" required="" onkeypress="return controlTagLetraNumero(event);">
                    </div>
                    <!-- Cierra Text -->

                    <!-- Div Text -->
                    <div class="form-group">
                        <label for="exampleInputDescrip">Descripción (<span class="required">*</span>)</label>
                        <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción de la Categoría" required="">
                    </div>
                    <!-- Cierra Div Text -->
                    <!-- Div Form-Group -->
                    <div class="form-group col-md-6">
                      <label for="listStatus">Estado</label>
                      <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                    </div>
                    <!-- Div Form-Group -->
                 </div>
             
             
                    <div class="col-md-6">
                        <div class="photo">
                            <label for="foto">Foto (570x380)</label>
                            <div class="prevPhoto">
                            <span class="delPhoto notBlock">X</span>
                            <label for="foto"></label>
                            <div>
                                <img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
                            </div>
                            </div>
                            <div class="upimg">
                            <input type="file" name="foto" id="foto">
                            </div>
                            <div id="form_alert"></div>
                        </div>
                    </div>
                </div>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>ID:</td>
              <td id="celId">654654654</td>
            </tr>
            <tr>
              <td>Nombre:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion">Jacob</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Foto:</td>
              <td id="imgCategoria">Larry</td>
            </tr>
           
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


