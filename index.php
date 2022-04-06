<?php  
    //FERNANDO 23/10/2021
    //Configuración modelo MVC, extraer controlador, metodo y parametros
    require_once("Config/config.php");
    require_once("Helpers/Helpers.php");
    $url= !empty($_GET['url']) ? $_GET['url'] :  'Home/Home';
    $arrUrl=explode("/",$url);
    $controller=$arrUrl[0];
    $method=$arrUrl[0];
    $params="";

    if (!empty($arrUrl[1])) {
        if ($arrUrl[0]!="") {
            $method=$arrUrl[1];
        }
    }
    if (!empty($arrUrl[2])) {
        if ($arrUrl[2]!="") {
            for ($i=2;$i< count($arrUrl); $i++) { 
                $params.= $arrUrl[$i].',';
            }
            $params=trim($params,",");
            echo $params;
        }
    }

   require_once("libraries/Core/Autoload.php");
   require_once("libraries/Core/Load.php");

      
?>