<?php  
    class Dashboard extends Controllers{
        public function __construct()
        {
            parent::__construct();
            session_start();
             //session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(1);
            
        }
        
        public function dashboard()
        {
            $data['page_id']=2;
            $data['page_tag']="Dashboard Route 77";
            $data['page_title']="DASHBOARD ESTACIÓN ROUTE 77";
            $data['page_name']="dashboard";
            $data['page_functions_js']="functions_dashboard.js";
            $data['usuarios'] = $this->model->cantUsuarios();
            $data['clientes'] = $this->model->cantClientes();
            $data['productos'] = $this->model->cantProductos();
            $data['pedidos'] = $this->model->cantPedidos();
            $data['pedidos'] = $this->model->cantPedidos();
            $data['lastOrders'] = $this->model->lastOrders();
            $data['productosTen'] = $this->model->productosTen();
            $anio = date('Y');
            $mes = date('m');
            $data['pagosMes'] = $this->model->selectPagosMes($anio, $mes);
            $data['ventasMDia'] = $this->model->selectVentasMes($anio, $mes);
        // dep($data['ventasMDia']);
        // exit;
            $data['ventasAnio'] = $this->model->selectVentasAnio($anio);
            /* dep($data['ventasAnio']);
             exit;  */
            if ($_SESSION['userData']['COD_ROL'] == RCLIENTES ) {
                $this->views->getView($this,"dashboardCliente",$data);

            }else{
                $this->views->getView($this,"dashboard",$data);
            }
               
           }
        public function getProductos()
        {
            if($_SESSION['permisosMod']['r']){
            
                $arrData = $this->model->selectProductos();
               
                $arrNotificaciones=array();
                for ($i=0; $i < count($arrData); $i++) { 
                    $arrinfoProducto=array(
                        'nombre'=>$arrData[$i]['NOMBRE'],
                        'categoria'=>$arrData[$i]['CATEGORÍA'],
                        'stock'=>$arrData[$i]['STOCK'],
                        'cant_minima'=>$arrData[$i]['CANT_MINIMA']);
                        
                        array_push($arrNotificaciones,$arrinfoProducto);
                    }
                    $_SESSION['notificaciones']=$arrNotificaciones;

                 $htmlNotifi = getFile('Template/Modals/notificaciones',$_SESSION['notificaciones']);
                 $arrResponse = array("status" => true, "msg" => 'Producto Eliminado',"htmlNotifi"=>$htmlNotifi,);
                 
             }else{
                 $arrResponse=array("status"=>false,"msg"=>'Datos Incorrectoss');
             }
             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
        public function tipoPagoMes(){
            if($_POST){
                $grafica = "tipoPagoMes";
                $nFecha = str_replace(" ","",$_POST['fecha']);
                $arrFecha = explode('-',$nFecha);
                $mes = $arrFecha[0];
                $anio = $arrFecha[1];
                $pagos = $this->model->selectPagosMes($anio,$mes);

                $script = getFile("Template/Modals/graficas",$pagos);
                echo $script;
               /*  dep($pagos);
                die(); */

                

            }
        }
        public function ventasMes(){
            if($_POST){
                $grafica = "ventasMes";
                $nFecha = str_replace(" ","",$_POST['fecha']);
                $arrFecha = explode('-',$nFecha);
                $mes = $arrFecha[0];
                $anio = $arrFecha[1];
                $pagos = $this->model->selectVentasMes($anio, $mes);
               

                $script = getFile("Template/Modals/graficas",$pagos);
                echo $script;
    }
 }
 public function ventasAnio(){
    if($_POST){
        $grafica = "ventasAnio";
        $anio = intval($_POST['anio']);
         $pagos = $this->model->selectVentasAnio($anio);
         $script = getFile("Template/Modals/graficas",$pagos);
        echo $script;
 }

}

  }
?>