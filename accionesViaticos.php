<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][1]!="000"){
		include("conexion.php");
		if($_POST["accion"]=="registro"){
			$idU = 0;
			$total = 0;
			$idV =0;
			$arrDin = array();
			$correcto = true;
			extract($_POST);
			foreach($_POST as $name => $valor){
				if($name!="accion" && $name!="id_comision"){
					if(substr($name,0,3)=="idU") {
						$idU = $valor;
						if(mysqli_query($conexion, "INSERT INTO Viaticos() VALUES(null, ".$_POST['id_comision'].", ".$totalDV.", ".$idU.", '".date('Y-m-d')."', '".$viatic."', 1)")){
							$idV = mysqli_insert_id($conexion);
							if(mysqli_query($conexion, "INSERT INTO Detalle_viaticos() VALUES(null, ".$idV.",'".$detalleV."')")){
                               $correcto=true;
                            }
						}				
					}					
				}
			}
			if($correcto){
				echo'
					Registro correcto
					<script>
						$("[carga=viaticos]").trigger("click");
					</script>
				';
			}
			
		}
		if($_POST["accion"]=="modificar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Claves SET id_usuario=".$id_usuario.", categoria='".$categoria."', horas='".$horas."', plaza='".$plaza."', fecha_modificacion='".date("Y-m-d")."', puesto='".$puesto."' WHERE id_clave=".$_POST["id_clave"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		if($_POST["accion"]=="deshabilitar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Viaticos SET status=0,  notas=concat('<div style=\"position:relative;top:15%;left:10%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', notas) WHERE num_comision=".$_POST["id_comision"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=viaticos]").trigger("click");
						setTimeout(function(){$("[mostrar=modificarViaticos]")},500);
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		if($_POST["accion"]=="restaurar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Viaticos SET status=1, notas=replace(notas,'<div style=\"position:relative;top:15%;left:10%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', '') WHERE num_comision=".$_POST["id_comision"])){
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=claves]").trigger("click");
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