<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "description" content = "Route 77">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Nosotros">
    <meta name="theme-color" content="=#009688">
    <link rel="shortcut icon" href="<?= media();?>/images//favicon.ico">
    <title><?= $data['page_tag'] ?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/mainLogin.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
    <link rel="stylesheet" href="<?= media(); ?>/js/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
      <div class="cover2"></div>
    </section>
    <section class="login-content">
    <div class="logo d-flex justify-content-center">
        <img src="<?= media(); ?>/images//Logo.png" class="imagenLogin" alt="" >
    </div>
    <div class="login-box flipped">
        <div id="divLoading" >
            <div>
              <img src="<?= media(); ?>/images//loadingRoute.gif" alt="Loading">
            </div>
        </div>
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
          <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idUsuario']; ?>" required >
           <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required >
          <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required > 
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control valid ValidContra" type="password" placeholder="Nueva contraseña" required >
          </div>
          <div class="form-group">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control valid ValidContra" type="password" placeholder="Confirmar contraseña" required >
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
        </form>
      </div>
      </section>
      <script>
         const base_url = "<?= base_url(); ?>";
      </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/plugins/jquery/jquery.min.js"></script>
<!--     <script src="<?= media(); ?>/js/plugins/popper/popper.min.js"></script>-->
    <script src="<?= media(); ?>/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/funtions_admin.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/pace.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
   
    ?>
  </body>
</html>