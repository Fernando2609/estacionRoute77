<?php  
    //Fernadno 23/10/2021
    class ComprasModel extends Mysql{
        public $intIdcategoria;
		public $strCategoria;
		public $strDescripcion;
		public $intStatus;
		public $strPortada;
		public $strRuta;
		public $user;
        public function __construct()
        {
           parent::__construct();
        }
        public function insertCategoria(string $nombre, string $descripcion, string $portada, string $ruta,int $status, int $user){

			$return = 0;
			$this->strCategoria = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intUser = $user;


			//validación 

			/* $sql = "SELECT * FROM TBL_CATEGORIA WHERE nombre = '{$this->strCategoria}' "; */
			$sql="CALL CRUD_CATEGORIA(null,null,'{$this->strCategoria}',null,null,null,null,'A',null)";
			$request = $this->select_all($sql);
            /* dep($sql);
			exit; */
			if(empty($request))
			{
				/* $query_insert  = "INSERT INTO categoria(nombre,descripcion,portada,status) VALUES(?,?,?,?)";
	        	$arrData = array($this->strCategoria, 
								 $this->strDescripcion, 
								 $this->strPortada,
								 //$this->strRuta, 
								 $this->intStatus); */
				$query_insert  = 'CALL CRUD_CATEGORIA(?,?,?,?,?,?,?,?,?)';
	        	$arrData = array($this->intStatus, 
								 $this->strDescripcion, 
								 $this->strCategoria,
								 $this->strPortada,
								 $this->intUser,
								 0,
								 //$this->strRuta, 
								 'I',
								 "null"
								 );
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
				
			
	        	$return = $request_ID['last_insert_id()'];
				/* $sql = "CALL CRUD_CATEGORIA({$this->intStatus}, '{$this->strDescripcion}','{$this->strCategoria}','{$this->strPortada}','I',null)";
			$request_insert = $this->select($sql);
			
			$return = $request_insert["id"]; */
			}else{
				$return = false;
			}
			return $return;
		}
		public function selectCompras()
		{
			/* $sql = "SELECT * FROM categoria 
					WHERE status != 0 "; */
			$sql = 'CALL CRUD_ORDEN_COMPRA(null,null,null,null,"V",null,null)';
			$request = $this->select_all($sql);
			
			return $request;

		}
		public function selectCompra(int $idCompra){
			$this->intidCompra = $idCompra;
		
			/* $sql="CALL CRUD_ORDEN_COMPRA(null,null,null,null,'R',null,{$this->intidCompra})";
			$request = $this->select($sql);
			 */
            $request = array();
            $sql = "SELECT oc.*,p.NOMBRE_EMPRESA,date_format( oc.FECHA_COMPRA,'%d-%m-%Y') as 'FECHA_COMPRA' FROM TBL_ORDEN_COMPRA oc 
            INNER JOIN TBL_PROVEEDORES p on p.COD_PROVEEDOR=oc.COD_PROVEEDOR
            INNER JOIN TBL_DETALLE_COMPRA dc on dc.COD_ORDEN=oc.COD_ORDEN  WHERE oc.COD_ORDEN =  $idCompra"; 
            /* $sql= "CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'R',)"; */
                        $requestPedido = $this->select($sql);
                      
                        if (!empty($requestPedido)) {
                            $idpersona = $requestPedido['CREADO_POR'];
                            $sql_cliente = "SELECT tp.COD_PERSONA,
                                                        tp.NOMBRES,
                                                        tp.APELLIDOS,
                                                        tp.EMAIL,
                                                        tp.TELEFONO
                                            FROM TBL_PERSONAS tp WHERE  tp.COD_PERSONA= $idpersona ";
                            $requestVendedor = $this->select($sql_cliente);
                            
                            $sql_detalle = "SELECT p.COD_PRODUCTO,
                            p.NOMBRE as PRODUCTO,
                            d.PRECIO,
                            c.NOMBRE as CATEGORIA,
                             d.CANT_COMPRA,
                             p.COD_BARRA
                            FROM TBL_DETALLE_COMPRA d
                            INNER JOIN TBL_PRODUCTOS p
                            ON d.COD_PRODUCTO = p.COD_PRODUCTO
                            INNER JOIN TBL_CATEGORIA c
                            ON c.COD_CATEGORIA = p.COD_CATEGORIA
                            WHERE d.COD_ORDEN = $idCompra";
                            $requestProductos = $this->select_all($sql_detalle);
                            
                            $request = array('vendedor'=> $requestVendedor,
                                            'orden'=> $requestPedido,
                                            'detalle'=> $requestProductos);
                        }
                       
			return $request;
		}

		public function updateCategoria(int $idcategoria, string $categoria, string $descripcion, string $portada,string $ruta, int $status,int $user){

			$this->intIdcategoria = $idcategoria;
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;
			$this->intUser = $user;
			
			//Validación update
			/* $sql = "SELECT * FROM TBL_CATEGORIA WHERE nombre = '{$this->strCategoria}' AND COD_CATEGORIA != $this->intIdcategoria";
			 */
			$sql="CALL CRUD_CATEGORIA(null,null,'{$this->strCategoria}',null,null,null,null,'B',$this->intIdcategoria)";
			/* dep($sql);
			exit; */
			$request = $this->select_all($sql);

			if(empty($request))
			{
				
				$sql = "CALL CRUD_CATEGORIA(?,?,?,?,?,?,?,?,?)"; 	
	        	$arrData = array($this->intStatus,
								 $this->strDescripcion, 
								 $this->strCategoria, 
								 $this->strPortada,
								 null,
								 $this->intUser,
								 $this->strRuta,
								 "U",
								 $this->intIdcategoria
								 );
	        	$request = $this->update($sql,$arrData);
				
				/* dep($arrData);
				exit; */
	        	/* $sql = "CALL CRUD_CATEGORIA({$this->intStatus}, '{$this->strDescripcion}','{$this->strCategoria}','{$this->strPortada}','U',){$this->intIdcategoria}";
			$request_insert = $this->select($sql); */
			
			//$request = $request_insert["id"];
			}else{
				$request = false;
			}
			return $request;
		}

		public function deleteCategoria(int $idcategoria)
		{
			$this->intIdcategoria = $idcategoria;
			$sql = "SELECT * FROM TBL_PRODUCTOS WHERE COD_CATEGORIA = $this->intIdcategoria";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				/* $sql = "UPDATE categoria SET status = ? WHERE idcategoria = $this->intIdcategoria ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				dep($request);
                exit; */
				$sql = "CALL CRUD_CATEGORIA(null,null,null,null,null,null,null,?,'$this->intIdcategoria')";
				$arrData = array("D");
				$request = $this->update($sql,$arrData);
				
				if($request)
				{
					$request = true;	
				}else{
					$request = false;
				}
			}else{
				$request = false;
			}
			return $request;
		}

    }

?>