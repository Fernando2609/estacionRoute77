<?php headerAdmin($data); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard"><i class="fas fa-home casa"></i></a></li>
                        <li class="breadcrumb-item active"><a href="<?= base_url(); ?>/Compras"> Compras</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section id="sPedido" class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php
                    if (empty($data['arrCompras'])) {
                    ?>
                        <p> Datos no encontrados</p>
                    <?php } else {
                        $Comprador = $data['arrCompras']['vendedor'];
                        $orden = $data['arrCompras']['orden'];
                        $detalle = $data['arrCompras']['detalle'];
                        
                    ?>

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <!-- Acá empieza la orden -->
                                   <img width="42" src="<?= media(); ?>/images//logo3.ico" alt="" srcset="">Estación Route 77
                                    <small class="float-right">Fecha: <?= $orden['FECHA_COMPRA'] ?></small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">

                                    <address>
                                        <strong>NOMBRE_EMPRESA</strong><br>
                                      
                                        <?= TELEMPRESA ?><br>
                                        <?= EMAIL_EMPRESA ?><br>
                                        <?= WEB_EMPRESA ?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                    <address>
                                        <strong><?= $Comprador['NOMBRES'].' '. $Comprador['APELLIDOS'] ?></strong><br>
                                        <!-- Envío: <?= $orden['DIRECCION_ENVIO']; ?><br> -->
                                        Tel: <?= $Comprador['TELEFONO'] ?><br>
                                        Email: <?= $Comprador['EMAIL'] ?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Compra #<?= $orden['COD_ORDEN'] ?></b><br>
                                    <b>Proveeedor: </b><?= $orden['NOMBRE_EMPRESA'] ?><br>
                                    <b>N° Factura:</b> <?=  $orden['NO_FACTURA'] ?> <br>
                                    <!-- <b>Estado:</b> <?= $orden['status'] ?> <br> -->
                                    <b>Monto:</b> <?= SMONEY . ' ' . formatMoney($orden['MONTO']) ?>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Cod Barra</th>
                                                <th>Nombre</th>
                                                <th>Categoría</th>
                                                <th class="text-right">Precio</th>
                                                <th class="text-center">Cantidad #</th>
                                                <th class="text-right">Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $subtotal = 0;
                                            if (count($detalle) > 0) {
                                                foreach ($detalle as $producto) {
                                                    $subtotal += $producto['CANT_COMPRA'] * $producto['PRECIO'];

                                            ?>
                                                    <tr>
                                                        <td><?= $producto['COD_BARRA'] ?></td>
                                                        <td><?= $producto['PRODUCTO'] ?></td>
                                                        <td><?= $producto['CATEGORIA'] ?></td>
                                                        <td class="text-right"><?= SMONEY . ' ' . formatMoney($producto['PRECIO']) ?></td>
                                                        <td class="text-center"><?= $producto['CANT_COMPRA'] ?></td>
                                                        <td class="text-right"><?= SMONEY . ' ' . formatMoney($producto['CANT_COMPRA'] * $producto['PRECIO']) ?></td>
                                                    </tr>
                                            <?php
                                                }
                                                //$impuesto=$subtotal*($orden['ISV']/100);
                                                $impuesto=$orden['ISV'];
                                                
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Sub-Total:</th>
                                                <td class="text-right"><?= SMONEY . ' ' . formatMoney($subtotal) ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="text-right">Impuesto:</th>
                                                <td class="text-right"><?= SMONEY . ' ' . formatMoney($impuesto) ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="text-right">Total:</th>
                                                <td class="text-right"><?= SMONEY . ' ' . formatMoney($orden['MONTO']+$impuesto) ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->

                                <!-- /.col -->

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="javascript:window.print('#sPedido');" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir</a>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
<?php } ?>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php footerAdmin($data); ?>