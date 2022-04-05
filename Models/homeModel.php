<?php  
    //Fernadno 23/10/2021
    class homeModel extends Mysql{
        public function __construct()
        {
           parent::__construct();
        }

        
       /*  public function setUser(string $nombre, int $edad)
        {
            $query_insert="INSERT into usuario(nombre,edad) values(?,?)";
            $arrayData=array($nombre,$edad);
            $request_insert=$this->insert($query_insert,$arrayData);
            return $request_insert;
        }
        public function getUser($id)
        {
           $sql="SELECT * From usuario Where id=$id";
           $request=$this->select($sql);
           return $request;
        }
        public function updateUser(int $id,string $nombre, int $edad)
        {
            $query_update="UPDATE usuario SET nombre=?, edad=? where id=$id";
            $arrayData=array($nombre,$edad);
            $request_update=$this->update($query_update,$arrayData);
            return $request_update;
        }
        public function getUsers()
        {
            $sql="SELECT * FROM usuario";
            $request=$this->select_all($sql);
            return $request;
        }
        public function delUser($id)
        {
            $sql="DELETE FROM usuario where id=$id";
            $request=$this->delete($sql);
            return $request;
        } */
    }

?>