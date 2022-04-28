<?php 

class ContactosModel extends Mysql{

	public function selectContactos()
	{
		$sql = "SELECT COD_CONTACTO, NOMBRE, EMAIL, DATE_FORMAT(FECHA_CREACION, '%d/%m/%Y') as fecha,MENSAJE
				FROM TBL_CONTACTO ORDER BY COD_CONTACTO DESC";
		$request = $this->select_all($sql);
		return $request;
	}
    public function selectMensaje(int $idMensaje)
    {
       
		$sql = "SELECT COD_CONTACTO, NOMBRE, EMAIL, DATE_FORMAT(FECHA_CREACION, '%d/%m/%Y') as fecha,MENSAJE
        FROM TBL_CONTACTO WHERE COD_CONTACTO=$idMensaje";
        $request = $this->select($sql);
        return $request;
    }

}
 ?>