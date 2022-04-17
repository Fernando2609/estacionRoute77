<?php
class Inventario extends Controllers{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: '.base_url().'/login');
            die();
        }
        getPermisos(9);
    }
    
    public function Inventario()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header('Location: '.base_url().'/dashboard');
        }
        $data['page_tag']="Inventario";
        $data['page_title']="INVENTARIO <small>Route 77</small>";
        $data['page_name']="inventario";
        $data['page_functions_js']="functions_inventario.js";
        $this->views->getView($this,"inventario",$data);
    }

  
public function getInventarios()
{

    if ($_SESSION['permisosMod']['r']) {
        $arrData = $this->model->selectInventarios();
        
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';

            

            if ($_SESSION['permisosMod']['r']) {
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['COD_PRODUCTO'] . ')" title="Ver empresa"><i class="far fa-eye"></i></button>';
            }


           /*  if ($_SESSION['permisosMod']['d']) {
                
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['COD_EMPRESA'] . ')" title="Eliminar empresa"><i class="far fa-trash-alt"></i></button>';
                
            } */


            $arrData[$i]['options'] = '<div class="text-center">' . $btnView  /* . ' ' . $btnDelete */ . '</div>';
        }
        /*  dep($arrData[0]['status']);exit; */
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    die();
}
public function getInventario($idUsuario)
{
    //echo $idUsuario;
    //die();
    if ($_SESSION['permisosMod']['r']) {
        $idusuario = intval($idUsuario);
        if ($idusuario > 0) {
            $arrData = $this->model->selectInventario($idusuario);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }
    die();
}   

}
   

    ?>