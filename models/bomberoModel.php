<?php 
class bomberoModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getBomberos($pagina=1){
		$sql = "SELECT * FROM User WHERE UserType_idUserType='2'";
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	
	public function getPaginacion()
	{
		if($this->_db->_paginacion){
			return $this->_db->_paginacion;
		} else {
			return false;
		}
	}
	// ADMINISTRADORES

	public function getAdministradores($pagina=1){
		$sql = "SELECT * FROM User WHERE Role_idRole='2' AND UserType_idUserType='2'";
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}

	// SUPERVISORES

	public function getSupervisores($pagina=1){
		$sql = "SELECT * FROM User WHERE Role_idRole='3' AND UserType_idUserType='2'";
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	// UNIDADES

		public function getUnidades(){
		$sql = "SELECT * FROM AppUNit WHERE CodeUnit='BVP'";
		$result = $this->_db->query($sql);
		return $result;
	}
}

?>