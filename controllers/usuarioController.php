<?php

class usuarioController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Inicio";
        // $this->_view->renderizar('inicio');
         $this->redireccionar('inicio');
    }

    public function usuarios($pagina=1)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Usuarios";
        $this->_view->setJs(array('usuario'));
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->usuarios = $this->_usuario->getUsuarios($pagina);
        $this->_view->param = $this->_usuario->getPaginacion(); 
        $this->_view->renderizar('usuario');
    }

    public function administradores($pagina=1)
    {
        $tipo=Session::get('tipoId');
        if ($tipo=='1') {
            $tipo=Session::get('type');
        }
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Administradores";
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->setJs(array('usuario'));
        if (Session::get('tipoId')=='1' ) {
           $ubigeo='2054';
        }else{
            $ubigeo=Session::get('idUbigeo');
        }

        $this->_view->usuarios = $this->_usuario->getAdministradores($pagina,$tipo,$ubigeo);
        $this->_view->param = $this->_usuario->getPaginacion(); 
        $this->_view->renderizar('administradores');
    }

    public function supervisores($pagina=1)
    {
       $tipo=Session::get('tipoId');
        if ($tipo=='1') {
            $tipo=Session::get('type');
        }

        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Supervisores";
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->setJs(array('usuario'));
        
        if (Session::get('tipoId')=='1' ) {
           $ubigeo='2054';
        }else{
            $ubigeo=Session::get('idUbigeo');
        }

        $this->_view->usuarios = $this->_usuario->getSupervisores($pagina, $tipo, $ubigeo);
        $this->_view->param = $this->_usuario->getPaginacion(); 
        $this->_view->renderizar('supervisores');
    }

    public function nuevo()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Ingresar Nuevo Usuario";
        $this->_entidad= $this->loadModel('entidad');
        // LIMA
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->setJs(array('nuevo'));
        $this->_view->setJs(array('comprobar-email'));
        $this->_view->renderizar('nuevo');
    }

    public function ingresar()
    {
        $tipo=Session::get('tipoId');

        $this->_usuario = $this->loadModel('usuario');
        
        $data['idUser']=isset($_POST['ID'])?$_POST['ID']:'';
        $data['Name'] = strtoupper(trim($_POST['NOMBRE']));
        $data['LastName'] = strtoupper(trim($_POST['APELLIDOS']));
        $data['User'] = $data['Name']."-".$data['LastName'];
        
        if ($_POST['TIPO']=='2' || $tipo=='2') {
            $code='BVP';
        }else{
            $code='PNP';
        }

        $data['Code'] = $code."-".rand(1000,9999);
        $data['Email'] = trim($_POST['EMAIL']);
        $pass=md5(rand(100000,999999));
        $data['Password'] = isset($_POST['CLAVE'])?md5(trim($_POST['CLAVE'])):$pass;
        $data['State'] = isset($_POST['ACTIVO'])?'1':'0';
        $data['Role_idRole'] = trim($_POST['ROL']);
        $data['UserType_idUserType'] = isset($_POST['TIPO'])?$_POST['TIPO']:$tipo;
        $this->_entidad = $this->loadModel('entidad');
        
        if (Session::get('tipoId')=='1' ) {
            $de = $_POST['DEPARTAMENTO'];
            $pr = $_POST['PROVINCIA'];
            $di = $_POST['DISTRITO'];
            $id = $this->_entidad->getUbigeo($de,$pr,$di);
            $data['Ubigeo_idUbigeo'] = $id->idUbigeo;
        }else{
            $data['Ubigeo_idUbigeo'] = Session::get('idUbigeo');

        }

        $this->_view->error = $this->_usuario->grabar($data);
        if ($tipo=='1') {
             $this->redireccionar('inicio');
            exit();
        }
        if ($data['Role_idRole']=='2') {
            $this->redireccionar('usuario/administradores');
            exit();
        }else{
            $this->redireccionar('usuario/supervisores');
            exit();
        }
        
    }

    public function provincias($departamento)
    {
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->provincias = $this->_entidad->getProvincias($departamento);
        $this->_view->renderizar('ajax_provincias',true);
    }

    public function distritos($departamento,$provincia)
    {
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento,$provincia);
        $this->_view->renderizar('ajax_distritos',true);
    }
    
    public function borrar($idusuario)
    {
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->error = $this->_usuario->borrar($idusuario);
        $this->redireccionar('inicio');
    }
    public function validarEmail()
    {
        $this->_usuario = $this->loadModel('usuario');
        $this->_view->setJs(array('comprobar-email'));
        $email=trim($_POST['EMAIL']);
        $row = $this->_usuario->existEmail($email);
        // $row?$this->_view->info="uno":$this->_view->info="cero";
        $this->_view->info = $row?"uno":"cero";
        // }else{
        //     $this->_view->info="No existe";
        // }
        // $this->_view->info=$row;
        $this->_view->renderizar('ajax_email',true);
        // $this->redireccionar('usuario/nuevo');
    }
    
    public function editar($idusuario)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Editar Usuario";
        $this->_view->setJs(array('nuevo'));
        $this->_usuario = $this->loadModel('usuario');
        $row = $this->_usuario->getUsuario($idusuario);
        
        if (!$row) {
            $this->redireccionar('inicio');
            exit;
        }

        $this->_view->usuario = $row;
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('editar');
    }
    
    public function detalle($idusuario)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Detalle Usuario";
        $this->_usuario = $this->loadModel('usuario');
        $row = $this->_usuario->getUsuario($idusuario);

        if (!$row || (Session::get('rolId')>'2' && $idusuario!=Session::get('id')) ) {
           $this->redireccionar('inicio');
           exit();
        }
        
        $this->_view->usuario = $row;
        if ($idusuario==Session::get('id')) {
            $this->_view->renderizar('detalle','cuenta');
        }elseif (Session::get('tipoId')=='2') {
            $this->_view->renderizar('detalle','bombero');
        }elseif(Session::get('tipoId')=='3'){
            $this->_view->renderizar('detalle','policia');
        }else{
            $this->_view->renderizar('detalle','inicio');
        }
    }

    public function password()
      {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Cambiar contraseña";
        $this->_view->setJs(array('jquery.validate.password'));
        $this->_view->setJs(array('password'));
        $this->_view->renderizar('password','cuenta');
      }

    public function cuenta()
    {
       $this->_view->titulo = "SOS | ".Session::get('tipo')." - Mi Cuenta";
     
       $this->_view->renderizar('cuenta','cuenta');
     }

    public function cambiarPassword()
    {
       $this->_view->titulo = 'SOS | Inicio - Cambiar contraseña';
       $this->_view->setJs(array('jquery.validate.password'));
       $this->_view->setJs(array('password'));
       $this->_usuario= $this->loadModel('usuario');

       $id = Session::get('id');
       $antiguo = md5(trim($_POST['ANTIGUO']));
       $nuevo = md5(trim($_POST['password_confirm']));
       $validar=$this->_usuario->getPassword($id,$antiguo);

       if (!$validar) {
            $this->_view->_error = 'Contraseña incorrecta.';
            $this->_view->renderizar('password','cuenta');
            exit;
        }

        $this->_usuario->cambiarPassword($id,$nuevo);
        $this->redireccionar('usuario/cuenta');
    }
}
?>