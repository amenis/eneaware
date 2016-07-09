<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][12]!="000"){

		include("conexion.php");

		$accion = $_POST["option"];
		$idal = "";
		$respuesta = "";
		$respuesta2 = "";
		$pregunta = "";
		
		//actuvar encuestas a alumnos
		
		if($accion=="activar"){//activar encuestas a alumnos
			$hoy = date("Y-m-d");
			$hora = date("H:i:s");
			$periodo = $_POST["periodo"];
			$comprobar = mysqli_query($conexion,"SELECT * FROM Encuestas_activadas WHERE id_alumno= '".$_POST["egresado"]."' AND periodo= '".$periodo."' ;");
			
			while($datos = mysqli_fetch_array($comprobar)){
					$e = $datos["periodo"];
			}

			if(isset($e)) {
				echo "La Alumna (o): ".$_POST["nombre"]." ya tiene esta encuesta habilitada...";
			} else {
				$delete= mysqli_query($conexion,"INSERT INTO Encuestas_activadas SET aplicador='".$_POST["aplicador"]."', id_alumno='".$_POST["egresado"]."', carrera='".$_POST["carrera"]."', fecha_inicio='".$hoy."', hora_inicio= '$hora', periodo=".$periodo.", status=1 ;");
				$Empezar = mysqli_query($conexion,"INSERT INTO Encuestas_progreso SET id_alumno = '".$_POST["egresado"]."', id_encuesta = '$periodo', id_seccion = 0, id_apartado = 0,fecha = '$hoy', hora = '$hora' ;");
				echo"Encuesta habilitada...";
				echo '<script>
							$("[carga=administrarEncuesta]").trigger("click");
							setTimeout(function(){$("[mostrar=Activar]").trigger("click")},1000);
					  </script>';
			}
		}
		if($accion=="activar2"){//activar encuestas a alumnos
			$hoy = date("Y-m-d");
			$hora = date("H:i:s");
			$periodo = $_POST["periodo"];

			for ($i=1; $i <=$_POST["res"] ; $i++) { 
				$comprobar = mysqli_query($conexion,"SELECT * FROM Encuestas_activadas WHERE id_alumno= '".$_POST["egresado".$i]."' AND periodo= '".$periodo."' ;");
			
				while($datos = mysqli_fetch_array($comprobar)){
						$e = $datos["periodo"];
				}

				if(isset($e)) {
					echo "La Alumnas (o): ".$_POST["nombre".$i]." ya tiene esta encuesta habilitada...<br>";
				} else {
					$delete= mysqli_query($conexion,"INSERT INTO Encuestas_activadas SET aplicador='".$_POST["aplicador"]."', id_alumno='".$_POST["egresado".$i]."', carrera='".$_POST["carrera"]."', fecha_inicio='".$hoy."', hora_inicio= '$hora', periodo=".$periodo.", status=1 ;");
					$Empezar = mysqli_query($conexion,"INSERT INTO Encuestas_progreso SET id_alumno = '".$_POST["egresado".$i]."', id_encuesta = '$periodo', id_seccion = 0, id_apartado = 0,fecha = '$hoy', hora = '$hora' ;");
					echo"Encuesta habilitada a ".$_POST["nombre".$i]."...<br>";
					echo '<script>
								$("[carga=administrarEncuesta]").trigger("click");
								setTimeout(function(){$("[mostrar=Activar]").trigger("click")},1000);
						  </script>';
				}
			}

		}
		
		if($accion=="borrar"){ //desactivar encuestas a alumnos
			$delete= mysqli_query($conexion,"UPDATE Encuestas_activadas set status='0' WHERE id_encuesta_activada=".$_POST['egresado']);
		echo"Encuesta desahabilitada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=encuestasDes]").trigger("click")},1000);
				</script>';
		}
		
		//fin
		
		//habilitar y deshabilitar encuestas
		
		if($accion=="reactivar"){ //reactivar encuestas a alumnos
			$delete= mysqli_query($conexion,"Update Encuestas_activadas set status='1' WHERE id_encuesta_activada=".$_POST['egresado']);
		echo"Encuesta habilitada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=encuestas]").trigger("click")},1000);
				</script>';
		}
		
		if($accion=="ha"){ //Dar de alta la encuesta
			$habilitar= mysqli_query($conexion,"Update Encuestas set status=1 WHERE id_encuesta=".$_POST['encuesta']);
		echo"La Encuesta se dio de Alta...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		if($accion=="de"){ //Dar de baja encuesta
			$desahabilitar= mysqli_query($conexion,"Update Encuestas set status=0 WHERE id_encuesta=".$_POST['encuesta']);
			echo"La encuesta se dio de Baja...";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				  </script>';
		}
		
		//fin
		
		//encuestas
		
		if($accion=="seccion"){ //add seccion
			$hoy = date("Y-m-d");
			$seccion= mysqli_query($conexion,"INSERT INTO Secciones SET id_encuesta='".$_POST["encuesta"]."', nombre_seccion='".$_POST["seccion"]."', nota='".$_POST["nota"]."', fecha='".$hoy."';");
			echo"Seccion guardada correctamente...";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		if($accion=="AddApa"){ //add apartado
			$hoy = date("Y-m-d");
			$apartado= mysqli_query($conexion,"INSERT INTO Apartados SET id_encuesta=".$_POST["encuesta"].", nombre_apartado='".$_POST["apartado"]."', fecha='".$hoy."';");
			echo"Apartado guardada correctamente...";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		
		if($accion=="apartado"){ //add pregunta a apartado
			$id="";
			$tipo = $_POST["tipo"];
			$sec = $_POST["encuesta"];
			$hoy = date("Y-m-d");
			
			
			if ($tipo=="Abierta") {
				//pregunta
				$pre= mysqli_query($conexion,"INSERT INTO Preguntas_apartado SET id_apartado=".$_POST["apartado"].", pregunta='".$_POST["pregunta"]."', fecha='".$hoy."';");
				//fin
				
				//respuesta
				$sql2 = "SELECT MAX(id_pregunta_apartado) as id FROM Preguntas_apartado"; 
				$req2 = 	mysqli_query($conexion,$sql2);
				while($result = mysqli_fetch_array($req2)){
					$id = trim($result[0]);
				}
				$res= mysqli_query($conexion,"INSERT INTO Respuestas_apartado SET id_pregunta_apartado=".$id.", tipo_respuesta='$tipo', opciones='abierta', fecha='".$hoy."';");
				//fin
				
			} 
			if ($tipo=="Por opciones") {		
				 //pregunta
				$pre= mysqli_query($conexion,"INSERT INTO Preguntas_apartado SET id_apartado=".$_POST["apartado"].", pregunta='".$_POST["pregunta"]."', fecha='".$hoy."';");
				//fin
					
				foreach($_POST as $nombre_campo => $valor){ 
					   for ($i=1; $i < 11 ; $i++) { 
						   if($nombre_campo=="op".$i){
						   	$respuesta=$valor;
								//respuesta
								$sql2 = "SELECT MAX(id_pregunta_apartado) as id FROM Preguntas_apartado"; 
								$req2 = 	mysqli_query($conexion,$sql2);
								while($result2 = mysqli_fetch_row($req2)){
									$idr = trim($result2[0]);
								}
								$res= mysqli_query($conexion,"INSERT INTO Respuestas_apartado SET id_pregunta_apartado=".$idr.", tipo_respuesta='$tipo', opciones='$respuesta', fecha='".$hoy."';");
								//fin
						   }
						}
					    for ($i=0; $i <=4 ; $i++) { 
						   if($nombre_campo=="OpOt".$i){
						   	$respuesta2=$valor; 
								//respuesta
								$sql3 = "SELECT MAX(id_pregunta_apartado) as id FROM Preguntas_apartado"; 
								$req3 = 	mysqli_query($conexion,$sql3);
								while($result3 = mysqli_fetch_row($req3)){
									$ido = trim($result3[0]);
								}
								$otro= mysqli_query($conexion,"INSERT INTO Respuestas_apartado SET id_pregunta_apartado=".$ido.", tipo_respuesta='$tipo | otro', opciones='$respuesta2', fecha='".$hoy."';");
								//fin
							}
						}
				}
			}
			echo"Apartado guardada correctamente...";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		
		
		if($accion=="pregunta"){ //add pregunta
			$id="";
			$tipo = $_POST["tipo"];
			$sec = $_POST["encuesta"];
			$hoy = date("Y-m-d");
			
			
			
			if ($tipo=="Abierta") {
				//pregunta
				$pre= mysqli_query($conexion,"INSERT INTO Preguntas SET id_encuesta=".$_POST["encuesta"].", id_seccion=".$_POST["seccion"].", pregunta='".$_POST["pregunta"]."', fecha='".$hoy."';");
				//fin
				
				//respuesta
				$sql2 = "SELECT MAX(id_pregunta) as id FROM Preguntas"; 
				$req2 = 	mysqli_query($conexion,$sql2);
				while($result = mysqli_fetch_array($req2)){
					$id = trim($result[0]);
				}
				$res= mysqli_query($conexion,"INSERT INTO Respuestas SET id_pregunta=".$id.", tipo_respuesta='$tipo', opciones='abierta', fecha='".$hoy."';");
				//fin
				
			} 
			if ($tipo=="Poropciones") {		
				 //pregunta
				$pre= mysqli_query($conexion,"INSERT INTO Preguntas SET id_encuesta=".$_POST["encuesta"].", id_seccion=".$_POST["seccion"].", pregunta='".$_POST["pregunta"]."', fecha='".$hoy."';");
				//fin
					
				foreach($_POST as $nombre_campo => $valor){ 
					   for ($i=1; $i < 11 ; $i++) { 
						   if($nombre_campo=="op".$i){
						   	$respuesta=$valor;
								//respuesta
								$sql2 = "SELECT MAX(id_pregunta) as id FROM Preguntas"; 
								$req2 = 	mysqli_query($conexion,$sql2);
								while($result2 = mysqli_fetch_row($req2)){
									$idr = trim($result2[0]);
								}
								$res= mysqli_query($conexion,"INSERT INTO Respuestas SET id_pregunta=".$idr.", tipo_respuesta='$tipo', opciones='$respuesta', fecha='".$hoy."';");
								//fin
						   }
						}
					    for ($i=0; $i <=4 ; $i++) { 
						   if($nombre_campo=="OpOt".$i){
						   	$respuesta2=$valor; 
								//respuesta
								$sql3 = "SELECT MAX(id_pregunta) as id FROM Preguntas"; 
								$req3 = 	mysqli_query($conexion,$sql3);
								while($result3 = mysqli_fetch_row($req3)){
									$ido = trim($result3[0]);
								}
								$otro= mysqli_query($conexion,"INSERT INTO Respuestas SET id_pregunta=".$ido.", tipo_respuesta='$tipo | otro', opciones='$respuesta2', fecha='".$hoy."';");
								//fin
							}
						}
				}
			}
			echo"Pregunta guardada correctamente...";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		//fin

		//guardar encuesta
		
		if($accion=="Add"){ 
			$hoy = date("Y-m-d");
			$add= mysqli_query($conexion,"INSERT INTO Encuestas SET nombre_encuesta='".$_POST["nombre"]."', periodo='".$_POST["periodo"]."', fecha='".$hoy."', activada_por='".$_POST["aplicador"]."', status=0 ;");
			echo "Encuesta Creada Exitotamente....";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		
		//fin
		
		//editar
		
		if($accion=="EditEn"){ //editar encuesta
			$EditarEn= mysqli_query($conexion,"Update Encuestas set nombre_encuesta='".$_POST["Uencuesta"]."' WHERE id_encuesta=".$_POST['encuesta']);
		echo"Nombre cambiado...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		
		if($accion=="EditSec"){ //editar Seccion
			$EditarSec= mysqli_query($conexion,"Update Secciones set nombre_seccion='".$_POST["Usec"]."' WHERE id_seccion=".$_POST['encuesta']);
		echo"Seccion modificada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		if($accion=="EditAp"){ //editar apartado
			$EditarSec= mysqli_query($conexion,"Update Apartados set nombre_apartado='".$_POST["Uap"]."' WHERE id_apartado=".$_POST['encuesta']);
		echo"Apartado modificado...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		
		if($accion=="EditPre"){ //editar pregunta
		$cont = $_POST["op"];
		if ($_POST["tipo_respuesta"]=="Abierta") {
			$EditarPre= mysqli_query($conexion,"Update Preguntas set pregunta='".$_POST["preM"]."' WHERE id_pregunta=".$_POST['pregunta']);
		} 
		else {
			$EditarPre= mysqli_query($conexion,"Update Preguntas set pregunta='".$_POST["preM"]."' WHERE id_pregunta=".$_POST['pregunta']);
			
			for ($i=1; $i <= $cont ; $i++) { 		   
				$EditarRes= mysqli_query($conexion,"Update Respuestas set opciones='".$_POST["resM".$i]."' WHERE id_respuesta='".$_POST["id".$i]."' AND id_pregunta=".$_POST['pregunta'].";");				
			}
				
		}
		echo"Pregunta modificada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		//fin

		if($accion=="EditPreAp"){ //editar pregunta
		$cont = $_POST["op"];
		if ($_POST["tipo_respuesta"]=="Abierta") {
			$EditarPre= mysqli_query($conexion,"Update Preguntas_apartado set pregunta='".$_POST["preM"]."' WHERE id_pregunta_apartado=".$_POST['pregunta']);
		} 
		else {
			$EditarPre= mysqli_query($conexion,"Update Preguntas_apartado set pregunta='".$_POST["preM"]."' WHERE id_pregunta_apartado=".$_POST['pregunta']);
			
			for ($i=1; $i <= $cont ; $i++) { 		   
				$EditarRes= mysqli_query($conexion,"Update Respuestas_apartado set opciones='".$_POST["resM".$i]."' WHERE id_respuesta_apartado='".$_POST["id".$i]."' AND id_pregunta_apartado=".$_POST['pregunta'].";");				
			}
				
		}
		echo"Pregunta modificada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}
		//fin

		if($accion=="capasidad"){ //agregar preguntas de capasidad
		
		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

			$res= mysqli_query($conexion,"INSERT INTO Capasidades_encuesta SET id_encuesta=".$_POST["encuesta"].",capasidad='".$_POST["capasidad"]."', fecha='".$hoy."',hora='".$hora."';");
								
			echo"Capasidad Agreada exitosamente...";
			
			echo '<script>
						$("[carga=administrarEncuesta]").trigger("click");
						setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
					</script>';
		}
		//fin
		if($accion=="capasidadPre"){ //agregar preguntas a capasidad
		
		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

			$res= mysqli_query($conexion,"INSERT INTO Preguntas_capasidades SET id_encuesta=".$_POST["encuesta"].",pregunta='".$_POST["capasidad"]."',opcion1='".$_POST["op1"]."',opcion2='".$_POST["op2"]."',opcion3='".$_POST["op3"]."',opcion4='".$_POST["op4"]."' ,fecha='".$hoy."',hora='".$hora."';");
								
			echo"Pregunta Agreada exitosamente...";
			
			echo '<script>
						$("[carga=administrarEncuesta]").trigger("click");
						setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
					</script>';
		}
		//fin

		if($accion=="EditarCopetencia"){ //Editar copetencia
		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

		$delete= mysqli_query($conexion,"Update Capasidades_encuesta SET capasidad='".$_POST["capasidad"]."', fecha='".$hoy."',hora='".$hora."' WHERE id_capasidad = ".$_POST["id"].";");
		echo"Capasidad modificada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		if($accion=="EditarPreCopetencia"){ //Editar pregunta copetencia
		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

		$delete= mysqli_query($conexion,"Update Preguntas_capasidades SET pregunta='".$_POST["capasidad"]."',opcion1='".$_POST["op1"]."',opcion2='".$_POST["op2"]."',opcion3='".$_POST["op3"]."',opcion4='".$_POST["op4"]."' ,fecha='".$hoy."',hora='".$hora."' WHERE id_pregunta_capasidad = ".$_POST["id"].";");
		echo"Pregunta modificada...";
		
		echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=ConEn]").trigger("click")},1000);
				</script>';
		}

		if($accion=="folio"){ //generar folio
		$a = date("Y");
		$m = date("m");
		$d = date("d");
		$id = $_POST["alumno"];
		$en = $_POST["encuesta"];
		$Folio = $a.$m.$en.$id;
		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

			$guardarFinal = mysqli_query($conexion,"Update Encuestas_activadas set fecha_fin='".$hoy."', hora_fin= '$hora', status_llenado='2' WHERE id_alumno=".$id." AND periodo= ".$en." ;");
			$guardarFolio = mysqli_query($conexion,"INSERT INTO Folio_encuesta SET id_alumno= ".$id.", id_encuesta= ".$en.", folio=".$Folio." ;");
			echo "Encuesta envida exitosamente con No. de folio: <font color='red' weight='bold'>".$Folio."</font>";
			echo '<script>
					$("[carga=administrarEncuesta]").trigger("click");
					setTimeout(function(){$("[mostrar=encuestas]").trigger("click")},1000);
				</script>';
		}

	}
}
else {
	header("Location: index.php");	
}
?>