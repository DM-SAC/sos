<?php 
class unidadModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getUnidad($idunidad){
		$sql = "SELECT * FROM appunit where idAppUnit='$idunidad'";
		$result = $this->_db->query($sql);
		
		if ($result->num_rows) $datos = $result->fetch_object();
		else 
			$datos= false;
		return $datos;
	}

	public function getUnidades($tipo,$ubigeo,$pagina=1){
		if ($ubigeo=='0') {
			$sql = "SELECT * FROM appunit WHERE usertype_idUserType='$tipo'";
		}else{

		$sql = "SELECT * FROM appunit WHERE usertype_idUserType='$tipo' AND ubigeo_idUbigeo='$ubigeo'";
		}
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	
	public function bloquear($idunidad){
		
		$sql = "UPDATE appunit SET StateUnit='0' WHERE idAppUnit='$idunidad'";
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
		$sql ="SELECT idAppUnit FROM appunit WHERE idAppUnit='$idAppUnit'";
		$result=$this->_db->query($sql);
		if ($result->num_rows)  return true;
		return false;
	} 
	
	
	public function grabarUnidad($datos){
		
		$sql = "SELECT idAppUnit FROM appunit WHERE idAppUnit ='$datos[idAppUnit]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'INSERT into appunit set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);
			$this->_db->query($sql);
		}
		else {
			$sql = 'UPDATE appunit set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);
			$sql.="where idAppUnit='$datos[idAppUnit]'";
			$this->_db->query($sql);
		}
		
		return;
	}
	
	
	

}

?>