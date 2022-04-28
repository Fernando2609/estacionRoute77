<?php  
     require_once("Models/Tcategoria.php");
     require_once("Models/Tproducto.php");
    class Errors extends Controllers{
        use Tcategoria, Tproducto;
        public function __construct()
        {
            parent::__construct();
            
        }
        
        public function notFound()
        {
            $pageContent=getPageRout('not-found');
            if (empty($pageContent)) {
                header("Location:".base_url());
            }else{
            $data['page_tag']=datosEmpresa()['NOMBRE_EMPRESA'];
            $data['page_title']=datosEmpresa()['NOMBRE_EMPRESA'].' - '.$pageContent['TITULO'];
            $data['page_name']=$pageContent['TITULO'];
            $data['page']=$pageContent;
            $data['categorias'] = $this->getCategorias();
            $this->views->getView($this,"error",$data);
         }
        }
        
       
    }
    $notFound= new Errors();
    $notFound->notFound();
?>