<?php

class usuarioController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = 'Inicio';
        $this->_view->renderizar('inicio');
    }
//------- GENERAL

    public function usuarios($pagina=1)
    {
        $this->_view->titulo = 'Usuario';
        $this->_view->setJs(array('usuario'));
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->usuarios = $this->_usuario->getUsuarios($pagina);
        $this->_view->param = $this->_usuario->getPaginacion(); 
        $this->_view->renderizar('usuario');
    }

    public function nuevo()
    {
        $this->_view->titulo = 'Ingresar Nuevo';
        $departamento='15';
        $provincia='01';
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento,$provincia);
        // $this->_view->setJs(array('nuevo'));
        $this->_view->renderizar('nuevo');
    }
     public function provincias($departamento){
        
        // $this->_view->titulo = 'Ingresar Nuevo Policía';
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->provincias = $this->_entidad->getProvincias($departamento);
        $this->_view->renderizar('ajax_provincias',true);
    }
    public function distritos($departamento,$provincia){
        
        // $this->_view->titulo = 'Ingresar Nuevo Policía';
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento,$provincia);
        $this->_view->renderizar('ajax_distritos',true);
    }
    
    public function borrar($idusuario)
    {
        $this->_usuario = $this->loadModel('usuario');
         $this->_view->error = $this->_usuario->borrarUsuario($idusuario);
        $this->redireccionar('inicio');
    }
    
    public function editar($idusuario)
    {
        $this->_view->titulo = 'Editar Usuario';
        // $this->_view->setJs(array('nuevo'));
        $this->_usuario = $this->loadModel('usuario');
          $departamento='15';
        $provincia='01';
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento,$provincia);
         $this->_view->usuario = $this->_usuario->getUsuario($idusuario);
        $this->_view->renderizar('editar');
    }
    
    public function detalle($idusuario)
    {
        $this->_view->titulo = 'Detalle Usuario';
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->usuario = $this->_usuario->getUsuario($idusuario);
        $this->_view->renderizar('detalle');
    }
}

?>