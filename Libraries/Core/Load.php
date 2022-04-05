<?php  
     //Load
     $controller = ucwords($controller);
     $controllerFile="Controllers/".$controller.".php";
     echo $controllerFile;
     if (file_exists($controllerFile)) { //Validar si exite el controlador
         require_once($controllerFile);
         $controller=new $controller();
         if(method_exists($controller, $method))//validar si existe el metodo
         {
             $controller->{$method}($params);
         }else{
             require_once("Controllers/Error.php");
         }
     }else{
         require_once("Controllers/Error.php");
     }

?>