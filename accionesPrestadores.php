<?php
session_start();
  if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][9]!="000"){
		include("conexion.php");
		if($_POST['accion']=="registrar"){
			extract($_POST);
			$registrar = mysqli_query($conexion,"INSERT INTO Prestadores_servicios() VALUES (null,'".$nombre."','".$institucion."','".$inicio."','".$term."',1,'".$telefono."','".$email."','".$notas."')");
			if($registrar){
				echo'Registro Correcto
					<script>
						$("[carga=prestadores]").trigger("click");
						setTimeout(function(){$("[mostrar=registroPres]").trigger("click")},1000);
					</script>
				';
			}
			
		}
		if($_POST['accion']=="modificar"){
			extract($_POST);
			$modificar=mysqli_query($conexion,"UPDATE Prestadores_servicios SET nombre='".$nombre."',institucion='".$institucion."',fecha_inicio='".$inicio."',fecha_final='".$term."',telefono='".$telefono."',email='".$email."',notas='".$notas."' WHERE id_prestador=".$id." ");
			if($modificar){
				echo'Registro Modificado
					<script>
						$("[carga=prestadores]").trigger("click");
						setTimeout(function(){$("[mostrar=modificar]").trigger("click")},1000);
					</script>
				';
			}
		
		}
		if($_POST['accion']=="eliminar"){
			extract($_POST);
			$modificar = mysqli_query($conexion,"UPDATE Prestadores_servicios SET status=0 WHERE id_prestador=".$id."");
			if($modificar){
				echo'
					Registro en Baja
					<script>
						$("[carga=prestadores]").trigger("click");
						setTimeout(function(){$("[mostrar=modificar]")},1000);
					</script>
				';
			}
			
		}
		if($_POST['accion']=="restaurar"){
			extract($_POST);
			$restaurar = mysqli_query($conexion,"UPDATE Prestadores_servicios SET status=1 WHERE id_prestador=".$id." ");
			if($restaurar){
				echo'
					Registro Restaurado
					<script>
						$("[carga=prestadores]").trigger("click");
						setTimeout(function(){$("[mostrar=RegBaja]")},1000);
					</script>
				';
			}
			else{
				echo mysqli_error($conexion);
			}
		}

	}
}
	
?>