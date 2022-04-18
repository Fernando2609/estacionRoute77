<?php

$orden = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orden</title>
	<style type="text/css">
		p{
			font-family: arial;letter-spacing: 1px;color: #7f7f7f;font-size: 12px;
		}
		hr{border:0; border-top: 1px solid #CCC;}
		h4{font-family: arial; margin: 0;}
		table{width: 100%; max-width: 600px; margin: 10px auto; border: 1px solid #CCC; border-spacing: 0;}
		table tr td, table tr th{padding: 5px 10px;font-family: arial; font-size: 12px;}
		#detalleOrden tr td{border: 1px solid #CCC;}
		.table-active{background-color: #CCC;}
		.text-center{text-align: center;}
		.text-right{text-align: right;}

        .logo{
            width: 8rem;
        }
		@media screen and (max-width: 470px) {
			.logo{width: 100px;}
			p, table tr td, table tr th{font-size: 9px;}
		}
	</style>
</head>
<body>
	<div>
		<br>
		<p class="text-center">Se ha generado una orden, a continuación encontrarás los datos.</p>
		<br>
		<hr>
		<br>
		<table>
			<tr>
				<td width="33.33%">
					<img class="logo" src="<?= media (); ?>/tienda/images/icons/logo3.png" alt="Logo">
				</td>
				<td width="33.33%">
					<div class="text-center">
						<h4><strong><?= NOMBRE_EMPESA?></strong></h4>
						<p>
							<?= DIRECCION?> <br>
							<?= TELEMPRESA?> <br>
							<?= EMAIL_EMPRESA?>
						</p>
					</div>
				</td>
				<td width="33.33%">
					<div class="text-right">
						<p>
							No. Orden: <strong> <?=$orden['COD_PEDIDO']?> </strong><br>
                            Fecha: <?=$orden['FECHA']?>  <br>
                            <?php
                            if($orden['COD_TIPO_PAGO']==1){
                                ?>
                            Método Pago: <?=$orden['TIPO PAGO']?>  <br>
                            Transacción: <?=$orden['COD_TRANSACCION_PAYPAL']?>
                            <?php }else{ ?>
                                Método Pago: Contra Entrega  <br>
                                Tipo Pago: <?=$orden['TIPO PAGO']?>
                            <?php }?> 
						</p>
					</div>
				</td>				
			</tr>
		</table>
		<table>
			<tr>
		    	<td width="140">Nombre:</td>
		    	<td> <?=$_SESSION['userData']['NOMBRES'].' '.$_SESSION['userData']['APELLIDOS'] ?> </td>
		    </tr>
		    <tr>
		    	<td>Teléfono</td>
		    	<td> <?=$_SESSION['userData']['TELEFONO']?> </td>
		    </tr>
		    <tr>
		    	<td>Dirección de envío:</td>
		    	<td><?=$orden['DIRECCION_ENVIO']?></td>
		    </tr>
		</table>
		<table>
		  <thead class="table-active">
		    <tr>
		      <th>Descripción</th>
		      <th class="text-right">Precio</th>
		      <th class="text-center">Cantidad</th>
		      <th class="text-right">Importe</th>
		    </tr>
		  </thead>
		  <tbody id="detalleOrden">
              <?php
                if(count($detalle)>0){
                    $subtotal=0;
                    foreach($detalle as $producto){
                        $precio=formatMoney($producto['PRECIO']);
                        $importe=formatMoney($producto['PRECIO'] * $producto['CANTIDAD']);
                        $subtotal+=$importe;
                
              ?>
		    <tr>
		      <td><?= $producto['NOMBRE'] ?> </td>
		      <td class="text-right"><?= SMONEY.' '.$precio ?></td>
		      <td class="text-center"><?= $producto['CANTIDAD'] ?></td>
		      <td class="text-right"><?= SMONEY.' '.$importe ?></td>
		    </tr>
            <?php } 
            }?>
		  </tbody>
		  <tfoot>
		  		<tr>
		  			<th colspan="3" class="text-right">Subtotal:</th>
		  			<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal)?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Envío:</th>
		  			<td class="text-right"><?= SMONEY.' '.formatMoney($orden['COSTOENVIO']) ?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Total:</th>
		  			<td class="text-right"><?= SMONEY.' '.formatMoney($orden['MONTO']); ?></td>
		  		</tr>
		  </tfoot>
		</table>
		<div class="text-center">
			<p>Si tienes preguntas sobre tu pedido, <br>pongase en contacto con nombre, teléfono y Email</p>
			<h4>¡Gracias por tu compra!</h4>			
		</div>
	</div>									
</body>
</html>