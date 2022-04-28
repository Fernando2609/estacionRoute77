<?php  
    //Fernadno 23/10/2021
    class UsuariosModel extends Mysql{
		
        private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
        private $intNacionalidad;
        private $intGenero;
        private $intEstadoC;
        private $intSucursal;
        private $strFechaNacimiento;
        public function __construct()
        {
           parent::__construct();
        }
        public function insertUsuario(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status, int $genero, int $sucursal, int $user ){
		
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
          
            $this->intGenero = $genero;
         
            $this->intSucursal = $sucursal;
            $this->intUser=$user;


			$return = 0;
			

			//Validación
            $sql="CALL CRUD_USUARIO(null,null,'{$this->strEmail}',null,null,null,null,null,null,'{$this->strIdentificacion}',null,null,null,'A',null)";
			 
			$request = $this->select_all($sql);

			if(empty($request))
			{
				
				$query_insert="CALL CRUD_USUARIO(?,?,?,?,?,?,?,?,?,?,?,null,?,'I',null)";
	        	$arrData = array($this->strNombre,
									$this->strApellido,
									$this->strEmail,
									$this->strPassword,
									$this->intTipoId,
									$this->intStatus,
									$this->intTelefono,
									$this->intSucursal,
									$this->intGenero,
									$this->strIdentificacion,
									$this->intUser, NOW());
									
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
	        	$return = $request_ID['last_insert_id()'];

			}else{
				$return = false;
			}
	        return $return;
		}
        
		public function selectUsuarios()
		{
			$whereAdmin = "";
			$idUser=$_SESSION['idUser'];
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and P.COD_PERSONA !=1";
			}
		   $sql="CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,NULL,'V',$idUser)";
			
			/*  $sql="SELECT P.COD_PERSONA,U.COD_USUARIO, P.COD_ROL, R.NOM_ROL AS ROL, U.DNI, P.NOMBRES, P.APELLIDOS, P.EMAIL,ST.DESCRIPCION AS STATUS , P.TELEFONO, S.NOMBRE AS SUCURSAL, G.DESCRIPCION AS GENERO,
			P.FECHA_CREACION, P.FECHA_MODIFICACION, P.DATE_LOGIN,P.COD_STATUS
			FROM TBL_USUARIOS U
			INNER JOIN TBL_PERSONAS P ON P.COD_PERSONA=U.COD_PERSONA
			INNER JOIN TBL_SUCURSAL S ON S.COD_SUCURSAL=U.COD_SUCURSAL
			INNER JOIN TBL_GENERO G ON G.COD_GENERO=U.COD_GENERO
			INNER JOIN TBL_STATUS ST ON ST.COD_STATUS=P.COD_STATUS
			INNER JOIN TBL_ROLES R ON R.COD_ROL=P.COD_ROL WHERE P.COD_STATUS != 0 and P.COD_ROL!=2".$whereAdmin; */
			$request = $this->select_all($sql);
		
			return $request;
		}

		public function selectUsuario(int $idUsuario){
			$this->intIdUsuario = $idUsuario;
			

			$sql="CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,NULL,'R',$this->intIdUsuario)";
			
			$request = $this->select($sql);
			
			return $request;
		}
		public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status, int $genero,  int $sucursal,int $user){
			
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			
          
            $this->intGenero = $genero;
           
            $this->intSucursal = $sucursal;
			$this->intUser = $user;
           

			//Validación

			/* $sql="SELECT * FROM TBL_PERSONAS p
			LEFT JOIN TBL_USUARIOS u on p.COD_PERSONA=u.COD_PERSONA
			WHERE p.EMAIL = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario OR u.DNI = '{$this->strIdentificacion}' AND p.COD_PERSONA != $this->intIdUsuario";
 */         
            //Validación
            $sql="CALL CRUD_USUARIO(null,null,'{$this->strEmail}',null,null,null,null,null,null,'{$this->strIdentificacion}',null,null,NULL,'B',$this->intIdUsuario)";
			/* dep($sql);
			exit; */
			$request = $this->select_all($sql);

			if(empty($request))
			{	//Si la contraseña es diferente a vaacio se actualiza la contraseña
				if($this->strPassword  != "")
				{
					
					$sql="CALL CRUD_USUARIO(?,?,?,?,?,?,?,?,?,?,null,?,?,'U',$this->intIdUsuario)";
					$arrData = array(
									$this->strNombre,
									$this->strApellido,
									$this->strEmail,
									$this->strPassword,
									$this->intTipoId,
									$this->intStatus,
									$this->intTelefono,
									$this->intSucursal,
									$this->intGenero,
									$this->strIdentificacion,
									$this->intUser, NOW()
									);
							
				}else{
					
					$sql="CALL CRUD_USUARIO(?,?,?,null,?,?,?,?,?,?,null,?,?,'S',$this->intIdUsuario)";
					$arrData = array(
									$this->strNombre,
									$this->strApellido,
									$this->strEmail,
									//$this->strPassword,
									$this->intTipoId,
									$this->intStatus,
									$this->intTelefono,
									$this->intSucursal,
									$this->intGenero,
									$this->strIdentificacion,
									$this->intUser, NOW()
									);
				}
				$request = $this->update($sql,$arrData);
				
			}else{
				$request = false;
			}
			
			return $request;
		
		}
		
		public function deleteUsuario(int $intIdUser)
		{
			$this->intIdUsuario = $intIdUser;
			
			$sql="CALL CRUD_USUARIO(null,null,null,null,null,null,null,null,null,null,null,null,NULL,'D',?)";
			$arrData = array($this->intIdUsuario);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, int $genero, int $sucursal,string $password,int $user )
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			
			$this->strPassword = $password;
		
           
            $this->intGenero = $genero;
      
            $this->intSucursal = $sucursal;
			$this->intUser = $user;
			if($this->strPassword != "")
			{
				
				$sql="CALL CRUD_USUARIO(?,?,null,?,null,null,?,?,?,?,null,?,?,'P',$this->intIdUsuario)";
				$arrData = array(
								$this->strNombre,
								$this->strApellido,
								//$this->strEmail,
								$this->strPassword,
								
								$this->intTelefono,
								$this->intSucursal,
								$this->intGenero,
								$this->strIdentificacion,
								$this->intUser,NOW()
								);
			}else{
				
				$sql="CALL CRUD_USUARIO(?,?,null,null,null,null,?,?,?,?,null,?,?,'H',$this->intIdUsuario)";
				
				$arrData = array(
								$this->strNombre,
								$this->strApellido,
								//$this->strEmail,
								//$this->strPassword,
								
								$this->intTelefono,
								$this->intSucursal,
								$this->intGenero,
								$this->strIdentificacion,
								$this->intUser, NOW()
								);
								
			}
			$request = $this->update($sql,$arrData);
		    return $request;
		}
		public function updatePerfilCliente(int $idUsuario, string $nombre, string $apellido, int $telefono,string $password,int $user )
		{
			$this->intIdUsuario = $idUsuario;

			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strPassword = $password;
			$this->intUser = $user;
			if($this->strPassword != "")
			{
				
				$sql="CALL CRUD_USUARIO(?,?,null,?,null,null,?,null,null,null,null,?,'C',$this->intIdUsuario)";
				$arrData = array(
								$this->strNombre,
								$this->strApellido,
								//$this->strEmail,
								$this->strPassword,
								
								$this->intTelefono,
								$this->intUser
								);
			}else{
				
				$sql="CALL CRUD_USUARIO(?,?,null,null,null,null,?,null,null,null,null,?,?,'M',$this->intIdUsuario)";
				$arrData = array(
								$this->strNombre,
								$this->strApellido,
								//$this->strEmail,
								//$this->strPassword,
								
								$this->intTelefono,
								$this->intUser, NOW()
								);
			}
			$request = $this->update($sql,$arrData);
		    return $request;
		}
    }

?>