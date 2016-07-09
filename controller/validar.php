<?php
    include('../model/validaLogin.php');
    

    $usuario = md5($_POST['usuario']);
    $password = md5($_POST['pass']);
    
    $validaLogin = new validaLogin();
    $result = $validaLogin->validaUSer($usuario,$password);
    echo $result;
   
    
?>