<?php

class alertaController extends Controller
{
    public function __construct() {
        parent::__construct();
        Session::autenticado();
    }
    
    public function inicio()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Alertas";
        $this->redireccionar('alerta/alertas');
    }

    public function detalle($idAlerta)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Detalle Alerta";
        $this->_alerta = $this->loadModel('alerta');
        $row = $this->_alerta->getAlerta($idAlerta);
        
        if (!$row) {
            $this->redireccionar('alerta','alertas');
            exit;
        }

        $this->_view->alerta = $row;
        $this->_view->renderizar('alerta','alertas');
    }
    
    public function ingresarAlerta()
    {
        $this->_alerta = $this->loadModel('alerta');
        $data['idAlert']=isset($_POST['ID'])?$_POST['ID']:'';
        $data['NameCaller'] = strtoupper(trim($_POST['NOMBRE']));
        $data['Code'] = Session::get('tipoId')=='2'?'BVP':'PNP';
        $data['PhoneNumberCaller'] = trim($_POST['NUMERO']);
        $data['AlertDetail'] = trim($_POST['DETALLE']);
        $data['Location'] = strtoupper(trim($_POST['UBICACION']));
        $data['AlertType_idAlertType'] = trim($_POST['TIPO']);
        $data['AppUnit_idAppUnit'] = isset($_POST['UNIDAD'])?$_POST['UNIDAD']:'1';
        $data['AppUser_idAppUser'] = isset($_POST['IDAPP'])?$_POST['IDAPP']:'1';

        if ((Session::get('distrito'))=="TODOS"){
            $data['State_idState'] = '2';
            $di = $_POST['DISTRITO'];
        }else{
            $data['State_idState'] = '3';
            $di = Session::get('idDistrito');
        }

        $de=Session::get('idDepartamento');
        $pr=Session::get('idProvincia');

        $this->_entidad = $this->loadModel('entidad');
        $id = $this->_entidad->getUbigeo($de,$pr,$di);
        
        $data['Ubigeo'] = $id->idUbigeo;

        $this->_view->error = $this->_alerta->grabarAlerta($data);
        unset($_SESSION['UABD']);
        unset($_SESSION['UAM']);
        $this->redireccionar('alerta');
        // $this->_view->renderizar('alertas','alertas');
    }

    public function nueva()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Nueva Alerta";
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_unidad= $this->loadModel('unidad');
        $this->_view->unidades = $this->_unidad->getUnidades(Session::get('tipoId'),Session::get('idUbigeo'));
        $this->_view->unidadesL = $this->_unidad->getUnidades(Session::get('tipoId'),Session::get('idUbigeo'));
        $this->_view->renderizar('nuevaAlerta','alertas');
    }

    public function alertas()
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Alertas";
        $this->_alerta = $this->loadModel('alerta');
        $this->_view->setJs(array('buscar'));
        $this->_view->setJs(array('alertas'));

        $buscar='';
        $ubigeo=Session::get('idUbigeo');
        $tipo=Session::get('tipoId')=='2'?'BVP':'PNP';
        
        if(isset($_POST['buscar'])){
            $buscar = preg_replace('[\s+]','', $_POST['buscar']);
        }
        $this->_view->buscar = $buscar;
        if (Session::get('distrito')=='TODOS') {
        $ultimaAlerta=$this->_alerta->getUltimaAlerta($tipo,$ubigeo=='0');
        $numeroAlertas=$this->_alerta->getNumeroAlertas($ubigeo='0',$tipo);
        }else{
            $ultimaAlerta=$this->_alerta->getUltimaAlerta($tipo,$ubigeo);
            $numeroAlertas=$this->_alerta->getNumeroAlertas($ubigeo,$tipo);
        }

        // $this->_view->numero = $numeroAlertas->numero;
        Session::set('numero',$numeroAlertas->numero);
        
        Session::set('UABD',$ultimaAlerta->idAlert);
        if (!Session::get('UAM')) {
            Session::set('UAM',$ultimaAlerta->idAlert);
        }

        if (Session::get('UABD')>Session::get('UAM')) {

            if (Session::get('distrito')=='TODOS') {
                $this->_view->alertas = $this->_alerta->getAlertasAjax(Session::get('UABD'),Session::get('UAM'),$tipo);
            }else{
                $this->_view->alertas = $this->_alerta->getAlertasDistritoAjax(Session::get('UABD'),Session::get('UAM'),$tipo,$ubigeo);
            // $this->_view->renderizar('alertasAjax',true);
            }

            if (!isset($_POST['buscar'])) {

                if (isset($_POST['ultimo']) && Session::get('UABD')==Session::get('UAM')){
                    exit();
                }else{
                    $this->_view->renderizar('alertasAjax',true);
                    // $this->_view->renderizar('alertas','alertas');
                }
            }else{
                $this->_view->renderizar('alertasBusqueda',true);
            }

            Session::set('UAM',Session::get('UABD'));

        }else{

            if (Session::get('distrito')=="TODOS"){
                $this->_view->alertas = $this->_alerta->getAlertas($buscar,Session::get('UABD'),$tipo);
            }else{
                $this->_view->alertas = $this->_alerta->getAlertasDistrito($ubigeo,$buscar,Session::get('UABD'),$tipo); 
            }

            if (!isset($_POST['buscar'])) {
                if (isset($_POST['ultimo']) && Session::get('UABD')==Session::get('UAM')){
                    exit();
                }else{
                    $this->_view->renderizar('alertas','alertas');
                }
            }
            else{
                $this->_view->renderizar('alertasBusqueda',true);
            }
            
         Session::set('UAM',Session::get('UABD'));
        }
        // $this->_view->param = $this->_alerta->getPaginacion(); 
    }

    public function atender($idAlerta)
    {
        $this->_view->titulo = "SOS | ".Session::get('tipo')." - Atender Emergencia";
        $this->_unidad= $this->loadModel('unidad');
        $this->_view->unidades = $this->_unidad->getUnidades(Session::get('tipoId'),Session::get('idUbigeo'));
        $this->_view->unidadesL = $this->_unidad->getUnidades(Session::get('tipoId'),Session::get('idUbigeo'));
        $this->_alerta = $this->loadModel('alerta');
        $this->_view->alerta = $this->_alerta->getAlerta($idAlerta);
        $this->_entidad= $this->loadModel('entidad');
        $this->_view->distritos = $this->_entidad->getDistritos($departamento='15',$provincia='01');
        $this->_view->renderizar('atenderAlerta','alertas');
    }
}
?>