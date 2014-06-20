<?php 
class usuarioModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function grabar($datos){
		
		$sql = "SELECT idUser FROM user WHERE idUser ='$datos[idUser]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'INSERT INTO user SET ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1); 
			$this->_db->query($sql);
		}
		else {
			$sql = 'UPDATE user SET ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);
			$sql.="WHERE idUser='$datos[idUser]'";
			$this->_db->query($sql);
		}
		
		return;
	}

	public function getUsuarios($pagina=1){
		$sql = 'SELECT * FROM user';
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	public function existEmail($email){
		$sql ="SELECT Email FROM user WHERE Email='$email'";
		$result=$this->_db->query($sql);
		if ($result->num_rows)  return true;
		return false;
	} 
	public function getPassword($id,$pass){
		$sql = "SELECT * FROM user WHERE idUser='$id' AND Password='$pass'";
		$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();
		}
		else{
			$datos = false;
		}
		return $datos;
	}

	public function cambiarPassword($id,$pass){
		$sql = "UPDATE user SET Password='$pass' WHERE idUser='$id'";
		$result = $this->_db->query($sql);
		return $result;
	}

	public function getUsuario($idusuario){

		$sql = "SELECT * FROM user u
				INNER JOIN ubigeo ub ON(u.ubigeo_idUbigeo=ub.idUbigeo)
		        INNER JOIN role r ON(u.role_idRole=r.idRole)
		        INNER JOIN usertype ut ON(u.usertype_idUserType=ut.idUserType)
				WHERE idUser='$idusuario'";

		$result=$this->_db->query($sql);
		if ($result->num_rows) {
			$datos = $result->fetch_object();

				$Department=$datos->Department;
				if ($Department=='0') {
					$datos->Province='TODOS';
					$datos->District='TODOS';
					$datos->Department='TODOS';
				}else{
					$sql2="SELECT NameUbigeo FROM ubigeo  WHERE Department='$Department' AND Province='0'";
					$result2 = $this->_db->query($sql2);
					$NombreDepartamento=$result2->fetch_object();
					$datos->Department=$NombreDepartamento->NameUbigeo;

					$Province=$datos->Province;
					if ($Province=='0') {
						$datos->Province='TODOS';
						$datos->District='TODOS';
					}else{
						$sql3="SELECT NameUbigeo FROM ubigeo  WHERE Department='$Department' AND Province='$Province' AND District='0'";
						$result3 = $this->_db->query($sql3);
						$NombreProvincia=$result3->fetch_object();
						$datos->Province=$NombreProvincia->NameUbigeo;

						$District=$datos->District;
						if ($District=='0') {
							$datos->District='TODOS';
						}else{
							$sql4="SELECT NameUbigeo FROM ubigeo  WHERE Department='$Department' AND Province='$Province' AND District='$District'";
							$result4 = $this->_db->query($sql4);
							$NombreDistrito=$result4->fetch_object();
							$datos->District=$NombreDistrito->NameUbigeo;
						}
					}
				}

		}
		else{
			$datos = false;
		}

		return $datos;
	}

	public function borrar($idusuario){
		
		$sql = "UPDATE user SET State='0' WHERE idUser='$idusuario'";
		$this->_db->query($sql);
	
	}
	public function getRol($Role){
		$sql = "SELECT * FROM role WHERE idRole='$Role'";
		$result = $this->_db->paginar($sql);
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

	public function getAdministradores($pagina=1,$tipo, $ubigeo){

		if ($ubigeo=='2054') {
			$sql = "SELECT * FROM user WHERE Role_idRole='2' AND UserType_idUserType='$tipo'";
		}else {
			$sql = "SELECT * FROM user WHERE Role_idRole='2' AND UserType_idUserType='$tipo' AND Ubigeo_idUbigeo='$ubigeo'";
		}

		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}

	public function getSupervisores($pagina=1, $tipo, $ubigeo){
		if ($ubigeo=='2054') {
			$sql = "SELECT * FROM user WHERE Role_idRole='3' AND UserType_idUserType='$tipo'";
		}else{
			$sql = "SELECT * FROM user WHERE Role_idRole='3' AND UserType_idUserType='$tipo' AND Ubigeo_idUbigeo='$ubigeo'";
		}
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
//  ------------------- BOMBEROS --------------------------------

	// public function getBomberos($pagina=1){
	// 	$sql = "SELECT * FROM user WHERE UserType_idUserType='2'";
	// 	$result = $this->_db->paginar($sql,$pagina);
	// 	return $result;
	// }
	



	// 	public function getUnidadesBomberos(){
	// 	$sql = "SELECT * FROM AppUNit WHERE CodeUnit='BVP'";
	// 	$result = $this->_db->query($sql);
	// 	return $result;
	// }

}

?>