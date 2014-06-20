<?php

class Database extends mysqli
{
    public function __construct() {
    	parent::__construct(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    	            
    }
    public function paginar($query, $pagina = false, $limite = false)
	{
		if(!($limite && is_numeric($limite))){
			$limite = LIMIT_REGXPAG;
		}

		if ($pagina && is_numeric($pagina)){
			$inicio = ($pagina - 1) * $limite;
		} else {
			$pagina = 1;
			$inicio = 0;
		}

		$result = $this->query($query);
		$registros =  $result->num_rows;

		$total = ceil($registros / $limite);
		
		if ($pagina>$total) $pagina=$total;
		
		if ($pagina && is_numeric($pagina)){
			$inicio = ($pagina - 1) * $limite;
		} else {
			$pagina = 1;
			$inicio = 0;
		}

		$query = $query . " LIMIT $inicio, $limite";
		$result = $this->query($query);

		$this->_paginacion['actual'] = $pagina;
		$this->_paginacion['total'] = $total;

		if($pagina > 1){
			$this->_paginacion['primero'] = 1;
			$this->_paginacion['anterior'] = $pagina - 1;
		} else {
			$this->_paginacion['primero'] = '';
			$this->_paginacion['anterior'] = '';
		}

		if($pagina < $total){
			$this->_paginacion['ultimo'] = $total;
			$this->_paginacion['siguiente'] = $pagina + 1;
		} else {
			$this->_paginacion['ultimo'] = '';
			$this->_paginacion['siguiente'] = '';
		}


		$total_paginas = $this->_paginacion['total'];
		$pagina_seleccionada = $this->_paginacion['actual'];
		$rango = ceil(LIMIT_PAGEVIEW / 2);

		if($pagina_seleccionada < $rango){
			$rango_derecho = LIMIT_PAGEVIEW;
		} else {
			$rango_derecho = $pagina_seleccionada + $rango;
		}

		if ($total_paginas<LIMIT_PAGEVIEW) $rango_derecho = $total_paginas;

		$rango_izquierdo = $pagina_seleccionada - ($rango-1);

		if ($rango_izquierdo<=0) $rango_izquierdo=1;

		$paginas = range($rango_izquierdo,$rango_derecho);

		$this->_paginacion['rango'] = $paginas;

		return $result;
	}
}

?>