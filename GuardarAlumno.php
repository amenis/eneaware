<?php
	include('conexion.php');
	$accion = $_POST["option"];
	
	if($accion=="reg"){
		/*$Alumnos=mysqli_query($conexion,'INSERT INTO Alumnos(matricula, curp, nombre, fecha_nacimiento, tutor, domicilio_tutor, fecha_ingreso, tel_casa, 
		tel_celular, email,calle_local, num_ext_local, num_int_local, colonia_local, municipio_local, estado_local, cp_local, calle_foranea, num_ext_foranea, 
		num_int_foranea, colonia_foranea, municipio_foranea, estado_foranea, cp_foranea, padre, dom_padre, madre, dom_madre, nombre_emergecia, domicilio_emergencia, 
		tel_emergencia, tipo_sangre, sexo,beca, status, semestre, carrera, notas, fecha_termino, bachillerato, dictamen_titulacion) VALUES ("'.$_POST['matricula'].'","'.$_POST['curp'].'",
		"'.$_POST['nombre'].'",
		"'.$_POST['fechaN'].'","'.$_POST['tutor'].'","'.$_POST['domTu'].'","'.$_POST['inside'].'","'.$_POST['telCasa'].'","'.$_POST['telCel'].'","'.$_POST['email'].'","'.$_POST['dom'].'",
		"'.$_POST['NumExt'].'","'.$_POST['NumInt'].'","'.$_POST['colonia'].'","'.$_POST['municipio'].'","'.$_POST['estado'].'","'.$_POST['cp'].'",
		"'.$_POST['calleF'].'","'.$_POST['NumExtF'].'","'.$_POST['NumIntF'].'","'.$_POST['coloniaF'].'","'.$_POST['municipioF'].'","'.$_POST['estadoF'].'","'.$_POST['cpF'].'",
		"'.$_POST['padre'].'","'.$_POST['DomPa'].'","'.$_POST['madre'].'","'.$_POST['DomMa'].'","'.$_POST['emerg'].'","'.$_POST['domEme'].'",
		"'.$_POST['telEme'].'","'.$_POST['tipSan'].'","'.$_POST['sexo'].'","'.$_POST['beca'].'","1","'.$_POST['semestre'].'","'.$_POST['carrera'].'",
		"'.$_POST['notas'].'","'.$_POST['term'].'","'.$_POST['bachi'].'","'.$_POST['dict'].'")');
		echo'REGISTRO CREADO';
		
		$id = mysqli_insert_id($conexion);
		$archivo= $_FILES['archivo'];
		$tempName = $archivo["tmp_name"];	
		$datosImg = explode(".", $_FILES["archivo"]["name"]);
		$extension = $datosImg[count($datosImg)-1];	
		$punto = "imagenes/alumnos/".$id.".".$extension;
		copy($tempName,$punto);
		
		echo '<script>
				$("[carga=alumnos]").trigger("click");
			</script>';*/
	}
	if($accion=="modificar"){
		$ModAl=mysqli_query($conexion,'UPDATE alumnos SET matricula="'.$_POST['matricula'].'",curp="'.$_POST['curp'].'",nombre="'.$_POST['nombre'].'",fecha_nacimiento="'.$_POST['fechaN'].'",
		tutor="'.$_POST['tutor'].'",domicilio_tutor="'.$_POST['domTu'].'",fecha_ingreso="'.$_POST['inside'].'",tel_casa="'.$_POST['telCasa'].'",tel_celular="'.$_POST['telCel'].'",email="'.$_POST['email'].'",
		calle_local="'.$_POST['dom'].'",num_ext_local="'.$_POST['NumExt'].'",num_int_local="'.$_POST['NumInt'].'",colonia_local="'.$_POST['colonia'].'",municipio_local="'.$_POST['municipio'].'",
		estado_local="'.$_POST['estado'].'",cp_local="'.$_POST['cp'].'",calle_foranea="'.$_POST['calleF'].'",num_ext_foranea="'.$_POST['NumExtF'].'",
		num_int_foranea="'.$_POST['NumIntF'].'",colonia_foranea="'.$_POST['coloniaF'].'",municipio_foranea="'.$_POST['municipioF'].'",estado_foranea="'.$_POST['estadoF'].'",
		cp_foranea="'.$_POST['cpF'].'",padre="'.$_POST['padre'].'",dom_padre="'.$_POST['DomPa'].'",madre="'.$_POST['madre'].'",dom_madre="'.$_POST['DomMa'].'",nombre_emergecia="'.$_POST['emerg'].'",
		domicilio_emergencia="'.$_POST['domEme'].'",tel_emergencia="'.$_POST['telEme'].'",tipo_sangre="'.$_POST['tipSan'].'",sexo="'.$_POST['sexo'].'",beca="'.$_POST['beca'].'",
		semestre="'.$_POST['semestre'].'",carrera="'.$_POST['carrera'].'",notas="'.$_POST['notas'].'",fecha_termino="'.$_POST['term'].'",bachillerato="'.$_POST['bachi'].'",dictamen_titulacion="'.$_POST['dict'].'"  WHERE id_alumno='.$_POST['id'].'');
		echo 'Registro Modificado';
		
		$archivo= $_FILES['archivo'];
		$tempName = $archivo["tmp_name"];	
		$datosImg = explode(".", $_FILES["archivo"]["name"]);
		$extension = $datosImg[count($datosImg)-1];	
		$punto = "imagenes/alumnos/".$_POST['id'].".".$extension;
		copy($tempName,$punto);
		
		echo '<script>
				$("[carga=alumnos]").trigger("click");
			</script>';
	}
	if($accion=="borrar"){
		$delete= mysqli_query($conexion,"Update alumnos set status='0' WHERE id_alumno=".$_POST['alumno']);
	echo"REGISTRO DESHABILITADO";
	
	echo '<script>
				$("[carga=alumnos]").trigger("click");
				settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
			</script>';
	}
	if($accion=="restaurar"){
		$delete= mysqli_query($conexion,"Update alumnos set status='1' WHERE id_alumno=".$_POST['id_alumno']);
	echo"REGISTRO HABILITADO";
	
	echo '<script>
				$("[carga=alumnos]").trigger("click");
				settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
			</script>';
	}
	echo mysqli_error($conexion);
	
	mysqli_close($conexion);
	
?>