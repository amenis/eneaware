<?php
    include 'conexion.php';
	$accion = $_POST["accion"];
    if($accion=="guardar"){
    	extract($_POST);
		$guardar = mysqli_query($conexion,"INSERT INTO `Lugares_practicantes`(institucion,telefono,domicilio,encargado,estado_pais,municipio,notas) VALUES ('".$institucion."','".$telefono."',
		'".$domicilio."','".$encargado."','".$estado."','".$municipio."','".$notas."')");
		
		
		if(!$guardar){
			echo mysqli_error($conexion);
		}
		else{
			echo 'REGISTRO GUARDADO EXITOSAMENTE';
			
			$id = mysqli_insert_id($conexion);
			$archivo= $_FILES['archivo'];
			$tempName = $archivo["tmp_name"];	
			$datosImg = explode(".", $_FILES["archivo"]["name"]);
			$extension = $datosImg[count($datosImg)-1];	
			$punto = "imagenes/lugares/".$id.".".$extension;
			copy($tempName,$punto);
			
			echo '<script>
				$("[carga=practicantes]").trigger("click");
			</script>';
		}
	
    }
	if($accion=="modificiar"){
		extract($_POST);
		
		$modificar = mysqli_query($conexion,"UPDATE Lugares_practicantes SET institucion='".$institucion."',telefono='".$telefono."',domicilio='".$domicilio."',
		encargado='".$encargado."' ,estado_pais='".$estado."',municipio='".$municipio."',notas='".$notas."' WHERE id_lugar = '".$id_lugar."'");
		
	
		
		if(!$modificar){
			echo mysqli_error($conexion);
		}
		else{				
			
			echo 'REGISTRO MODIFICADO';
				if(isset($_FILES["archivo"])){
				$datosImg = explode(".", $_FILES["archivo"]["name"]);
				$extension = $datosImg[count($datosImg)-1];
				copy($_FILES["archivo"]["tmp_name"], "imagenes/lugares/".$id_lugar.".".$extension);
				}
				
			echo '<script>
				$("[carga=practicantes]").trigger("click");
			</script>';
		}
		
		
		
	}
	
	if($accion=="borrar"){
		extract($_POST);
		$modificar = mysqli_query($conexion,"UPDATE Lugares_practicantes SET institucion='".$institucion."',telefono='".$telefono."',domicilio='".$domicilio."',
		encargado='".$encargado."' ,estado_pais='".$estado."',municipio='".$municipio."',notas='".$notas."' WHERE id_lugar =".$id_lugar);
		if(!$modificar){
			echo mysqli_error($conexion);
		}
		else{
			echo 'REGISTRO MODIFICADO';
		}
		
	}

	 if($accion=="guardarAlumno"){
	 	$Empezar = mysqli_query($conexion,"INSERT INTO Practicantes SET id_alumno = '".$_POST["alumno"]."', id_lugar = '".$_POST["lugar"]."', status=1 ;");
		echo "Lugar Asignado...";
		echo '<script>
						$("[carga=practicantes]").trigger("click");
				  </script>';
	 }
?>
