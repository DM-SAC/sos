<?php

class appController extends Controller
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
    
     public function ingresarApp()
    {
        if ($_GET['name']=='' || $_GET['last']=='') {
           exit();
        }
      
        $data['idAppUser']=isset($_GET['ID'])?$_GET['ID']:'';
        $data['NameUser'] = strtoupper(trim($_GET['name']));
        $data['LastNameUser'] = strtoupper(trim($_GET['last']));
        $data['PhoneNumber'] = rand(900000000,999999999);
        $data['Document'] = rand(11111111,9999999);
        $data['Priority']=isset($_GET['PRIORIDAD'])?$_GET['PRIORIDAD']:'5';
   
  
        $this->_appuser = $this->loadModel('appuser');
        
      $this->_appuser->grabarUsuario($data);

    }

}
    $index=new appController();
    $cl = $index->ingresarApp();
    $cl->run();

?>