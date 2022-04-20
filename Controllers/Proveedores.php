<?php
class Proveedores extends Controllers{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: '.base_url().'/login');
            die();
        }
        getPermisos(15);
    }
    
    public function Proveedores()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header('Location: '.base_url().'/dashboard');
        }
        $data['page_tag']="Proveedores";
        $data['page_title']="PROVEEDORES <small>Route 77</small>";
        $data['page_name']="Proveedores";
        $data['page_functions_js']="functions_Proveedores.js";
        $this->views->getView($this,"proveedores",$data);
    }

    public function setProveedores()
    {
    
        if ($_POST) {
            if(empty($_POST['txtRTN']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtEmpresa']) || empty($_POST['listStatus']) ||  empty($_POST['txtUbicacion']) )
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{ 
                $idProveedores = intval($_POST['idProveedores']);
                $strRTN = strClean($_POST['txtRTN']);
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $intTipoId = 3;
                $strEmpresa = ucwords(strClean($_POST['txtEmpresa']));
                $intStatus = intval(strClean($_POST['listStatus']));
                $strUbicacion = ucwords(strClean($_POST['txtUbicacion']));
                $user=intval($_SESSION['idUser']);
                
                $request_user="";
                if ($idProveedores==0) {
                    $option=1;
                    if($_SESSION['permisosMod']['w']){
                    $request_user = $this->model->insertProveedores(
                                                                                $strNombre, 
                                                                                $strApellido,
                                                                                $strEmail,
                                                                                $intStatus,
                                                                                $intTipoId, 
                                                                                $intTelefono, 
                                                                                $strEmpresa,
                                                                                $strRTN, 
                                                                                $strUbicacion, 
                                                                                $user
                                                                               );
                    
                    }
                }else{
                    $option=2;
                    if($_SESSION['permisosMod']['u']){
                    $request_user = $this->model->updateProveedores($strNombre, 
                                                                                $strApellido,
                                                                                $strEmail,
                                                                                $intStatus,
                                                                                $intTipoId, 
                                                                                $intTelefono, 
                                                                                $strEmpresa,
                                                                                $strRTN, 
                                                                                $strUbicacion, 
                                                                                $user,
                                                                                $idProveedores
                                                                                );

                }
                }
                
                if($request_user > 0 ){
                    if ($option==1) {
                        $arrResponse = array("status" => true, "msg" => 'Proveedor Guardado Correctamente.');
                    }else{
                        $arrResponse = array("status" => true, "msg" => 'Proveedor Actualizado Correctamente.');
                    }
                }else if($request_user == 'exist'){
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
                }else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos Verifique el email y el RTN.');
                }
             }
             echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        
        die();
    }
    public function getProveedores()
    {
        if($_SESSION['permisosMod']['r']){ 
        $arrData= $this->model->selectProveedores();
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
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['COD_PERSONA'].')" title="Ver Proveedor"><i class="far fa-eye"></i></button>';
            }

            if($_SESSION['permisosMod']['u']){
                $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['COD_PERSONA'].')" title="Editar Proveedor"><i class="fas fa-pencil-alt"></i></button>';                 
            }

            if($_SESSION['permisosMod']['d']){
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['COD_PERSONA'].')" title="Eliminar Proveedor"><i class="far fa-trash-alt"></i></button>';  
            }
            

            $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            
         } 
        /*  dep($arrData[0]['status']);exit; */
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
     }
         die();
    }   
  
    public function getProveedor($idProveedores){
        /*echo $idUsuario;
        die();*/
        if($_SESSION['permisosMod']['r']){
            $idProveedores = intval($idProveedores);

            if($idProveedores > 0)
            {
                $arrData = $this->model->selectProveedor($idProveedores);
                /*dep($arrData);
                exit;*/ 
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


public function delProveedor()
{
    if ($_POST) {
        if ($_SESSION['permisosMod']['d']) {
            $intIdpersona = intval($_POST['idProveedores']);

            $requestDelete = $this->model->deleteProveedor($intIdpersona);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el proveedor');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al proveedor.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }
    die();
}


}

?>