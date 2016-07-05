<?php
    session_start();
    include("Conexion.php");
    class validaLogin extends conexion{
        
         public function __construct(){
            parent::__construct(); 
            
        }
        
        public function validaUSer($usuario,$password){
            
            $msj;
            
            $result = mysqli_query($this->conection,"SELECT * FROM Usuarios WHERE usuario='$usuario'");
            $numResult = mysqli_num_rows($result);
            if($numResult == 0){
                $msj = "El usuario proporcionado no es existe";
            }
            else{
                $userResult = mysqli_fetch_array($result);
                if($password == $userResult['password']){
                    if($userResult['status_login']==1){
                        $_SESSION["Usuario_Eneaware"]=$userResult["usuario"];			
                        $_SESSION["Nombre_Usuario_Eneaware"]=$userResult["apellidoP"]." ".$userResult["apellidoM"]." ".$userResult["nombre"];	
                        $_SESSION["id_usuario"]= $userResult['id_usuario'];
                        $_SESSION["Permisos_Eneaware"]=explode(",", $userResult["permisos"]);			
                        $msj = "Inicio de sesion correcto"	;
                    }
                    else{
                        $msj = "El usuario ha sido deshabilitado";
                    }
                }
                else{
                    $msj = "Contrase&ntilde;a incorrecta";
                }
            }
            
            return $msj;
        }
        
        public function CerrarSession(){
            session_destroy();
        }
    }
?>