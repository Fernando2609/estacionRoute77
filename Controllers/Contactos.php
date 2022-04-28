<?php 

	class Contactos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MCONTACTO);
		}

		public function contactos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Contactos";
			$data['page_title'] = "Contactos <small>Route 77</small>";
			$data['page_name'] = "Contactos";
			$data['page_functions_js'] = "functions_Contactos.js";
			$this->views->getView($this,"contactos",$data);
		}

		public function getContactos(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectContactos();
                for ($i=0; $i < count($arrData); $i++) { 
                    $btnView='';
                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['COD_CONTACTO'] . ')" title="Ver Mensaje"><i class="far fa-eye"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">' . $btnView. '</div>';
                }
                
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function getMensaje($idMensaje){
			if($_SESSION['permisosMod']['r']){
				$idMensaje = intval($idMensaje);
				if($idMensaje > 0){
					$arrData = $this->model->selectMensaje($idMensaje);
            
					
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

	}
?>