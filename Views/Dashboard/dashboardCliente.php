<?php headerAdmin($data); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= $data['page_title'] ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="<?= base_url(); ?>/dashboard">Dashboard </a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Usuarios) -->
        <div class="row">
        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3><?= $data['usuarios'] ?></h3>

                <p>Usuarios</p>
              </div>
              <div class="icon">
              <i class=" nav-icon fas fa-users"></i>
              </div>
              <a href="<?= base_url() ?>/usuarios" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            
          </div>
          <?php } ?>
          <!-- ./col -->
          <!-- Clientes -->
          <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
              <div class="col-lg-3 col-6">
                <!-- small box -->
               
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3><?= $data['clientes'] ?></h3>

                      <p>Clientes</p>
                    </div>
                    <div class="icon">
                      <i class=" nav-icon fas fa-user"></i>
                    </div>
                    <a href="<?= base_url() ?>/clientes" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
            <?php
            }
            ?>
          <!-- ./col -->
           <!-- Pedidos-->
           <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
              <div class="col-lg-3 col-6">
                <!-- small box -->
           
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3><?= $data['pedidos'] ?></h3>

                      <p>Pedidos</p>
                    </div>
                    <div class="icon">
                      <i class="nav-icon fas fa-shopping-cart"></i>
                    </div>
                    <a href="<?= base_url() ?>/pedidos" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                
              </div>
            <?php
            }
            ?>
          <!-- ./col -->
           <!-- ./col -->
           <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3><?= $data['productos'] ?></h3>

                      <p>Productos</p>
                    </div>
                    <div class="icon">
                      <i class=" nav-icon fas fa-store"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              
              </div>
            <?php
            }
            ?>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- Tabla y Graficaa -->
        <div class="row">
          <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Últimos Pedidos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-sm">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th class="text-right">Monto</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (count($data['lastOrders']) > 0) {
                        foreach ($data['lastOrders'] as $pedido) {
                        

                      ?>
                          <tr>
                            <td><?= $pedido['COD_PEDIDO'] ?></td>
                            <td><?= $pedido['nombre'] ?></td>
                            <td><?= $pedido['Estado'] ?></td>
                            <td class="text-right"><?= SMONEY . " " . formatMoney($pedido['monto']) ?></td>
                            <td><a href="<?= base_url() ?>/pedidos/orden/<?= $pedido['COD_PEDIDO'] ?>" target="_black"><i class="fas fa-eye" aria-hidden="true"></i></a></td>
                           
                          </tr>
                      <?php
                        }
                      }
                      ?>
                     
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                
              </div>
              <!-- /.card -->


              <!-- /.card -->



            </div>
          <?php
          }
          ?>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <div class="container-tittle">

                  
                  <h3 class="card-title">Últimos Productos</h3>
                </div>
                
                  <table class="table table-bordered table-sm">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Productos</th>
                        <th class="text-right">Precio Unitario</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php
                      if (count($data['productosTen']) > 0) {
                        foreach ($data['productosTen'] as $producto) {
                        

                      ?>
                          <tr>
                            <td><?= $producto['COD_PRODUCTO'] ?></td>
                            <td><?= $producto['NOMBRE'] ?></td>
                            
                            <td class="text-right"><?= SMONEY . " " . formatMoney($producto['PRECIO']) ?></td>
                            <td><a href="<?= base_url() ?>/tienda/producto/<?= $producto['COD_PRODUCTO'].'/'.$producto['RUTA'] ?>" target="_black"><i class="fas fa-eye" aria-hidden="true"></i></a></td>
                           
                          </tr>
                      <?php
                        }
                      }
                      ?>
                     
                    </tbody>
                  </table> 
                  </div>
                    </div>
            
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="container-tittle">
                  <h3 class="card-title">Ventas por Mes</h3>
                  <div class= "dflex">
                    <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
                    <button type="button" class="btnVentasMes btn  btn-info btn-sm"onclick="fntSearchVmes()"> 
                      <i class="fas fa-search" ></i> </button>
                    </div>
                </div>
              </div>
              <div id="graficaMes"></div>
            </div>
          </div>


      
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php footerAdmin($data); ?>

<script>


  Highcharts.chart('graficaMes', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Ventas de <?= $data['ventasMDia']['mes'] . ' del ' . $data['ventasMDia']['anio'] ?>'
    },
    subtitle: {
      text: 'Total Ventas <?= SMONEY . '. ' . formatMoney($data['ventasMDia']['total']) ?>'
    },
    xAxis: {
      categories: [
        <?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['Dia'] . ",";
        }
        ?>
      ]
    },
    yAxis: {
      title: {
        text: ''
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [{
      name: '',
      data: [
        <?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['Total'] . ",";
        }
        ?>
      ]
    }]
  });

 
</script>