<?php  
    //Fernando 23/10/2021 Vistas
    class Views{
        function getView($controller,$view,$data='')
        {
            $controller=get_class($controller);
            if ($controller=="Home") {
                $view="views/".$view.".php";
            }else{
                $view="views/".$controller."/".$view.".php";
            }
            require_once($view);
        }
    }

?>