<?php

class bomberoController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = 'SOS | Bomberos';
        $this->_view->renderizar('inicio');
    }
    
    // BOMBEROS
    
    public function bomberos($pagina=1)
    {
        $this->_view->titulo = 'Lista de Bomberos';
        $this->_view->setJs(array('bomberos'));
        $this->_bomberos = $this->loadModel('bombero');
        $this->_view->bomberos = $this->_bomberos->getBombeross($pagina);
        $this->_view->param = $this->_bomberos->getPaginacion(); 
        $this->_view->renderizar('inicio');
    }

    // ADMINISTRADORES 

    public function administradores($pagina=1)
    {
        $this->_view->titulo = 'SOS | Bomberos - Administradores';
        $this->_bombero = $this->loadModel('bombero');
        $this->_view->setJs(array('bomberos'));
        $this->_view->bomberos = $this->_bombero->getAdministradores($pagina);
        $this->_view->param = $this->_bombero->getPaginacion(); 
        $this->_view->renderizar('administradores');
    }

    // SUPERVISORES

    public function supervisores($pagina=1)
    {
        $this->_view->titulo = 'SOS | Bomberos - Supervisores';
        $this->_bombero = $this->loadModel('bombero');
        $this->_view->setJs(array('bomberos'));
        $this->_view->bomberos = $this->_bombero->getSupervisores($pagina);
        $this->_view->param = $this->_bombero->getPaginacion(); 
        $this->_view->renderizar('supervisores');
    }

    // OPERACIONES GENERALES

 	public function nuevo()
    {
        $this->_view->titulo = 'Ingresar Nuevo Bombero';
        $this->_entidad= $this->loadModel('entidad');
        // LIMA
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->setJs(array('nuevo'));
        $this->_view->renderizar('nuevo');
    }
     public function provincias($departamento){
        
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->provincias = $this->_entidad->getProvincias($departamento);
        $this->_view->renderizar('ajax_provincias',true);
    }
    public function distritos($departamento,$provincia){
        
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento,$provincia);
        $this->_view->renderizar('ajax_distritos',true);
    }

	public function ingresar()
    {
        $this->_bombero = $this->loadModel('usuario');
        
        $data['idUser']=isset($_POST['ID'])?$_POST['ID']:'';
        $data['Name'] = strtoupper(trim($_POST['NOMBRE']));
        $data['LastName'] = strtoupper(trim($_POST['APELLIDOS']));
        if ($_POST['ROL']=='2') {
            $rol='A';
        }elseif ($_POST['ROL']=='3') {
            $rol='U';
        }else{
            $rol='X';
        }

        $data['User'] = $data['Name']."-".$data['LastName'];
        $data['Code'] = "BVP-".$rol.rand(1000,9999);
        $data['Email'] = trim($_POST['EMAIL']);
        $pass=md5(rand(100000,999999));
        $data['Password'] = $pass;
        $data['State'] = isset($_POST['ACTIVO'])?'1':'0';
        $data['Role_idRole'] = trim($_POST['ROL']);
        $data['UserType_idUserType'] = '2';

        $this->_entidad = $this->loadModel('entidad');

        $de = $_POST['DEPARTAMENTO'];
        $pr = $_POST['PROVINCIA'];
        $di = $_POST['DISTRITO'];
        $id = $this->_entidad->getUbigeo($de,$pr,$di);
        
        if (!$id) {
            $data['Ubigeo_idUbigeo'] = '1404';
        }
        else{
            $data['Ubigeo_idUbigeo'] = $id->idUbigeo;
        }

        $this->_view->error = $this->_bombero->grabar($data);
        $this->redireccionar('bombero');
    }

    public function borrar($idBombero)
    {
        $this->_bombero = $this->loadModel('usuario');
         $this->_view->error = $this->_bombero->borrar($idBombero);
        $this->redireccionar('bombero');
    }
    
    public function editar($idBombero)
    {
        $this->_view->titulo = 'Editar Bombero';
        $this->_view->setJs(array('nuevo'));
        $this->_bombero = $this->loadModel('usuario');
        $this->_view->bombero = $this->_bombero->getUsuario($idBombero);
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('editar');
    }

    public function atender($idAlerta)
    {
        $this->_view->titulo = 'Atender Emergencia';
        // $this->_view->setJs(array('nuevo'));
        $this->_bombero= $this->loadModel('bombero');
        $this->_view->unidades = $this->_bombero->getUnidades();
        $this->_alerta = $this->loadModel('alerta');
        $this->_view->alerta = $this->_alerta->getAlertaBombero($idAlerta);
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('atenderAlerta');
    }
    
    public function detalle($idBombero)
    {
        $this->_view->titulo = 'Detalle Bombero';
        $this->_bombero = $this->loadModel('usuario');
        $this->_view->bombero = $this->_bombero->getUsuario($idBombero);
        
        if (!$this->_bombero->getUsuario($idBombero)) {
            $this->redireccionddar('inicio');
            exit;
        }

        $this->_view->renderizar('detalle');
    }
     public function alertas($pagina=1)
    {
        $this->_view->titulo = 'SOS | Bomberos - Alertas';
        $this->_alerta = $this->loadModel('alerta');
        // $this->_view->setJs(array('alertas'));
        if ((Session::get('distrito'))=="TODOS"){
        $this->_view->alertas = $this->_alerta->getAlertasBomberos($pagina);
        }else{
            $distrito=Session::get('idUbigeo');
           $this->_view->alertas = $this->_alerta->getAlertasBomberosDistrito($distrito,$pagina); 
        }
        $this->_view->param = $this->_alerta->getPaginacion(); 
        $this->_view->renderizar('alertas');
    }

    // public function alertAjax($pagina=1)
    // {
    //     $this->_view->titulo = 'SOS | Bomberos - Alertas';
    //     $this->_alerta = $this->loadModel('alerta');
    //     // $this->_view->setJs(array('alertas'));
    //     if ((Session::get('distrito'))=="TODOS"){
    //     $this->_view->alertas = $this->_alerta->getAlertasBomberos($pagina);
    //     }else{
    //         $distrito=Session::get('idUbigeo');
    //        $this->_view->alertas = $this->_alerta->getAlertasBomberosDistrito($distrito,$pagina); 
    //     }
    //     $this->_view->param = $this->_alerta->getPaginacion(); 
    //     $this->_view->renderizar('alertas');
    // }

    public function nuevaAlerta()
    {
        $this->_view->titulo = 'SOS | Bomberos - Nueva Alerta';
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_bombero= $this->loadModel('bombero');
        $this->_view->unidades = $this->_bombero->getUnidades();
        $this->_view->renderizar('nuevaAlerta');
    }
    public function ingresarAlerta()
    {
        $this->_alerta = $this->loadModel('alerta');
        $data['idAlert']=isset($_POST['ID'])?$_POST['ID']:'';
        $data['NameCaller'] = strtoupper(trim($_POST['NOMBRE']));
        $data['Code'] = "BVP";
        $data['PhoneNumberCaller'] = trim($_POST['NUMERO']);
        $data['AlertDetail'] = trim($_POST['DETALLE']);
        $data['Location'] = strtoupper(trim($_POST['UBICACION']));
        $data['AlertType_idAlertType'] = trim($_POST['TIPO']);
        $data['AppUnit_idAppUnit'] = isset($_POST['UNIDAD'])?$_POST['UNIDAD']:'1';
        $data['AppUser_idAppUser'] = isset($_POST['IDAPP'])?$_POST['IDAPP']:'1';

        if ((Session::get('distrito'))=="TODOS"){
            $data['State_idState'] = '2';
        }else{
            $data['State_idState'] = '3';
        }

        $de=Session::get('idDepartamento');
        $pr=Session::get('idProvincia');
        if ((Session::get('distrito'))=="TODOS"){
           $di = $_POST['DISTRITO'];
        }else{
            $di = Session::get('idDistrito');
        }

        $this->_entidad = $this->loadModel('entidad');
        $id = $this->_entidad->getUbigeo($de,$pr,$di);
        
        $data['Ubigeo'] = $id->idUbigeo;
       
        $this->_view->error = $this->_alerta->grabarAlerta($data);
        $this->redireccionar('bombero/alertas');
    }

    public function detalleAlerta($idAlerta)
    {
        $this->_view->titulo = 'SOS | Bomberos - Detalle Alerta';
        $this->_alerta = $this->loadModel('alerta');
        $this->_view->alerta = $this->_alerta->getAlertaBombero($idAlerta);
        
        if (!$this->_alerta->getAlertaBombero($idAlerta)) {
            $this->redireccionar('bombero/alertas');
            exit;
        }

        $this->_view->renderizar('detalleAlerta');
    }
    
}

?>