<?php 
class alertaModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function grabarAlerta($datos){
		
		$sql = "SELECT idAlert FROM alert WHERE idAlert ='$datos[idAlert]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'insert into alert set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);
			$this->_db->query($sql);
		}
		else {
			$sql = 'update alert set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);
			$sql.="WHERE idAlert='$datos[idAlert]'";
			$this->_db->query($sql);
		}
		return;
	}

	public function getAlerta($idAlerta){

		$sql = "SELECT * FROM alert a 
				INNER JOIN appuser au ON(a.appuser_idAppUser=au.idAppUser)
		        INNER JOIN alerttype at ON(a.alerttype_idAlertType=at.idAlertType)
		        INNER JOIN appunit aun ON(a.appunit_idAppUnit=aun.idAppUnit)
		        INNER JOIN state s ON(a.state_idState=s.idState)
				WHERE idAlert='$idAlerta'";
		
		$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();
		}
		else{
			$datos = false;
		}

		return $datos;
	}

	public function getAlertas($buscar,$uabd,$tipo){
		$buscar==''?$buscar='%':$buscar;
		$sql = "SELECT * FROM alert a 
				INNER JOIN appuser au ON(a.appuser_idAppUser=au.idAppUser)
		        INNER JOIN alerttype at ON(a.alerttype_idAlertType=at.idAlertType)
		        INNER JOIN appunit aun ON(a.appunit_idAppUnit=aun.idAppUnit)
		        INNER JOIN state s ON(a.state_idState=s.idState)
				WHERE Code='$tipo' AND State_idState<>'4' AND idAlert<='$uabd' AND PhoneNumberCaller LIKE '%$buscar%' OR PhoneNumber LIKE '%$buscar%'
				ORDER BY Date DESC
				";

		$result = $this->_db->query($sql);
		return $result;
	}

	public function getAlertasAjax($uabd,$uam,$tipo){
		$sql = "SELECT * FROM alert a 
				INNER JOIN appuser au ON(a.appuser_idAppUser=au.idAppUser)
		        INNER JOIN alerttype at ON(a.alerttype_idAlertType=at.idAlertType)
		        INNER JOIN appunit aun ON(a.appunit_idAppUnit=aun.idAppUnit)
		        INNER JOIN state s ON(a.state_idState=s.idState)
				WHERE Code='$tipo' AND State_idState<>'4' AND idAlert<='$uabd' AND idAlert>'$uam'
				ORDER BY Date DESC
				";
		
		$result = $this->_db->query($sql);
		return $result;
	}

	public function getAlertasDistrito($ubigeo,$buscar,$uabd,$tipo){
		$buscar==''?$buscar='%':$buscar;
				$sql = "SELECT * FROM alert a 
				INNER JOIN appuser au ON(a.appuser_idAppUser=au.idAppUser)
		        INNER JOIN alerttype at ON(a.alerttype_idAlertType=at.idAlertType)
		        INNER JOIN appunit aun ON(a.appunit_idAppUnit=aun.idAppUnit)
		        INNER JOIN state s ON(a.state_idState=s.idState)
				WHERE Code='$tipo' AND State_idState<>'4' AND idAlert<='$uabd' AND Ubigeo='$ubigeo' AND PhoneNumberCaller LIKE '%$buscar%'
				ORDER BY Date DESC";
		$result = $this->_db->query($sql);
		return $result;
	}

	public function getAlertasDistritoAjax($uabd,$uam,$tipo,$ubigeo){
		$sql = "SELECT * FROM alert a 
				INNER JOIN appuser au ON(a.appuser_idAppUser=au.idAppUser)
		        INNER JOIN alerttype at ON(a.alerttype_idAlertType=at.idAlertType)
		        INNER JOIN appunit aun ON(a.appunit_idAppUnit=aun.idAppUnit)
		        INNER JOIN state s ON(a.state_idState=s.idState)
				WHERE Code='$tipo' AND State_idState<>'4' AND Ubigeo='$ubigeo' AND idAlert<='$uabd' AND idAlert>'$uam'
				ORDER BY Date DESC
				";
		$result = $this->_db->query($sql);
		return $result;
	}
	public function getNumeroAlertas($ubigeo,$tipo){
		if ($ubigeo=='0') {
		$sql="SELECT COUNT(idAlert) AS numero FROM alert WHERE CODE='$tipo'";
		}else{
			$sql="SELECT COUNT(idAlert) AS numero FROM alert WHERE CODE='$tipo' AND Ubigeo='$ubigeo'";
		}

	$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();
		}
		else{
			$datos = false;
		}

		return $datos;
	}
	public function getUltimaAlerta($tipo,$ubigeo){

		if ($ubigeo=='0') {
		$sql="SELECT idAlert FROM alert WHERE CODE='$tipo' ORDER BY idAlert DESC LIMIT 1";
		}else{

		$sql="SELECT idAlert FROM alert WHERE CODE='$tipo' AND Ubigeo='$ubigeo' ORDER BY idAlert DESC LIMIT 1";
		}

		$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();
		}
		else{
			$datos = false;
		}

		return $datos;
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