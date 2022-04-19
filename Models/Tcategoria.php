 <?php
require_once("Libraries/Core/Mysql.php");
  trait Tcategoria{
      private $con;

      public function getCategoriasT(string $categorias){
          $this->con = new Mysql();
          /* $sql = " SELECT idcategoria, nombre, descripcion, portada,ruta
                   FROM categoria WHERE status != 0 AND idcategoria IN ($categorias)";
          */
          $sql="SELECT COD_CATEGORIA, NOMBRE, DESCRIPCION, PORTADA,RUTA
          FROM TBL_CATEGORIA WHERE COD_STATUS=1 AND COD_CATEGORIA IN ($categorias);";
        
          $request = $this->con->select_all($sql);
          
          if(count($request) > 0){
              for ($c=0; $c < count($request); $c++){
                $request[$c]['PORTADA'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['PORTADA'];
              } 
          }
         
          return $request;
    }
    public function getCategorias(){
          $this->con = new Mysql();
          /* $sql = " SELECT idcategoria, nombre, descripcion,portada,ruta
                  FROM categoria WHERE status != 0 "; */
                  $sql = 'CALL CRUD_TCATEGORIA(null,null,null,null,null,null,null,null,"J",null)';
          $request = $this->con->select_all($sql);
           if(count($request) > 0){
              for ($c=0; $c < count($request); $c++){
                $request[$c]['PORTADA'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['PORTADA'];
              } 
          } 
          return $request;
    }

    public function getCategoriasV(){
      $this->con = new Mysql();
      /* $sql = " SELECT idcategoria, nombre, descripcion,portada,ruta
              FROM categoria WHERE status != 0 "; */
      $sql = 'CALL CRUD_TCATEGORIA(null,null,null,null,null,null,null,null,"M",null)';
      $request = $this->con->select_all($sql);
       if(count($request) > 0){
          for ($c=0; $c < count($request); $c++){
            $request[$c]['PORTADA'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['PORTADA'];
          } 
      } 
      return $request;
}

   }
?>