<script src="js/printThis.js"></script>
<script src="js/jquery.tablePagination.js" ></script>
<style>
	
</style>
<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][6]!="000"){
		include("conexion.php");

		if($_POST['accion']=="new"){
			extract($_POST);
			$mes="";
			$mes2="";

			$regInci = mysqli_query($conexion,"SELECT MAX(id_incidencia) FROM Insidencias");
			$id= @mysqli_fetch_row($conexion);
			mysqli_free_result($regInci);
			
			if($regInci){
				$incid = mysqli_query($conexion,"SELECT * FROM Insidencias WHERE id_incidencia=".($id[0]+1)." AND personal='".$_SESSION['id_usuario']."' ");
				$datosInc = @mysqli_fetch_array($incid);
				
				if($datosInc!=0){

					$mes=explode('-',$fechaIni);
					$mes= $mes[count($mes)-2]."-".$mes[0];
					$mes2 = explode('-',$datosInc['fecha_inicio']);
                    $mes2= $mes2[count($mes2)-2]."-".$mes2[0];

					if($mes==$mes2){
						echo 'El periodo inidicado ya se encuentra en uso favor de indicar un nuevo periodo o continuar 
							  <br/><button onclick="$(\'[carga=incidencias]\').trigger(\'click\')">Ok</button>';
					}
					else{

						$existe = mysqli_query($conexion,"SELECT * FROM Acciones_incidencia WHERE periodo='".$fechaIni."--".$fechaFinal."' WHERE status=1");
						$cant = @mysqli_num_rows($existe);
						if($cant>0){
							echo'<script>$(".formularioInci").show();</script>';							
						}
						else{
							$accionesI = mysqli_query($conexion,"INSERT INTO Acciones_incidencia() VALUE(null,'".date('Y-m-d')."','','".$fechaIni."-".$fechaFinal."', 1)");	
							if($accionesI){
								echo'<script>$(".formularioInci").show();</script>';
							}	
							else{
								echo mysqli_error($conexion);
							}
						}
						
						
					}
				}
				
				else{
					$existe = mysqli_query($conexion,"SELECT * FROM Acciones_incidencia WHERE periodo='".$fechaIni."--".$fechaFinal."' WHERE status=1");
						$cant = @mysqli_num_rows($existe);
						if($cant>0){
							echo'<script>$(".formularioInci").show();</script>';							
						}
						else{
							$accionesI = mysqli_query($conexion,"INSERT INTO Acciones_incidencia() VALUE(null,'".date('Y-m-d')."','','".$fechaIni."-".$fechaFinal."',1)");	
							if($accionesI){
								echo'<script>$(".formularioInci").show();</script>';
							}	
							else{
								echo mysqli_error($conexion);
							}
						}
					
				}
			}
			
			echo'
				<div class="formularioInci" style="display:none">
					<h2>Registro de Incidencias</h2>
					<form action="accionesIncidencias.php" destino="resultadoRegistro" >
						<input type="hidden" name="accion" value="registro">
						<input type="hidden" name="fechaIni" value="'.$fechaIni.'">
						<input type="hidden" name="fechaFinal" value="'.$fechaFinal.'">	
						<input type="hidden" name="funcion" value="nuevo">	
						<fieldset style="width:80%;">
						 <legend style=" border:2px solid #009ec3;">Datos Incidencia</legend>
						 <label for="fecha" style="position:relative;left:70%;" >Fecha: </label><input id="fecha"  style="position:relative;left:70%;"  type="date" name="fecha" value="'.date('Y-m-d').'">
						 <br/><br/>

						 <label for="maestro">Personal Docente</label>';
						 $maestro = mysqli_query($conexion,"SELECT id_usuario,apellidoP,apellidoM,nombre FROM Usuarios WHERE status=1");
								$cant=0;
								$dataCant = mysqli_num_rows($maestro);
								echo'<select id="maestro" name="maestro"  onchange="$(\'#horarios option\').hide();var id=$(this).find(\'option:selected\').val();$(\'#horarios option.\'+id).show();">
										<option>Selecciona...</option>';
								while($cant < $dataCant){
									$dataMaestro = @mysqli_fetch_assoc($maestro);
									echo'<option value="'.$dataMaestro['id_usuario'].'">'.$dataMaestro['apellidoP'].' '.$dataMaestro['apellidoM'].' '.$dataMaestro['nombre'].'</option>';
									$cant++;
								}
								echo'</select>';
								mysqli_free_result($maestro);
						echo'<label for="horarios"  style="padding-left:20px">Horario</label>';
						$horaios = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE status=1");
									$cant=0;
									$cantHorarios= mysqli_num_rows($horaios);	
									echo'<select  id="horarios" name="horario"required>
										<option>Selecciona el horario..</option>';					
									while($cant < $cantHorarios){
										$dataHorario= @mysqli_fetch_assoc($horaios);
										echo'<option class="'.$dataHorario['id_usuario'].'"  value="'.$dataHorario['id_horario_gral'].'">'.$dataHorario['hora_inicio'].' - '.$dataHorario['hora_fin'].'</option>';
										
										$cant++;
									}
									echo'</select>';
									mysqli_free_result($horaios);

					echo'
						<br/><br/>
						<label for="motivo">Motivo</label>
						<select id="motivo" name="motivo">
							<option>Selecciona un motivo..</option>
							<option>Retardo</option>
							<option>Comision</option>
							<option>No_se_Presento</option>
							<option>Cita_Medica</option>
							<option>Enfermedad</option>
							<option>otro</option>								
						</select>
						<label for="actividad" style="padding-left:20px">Actividad</label>
						<select name="actividad">
							<option> Selecciona una Actividad..</option>
							<option>Clase</option>
							<option>Asesoria</option>
							<option>Investigacion</option>
							<option>Tutoria</option>
							<option>Otro</option>
						</select>
						<br/></br>
						<label>Observaciones</label><br/>
						<textArea name="notas" rows="5" cols="80"></textArea>
						<br/><center><button>Agregar</button></center>
					</fieldset>
						<br/>
					</form>
					<div id="nuevos">
						
					</div>	
				</div>';			
			
		}



		if($_POST['accion']=="continuar"){
			extract($_POST);
			$Period = explode('--',$periodo);
			$fechaIni= $Period[0];
			$fechaFinal = $Period[1];
			
			echo'
					<img src="imagenes/checkmark.png" style="position:absolute;left:30%;top:0;" onclick="$(this).next().toggle(\'drop\');"/>
					<form action="accionesIncidencias.php" destino="resultadoRegistro" style="display:none">
						<input type="hidden" name="accion" value="finalizar">
						<input type="hidden" name="periodo" value="'.$fechaIni.'-'.$fechaFinal.'">
						Deseas Finalizar el periodo
						<button>Si</button>
						<button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
					</form>

					<br><br>
				<form id="formu" action="accionesIncidencias.php" destino="resultadoRegistro">
					<input type="hidden" name="accion" value="registro">	
					<input type="hidden" name="fechaIni" value="'.$fechaIni.'">
					<input type="hidden" name="fechaFinal" value="'.$fechaFinal.'">	
					<input type="hidden" name="funcion" value="continuar">	
					<fieldset style="width:80%;">
						 <legend style=" border:2px solid #009ec3;">Datos Incidencia</legend>
						 <label for="fecha" style="position:relative;left:70%;" >Fecha: </label><input id="fecha"  style="position:relative;left:70%;"  type="date" name="fecha" value="'.date('Y-m-d').'">
						 <br/><br/>

						 <label for="maestro">Personal Docente</label>';
						 $maestro = mysqli_query($conexion,"SELECT id_usuario,apellidoP,apellidoM,nombre FROM Usuarios WHERE status=1");
								$cant=0;
								$dataCant = mysqli_num_rows($maestro);
								echo'<select id="maestro" name="maestro"  onchange="$(\'#horarios option\').hide();var id=$(this).find(\'option:selected\').val();$(\'#horarios option.\'+id).show();">
										<option>Selecciona...</option>';
								while($cant < $dataCant){
									$dataMaestro = @mysqli_fetch_assoc($maestro);
									echo'<option value="'.$dataMaestro['id_usuario'].'">'.$dataMaestro['apellidoP'].' '.$dataMaestro['apellidoM'].' '.$dataMaestro['nombre'].'</option>';
									$cant++;
								}
								echo'</select>';
								mysqli_free_result($maestro);
						echo'<label for="horarios"  style="padding-left:20px">Horario</label>';
						$horaios = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE status=1");
									$cant=0;
									$cantHorarios= mysqli_num_rows($horaios);	
									echo'<select  id="horarios" name="horario"required>
										<option>Selecciona el horario..</option>';					
									while($cant < $cantHorarios){
										$dataHorario= @mysqli_fetch_assoc($horaios);
										echo'<option class="'.$dataHorario['id_usuario'].'"  value="'.$dataHorario['id_horario_gral'].'">'.$dataHorario['hora_inicio'].' - '.$dataHorario['hora_fin'].'</option>';
										
										$cant++;
									}
									echo'</select>';
									mysqli_free_result($horaios);

					echo'
						<br/><br/>
						<label for="motivo">Motivo</label>
						<select id="motivo" name="motivo">
							<option>Selecciona un motivo..</option>
							<option>Retardo</option>
							<option>Comision</option>
							<option>No_se_Presento</option>
							<option>Cita_Medica</option>
							<option>Enfermedad</option>
							<option>otro</option>								
						</select>
						<label for="actividad" style="padding-left:20px">Actividad</label>
						<select name="actividad">
							<option> Selecciona una Actividad..</option>
							<option>Clase</option>
							<option>Asesoria</option>
							<option>Investigacion</option>
							<option>Tutoria</option>
							<option>Otro</option>
						</select>
						<br/></br>
						<label>Observaciones</label><br/>
						<textArea name="notas" rows="5" cols="80"></textArea>
						<br/><center><button>Agregar</button></center>
					</fieldset>
				
					<br/>
				</form>
		
			<div>
				
				<div id="nuevos" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
					<b>Ver Registros</b>
					<img src="imagenes/edit.png" style="position:relative;top:0%;left:105px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
				</div>
			<br/><br/>
				
			</div>';
		}
		if($_POST['accion']=="imprimir"){
			extract($_POST);
			$Period = explode('--',$periodo);
			$fechaIni= $Period[0];
			$fechaFinal = $Period[1];

			echo'<h2>Imprimir Reporte</h2>';
			$estado = mysqli_query($conexion,"SELECT * FROM Acciones_incidencia WHERE periodo='".$fechaIni."-".$fechaFinal."' ");
			$dataE = mysqli_fetch_array($estado);
			mysqli_free_result($estado);
			$imp= mysqli_query($conexion,"SELECT * FROM Insidencias WHERE personal='".$_SESSION['id_usuario']."' AND fecha_inicio='".$fechaIni."' AND fecha_final='".$fechaFinal."'");
			echo '
			<button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>

			<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:17.5cm;border:1px solid grey; height:24cm ">				
				<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:0%;"/>	
				<span style="position:relative;left:70%;top:0;">'.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
				<center ><h4>REPORTE DE INCIDENCIA DEL PERIODO '.$fechaIni.'-'.$fechaFinal.'</h4></center>
				<b>Fecha de Inicio</b>'.$fechaIni.' <b style="">Fecha de Termino</b> '; echo $termino = ($fechaFinal!="0000-00-00") ? $fechaFinal : "Aun sin terminar"; echo "<br><br><br>"; 
				
					while($datosImp = @mysqli_fetch_assoc($imp)){
						$nombre = mysqli_query($conexion,"SELECT concat(apellidoP,' ',apellidoM,' ',nombre) AS nombre FROM Usuarios WHERE id_usuario=".$datosImp['id_usuario']);
						$result = mysqli_fetch_assoc($nombre);
						mysqli_free_result($nombre);
						
						$faltas= mysqli_query($conexion,"SELECT * FROM Asistencia_personal WHERE id_usuario='".$datosImp['id_usuario']."' ");
						$datosFaltas= mysqli_fetch_assoc($faltas);
						mysqli_free_result($faltas);



						echo'
						<fieldset>
							<legend>Incidencia no. '.$datosImp['id_incidencia'].'</legend>
							<b>Maestro:</b> '.$result['nombre'].'<br/>					
							<b>Fecha:</b> '.$datosFaltas['fecha'].'&nbsp;&nbsp;&nbsp;<b>Horarios:</b> '.$datosFaltas['id_horario_gral'].'<br/>
							<b>Motivo:</b> '.$datosImp['motivo'].'&nbsp;&nbsp;&nbsp;<b>Motivo:</b> '.$datosImp['actividad'].'&nbsp;&nbsp;&nbsp;
							<b>Incidencia:</b> ';
									if($datosFaltas['status']==1){
										echo 'Justificada';
									}
									else{
										echo 'Falta';
									}
						echo'<br><b>Observaciones:</b> '.$datosImp['notas'].'<br/>
						</fieldset><br/>';
						
					}
	
			mysqli_free_result($imp);
		}
		if($_POST['accion']=="ver"){
			
			extract($_POST);
			$Period = explode('--',$periodo);
			$fechaIni= $Period[0];
			$fechaFinal = $Period[1];

			echo '
			<div id="incidencias">
			<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
			<input type="text" id="name"/>
			<img src="imagenes/search.png" id="search-name" />
			</div>
			<table style="position:relative;left:0%;" >
				<tr style="background:black;color:white;"> 
						<th style="width:180px;">
							Maestro:<br/>						
						</th>
						<th style="width:165px;">
							Fecha:<br/>
						</th>
						<th style="width:140px;">
							Horarios:<br/>
						</th>
						<th style="width:130px;">
							Motivo:<br/>
						</th>
						<th style="width:167px;" >
							Actividad<br/>
						</th>
						<th style="width:235px;">
							Observaciones<br/>
						</th>
						<th style="width:100px;">
							Incidencia
						</th>
						<th>
						</th>
				</tr>
			
				</table>
				
					<table id="resultados" style="position:relative;left:0%;">';

					$imp= mysqli_query($conexion,"SELECT * FROM Insidencias WHERE fecha_inicio='".$fechaIni."' AND fecha_final='".$fechaFinal."' ");

					while($datosImp = @mysqli_fetch_assoc($imp)){
							$nombre = mysqli_query($conexion,"SELECT concat(apellidoP,' ',apellidoM,' ',nombre) AS nombre FROM Usuarios WHERE id_usuario=".$datosImp['id_usuario']);
							$result = mysqli_fetch_assoc($nombre);
							mysqli_free_result($nombre);
							
							$faltas= mysqli_query($conexion,"SELECT * FROM Asistencia_personal WHERE id_usuario='".$datosImp['id_usuario']."' ");
							$datosFaltas= mysqli_fetch_assoc($faltas);
							mysqli_free_result($faltas);

							echo'					
							<tr class="incid">
							

								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;">
									<input type="hidden" name="id_incidencia" value="'.$datosImp['id_incidencia'].'">
									<span style="display:none" class="nombre">'.$result['nombre'].'</span>
									<input  type="text" value="'.$result['nombre'].'" />					
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;">
									<input type="date"  name="fecha" value="'.$datosFaltas['fecha'].'"/>
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;"">';
									$horarios = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE id_usuario='".$datosFaltas['id_usuario']."' ");
									
									$num= mysqli_num_rows($horarios);
									$cant=0;
									echo'
									<select id="h'.$datosImp['id_incidencia'].'" name="horario" >';
									while($cant < $num){
										$dataHorario = mysqli_fetch_assoc($horarios);
										echo'
										<option value="'.$dataHorario['id_horario_gral'].'">'.$dataHorario['hora_inicio'].'-'.$dataHorario['hora_fin'].'</option>
										';
										$cant++;

									}

									echo'
									</select>
									<script>
										opcionestmp = $("#h'.$datosImp["id_incidencia"].'").find("option");
										opcionestmp.each(function(){
											if($(this).attr("value")=="'.$datosFaltas["id_horario_gral"].'"){
												$(this).prop("selected", true);
												return false;
											}
										});
									</script>
									';
									mysqli_free_result($horarios);

								echo'
									
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;">
									<select name="motivo" id="motivo'.$datosImp['id_incidencia'].'" >
										<option value="Retardo">Retardo</option>
										<option value="Comision">Comision</option>
										<option value="No_se_Presento">No se Presento</option>
										<option value="Cita_Medica">Cita Medica</option>
										<option value="Enfermedad">Enfermedad</option>
										<option value="Otro">otro</option>								
									</select>
									<script>
										opcionestmp = $("#motivo'.$datosImp["id_incidencia"].'").find("option");
										opcionestmp.each(function(){
											if($(this).attr("value")=="'.$datosImp["motivo"].'"){
												$(this).prop("selected", true);
												return false;
											}
										});
									</script>
									
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center; ">
									<select id="actividad'.$datosImp['id_incidencia'].'" name="actividad" style="width:167px;">
										<option></option>
										<option value="Clase">Clase</option>
										<option value="Asesoria" >Asesoria</option>
										<option value="Investigacion">Investigacion</option>
										<option value="Tutoria">Tutoria</option>
										<option value="Otro">Otro</option>
									</select>
									<script>
										optionestmp = $("#actividad'.$datosImp['id_incidencia'].'").find("option");
										optionestmp.each(function(){
											if($(this).attr("value")=="'.$datosImp['actividad'].'"){
												$(this).prop("selected",true);
												return false;
											}
										});
									</script>
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;">
									<textArea cols="25" rows="2" name="notas">'.$datosImp['notas'].'</textArea>
								</td>
								<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align:center;">
									<input type="hidden" name="id_asistencia"  value="'.$datosFaltas['id_asistencia'].'">	
									<select id="asis'.$datosImp['id_incidencia'].'" name="asistencia">
										<option value="1">Justificada</option>
										<option value="0">Falta</option>
									</select>
									<script>
										var optiones = $("#asis'.$datosImp['id_incidencia'].'").find("option");
										optiones.each(function(){
											if($(this).attr("value")=="'.$datosFaltas['status'].'"){
												$(this).prop("selected",true);
												return false;
											}
										});
									</script>
								</td>
								<td><button onclick="$(\'#editar\').show();clone=$(this).parent().parent().clone();$(\'#edicionRegistro\').html(clone);$(\'#edicionRegistro tr td:last\').remove();return false;"><img src="imagenes/checkmark.png" /></button></td>														
							</tr>						
							';
						}
						
			echo'
					</table>

			</div>
			<script>
				$("#resultados").tablePagination({});
				 $.expr[":"].Contains = function(x, y, z){
		            return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
		          };
							
			</script>';
			mysqli_free_result($imp);
		}
		if($_POST['accion']=="modificar"){
			extract($_POST);

			$modInci = mysqli_query($conexion,"UPDATE Insidencias SET motivo='".$motivo."' ,actividad='".$actividad."',notas='".$notas."' WHERE id_incidencia='".$id_incidencia."' ");
			if($modInci){
				$asistencia = mysqli_query($conexion,"UPDATE Asistencia_personal SET id_horario_gral='".$horario."', fecha='".$fecha."', status='".$asistencia."' WHERE id_asistencia='".$id_asistencia."' ");
				if($asistencia){
					echo 'Datos Modificados Exitosamente
					<script>
						$("#resultados").remove("sortReset");
						return false;
					</script>
					';
				}
				else{
					echo mysqli_error($conexion);
				}
			}
			else{
				echo mysqli_error($conexion);
			}
		}

		if($_POST["accion"]=="registro"){
			extract($_POST);
			$nombre = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre FROM Usuarios WHERE id_usuario=".$maestro);
			$result = mysqli_fetch_assoc($nombre);
			mysqli_free_result($nombre);
				

			$inci = mysqli_query($conexion,"INSERT INTO Insidencias() VALUES(null,'".$maestro."','".$fechaIni."','".$fechaFinal."','".$motivo."','".$actividad."','".$notas."', ".$_SESSION['id_usuario']." )");
			if($inci){
				$asistencia=mysqli_query($conexion,"INSERT INTO Asistencia_personal() VALUE(null,'".$maestro."','".$horario."', '".$fecha."', 1)");
				if($asistencia){
					echo'
						Registrado
						<script>
							$("#nuevos").append("<br/>Nombre <span style=color:#191970;weight:bold;>'.$result['nombre'].'</span>	");
							document.getElementById("formu").reset();
						</script>';
					
				
					
				}
				else{echo "Faltas ".mysqli_error($conexion);}
				
			}
			else{echo " Incidencia". mysqli_error($conexion);}
						
		}
		if($_POST['accion']=="finalizar"){

			$finalizar = mysqli_query($conexion,"UPDATE Acciones_incidencia SET status=0, fecha_termino='".date('Y-m-d')."' WHERE periodo='".$_POST['periodo']."' ");
			if($finalizar){
				echo'
				Inicidencia Finalizada
				<script>
					$("[carga=incidencias]").trigger("click");

				</script>
				';
			}
			

		}
	}
}
?>
