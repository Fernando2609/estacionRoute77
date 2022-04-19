<?php
require_once("Libraries/Core/Mysql.php");
trait Tproducto{
    private $con;
    private $strCategoria;
    private $intIdCategoria;
    private $intIdProducto;
    private $strProducto;
    private $cant;
    private $option;
    private $strRuta;
    private $strRutaCategoria;
   
    public function getProductosT(){
        $this->con = new Mysql();
       /*  $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.stock,
                        p.ruta 
                FROM producto p 
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 /* and p.stock>0 ORDER BY p.idproducto DESC  "; */
                $sql="CALL CRUD_TPRODUCTO(null,null,null,null,'V',null)";
                $request = $this->con->select_all($sql);
              
                if(count($request) > 0){
                    for ($c=0; $c < count($request) ; $c++) { 
                        $intIdProducto = $request[$c]['COD_PRODUCTO'];
                        /* $sqlImg = "SELECT IMG
                                FROM tbl_img_producto
                                WHERE COD_PRODUCTO = $intIdProducto"; */
                        $sqlImg =  "CALL CRUD_TPRODUCTO(null,null,null,null,'H',$intIdProducto)";    
                        $arrImg = $this->con->select_all($sqlImg);
                        if(count($arrImg) > 0){
                            for($i=0; $i < count($arrImg); $i++){
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['IMG'];
                            }
                        }
                        $request[$c]['images'] = $arrImg;
                    }
                }
                
        return $request;
    }
    public function getProductosPage($desde,$porpagina){
        $this->con = new Mysql();
    
              $sql="CALL CRUD_TPRODUCTO($desde,null,$porpagina,null,'F',null)";
                $request = $this->con->select_all($sql);
              
                if(count($request) > 0){
                    for ($c=0; $c < count($request) ; $c++) { 
                        $intIdProducto = $request[$c]['COD_PRODUCTO'];
                        $sqlImg = "SELECT IMG
                                FROM tbl_img_producto
                                WHERE COD_PRODUCTO = $intIdProducto";
                        $arrImg = $this->con->select_all($sqlImg);
                        if(count($arrImg) > 0){
                            for($i=0; $i < count($arrImg); $i++){
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['IMG'];
                            }
                        }
                        $request[$c]['images'] = $arrImg;
                    }
                }
                
        return $request;
    }

    public function getProductosCategoriaT(int $idcategoria, string $ruta, $desde = null, $porpagina = null){
		$this->intIdcategoria = $idcategoria;
		$this->strRuta = $ruta;
        $where = "";
		if(is_numeric($desde) AND is_numeric($porpagina)){
			$where = " LIMIT ".$desde.",".$porpagina;
		}
        $this->con = new Mysql();

        $sql_cat="CALL CRUD_TPRODUCTO(null,null,null,null,'G','{$this->intIdcategoria}')";
        //$sql_cat = "SELECT COD_CATEGORIA, NOMBRE FROM tbl_CATEGORIA WHERE COD_CATEGORIA = '{$this->intIdcategoria}'";
        /* $sql_cat = "SELECT COD_CATEGORIA, NOMBRE, RUTA FROM tbl_CATEGORIA WHERE COD_CATEGORIA = '{$this->intIdcategoria}'"; */

        $request = $this->con->select($sql_cat);
           // $sql="CALL CRUD_TPRODUCTO({$this->intIdcategoria},'{$this->strRuta}',null,null,'C',null)";
           // $request = $this->con->select_all($sql);

        if(!empty($request)){
            $this->strCategoria = $request['NOMBRE'];
        
           $this->strRutaCategoria = $request['RUTA'];
           $sql = "SELECT p.COD_PRODUCTO,
                           p.COD_BARRA,
                           p.NOMBRE,
                           p.DESCRIPCION,
                           p.COD_CATEGORIA,
                           c.NOMBRE as categoria,
                           p.PRECIO,
                           p.RUTA
                        
                   FROM tbl_productos p 
                   INNER JOIN tbl_categoria c
                   ON p.COD_CATEGORIA = c.COD_CATEGORIA
                   WHERE p.COD_STATUS != 0 AND p.COD_CATEGORIA = $this->intIdcategoria AND c.RUTA = '{$this->strRuta}'
                   ORDER BY p.COD_PRODUCTO DESC ".$where;
                   $request = $this->con->select_all($sql);
            if(count($request) > 0){
                
                for ($c=0; $c < count($request) ; $c++) { 
                    $intIdProducto = $request[$c]['COD_PRODUCTO'];
                    $sqlImg = "CALL CRUD_TPRODUCTO(null,null,null,null,'H',$intIdProducto)"; 
                    /* $sqlImg = "SELECT IMG
                            FROM tbl_img_producto
                            WHERE COD_PRODUCTO = $intIdProducto"; */
                    $arrImg = $this->con->select_all($sqlImg);
                    if(count($arrImg) > 0){
                        for($i=0; $i < count($arrImg); $i++){
                            $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['IMG'];
                        }
                    }
                    $request[$c]['images'] = $arrImg;
                }
            }
          
            $request = array('idcategoria' => $this->intIdcategoria,
								'ruta' => $this->strRutaCategoria,
								'categoria' => $this->strCategoria,
								'productos' => $request
							);
        }
      
        return $request;
    }

   /*  
            $sql="CALL CRUD_TPRODUCTO({$this->intIdcategoria},'{$this->strRuta}',$desde,null,'C',null)";
            $request = $this->con->select_all($sql);
         
 */




    public function getProductoT(int $idProducto,string $ruta)
    {
        $this->con = new Mysql();
        $this->intIdProducto=$idProducto;
        $this->strRuta=$ruta;
      
       /*  $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        c.ruta as ruta_categoria,
                        p.stock 
                FROM producto p 
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 AND p.idproducto = '{$this->intIdProducto}'AND p.ruta = '{$this->strRuta}' "; */
        $sql="CALL CRUD_TPRODUCTO(null,'{$this->strRuta}',null,null,'P',{$this->intIdProducto})";
        $request = $this->con->select($sql);
         if (!empty($request)) {
                 $intIdProducto = $request['COD_PRODUCTO'];
                 $sqlImg =  "CALL CRUD_TPRODUCTO(null,null,null,null,'H',$intIdProducto)"; 
                 /* $sqlImg = "SELECT IMG
                                 FROM TBL_IMG_PRODUCTO
                                 WHERE COD_PRODUCTO = $intIdProducto"; */
                 $arrImg = $this->con->select_all($sqlImg);
                 if (count($arrImg) > 0) {
                     for ($i = 0; $i < count($arrImg); $i++) {
                         $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['IMG'];
                     }
                 }else{
                    $arrImg[0]['url_image'] = media().'/images/uploads/product.png';
                }
                 $request['images'] = $arrImg;
         }
        return $request;
    }
    public function getProductosRandom(int $idcategoria, int $cant, string $option){
        $this->intIdCategoria =$idcategoria;
        $this->cant = $cant;
        $this->option = $option;

        if ($option == "r") {
            $this->option = " RAND() ";
        }else if
        ($option == "a"){
            $this->option = "COD_PRODUCTO ASC ";
        }else{
            $this->option = "COD_PRODUCTO DESC ";
        }

        $this->con = new Mysql();
           

            $sql="CALL CRUD_PRODUCTOSTIENDA($this->intIdCategoria, $this->cant, '$option', 'V')";
            /* $sql=" SELECT p.COD_PRODUCTO,
                    p.COD_BARRA,
                    p.NOMBRE,
                    p.DESCRIPCION,
                    p.COD_CATEGORIA,
                    c.NOMBRE as CATEGORIA,
                    p.PRECIO,
                    i.STOCK,
                    p.RUTA
                        FROM tbl_productos p 
                        INNER JOIN tbl_categoria c ON p.COD_CATEGORIA = c.COD_CATEGORIA
                        INNER JOIN tbl_inventario i ON p.COD_PRODUCTO = i.COD_PRODUCTO
                        WHERE p.COD_STATUS != 0  AND p.COD_CATEGORIA = $this->intIdCategoria
                        ORDER BY $this->option LIMIT $this->cant"; */

            $sql="CALL CRUD_PRODUCTOSTIENDA($this->intIdCategoria, $this->cant, '$option', 'V')";
           

            $request = $this->con->select_all($sql);
            
            if (count($request) > 0) {
                for ($c = 0; $c < count($request); $c++) {
                    $intIdProducto = $request[$c]['COD_PRODUCTO'];
                    $sqlImg =  "CALL CRUD_TPRODUCTO(null,null,null,null,'H',$intIdProducto)"; 
                    /* $sqlImg = "SELECT IMG
                            FROM TBL_IMG_PRODUCTO
                            WHERE COD_PRODUCTO = $intIdProducto"; */
                    $arrImg = $this->con->select_all($sqlImg);
                    if (count($arrImg) > 0) {
                        for ($i = 0; $i < count($arrImg); $i++) {
                            $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['IMG'];
                        }
                    }
                    $request[$c]['images'] = $arrImg;
                }
            }
        

        return $request;



    }

    public function getProductoIDT(int $idProducto)
    {
        $this->con = new Mysql();
        $this->intIdProducto=$idProducto;
        
        /* $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.ruta,
                        p.stock 
                FROM producto p 
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 AND p.idproducto = '{$this->intIdProducto}'"; */
        $sql="CALL CRUD_TPRODUCTO(null,null,null,null,'D',{$this->intIdProducto})";
        $request = $this->con->select($sql);
         if (!empty($request)) {
                 $intIdProducto = $request['COD_PRODUCTO'];
                 $sqlImg =  "CALL CRUD_TPRODUCTO(null,null,null,null,'H',$intIdProducto)"; 
                 /* $sqlImg = "SELECT IMG
                                 FROM TBL_IMG_PRODUCTO
                                 WHERE COD_PRODUCTO = $intIdProducto"; */
                 $arrImg = $this->con->select_all($sqlImg);
                 if (count($arrImg) > 0) {
                     for ($i = 0; $i < count($arrImg); $i++) {
                         $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['IMG'];
                     }
                 }else{
                    $arrImg[0]['url_image'] = media().'/images/uploads/product.png';
                }
                 $request['images'] = $arrImg;
         }
        return $request;
    }
    public function  cantProductos($categoria= null) {
        $where = "";
		if($categoria != null){
            $where = "AND COD_CATEGORIA = ".$categoria;
        }
         
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM tbl_productos WHERE COD_STATUS = 1 ".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;

    }
     
	public function cantProdSearch($busqueda){
		$this->con = new Mysql();
		$sql = "SELECT COUNT(*) as total_registro FROM tbl_productos WHERE NOMBRE LIKE '%$busqueda%' AND COD_STATUS = 1 ";
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;
	} 


	public function getProdSearch($busqueda, $desde, $porpagina){
		$this->con = new Mysql();
		 $sql = "SELECT p.COD_PRODUCTO,
						p.COD_BARRA,
						p.NOMBRE,
						p.DESCRIPCION,
						p.COD_CATEGORIA,
						c.NOMBRE as categoria,
						p.PRECIO,
						p.RUTA
					
				FROM tbl_productos p 
				INNER JOIN tbl_categoria c
				ON p.COD_CATEGORIA = c.COD_CATEGORIA
				WHERE p.COD_STATUS = 1 AND p.NOMBRE LIKE '%$busqueda%' ORDER BY p.COD_PRODUCTO DESC LIMIT $desde,$porpagina";
			
            $request = $this->con->select_all($sql);

                 
                if (count($request) > 0) {
                    for ($c = 0; $c < count($request); $c++) {
                        $intIdProducto = $request[$c]['COD_PRODUCTO'];
                        $sqlImg = "SELECT IMG
                                FROM TBL_IMG_PRODUCTO
                                WHERE COD_PRODUCTO = $intIdProducto";
                        $arrImg = $this->con->select_all($sqlImg);
                        if (count($arrImg) > 0) {
                            for ($i = 0; $i < count($arrImg); $i++) {
                                $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['IMG'];
                            }
                        }
                        $request[$c]['images'] = $arrImg;
                    }
                }
		return $request;
	}
}


?>
 