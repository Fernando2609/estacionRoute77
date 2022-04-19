<?php  
    //Fernadno 23/10/2021
    class CalendarioModel extends Mysql{
        public function __construct()
        {
           parent::__construct();
        }

        public function insertEvento(int $idUsuario,string $title, string $descripcion, string $start,string $end,string $color,string $Textcolor ){
			$this->intIdUsuario = $idUsuario;
			$this->strtitle = $title;
			$this->strdescripcion = $descripcion;
			$this->strstart = $start;
            $this->strend = $end;
			$this->strcolor = $color;
			$this->strTextcolor = $Textcolor;
			
			

			$return = 0;

			/* $sql = "SELECT * FROM calendario WHERE 
					email = '{$this->strEmail}' or dni = '{$this->strIdentificacion}' ";
			$request = $this->select_all($sql); */
            
			if(empty($request))
			{
				//$query_insert  = "INSERT INTO calendario(idUsuario,title,descripcion,start,end,color,textColor) VALUES(?,?,?,?,?,?,?)";
				$query_insert  = "INSERT INTO tbl_calendario(COD_PERSONA,title,descripcion,start,end,color,textColor) VALUES(?,?,?,?,?,?,?)";
	        	$arrData = array($this->intIdUsuario,
								 $this->strtitle,
                                $this->strdescripcion,
                                $this->strstart,
                                $this->strend,
								$this->strcolor,
								$this->strTextcolor);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = false;
			}
	        return $return;
		}
        public function selectCalendario(int $idUsuario)
		{
			//Sumarle un dia a la fecha final
			//DATE_ADD(c.end, interval 1 day) as end
			$this->intIdUsuario = $idUsuario;
			//$sql = "SELECT  c.id, c.title,c.descripcion,c.start,c.end, c.color,c.textColor from calendario c WHERE idUsuario=$this->intIdUsuario";
			$sql = "SELECT * FROM tbl_calendario where COD_PERSONA=$this->intIdUsuario";
					$request = $this->select_all($sql);
           
					return $request;
		}
		public function updateEvento(int $idEvento, string $title, string $descripcion, string $start,string $end,string $color,string $Textcolor ){
			$this->idEvento=$idEvento;
			$this->strtitle = $title;
			$this->strdescripcion = $descripcion;
			$this->strstart = $start;
            $this->strend = $end;
			$this->strcolor = $color;
			$this->strTextcolor = $Textcolor;
			
			

			$return = 0;

			/* $sql = "SELECT * FROM calendario WHERE 
					email = '{$this->strEmail}' or dni = '{$this->strIdentificacion}' ";
			$request = $this->select_all($sql); */
			//date_sub(?, interval 1 day)
            
			if(empty($request))
			{
				$sql = "UPDATE tbl_calendario SET title=?,descripcion=?,start=?,end=?,color=?,textColor=?,dateModificado=? where COD_CALENDARIO=$this->idEvento";
	        	$arrData = array($this->strtitle,
                                $this->strdescripcion,
                                $this->strstart,
                                $this->strend,
								$this->strcolor,
								$this->strTextcolor,NOW());
				$request = $this->update($sql,$arrData);
	        	
			}else{
				$return = false;
			}
	        return $request;
		}
		public function delEvento(int $idEvento){
			$this->idEvento=$idEvento;
	
			

			$return = 0;

			/* $sql = "SELECT * FROM calendario WHERE 
					email = '{$this->strEmail}' or dni = '{$this->strIdentificacion}' ";
			$request = $this->select_all($sql); */
            
			if(empty($request))
			{
				$sql = "DELETE FROM tbl_calendario where COD_CALENDARIO=$this->idEvento";
	        
				$request = $this->delete($sql);
	        	
			}else{
				$return = false;
			}
	        return $request;
		}
    }

?>