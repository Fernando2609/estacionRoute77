<?php
require_once("Models/TTipoPago.php");
 class Pedidos extends Controllers{
    use TTipoPago;
        public function __construct()
        {
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(MPEDIDOS);
        }
        
        public function Pedidos()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
           
            $data['page_tag']="Pedidos";
            $data['page_title']="PEDIDOS <small> Route 77</small> ";
            $data['page_name']="pedidos";
            $data['page_functions_js']="functions_pedidos.js";
            $this->views->getView($this,"pedidos",$data);
        }

        public function getPedidos(){
        if ($_SESSION['permisosMod']['r']) {
            $idpersona = "";
            if( $_SESSION['userData']['COD_ROL'] == RCLIENTES ) {
                $idpersona = $_SESSION['userData']['COD_PERSONA'];
            }
            $arrData = $this->model->selectPedidos($idpersona);
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                $arrData[$i]['transaccion'] = $arrData[$i]['REFERENCIA_COBRO'];
                if ($arrData[$i]['COD_TRANSACCION_PAYPAL'] != "") {
                    $arrData[$i]['transaccion'] = $arrData[$i]['COD_TRANSACCION_PAYPAL'];
                }

                $arrData[$i]['MONTO'] = SMONEY.formatMoney($arrData[$i]['MONTO']);

                if ($_SESSION['permisosMod']['r']) {

                    $btnView .= ' <a title= "Ver Detalle" href="'.base_url().'/pedidos/orden/'.$arrData[$i]['COD_PEDIDO'].'
                    " target="_balnck" class="btn btn-info btn-sm"> <i class="far fa-eye"></i> </a>

                    <a title= "Generar PDF" href="'.base_url().'/factura/generarFactura/'.$arrData[$i]['COD_PEDIDO'].'
                    " target="_balnck" class="btn btn-danger btn-sm"> <i class="fas fa-file-pdf"></i> </a> ';
                    
                    if ($arrData[$i]['COD_TIPO_PAGO'] == 1) {        
                        $btnView .= '<a title= "Ver Transaccion" href="'.base_url().'/pedidos/transaccion/'.$arrData[$i]['COD_TRANSACCION_PAYPAL'].'
                        " target="_balnck" class="btn btn-info btn-sm"> <i class="fa fa-paypal" 
                        aria-hidden="true"></i></a>';
                   
                    }else{
                        $btnView .= '<button class="btn btn-secondary btn-sm" disabled=""><i class="fa fa-paypal" 
                        aria-hidden="true"></i></button> ';
                    }
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning  btn-sm" onClick="fntEditInfo(this,'. $arrData[$i]['COD_PEDIDO'] . ')
                    " title="Editar Pedido"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['COD_PEDIDO'] . ')
                    " title="Eliminar Pedido"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
        }

        public function orden($idpedido){
        if(!is_numeric($idpedido)){
            header("Location:".base_url().'/pedidos');
        }
        if (empty($_SESSION['permisosMod']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $idpersona = "";
        if ($_SESSION['userData']['COD_ROL'] == RCLIENTES) {
            $idpersona = $_SESSION['userData']['COD_PERSONA'];
        }


        $data['page_tag'] = "Pedido - Route 77";
        $data['page_name'] = "pedido";
        $data['arrPedido'] = $this->model->selectPedido($idpedido, $idpersona);
        $data['page_title'] = "PEDIDO #".$data['arrPedido']['orden']['COD_PEDIDO'];
        $this->views->getView($this, "orden", $data);

        }
        public function transaccion($transaccion){
            if (empty($_SESSION['permisosMod']['r'])) {
                header('Location: ' . base_url() . '/dashboard');
            }
            $idpersona = "";
            if ($_SESSION['userData']['COD_ROL'] == RCLIENTES) {
                $idpersona = $_SESSION['userData']['COD_PERSONA'];
            }
            $requestTransaccion=$this->model->selectTransPaypal($transaccion,$idpersona);
            $data['page_tag'] = "Detalle de la Transaccion - Route 77";
            $data['page_title'] = "Detalles de la Transaccion";
            $data['page_name'] = "Detalles de la Transaccion";
            $data['page_functions_js']="functions_pedidos.js";
            $data['objTransaccion']=$requestTransaccion;
            $this->views->getView($this, "transaccion", $data);   
            }
            public function getTransaccion(string $transaccion){
                if($_SESSION['permisosMod']['r'] and $_SESSION['userData']['COD_ROL'] != RCLIENTES){
                    if($transaccion == ""){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{
                        $transaccion = strClean($transaccion);
                        $requestTransaccion = $this->model->selectTransPaypal($transaccion);
                        if(empty($requestTransaccion)){
                            $arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
                        }else{
                            $htmlModal = getFile("Template/Modals/modalReembolso",$requestTransaccion);
                            $arrResponse = array("status" => true, "html" => $htmlModal);
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }
            public function setReembolso(){
                if($_POST){
                    if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['COD_ROL'] != RCLIENTES){
                        //dep($_POST);
                        $transaccion = strClean($_POST['idtransaccion']);
                        $observacion = strClean($_POST['observacion']); 
                        $requestTransaccion = $this->model->reembolsoPaypal($transaccion,$observacion);
                        if($requestTransaccion){
                            $arrResponse = array("status" => true, "msg" => "El reembolso se ha procesado.");
                        }else{
                            $arrResponse = array("status" => false, "msg" => "No es posible procesar el reembolso.");
                        } 
                    }else{
                        $arrResponse = array("status" => false, "msg" => "No es posible realizar el proceso, Preguntele al BOSS.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }
            public function getPedido(string $pedido){
                if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['COD_ROL'] != RCLIENTES){
                    if($pedido == ""){
                        $arrResponse = array("status" => false, "msg" => "Datos Incorrectos");
                    }else{
                        $requestPedido= $this->model->selectPedido($pedido,"");
                        if(empty($requestPedido)){
                            $arrResponse=array("status"=>false,"msg" => "Datos No Disponibles");
                        }else{
                            $requestPedido['tipospago']=$this->getTiposPagoT();
                            $requestPedido['tiposestado']=$this->getTiposEstadoT();
                            $htmlModal = getFile("Template/Modals/modalPedido",$requestPedido);
                            $arrResponse=array("status"=>true, "html"=>$htmlModal);
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }

            public function setPedido(){
                if($_POST){
                    if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['COD_ROL'] != RCLIENTES){ 
                        $idpedido = !empty($_POST['idpedido']) ? intval($_POST['idpedido']) : "";
                        $estado = !empty($_POST['listEstado']) ? intval($_POST['listEstado']) : "";
                        $idtipopago =  !empty($_POST['listTipopago']) ? intval($_POST['listTipopago']) : "";
                        $transaccion = !empty($_POST['txtTransaccion']) ? strClean($_POST['txtTransaccion']) : "";
        
                        if($idpedido == ""){
                            $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                        }else{
                            if($idtipopago == ""){
                                if($estado == ""){
                                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                                }else{
                                    $requestPedido = $this->model->updatePedido($idpedido,"","",$estado);
                                    if($requestPedido){
                                        $arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
                                    }else{
                                        $arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
                                    }
                                }
                            }else{
                                if($idtipopago =="" or $estado == ""){
                                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                                }else{
                                    $requestPedido = $this->model->updatePedido($idpedido,$transaccion,$idtipopago,$estado);
                                    
                                    if($requestPedido){
                                        $arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
                                    }else{
                                        $arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
                                    }
                                }
                            }
                        }
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }
                }
                die();
            }
        
    }
?>