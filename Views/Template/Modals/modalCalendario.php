
 
 <!-- Modal -->
 <div class="modal fade" id="modalFormCalendar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="tituloEvento"></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
             </div>
             <div class="modal-body">
                  <!-- formulario Modal -->
                <form id="formCaledario" name="formCaledario" class="form-horizontal">
               <!--  <input type="hidden" id="idUsuario" name="idUsuario" value=""> -->
                <!-- <p class="text-success">Todos los campos son obligatorios</p> -->

                    <input type="hidden" placeholder="Titulo del Evento" class="form-control" id="id" name="id">
   
                    <div class="form-group ">
                        <label for="titulo">Titulo</label>
                        <input type="text" placeholder="Titulo del Evento" class="form-control" id="title" name="title" required="">
                    </div>               
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Fecha Inicio</label>
                        <input type="datetime-local"  class="form-control" id="inicio" name="inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="end">Fecha Final</label>
                        <input type="datetime-local" class="form-control" id="end" name="end" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="color" class="form-control" id="color" name="color" required>
                    </div>
                    <div class="form-group">
                        <label for="colorText">Color del texto</label>
                        <input type="color" class="form-control" id="colorText" name="colorText" required>
                    </div>
                    

                <!-- /.Cierra card-body -->

            </form>
            <div class="card-footer">
                <button id="btnGuardar" onClick="agregarEvento()" class="btn btn-success" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;
                <button id="btnModificar" onClick="updateEvento()" class="btn btn-warning" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Modificar</span></button>&nbsp;
                <button id="btnEliminar" onClick="deleteEvento()" class="btn btn-danger" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Eliminar</span></button>&nbsp;
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
             </div>
           
         </div>
     </div>
 </div>