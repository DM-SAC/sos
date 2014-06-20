<?php

class entidadModel extends Model
{
	public function __construct() {
		parent::__construct();
	}

	public function getDepartamentos(){
		$sql="SELECT Department,NameUbigeo FROM ubigeo WHERE Department<>'0' AND Province='0'";
		$result = $this->_db->query($sql);
		return $result;
	}

	public function getProvincias($departamento){
		$sql="SELECT Province,NameUbigeo FROM ubigeo WHERE Department='$departamento' AND Province<>'0' AND District='0'";
		$result = $this->_db->query($sql);
		return $result;
	}
	public function getDistritos($departamento, $provincia){
		$sql="SELECT District,NameUbigeo FROM ubigeo WHERE Department='$departamento' AND Province='$provincia' AND District<>'0'";
		$result = $this->_db->query($sql);
		return $result;
	}
	#SELECT Department, nombre FROM entidad WHERE departamento<>'0' AND Province='0'; 
	#SELECT departamento, provincia, nombre FROM entidad WHERE provincia<>'0' AND District='0' AND departamento='15';
	#SELECT departamento, provincia, nombre FROM entidad WHERE provincia='05' AND District<>'0' AND departamento='15';

	public function getDepartamento($id){
		$sql="SELECT NameUbigeo FROM ubigeo WHERE Department='$id' AND Province='0'";
		$result = $this->_db->query($sql);
		return $result;
	}

	public function getUbigeo($de,$pr,$di){
		$sql = "SELECT * FROM ubigeo WHERE Department='$de' AND Province='$pr' AND District='$di'";
		$result = $this->_db->query($sql);
		if ($result->num_rows) 
            $datos = $result->fetch_object();
        else 
            $datos= false;
        return $datos;
    }
	
}

?>