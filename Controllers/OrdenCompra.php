<?php

class OrdenCompra extends Controllers{
    public function __construct()
    {
            parent::__construct();
            session_start();
            //session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(17);
        }
        
        public function OrdenCompra()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
            //unset($_SESSION['compraDetalle']);
            $data['page_tag']="ordenCompra";
            $data['page_title']="Compras <small>Route 77</small>";
            $data['page_name']="ordenCompra";
            $data['page_functions_js']="functions_ordenCompra.js";
            $this->views->getView($this,"ordenCompra",$data);
        }
        public function getProducto($idproducto){
			if($_SESSION['permisosMod']['r']){
				$idproducto = intval($idproducto);
				if($idproducto > 0){
					$arrData = $this->model->selectProducto($idproducto);
				
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
				
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
        public function detalleCompra(){
             //unset($_SESSION['compraDetalle']);exit;
			if($_SESSION['permisosMod']['w']){
                $detalleTabla='';
                $idproducto = intval($_POST['idProducto']);
                $intCantidad = intval($_POST['txtCantidad']);
                $txtPrecio = ucwords(strClean($_POST['txtPrecio']));
                $txtPrecioTotal =$intCantidad*$txtPrecio;
                $arrDetalle=array();
                $arrTabla=array();
                $subtotal=0;
                $total=0;
                $iva=15;
                
                //$user=intval($_SESSION['idUser']);
                $arrData = $this->model->selectProducto($idproducto);
               
               $arrinfoProducto=array('idproducto' => $idproducto,
               'cantidad' => $intCantidad,
               'nombre'=>$arrData['NOMBRE'],
               'categoria'=>$arrData['CATEGORÍA'],
               'stock'=>$arrData['STOCK'],
               'cantCompra'=>$arrData['CANT_COMPRA'],
               'precio' => $txtPrecio,
               'txtPrecioTotal'=>$txtPrecioTotal);
                
                
               //$_SESSION['compraDetalle']=array();
               if(isset($_SESSION['compraDetalle'])){
                $on = true;
                $arrDetalle = $_SESSION['compraDetalle'];
                for ($pr=0; $pr < count($arrDetalle); $pr++) {
                    if($arrDetalle[$pr]['idproducto'] == $idproducto){
                        $arrDetalle[$pr]['cantidad'] = $intCantidad;
                        $arrDetalle[$pr]['precio'] = $txtPrecio;
                        $arrDetalle[$pr]['txtPrecioTotal']=$txtPrecio*$intCantidad;
                        $on = false;
                    }
                }
                if($on){
                    array_push($arrDetalle,$arrinfoProducto);
                }
                    $_SESSION['compraDetalle'] = $arrDetalle;
                }else{
                    array_push($arrDetalle, $arrinfoProducto);
                    $_SESSION['compraDetalle'] = $arrDetalle;
                }
            
                /* for ($i=0; $i < count($_SESSION['compraDetalle']) ; $i++) { 
                    $subtotal=round($subtotal+$_SESSION['compraDetalle'][$i]['txtPrecioTotal'],2);
                    $total=round($total+$_SESSION['compraDetalle'][$i]['txtPrecioTotal'],2);
                    $detalleTabla.=' <tr>
                    <td>'.$_SESSION['compraDetalle'][$i]['idproducto'].'</td>
                    <td>'.$_SESSION['compraDetalle'][$i]['nombre'].'</td>
                    <td>'.$_SESSION['compraDetalle'][$i]['categoria'].'</td>
                    <td>'.$_SESSION['compraDetalle'][$i]['cantidad'].'</td>
                    <td>'.$_SESSION['compraDetalle'][$i]['precio'].'</td>
                    <td>'.$_SESSION['compraDetalle'][$i]['txtPrecioTotal'].'</td>
                    <td class=""><a class="link_delete" href="$" # onclick="event.preventDefault();del_product_detalle('.$_SESSION['compraDetalle'][$i]['idproducto'].');"><i class="far fa-trash-alt"></i></a></td>
                    </tr>';
                } */

                $impuesto=round($subtotal*($iva/100),2);
                //$tl_sniva=round($subtotal-$impuesto);
                $total=round($subtotal+$impuesto);
                
               /*  $detalletTotales=' <tr>
                                    <td colspan="6" class="text-right">Subtotal L.</td>
                                    <td class="text-right">L.'.$subtotal.'</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">IVA ('.$iva.'%)</td>
                                    <td class="text-right">L.'.$impuesto.'</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">Total </td>
                                    <td class="text-right">L.'.$total.'</td>
                                </tr>'; */

              /*   $arrTabla['detalle']=$detalleTabla;            
                $arrTabla['totales']=$detalletTotales;  */
                $htmlCarrito='';
                $htmlCompras = getFile('Template/Modals/tablaCompra',$_SESSION['compraDetalle']); 
                $htmlTotales = getFile('Template/Modals/tablaTotales',$_SESSION['compraDetalle']);
                    
                $arrResponse = array("status" => true, "msg" => 'Producto agregado',"htmlCompras"=>$htmlCompras,"htmlTotales"=>$htmlTotales);
               
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function delCompra(){
            
            //unset($_SESSION['compraDetalle']);exit;
           if($_SESSION['permisosMod']['d']){
               $detalleTabla='';
               $idproducto = intval($_POST['idProducto']);
               if (is_numeric($idproducto) ) {
                $arrCompra=$_SESSION['compraDetalle'];
                for ($pr=0; $pr < count($arrCompra); $pr++) {
                    if($arrCompra[$pr]['idproducto'] == $idproducto){
                        unset($arrCompra[$pr]);
                    }
                }
                sort($arrCompra);
                $_SESSION['compraDetalle']=$arrCompra;
               
            
                $htmlCompras = getFile('Template/Modals/tablaCompra',$_SESSION['compraDetalle']); 
                $htmlTotales = getFile('Template/Modals/tablaTotales',$_SESSION['compraDetalle']);
                    
                $arrResponse = array("status" => true, "msg" => 'Producto Eliminado',"htmlCompras"=>$htmlCompras,"htmlTotales"=>$htmlTotales);
                
            }else{
                $arrResponse=array("status"=>false,"msg"=>'Datos Incorrectoss');
            }
              
              
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
           }
           die();
       }

       public function anularCompra(){
            
        //unset($_SESSION['compraDetalle']);exit;
       if($_SESSION['permisosMod']['d']){
         unset($_SESSION['compraDetalle']);
           if (empty($_SESSION['compraDetalle']) ) {
           
            $arrResponse = array("status" => true, "msg" => 'Productos Eliminados');
            
        }else{
            $arrResponse=array("status"=>false,"msg"=>'Datos Incorrectoss');
        }
          
           echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
       }
       die();
   }




   public function procesarCompra(){
           
    if ($_POST){
     
        $personaid=$_SESSION['idUser'];
        $monto=0;
        $factura=intval($_POST['txtFactura']);
        $idProveedor=intval($_POST['idProveedor']);
        $isv=15;
        $total=0;
        $cantCompra=0;
        
        //$costo_envio=COSTOENVIO;

        if(!empty($_SESSION['compraDetalle']) and !empty($_POST['txtFactura'])){
            foreach ($_SESSION['compraDetalle'] as $pro) {
                $total += $pro['cantidad']*$pro['precio'];
                
            }
            $impuesto=$total*($isv/100);
            $monto = $total;
           
            //dep($_SESSION['compraDetalle']);
            if($monto>0){
               //CREAR COMPRA
                $request_pedido=$this->model->insertCompra($idProveedor,
                                                                $monto,
                                                                $impuesto,
                                                                $factura,
                                                                $personaid);
                        
                if ($request_pedido>0){
                    foreach ($_SESSION['compraDetalle'] as $producto) {
                        $productoid = $producto['idproducto'];
                        $precio = $producto['precio'];
                        $cantidad = $producto['cantidad'];
                        $stock = $producto['stock'];
                        $cantCompra=$producto['cantCompra']+$cantidad;
                        $nuevoStock=$stock+$cantidad;
                        $this->model->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                        //Aumentar stock
                        $this->model->updateStock($productoid,$nuevoStock); 
                        //actualizarCant Compra
                        $this->model->updateCantCompra($productoid,$cantCompra); 

                    }
                
                
                        /*  $infoOrden=$this->getPedido($request_pedido); */
                        
                        /*  $dataEmailOrden=array('asunto'=>"Se ha realizado una Compraa.".$request_pedido,
                                                'email'=>emailGerente,
                                                'emailCopia'=>EMAIL_PEDIDOS,
                                                'pedido'=>$infoOrden);
                        
                        sendEmail($dataEmailOrden,"email_notificacion_orden");
                        
                        $orden=openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                        $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT,KEY);   */
                        $arrResponse= array("status"=> true,"msg"=>'Compra Realizads');
                        
                            unset($_SESSION['compraDetalle']);
                            session_regenerate_id(true);
                        }
                        
            }

        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible procesar la Compra.');
        }

    }else{
        $arrResponse= array("status"=> false, "msg" => 'No es posible procesar el pedido.');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();
}









   //Funcion para traer ell Proveedor
        public function getSelectProveedores()
        {
            $htmlOptions = "";
            $arrData = $this->model->selectProveedores();
           
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                
                    $htmlOptions .= '<option value="'.$arrData[$i]['COD_PROVEEDOR'].'">'.$arrData[$i]['NOMBRE_EMPRESA'].'</option>';
                    
                }
           }
            echo $htmlOptions;
            die();		
        }

        
 }
?>