<?php 
class appuserModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function grabarUsuario($datos){
		
		$sql = "SELECT idAppUser FROM appuser WHERE idAppUser ='$datos[idAppUser]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'insert into appuser set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
				
			$sql= substr($sql, 0, -1);
			$this->_db->query($sql);
		}
		else {
			$sql = 'update appuser set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);	
			$sql.="WHERE idAppUser='$datos[idAppUser]'";
			$this->_db->query($sql);
		}
		
		return;
	}

	public function getAppUsuarios($pagina=1){
		$sql = "SELECT * FROM appuser WHERE idAppUser<>'1' ORDER BY idAppUser DESC" ;
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}

	public function getAppUsuario($idappuser){

		$sql = "SELECT * FROM appuser WHERE idAppUser='$idappuser'";

		$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();
		}
		else{
			$datos = false;
		}

		return $datos;
	}
	public function bloquear($idusuario){
		
		$sql = "UPDATE AppUser SET Priority='0' WHERE idAppUser='$idusuario'";
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
}

?>