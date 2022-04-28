<?php
require_once("Libraries/Core/Mysql.php");
  trait TCliente{
      private $con;
      private $intIdUsuario;
      private $intIdTransaccion;
      private $strNombre;
      private $strApellido;
      private $intTelefono;
      private $strEmail;
      private $strPassword;
      private $strToken;
      private $intTipoId;
   /*    private $intStatus; */
      /* private $intNacionalidad;
      private $intGenero;
      private $intEstadoC;
      private $intSucursal;  */
     /*  private $strFechaNacimiento; */

     //Stock
     private $productoid;
      private $stock; 
     
    public function insertCliente(string $nombre, string $apellido,  string $email, string $password, int $tipoid, int $status, int $telefono){
        $this->con = new Mysql();
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;
        $this->intTelefono = $telefono;
        
       /*  $this->intNacionalidad = $nacionalidad;
        $this->intGenero = $genero;
        $this->intEstadoC = $estadoC;
          $this->intSucursal = $sucursal; 
        $this->strFechaNacimiento=$fechaNacimeinto; */


        $return = 0;

        /* $sql = "SELECT * FROM usuarios WHERE 
                email = '{$this->strEmail}' ";
        $request =$this->con->select_all($sql); */
        $sql = "SELECT * FROM TBL_PERSONAS p 
			left join TBL_CLIENTE c on p.COD_PERSONA=c.COD_PERSONA
			WHERE p.email =  '{$this->strEmail}' ";
			$request = $this-> con->select_all($sql);

        if(empty($request))
        {
            /* $query_insert  = "INSERT INTO usuarios(nombres,apellidos,email,contraseña,idRol,telefono) 
                              VALUES(?,?,?,?,?,?,?,?,?,?,?)"; */
            $query_insert="CALL CRUD_CLIENTE(?,?,?,?,?,?,?,null,null,?,'I',null)";
            $arrData = array(
                            $this->strNombre,
                            $this->strApellido,
                            $this->strEmail,
                            $this->strPassword,
                            /* $this->intNacionalidad,
                            $this->intGenero,
                            $this->intEstadoC, */
                            $this->intTipoId,
                           /*  $this->intSucursal,  
                            $this->strFechaNacimiento, */
                            $this->intStatus, 
                             $this->intTelefono,NOW());
           /*  $request_insert = $this->con->insert($query_insert,$arrData);
            $return = $request_insert;
            
            */
           /* dep($arrData);
           exit; */
            $request_insert = $this->con->insert($query_insert,$arrData);
            $sql = "SELECT MAX(COD_PERSONA) FROM TBL_PERSONAS";
            $request_ID = $this-> con ->select($sql);
            $return =$request_ID ["MAX(COD_PERSONA)"];



        }else{
            $return = false;
        }
        return $return;
    }
    /* public function SelectNacionalidadCliente()
    {
        $this->con = new Mysql();
    // Extraer Nacionalidad
    $sql = "SELECT * FROM nacionalidad";
    $request = $this->con->select_all($sql); 
    return $request;

    }
    //Funcion para traer el genero de usuario
    public function SelectGeneroCliente()
    { 
        $this->con = new Mysql();
        // Extraer Genero
        $sql = "SELECT * FROM genero";
        $request = $this->con->select_all($sql); 
        return $request;

    }
    //Funcion para traer el Estado Civil
    public function selectEstadoCCliente()
    {
        $this->con = new Mysql();
        // Extraer estado Civil
        $sql = "SELECT * FROM estadocivil";
        $request = $this->con->select_all($sql); 
        return $request;

    } */
    public function insertPedido( string $idtransaccionpaypal=NULL,
    string $datospaypal=NULL,
    int $personaid,
    string $monto,
    string $costoenvio,
    int $tipopagoid,
    string $direccionenvio,
    string $status){
    $this->con = new Mysql();
    /* $query_insert = "INSERT INTO pedido (idusuario,monto,costoenvio,idTipoPago,direccion_envio,status,idtransaccionpaypal, datospaypal)
    VALUES(?, ?, ?, ?, ?, ?, ?,?)"; */
    $query_insert="CALL CRUD_PEDIDO(?,?,?,?,?,?,?,?,null,?,'I',null)";
    $arrData = array($personaid,
                    $monto,
                    $costoenvio,
                    $tipopagoid,
                    $direccionenvio,
                    $status,
                    $idtransaccionpaypal,
                    $datospaypal,
                    NOW());
    $request_insert=$this->con->insert($query_insert, $arrData);
    $return=$request_insert;
    $sql = "SELECT last_insert_id()";
    $request_ID = $this->con->select($sql);
    $return = $request_ID['last_insert_id()'];
    return $return;
    }
    public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad){
		$this->con = new Mysql();
		/* $query_insert  = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad) 
							  VALUES(?,?,?,?)"; */
        $query_insert="CALL CRUD_DETALLE_PEDIDO(?,?,?,?,'I',null)";
		$arrData = array($idpedido,
    					$productoid,
						$precio,
						$cantidad
					);
		$request_insert = $this->con->insert($query_insert,$arrData);
	    $return = $request_insert;
        $sql = "SELECT last_insert_id()";
        $request_ID = $this->con->select($sql);
        $return = $request_ID['last_insert_id()'];
	    return $return;
	}
    public function updateStock(int $productoid, int $stock){

        $this->con = new Mysql();
        $this->productoid=$productoid;
        $this->stock=$stock;
        /* $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdcategoria";
        $request = $this->select_all($sql); */
        
        if(empty($request))
        {
            //$sql = "UPDATE producto SET stock = ? WHERE idproducto = $this->productoid "; 	
            $sql="CALL INVENTARIO(?,'U',?)";
            $arrData = array($this->stock,$this->productoid);
            $request = $this->con->update($sql,$arrData);
            
        }else{
            $request = false;
        }
        return $request;
    }


    public function insertDetalleTemp(array $pedido)
    {
        $this->con = new Mysql();
        $this->intIdUsuario=$pedido['idcliente'];
        $this->intIdTransaccion=$pedido['idtransaccion'];
        $productos=$pedido['productos'];
        $sql = "SELECT * FROM detalle_temp WHERE 
					transaccionid = '{$this->intIdTransaccion}' AND 
					usuarioid = $this->intIdUsuario";
		$request = $this->con->select_all($sql);
        if(empty($request)){
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(usuarioid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}else{
			$sqlDel = "DELETE FROM detalle_temp WHERE 
				transaccionid = '{$this->intIdTransaccion}' AND 
				usuarioid = $this->intIdUsuario";
			$request = $this->con->delete($sqlDel);
			foreach ($productos as $producto) {
				$query_insert  = "INSERT INTO detalle_temp(usuarioid,productoid,precio,cantidad,transaccionid) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
	        					$producto['idproducto'],
	    						$producto['precio'],
	    						$producto['cantidad'],
	    						$this->intIdTransaccion
	    					);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
			}
		}
    }
    

    public function getPedido(int $idpedido){
		$this->con = new Mysql();
		$request = array();
		/* $sql = "SELECT p.idpedido,
							p.referenciacobro,
							p.idtransaccionpaypal,
							p.idusuario,
							p.fecha,
							p.costoenvio,
							p.monto,
							p.idTipoPago,
							t.tipoPago,
							p.direccion_envio,
							p.status
					FROM pedido as p
					INNER JOIN tipo_pago t
					ON p.idTipoPago= t.idTipoPago
					WHERE p.idpedido =  $idpedido"; */
        $sql="CALL CRUD_PEDIDO(null,null,null,null,null,null,null,null,null,NULL,'R',$idpedido)";
		$requestPedido = $this->con->select($sql);
		if(count($requestPedido) > 0){
			/* $sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio,
											d.cantidad
									FROM detalle_pedido d
									INNER JOIN producto p
									ON d.productoid = p.idproducto 
									WHERE d.pedidoid = $idpedido
									"; */
            $sql_detalle="CALL CRUD_DETALLE_PEDIDO($idpedido,null,null,null,'R',null)";
			$requestProductos = $this->con->select_all($sql_detalle);
			$request = array('orden' => $requestPedido,
							'detalle' => $requestProductos
							);
		}
		return $request;
	}
    public function updateCantVenta(int $productoid, int $stock){

        $this->con = new Mysql();
        $this->productoid=$productoid;
        $this->stock=$stock;
        /* $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdcategoria";
        $request = $this->select_all($sql); */
        
        if(empty($request))
        {
            //$sql = "UPDATE producto SET stock = ? WHERE idproducto = $this->productoid "; 	
            $sql="CALL INVENTARIO(?,'A',?)";
            $arrData = array($this->stock,$this->productoid);
            $request = $this->con->update($sql,$arrData);
            
        }else{
            $request = false;
        }
        return $request;
    }
	public function setSuscripcion(string $nombre, string $email){
		$this->con = new Mysql();
		$sql = 	"SELECT * FROM TBL_SUSCRIPCIONES WHERE EMAIL = '{$email}'";
		$request = $this->con->select_all($sql);
		if(empty($request)){
			$query_insert  = "INSERT INTO TBL_SUSCRIPCIONES(NOMBRE,EMAIL) 
							  VALUES(?,?)";
			$arrData = array($nombre,$email);
			$request_insert = $this->con->insert($query_insert,$arrData);
			$return = $request_insert;
		}else{
			$return = false;
		}
		return $return;
	}
    public function setContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $useragent){
		$this->con = new Mysql();
        $nombre  	 = $nombre != "" ? $nombre : ""; 
		$email 		 = $email != "" ? $email : ""; 
		$mensaje	 = $mensaje != "" ? $mensaje : ""; 
		$ip 		 = $ip != "" ? $ip : ""; 
		$dispositivo = $dispositivo != "" ? $dispositivo : ""; 
		$useragent 	 = $useragent != "" ? $useragent : ""; 
		$query_insert  = "INSERT INTO TBL_CONTACTO(NOMBRE,EMAIL,MENSAJE,IP,DISPOSITIVO,USERAGENT,FECHA_CREACION) 
						  VALUES(?,?,?,?,?,?,?)";
		$arrData = array($nombre,$email,$mensaje,$ip,$dispositivo,$useragent,NOW());

		$request_insert = $this->con->insert($query_insert,$arrData);
       
		return $request_insert;
	}





   }
?>