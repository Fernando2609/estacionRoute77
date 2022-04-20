<?php 

class SuscriptoresModel extends Mysql{

	public function selectSuscriptores()
	{
		$sql = "SELECT COD_SUSCRIPCION, NOMBRE, EMAIL, DATE_FORMAT(FECHA_CREACION, '%d/%m/%Y') as fecha
				FROM TBL_SUSCRIPCIONES ORDER BY COD_SUSCRIPCION DESC";
		$request = $this->select_all($sql);
		return $request;
	}

}
 ?>