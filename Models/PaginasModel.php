<?php 

class PaginasModel extends Mysql{
    
    private $intCodPagina;
    private $strTitulo;
    private $strContenido;
    private $intStatus;
    private $strRuta;
    private $strImagen;
    public function __construct()
    {
       parent::__construct();
       /* $this->objCategoria = new CategoriasModel(); */
    }


	public function selectPaginas()
	{
		$sql = "SELECT COD_POST, TITULO, CONTENIDO, DATE_FORMAT(FECHA_CREACION, '%d/%m/%Y') as fecha,PORTADA,RUTA,COD_STATUS
				FROM TBL_POST WHERE COD_STATUS!=0";
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
    public function updatePost(int $idPost, string $titulo, string $contenido,string $portada, int $status)
    {
        $this->intCodPagina = $idPost;
		$this->strTitulo = $titulo;
		$this->strContenido = $contenido;
		$this->strImagen = $portada;
		$this->intStatus = $status;
		$sql = "UPDATE TBL_POST SET TITULO = ?, CONTENIDO = ?, PORTADA = ?, COD_STATUS = ? WHERE COD_POST = $this->intCodPagina ";
		$arrData = array($this->strTitulo, 
						 $this->strContenido,
						 $this->strImagen, 
						 $this->intStatus);
		$request = $this->update($sql,$arrData);
	    return $request;
    }
    public function insertPost(string $titulo, string $contenido, string $portada, string $ruta, int $status){
		$this->strTitulo = $titulo;
		$this->strContenido = $contenido;
		$this->strImagen = $portada;
		$this->strRuta = $ruta;
		$this->intStatus = $status;
		$sql = "SELECT * FROM TBL_POST WHERE RUTA = '{$this->strRuta}'";
		$request = $this->select_all($sql);
		if(empty($request)){
			$query_insert  = "INSERT INTO TBL_POST(TITULO,
												CONTENIDO,
												PORTADA,
												RUTA,
												COD_STATUS,FECHA_CREACION) 
							  VALUES(?,?,?,?,?,?)";
			$arrData = array($this->strTitulo,
    						$this->strContenido,
    						$this->strImagen,
    						$this->strRuta,
    						$this->intStatus,NOW());
			$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = 0;
		}
		return $return;
	}
    public function deletePagina(int $idpagina){
		$this->intIdPagina = $idpagina;
		$sql = "UPDATE TBL_POST SET COD_STATUS = ? WHERE COD_POST = $this->intIdPagina ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}
 ?>