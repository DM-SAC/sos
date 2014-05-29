<?php 
class unidadModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getUnidad($idunidad){
		$sql = "select * from unidades where IDUNIDAD='$idunidad'";
		$result = $this->_db->query($sql);
		
		if ($result->num_rows) $datos = $result->fetch_object();
		else 
			$datos= false;
		return $datos;
	}

	public function getUnidades($pagina=1){
		$sql = 'select * from unidades';
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	
	public function borrarUnidad($idunidad){
		
		$sql = "delete FROM unidades where IDUNIDAD='$idunidad'";
		$this->_db->query($sql);
	
	}
		
	public function getPaginacion()
	{
		if($this->_db->_paginacion){
			return $this->_db->_paginacion;
		} else {
			return false;
		}
	}
	
	public function existUnidad($idunidad){
		$sql ="select IDUNIDAD from unidades where IDUNIDAD='$idunidad'";
		$result=$this->_db->query($sql);
		if ($result->num_rows)  return true;
		return false;
	} 
	
	
	public function grabarUnidad($datos){
		
		$sql = "SELECT IDUNIDAD FROM unidades WHERE IDUNIDAD ='$datos[IDUNIDAD]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'insert into unidades set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
				
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$this->_db->query($sql);
		}
		else {
			$sql = 'update unidades set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$sql.="where IDUNIDAD='$datos[IDUNIDAD]'";
			$this->_db->query($sql);
		}
		
		return;
	}
	
	
	

}

?>