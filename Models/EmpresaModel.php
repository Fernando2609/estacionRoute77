<?php
class EmpresaModel extends Mysql{
		
        private $intIdUsuario;
		private $strNombreEmpresa;
		private $strDireccion;
		private $strRazonSocial;
		private $strEmail;
		private $strGerenteGeneral;

		
        public function __construct()
        {
           parent::__construct();
        }

        public function insertEmpresa(string $nombreEmpresa, string $direccion, string $razonSocial, string $email, string $gerenteGeneral ){
		
			$this->strNombreEmpresa = $nombreEmpresa;
			$this->strDireccion = $direccion;
			$this->strRazonSocial = $razonSocial;
			$this->strEmail = $email;
			$this->strGerenteGeneral = $gerenteGeneral;
			


			$return = 0;
			
			

			

			if(empty($request))
			{
				/* $query_insert  = "INSERT INTO usuarios(dni,nombres,apellidos,email,contraseña,idNacionalidad,idGenero,idEstadoCivil,idRol,idSucursal,fechaNacimiento,status,telefono) 
								  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)"; */
				$query_insert= "CALL CRUD_EMPRESA(?,?,?,?,?,'I',null)";
	        	$arrData = array($this->strNombreEmpresa,
									$this->strDireccion,
                                    $this->strRazonSocial,
									$this->strEmail,
                                    $this->strGerenteGeneral);
									
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
	        	$return = $request_ID['last_insert_id()'];
              
			}else{
				$return = false;
			}
	        return $return;
		}
    public function selectEmpresas()
    {

        /*$sql = "SELECT idUsuario, dni, nombres, apellidos, telefono, email, status
					FROM usuarios */
        $sql = "CALL CRUD_EMPRESA(null,null,null,null,null,null,null,null,null,null,null,null,'V',null)";
        //WHERE idRol = 7 and status != 0";
        $request = $this->select_all($sql);
		
        return $request;
    }

	public function selectEmpresa(int $idUsuario)
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

			$sql = "CALL CRUD_EMPRESA(null,null,null,null,null,null,null,null,null,null,null,null,'R',$this->intIdUsuario)";

		$request = $this->select($sql);

		return $request;
	}

	public function updateEmpresa(int $idUsuario, string $NombreEmpresa, string $Direccion, string $RazonSocial, string $email, string $GerenteGeneral, int $costoEnvio, string $RTN, string $strEmailPedidos,string $strTelEmpresa,string $strCelEmpresa,string $strCatSlider, string $strCatBanner)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strNombreEmpresa = $NombreEmpresa;
		$this->strDireccion = $Direccion;
		$this->strRazonSocial = $RazonSocial;
		$this->strEmail = $email;
		$this->strGerenteGeneral = $GerenteGeneral;
		

		$this->intCostoEnvio = $costoEnvio;
		$this->strRTN = $RTN;
		$this->strEmailPedidos = $strEmailPedidos;
		$this->strTelEmpresa = $strTelEmpresa;
		$this->strCelEmpresa = $strCelEmpresa;
		$this->strCatSlider = $strCatSlider;
		$this->strCatBanner = $strCatBanner;


		//$sql = "SELECT * FROM tbl_personas WHERE (email = '{$this->strEmail}' AND COD_PERSONA != $this->intIdUsuario)";
		//Areglar despues
		//OR (DNI = '{$this->strIdentificacion}' AND COD_PERSONA != $this->intIdUsuario)

		/* $sql = "SELECT * FROM tbl_personas p
			LEFT JOIN tbl_empresa u on p.COD_PERSONA=u.COD_PERSONA
			WHERE p.EMAIL = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario OR u.DNI = '{$this->strIdentificacion}' AND p.COD_PERSONA != $this->intIdUsuario";

		$request = $this->select_all($sql); */

		if (empty($request)) {	//Si la contraseña es diferente a vaacio se actualiza la contraseña
			
				/* $sql = "UPDATE usuarios SET dni=?,nombres=?,apellidos=?,email=?,contraseña=?,idNacionalidad=?,idGenero=?,idEstadoCivil=?,idRol=?,idSucursal=?,fechaNacimiento=?,status=?,telefono=?,datemodificado=?
							WHERE idUsuario = $this->intIdUsuario "; */
				$sql = "CALL CRUD_EMPRESA(?,?,?,?,?,?,?,?,?,?,?,?,'U',$this->intIdUsuario)";
				$arrData = array(
					$this->strNombreEmpresa,
					$this->strDireccion,
					$this->strRazonSocial,
					$this->strEmail,
					$this->strGerenteGeneral,
					$this->intCostoEnvio,
					$this->strRTN,
					$this->strEmailPedidos,
					$this->strTelEmpresa,
					$this->strCelEmpresa,
					$this->strCatSlider,
					$this->strCatBanner

				);
			
			
			$request = $this->update($sql, $arrData);
		} else {
			$request = false;
		}

		return $request;
	}

	public function deleteEmpresa(int $intIdUser)
	{
		$this->intIdUsuario = $intIdUser;
		/* $sql = "UPDATE usuarios SET status = ? WHERE idUsuario = $intIdUser"; */
		$sql = "CALL CRUD_EMPRESA(null,null,null,null,null,'D',?)";
		$arrData = array($this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}



    }
?>