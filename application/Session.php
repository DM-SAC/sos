<?php

class Session
{
    public static function init()
    {
        session_start();
    }
    
    public static function destroy($clave = false)
    {
        if($clave){
            if(is_array($clave)){
                for($i = 0; $i < count($clave); $i++){
                    if(isset($_SESSION[$clave[$i]])){
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            }
            else{
                if(isset($_SESSION[$clave])){
                    unset($_SESSION[$clave]);
                }
            }
        }
        else{
            session_destroy();
        }
    }
    
    public static function set($clave, $valor)
    {
        if(!empty($clave))
        $_SESSION[$clave] = $valor;
    }
    
    public static function get($clave)
    {
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
    }
    
    public static function autenticado()
    {
        if(!Session::get('autenticado')){
            header('location:' . BASE_URL . 'error/access/8080');
            exit;
        }
        
    }
    public static function acceso($level)
    {
        if(!Session::get('autenticado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }
    
    public static function accesoView($level)
    {
        if(!Session::get('autenticado')){
            return false;
        }
        
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            return false;
        }
        
        return true;
    }
    
    public static function getLevel($level)
    {
        $role['central'] = 2;
        $role['distrito'] = 1;
        
        if(!array_key_exists($level, $role)){
            // throw new Exception('Error de acceso');
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        else{
            return $role[$level];
        }
    }
    
    public static function accesoEstricto(array $level, $noAdmin = false)
    {
        if(!Session::get('autenticado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        Session::tiempo();
        
        if($noAdmin == false){
            if(Session::get('level') == 'admin'){
                return;
            }
        }
        
        if(count($level)){
            if(in_array(Session::get('level'), $level)){
                return;
            }
        }
        
        header('location:' . BASE_URL . 'error/access/5050');
    }
    
    public static function accesoViewEstricto(array $level, $noAdmin = false)
    {
        if(!Session::get('autenticado')){
            return false;
        }
        
        if($noAdmin == false){
            if(Session::get('level') == 'central'){
                return true;
            }
        }
        
        if(count($level)){
            if(in_array(Session::get('level'), $level)){
                return true;
            }
        }
        
        return false;
    }
    
}
?>