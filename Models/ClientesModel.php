<?php  
    
    class ClientesModel extends Mysql{  

		//private $intIdUsuario;
		//private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
        

        public function __construct()
        {
           parent::__construct();
        } 
		
		public function insertCliente(string $nombre, string $apellido, string $email, string $password, int $tipoid, int $status, int $telefono, int $user ){

			//$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$this->intTelefono = $telefono;
			$this->intuser = $user;
            /*$this->intNacionalidad = $nacionalidad;
            $this->intGenero = $genero;
            $this->intEstadoC = $estadoC;
             $this->intSucursal = $sucursal;
            $this->strFechaNacimiento=$fechaNacimeinto;
*/

			$return = 0;

			$sql = "SELECT * FROM TBL_PERSONAS p 
			left join tbl_cliente c on p.COD_PERSONA=c.COD_PERSONA
			WHERE p.email =  '{$this->strEmail}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				
				$query_insert=" CALL CRUD_CLIENTE(?,?,?,?,?,?,?,?,null,'I',null)";
				$arrData = array($this->strNombre,
        						$this->strApellido,
        						$this->strEmail,
        						$this->strPassword,
                                $this->intTipoId,
                                $this->intStatus,
        						$this->intTelefono,
								$this->intuser);
		
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
	        	$return = $request_ID['last_insert_id()'];
				
			}else{
				$return = false;
			}
	        return $return;
		}

		public function selectClientes()
		{
			
			/*$sql = "SELECT idUsuario, dni, nombres, apellidos, telefono, email, status
					FROM usuarios */
            $sql = "CALL CRUD_CLIENTE(null,null,null,null,null,null,null,NULL,NULL,'V',null)";
			//WHERE idRol = 7 and status != 0";
			    $request = $this->select_all($sql);
				return $request;
		}
        
        
        /*public function SelectNacionalidadCliente()
        {
        // Extraer Nacionalidad
        $sql = "SELECT * FROM nacionalidad";
        $request = $this->select_all($sql); 
        return $request;

        }
		 //Funcion para traer el genero de usuario
		public function SelectGeneroCliente()
		{
			// Extraer Genero
			$sql = "SELECT * FROM genero";
			$request = $this->select_all($sql); 
			return $request;

		}
		 //Funcion para traer el Estado Civil
		 public function selectEstadoCCliente()
		 {
			 // Extraer estado Civil
			 $sql = "SELECT * FROM estadocivil";
			 $request = $this->select_all($sql); 
			 return $request;
 
		 }
		//Funcion para traer la sucursal
		public function selectSucursal()
		{
			// Extraer estado Civil
			$sql = "SELECT * FROM sucursal";
			$request = $this->select_all($sql); 
			return $request;

		}*/
		 public function selectCliente(int $idUsuario){
			$this->intIdUsuario = $idUsuario;

			/* $sql = "SELECT idUsuario, dni, nombres, apellidos, telefono,
			email,u.datecreated,DATE_FORMAT(u.datecreated,'%d-%m-%Y %r') as fechaRegistro,
			DATE_FORMAT(u.fechaNacimiento,'%d-%m-%Y') as fechaNacimiento, DATE_FORMAT(u.fechaNacimiento,'%Y-%m-%d') as fechaNaci,u.status,DATE_FORMAT(u.datelogin,'%d-%m-%Y %r') as datelogin,DATE_FORMAT(u.datemodificado,'%d-%m-%Y %r') as datemodificado , 
			n.idNacionalidad,n.descripcion as 'nacionalidad',g.idGenero, g.descripcion as 'genero',
			e.idEstado,e.descripcion as 'estadocivil' 
			FROM usuarios
			INNER JOIN nacionalidad n ON u.idNacionalidad = n.idNacionalidad 
			INNER JOIN genero g on u.idGenero = g.idGenero 
			INNER JOIN estadocivil e on u.idEstadoCivil = e.idEstado 
			WHERE idUsuario = $this->intIdUsuario"; */
			/*$sql = "SELECT u.idUsuario,u.dni,u.nombres,u.apellidos,u.telefono,
			u.email,u.datecreated,DATE_FORMAT(u.datecreated,'%d-%m-%Y %r') as fechaRegistro,
			DATE_FORMAT(u.fechaNacimiento,'%d-%m-%Y') as fechaNacimiento, DATE_FORMAT(u.fechaNacimiento,'%Y-%m-%d') as fechaNaci,u.status,DATE_FORMAT(u.datelogin,'%d-%m-%Y %r') as datelogin,DATE_FORMAT(u.datemodificado,'%d-%m-%Y %r') as datemodificado ,
			s.idsucursal,s.nombre as 'sucursal',n.idNacionalidad,n.descripcion as 'nacionalidad',g.idGenero, g.descripcion as 'genero',
			e.idEstado,e.descripcion as 'estadocivil' 
			FROM usuarios u 
			INNER JOIN roles r ON u.idRol = r.Id_Rol 
			INNER JOIN nacionalidad n ON u.idNacionalidad = n.idNacionalidad 
			INNER JOIN genero g on u.idGenero = g.idGenero 
			INNER JOIN sucursal s on u.idSucursal = s.idsucursal 
			INNER JOIN estadocivil e on u.idEstadoCivil = e.idEstado 
			WHERE u.idUsuario = $this->intIdUsuario and u.idRol = 7";*/
			$sql= "CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'R',$this->intIdUsuario)";
			$request = $this->select($sql);
			/*dep(($request));
			exit;*/
			return $request;
		}

	public function updateCliente(int $idUsuario, string $nombre, string $apellido,  string $email, string $password,  int $intTipoId, int $status, int $telefono, int $user)
	{

		$this->intIdUsuario = $idUsuario;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $intTipoId;
		$this->intStatus = $status;
		$this->intTelefono = $telefono;
		$this->intUser = $user;
		/*dep($intTipoId);
		exit;*/
		$sql = "SELECT * FROM TBL_PERSONAS p
		LEFT JOIN tbl_cliente c on p.COD_PERSONA=c.COD_PERSONA
		WHERE p.EMAIL = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario";
		//$sql= "SELECT * FROM TBL_CLIENTE WHERE (email = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario";
		//$sql="CALL CRUD_CLIENTE(?,?,?,?,?,?,?,null,?,'U',$this->intIdUsuario)";
		$request = $this->select_all($sql);

		if (empty($request)) {	//Si la contraseña es diferente a vaacio se actualiza la contraseña
			if ($this->strPassword  != "") {
				/*$sql = "UPDATE TBL_CLIENTE SET dni=?,nombres=?,apellidos=?,email=?,contraseña=?,status=?,idNacionalidad=?,idGenero=?,idEstadoCivil=?,fechaNacimiento=?,idSucursal=?,telefono=?,datemodificado=?
							WHERE idUsuario = $this->intIdUsuario ";*/
				
				$sql="CALL CRUD_CLIENTE(?,?,?,?,?,?,?,null,?,'U',$this->intIdUsuario)";
				$arrData = array(
					$this->strNombre,
					$this->strApellido,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->intStatus,
					$this->intTelefono,
					$this->intUser
				);
				
			} else {
				$sql="CALL CRUD_CLIENTE(?,?,?,null,?,?,?,null,?,'S',$this->intIdUsuario)";
				/*$sql = "UPDATE cliente SET nombres=?,apellidos=?,email=?,status=?,telefono=?,datemodificado=?
				WHERE idUsuario = $this->intIdUsuario ";*/
				$arrData = array($this->strNombre,
								$this->strApellido,
								$this->strEmail,
								//$this->strPassword,
								$this->intTipoId,
								$this->intStatus,
								$this->intTelefono,
							    $this->intUser 
							);
			}
			
			$request = $this->update($sql, $arrData);
			
		} else {
			$request = false;
			
		}
		
		return $request;
		
	}

	public function deleteCliente(int $intIdUser)
	{
		$this->intIdUsuario = $intIdUser;
		//$sql = "UPDATE usuarios SET status = ? WHERE idUsuario = $intIdUser";
        $sql="CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'D',?)";
		$arrData = array($this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}



    }
?>