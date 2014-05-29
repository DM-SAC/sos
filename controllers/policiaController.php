<?php

class policiaController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = 'SOS | Policías';
        $this->_view->renderizar('inicio');
    }
    
    // POLICIAS
    
    public function policias($pagina=1)
    {
        $this->_view->titulo = 'Lista de Policías';
        $this->_view->setJs(array('policias'));
        $this->_policias = $this->loadModel('policia');
        $this->_view->policias = $this->_policias->getPolicias($pagina);
        $this->_view->param = $this->_policias->getPaginacion(); 
        $this->_view->renderizar('inicio');
    }

    // ADMINISTRADORES 

    public function administradores($pagina=1)
    {
        $this->_view->titulo = 'SOS | Policías - Administradores';
        $this->_policia = $this->loadModel('policia');
        $this->_view->setJs(array('policias'));
        $this->_view->policias = $this->_policia->getAdministradores($pagina);
        $this->_view->param = $this->_policia->getPaginacion(); 
        $this->_view->renderizar('administradores');
    }

    // SUPERVISORES

    public function supervisores($pagina=1)
    {
        $this->_view->titulo = 'SOS | Policías - Supervisores';
        $this->_policia = $this->loadModel('policia');
        $this->_view->setJs(array('policias'));
        $this->_view->policias = $this->_policia->getSupervisores($pagina);
        $this->_view->param = $this->_policia->getPaginacion(); 
        $this->_view->renderizar('supervisores');
    }

    // OPERACIONES GENERALES

 	public function nuevo()
    {
        $this->_view->titulo = 'Ingresar Nuevo Policía';
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
        $this->_policia = $this->loadModel('usuario');
        
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
        $data['Code'] = "PNP-".$rol.rand(1000,9999);
        $data['Email'] = trim($_POST['EMAIL']);
        $pass=md5(rand(100000,999999));
        $data['Password'] = $pass;
        $data['State'] = isset($_POST['ACTIVO'])?'1':'0';
        $data['Role_idRole'] = trim($_POST['ROL']);
        $data['UserType_idUserType'] = '3';

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

        // $data['Ubigeo_idUbigeo'] = '1404';

        $this->_view->error = $this->_policia->grabar($data);
        $this->redireccionar('policia');
    }

    public function borrar($idPolicia)
    {
        $this->_policia = $this->loadModel('usuario');
         $this->_view->error = $this->_policia->borrar($idPolicia);
        $this->redireccionar('policia');
    }
    
    public function editar($idPolicia)
    {
        $this->_view->titulo = 'Editar Policía';
        $this->_view->setJs(array('nuevo'));
        $this->_policia = $this->loadModel('usuario');
        $this->_view->policia = $this->_policia->getUsuario($idPolicia);
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('editar');
    }

    public function atender($idAlerta)
    {
        $this->_view->titulo = 'Atender Emergencia';
        // $this->_view->setJs(array('nuevo'));
        $this->_policia= $this->loadModel('policia');
        $this->_view->unidades = $this->_policia->getUnidades();
        $this->_alerta = $this->loadModel('alerta');
        $this->_view->alerta = $this->_alerta->getAlertaPolicia($idAlerta);
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('atenderAlerta');
    }
    
    public function detalle($idPolicia)
    {
        $this->_view->titulo = 'Detalle Policía';
        $this->_policia = $this->loadModel('usuario');
        $this->_view->policia = $this->_policia->getUsuario($idPolicia);
        
        if (!$this->_policia->getUsuario($idPolicia)) {
            $this->redireccionar('inicio');
            exit;
        }

        $this->_view->renderizar('detalle');
    }

    public function alertas($pagina=1)
    {
        $this->_view->titulo = 'SOS | Policía - Alertas';
        $this->_alerta = $this->loadModel('alerta');
        // $this->_view->setJs(array('alertas'));
        if ((Session::get('distrito'))=="TODOS"){
        $this->_view->alertas = $this->_alerta->getAlertasPolicias($pagina);
        }else{
            $distrito=Session::get('idUbigeo');
           $this->_view->alertas = $this->_alerta->getAlertasPoliciasDistrito($distrito,$pagina); 
        }
        $this->_view->param = $this->_alerta->getPaginacion(); 
        $this->_view->renderizar('alertas');
    }
    
    
}

?>