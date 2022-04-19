<?php
$subtotal=0;
$total=0;
$iva=15;
if (isset($_SESSION['compraDetalle']) and count($_SESSION['compraDetalle'])>0) {
?>
        
    <?php
    foreach($_SESSION['compraDetalle'] as $producto )
    {   
        
        $subtotal=round($subtotal+$producto['txtPrecioTotal'],2);
        $total=round($total+$producto['txtPrecioTotal'],2);
    ?>
       
                  <tr>
                    <td><?= $producto['idproducto']   ?></td>
                    <td><?=  $producto['nombre']  ?></td>
                    <td><?=  $producto['categoria']  ?></td>
                    <td><?=  $producto['cantidad']  ?></td>
                    <td><?= SMONEY.' '. formatMoney($producto['precio'])?></td>
                    <td><?= SMONEY.' '. formatMoney($producto['txtPrecioTotal'])  ?></td>
                    <td class=""><a class="link_delete" href="$" # onclick="event.preventDefault();del_product_detalle('<?=  $producto['idproducto']  ?>');"><i class="far fa-trash-alt"></i></a></td>
                    </tr>
      
    <?php } ?>

    <?php
        $impuesto=round($subtotal*($iva/100),2);
        //$tl_sniva=round($subtotal-$impuesto);
        $total=round($subtotal+$impuesto);
    ?>
   
<?php } ?>