<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][2]!="000"){
		include("conexion.php");
		
		if($_POST["accion"]=="registro"){
			extract($_POST);
			$ids = "";
			foreach($_POST as $name => $val){
				if($name !="accion" && $name !="notas" && $name !="fecha_inicio" && $name !="fecha_fin") {
					 $ids .=substr($val, 0, strlen($name)-1).",";		
				}	
				//$ids = substr($ids, 0, strlen($ids)-1);		 
			}
			$ids = trim($ids,",");
			
			if(mysqli_query($conexion,"INSERT INTO Comisiones() VALUES(null, '".$fecha_inicio."', '".$fecha_fin."', '".$ids."', 1, '".$notas."')")) {
				echo '
					Registro correcto.
					<script>
						$("[carga=comisiones]").trigger("click");
					</script>
				'; 
			}
			else{
				mysqli_error($conexion);
			}
		}
		if($_POST["accion"]=="deshabilitar"){
			if(mysqli_query($conexion, "UPDATE Comisiones SET status=0, notas=concat('<div style=\"position:absolute;top:75%;left:25%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', notas) WHERE id_comision=".$_POST["id_comision"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=comisiones]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		if($_POST["accion"]=="restaurar"){
			if(mysqli_query($conexion, "UPDATE Comisiones SET status=1, notas=replace(notas,'<div style=\"position:absolute;top:75%;left:25%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', '') WHERE id_comision=".$_POST["id_comision"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=comisiones]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		mysqli_close($conexion);
	}
}
else {
	header("Location: index.php");	
}
?>