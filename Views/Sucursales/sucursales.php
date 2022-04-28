<?php
headerTienda($data);
//$banner=media()."/tienda/images/bg-01.jpg";
$banner = $data["page"]["PORTADA"];
$idpagina = $data["page"]["COD_POST"];
?>
<script>
    document.querySelector("header").classList.add("header-v4")
</script>
	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url(<?=  $banner  ?>);">
		<h2 class="ltext-105 cl0 txt-center">
			<?=  
				$data["page"]["TITULO"];
			?>

		</h2>
	</section>	
  <!-- <section class="py-5 text-center">
    <div class="container">
      <p>Visitanos en nuestras sucursales, y disfruta de la variedad de productos que tenemos.</p>
      <a href="" class="btn btn-info">VER PRODUCTOS</a>
    </div>
</section>
<div class="py-5 bg-light">
  <div class="container">
    <div class="row">

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <img src="<?= media() ?>/tienda/images/SantaLucia.jpg" alt="Sucural uno">
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quaerat necessitatibus eligendi, soluta ipsa natus, at earum qui enim, illum doloremque, accusantium autem nemo est esse nulla neque eaque repellendus amet.</p>
            <p>Dirección: Santa Lucia frente a la Laguna<br>
              Teléfono: 4654645 <br>
              Correo: info@abelosh.com
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <img src="<?= media() ?>/tienda/images/SantaLucia.jpg" alt="Sucural uno">
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quaerat necessitatibus eligendi, soluta ipsa natus, at earum qui enim, illum doloremque, accusantium autem nemo est esse nulla neque eaque repellendus amet.</p>
            <p>Dirección: Col. Los Laureles, Calle principal <br>
              Teléfono: 4654645 <br>
              Correo: info@abelosh.com
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <img src="<?= media() ?>/tienda/images/SantaLucia.jpg" alt="Sucural uno">
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quaerat necessitatibus eligendi, soluta ipsa natus, at earum qui enim, illum doloremque, accusantium autem nemo est esse nulla neque eaque repellendus amet.</p>
            <p>Dirección: Residecial Las Hadas <br>
              Teléfono: 4654645 <br>
              Correo: info@abelosh.com
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div> -->
	<?php 
		if(viewPage($idpagina)) {
			echo $data["page"]["CONTENIDO"];

		}else{		
	?>
		<div>
			<div class="container-fluid py-5 text-center">
				<img src="<?= media(); ?>/tienda/images/construction.png" alt="En Construcción" srcset="">
				<h3>Estamos trabajando para usted</h3>
			</div>
		</div>





 <?php
 }
	footerTienda($data);
?>
	