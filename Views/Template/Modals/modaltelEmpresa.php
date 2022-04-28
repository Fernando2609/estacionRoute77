<div class="modal fade" id="modalFormtelEmpresa" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <form id="formtelEmpresa" name="formtelEmpresa" class="form-horizontal">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <p class="text-primary">El campo con asterisco (<span class="required">*</span>)es obligatorio. </p>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="txttelEmpresa">Teléfono<span class="required"> *</span></label>
                            <input type="text" class="form-control valid validNumberTel" id="txttelEmpresa" name="txttelEmpresa" required="" onkeypress="return controlTag(event);">
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
<div class="modal fade" id="modalViewtelEmpresa" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <!-- Div Centrar Modal -->
    <div class="modal-dialog bounceInDown animated" role="document">
        <div class="modal-content">
            <!-- Div Contenido Modal -->
            <div class="modal-header header-primary">
                <!-- Encabezado Modal -->
                <h5 class="modal-title" id="titleModal">Dato Teléfono Empresa</h5>
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
                            <td>Teléfono:</td>
                            <td id="celtelEmpresa">Larry</td>
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