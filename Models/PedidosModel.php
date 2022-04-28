<?php  
    class PedidosModel extends Mysql{

        private $objCategoria;
        public function __construct()
        {
           parent::__construct();
        }

        public function selectPedidos($idpersona = null){
            $this->strPersona=$idpersona;
            $where = "";
            if ($idpersona != null) {
                $where = " WHERE p.COD_PERSONA = ".$idpersona;
            }
             $sql = "SELECT p.COD_PEDIDO,
                    p.REFERENCIA_COBRO,
                    p.COD_TRANSACCION_PAYPAL,
                    DATE_FORMAT(p.FECHA, '%Y/%m/%d') as FECHA,
                    p.MONTO,
                    tp.TIPO_PAGO,
                    tp.COD_TIPO_PAGO,
                    p.COD_ESTADO,
                    te.DESCRIPCION as TIPOESTADO
                    FROM TBL_PEDIDO p
                    INNER JOIN TBL_TIPO_PAGO tp
                    ON p.COD_TIPO_PAGO = tp.COD_TIPO_PAGO
                    INNER JOIN TBL_TIPO_ESTADO te
                    ON p.COD_ESTADO = te.COD_ESTADO 
                     $where "; 
            /*$sql= "CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'V',NULL)";*/
           
                    $request = $this -> select_all($sql);
                     
                    return $request;
        }
         public function selectPedido(int $idpedido,$idpersona = NULL){
            
        $busqueda = "";
        if ($idpersona != NULL) {
            $busqueda = " AND p.COD_PERSONA = ".$idpersona;
            //TIPO CLIENTE
        }
        
        
        $request = array();
        $sql = "SELECT p.COD_PEDIDO ,
                        p.REFERENCIA_COBRO,
                        p.COD_TRANSACCION_PAYPAL,
                        p.COD_PERSONA,
                        DATE_FORMAT(p.FECHA, '%d/%m/%Y') as fecha,
                        p.COSTOENVIO,
                        p.MONTO,
                        p.COD_TIPO_PAGO,
                        tp.TIPO_PAGO,
                        p.DIRECCION_ENVIO,
                        te.DESCRIPCION as status,
                        p.COD_ESTADO
                        FROM TBL_PEDIDO as p
                        INNER JOIN TBL_TIPO_PAGO tp
                        ON p.COD_TIPO_PAGO= tp.COD_TIPO_PAGO
                        INNER JOIN TBL_TIPO_ESTADO te
                        ON p.COD_ESTADO = te.COD_ESTADO 
                        WHERE p.COD_PEDIDO =  $idpedido ".$busqueda; 
        /* $sql= "CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'R',)"; */
                    $requestPedido = $this->select($sql);
                   
                    if (!empty($requestPedido)) {
                        $idpersona = $requestPedido['COD_PERSONA'];
                        $sql_cliente = "CALL CRUD_CLIENTE(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'C',$idpersona)";
                        /* $sql_cliente = "SELECT tp.COD_PERSONA,
                                                    tp.NOMBRES,
                                                    tp.APELLIDOS,
                                                    tp.EMAIL,
                                                    tp.TELEFONO
                                        FROM TBL_PERSONAS tp WHERE  tp.COD_PERSONA= $idpersona ";  */
                        $requestcliente = $this->select($sql_cliente);
                        /* $sql_detalle = "SELECT p.COD_PRODUCTO,
                                               p.NOMBRE as producto,
                                               d.PRECIO,
                                               d.CANTIDAD
                                        FROM TBL_DETALLE_PEDIDO d
                                        INNER JOIN TBL_PRODUCTOS p
                                        ON d.COD_PRODUCTO = p.COD_PRODUCTO
                                        WHERE d.COD_PEDIDO = $idpedido"; */
                        $sql_detalle = "CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'G',$idpedido)";
                        $requestProductos = $this->select_all($sql_detalle);
                        $request = array('cliente'=> $requestcliente,
                                        'orden'=> $requestPedido,
                                        'detalle'=> $requestProductos);
                    }
                    return $request;
        }
        public function selectTransPaypal(string $idtransaccion, $idpersona = NULL){
			$busqueda = "";
            $requestData="";
            
           
			if($idpersona != NULL){
				$busqueda = " AND COD_PERSONA =".$idpersona;
             }
			//$objTransaccion = array(); */
            //FALTA
			//$sql = "CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL, $idtransaccion,NULL,NULL,'F',$idpersona)";
            $sql = "SELECT DATOS_PAYPAL FROM TBL_PEDIDO WHERE COD_TRANSACCION_PAYPAL = '{$idtransaccion}' ".$busqueda;
			/* dep($sql);
            exit; */
            $requestData = $this->select($sql);
			if(!empty($requestData)){
				$objData = json_decode($requestData['DATOS_PAYPAL']);
				//$urlTransaccion = $objData->purchase_units[0]->payments->captures[0]->links[0]->href;
				$urlOrden = $objData->links[0]->href;
				$objTransaccion = CurlConnectionGet($urlOrden,"application/json",getTokenPaypal());
			}
			return $objTransaccion;
		}
    public function reembolsoPaypal(string $idtransaccion, string $observacion){
            $response = false;
            $sql="CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,NULL,'$idtransaccion',NULL,NULL,NULL,'C',null)";
           
            //$sql= "SELECT COD_PEDIDO, DATOS_PAYPAL FROM TBL_PEDIDO  WHERE COD_TRANSACCION_PAYPAL = '{$idtransaccion}' ";
            $requestData= $this-> select($sql);
            
            if(!empty($requestData)){
                $objData= json_decode($requestData['DATOS_PAYPAL']);
                //INGRESAR AL HREF DEL METODO LINKS CON EL METODO GET
               $urlOrden = $objData->links[0]->href;
               $objurl=CurlConnectionGet($urlOrden,"application/json",getTokenPaypal());
                //INGRESAR AL HREF DEL METODO LINKS CON EL METODO POST PARA LA URL DE REEMBOLSO(REFOUND)
               $urlReembolso=$objurl->purchase_units[0]->payments->captures[0]->links[1]->href;
               $objTransaccion=CurlConnectionPost($urlReembolso,"application/json",getTokenPaypal());
                if(isset($objTransaccion->status) and $objTransaccion->status == "COMPLETED") {
                    $idpedido=$requestData['COD_PEDIDO'];
                    $idtransaccion= $objTransaccion->id;
                    $status= $objTransaccion->status;
                    $jsonData = json_encode($objTransaccion);
                    $observacion=$observacion;
                    /* $query_insert= "INSERT INTO TBL_REEMBOLSO (COD_PEDIDO,
                                                            COD_TRANSACCION,
                                                            DATOS_REEMBOLSO,
                                                            OBSERVACION,
                                                            STATUS) 
                                                            VALUES (?,?,?,?,?)"; */
                        $query_insert="CALL CRUD_REEMBOLSO(?,?,?,?,?,'I')";

                    $arrData = array($idpedido,
                                    $observacion,
                                    $status,
                                    $idtransaccion,
                                    $jsonData);

                $request_insert= $this->insert($query_insert, $arrData);
                $sql = "SELECT last_insert_id()";
			    $request_ID = $this->select($sql);
			    $request_insert = $request_ID['last_insert_id()'];
                if($request_insert>0){
                   /*  $updatePedido=" UPDATE TBL_PEDIDO SET COD_ESTADO = ? WHERE COD_PEDIDO = $idpedido"; */
                    $updatePedido="CALL CRUD_PEDIDO(NULL,NULL,NULL,NULL,NULL,?,NULL,NULL,NULL,NULL,'A',$idpedido)";
                    $arrPedido= array(4);
                    $request=$this->update($updatePedido, $arrPedido);
                    $response=true;
                }
            }
                return $response;
            }
        }  
        
        public function updatePedido(int $idpedido, $transaccion = NULL, $idtipopago = NULL,int $estado,int $user){
			if($transaccion == NULL){
				/* $query_insert  = "UPDATE TBL_PEDIDO SET COD_ESTADO = ?  WHERE COD_PEDIDO = $idpedido "; */
                $query_insert="CALL CRUD_PEDIDO($user,NULL,NULL,NULL,NULL,?,NULL,NULL,NULL,?,'A',$idpedido)";
	        	$arrData = array($estado,NOW());
			}else{
				/* $query_insert  = "UPDATE TBL_PEDIDO SET REFERENCIA_COBRO = ?, COD_TIPO_PAGO = ?,COD_ESTADO = ? WHERE COD_PEDIDO = $idpedido"; */
                $query_insert="CALL CRUD_PEDIDO($user,NULL,NULL,?,NULL,?,?,NULL,NULL,?,'B',$idpedido)";
	        	$arrData = array($idtipopago,
	    						$estado,
                                $transaccion,NOW()
	    					);
			}
			$request_insert = $this->update($query_insert,$arrData);
        	return $request_insert;
		}





  }
?>


      