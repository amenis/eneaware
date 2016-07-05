<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.tablePagination.js"></script>
<?php
session_start();
	if(isset($_SESSION["Usuario_Eneaware"])){
				
		if($_SESSION["Permisos_Eneaware"][22]!="000"){
			include('conexion.php');
			$accion = $_POST["option"];	

			if($accion=="fin"){
				echo 'Proceso terminado...
					<script>
						$("[carga=subir]").trigger("click");
						setTimeout(function(){$("[mostrar=subir]").trigger("click")},1000);
					</script>
					';
			}
		}
		if($_SESSION["Permisos_Eneaware"][11]!="000"){
			include('conexion.php');
			$accion = $_POST["option"];	

			if($accion=="doce"){
				echo'
				<hr></hr>
				<table>
					<tr>
						<td>Plan de Estudios:</td><td>';
						$pro= mysqli_query($conexion,"SELECT * FROM Planes_estudios WHERE status=1;");
						$numpro = mysqli_num_rows($pro);
						echo"<select id='plan' name='plan' disabled ><option value='0'>Eliga el plan de estudios...</option>
						";
						if($numpro>0){
							for($x=0;$x<$numpro;$x++){
								$datospro = mysqli_fetch_array($pro);
								echo"<option value='".$datospro["id_plan"]."'>". $datospro["nombre"]." - ". $datospro["carrera"]."</option>";
							}
						}
						echo'</select>
						<script>
							var opciones = $("#plan").find("option");
							opciones.each(function(){
								if($(this).val()=="'.$_POST["plan"].'"){
									$(this).prop("selected",true);
									return false;
								}
							});
						</script></td>
						<td>Semestre:</td><td>
						<select id="semestre"  name="semestre" disabled>
							<option value="1">1ro</option>
							<option value="2">2do</option>
							<option value="3">3ro</option>
							<option value="4">4to</option>
							<option value="5">5to</option>
							<option value="6">6to</option>
							<option value="7">7mo</option>
							<option value="8">8vo</option>
						</select>
						<script>
							var opciones = $("#semestre").find("option");
							opciones.each(function(){
								if($(this).val()=="'.$_POST["semestre"].'"){
									$(this).prop("selected",true);
									return false;
								}
							});
						</script></td>
					</tr>
				</table><br>
				<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
				<input type="hidden" name="option" value="doce">

				<table>
					<tr><td>Docente:</td><td>';
					$pro= mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE funcion='docente';");
					$numpro = mysqli_num_rows($pro);
					echo"<select name='docente' required ><option value='na'>Eliga al docente</option>
					";
					if($numpro>0){
						for($x=0;$x<$numpro;$x++){
							$datospro = mysqli_fetch_array($pro);
							echo"<option value='".$datospro["id_usuario"]."'>". $datospro["nombre"]."</option>";
						}
					}
					echo'</select></td></tr>
					<tr><td>Materia:</td><td>';
					$pro= mysqli_query($conexion,"SELECT * FROM Materias WHERE plan_estudios=".$_POST["plan"]." AND semestre=".$_POST["semestre"]." AND status=1;");
					$numpro = mysqli_num_rows($pro);
					echo"<select name='materia' required ><option value='0'>Eliga el agsinatura...</option>
					";
					if($numpro>0){
						for($x=0;$x<$numpro;$x++){
							$datospro = mysqli_fetch_array($pro);
							echo"<option value='".$datospro["id_materia"]."'>". $datospro["clave"]." - ". $datospro["materia"]."</option>";
						}
					}
					echo'</select></td></tr>
					<tr><td>En el periodo:</td><td><input name="periodo" type="text"  placeholder="Febrero 2016 - Junio 2016" required /></td></tr>
				</table><br>
				<center><button>Agsinar</button></center><br>
				</form>
				';
			}
		}

	}	

	function CalculaEdad( $fecha ) {
    	list($Y,$m,$d) = explode("-",$fecha);
    	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
?>

