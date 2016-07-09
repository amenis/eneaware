<?php
    class conexion{
        
        var $DBHOST = "localhost";
        var $DBUSER = "root";
        var $DBPASSWORD = "";
        var $DBNAME="eneaware";
        var $DBCHARSET="utf-8";
        protected $conection;
       
        public function __construct(){
            date_default_timezone_set("America/Mexico_City");
            $this->conect();    
        }

        private function conect(){
            $this->conection = mysqli_connect($this->DBHOST,$this->DBUSER,$this->DBPASSWORD,$this->DBNAME) or die("ERROR AL CONECTAR A LA BASE DE DATOS");
            //$this->conection->set_charset(DBCHARSET); 
        }
        
        function closeConection(){
           $this->conection->mysqli_close();
        }
    }
?>
