<?php  
    require_once("Models/Tcategoria.php");
    require_once("Models/Tproducto.php");
    class Sucursales extends Controllers{
        use Tcategoria;
        public function __construct()
        {
            session_start();
            parent::__construct();
            /* session_start();
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            } */
            getPermisos(MPÁGINAS);
        }
        
        public function sucursales()
        {
            /* dep($this->getCategoriasT(CAT_SLIDER));
            exit; */
            /* dep($this->selectProductos());
            exit; */
            $pageContent=getPageRout('sucursales');
            
            if (empty($pageContent)) {
                header("Location:".base_url());
            }else{
                $data['page_tag']=datosEmpresa()['NOMBRE_EMPRESA'];
                $data['page_title']=datosEmpresa()['NOMBRE_EMPRESA'].' - '.$pageContent['TITULO'];
                $data['page_name']=$pageContent['TITULO'];
                $data['page']=$pageContent;
                $data['categorias'] = $this->getCategorias();
               
          
                $this->views->getView($this,"sucursales",$data);

            }
        }
        
       
    }

?>

