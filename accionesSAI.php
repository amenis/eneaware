<?php
	include('conexion.php');
	$accion = $_POST["option"];

	if($accion=="recetear"){ //Cambio de contraseña

		$cu = md5($_POST["cu"]);
		$cambio = mysqli_query($conexion,"UPDATE Sai set password='".$cu."' WHERE id_alumno=".$_POST["id"]." ;");
		echo "Contraseña receteada";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="plan"){ //Agregar plan de estudios

		$plan= mysqli_query($conexion,"INSERT INTO Planes_estudios SET nombre='".$_POST["nombre"]."', anio='".$_POST["ano"]."', carrera='".$_POST["carrera"]."', status=1 ;");
						
		echo "Plan de Estudios Agregado correctamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="asig"){ //Agregar asignatura

		$Asig= mysqli_query($conexion,"INSERT INTO Materias SET clave='".$_POST["clave"]."', materia='".$_POST["asig"]."', semestre='".$_POST["semestre"]."', carrera='".$_POST["carrera"]."', plan_estudios='".$_POST["plan"]."', status=1 ;");
		
		echo "Asignatura agregada exitosamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="doce"){ //Asignar materias docentes

		$comprobar = mysqli_query($conexion,"SELECT * FROM Agsi_materia_doce WHERE id_docente= '".$_POST["docente"]."' AND id_materia='".$_POST["materia"]."' AND periodo= '".$_POST["periodo"]."' ;");
			
			while($datos = mysqli_fetch_array($comprobar)){
					$e = $datos["id_docente"];
			}

			if(isset($e)) {
				echo "La docente ya tiene esta asignatura asignada...";
			} else {

				$doce= mysqli_query($conexion,"INSERT INTO Agsi_materia_doce SET id_docente='".$_POST["docente"]."', id_materia='".$_POST["materia"]."', periodo='".$_POST["periodo"]."', status=1 ;");
				
				echo "Asignatura asignada exitosamente...";
				echo '<script>
							$("[carga=seguimiento]").trigger("click");
							setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
						</script>';
			}
		
	}

	if($accion=="bajaAsig"){ //dar de baja asignatura

		$delete= mysqli_query($conexion,"UPDATE Materias set status='0' WHERE id_materia=".$_POST['materia']);
		
		echo "Asignatura dada de baja exitosamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="bajaPln"){ //dar de baja plan de estudios

		$delete= mysqli_query($conexion,"UPDATE Planes_estudios set status='0' WHERE id_plan=".$_POST['plan']);
		
		$comprobar = mysqli_query($conexion,"SELECT * FROM Materias WHERE plan_estudios=".$_POST['plan']." ;");
		$num = mysqli_num_rows($comprobar);	

			$cont = 1;
			while($datos = mysqli_fetch_array($comprobar)){
					$id[$cont] = $datos["id_materia"];
					$cont++;
			}

			for ($i=1; $i <= $num ; $i++) { 
				$delete= mysqli_query($conexion,"UPDATE Materias set status='0' WHERE id_materia=".$id[$i]);
			}

		echo "Plan de estudios dado de baja exitosamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="cal"){ //periodo para subir califiucaciones

		$hoy = date("H:i:s");
		$Asig= mysqli_query($conexion,"UPDATE Evaluacion SET de_fecha='".$_POST["de"]."', de_hora='".$hoy."', a_fecha='".$_POST["a"]."', a_hora='".$hoy."', tipo_evaluacion=".$_POST["tipo"]." WHERE id_evaluacion=1;");
		
		echo "Periodo de Evaluacion creado exitosamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	if($accion=="sem"){ //Agregar SEMESTRE

		$hoy = date("Y-m-d");
		$hora = date("H:i:s");

		$plan= mysqli_query($conexion,"INSERT INTO Ciclos SET ciclo='".$_POST["ciclo"]."', periodo='".$_POST["tipo"]."', fecha='".$hoy."', hora='".$hora."' ;");
						
		echo "Semestre Agregado correctamente...";
		echo '<script>
					$("[carga=seguimiento]").trigger("click");
					setTimeout(function(){$("[mostrar=Sai]").trigger("click")},1000);
				</script>';
		
	}

	
?>