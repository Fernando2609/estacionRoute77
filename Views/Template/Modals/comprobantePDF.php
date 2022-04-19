<?php
 $cliente = $data['cliente'];
 $orden = $data['orden'];
 $detalle = $data['detalle'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
      table{
          width: 100%;

      }
      table td, table th{
          font-size: 13px;
      }
      h4{
          margin-bottom: 0px;
      }
      .text-center{
          text-align: center;
      } 
      .text-right{
          text-align: right;
      }
      .wd33{
         width: 33.33% 
      }
      .tbl-cliente{
          border: 1px solid #CCC;
          border-radius: 10px;
          padding: 5px;
      }
      .wd10{
        width: 10%;   
      }
      .wd15{
        width: 15%;   
    }
      .wd38{
          width: 38%;
      }
      .wd40{
          width: 40%;
      }
      .wd55{
          width: 55%;
      }
      .tbl-detalle{
          border-collapse: collapse;
      }
      .tbl-detalle thead th{
          padding: 5px;
          background-color: #075289;
          color: #FFF;
      }
      .tbl-detalle tbody td{
          border-bottom: 1px solid #CCC;
          padding: 5px;
      }
      .tbl-detalle tfoot td{
          padding: 5px
      }
    </style>
</head>
<body>
   <table class="tbl-hader">
       <tbody>
           <tr>
               <td class="wd33">
               <img src="<?= media() ?>/tienda/images/icons/logo3.png"width="125"_alt="Logo">
                </td>
            <td class="text-center">
                <h4>Estación <strong><?= NOMBRE_EMPESA ?></strong></h4>
                
                <p>RTN: <?= datosEmpresa()['RTN'] ?> <br>
                    <?= datosEmpresa()['DIRECCION_FACTURA'] ?> <br>
                Teléfono: <?= datosEmpresa()['TEL_EMPRESA'] ?> <br>
                Celular: <?= datosEmpresa()['CEL_EMPRESA'] ?> <br>
                Email: <?= datosEmpresa()['EMAIL_EMPRESA'] ?></p>
            </td>
            <td class="text-right wd38">
                <p>No. Orden <strong><?= $orden['COD_PEDIDO'] ?></strong><br>
                    Fecha: <?= $orden['fecha'] ?> <br>
                    <?php
                     if($orden['COD_TIPO_PAGO']==1){
                    ?>
                    Método de pago: <?= $orden['TIPO_PAGO'] ?><br>
                    Transacción: <?= $orden['COD_TRANSACCION_PAYPAL'] ?><br>
                    <?php }else{?>
                    Método de pago: <?= $orden['TIPO_PAGO'] ?>
                    <?php } ?>
                </p>
            </td>
            </tr>
        </tbody>
</table>
<table class="tbl-cliente">
  <tbody>
  <tr>
          <td>Nombre:</td>
          <td><?= $cliente['NOMBRES'].' '.$cliente['APELLIDOS']?></td>
          <td>Dirección:</td>
          <td><?= $orden['DIRECCION_ENVIO']?></td>
      </tr>
      <tr>
          <td class="wd10">Email:</td>
          <td class="wd40"><?= $cliente['EMAIL']?></td>
          <td class="wd10">Teléfono:</td>
          <td class="wd40"><?= $cliente['TELEFONO']?></td>
      </tr>
  </tbody>
</table>
<br>
<table class="tbl-detalle">
   <thead>
       <tr>
           <th class="wd55">Descripción</th>
           <th class="wd15 text-right">Precio</th>
           <th class="wd15 text-center">Cantidad</th>
           <th class="wd15 text-right">Importe</th>
       </tr>
   </thead>
   <tbody>
       <?php
        $subtotal = 0;
        foreach ($detalle as $producto){
         $importe = $producto['PRECIO'] * $producto['CANTIDAD'];
         $subtotal = $subtotal + $importe;
       ?>
       <tr>
           <td><?= $producto['producto']?></td>
           <td class="wd15 text-right"><?='L. '.($producto['PRECIO']) ?></td>
           <td class="wd15 text-center"><?= $producto['CANTIDAD']?></td>
           <td class="wd15 text-right"><?='L. '.formatMoney($importe) ?></td>
       </tr>
       <?php } ?>
   </tbody>
   <tfoot>
      <tr>
          <td colspan="3" class="wd15 text-right" >Subtotal:</td>
          <td class="wd15 text-right"><?='L. '.formatMoney($subtotal) ?></td>
      </tr> 
      <tr>
          <td colspan="3" class="wd15 text-right">Envío:</td>
          <td class="wd15 text-right"><?= $orden['COSTOENVIO']?></td>
      </tr> 
      <tr>
          <td colspan="3" class="wd15 text-right">Total:</td>
          <td class="wd15 text-right"><?= $orden['MONTO']?></td>
      </tr> 
      
   </tfoot>
 
</table>
    <div class="text-center">
    <p>
        Si tienes preguntas sobre tu pedido, <br>pongase en contacto con nombre, teléfono y Email</p>
        <h4>¡Gracias por tu compra!</h4>
    </div>
</body>
</html>