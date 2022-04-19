<?php  
    require_once("Models/Tcategoria.php");
    require_once("Models/Tproducto.php");
    require_once("Models/TTipoPago.php");
    require_once("Models/TCliente.php");
    class Carrito extends Controllers{
        use Tcategoria, Tproducto,TTIpoPago,TCliente;
        public function __construct()
        {
            parent::__construct();
            session_start();
            
        }
        
        public function carrito()
        {
            /* dep($this->getCategoriasT(CAT_SLIDER));
            exit; */
            /* dep($this->selectProductos());
            exit; */
            $data['page_tag']=NOMBRE_EMPESA.' - Carrito';
            $data['page_title']='Carrito de Compras';
            $data['page_name']='carrito';
            /* $data['slider'] = $this->getCategoriasT(CAT_SLIDER);
            $data['banner'] = $this->getCategoriasT(CAT_BANNER); */
            $data['categorias'] = $this->getCategorias();
            /* $data['productos'] = $this->getProductosT(); */
             /* dep($data); exit; */ 
            $this->views->getView($this,"carrito",$data);
        }
        public function procesarpago()
        {
            if (empty($_SESSION['arrCarrito'])) {
                header("Location: ". base_url());
                die();
            }

            $data['page_tag']=NOMBRE_EMPESA.' - Procesar Pago';
            $data['page_title']='Procesar Pago';
            $data['page_name']='procesarpago';
            $data['categorias'] = $this->getCategorias();
            $data['tiposPago']= $this->getTiposPagoT();
            $this->views->getView($this,"procesarpago",$data);
        }
        
      /*   public function setDetalleTemp(){
            $sid=session_id();
           $arrPedido=array('idcliente'=>$_SESSION['idUser'],
                            'idtransaccion'=> $sid,
                            'productos'=>$_SESSION['arrCarrito']);
            $this->insertDetalleTemp($arrPedido);
        } */
    }

?>

