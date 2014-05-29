<?php 
class alertaModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function grabarAlerta($datos){
		
		$sql = "SELECT idAlert FROM Alert WHERE idAlert ='$datos[idAlert]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'insert into Alert set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
				
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$this->_db->query($sql);
		}
		else {
			$sql = 'update Alert set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$sql.="WHERE idAlert='$datos[idAlert]'";
			$this->_db->query($sql);
		}
		
		return;
	}

	// BOMBEROS

	public function getAlertaBombero($idAlerta){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
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

	public function getAlertasBomberos($pagina=1){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
				WHERE Code='BVP' AND State_idState<>'4'
				ORDER BY Date DESC
				";
		
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	public function getAlertasBomberosDistrito($distrito,$pagina=1){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
				WHERE Code='BVP' AND State_idState<>'4' AND Ubigeo='$distrito' 
				ORDER BY Date DESC
				";

		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}

	// POLICIAS

		public function getAlertaPolicia($idAlerta){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
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

	public function getAlertasPolicias($pagina=1){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
				WHERE Code='PNP' AND State_idState<>'4'
				ORDER BY Date DESC
				";
		
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	public function getAlertasPoliciasDistrito($distrito,$pagina=1){

		$sql = "SELECT * FROM Alert a 
				INNER JOIN AppUser au ON(a.AppUser_idAppUser=au.idAppUser)
		        INNER JOIN AlertType at ON(a.AlertType_idAlertType=at.idAlertType)
		        INNER JOIN AppUnit aun ON(a.AppUnit_idAppUnit=aun.idAppUnit)
		        INNER JOIN State s ON(a.State_idState=s.idState)
				WHERE Code='PNP' AND State_idState<>'4' AND Ubigeo='$distrito' 
				ORDER BY Date DESC
				";

		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	
	
	public function borrar($idUsuario){
		
		$sql = "UPDATE User SET State='0' WHERE idUser='$idUsuario'";
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

	public function getRol($Role){
		$sql = "SELECT * FROM Role WHERE idRole='$Role'";
		$result = $this->_db->paginar($sql);
		return $result;
	}

}
?>