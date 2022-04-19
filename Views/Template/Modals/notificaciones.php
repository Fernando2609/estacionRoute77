
<?php
if (isset($_SESSION['notificaciones']) and count($_SESSION['notificaciones'])>0) {
?>
 <span class="dropdown-item dropdown-header"><?=  count($_SESSION['notificaciones'])  ?> Notificaciones</span>
<?php

 foreach($_SESSION['notificaciones'] as $notificacion )
 {   
?>   
        <div class="dropdown-divider"></div>
        <a href="<?=  base_url()  ?>/inventario" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> <?=  $notificacion['nombre']  ?>
        <span class="float-right text-muted text-sm">Verificar Producto</span>
    </a>
<?php } ?>
<?php } ?>