<?php

class inicioController extends Controller
{
  public function __construct() {
    parent::__construct();
    Session::autenticado();
  }
    
  public function inicio()
  {
    $this->_view->titulo = 'SOS | Inicio';
    $this->_view->renderizar('inicio');
  }
    public function cambiar()
  {
    $this->_view->titulo = 'SOS | Inicio - Cambiar contraseña';
    $this->_view->setJs(array('jquery.validate.password'));
    $this->_view->setJs(array('password'));
    $this->_view->renderizar('password');
  }
}

?>