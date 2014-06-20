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
    $this->_view->renderizar('inicio','inicio');
  }
    public function policias()
  {
    $this->_view->titulo = 'SOS | Inicio';
    unset($_SESSION['type']);
    Session::set('type','3');
    $this->_view->renderizar('policias','policia');
  }
    public function bomberos()
  {
    $this->_view->titulo = 'SOS | Inicio';
    unset($_SESSION['type']);
    Session::set('type','2');
    $this->_view->renderizar('bomberos','bombero');
  }

}
?>