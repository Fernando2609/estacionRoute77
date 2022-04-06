<?php  
    class Home extends Controllers{
        public function __construct()
        {
            parent::__construct();
            
        }
        
        public function home()
        {
            $data['page_id']=1;
            $data['page_tag']="Estación Route 77";
            $data['page_title']="BIENVENIDOS A ESTACIÓN ROUTE 77";
            $data['page_name']="home";
            $data['page_content']="Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint labore pariatur voluptates consequuntur debitis et? Facere doloribus rerum distinctio explicabo itaque nihil minima commodi ab laudantium numquam, nam, dolor quisquam.";
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