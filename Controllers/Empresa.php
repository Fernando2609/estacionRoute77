<?php
class Empresa extends Controllers{
        public function __construct()
        {
            parent::__construct();
            session_start();
            //session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(14);
        }
        
        public function Empresa()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header('Location: '.base_url().'/dashboard');
            }
            $data['page_tag']="Empresa";
            $data['page_title']="EMPRESA <small>Route 77</small>";
            $data['page_name']="empresa";
            $data['page_functions_js']="functions_empresa.js";
            $this->views->getView($this,"empresa",$data);
        }

    public function setEmpresa(){ {
            if ($_POST) {
                if (empty($_POST['txtNombreEmpresa']) || empty($_POST['txtDireccion']) || empty($_POST['txtRazonSocial']) || empty($_POST['txtEmail']) || empty($_POST['txtGerenteGeneral'])) {
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                } else {
                    $idUsuario = intval($_POST['idUsuario']);
                    $strNombreEmpresa = strClean($_POST['txtNombreEmpresa']);
                    $strDireccion = ucwords(strClean($_POST['txtDireccion']));
                    $strRazonSocial = ucwords(strClean($_POST['txtRazonSocial']));
                    $strEmail = strtolower(strClean($_POST['txtEmail']));
                    $strGerenteGeneral = ucwords(strClean($_POST['txtGerenteGeneral']));
                    
                    if ($idUsuario == 0) {
                        $option = 1;
                        
                        if ($_SESSION['permisosMod']['w']) {
                          /*   $request_user = $this->model->insertEmpresa(
                                $strNombreEmpresa,
                                $strDireccion,
                                $strRazonSocial,
                                $strEmail,
                                $strGerenteGeneral,

                            ); */
                        }
                    } else {
                         $option = 2;
                        
                        if ($_SESSION['permisosMod']['u']) {
                            $request_user = $this->model->updateEmpresa(
                                $idUsuario,
                                $strNombreEmpresa,
                                $strDireccion,
                                $strRazonSocial,
                                $strEmail,
                                $strGerenteGeneral,
                                
                            );
                        } 
                    }

                    if ($request_user > 0) {
                        if ($option == 1) {
                            $arrResponse = array("status" => true, "msg" => 'Empresa Guardada Correctamente.');
                        } else {
                            $arrResponse = array("status" => true, "msg" => 'Empresa Actualizada Correctamente.');
                        }
                    } else if ($request_user == 'exist') {
                        $arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos Verifique el email.');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }

            die();
        }
    }
    public function getEmpresas()
    {

        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectEmpresas();
             /* dep($arrData);
            exit; */ 
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['COD_EMPRESA'] . ')" title="Ver empresa"><i class="far fa-eye"></i></button>';
                }

                if ($_SESSION['permisosMod']['u']) {
                        $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['COD_EMPRESA'] . ')" title="Editar empresa"><i class="fas fa-pencil-alt"></i></button>';
                }

               /*  if ($_SESSION['permisosMod']['d']) {
                    
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['COD_EMPRESA'] . ')" title="Eliminar empresa"><i class="far fa-trash-alt"></i></button>';
                    
                } */


                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit /* . ' ' . $btnDelete */ . '</div>';
            }
            /*  dep($arrData[0]['status']);exit; */
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getEmpresa($idUsuario)
    {
        //echo $idUsuario;
        //die();
        if ($_SESSION['permisosMod']['r']) {
            $idusuario = intval($idUsuario);
            if ($idusuario > 0) {
                $arrData = $this->model->selectEmpresa($idusuario);

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

   /*  public function delEmpresa()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdpersona = intval($_POST['idUsuario']);

                $requestDelete = $this->model->deleteEmpresa($intIdpersona);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Empresa');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Empresa.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    } */



    }


?>