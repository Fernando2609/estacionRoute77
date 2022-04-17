<?php  
    class Sucursales extends Controllers{
        public function __construct()
        {
            parent::__construct();
            session_start();
            //session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(16);
        }
        
        public function Sucursales()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
            $data['page_tag']="Sucursales";
            $data['page_title']="SUCURSALES <small>Route 77</small>";
            $data['page_name']="sucursales";
            $data['page_functions_js']="functions_sucursales.js";
            $this->views->getView($this,"sucursales",$data);
        }
        public function setSucursales()
        {
           
        /* dep($_POST);
        exit;   */ 
            if ($_POST) {
                if(empty($_POST['txtNombre']) || empty($_POST['txtDireccion']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
                    $idSucursal = intval($_POST['idSucursal']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strDireccion = ucwords(strClean($_POST['txtDireccion']));
					                
                    
                    $request_user="";
                    if ($idSucursal==0) {
                        $option=1;
                         if($_SESSION['permisosMod']['w']){
                        $request_user = $this->model->insertSucursales($strNombre, 
                                                                                    $strDireccion 
                                                                                    );
                                                                                   
                    
                        }
                    }else{
                        $option=2;
                       if($_SESSION['permisosMod']['u']){
                        $request_user = $this->model->updateSucursal($idSucursal, $strNombre, 
                                                                                    $strDireccion);
                                                                                
                    } 
                   
                    }
                    
                    if($request_user > 0 ){
                        if ($option==1) {
                            $arrResponse = array("status" => true, "msg" => 'Sucursal Guardada Correctamente.');
                        }else{
                            $arrResponse = array("status" => true, "msg" => 'Sucursal  Actualizada Correctamente.');
                        }
                    }else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! la sucursal ya existe, ingrese otro nombre.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos Verifique el nombre.');
					}
                    
                 }
                 echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            
            die();
        }
        public function getSucursales()
        {
        /*  dep($_SESSION);
         exit; */
            if($_SESSION['permisosMod']['r']){ 
            $arrData= $this->model->selectSucursales();
              
            for ($i=0; $i < count($arrData) ; $i++) { 
                $btnView ='';
                $btnEdit = '';
                $btnDelete = '';

                if($_SESSION['permisosMod']['r']){
                    $btnView = '<button class="btn btn-info btn-sm btnViewSucursales" onClick="fntViewSucursales('.$arrData[$i]['COD_SUCURSAL'].')" title="Ver sucursal"><i class="far fa-eye"></i></button>';
                }

                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-warning btn-sm btnEditSucursales" onClick="fntEditSucursales(this,'.$arrData[$i]['COD_SUCURSAL'].')" title="Editar sucursal"><i class="fas fa-pencil-alt"></i></button>';
                       }else{
                        $btnEdit = '<button class="btn btn-warning btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';  
                       }
                   
                if($_SESSION['permisosMod']['d']){
                    $btnDelete = '<button class="btn btn-danger btn-sm btnDelSucursales" onClick="fntDelSucursales('.$arrData[$i]['COD_SUCURSAL'].')" title="Eliminar Sucursal"><i class="far fa-trash-alt"></i></button>';
                    }else{
                        $btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="far fa-trash-alt"></i></button>';
                    
                   
                }
                
 
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                
             } 
            /*  dep($arrData[0]['status']);exit; */
           /*  dep($arrData);
            exit;  */
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
         }
             die();
        }
        public function getSucursal($idSucursal){
            //echo $idUsuario;
            //die();
            if($_SESSION['permisosMod']['r']){
				$idSucursal = intval($idSucursal);
				if($idSucursal > 0)
				{
				$arrData = $this->model->selectSucursal($idSucursal);
                   /*  dep($arrData);
                    exit; */
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
             } 
			die();
		} 
        public function delSucursal()
        {
            if($_POST){
                if($_SESSION['permisosMod']['d']){
                    $intIdSucursal = intval($_POST['idSucursal']);

                    $requestDelete = $this-> model->deleteSucursal($intIdSucursal);
                    if ($requestDelete) 
                    {
                        $arrResponse = array ('status' => true, 'msg' => 'Se ha eliminado la sucursal');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la sucursal.');
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    } 
                }  
            die();  
        }
    }
?>
