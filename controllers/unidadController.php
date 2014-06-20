<?php

class unidadController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Inicio";
           if (Session::get('tipoId')=='2') {
            $menu='bombero';
        }elseif(Session::get('tipoId')=='3'){
            $menu='policia';
        }else{
            $menu='inicio';
        }

        $this->_view->renderizar('inicio',$menu);
    }
    
    public function unidades()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Lista de Unidades";
        $this->_unidad = $this->loadModel('unidad');
        $ubigeo=Session::get('idUbigeo');
        $tipo=Session::get('tipoId');
        if (Session::get('distrito')=='TODOS') {
           $ubigeo='0';
        }
        $this->_view->unidades = $this->_unidad->getUnidades($tipo,$ubigeo);
        $this->_view->param = $this->_unidad->getPaginacion(); 
        $this->_view->renderizar('unidades','inicio');
    }

    // OPERACIONES GENERALES

 	public function nueva()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Nueva Unidad";
        $this->_view->setJs(array('nuevo'));
        
        if (Session::get('tipoId')=='2') {
            $menu='bombero';
        }elseif(Session::get('tipoId')=='3'){
            $menu='policia';
        }else{
            $menu='inicio';
        }

        $this->_view->renderizar('nuevo',$menu);
    }

	public function ingresar()
    {
     
        $data['idAppUnit']=isset($_POST['ID'])?$_POST['ID']:'';
        if (Session::get('tipoId')=='2') {
            $code='BVP';
        }else{
            $code='PNP';
        }
        $data['CodeUnit'] = $code;
        $data['NameUnit'] = strtoupper(trim($_POST['NOMBRE']));
        $data['LastNameUnit'] = strtoupper(trim($_POST['APELLIDOS']));
        $data['Plate'] = trim($_POST['PLACA']);
        $data['StateUnit'] = isset($_POST['ACTIVO'])?'1':'0';
        $data['License_idLicense']='1';
        $data['usertype_idUserType']=Session::get('tipoId');
        $data['Ubigeo_idUbigeo'] = Session::get('idUbigeo');

        $this->_unidad = $this->loadModel('unidad');

        $this->_view->error = $this->_unidad->grabarUnidad($data);
        $this->redireccionar('unidad/unidades');
    }

    public function bloquear($idunidad)
    {
        $this->_unidad = $this->loadModel('unidad');
         $this->_view->error = $this->_unidad->bloquear($idunidad);
        $this->redireccionar('unidad/unidades');
    }
    
    public function editar($idunidad)
    {
        $this->_view->titulo = 'SOS | Aplicación - Editar Unidad';
        // $this->_view->setJs(array('nuevo'));
        $this->_unidad = $this->loadModel('unidad');
        $row = $this->_unidad->getUnidad($idunidad);
        $this->_view->unidad = $row;
        if (!$row) {
            $this->redireccionar('inicio');
            exit;
        }
        $this->_view->renderizar('editar');
    }

    public function detalle($idunidad)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Detalle Unidad";
        $this->_unidad = $this->loadModel('unidad');
        $row = $this->_unidad->getUnidad($idunidad);
        $this->_view->unidad = $row;
        if (!$row) {
            $this->redireccionar('inicio');
            exit;
        }

        $this->_view->renderizar('detalle');
    }
    
}

?>