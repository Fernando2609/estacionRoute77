<?php 

	class Paginas extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MPÁGINAS);
		}

		public function paginas()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Páginas";
			$data['page_title'] = "Páginas <small>Route 77</small>";
			$data['page_name'] = "paginas";
			$data['page_functions_js'] = "functions_Paginas.js";
            
			$this->views->getView($this,"paginas",$data);
		}
        public function editar($idPost)
        {
            if($_SESSION['permisosMod']['u']){
                $idPost=intval($idPost);
                if ($idPost>0) {
                    $data['page_tag'] = "Actualizar Página";
                    $data['page_title'] = "ACTUALIZAR PÁGINAS";
                    $data['page_name'] = "actualizar_paginas";
                    $data['page_functions_js'] = "functions_Paginas.js";
                    $infopage=getInfoPage($idPost);
                    if (empty($infopage)) {
                        header("Location:".base_url().'/paginas');
                    }else{
                        $data['infoPage']=$infopage;
                    }
                    $this->views->getView($this,"editarPagina",$data);
                }else{
                    header("Location:".base_url().'/paginas');
                }
             }
        }
        public function crear()
        {
            if($_SESSION['permisosMod']['w']){
               
              
                    $data['page_tag'] = "Crear Página";
                    $data['page_title'] = "CREAR PÁGINAS";
                    $data['page_name'] = "crear_paginas";
                    $data['page_functions_js'] = "functions_Paginas.js";
                   
                    
                    $this->views->getView($this,"crearPagina",$data);
            
             }
        }
        public function getPaginas(){
            if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectPaginas();
                for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';
                    $urlPage=base_url()."/".$arrData[$i]['RUTA'];
                    
                   /*  if($arrData[$i]['COD_STATUS'] == 1)
                    {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    }else{
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }
 */
                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<a title="Ver página" href="'.$urlPage.'" target="_balnck" class="btn btn-info btn-sm"> <i class="far fa-eye"></i></a>'; 
                    }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<a title="Editar página" href="'.base_url().'/paginas/editar/'.$arrData[$i]['COD_POST'].'" class="btn btn-warning btn-sm"> <i class="fas fa-pencil-alt"></i></a>';
                    }
                    if($_SESSION['permisosMod']['d']){	
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['COD_POST'].')" title="Eliminar página"><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                
			}
			die();
        }
      
        public function setPagina()
        {
          
            if ($_POST) {
               // dep($_POST);
                //dep($_FILES);
              
                if(empty($_POST['txtTitulo']) || empty($_POST['txtContenido']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else {
                    $intIdPost = empty($_POST['idPost']) ? 0 : intval($_POST['idPost']);
                    $strTitulo =  strClean($_POST['txtTitulo']);
                    $strContenido = $_POST['txtContenido'];
                    $intStatus = intval($_POST['listStatus']);
                    $ruta = strtolower(clear_cadena($strTitulo));
					$ruta = str_replace(" ","-",$ruta);
                    $user=$_SESSION['idUser'];
                    //Imagen

					$foto   	 	= $_FILES['foto'];
					$nombre_foto 	= $foto['name'];
					$type 		 	= $foto['type'];
					$url_temp    	= $foto['tmp_name'];
					$imgPortada 	= '';
                    $request = "";

					
                    if($nombre_foto != ''){
 						$imgPortada = 'img_'.md5(date('d-m-Y H:i:s')).'.jpg';
					}
                  
                if ($intIdPost==0) {
                   
                    if($_SESSION['permisosMod']['w']){
                    
                   
                    $request = $this->model->insertPost($strTitulo, $strContenido,$imgPortada,$ruta, $intStatus);
                    $option=1;
                   
                     }
                }else{
                    //Si hay idCategoria se actualiza el registro
                    if($_SESSION['permisosMod']['u']){
                    if($nombre_foto == ''){
                        if($_POST['foto_actual'] != '' &&  $_POST['foto_remove'] == 0){
                            $imgPortada = $_POST['foto_actual'];
                          }
                         }
                   $request = $this->model->updatePost($intIdPost,$strTitulo, $strContenido,$imgPortada,$intStatus,$user);
                    $option=2;
                    
                     }
                }
                
                if($request > 0 )
                {
                if($option == 1)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
                }else   {
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
                    if(($nombre_foto == '' AND $_POST['foto_remove'] == 1 AND $_POST['foto_actual'] != '')
                        || ($nombre_foto != '' AND $_POST['foto_actual'] != '')){
                        deleteFile($_POST['foto_actual']);
                    }
                     
                    }
                }else if($request==0){
                    $arrResponse = array("status" => false, "msg" => 'Lá Página ya existe');
                }else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                  }
                    
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delPagina(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdPagina = intval($_POST['idPagina']);
					$requestDelete = $this->model->deletePagina($intIdPagina);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Página');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Página.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
?>