<?php
 class Clientes extends Controllers{
        public function __construct()
        {
            parent::__construct();
            session_start();
            //session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(MCLIENTES);
        }
        
        public function Clientes()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
            $data['page_tag']="Clientes";
            $data['page_title']="CLIENTES <small>Route 77</small>";
            $data['page_name']="clientes";
            $data['page_functions_js']="functions_clientes.js";
            $this->views->getView($this,"clientes",$data);
        }

        public function setCliente()
        {
            if ($_POST) {
                
                if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listStatus']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
                    $idUsuario = intval($_POST['idUsuario']);
					//$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					
					$strEmail = strtolower(strClean($_POST['txtEmail']));
                    $intTipoId = 2;
					$intStatus = intval(strClean($_POST['listStatus']));
                    $intTelefono = intval(strClean($_POST['txtTelefono']));
					
                   /* $intNacionalidad = intval(strClean($_POST['listNacionalidadCliente']));
                    $intGenero = intval(strClean($_POST['listGenero']));
                    $intEstadoC = intval(strClean($_POST['listEstadoC']));
                    $intSucursal = intval(strClean($_POST['listSucursal'])); 
                    $strFechaNacimiento = strClean($_POST['fechaNacimiento']);*/
                    $user=intval($_SESSION['idUser']);
                    
                    $request_user="";

                    if ($idUsuario==0) {
                        $option=1;
                        $strPassword =  empty($_POST['txtPassword']) ? passGenerator() : hash("SHA256",$_POST['txtPassword']);
                        $strPasswordEncrip = hash("SHA256",$strPassword);
                       
                       // $strPassword =  empty($_POST['txtPassword']) ?passGenerator() : $_POST['txtPassword'];
                      //$strPasswordEncrip = hash("SHA256",$strPassword);
                        if($_SESSION['permisosMod']['w']){
                        $request_user = $this->model->insertCliente($strNombre,     $strApellido, 
                                                                                   $strEmail,
                                                                                    $strPasswordEncrip,
                                                                                    $intTipoId, 
                                                                                    $intStatus,
                                                                                    $intTelefono, 
                                                                                    $user    
                                                                                );
                                                                                   
                        } 
                    }else{
                         $option=2;
                         $strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
                         if($_SESSION['permisosMod']['u']){
                        $request_user = $this->model->updateCliente($idUsuario,     
                                                                                    $strNombre, 
                                                                                    $strApellido, 
                                                                                    $strEmail,
                                                                                    $strPassword,
                                                                                    $intTipoId,
                                                                                    $intStatus,
                                                                                    $intTelefono,
                                                                                    $user    
                                                                                   );
                        }
                   
                }
                    if($request_user > 0 ){
                        if ($option==1) {
                            $arrResponse = array("status" => true, "msg" => 'Cliente Guardado Correctamente.');
                            $nombreUsuario = $strNombre.' '.$strApellido;
                        $dataUsuario = array(
                            'nombreUsuario' => $nombreUsuario,
                            'email' => $strEmail,
                            'password' => $strPassword,
                            'asunto' => 'Bienvenido a tu Tienda en Línea');
                        sendEmail($dataUsuario, 'email_bienvenida');
                            
                        }else{
                            $arrResponse = array("status" => true, "msg" => 'Cliente Actualizado Correctamente.');
                        }
                    }else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email  ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.Verifique el Email');
					}
                 }
                 echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            
            die();
        }
    
/*
        public function getSelectNacionalidadCliente()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectNacionalidadCliente();
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
            $arrData = $this->model->selectGeneroCliente();
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
            $arrData = $this->model->selectEstadoCCliente();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                
                    $htmlOptions .= '<option value="'.$arrData[$i]['idEstado'].'">'.$arrData[$i]['descripcion'].'</option>';
                    
                }
            }
            echo $htmlOptions;
            die();		
        }
*/
        public function getClientes()
        {
            if($_SESSION['permisosMod']['r']){ 
            $arrData= $this->model->selectClientes();
           /* dep($arrData);
            exit;*/
            for ($i=0; $i < count($arrData) ; $i++) { 
                $btnView ='';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['COD_STATUS']==1) {
                 $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';   
                }else{
                 $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if($_SESSION['permisosMod']['r']){
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['COD_PERSONA'].')" title="Ver Cliente"><i class="far fa-eye"></i></button>';
                }

                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['COD_PERSONA'].')" title="Editar Cliente"><i class="fas fa-pencil-alt"></i></button>';                 
                }

                if($_SESSION['permisosMod']['d']){
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['COD_PERSONA'].')" title="Eliminar Cliente"><i class="far fa-trash-alt"></i></button>';  
                }
                
 
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                
             } 
            /*  dep($arrData[0]['status']);exit; */
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
         }
             die();
        }   
      
        public function getCliente($idUsuario){
            /*echo $idUsuario;
            die();*/
            if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idUsuario);

				if($idusuario > 0)
				{
					$arrData = $this->model->selectCliente($idusuario);
                     /*dep($arrData);
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


    public function delCliente()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdpersona = intval($_POST['idUsuario']);

                $requestDelete = $this->model->deleteCliente($intIdpersona);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Cliente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Cliente.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
        //Funcion para traer La Sucursal
        /*public function getSelectSucursal()
        //{
            $htmlOptions = "";
            $arrData = $this->model->selectSucursal();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                
                    $htmlOptions .= '<option value="'.$arrData[$i]['idsucursal'].'">'.$arrData[$i]['nombre'].'</option>';
                    
               // }
           // }
            echo $htmlOptions;
            die();		
        }*/


    }

?>