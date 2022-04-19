<?php
 class Compras extends Controllers{
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
        
        public function Compras()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
            $data['page_tag']="Compras";
            $data['page_title']="Compras <small>Route 77</small>";
            $data['page_name']="compras";
            $data['page_functions_js']="functions_compras.js";
            $this->views->getView($this,"compras",$data);
        }

        public function getCompras(){
            if ($_SESSION['permisosMod']['r']) {

                $arrData = $this->model->selectCompras();
              
                for ($i = 0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';
    
                    $arrData[$i]['MONTO'] = SMONEY.formatMoney($arrData[$i]['MONTO']);
                    //$arrData[$i]['MONTO'] = SMONEY.formatMoney($arrData[$i]['MONTO']+$arrData[$i]['ISV']);
    
                    if ($_SESSION['permisosMod']['r']) {
    
                        $btnView .= ' <a title= "Ver Detalle" href="'.base_url().'/compras/orden/'.$arrData[$i]['COD_ORDEN'].'
                        " target="_balnck" class="btn btn-info btn-sm"> <i class="far fa-eye"></i> </a>';
                    }
                    /* if ($_SESSION['permisosMod']['u']) {
                        $btnEdit = '<button class="btn btn-warning  btn-sm" onClick="fntEditInfo(this,'. $arrData[$i]['COD_PEDIDO'] . ')
                        " title="Editar Pedido"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['COD_PEDIDO'] . ')
                        " title="Eliminar Pedido"><i class="far fa-trash-alt"></i></button>';
                    } */
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                }
              
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            }
            die();
            }

        public function orden($idCompra){
            if(!is_numeric($idCompra)){
                header("Location:".base_url().'/pedidos');
            }
            if (empty($_SESSION['permisosMod']['r'])) {
                header('Location: ' . base_url() . '/dashboard');
            }
            $idpersona = "";
            if ($_SESSION['userData']['COD_ROL'] == RCLIENTES) {
                $idpersona = $_SESSION['userData']['COD_PERSONA'];
            }
    
    
            $data['page_tag'] = "Orden Compra - Route 77";
            $data['page_name'] = "orden_compra";
            $data['arrCompras'] = $this->model->selectCompra($idCompra);
            
            $data['page_title'] = "COMPRA# ".$data['arrCompras']['orden']['COD_ORDEN'];
            $this->views->getView($this, "orden", $data);
    
            }

    }

?>