<?php 
    headerTienda($data);
?>
<script>
  document.querySelector('header').classList.add('header-v4');
</script>
<div class="container text-center">
	
       
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning">Error 404</h2>

        <div class="error-content">
        <?= $data['page']['CONTENIDO']; ?>
         
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
      <p><a class="btn btn-dark" href="javascript:window.history.back();">Regresar</a></p>
    </section>
</div>
<?php footerTienda($data); ?>

