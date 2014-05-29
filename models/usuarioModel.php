<?php 
class usuarioModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function grabar($datos){
		
		$sql = "SELECT idUser FROM User WHERE idUser ='$datos[idUser]'";
		$resul = $this->_db->query($sql);
		if(!$resul->num_rows){
			$sql = 'insert into User set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
				
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$this->_db->query($sql);
		}
		else {
			$sql = 'update User set ';
			foreach ($datos as $campo => $valor)
				$sql.= "$campo ='$valor' ,";
			$sql= substr($sql, 0, -1);  #quita la ultima coma del query	
			#echo $sql;
			$sql.="WHERE idUser='$datos[idUser]'";
			$this->_db->query($sql);
		}
		
		return;
	}

	public function getUsuarios($pagina=1){
		$sql = 'SELECT * FROM User';
		$result = $this->_db->paginar($sql,$pagina);
		return $result;
	}
	
	public function getUsuario($idusuario){

		$sql = "SELECT * FROM User u
				INNER JOIN Ubigeo ub ON(u.Ubigeo_idUbigeo=ub.idUbigeo)
		        INNER JOIN Role r ON(u.Role_idRole=r.idRole)
		        INNER JOIN UserType ut ON(u.UserType_idUserType=ut.idUserType)
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
					$sql2="SELECT NameUbigeo FROM Ubigeo  WHERE Department='$Department' AND Province='0'";
					$result2 = $this->_db->query($sql2);
					$NombreDepartamento=$result2->fetch_object();
					$datos->Department=$NombreDepartamento->NameUbigeo;

					$Province=$datos->Province;
					if ($Province=='0') {
						$datos->Province='TODOS';
						$datos->District='TODOS';
					}else{
						$sql3="SELECT NameUbigeo FROM Ubigeo  WHERE Department='$Department' AND Province='$Province' AND District='0'";
						$result3 = $this->_db->query($sql3);
						$NombreProvincia=$result3->fetch_object();
						$datos->Province=$NombreProvincia->NameUbigeo;

						$District=$datos->District;
						if ($District=='0') {
							$datos->District='TODOS';
						}else{
							$sql4="SELECT NameUbigeo FROM Ubigeo  WHERE Department='$Department' AND Province='$Province' AND District='$District'";
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
		
		$sql = "UPDATE User SET State='0' WHERE idUser='$idusuario'";
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