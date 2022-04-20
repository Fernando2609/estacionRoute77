<?php  
    require_once("Models/Tcategoria.php");
    require_once("Models/Tproducto.php");
    require_once("Models/TCliente.php");
    require_once("Models/LoginModel.php");
    class Tienda extends Controllers{
        use Tcategoria, Tproducto, TCliente;
        public $login;
        public function __construct()
        {
            parent::__construct();
            session_start();
            $this->login=new LoginModel();
        }
        
        public function tienda()
        {
            $data['page_tag']=NOMBRE_EMPESA;
            $data['page_title']=NOMBRE_EMPESA;
            $data['page_name']="tienda";
            $pagina = 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
            $data['categorias_search'] = $this->getCategoriasV();
			$this->views->getView($this,"tienda",$data);
		}

        public function categoria($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                $arrParams=explode(",",$params);
                $idcategoria=intval($arrParams[0]);
                $ruta=strClean($arrParams[1]);
                $pagina = 1;
                if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
					$pagina = $arrParams[2];
                 }
                 $cantProductos = $this->cantProductos($idcategoria);
                 $total_registro = $cantProductos['total_registro'];
                 $desde = ($pagina-1) * PROCATEGORIA;
                 $total_paginas = ceil($total_registro / PROCATEGORIA);


                  
                 $infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta,$desde,PROCATEGORIA);
                //dep($infoCategoria);exit;
                 $categoria = strClean($params);
                 $data['page_tag'] = NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
                 
                 $data['page_title'] = $infoCategoria['categoria'];
                 $data['page_name'] = "categoria";
                 $data['productos'] = $infoCategoria['productos'];
                 $data['infoCategoria'] = $infoCategoria;
                 $data['pagina'] = $pagina;
                 $data['total_paginas'] = $total_paginas;
                 $data['categorias'] = $this->getCategorias();
                 $data['categorias_search'] = $this->getCategoriasV();
                 
                 $this->views->getView($this,"categoria",$data);
                 
             }
         }
         public function producto($params){
             
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $arrParams = explode(",",$params);
            $idproducto = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoProducto = $this->getProductoT($idproducto,$ruta);
           if (empty($infoProducto)) {
               header("Location:".base_url());
           }
            $producto = strClean($params);
            //$arrProducto = $this->getProductoT($producto);
            $data['page_tag'] = NOMBRE_EMPESA . " - " . $infoProducto['NOMBRE'];
            $data['page_title'] = $infoProducto['NOMBRE'];
            $data['page_name'] = "producto";
            $data['categorias'] = $this->getCategorias();
            $data['producto'] = $infoProducto;
            $data['productos'] = $this->getProductosRandom($infoProducto['COD_CATEGORIA'],8,"a");
            $this->views->getView($this, "producto", $data);
         }
        }
        public function addCarrito()
        {
            if ($_POST) {
               /*  */
               
                //unset($_SESSION['arrCarrito']);exit;
                $arrCarrito=array();
                $cantCarrito=0;
                $stockCarrito=0;
                $idproducto=openssl_decrypt($_POST['id'],METHODENCRIPT,KEY);
                $cantidad=$_POST['cant'];
                if (is_numeric($idproducto) and is_numeric($cantidad)) {
                    $arrInfoProducto=$this->getProductoIDT($idproducto);
                    
                    $stockCarrito=$arrInfoProducto['STOCK'];
                   
                    if (!empty($arrInfoProducto)) {
                        $arrProducto = array('idproducto' => $idproducto,
											'producto' => $arrInfoProducto['NOMBRE'],
											'cantidad' => $cantidad,
											'precio' => $arrInfoProducto['PRECIO'],
                                            'stock' => $arrInfoProducto['STOCK'],
                                            'ruta'=>$arrInfoProducto['RUTA'],
                                            'cantVenta'=>$arrInfoProducto['CANT_VENTA'],
											'imagen' => $arrInfoProducto['images'][0]['url_image']
										);
                        
                             
                        if (isset($_SESSION['arrCarrito'])) {
                            $on = true;
							$arrCarrito = $_SESSION['arrCarrito'];
                            
							for ($pr=0; $pr < count($arrCarrito); $pr++) {
								if($arrCarrito[$pr]['idproducto'] == $idproducto){
                                    if ($stockCarrito>=$arrCarrito[$pr]['cantidad'] and $cantidad+$arrCarrito[$pr]['cantidad']<=$stockCarrito) {
                                        
                                        
                                        $arrCarrito[$pr]['cantidad'] += $cantidad;
                                        $on = false;
                                      
                                     }else{
                                        $arrResponse = array("status" => false, "msg" => 'Stock Sobrepasado');
                                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                        die();
                                    }
                                    
                                    
								}     
							}
							if($on){
                                if ($stockCarrito>= $cantidad) {
                                   
                                    array_push($arrCarrito,$arrProducto);
                                 
                                 }else{
                                    $arrResponse = array("status" => false, "msg" => 'Stock Sobrepasado');
                                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                    die();
                                }
								
							}
                            $_SESSION['arrCarrito']=$arrCarrito;
                        }else{
                            
                            if ($stockCarrito>=$cantidad ) {
                                
                                array_push($arrCarrito,$arrProducto);
                                $_SESSION['arrCarrito']=$arrCarrito;
                              
                             }else{
                                $arrResponse = array("status" => false, "msg" => 'Stock Sobrepasado');
                                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                die();
                            }
                          
                        }
                        foreach ($_SESSION['arrCarrito'] as $pro){
                            if ($stockCarrito>=$cantidad || $stockCarrito>=$pro['cantidad'] ) {
                                
                                $cantCarrito+=$pro['cantidad'];
                            }else{
                                $arrResponse = array("status" => false, "msg" => 'Stock Sobrepasado');
                                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                                die();
                            }
                        }
                     
                        $htmlCarrito ="";
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
						$arrResponse = array("status" => true, 
											"msg" => '¡Se agrego al carrito!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito
										);
                        
                           
                        
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'Producto No existente');
                    }
               
                }else{
                    $arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
               
            }
            die();
        }

        public function delCarrito()
        {
            if ($_POST) {
                $arrCarrito=array();
                $cantCarrito=0;
                $subtotal=0;
                $envio=0;
                $idproducto=openssl_decrypt($_POST['id'],METHODENCRIPT,KEY);
                $option=$_POST['option'];
                if (is_numeric($idproducto) and ($option==1 or $option==2)) {
                    $arrCarrito=$_SESSION['arrCarrito'];
                    for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto){
							unset($arrCarrito[$pr]);
						}
					}
                    sort($arrCarrito);
                    $_SESSION['arrCarrito']=$arrCarrito;
                    foreach($_SESSION['arrCarrito'] as $pro)
                    {
                         $cantCarrito+=$pro['cantidad'];
                         $subtotal+=$pro['cantidad']*$pro['precio'];
                         if ($subtotal>=500) {
                            $envio=0;
                        }else if ($subtotal<500) {
                         $envio=datosEmpresa()['COSTO_ENVIO'];   
                        } 
                    }
                    $htmlCarrito ="";
                    if ($option==1) {
                        $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                        
                    }
                    $arrResponse = array("status" => true, 
											"msg" => '¡Producto Eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
                                            "subTotal" => SMONEY.formatMoney($subtotal),
                                             "envio" => SMONEY.formatMoney($envio),
                                             "total" => SMONEY.formatMoney($subtotal + $envio)
										);
                    
                }else{
                    $arrResponse=array("status"=>false,"msg"=>'Datos Incorrectoss');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function updCarrito(){
			if($_POST){
                //dep($_POST);
				$arrCarrito = array();
				$totalProducto = 0;
				$subtotal = 0;
				$total = 0;
                $envio=0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = intval($_POST['cantidad']);
                $stockCarrito=0;
                
				if(is_numeric($idproducto) and $cantidad > 0){
                    
                       
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idproducto){
							$arrCarrito[$p]['cantidad'] = $cantidad;
                            $stockCarrito=$arrCarrito[$p]['stock'];
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}
                    if ($stockCarrito>=$cantidad) {
					$_SESSION['arrCarrito'] = $arrCarrito;
                  
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio'];
                        
                        if ($subtotal>=500) {
                            $envio=0;
                        }else if ($subtotal<500) {
                         $envio=datosEmpresa()['COSTO_ENVIO'];   
                        } 
					}
                    
					$arrResponse = array("status" => true, 
                    "msg" => '¡Producto actualizado!',
                    "totalProducto" => SMONEY.formatMoney($totalProducto),
                    "subTotal" => SMONEY.formatMoney($subtotal),
                    "envio" => SMONEY.formatMoney($envio),
                    "cantidad"=>$cantidad,
                    "stock"=>$stockCarrito,
                    "total" => SMONEY.formatMoney($subtotal + $envio)
                );
                
            }else{
                $arrResponse = array("status" => false, "msg" => 'Stock Sobrepasado');
            }
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
                
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
			}
			die();
		}


         public function registro()
        {
            
            if ($_POST) {
                if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
                    
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                    $intTipoId = 2;
                    $intStatus =1;
                    $intTelefono = intval(strClean($_POST['txtTelefono']));
					//$intTipoId = 7;
				
                    /* $intNacionalidad = intval(strClean($_POST['listNacionalidadCliente']));
                    $intGenero = intval(strClean($_POST['listGenero']));
                    $intEstadoC = intval(strClean($_POST['listEstadoC']));
                    $intSucursal = 4;
                     $strFechaNacimiento = strClean($_POST['fechaNacimiento']); */ 
                    $request_user="";
                    $strPassword =  passGenerator();
                    $strPasswordEncrip = hash("SHA256",$strPassword);
                  
                    $request_user = $this->insertCliente(
                                            $strNombre, 
                                            $strApellido, 
                                            $strEmail,
                                            $strPasswordEncrip,
                                            $intTipoId, 
                                            $intStatus,
                                            $intTelefono, 
                                             );
                                                                               
                    

                    
                    if($request_user > 0 ){
                        $arrResponse = array("status" => true, "msg" => 'Cliente Guardado Correctamente.');
                        $nombreUsuario = $strNombre.' '.$strApellido;
                    $dataUsuario = array(
                        'nombreUsuario' => $nombreUsuario,
                        'email' => $strEmail,
                        'password' => $strPassword,
                        'asunto' => 'Bienvenido a tu Tienda en Línea');
                        $_SESSION['idUser'] = $request_user;
                        $_SESSION['login'] = true;
                        $this->login->sessionLogin($request_user);
                        sendEmail($dataUsuario, 'email_bienvenida');
                    }else if($request_user == false){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
                 }
                 echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            
            die();
        }
        /* public function getSelectNacionalidadCliente()
		{
			$htmlOptions = "";
			$arrData = $this->selectNacionalidadCliente();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
				
					$htmlOptions .= '<option value="'.$arrData[$i]['idNacionalidad'].'">'.$arrData[$i]['descripcion'].'</option>';
					
				}
			}
			echo $htmlOptions;
			die();		
		}
        //Funcion para traer el Genero de usuario
        public function getSelectGeneroCliente()
        {
            $htmlOptions = "";
            $arrData = $this->selectGeneroCliente();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                
                    $htmlOptions .= '<option value="'.$arrData[$i]['idGenero'].'">'.$arrData[$i]['descripcion'].'</option>';
                    
                }
            }
            echo $htmlOptions;
            die();		
        }
        //Funcion para traer el Estado Civil
        public function getSelectEstadoCCliente()
        {
            $htmlOptions = "";
            $arrData = $this->selectEstadoCCliente();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                
                    $htmlOptions .= '<option value="'.$arrData[$i]['idEstado'].'">'.$arrData[$i]['descripcion'].'</option>';
                    
                }
            }
            echo $htmlOptions;
            die();		
        } */
        public function procesarVenta(){
           
            if ($_POST){
                $idtransaccionpaypal=NULL;
                $datospaypal=NULL;
                $personaid=$_SESSION['idUser'];
                $monto=0;
                $tipopagoid=intval($_POST['inttipopago']);
                $direccionenvio=strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
                $status = 1;
                $subtotal=0;
                //$costo_envio=COSTOENVIO;
               
                if(!empty($_SESSION['arrCarrito'])){
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        $subtotal += $pro['cantidad']*$pro['precio'];
                    }
                    if($subtotal>=500){
                        $costo_envio=0;
                    }else{
                        $costo_envio=datosEmpresa()['COSTO_ENVIO'];
                    }
                    $monto = formatMoney($subtotal + $costo_envio);
                    /* dep($monto);
                    dep($costo_envio);
                    die(); */
                    //PAGO CONTRA ENTREGA
                    if(empty($_POST['datapay'])){
                       //CREAR PEDIDO
                        $request_pedido=$this->insertPedido($idtransaccionpaypal,
                                $datospaypal,
                                $personaid,
                                $monto,
                                $costo_envio,                                
                                $tipopagoid,
                                $direccionenvio,
                                $status);
                        
                                if ($request_pedido>0){
                                    foreach ($_SESSION['arrCarrito'] as $producto) {
                                        $productoid = $producto['idproducto'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $stock = $producto['stock'];
                                        $nuevoStock=$stock-$cantidad;
                                        $cantVenta=$producto['cantVenta']+$cantidad;
                                        $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                                        
                                        //Disminuir stock
                                         $this->updateStock($productoid,$nuevoStock);
                                        //aumentar cantiad vendida
                                        $this->updateCantVenta($productoid,$cantVenta); 

                                    }
                           
                                    $infoOrden=$this->getPedido($request_pedido);
                                   
                                    $dataEmailOrden=array('asunto'=>"Se ha creado la orden No.".$request_pedido,
                                                         'email'=>$_SESSION['userData']['EMAIL'],
                                                         'emailCopia'=>datosEmpresa()['EMAIL_PEDIDOS'],
                                                            'pedido'=>$infoOrden);
                                    
                                    sendEmail($dataEmailOrden,"email_notificacion_orden");
                                   
                                    $orden=openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                                    $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT,KEY);  
                                    $arrResponse= array("status"=> true,
                                                        "orden"=>$orden,
                                                        "transaccion"=>$transaccion,
                                                        "msg"=>'Pedido Realizado');
                                    $_SESSION['dataorden']=$arrResponse;    
                                     unset($_SESSION['arrCarrito']);
                                     session_regenerate_id(true);
                                    }
                                
                    }else{
                        //PAGO PAYPAL
                        $jsonPaypal=$_POST['datapay'];
                        $objPaypal=json_decode($jsonPaypal);
                        $status=2;

                        if(is_object($objPaypal)){
                            $datospaypal=$jsonPaypal;
                            $idtransaccionpaypal=$objPaypal->purchase_units[0]->payments->captures[0]->id;
                            if ($objPaypal->status == "COMPLETED"){
                                $totalPaypal= formatMoney($objPaypal->purchase_units[0]->amount->value);
                                if($monto==$totalPaypal){
                                    $status=3;
                                }
                               
                                $request_pedido=$this->insertPedido($idtransaccionpaypal,
                                $datospaypal,
                                $personaid,
                                $monto,
                                $costo_envio,
                                $tipopagoid,
                                $direccionenvio,
                                $status);
                                if ($request_pedido>0){
                                    foreach ($_SESSION['arrCarrito'] as $producto) {
                                        $productoid = $producto['idproducto'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $stock = $producto['stock'];
                                        $nuevoStock=$stock-$cantidad;
                                        $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                                        //Disminuir stock
                                        $this->updateStock($productoid,$nuevoStock); 
                                    }
                                    $infoOrden=$this->getPedido($request_pedido);
                                    $dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['EMAIL'], 
													'emailCopia' => datosEmpresa()['EMAIL_PEDIDOS'],
													'pedido' => $infoOrden );
									sendEmail($dataEmailOrden,"email_notificacion_orden");

                                    $orden=openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                                    $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT,KEY);  
                                    $arrResponse= array("status"=> true,
                                    "orden"=>$orden,
                                    "transaccion"=>$transaccion,
                                    "msg"=>'Pedido Realizado');
                                    $_SESSION['dataorden']=$arrResponse;    
                                     unset($_SESSION['arrCarrito']);
                                     session_regenerate_id(true);

                                }else{
                                    $arrResponse=array("status"=>false, "msg" =>'No es posible procesar el pedido.');
                                }

                            }else{
                                $arrResponse=array("status"=>false, "msg"=>'No es posible completar el pago de Paypal.');
                            }
                        }else{
                            $arrResponse=array("status" => false, "msg" => 'Hubo un error en la transaccion.');
                        }
                    }

                }else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
                }




            }else{
                $arrResponse= array("status"=> false, "msg" => 'No es posible procesar el pedido.');
            }
          
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function confirmarpedido(){
            
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
                
				$dataorden = $_SESSION['dataorden'];
				$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
				$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY); 
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
                $data['categorias'] = $this->getCategorias();
				$data['orden'] = $idpedido;
				$data['transaccion'] = $transaccion; 
				$this->views->getView($this,"confirmarpedido",$data);
                
			}
			unset($_SESSION['dataorden']);
		}
        public function page($pagina = null){

			$pagina = is_numeric($pagina) ? $pagina : 1;
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
            $data['categorias_search'] = $this->getCategoriasV();
			$this->views->getView($this,"tienda",$data);
		}
        public function search(){
			if(empty($_REQUEST['s'])){
				header("Location: ".base_url());
			}else{
				$busqueda = strClean($_REQUEST['s']);
			}

			$pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
			$cantProductos = $this->cantProdSearch($busqueda);
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROBUSCAR;
			$total_paginas = ceil($total_registro / PROBUSCAR);
           
			$data['productos'] = $this->getProdSearch($busqueda,$desde,PROBUSCAR);

//dep($data['productos']); exit;

			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = "Resultado de: ".$busqueda;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
            $data['busqueda'] = $busqueda;
			$data['categorias'] = $this->getCategorias();
			$data['categorias_search'] = $this->getCategoriasV();
			$this->views->getView($this,"search",$data);

		}
        public function suscripcion(){
			if($_POST){
				$nombre = ucwords(strtolower(strClean($_POST['nombreSuscripcion'])));
				$email  = strtolower(strClean($_POST['emailSuscripcion']));

				$suscripcion = $this->setSuscripcion($nombre,$email);
				if($suscripcion > 0){
					$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva suscripción",
										'email' => EMAIL_SUSCRIPCION,
										'nombreSuscriptor' => $nombre,
										'emailSuscriptor' => $email );
					sendEmail($dataUsuario,"email_suscripcion");
                   
				}else{
					$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die(); 
		}
    }
?>       