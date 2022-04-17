<?php  
    //Fernadno 23/10/2021
    class ProductosModel extends Mysql{
        private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $intPrecio;
		private $intStock;
		private $intStatus;
		private $strRuta;
		private $strImagen;
		private $user;
        public function __construct()
        {
           parent::__construct();
        }
        public function selectProductos(){
			/*$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.categoriaid,
							c.nombre as categoria,
							p.precio,
							p.stock,
							p.status 
					FROM producto p 
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE p.status != 0 "; */
					$sql= 'call CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,null,null,"V",null)';
					$request = $this->select_all($sql);


					 
			return $request;
		}	
        public function insertProducto(string $nombre, string $descripcion, int $codigo, int $categoriaid, string $precio, int $stock,string $ruta, int $status, int $user){
			
			$this->strNombre =  $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intUser = $user;
			
			$return = 0;
			//validación
			/* $sql = "SELECT * FROM tbl_productos WHERE COD_BARRA = '{$this->intCodigo}'or NOMBRE = '{$this->strNombre}'";
			 */
			$sql= "CALL CRUD_PRODUCTOS(null,'{$this->intCodigo}','{$this->strNombre}',null,null,null,null,null,null,'A',null)";
			/* dep($sql);
			exit; */
			$request = $this->select_all($sql);
			if(empty($request))
			{
			/* 	$query_insert  = "INSERT INTO producto(categoriaid,
														codigo,
														nombre,
														descripcion,
														precio,
														stock,
														ruta,
														status) 
								  VALUES(?,?,?,?,?,?,?,?)"; */
				$query_insert = "CALL CRUD_PRODUCTOS(?,?,?,?,?,?,?,?,?,?,?,?);";		  
	        	$arrData = array($this->intCategoriaId,
        						$this->intCodigo,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
								$this->strRuta,
								$this->intUser,
								0,
        						$this->intStatus,
        						 $this->intStock, 
								'I',
								"NULL" );
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT Last_insert_id()";
				$request_id = $this-> select($sql);
				
	        	$return = $request_id["Last_insert_id()"];
				
			}else{ 
				$return = false;
			}
	        return $return;
		}
		public function updateProducto(int $idproducto, string $nombre, string $descripcion, int $codigo, int $categoriaid, string $precio, int $stock, string $ruta, int $status, int $user){
			$this->intIdProducto = $idproducto;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intUser = $user;
			$return = 0;
			//VALIDACIÓN
			/* $sql = "SELECT * FROM TBL_PRODUCTOS WHERE COD_BARRA = '{$this->intCodigo}' AND COD_PRODUCTO != $this->intIdProducto or NOMBRE = '{$this->strNombre}' AND COD_PRODUCTO != $this->intIdProducto";
			 */
			$sql= "CALL CRUD_PRODUCTOS(null,'{$this->intCodigo}','{$this->strNombre}',null,null,null,null,null,null,'B',$this->intIdProducto)";
		     /* dep($sql);
			 exit; */
			$request = $this->select_all($sql);
			if(empty($request))
			{
			/* 	$sql = "UPDATE producto 
						SET categoriaid=?,
							codigo=?,
							nombre=?,
							descripcion=?,
							precio=?,
							stock=?,
							ruta=?,
							status=?,dateModificado=? 
						 WHERE idproducto = $this->intIdProducto "; */

             $sql = "CALL CRUD_PRODUCTOS(?,?,?,?,?,?,?,?,?,?,?,?);";
				$arrData = array($this->intCategoriaId,
							$this->intCodigo,
							$this->strNombre,
							$this->strDescripcion,
							$this->strPrecio,
							$this->strRuta,
							"null",
							$this->intUser,
							$this->intStatus,
							$this->intStock,
							'U',
							$this->intIdProducto );
	        	$request = $this->update($sql,$arrData);
			
	        	$return = $request;
			}else{
				
				$return = false;
			}
	        return $return;
		}
		public function selectProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
		/* 	$sql = "SELECT p.idproducto,
							p.codigo,
							p.nombre,
							p.descripcion,
							p.precio,
							p.stock,
							p.categoriaid,
							c.nombre as categoria,
							p.status
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE idproducto = $this->intIdProducto"; */
					$sql ="call CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,null,null,'R',{$this->intIdProducto})";
			$request = $this->select($sql);
			
			return $request;

		}
		public function insertImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			//$query_insert  = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
			$query_insert= "CALL CRUD_IMG_PRODUCTO(?,'I',?)";
	        $arrData = array($this->strImagen,$this->intIdProducto);
              
	    	$request_insert = $this->insert($query_insert,$arrData);
			$sql = "SELECT Last_insert_id()";
				$request_id = $this-> select($sql);
				
	        	$request_insert = $request_id["Last_insert_id()"];


	        return $request_insert;
		}
		public function selectImages(int $idproducto){
			$this->intIdProducto = $idproducto;
			/* $sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto"; */
					$sql= "CALL CRUD_IMG_PRODUCTO(null,'R',$this->intIdProducto)";
			$request = $this->select_all($sql);
			return $request;
		}
		public function deleteImage(int $idproducto, string $imagen){
			 $this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
		 	/* $query  = "DELETE FROM imagen 
						WHERE productoid = $this->intIdProducto 
						AND img = '{$this->strImagen}'";  */
			$sql= "CALL CRUD_IMG_PRODUCTO('{$this->strImagen}','D',$this->intIdProducto)";

	        $request_delete = $this->delete($sql);
		
	        return $request_delete;
		}
		public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			/* $sql = "UPDATE TBL_PRODUCTOS SET status = ? WHERE COD_PRODUCTO = $this->intIdProducto ";
			$arrData = array(0); */
			$sql ="call CRUD_PRODUCTOS(null,null,null,null,null,null,null,null,null,?,{$this->intIdProducto})";
			$arrData = array('D');
			
			$request = $this->update($sql,$arrData);
			
            return $request;
		}
    }

?>