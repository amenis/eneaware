<style>
	#Mod {
	    border-collapse: collapse;
	    width: 100%;
	}

	#Mod th, #Mod td {
	    text-align: left;
	    padding: 8px;
	}

	#Mod tr:nth-child(odd){background-color: #D9D9D9}

	#Mod th {
	    background: -webkit-linear-gradient(top, rgba(206,219,233,1) 0%,rgba(170,197,222,1) 0%,rgba(58,139,194,1) 50%,rgba(97,153,199,1) 50%,rgba(58,132,195,1) 50%,rgba(38,85,139,1) 100%);
	    color: white;
	    text-align: center;
	}

	#Mod tr:hover {background-color: #00b7ea}

</style>
<?php
session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">
		
	<h1>Subir calificaciones</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="subir">Subir</button>
		<button class="tab"  style="border-bottom:none;" permiso="D" mostrar="modificar">Ver/Recapturar Calificaciones</button>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
			<div id="subir" class="tabCont" permiso="A">
				<h2>Subir calificacion por Asignatura:</h2>

				<table style="width:100%;">';

				$hoy = date("Y-m-d");
				$hora = date("H:i:s");
				$hora1 = strtotime( $hora );
				$hoy1 = strtotime( $hoy );

				$comprobar = mysqli_query($conexion,"SELECT * FROM Agsi_materia_doce WHERE id_docente = ".$_SESSION["id_usuario"]." AND status=1  ;");
				while($datosA = mysqli_fetch_array($comprobar)){

					$comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$datosA["id_materia"].";");
					while($datosB = mysqli_fetch_array($comproba)){

						$mati=$datosB['id_materia'];
						
						echo '<tr><td>
							<div nombre="'.$datosB["id_materia"].'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b><font color="#191970" weight="bold">Clave: </font>'.$datosB["clave"].' | '.$datosB["materia"].'</b>						
								<div id="cal'.$datosB["id_materia"].'" style="display:none">
									<hr></hr>';

									$comprob = mysqli_query($conexion,"SELECT * FROM Evaluacion  ;");
									while($datos = mysqli_fetch_array($comprob)){
										
										$hoy2 = strtotime( $datos["a_fecha"] );
										$hora2 = strtotime( $datos["a_hora"] );
										$hoy3 = strtotime( $datos["de_fecha"] );
										$hora3 = strtotime( $datos["de_hora"] );

										if ($hoy1>=$hoy3&&$hoy1<=$hoy2) {
											
												
												echo '<BR>
												<table id="ww">
												<tr><td><b><font color="#191970" weight="bold">Fecha:</font> </b></td><td>'.$hoy.'</td></tr>
												<tr><td><b><font color="#191970" weight="bold">Asignatura:</font> </b></td><td>'.$datosB["materia"].'</td></tr>
												<tr><td><b><font color="#191970" weight="bold">Semestre:</font> </b></td><td>'.$datosB["semestre"].'</td></tr>
												<tr><td><b><font color="#191970" weight="bold">Carrera:</font> </b></td><td>'.$datosB["carrera"].'</td></tr>
												<tr><td><b><font color="#191970" weight="bold">Periodo:</font> </b></td><td>'.$datosA["periodo"].'</td></tr>
												</table> <br>';

												if ($datos["tipo_evaluacion"]==1) {//periodo ordinario

													echo'<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">Periodo: </font> Ordinario</b>						
														<div id="odi'.$datosB["id_materia"].'" style="display:none"><br>

														<form  destino="subir" action="guardarSegui.php" >
															<input type="hidden" value="guardar" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table  id="Mod">
																
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>						
																</tr>';

																$cont=1;
																$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE carrera= '".$datosB["carrera"]."' AND semestre='".$datosB["semestre"]."' ORDER BY apellidoP,apellidoM ASC ");
																$numRespuesta = mysqli_num_rows($alumno);
																while($datosAl = mysqli_fetch_array($alumno)){

																		echo'
																		<tr>
																			<td>'.$datosAl['matricula'].'</td>
																			<td>'.$datosAl['nombre'].'
																			<input type="hidden" value="'.$datosAl['id_alumno'].'" name="id_alumno'.$cont.'"></td>
																			<td style="text-align: center;"><input type="text" name="CalF_'.$cont.'" style="width:60px;" ></td>
																			<td style="text-align: center;"><input type="text" name="Asis_'.$cont.'" style="width:60px;" ></td>
																			
																		</tr>
																		';
																	

																	$cont++;
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$numRespuesta.'" style="display:none">
															<center><button>Subir Calificaciones</button></center>
														</form>

														</div>';

														$regul = mysqli_query($conexion,"SELECT * FROM Detalles_evaluacion WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND tipo_evaluacion=1 ;");
														$numP = mysqli_num_rows($regul);

														if ($numP>0) {
															echo '<hr></hr><font color="red" weight="bold">*Nota: </font><b>Ya a subido calificaciones de esta asignatura.</b>';
														} else {
															echo '<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#odi'.$datosB["id_materia"].'\').toggle(\'drop\')">';
														}

													echo'	
													</div>';

												}
												if ($datos["tipo_evaluacion"]==5) {//periodo extraoirdinario

													echo'<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">Periodo: </font> Extraordinario</b>						
														<div id="exta'.$datosB["id_materia"].'" style="display:none"><br>

														<form  destino="subir" action="guardarSegui.php" >
															<input type="hidden" value="guardar" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table  id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>					
																</tr>';

																$cont=1;
																$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE carrera= '".$datosB["carrera"]."' AND semestre='".$datosB["semestre"]."' ORDER BY apellidoP,apellidoM ASC ");
																$numRespuesta = mysqli_num_rows($alumno);
																while($datosAl = mysqli_fetch_array($alumno)){

																		echo'
																		<tr>
																			<td>'.$datosAl['matricula'].'</td>
																			<td>'.$datosAl['nombre'].'
																			<input type="hidden" value="'.$datosAl['id_alumno'].'" name="id_alumno'.$cont.'"></td>
																			<td style="text-align: center;"><input type="text" name="CalF_'.$cont.'" style="width:60px;" ></td>
																			<td style="text-align: center;"><input type="text" name="Asis_'.$cont.'" style="width:60px;" ></td>
																			
																		</tr>
																		';
																	

																	$cont++;
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$numRespuesta.'" style="display:none">
															<center><button>Subir Calificaciones</button></center>
														</form>

														</div>';

														$regul = mysqli_query($conexion,"SELECT * FROM Detalles_evaluacion WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND tipo_evaluacion=5 ;");
														$numP = mysqli_num_rows($regul);

														if ($numP>0) {
															echo '<hr></hr><font color="red" weight="bold">*Nota: </font><b>Ya a subido calificaciones de esta asignatura.</b>';
														} else {
															echo '<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#exta'.$datosB["id_materia"].'\').toggle(\'drop\')">';
														}

													echo'	
													</div>';

												}

												if ($datos["tipo_evaluacion"]==2) {//1ra reguralizacion

													echo'<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">1ra: </font> Regularizacion</b>						
														<div id="r1'.$datosB["id_materia"].'" style="display:none"><br>

														<form  destino="subir" action="guardarSegui.php" >
															<input type="hidden" value="guardar" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table  id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>
																	<th>Fecha</th>
																	<th>Cal.</th>						
																</tr>';

																$cont=1;

																$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND cal_final<=5.00 ;");
																$num = mysqli_num_rows($regul);
																if ($num>0) {
																
																	while($datosEx = mysqli_fetch_array($regul)){


																		$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
																		
																		while($datosAl = mysqli_fetch_array($alumno)){

																			
																				echo'
																				<tr>
																					<td>'.$datosAl['matricula'].'</td>
																					<td>'.$datosAl['nombre'].'
																					<input type="hidden" value="'.$datosEx['id_resultado'].'" name="id_alumno'.$cont.'"></td>
																					<td > '.$datosEx["cal_final"].' </td>
																					<td > '.$datosEx["asistencias"].' </td>
																					<td style="text-align: center;"><input type="date" name="FechaR'.$cont.'" style="width:130px;" ></td>
																					<td style="text-align: center;"><input type="text" name="CalR'.$cont.'" style="width:60px;" ></td>
																					
																				</tr>
																				<input type="text" name="calf'.$cont.'" value="'.$datosEx["cal_final"].'" style="display:none">
																				<input type="text" name="asi'.$cont.'" value="'.$datosEx["asistencias"].'" style="display:none">
																				<input type="text" name="alm'.$cont.'" value="'.$datosAl['id_alumno'].'" style="display:none">';
																			

																			$cont++;
																		}

																	}
																}else {
																	echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No tiene Alumnos a regularizar.</td></tr>';
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$num.'" style="display:none">
															<center><button>Subir Calificaciones</button></center>
														</form>

														</div>';

														$regul = mysqli_query($conexion,"SELECT * FROM Detalles_evaluacion WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND tipo_evaluacion=2 ;");
														$numP = mysqli_num_rows($regul);

														if ($numP>0) {
															echo '<hr></hr><font color="red" weight="bold">*Nota: </font><b>Ya a subido calificaciones de esta asignatura.</b>';
														} else {
															echo '<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#r1'.$datosB["id_materia"].'\').toggle(\'drop\')">';
														}

													echo'	
													</div>';

											    }
											    if ($datos["tipo_evaluacion"]==3) {//2da regulizacion

													echo'<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">2da: </font> Regularizacion</b>						
														<div id="r2'.$datosB["id_materia"].'" style="display:none"><br>

														<form  destino="subir" action="guardarSegui.php" >
															<input type="hidden" value="guardar" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table  id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>						
																</tr>';

																$cont=1;
																$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND cal_r1<6.00 AND cal_r1>0.00 ;");
																$num = mysqli_num_rows($regul);
																if ($num>0) {
																
																	while($datosEx = mysqli_fetch_array($regul)){


																		$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
																		
																		while($datosAl = mysqli_fetch_array($alumno)){

																		
																			echo'
																			<tr>
																				<td >'.$datosAl['matricula'].'</td>
																				<td>'.$datosAl['nombre'].'
																				<input type="hidden" value="'.$datosEx['id_resultado'].'" name="id_alumno'.$cont.'"></td>
																				<td > '.$datosEx["cal_final"].' </td>
																				<td > '.$datosEx["asistencias"].' </td>
																				<td > '.$datosEx["fecha_r1"].' </td>
																				<td > '.$datosEx["cal_r1"].' </td>
																				<td style="text-align: center;"><input type="date" name="FechaR'.$cont.'" style="width:130px;" ></td>
																				<td style="text-align: center;"><input type="text" name="CalR'.$cont.'" style="width:60px;" ></td>
																				
																			</tr>
																			<input type="text" name="calf'.$cont.'" value="'.$datosEx["cal_final"].'" style="display:none">
																			<input type="text" name="asi'.$cont.'" value="'.$datosEx["asistencias"].'" style="display:none">
																			<input type="text" name="calfr'.$cont.'" value="'.$datosEx["fecha_r1"].'" style="display:none">
																			<input type="text" name="asir'.$cont.'" value="'.$datosEx["cal_r1"].'" style="display:none">
																			
																			<input type="text" name="alm'.$cont.'" value="'.$datosAl['id_alumno'].'" style="display:none">
																			
																			';
																		

																		$cont++;
																		}
																	}
																}else {
																	echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No tiene Alumnos a regularizar.</td></tr>';
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$num.'" style="display:none">
															<center><button>Subir Calificaciones</button></center>
														</form>

														</div>';

														$regul = mysqli_query($conexion,"SELECT * FROM Detalles_evaluacion WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND tipo_evaluacion=3 ;");
														$numP = mysqli_num_rows($regul);

														if ($numP>0) {
															echo '<hr></hr><font color="red" weight="bold">*Nota: </font><b>Ya a subido calificaciones de esta asignatura.</b>';
														} else {
															echo '<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#r2'.$datosB["id_materia"].'\').toggle(\'drop\')">';
														}

													echo'	
													</div>';

												}
												if ($datos["tipo_evaluacion"]==4) {//3ra regulizacion

													echo'<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">3ra: </font> Regularizacion</b>
														<div id="r3'.$datosB["id_materia"].'" style="display:none"><br>

														<form  destino="subir" action="guardarSegui.php" >
															<input type="hidden" value="guardar" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>							
																</tr>';

																$cont=1;
																$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND cal_r2<6.00 AND cal_r2>0.00 ;");
																$num = mysqli_num_rows($regul);
																if ($num>0) {
																
																	while($datosEx = mysqli_fetch_array($regul)){


																		$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
																		
																		while($datosAl = mysqli_fetch_array($alumno)){

																			echo'
																			<tr>
																				<td >'.$datosAl['matricula'].'</td>
																				<td>'.$datosAl['nombre'].'
																				<input type="hidden" value="'.$datosEx['id_resultado'].'" name="id_alumno'.$cont.'"></td>
																				<td > '.$datosEx["cal_final"].' </td>
																				<td > '.$datosEx["asistencias"].' </td>
																				<td > '.$datosEx["fecha_r1"].' </td>
																				<td > '.$datosEx["cal_r1"].' </td>
																				<td > '.$datosEx["fecha_r2"].' </td>
																				<td > '.$datosEx["cal_r2"].' </td>
																				<td style="text-align: center;"><input type="date" name="FechaR'.$cont.'" style="width:130px;" ></td>
																				<td style="text-align: center;"><input type="text" name="CalR'.$cont.'" style="width:60px;" ></td>
																			</tr>
																			<input type="text" name="calf'.$cont.'" value="'.$datosEx["cal_final"].'" style="display:none">
																			<input type="text" name="asi'.$cont.'" value="'.$datosEx["asistencias"].'" style="display:none">
																			<input type="text" name="calfr'.$cont.'" value="'.$datosEx["fecha_r1"].'" style="display:none">
																			<input type="text" name="asir'.$cont.'" value="'.$datosEx["cal_r1"].'" style="display:none">
																			<input type="text" name="calfr2'.$cont.'" value="'.$datosEx["fecha_r1"].'" style="display:none">
																			<input type="text" name="asir2'.$cont.'" value="'.$datosEx["cal_r1"].'" style="display:none">
																			
																			<input type="text" name="alm'.$cont.'" value="'.$datosAl['id_alumno'].'" style="display:none">
																			
																			';
																		

																		$cont++;
																		}
																	}
																}else {
																	echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No tiene Alumnos a regularizar.</td></tr>';
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$num.'" style="display:none">
															<center><button>Subir Calificaciones</button></center>
														</form>

														</div>';

														$regul = mysqli_query($conexion,"SELECT * FROM Detalles_evaluacion WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' AND tipo_evaluacion=4 ;");
														$numP = mysqli_num_rows($regul);

														if ($numP>0) {
															echo '<hr></hr><font color="red" weight="bold">*Nota: </font><b>Ya a subido calificaciones de esta asignatura.</b>';
														} else {
															echo '<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#r3'.$datosB["id_materia"].'\').toggle(\'drop\')">';
														}

													echo'	
													</div>';

												}
												if ($datos["tipo_evaluacion"]==6) {//periodo de recapturas

													echo'
													<div nombre="ordinario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
														<b><font color="#191970" weight="bold">Periodo: </font> Recaptura</b><hr></hr>
														<b><font color="#191970" weight="bold">*AVISO:</font> Vaya ala pestaña de Ver/Recapturar Calificaciones.</b>
													</div>';

												}


											
										} else {
											echo '<b><font color="#191970" weight="bold">*AVISO:</font> El tiempo de Evaluacion no a sido habilitado.</b>';
										}

										
											
										
										
									}
									
							echo'	</div>
								<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#cal'.$datosB["id_materia"].'\').toggle(\'drop\')">
							</div></td></tr>';
					}
				}
				echo "</table>";

				
		echo'	<br><br></div>

			<div id="modificar" class="tabCont" permiso="D" style="display:none;">
				<h2>Ver/Recapturar por Asignatura</h2>

				<table style="width:100%;">';

				$hoy = date("Y-m-d");
				$hora = date("H:i:s");
				$hora1 = strtotime( $hora );
				$hoy1 = strtotime( $hoy );

				$comprobar = mysqli_query($conexion,"SELECT * FROM Agsi_materia_doce WHERE id_docente = ".$_SESSION["id_usuario"]." AND status=1  ;");
				while($datosA = mysqli_fetch_array($comprobar)){

					$comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$datosA["id_materia"].";");
					while($datosB = mysqli_fetch_array($comproba)){

						$mati=$datosB['id_materia'];
						
						echo '<tr><td><div nombre="'.$datosB["id_materia"].'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b><font color="#191970" weight="bold">Clave: </font>'.$datosB["clave"].' | '.$datosB["materia"].'</b>						
								<div id="call'.$datosB["id_materia"].'" style="display:none">
									<hr></hr>';

									$comprob = mysqli_query($conexion,"SELECT * FROM Evaluacion  ;");
									while($datos = mysqli_fetch_array($comprob)){

										$hoy2 = strtotime( $datos["a_fecha"] );
										$hora2 = strtotime( $datos["a_hora"] );
										$hoy3 = strtotime( $datos["de_fecha"] );
										$hora3 = strtotime( $datos["de_hora"] );

										if ($hoy1>=$hoy3&&$hoy1<=$hoy2) {
											
												if ($datos["tipo_evaluacion"]==6) {//periodo de recaptura

													echo'<form  destino="resultadoRegistro" action="guardarSegui.php" >
															<input type="hidden" value="recap" name="accion">
															<input type="hidden" name="tipo" value="'.$datos["tipo_evaluacion"].'">
															<input type="hidden" name="periodo" value="'.$datosA["periodo"].'">
															<input type="hidden" name="docente" value="'.$_SESSION["id_usuario"].'">
															<input type="hidden" name="materia" value="'.$datosB['id_materia'].'">
																	 

															<table id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>							
																</tr>';

																$cont=1;
																$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' ;");
																$num = mysqli_num_rows($regul);
																if ($num>0) {
																
																	while($datosEx = mysqli_fetch_array($regul)){


																		$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
																		
																		while($datosAl = mysqli_fetch_array($alumno)){

																			echo'
																			<tr>
																				<td >'.$datosAl['matricula'].'</td>
																				<td>'.$datosAl['nombre'].'
																				<input type="hidden" value="'.$datosEx['id_resultado'].'" name="id_resultado'.$cont.'"></td>
																				<td ><input type="text" name="CalF_'.$cont.'" size=2 value="'.$datosEx["cal_final"].'" style="background:none;border:none;"> </td>
																				<td ><input type="text" name="Asis_'.$cont.'" size=2 value="'.$datosEx["asistencias"].'" style="background:none;border:none;"> </td>
																				<td ><input type="text" name="fecha_r1'.$cont.'" size=8 value="'.$datosEx["fecha_r1"].'" style="background:none;border:none;">  </td>
																				<td ><input type="text" name="cal_r1'.$cont.'" size=2 value="'.$datosEx["cal_r1"].'" style="background:none;border:none;">  </td>
																				<td ><input type="text" name="fecha_r2'.$cont.'" size=8 value="'.$datosEx["fecha_r2"].'" style="background:none;border:none;">  </td>
																				<td ><input type="text" name="cal_r2'.$cont.'" size=2 value="'.$datosEx["cal_r2"].'" style="background:none;border:none;">  </td>
																				<td ><input type="text" name="fecha_r3'.$cont.'" size=8 value="'.$datosEx["fecha_r3"].'" style="background:none;border:none;">  </td>
																				<td ><input type="text" name="cal_r3'.$cont.'" size=2 value="'.$datosEx["cal_r3"].'" style="background:none;border:none;">  </td>
																			</tr>';
																		

																		$cont++;
																		}
																	}
																}else {
																	echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No a subido calificaciones de esta asignatura.</td></tr>';
																}
														echo'
															</table><br>
															<input type="text" name="for" value="'.$num.'" style="display:none">
															<center><button>Recapturar Calificaciones</button></center>
														</form>';

												}else{//periodos ordinario,extraordinario y las regularizaciones

													echo'<table id="Mod">
																<tr>
																	<th>Matricula</th>
																	<th>Alumno</th>
																	<th>Cal. Final</th>
																	<th>Asistencia</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>
																	<th>Fecha</th>
																	<th>Cal.</th>							
																</tr>';

																$cont=1;
																$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' ;");
																$num = mysqli_num_rows($regul);
																if ($num>0) {
																	while($datosEx = mysqli_fetch_array($regul)){

																		$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
																		while($datosAl = mysqli_fetch_array($alumno)){

																			echo'
																			<tr>
																				<td >'.$datosAl['matricula'].'</td>
																				<td>'.$datosAl['nombre'].'</td>
																				<td > '.$datosEx["cal_final"].' </td>
																				<td > '.$datosEx["asistencias"].' </td>
																				<td style="font-size: 13px" > '.$datosEx["fecha_r1"].' </td>
																				<td > '.$datosEx["cal_r1"].' </td>
																				<td style="font-size: 13px"> '.$datosEx["fecha_r2"].' </td>
																				<td > '.$datosEx["cal_r2"].' </td>
																				<td style="font-size: 13px"> '.$datosEx["fecha_r3"].' </td>
																				<td > '.$datosEx["cal_r3"].' </td>
																			</tr>';
																		$cont++;
																		}
																	}
																}else {
																	echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No a subido calificaciones de esta asignatura.</td></tr>';
																}
														echo'</table><br>';

												}
										} else {//siempre

											echo'<table id="Mod">
												<tr>
													<th>Matricula</th>
													<th>Alumno</th>
													<th>Cal. Final</th>
													<th>Asistencia</th>
													<th>Fecha</th>
													<th>Cal.</th>
													<th>Fecha</th>
													<th>Cal.</th>
													<th>Fecha</th>
													<th>Cal.</th>							
												</tr>';
												$cont=1;
												$regul = mysqli_query($conexion,"SELECT * FROM Resultados_generales WHERE id_materia='".$datosB['id_materia']."' AND periodo='".$datosA["periodo"]."' ;");
												$num = mysqli_num_rows($regul);
												if ($num>0) {
													while($datosEx = mysqli_fetch_array($regul)){

														$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE semestre='".$datosB["semestre"]."' AND id_alumno='".$datosEx["id_alumno"]."' ORDER BY apellidoP,apellidoM ASC ");
														while($datosAl = mysqli_fetch_array($alumno)){

															echo'<tr>
																<td >'.$datosAl['matricula'].'</td>
																<td>'.$datosAl['nombre'].'</td>
																<td > '.$datosEx["cal_final"].' </td>
																<td > '.$datosEx["asistencias"].' </td>
																<td style="font-size: 13px" > '.$datosEx["fecha_r1"].' </td>
																<td > '.$datosEx["cal_r1"].' </td>
																<td style="font-size: 13px"> '.$datosEx["fecha_r2"].' </td>
																<td > '.$datosEx["cal_r2"].' </td>
																<td style="font-size: 13px"> '.$datosEx["fecha_r3"].' </td>
																<td > '.$datosEx["cal_r3"].' </td>
															</tr>';
															$cont++;
														}
													}
												}else {
													echo '<tr><td colspan=10 style="text-align: center;"><font color="#191970" weight="bold">*AVISO:</font> No a subido calificaciones de esta asignatura.</td></tr>';
												}
											echo'</table><br>';

										}


										
									}
						echo'	</div>
								<img src="imagenes/cloud_upload.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#call'.$datosB["id_materia"].'\').toggle(\'drop\')">
							</div></td></tr>';
					}
				}
				echo "</table>";
				
		echo'	<br><br></div>
			
		</div>
	</div>
	';
	if(substr($_SESSION["Permisos_Eneaware"][22],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][22],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][22],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>