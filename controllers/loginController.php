<?php

class loginController extends Controller
{
    private $_login;
    
    public function __construct(){
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }
    
    public function inicio()
    {
        if (Session::get('autenticado')){
            $this->redireccionar('inicio');
        }

        $this->_view->titulo = 'Iniciar Sesión';
         $this->_view->setJs(array('inicio'));  
         $this->_view->renderizar('inicio');
    }
     
    public function iniciar()
    {   
        if (Session::get('autenticado')){
            $this->redireccionar('inicio');
        }

        $this->_view->titulo = 'Iniciar Sesión'; 
        $this->_view->setJs(array('inicio'));  
        if($this->getInt('enviar') == 1){
            
            // if(!$this->getAlphaNum('usuario')){
            //     $this->_view->_error = 'Debe introducir su nombre de usuario';
            //     $this->_view->renderizar('inicio/inicio');
            //     exit;
            // }
            
            // if(!$this->getSql('clave')){
            //     $this->_view->_error = 'Debe introducir su password';
            //     $this->_view->renderizar('inicio/inicio');
            //     exit;
            // }
            $email = trim($_POST['usuario']);
            $password = md5(trim($_POST['clave']));

            $row = $this->_login->getUsuario($email,$password);
            
            if(!$row){
                $this->_view->_error = 'Usuario y/o password incorrectos.';
                $this->_view->renderizar('inicio');
                exit;
            }
            
            if($row->State != 1){
                $this->_view->_error = 'Este usuario no está habilitado.';
                $this->_view->renderizar('inicio');
                exit;
            }

            Session::set('autenticado', true);
            Session::set('id', $row->idUser);
            Session::set('usuario', $row->Name);
            Session::set('apellidos', $row->LastName);
            Session::set('rol', $row->DetailRole);
            Session::set('rolId', $row->idRole);
            Session::set('tipo', $row->UserType);
            Session::set('tipoId', $row->idUserType);
            Session::set('distrito', $row->DistrictName);
            Session::set('idUbigeo', $row->idUbigeo);
            Session::set('idDistrito', $row->District);
            Session::set('idDepartamento', $row->Department);
            Session::set('idProvincia', $row->Province);
            // Session::set('tiempo', time());
            $this->redireccionar('inicio');
        }
        // $this->_view->renderizar('login');
        $this->redireccionar('login');
    }
    
    public function cerrar()
    {
        Session::destroy();
        $this->redireccionar('login');
    }
}

?>