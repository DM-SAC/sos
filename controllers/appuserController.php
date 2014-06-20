<?php

class appuserController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = 'SOS | App User';
        $this->_view->renderizar('inicio', 'appuser');
    }
    
    public function usuarios($pagina=1)
    {
        $this->_view->titulo = 'Lista de Usuarios de la Aplicación';
        $this->_appusers = $this->loadModel('appuser');
        $this->_view->appuser = $this->_appusers->getAppUsuarios($pagina);
        $this->_view->param = $this->_appusers->getPaginacion(); 
        $this->_view->renderizar('usuarios','appuser');
    }

    // OPERACIONES GENERALES

 	public function nuevo()
    {
        $this->_view->titulo = 'SOS | Aplicación - Nuevo Usuario';
        $this->_view->setJs(array('nuevo'));
        $this->_view->renderizar('nuevo','appuser');
    }

	public function ingresar()
    {
        if (isset($_GET['ID'])) {

        $data['idAppUser']=isset($_GET['ID'])?$_GET['ID']:'';
        $data['NameUser'] = strtoupper(trim($_GET['NOMBRE']));
        $data['LastNameUser'] = strtoupper(trim($_GET['APELLIDOS']));
        $data['PhoneNumber'] = trim($_GET['NUMERO']);
        $data['Document'] = rand(11111111,9999999);
        $data['Priority']=isset($_GET['PRIORIDAD'])?$_GET['PRIORIDAD']:'5';
        }else{
        $data['idAppUser']=isset($_POST['ID'])?$_POST['ID']:'';
        $data['NameUser'] = strtoupper(trim($_POST['NOMBRE']));
        $data['LastNameUser'] = strtoupper(trim($_POST['APELLIDOS']));
        $data['PhoneNumber'] = trim($_POST['NUMERO']);
        $data['Document'] = trim($_POST['DNI']);
        $data['Priority']=isset($_POST['PRIORIDAD'])?$_POST['PRIORIDAD']:'';
            
        }
        

        $this->_appuser = $this->loadModel('appuser');

        $this->_view->error = $this->_appuser->grabarUsuario($data);
        $this->redireccionar('appuser/usuarios');
    }

    public function bloquear($iduser)
    {
        $this->_appuser = $this->loadModel('appuser');
         $this->_view->error = $this->_appuser->bloquear($iduser);
        $this->redireccionar('appuser/usuarios');
    }
    
    public function editar($idusuario)
    {
        $this->_view->titulo = 'SOS | Aplicación - Editar Usuario';
        // $this->_view->setJs(array('nuevo'));
        $this->_appuser = $this->loadModel('appuser');
        $row = $this->_appuser->getAppUsuario($idusuario);
        $this->_view->appuser = $row;
        if (!$row) {
            $this->redireccionar('inicio');
            exit;
        }
        $this->_view->renderizar('editar','appuser');
    }

    public function detalle($idusuario)
    {
        $this->_view->titulo = 'SOS | Aplicación - Detalle Usuario';
        $this->_appuser = $this->loadModel('appuser');
        $row = $this->_appuser->getAppUsuario($idusuario);
        $this->_view->appuser = $row;
        if (!$row) {
            $this->redireccionar('inicio');
            exit;
        }

        $this->_view->renderizar('detalle');
    }
}
    // $index=new appuserController();
    // $cl = $index->ingresarApp();
    // $cl->run();

?>