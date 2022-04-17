<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
            <form id="formUpdatePedido" name="formUpdatePedido" class="form-horizontal">
             <input type="hidden" id="idpedido" name="idpedido" value="<?= $data['orden']['COD_PEDIDO'] ?>" required="">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="210">No. Pedido</td>
                            <td><?= $data['orden']['COD_PEDIDO'] ?></td>
                        </tr>
                        <tr>
                            <td>Cliente:</td>
                            <td><?= $data['cliente']['NOMBRES'].''.$data['cliente']['APELLIDOS'] ?></td>
                        </tr>
                        <tr>
                            <td>Importe Total:</td>
                            <td><?= SMONEY.' '.$data['orden']['MONTO'] ?></td>
                        </tr>
                        <tr>
                            <td>Transaccion:</td>
                            <td>
                                <?php 
                                    if($data['orden']['COD_TIPO_PAGO']==1){
                                        echo $data['orden']['COD_TRANSACCION_PAYPAL'];
                                    }else{
                                ?>
                                <input type="text" name="txtTransaccion" id="txtTransaccion" class="form-control" value="<?= $data['orden']['REFERENCIA_COBRO'] ?>">
                                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tipo Pago:</td>
                            <td>
                            <?php 
                                    if($data['orden']['COD_TIPO_PAGO']==1){
                                        echo $data['orden']['TIPO_PAGO'];
                                    }else{
                                ?>
                                <select name="listTipopago" id="listTipopago" class="form-control selectpicker" data-live-search="true" required=""> 
                                    <?php
                                        for($i=0; $i < count($data['tipospago']); $i++){
                                            $selected="";
                                            if($data['tipospago'][$i]['COD_TIPO_PAGO']== $data['orden']['COD_TIPO_PAGO']){
                                                $selected=" selected ";
                                            }
                                    ?>
                                    <option value="<?= $data['tipospago'][$i]['COD_TIPO_PAGO']?>" <?= $selected ?> ><?= $data['tipospago'][$i]['TIPO_PAGO'] ?></option>
                                    <?php }  ?>
                                </select>
                                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td>
                                <select name="listEstado" id="listEstado" class="form-control selectpicker" data-live-search="true" 
                                required="">
                                            <?php  
                                                for ($i=0; $i < count($data['tiposestado']); $i++ ){
                                                    $selected="";
                                                    if($data['tiposestado'][$i]['COD_ESTADO']== $data['orden']['COD_ESTADO']){
                                                        $selected=" selected ";
                                                    }                                                   
                                            ?>
                                            <option value="<?= $data['tiposestado'][$i]['COD_ESTADO'] ?>" <?= $selected?> ><?= $data['tiposestado'][$i]['DESCRIPCION'] ?></option>
                                            <?php } ?>
                                        </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="title-footer">
                    <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>
                    <span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>
                    Cerrar</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>