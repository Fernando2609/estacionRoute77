<?php  
    class Login extends Controllers{
        public function __construct()
        {
          
            session_start();
            if (isset($_SESSION['login'])) {
                header('Location: '.base_url().'/dashboard');
                die();
            }
            parent::__construct();
            
            
        }
        
        public function login()
        {
           
            $data['page_tag']="Login - Route 77";
            $data['page_title']="LOGIN ESTACIÓN ROUTE 77";
            $data['page_name']="login";
            $data['page_functions_js']="functions_login.js";
            $this->views->getView($this,"login",$data);
        }
        public function LoginUser(){
           // dep($_POST);
           if($_POST){
               if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
                   $arrResponse = array('status' => false, 'msg' => 'Error de datos');
                }else{
                   
                   $strUsuario = strtolower(strClean($_POST['txtEmail']));
                   $strPassword = hash("SHA256", $_POST['txtPassword']);
                   $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                   if(empty($requestUser)){
                    $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.' ); 
                }else{
                    $arrData = $requestUser;
                    
						if($arrData['COD_STATUS'] == 1){
							$_SESSION['idUser'] = $arrData['COD_PERSONA'];
							$_SESSION['login'] = true;
                            $this->model->sessionUpdate($_SESSION['idUser']);
							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
                            sessionUser($_SESSION['idUser']);

                            $arrData = $this->model->selectProductos();
               
                            $arrNotificaciones=array();
                            for ($i=0; $i < count($arrData); $i++) { 
                            $arrinfoProducto=array(
                            'nombre'=>$arrData[$i]['NOMBRE'],
                            'categoria'=>$arrData[$i]['CATEGORÍA'],
                            'stock'=>$arrData[$i]['STOCK'],
                            'cant_minima'=>$arrData[$i]['CANT_MINIMA']
                            );
                                array_push($arrNotificaciones,$arrinfoProducto);
                            }
                         $_SESSION['notificaciones']=$arrNotificaciones;

                         $htmlNotifi = getFile('Template/Modals/notificaciones',$_SESSION['notificaciones']);
                            
							$arrResponse = array('status' => true, 'msg' => 'ok'); 
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
						}
                  }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function resetPass()
        {
            
            if ($_POST) {
                if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else {
                    $token=token();
                    $strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);
                   
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.' ); 
					}else{
                        $idUsuario = $arrData['COD_PERSONA'];
						$nombreUsuario = $arrData['NOMBRES'].' '.$arrData['APELLIDOS'];
                        $url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idUsuario,$token);
                        //$datosEmpresa=$this->model->datosEmpresa();
                        $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                        'email' => $strEmail,
                        'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE,
                        'url_recovery' => $url_recovery);
                        
                        if($requestUpdate){
                            $sendEmail = sendEmail($dataUsuario,'email_cambioPassword');
                            
                           
                            if($sendEmail){
                                $arrResponse = array('status' => true, 
                                                 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
                            }else{
                                $arrResponse = array('status' => false, 
                                'msg' => 'No es posible realizar el proceso, intenta más tarde. 1' );
                            }
                        }else{
                            $arrResponse = array('status' => false, 
                                             'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
                        }
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function confirmUser(string $params){

			if(empty($params)){
				header('Location: '.base_url());
			}else{
				$arrParams = explode(',',$params);
                //dep($arrParams);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
                $arrResponse = $this->model->getUsuario($strEmail,$strToken);
			}	if(empty($arrResponse)){
                header("Location: ".base_url());
            }else{ 
					$data['page_tag'] = "Cambiar contraseña";
					$data['page_name'] = "cambiar_contrasenia";
					$data['page_title'] = "Cambiar Contraseña";
					$data['idUsuario'] = $arrResponse['COD_PERSONA'];
                    $data['page_functions_js'] = "functions_login.js";  
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$this->views->getView($this,"cambiarPassword",$data);
		     }
			die();
		}
        public function setPassword(){
            
			 if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){

					$arrResponse = array('status' => false, 
										 'msg' => 'Error de datos' );
				}else{
					$intIdUsuario= intval($_POST['idUsuario']);
					$strPassword = $_POST['txtPassword'];
					$strPasswordConfirm = $_POST['txtPasswordConfirm'];
					$strEmail = strClean($_POST['txtEmail']);
					$strToken = strClean($_POST['txtToken']);

					if($strPassword != $strPasswordConfirm){
						$arrResponse = array('status' => false, 
											 'msg' => 'Las contraseñas no son iguales.' );
					}else{
						$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
						if(empty($arrResponseUser)){
							$arrResponse = array('status' => false, 
											 'msg' => 'Error de datos.' );
						}else{
                            //Encriptación de contraseña
							$strPassword = hash("SHA256",$strPassword);
                            //Se ejecuta el query
							$requestPass = $this->model->insertPassword($intIdUsuario ,$strPassword);

							if($requestPass){
								$arrResponse = array('status' => true, 
													 'msg' => 'Contraseña actualizada con éxito.');
							}else{
								$arrResponse = array('status' => false, 
													 'msg' => 'No es posible realizar el proceso, intente más tarde.');
							}
						}
					}
				}
            
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die(); 
		}
    }

?>
