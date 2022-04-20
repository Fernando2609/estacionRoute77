<?php
class TelEmpresaModel extends Mysql{  

		private $intIdUsuario;
		private $intTelefono;
		
        public function __construct()
        {
           parent::__construct();
        } 
		
		public function inserttelEmpresa(int $telEmpresa){
			$this->intTelefono = $telEmpresa;
			$return = 0;
            //VALIDAR
		    /*  $sql = "SELECT * from TBL_TELEFONO_EMPRESA where TELEFONO=$this->intTelefono"; */
			$sql= "CALL CRUD_TELEFONO_EMPRESA(null,$this->intTelefono,'A',null)";
			 $request = $this->select_all($sql); 

			if(empty($request))
			{
				
				$query_insert= " CALL CRUD_TELEFONO_EMPRESA(1,?,'I',null)";
				$arrData = array($this->intTelefono);
		
	        	$request_insert = $this->insert($query_insert,$arrData);
				$sql = "SELECT last_insert_id()";
				$request_ID = $this->select($sql);
	        	$return = $request_ID['last_insert_id()'];
				
			}else{
				$return = false;
			}
	        return $return;
		}

	public function selecttelEmpresas()
	{

		$sql = "CALL CRUD_TELEFONO_EMPRESA(1,null,'V',null)";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selecttelEmpresa(int $idUsuario)
	{
		$this->intIdUsuario = $idUsuario;

		$sql = "CALL CRUD_TELEFONO_EMPRESA(1,null,'R',$this->intIdUsuario)";

		$request = $this->select($sql);

		return $request;
	}

	public function updatetelEmpresa(int $idUsuario, int $telEmpresa)
	{

		$this->intIdUsuario = $idUsuario;
		$this->intTelefono = $telEmpresa;
		
		//VALIDAR

		/*  $sql = "SELECT * from TBL_TELEFONO_EMPRESA where TELEFONO =$this->intTelefono and COD_TELEFONO_EMPRESA!=$this->intIdUsuario";
		 */
		$sql = "CALL CRUD_TELEFONO_EMPRESA(null,$this->intTelefono,'B',$this->intIdUsuario)";
		/* dep($sql);
		exit; */
		$request = $this->select_all($sql);
 
		if (empty($request)) {	//Si la contraseña es diferente a vaacio se actualiza la contraseña
		
				/*$sql = "UPDATE TBL_CLIENTE SET dni=?,nombres=?,apellidos=?,email=?,contraseña=?,status=?,idNacionalidad=?,idGenero=?,idEstadoCivil=?,fechaNacimiento=?,idSucursal=?,telefono=?,datemodificado=?
							WHERE idUsuario = $this->intIdUsuario ";*/

				$sql = "CALL CRUD_TELEFONO_EMPRESA(1,?,'U',$this->intIdUsuario)";
				$arrData = array(
					
					$this->intTelefono,
					
				);

			$request = $this->update($sql, $arrData);
		} else {
			$request = false;
		}

		return $request;
	}

	public function deletetelEmpresa(int $intIdUser)
	{
		$this->intIdUsuario = $intIdUser;
		/* $sql = "UPDATE usuarios SET status = ? WHERE idUsuario = $intIdUser"; */
		$sql = "CALL CRUD_TELEFONO_EMPRESA(1,null,'D',?)";
		$arrData = array($this->intIdUsuario);
		$request = $this->update($sql, $arrData);
		return $request;
	}

    }
?>