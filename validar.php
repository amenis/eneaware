<?php
session_start();
	include("conexion.php");
	$usuario = md5($_POST["usuario"]);
	$contrasenia = md5($_POST["pass"]);
	
	$consulta = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE usuario='$usuario'");	
	$numUsuarios = mysqli_num_rows($consulta);
	if($numUsuarios==0){
		echo "El usuario y/o la contrase&ntilde;a son incorrectos.<br>";
	}
	else {
		$datos=@mysqli_fetch_array($consulta);
		if($contrasenia==$datos["password"]){
			if($datos["status_login"]==1){
				$_SESSION["Usuario_Eneaware"]=$datos["usuario"];			
				$_SESSION["Nombre_Usuario_Eneaware"]=$datos["apellidoP"]." ".$datos["apellidoM"]." ".$datos["nombre"];	
				$_SESSION["id_usuario"]= $datos['id_usuario'];
				$_SESSION["Permisos_Eneaware"]=explode(",", $datos["permisos"]);			
				echo "Inicio de sesion correcto"	;
			}
			else{
					echo "El usuario se encuentra inhabilitado en el sistema<br>";
			}
		}
		else {
			echo "El usuario y/o la contrase&ntilde;a son incorrectos.<br>";
		}
	}
	mysqli_free_result($consulta);
	mysqli_close($conexion);
?>