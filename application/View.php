<?php

class View
{
	private $_controlador;
	private $_js;

	public function __construct(Request $peticion) {
		$this->_controlador = $peticion->getControlador();
		$this->_js = array();
	}

	public function renderizar($vista, $item = false)
	{
		
		 // $menu = array(
   //          array(
   //              'id' => 'inicio',
   //              'titulo' => 'Inicio',
   //              'enlace' => BASE_URL
   //              ),
   //      );

	    $js = array();

	    if(count($this->_js)){
	    	$js = $this->_js;
	    }

	    $_layoutParams = array(
	      'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
	      'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
	      'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
	      'js' => $js
	      // ,
	      // 'menu' => $menu
	    );

	    $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
	 
	    if(is_readable($rutaView)){
			if (!$item) {
				include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
				include_once $rutaView;
				include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
			}
			else 
				include_once $rutaView;
		}
		else {
			throw new Exception('Error de vista.');
		}

}
	/*
	 *  carga los js  especificos del controlador
	 *
	 */
public function setJsPlugin(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_jsPlugin[] = BASE_URL . 'public/js/' .  $js[$i] . '.js';
            }
        } 
        else {
            throw new Exception('Error de js plugin');
        }
    }
	public function setJs(array $js)
	{
		if(is_array($js) && count($js)){
			for($i=0; $i < count($js); $i++){
				$this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
			}
		} else {
			throw new Exception('Error de js');
		}
	}

}

?>
