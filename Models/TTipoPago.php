<?php
require_once("Libraries/Core/Mysql.php");
  trait TTIpoPago{
      private $con;

      public function getTiposPagoT(){
		$this->con = new Mysql();
		/*$sql = "SELECT * FROM TBL_TIPO_PAGO WHERE COD_STATUS != 0";*/
		$sql = "CALL CRUD_TIPOPAGO(NULL,NULL,NULL,'A',NULL)";
		$request = $this->con->select_all($sql);
		return $request;

	}
	public function getTiposEstadoT(){
		$this->con = new Mysql();
		/*$sql = "SELECT * FROM TBL_TIPO_ESTADO ";*/
		$sql = "CALL CRUD_TIPOESTADO(NULL,'V',NULL)";
		$request = $this->con->select_all($sql);
		return $request;
		
	}

   }
?>