<!-- Modal -->
<div class="modal fade" id="modalFormEmpresa" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <!-- Div Centrar Modal -->
    <div class="modal-dialog modal-lg bounceInDown animated" role="document">
        <div class="modal-content">
            <!-- Div Contenido Modal -->
            <div class="modal-header headerRegister ">
                <!-- Encabezado Modal -->
                <h5 class="modal-title" id="titleModal">Registro De Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- Termina Encabezado Modal -->
            <!-- abre Modal Body -->
            <div class="modal-body">
                <!-- Card -->
                <!-- formulario Modal -->
                <form id="formEmpresa" name="formEmpresa" class="form-horizontal">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <p class="text-primary">Los campos con asterisco (<span class="required">*</span>)son obligatorios. </p>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtNombreEmpresa">Nombre Empresa<span class="required"> *</span></label>
                            <input type="text" class="form-control valid" id="txtNombreEmpresa" name="txtNombreEmpresa" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtDireccion">Dirección<span class="required"> *</span></label>
                            <input type="text" class="form-control valid" id="txtDireccion" name="txtDireccion" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtRazonSocial">Razón Social<span class="required"> *</span></label>
                            <input type="text" class="form-control valid validText" id="txtRazonSocial" name="txtRazonSocial" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="txtEmail">Email<span class="required"> *</span></label>
                            <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtGerenteGeneral">Gerente General<span class="required"> *</span></label>
                            <input type="text" class="form-control valid validText" id="txtGerenteGeneral" name="txtGerenteGeneral" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtCostoEnvio">Costo de Envío<span class="required"> *</span></label>
                            <input type="text" class="form-control valid validNumber" id="txtCostoEnvio" name="txtCostoEnvio" required="" onkeypress="return controlTag(event)";>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtRTN">RTN<span class="required"> *</span></label>
                            <input type="text" class="form-control valid validNumber" id="txtRTN" name="txtRTN" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtEmailPedidos">Email Para Pedidos<span class="required"> *</span></label>
                            <input type="email" class="form-control valid validEmail" id="txtEmailPedidos" name="txtEmailPedidos" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtTelEmpresa">Teléfono Empresa<span class="required"> *</span></label>
                            <input type="text" class="form-control valid " id="txtTelEmpresa" name="txtTelEmpresa" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtCelEmpresa">Celular Empresa<span class="required"> *</span></label>
                            <input type="text" class="form-control valid " id="txtCelEmpresa" name="txtCelEmpresa" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtCatSlider">Categorías Slider<span class="required">*</span><i>(Códigos separado por comas)</i></label>
                            <input type="text" class="form-control valid" placeholder="Separados por Comas" id="txtCatSlider" name="txtCatSlider" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtCatBanner">Categorías Banner<span class="required">* </span><i>(Códigos separado por comas)</i></label>
                            <input type="text" class="form-control valid " placeholder="Separados por Comas" id="txtCatBanner" name="txtCatBanner" required="">
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
<div class="modal fade" id="modalViewEmpresa" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <!-- Div Centrar Modal -->
    <div class="modal-dialog bounceInDown animated" role="document">
        <div class="modal-content">
            <!-- Div Contenido Modal -->
            <div class="modal-header header-primary">
                <!-- Encabezado Modal -->
                <h5 class="modal-title" id="titleModal">Datos de la Empresa</h5>
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
                            <td>Nombre Empresa:</td>
                            <td id="celNombreEmpresa">Despensa</td>
                        </tr>
                        <tr>
                            <td>Direccion Factura (Factura)</td>
                            <td id="celDireccion">Torocagua</td>
                        </tr>
                        <tr>
                            <td>Razón Social:</td>
                            <td id="celRazonSocial">Despensa SA</td>
                        </tr>
                        <tr>
                            <td>Email (Empresa):</td>
                            <td id="celEmail">Larry</td>
                        </tr>
                        <tr>
                            <td>Gerente General</td>
                            <td id="celGerenteGeneral">Nery</td>
                        </tr>
                        <tr>
                            <td>Costo de Envío</td>
                            <td id="celCostoEnvio">Nery</td>
                        </tr>
                        <tr>
                            <td>RTN</td>
                            <td id="celRTN">Nery</td>
                        </tr>
                        <tr>
                            <td>Email Pedidos</td>
                            <td id="celEmailPedidos">Nery</td>
                        </tr>
                        <tr>
                            <td>Teléfono Empresa (Factura)</td>
                            <td id="celTelefonoEmpresa">Nery</td>
                        </tr>
                        <tr>
                            <td>Celular Empresa (Factura)</td>
                            <td id="celCelularEmpresa">Nery</td>
                        </tr>
                       
                        <tr>
                            <td>Categorías Slider (Códigos de la categorías)</td>
                            <td id="celCatSlider">Nery</td>
                        </tr>
                        <tr>
                            <td>Categorías Bannere (Códigos de la categorías)</td>
                            <td id="celCatBanner">Nery</td>
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