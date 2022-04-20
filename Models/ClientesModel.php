<?php  
    
    class ClientesModel extends Mysql{  

		
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

			
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$this->intTelefono = $telefono;
			$this->intuser = $user;
            

			$return = 0;

			
			$sql= " CALL CRUD_CLIENTE(null,null,'{$this->strEmail}',null,null,null,null,null,null,'A',null)";
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
			
			
            $sql = "CALL CRUD_CLIENTE(null,null,null,null,null,null,null,NULL,NULL,'V',null)";
			
			    $request = $this->select_all($sql);
				return $request;
		}
        
        
        
		 public function selectCliente(int $idUsuario){
			$this->intIdUsuario = $idUsuario;

			$sql= "CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'R',$this->intIdUsuario)";
			$request = $this->select($sql);
			
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
		
		//validación update
		 /* $sql = "SELECT * FROM TBL_PERSONAS p
		LEFT JOIN TBL_CLIENTE c on p.COD_PERSONA=c.COD_PERSONA
		WHERE p.EMAIL = '{$this->strEmail}' AND p.COD_PERSONA !=$this->intIdUsuario";  */
		$sql="CALL CRUD_CLIENTE(null,null,'{$this->strEmail}',null,null,null,null,null,null,'B',$this->intIdUsuario)";
		/* dep($sql);
		exit;  */
		$request = $this->select_all($sql);

		if (empty($request)) {	//Si la contraseña es diferente a vaacio se actualiza la contraseña
			if ($this->strPassword  != "") {
				
				
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
		
        $sql="CALL CRUD_CLIENTE(null,null,null,null,null,null,null,null,null,'D',?)";
		$arrData = array($this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}



    }
?>