<?php  
    require_once("Models/Tcategoria.php");
    require_once("Models/Tproducto.php");
    class Home extends Controllers{
        use Tcategoria, Tproducto;
        public function __construct()
        {
            session_start();
            parent::__construct();
            /* session_start();
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            } */
        }
        
        public function home()
        {
            /* dep($this->getCategoriasT(CAT_SLIDER));
            exit; */
            /* dep($this->selectProductos());
            exit; */

            $data['page_tag']=datosEmpresa()['NOMBRE_EMPRESA'];
            $data['page_title']=datosEmpresa()['NOMBRE_EMPRESA'];
            $data['page_name']=datosEmpresa()['NOMBRE_EMPRESA'];
            $data['slider'] = $this->getCategoriasT(datosEmpresa()['CATEGORIAS_SLIDER']);
            $data['banner'] = $this->getCategoriasT(datosEmpresa()['CATEGORIAS_BANNER']);
            $data['categorias'] = $this->getCategorias();
            
            $data['productos'] = $this->getProductosT();
             /* dep($data); exit; */ 
            $this->views->getView($this,"home",$data);
        }
        
        /* public function insertar(){
            $data=$this->model->setUser("José",22);
            $data=$this->model->setUser("e",20);
            print_r($data);
        }
        public function verUsuario($id){
            $data=$this->model->getUser($id);
            print_r($data);
        }
        public function actualizar(){
            $data=$this->model->updateUser(1,"Fernando",21);
            print_r($data);
        }
        public function verUsuarios(){
            $data=$this->model->getUsers();
            print_r($data);
        }
        public function eliminarUsuario($id){
            $data=$this->model->delUser($id);
            print_r($data);
        } */
    }

?>

