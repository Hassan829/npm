<?php

class Database{
    
    
    private $_connection;
    private static $_instance;
    
    
   function __construct() {
       
       // 
       
      // $this->_connection = new mysqli('hostname', 'username', 'password', 'databasename');
       // $this->_connection = new mysqli('localhost', 'npmsolut_adnan', 'Aziza737', 'npmsolut_attendance');
       $this->_connection = new mysqli('localhost', 'root', '', 'npmsolut_attendance');
       
       if(mysqli_connect_error()){
           trigger_error("Error", mysqli_connect_error(), E_USER_ERROR);
       }
    }
    
    
    public static function getInstance(){
        
        
        if(!self::$_instance){
            
            self::$_instance = new self();
            
        }
        
    return self:: $_instance;
        
    }
    
    
    private function __clone() {
        
    }
    
    
    public function getConnection(){
        
        return $this->_connection;
        
    }
    
    
    
}

?>