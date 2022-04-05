<?php  
    //Fernando 24/10/2021 Conexcion a la base de datos 
    class Conexion{
    
        private $conect;
        

        public function __construct(){
            $conectionString="mysql:hos=".DB_HOST.";dbname=".DB_NAME.";.DB_CHARSET.";
            try {
                $this->conect=new PDO($conectionString,DB_USER,DB_PASSWORD);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                $this->conect="Error de conexion";
                echo "ERROR: ". $e->getMessage();
            }
        }
            
        public function connect()
        {
            return $this->conect;
        }
    }

   
?>  