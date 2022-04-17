<?php
class redesSocialesModel extends Mysql{  

		private $intIdUsuario;
		private $strDescripcion;
		private $strEnlace;
        

        public function __construct()
        {
           parent::__construct();
        } 
		
		public function insertredesSociales(string $descripcion, string $enlace){

			
			$this->strDescripcion = $descripcion;
			$this->strEnlace = $enlace;

			$return = 0;
            //validación

			/*  $sql = "SELECT * from tbl_redes_sociales where ENLACE ='$this->strEnlace' or DESCRIPCION='$this->strDescripcion'";
           */
            $sql="CALL CRUD_REDES_SOCIALES(null,'$this->strDescripcion','$this->strEnlace','A',null)";
			/* dep($sql);
            exit; */
            $request = $this->select_all($sql); 

			if(empty($request))
			{
				
				$query_insert= " CALL CRUD_REDES_SOCIALES(1,?,?,'I',null)";
				$arrData = array($this->strDescripcion,
        						$this->strEnlace);
		
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
	        	$return = $request_ID['last_insert_id()'];
				
			}else{
				$return = false;
			}
	        return $return;
		}
    public function selectredesSociales()
    {

        /*$sql = "SELECT idUsuario, dni, nombres, apellidos, telefono, email, status
					FROM usuarios */
        $sql = "CALL CRUD_REDES_SOCIALES(1,null,null,'V',null)";
        //WHERE idRol = 7 and status != 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectredSocial(int $idUsuario)
    {
        $this->intIdUsuario = $idUsuario;
        /* $sql = "SELECT u.idUsuario,u.dni,u.nombres,u.apellidos,u.telefono,
			u.email,u.datecreated,DATE_FORMAT(u.datecreated,'%d-%m-%Y %r') as fechaRegistro,
			DATE_FORMAT(u.fechaNacimiento,'%d-%m-%Y') as fechaNacimiento, DATE_FORMAT(u.fechaNacimiento,'%Y-%m-%d') as fechaNaci,u.status,DATE_FORMAT(u.datelogin,'%d-%m-%Y %r') as datelogin,DATE_FORMAT(u.datemodificado,'%d-%m-%Y %r') as datemodificado ,
			s.idsucursal,s.nombre as 'sucursal',r.Id_Rol,r.nombreRol, 
			n.idNacionalidad,n.descripcion as 'nacionalidad',g.idGenero, g.descripcion as 'genero',
			e.idEstado,e.descripcion as 'estadocivil' 
			FROM usuarios u 
			INNER JOIN roles r ON u.idRol = r.Id_Rol 
			INNER JOIN nacionalidad n ON u.idNacionalidad = n.idNacionalidad 
			INNER JOIN genero g on u.idGenero = g.idGenero 
			INNER JOIN sucursal s on u.idSucursal = s.idsucursal 
			INNER JOIN estadocivil e on u.idEstadoCivil = e.idEstado 
			WHERE u.idUsuario = $this->intIdUsuario"; */

        $sql = "CALL CRUD_REDES_SOCIALES(1,null,null,'R',$this->intIdUsuario)";

        $request = $this->select($sql);

        return $request;
    }
    public function updateredesSociales(int $idUsuario, string $descripcion,  string $enlace)
    {

        $this->intIdUsuario = $idUsuario;
        $this->strDescripcion = $descripcion;
        $this->strEnlace = $enlace;


        //$sql = "SELECT * FROM tbl_personas WHERE (email = '{$this->strEmail}' AND COD_PERSONA != $this->intIdUsuario)";
        //Areglar despues
        //OR (DNI = '{$this->strIdentificacion}' AND COD_PERSONA != $this->intIdUsuario)

        /* $sql = "SELECT * FROM tbl_personas p
			LEFT JOIN tbl_empresa u on p.COD_PERSONA=u.COD_PERSONA
			WHERE p.EMAIL = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario OR u.DNI = '{$this->strIdentificacion}' AND p.COD_PERSONA != $this->intIdUsuario";

		$request = $this->select_all($sql); */

        if (empty($request)) {    //Si la contraseña es diferente a vaacio se actualiza la contraseña

            /* $sql = "UPDATE usuarios SET dni=?,nombres=?,apellidos=?,email=?,contraseña=?,idNacionalidad=?,idGenero=?,idEstadoCivil=?,idRol=?,idSucursal=?,fechaNacimiento=?,status=?,telefono=?,datemodificado=?
							WHERE idUsuario = $this->intIdUsuario "; */
            $sql = "CALL CRUD_REDES_SOCIALES(1,?,?,'U',$this->intIdUsuario)";
            $arrData = array(
                $this->strDescripcion,
                $this->strEnlace,
            );


            $request = $this->update($sql, $arrData);
        } else {
            $request = false;
        }

        return $request;
    }

    public function deleteredSocial(int $intIdUser)
    {
        $this->intIdUsuario = $intIdUser;
        /* $sql = "UPDATE usuarios SET status = ? WHERE idUsuario = $intIdUser"; */
        $sql = "CALL CRUD_REDES_SOCIALES(1,null,null,'D',?)";
        $arrData = array($this->intIdUsuario);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    }
?>