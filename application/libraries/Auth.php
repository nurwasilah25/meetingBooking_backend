<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author dito
 */



class Auth {
    var $CI = NULL;

  function __construct() {
    // get CI's object
    $this->CI =& get_instance();
  }
        
        
        function Auth_isPermDelete($token) {
            
            $config_token = $this->CI->config->item('token');
            
            if (md5($config_token) == $token){
                
                return true;
            }
            else{
                 
               $array=array('success'=>0,'message'=>'You dont have access to this menu !'
                );
              echo json_encode($array)  ;
               die();
            }
            
        }
        
        function Auth_isPermPost($token) {
            
            $config_token = $this->CI->config->item('token');
            
            if (md5($config_token) == $token){
                
                return true;
            }
            else{
               return false;
            }
            
        }
        
        function Auth_isPermSecret($secret) {
            
            
           $config_secret = $this->CI->config->item('carsurin');
            
            if ($config_secret == $secret){
                
                return true;
            }
            else{
               return false;
            }
            }
            
        
    
  
        
        
        function Auth_getHeader($header_name) {
            
            
            $headers = array();
        
        foreach ($this->getallheaders() as $name => $value) {
            $headers[$name] = $value;
            
        }
            return $headers[$header_name];
            
           
        }
    
    function getallheaders()
    {
           $headers = [];
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace("http_","",strtolower($name))] = $value;
           }
       }
     //var_dump($headers);
    
       return $headers;
    } 
      
        
    //put your code here
}
