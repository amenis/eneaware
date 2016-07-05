<script src="js/encuesta.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.tablePagination.js"></script>
<style type="text/css">
.button{
	text-align: center;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
	padding-right: 10px;
	background-color: ghostwhite;
	border:none;
	color: black;
	margin: 0;
	border:1px solid rgba(0,0,0,0.2);
	font-family: biko;
	font-size: 11pt;
	text-decoration: none;
}
.button:hover{
	background: -webkit-linear-gradient(top, #00b7ea 0%,#009ec3 100%);
	color: white;
	cursor: pointer;
}
</style>

<?php
session_start();
include ('conexion.php');
echo'
	<div id="con" style="overflow:auto;height:100%">
			<h1>Control de Encuestas para Alumnos</h1>
			<button class="tab seleccionado" style="border-bottom:none;" permiso="A" mostrar="Activar">Habilitar Encuesta</button>
			<button class="tab " style="border-bottom:none;" mostrar="encuestas">Encuestas Habilitadas</button>
			<button class="tab " style="border-bottom:none;" mostrar="encuestasDes">Encuestas Deshabilitadas</button>
			<button class="tab " style="border-bottom:none;" permiso="A" mostrar="ConEn">Administrar Encuestas </button>';
			
	   echo'<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			  	
			  	<div id="Activar" class="tabCont" permiso="A">
			  		<h2>Habilitar encuestas:</h2>

					<div id="tabs" style="border:none">
								
						<ul>
							<li><a href="#prescolar">Por Alumno</a></li>
							<li><a href="#primaria">Por Semestre</a></li>
						</ul>
								
						<div id="prescolar" class="clase" style="display:none">	
						
							<form destino="verConsultaPA" action="busqueda.php" style="display:inline-block">
								<input type="hidden" name="option" value="porAlumno">

								Buscar: <input type="search" size="47" placeholder="por: Matricula, Apellido Paterno, Apellido Materno y Nombre" name="mati" required/> <button ><img src="imagenes/search.png"></button>
							</form><br><br>
							<div id="verConsultaPA"></div>

						</div>

						<div id="primaria" class="clase" style="display:none">
							
							<form destino="verConsultaPg" action="busqueda.php" style="display:inline-block">
								<input type="hidden" name="option" value="porGrupo">

								<table>
								<tr><td>Semestre:</td><td>
								<select  name="semestre" required>
									<option value="1">1ro</option>
									<option value="2">2do</option>
									<option value="3">3ro</option>
									<option value="4">4to</option>
									<option value="5">5to</option>
									<option value="6">6to</option>
									<option value="7">7mo</option>
									<option value="8">8vo</option>
									<option value="9">Egresado</option>
								</select></td>
								<td>Carrera:</td>
								<td><select  name="carrera">
									<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
									<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
								</select></td>
								<td><button >Buscar</button></td></tr>
								</table>

							</form><br><br>
							<div id="verConsultaPg"></div>
							
						</div>

					</div>

				</div>
			
			
				<div id="encuestas" class="tabCont" style="display:none">
					<h2>Ver Encuestas Habilitadas</h2>
			  		
					<div id="tabs2" style="border:none">
								
						<ul>
							<li><a href="#prescolar">Lincenciatura en Educacion Preescolar</a></li>
							<li><a href="#primaria">Lincenciatura en Educacion Primaria</a></li>
						</ul>
								
						<div id="prescolar" class="clase" style="display:none">	
						<br/><br/>
						<div style="padding:8px;position:absolute;top:52px;right:0;" class="buscar">
							<input type="search" autofocus padre="activas"  class="name" placeholder="Buscar...">
							<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
						</div>

							<table id="activas" style="width:100%;">';
									
									$Activadas = mysqli_query($conexion, "SELECT * FROM Encuestas_activadas WHERE status=1 AND carrera='Lincenciatura en Educacion Preescolar' ; ");

									while($datos = mysqli_fetch_array($Activadas)){

										$idE=$datos["id_encuesta_activada"];

										$alumno = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$datos["id_alumno"]."; ");
										$egresado = "";
										while($datosAl = mysqli_fetch_array($alumno)){
												$egresado = $datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"];	
												$mati = $datosAl["matricula"];
												$carrera = $datosAl["carrera"];
												$id = $datosAl["id_alumno"];
											}
										
										$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$datos["periodo"]."; ");
										$dato = mysqli_fetch_array($con);
										
										echo'
										<tr class="activas">
											<td>
												<span class="activas_nombre" style="display:none;"> '.$mati.' '.$egresado.' '.$dato["nombre_encuesta"].'</span>
												<div nombre="'.strtolower($datos["id_alumno"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
												<b><font color="#191970" weight="bold">'.$mati.'</font>, '.$egresado.'</b>
												<br/><b>Encuesta: </b><font color="#191970" weight="bold">'.$dato["nombre_encuesta"].'</font></b>
																
													<img class="edit" src="imagenes/ver.png" style="padding:4px; top:5px; position:absolute; right:3%; cursor:pointer;" onclick="$(\'#'.$datos["id_encuesta_activada"].'M\').toggle(\'drop\');">';
													echo'<div id="'.$datos["id_encuesta_activada"].'M" style="display:none;">';

														echo '<hr></hr><b>Aplicador: </b><font color="#191970" weight="bold">'.$datos["aplicador"].'</font><br/></b>
														<b>Fecha y Hora que se habilito: </b>'.$datos["fecha_inicio"].' - '.$datos["hora_inicio"]."<br/>";

																	if ($datos["status_llenado"]==0) {
																		echo "<b>Estado: <font color='red' weight='bold'> No a empezado su Encuesta </font></b><br/>";
																	} 
																	if ($datos["status_llenado"]==1){

																		$seccion = mysqli_query($conexion, "SELECT * FROM Secciones WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumS = mysqli_num_rows($seccion);
																		$apartado = mysqli_query($conexion, "SELECT * FROM Apartados WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumA = mysqli_num_rows($apartado);
																		$copetencia = mysqli_query($conexion, "SELECT * FROM Capasidades_encuesta WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumC = mysqli_num_rows($copetencia);
																		

																		$s =1;
																		while($datosSeccion = mysqli_fetch_array($seccion)){
																			$idSec[$s] = $datosSeccion["id_seccion"];
																			$sec[$s] =$datosSeccion["nombre_seccion"];
																			$s++;
																		}

																		$a =1;
																		while($datosApartados = mysqli_fetch_array($apartado)){
																			$idApa[$a] = $datosApartados["id_apartado"];
																			$apa[$a]= $datosApartados["nombre_apartado"];
																			$a++;
																		}

																		$c =1;
																		while($datosCopetencia = mysqli_fetch_array($copetencia)){
																			$idCop[$c] = $datosCopetencia["id_capasidad"];
																			$cop[$c]= $datosCopetencia["capasidad"];
																			$c++;
																		}

																		echo "<b>Estado: <font color='#191970' weight='bold'> Contestando su Encuesta </font></b><br/>";
																		
																		echo '<br/>
																			<table>
																				<tr>
																					<td>
																						<b><font color="#191970" weight="bold">Secciones:</font></b><hr></hr>
																					</td>
																					<td>
																						<b><font color="#191970" weight="bold">Apartados:</font></b><hr></hr>
																					</td>
																					<td>
																						<b><font color="#191970" weight="bold">Copetencias:</font></b><hr></hr>
																					</td>
																				</tr>
																				<tr>
																					<td>';
																						for ($i=1; $i <= $NumS ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_seccion= '".$idSec[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$sec1 = $datosS["id_seccion"];
																							if ($sec1==$idSec[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$sec[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																					<td style="border-right:1px solid rgba(0,0,0,0.5);border-left:1px solid rgba(0,0,0,0.5);">';
																						for ($i=1; $i <= $NumA ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_apartado= '".$idApa[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$apa1 = $datosS["id_apartado"];
																							if ($apa1==$idApa[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$apa[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																					<td>';
																						for ($i=1; $i <= $NumC ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Capasidades_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_capasidad= '".$idCop[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$cap1 = $datosS["id_capasidad"];
																							if ($cap1==$idCop[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$cop[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																				</tr>
																			</table>';

																		$all = $datos["id_alumno"];
																		$enn = $dato["id_encuesta"];
																		$ver2 = mysqli_query($conexion, "SELECT * FROM Capasidades_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_encuesta = ".$enn.";");
																		$Nu2 = mysqli_num_rows($ver2);
																		$ss=0;
																		$ver1 = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_encuesta = ".$enn.";");
																		
																		while($datos = mysqli_fetch_array($ver1)){	

																			if ($datos["id_seccion"]==0) {
																				$basura = 1;
																			} else {
																				$ss++;
																			}
																		}

																		if ($NumS==$ss&&$NumC==$Nu2) {
																			echo '<center><form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																					<input type="hidden" value="folio" name="option">
																					<input type="hidden" value="'.$all.'" name="alumno" >	
																					<input type="hidden" value="'.$enn.'" name="encuesta" >									
																						<br/><button>Generar Folio</button>																	
																				</form></center>';
																		} else {
																			echo "<br/><center><button disabled>Generar Folio</button></center>";
																		}

																	}
																	if ($datos["status_llenado"]==2){

																		$consultaFolio = mysqli_query($conexion, "SELECT * FROM Folio_encuesta WHERE id_alumno=".$datos["id_alumno"]." AND id_encuesta= ".$dato["id_encuesta"]." ;");
				
																		while($dat = mysqli_fetch_array($consultaFolio)){	
																			$Folio = $dat["folio"];
																		}

																		echo "<b>Fecha y Hora de finalizacion: </b>".$datos["fecha_fin"].' - '.$datos["hora_fin"]."<br/>
																		<b>Estado: <font color='green' weight='bold'> Finalizo su Encuesta </font> con No. de folio: <font color='red' weight='bold'> ".$Folio." </font></b><br/>";
																	}
																	
																echo'</div>
																<img src="imagenes/bin.png"  style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(\'#encuestas'.$datos["id_alumno"].'\').toggle(\'drop\');">';
																
																echo '<img src="imagenes/delete.png"  permiso="D" style="padding:4px; top:5px; position:absolute;right:0; cursor:pointer;" onclick="$(this).next().toggle(\'drop\');">
														
																		<div style="display:none;" permiso="D">
																			<form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																				<input type="hidden" value="borrar" name="option">
																				<input type="hidden" value="'.$idE.'" name="egresado" >									
																					<label>Estas Seguro que deseas deshabilitar la encuesta a: <font color="#191970" weight="bold">'.$egresado.'</font>?</label>
																					<button>Si,estoy seguro</button>																
																			</form>
																			<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
																		</div>';
															
												echo'</div>

											</td>
										</tr>';

										
									}

									echo '</table>

									<script>
										$("#activas").tablePagination({});
										$.expr[":"].Contains = function(x, y, z){
										return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
										};
									</script>

						</div>

						<div id="primaria" class="clase" style="display:none">
						<br/><br/>
						<div style="padding:8px;position:absolute;top:52px;right:0;" class="buscar">
							<input type="search" autofocus padre="activasP"  class="name" placeholder="Buscar...">
							<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
						</div>

							<table id="activasP" style="width:100%;">';
									
									$Activadas = mysqli_query($conexion, "SELECT * FROM Encuestas_activadas WHERE status=1 AND carrera='Lincenciatura en Educacion Primaria'; ");

									while($datos = mysqli_fetch_array($Activadas)){

										$idP=$datos["id_encuesta_activada"];

										$alumno = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$datos["id_alumno"]."; ");
										$egresado = "";
										while($datosAl = mysqli_fetch_array($alumno)){
												$egresado = $datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"];	
												$mati = $datosAl["matricula"];
												$carrera = $datosAl["carrera"];
											}
										
										$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$datos["periodo"]."; ");
										$dato = mysqli_fetch_array($con);
										
										echo'
										<tr class="activasP">
											<td>
												<span class="activasP_nombre" style="display:none;"> '.$mati.' '.$egresado.' '.$dato["nombre_encuesta"].'</span>
												<div nombre="'.strtolower($datos["id_alumno"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
															<b><font color="#191970" weight="bold">'.$mati.'</font>, '.$egresado.'</b>
															<br/><b>Encuesta: </b><font color="#191970" weight="bold">'.$dato["nombre_encuesta"].'</font></b>
																
															<img class="edit" src="imagenes/ver.png" style="padding:4px; top:5px; position:absolute; right:3%; cursor:pointer;" onclick="$(\'#'.$datos["id_encuesta_activada"].'M\').toggle(\'drop\');">';
															echo'<div id="'.$datos["id_encuesta_activada"].'M" style="display:none;">';

																echo '<hr></hr><b>Aplicador: </b><font color="#191970" weight="bold">'.$datos["aplicador"].'</font><br/></b>
																<b>Fecha y Hora que se habilito: </b>'.$datos["fecha_inicio"].' - '.$datos["hora_inicio"]."<br/>";

																	if ($datos["status_llenado"]==0) {
																		echo "<b>Estado: <font color='red' weight='bold'> No a empezado su Encuesta </font></b><br/>";
																	} 
																	if ($datos["status_llenado"]==1){

																		$seccion = mysqli_query($conexion, "SELECT * FROM Secciones WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumS = mysqli_num_rows($seccion);
																		$apartado = mysqli_query($conexion, "SELECT * FROM Apartados WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumA = mysqli_num_rows($apartado);
																		$copetencia = mysqli_query($conexion, "SELECT * FROM Capasidades_encuesta WHERE id_encuesta = ".$dato["id_encuesta"]." ;");
																		$NumC = mysqli_num_rows($copetencia);
																		

																		$s =1;
																		while($datosSeccion = mysqli_fetch_array($seccion)){
																			$idSec[$s] = $datosSeccion["id_seccion"];
																			$sec[$s] =$datosSeccion["nombre_seccion"];
																			$s++;
																		}

																		$a =1;
																		while($datosApartados = mysqli_fetch_array($apartado)){
																			$idApa[$a] = $datosApartados["id_apartado"];
																			$apa[$a]= $datosApartados["nombre_apartado"];
																			$a++;
																		}

																		$c =1;
																		while($datosCopetencia = mysqli_fetch_array($copetencia)){
																			$idCop[$c] = $datosCopetencia["id_capasidad"];
																			$cop[$c]= $datosCopetencia["capasidad"];
																			$c++;
																		}

																		echo "<b>Estado: <font color='#191970' weight='bold'> Contestando su Encuesta </font></b><br/>";
																		
																		echo '<br/>
																			<table>
																				<tr>
																					<td>
																						<b><font color="#191970" weight="bold">Secciones:</font></b><hr></hr>
																					</td>
																					<td>
																						<b><font color="#191970" weight="bold">Apartados:</font></b><hr></hr>
																					</td>
																					<td>
																						<b><font color="#191970" weight="bold">Copetencias:</font></b><hr></hr>
																					</td>
																				</tr>
																				<tr>
																					<td>';
																						for ($i=1; $i <= $NumS ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_seccion= '".$idSec[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$sec1 = $datosS["id_seccion"];
																							if ($sec1==$idSec[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$sec[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																					<td style="border-right:1px solid rgba(0,0,0,0.5);border-left:1px solid rgba(0,0,0,0.5);">';
																						for ($i=1; $i <= $NumA ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_apartado= '".$idApa[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$apa1 = $datosS["id_apartado"];
																							if ($apa1==$idApa[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$apa[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																					<td>';
																						for ($i=1; $i <= $NumC ; $i++) { 
																							$verS = mysqli_query($conexion, "SELECT * FROM Capasidades_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_capasidad= '".$idCop[$i]."' ;");
																							$datosS = mysqli_fetch_array($verS);
																							$cap1 = $datosS["id_capasidad"];
																							if ($cap1==$idCop[$i]) {
																								echo '<font color="#191970" weight="bold">No '.$i.'</font>- '.$cop[$i]."<br/>";
																							} 
																						}
																				echo'</td>
																				</tr>
																			</table>';
																		
																		$all = $datos["id_alumno"];
																		$enn = $dato["id_encuesta"];
																		$ver2 = mysqli_query($conexion, "SELECT * FROM Capasidades_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_encuesta = ".$enn.";");
																		$Nu2 = mysqli_num_rows($ver2);
																		$ss=0;
																		$ver1 = mysqli_query($conexion, "SELECT * FROM Encuestas_progreso WHERE id_alumno = ".$datos["id_alumno"]." AND id_encuesta = ".$enn.";");
																		
																		while($datos = mysqli_fetch_array($ver1)){	

																			if ($datos["id_seccion"]==0) {
																				$basura = 1;
																			} else {
																				$ss++;
																			}
																		}

																		if ($NumS==$ss&&$NumC==$Nu2) {
																			echo '<center><form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																					<input type="hidden" value="folio" name="option">
																					<input type="hidden" value="'.$all.'" name="alumno" >	
																					<input type="hidden" value="'.$enn.'" name="encuesta" >									
																						<br/><button>Generar Folio</button>																	
																				</form></center>';
																		} else {
																			echo "<br/><center><button disabled>Generar Folio</button></center>";
																		}

																	}
																	if ($datos["status_llenado"]==2){

																		$consultaFolio = mysqli_query($conexion, "SELECT * FROM Folio_encuesta WHERE id_alumno=".$datos["id_alumno"]." AND id_encuesta= ".$dato["id_encuesta"]." ;");
				
																		while($dat = mysqli_fetch_array($consultaFolio)){	
																			$Folio = $dat["folio"];
																		}

																		echo "<b>Fecha y Hora de finalizacion: </b>".$datos["fecha_fin"].' - '.$datos["hora_fin"]."<br/>
																		<b>Estado: <font color='green' weight='bold'> Finalizo su Encuesta </font> con No. de folio: <font color='red' weight='bold'> ".$Folio." </font></b><br/>";
																	}
																	
																echo'</div>
																<img src="imagenes/bin.png"  style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(\'#encuestas'.$datos["id_alumno"].'\').toggle(\'drop\');">';
																
																echo '<img src="imagenes/delete.png"  permiso="D" style="padding:4px; top:5px; position:absolute;right:0; cursor:pointer;" onclick="$(this).next().toggle(\'drop\');">
														
																		<div style="display:none;" permiso="D">
																			<form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																				<input type="hidden" value="borrar" name="option">
																				<input type="hidden" value="'.$idP.'" name="egresado" >									
																					<label>Estas Seguro que deseas deshabilitar la encuesta a: <font color="#191970" weight="bold">'.$egresado.'</font>?</label>
																					<button>Si,estoy seguro</button>																		
																			</form>
																			<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
																		</div>';
															
												echo'</div>

											</td>
										</tr>';

										
									}

									echo '</table>

									<script>
										$("#activasP").tablePagination({});
										$.expr[":"].Contains = function(x, y, z){
										return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
										};
									</script>
											
						</div>
					</div>
								
			  	</div> 
				
				<div id="encuestasDes" class="tabCont" style="display:none">
					<h2>Ver Encuestas Desahabilitadas</h2>
			  		

					<div id="tabs3" style="border:none">
								
						<ul>
							<li><a href="#prescolar">Lincenciatura en Educacion Preescolar</a></li>
							<li><a href="#primaria">Lincenciatura en Educacion Primaria</a></li>
						</ul>
								
						<div id="prescolar" class="clase" style="display:none">	
						<br/><br/>
						<div style="padding:8px;position:absolute;top:52px;right:0;" class="buscar">
							<input type="search" autofocus padre="reactivas" class="name" placeholder="Buscar...">
							<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
						</div>

						<table id="reactivas" style="width:100%;">';
						
						$Reactivadas = mysqli_query($conexion, "SELECT * FROM Encuestas_activadas WHERE status=0 AND carrera='Lincenciatura en Educacion Preescolar'; ");

						while($datos = mysqli_fetch_array($Reactivadas)){
							$id1=$datos["id_encuesta_activada"];

							$alumno = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$datos["id_alumno"]."; ");
							$egresado = "";
							while($datosAl = mysqli_fetch_array($alumno)){
									$egresado = $datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"];	
									$mati = $datosAl["matricula"];
									$carrera = $datosAl["carrera"];
								}
							
							$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$datos["periodo"]."; ");
							$dato = mysqli_fetch_array($con);
							
							echo'
							<tr class="reactivas">
								<td>
									<span class="reactivas_nombre" style="display:none;">'.$mati.' '.$egresado.'</span>
									<div nombre="'.strtolower($datos["id_alumno"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
												<b><font color="#191970" weight="bold">'.$mati.'</font>, '.$egresado.' 
												<br/>Encuesta: <font color="#191970" weight="bold">'.$dato["nombre_encuesta"].'</font></b>
												
											
													<img src="imagenes/bin.png"  style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(\'#encuestas'.$datos["id_alumno"].'\').toggle(\'drop\');">';
													
													echo '<img src="imagenes/checkmark.png"  permiso="D" style="padding:4px; top:5px; position:absolute;right:0; cursor:pointer;" onclick="$(this).next().toggle(\'drop\');">
											
															<div style="display:none;" permiso="D">
																<form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																	<input type="hidden" value="reactivar" name="option">
																	<input type="hidden" value="'.$id1.'" name="egresado" >									
																		<label>Estas Seguro que deseas deshabilitar la encuesta a: <font color="#191970" weight="bold">'.$egresado.'</font>?</label>
																		<button>Si,estoy seguro</button>																		
																</form>
																<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
															</div>';
												
									echo'</div>

								</td>
							</tr>';

							
						}

						echo '</table>

						<script>
							$("#reactivas").tablePagination({});
							$.expr[":"].Contains = function(x, y, z){
							return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
							};
						</script>
						

						</div>

						<div id="primaria" class="clase" style="display:none">
						<br/><br/>

						<div style="padding:8px;position:absolute;top:52px;right:0;" class="buscar">
							<input type="search" autofocus padre="reactivasP" class="name" placeholder="Buscar...">
							<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
						</div>

						<table id="reactivasP" style="width:100%;">';
						
						$Reactivadas = mysqli_query($conexion, "SELECT * FROM Encuestas_activadas WHERE status=0 AND carrera='Lincenciatura en Educacion Primaria'; ");

						while($datos = mysqli_fetch_array($Reactivadas)){
							$id2=$datos["id_encuesta_activada"];

							$alumno = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$datos["id_alumno"]."; ");
							$egresado = "";
							while($datosAl = mysqli_fetch_array($alumno)){
									$egresado = $datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"];	
									$mati = $datosAl["matricula"];
									$carrera = $datosAl["carrera"];
								}
							
							$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$datos["periodo"]."; ");
							$dato = mysqli_fetch_array($con);
							
							echo'
							<tr class="reactivasP">
								<td>
									<span class="reactivasP_nombre" style="display:none;">'.$mati.' '.$egresado.'</span>
									<div nombre="'.strtolower($datos["id_alumno"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
												<b><font color="#191970" weight="bold">'.$mati.'</font>, '.$egresado.' 
												<br/>Encuesta: <font color="#191970" weight="bold">'.$dato["nombre_encuesta"].'</font></b>
											
											
													<img src="imagenes/bin.png"  style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(\'#encuestas'.$datos["id_alumno"].'\').toggle(\'drop\');">';
													
													echo '<img src="imagenes/checkmark.png"  permiso="D" style="padding:4px; top:5px; position:absolute;right:0; cursor:pointer;" onclick="$(this).next().toggle(\'drop\');">
											
															<div style="display:none;" permiso="D">
																<form class="borrar" destino="resultadoRegistro" action="guardarEncuesta.php"style="display:inline-block" >
																	<input type="hidden" value="reactivar" name="option">
																	<input type="hidden" value="'.$id2.'" name="egresado" >									
																		<label>Estas Seguro que deseas deshabilitar la encuesta a: <font color="#191970" weight="bold">'.$egresado.'</font>?</label>
																		<button>Si,estoy seguro</button>																		
																</form>
																<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
															</div>';
												
									echo'</div>

								</td>
							</tr>';

							
						}

						echo '</table>

						<script>
							$("#reactivasP").tablePagination({});
							$.expr[":"].Contains = function(x, y, z){
							return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
							};
						</script>
						
											
						</div>
					</div>

					
			   </div>
		
		
		<div id="ConEn" class="tabCont" style="display:none" permiso="A">
			<h2>Administrar Encuestas</h2>
			
			<div nombre="Encuestas" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
			<b>Ajustes</b>
			<img src="imagenes/settings.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Add\').toggle(\'drop\')">
			
				<div id="Add" style="display:none">
					
					<div nombre="AddEn" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">1 :</font>
							Agregar Encuesta</b>						
							<div id="AddEn" style="display:none">
							
								<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
										<input type="hidden" name="option" value="Add">';
										
										$apli = $_SESSION["Usuario_Eneaware"];
										$aplicador = "";
										$consulta= mysqli_query($conexion,"SELECT * FROM Usuarios WHERE usuario='".$apli."';");
											$numapli = mysqli_num_rows($consulta);
											if($numapli>0){
													for($x=0;$x<$numapli;$x++){
														$datosapli = mysqli_fetch_array($consulta);			
														$aplicador = $datosapli["nombre"];
													}	
											}
										echo'<input type="text" name="aplicador" value="'.$aplicador.'" style="display:none;"/>
										
										<b>Nombre de la encuesta:</b><br/><input type="text" name="nombre" style="width:370px" required="required"/><br/>
										<b>Periodo:</b><br/><input type="text" name="periodo" required="required"/>
										<button >Crear encuesta</button>						
								</form>
							
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#AddEn\').toggle(\'drop\')">
					</div>
					
					
					<div nombre="AddSe" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">2 :</font>
							Agregar Seccion</b>						
							<div id="AddSe" style="display:none">
							
								<form destino="resultadoRegistro" action="guardarEncuesta.php" >
									<input type="hidden" name="option" value="seccion">';
									
									$pro= mysqli_query($conexion,"SELECT * FROM Encuestas");
									$numpro = mysqli_num_rows($pro);
									
									
									echo"<select id='sec' name='encuesta' required='required'><option value='0'>Eliga la encuesta a agregar la seccion</option>";
									
										if($numpro>0){
											
											for($x=0;$x<$numpro;$x++){
													$datospro = mysqli_fetch_array($pro);
													echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
											}
															
										}
									echo"</select>
									<br/><br/>";	
									
							echo'		<b>Nombre de la seccion:</b> <br/> <input type="text" name="seccion"/><br/>
										<b>Agregar una Instruccion:<br/> 
										<font color="#191970" weight="bold">Ejemplos:</font></b> <br/> 
											1.- Favor completa todos los campos <br/>
											2.- Completa la seccion y terminando ve al apartado "privados" y contesta <br/>
											3.- Contesta segun tu criterio <br/>
										<input type="text" name="nota" style="width:370px"/>
									<br/><br/><center><button >Guardar Seccion</button></center>
								</form>	
							
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#AddSe\').toggle(\'drop\')">
					</div>
					
					<div nombre="AddAp" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">3 :</font>
							Agregar Apartado y Pregunta a apartado</b>						
							<div id="AddAp" style="display:none">
							
								<form destino="con" action="crearEncuesta.php" >
									<input type="hidden" name="option" value="AddAp">';
									
									$pro= mysqli_query($conexion,"SELECT * FROM Encuestas");
									$numpro = mysqli_num_rows($pro);
									
									echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para agregar el apartado por favor seleccione la encuesta donde dese agregarla y de click en 'Agregar Apartado'</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
									
									echo"<select id='sec' name='encuesta' ><option value='0'>Eliga la encuesta a agregar el apartado</option>";
									
										if($numpro>0){
											
											for($x=0;$x<$numpro;$x++){
													$datospro = mysqli_fetch_array($pro);
													echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
											}
															
										}
									echo"</select>";	
							echo'    <button>Agregar Apartado</button>
								</form>
							
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#AddAp\').toggle(\'drop\')">
					</div>
					
					
					<div nombre="Addpre" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">4 :</font>
							Agregar Pregunta</b>						
							<div id="Addpre" style="display:none">
							<form destino="con" action="crearEncuesta.php">
							<input type="hidden" name="option" value="Add">';
							
							$p= mysqli_query($conexion,"SELECT * FROM Encuestas;");
							$num = mysqli_num_rows($p);
							
							
			echo"          <font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para agregar la pregunta por favor seleccione la encuesta donde dese agregarla y de click en 'Agregar pregunta'</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>
								
							<br/><select id='sec' name='encuesta' style='position:relative;width:95%; ' required='required' >
							<option value='0'>Seleccion la encuesta donde desea que la pregunta se agrege...</option>";
							
								if($num>0){
									
									while($datos = mysqli_fetch_array($p)){
												$dato = mysqli_fetch_array($pro);
												echo"<option value='".$datos["id_encuesta"]."'>".$datos["nombre_encuesta"]."</option>";
									}
													
								}
							echo"</select>";	
							
				echo'		<br/><br/>
							<center><button >Agregar Pregunta</button></center>
						</form>
					</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Addpre\').toggle(\'drop\')">
					</div>


					<div nombre="Addpre" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">5 :</font>
							Agregar y Editar Copetencias</b>						
							<div id="AddpreCon" style="display:none">
							<form destino="con" action="crearEncuesta.php">
							<input type="hidden" name="option" value="capasidad">';
							
							$p= mysqli_query($conexion,"SELECT * FROM Encuestas;");
							$num = mysqli_num_rows($p);
							
							
			echo"          <font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para agregar la pregunta por favor seleccione la encuesta donde dese agregarla y de click en 'Agregar pregunta'</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>
								
							<br/><select id='sec' name='encuesta' style='position:relative;width:95%; ' required='required' >
							<option value='0'>Seleccion la encuesta donde desea que la pregunta se agrege...</option>";
							
								if($num>0){
									
									while($datos = mysqli_fetch_array($p)){
												$dato = mysqli_fetch_array($pro);
												echo"<option value='".$datos["id_encuesta"]."'>".$datos["nombre_encuesta"]."</option>";
									}
													
								}
							echo"</select>";	
							
				echo'		<br/><br/>
							<center><button >Agregar Pregunta</button></center>
						</form>
					</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#AddpreCon\').toggle(\'drop\')">
					</div>

					
					<div nombre="EditEn" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">6 :</font>
							Editar Nombre de la Encuesta</b>						
							<div id="EditEn" style="display:none">
							
								<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
										<input type="hidden" name="option" value="EditEn">';
										
										
							echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para modificar el nombre seleccione la escuesta y escriba el nuevo nombre'</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
										
										$pro = mysqli_query($conexion, "SELECT id_encuesta,nombre_encuesta FROM Encuestas ");
											$numpro = mysqli_num_rows($pro);
											if($numpro>0){
												echo"<select name='encuesta' id='SecEn' ><option value='na'>Eliga la encuesta a editar</option>";
												for($x=0;$x<$numpro;$x++){
														$datospro = mysqli_fetch_array($pro);
														echo"<option  value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
												}
												echo"</select>";					
											}
					echo'				
										<input type="text" id="UpEn" name="Uencuesta" style="display:none;"/>
										<button>Editar</button>';
										
										
					echo'    </form>
							
							</div>
					<img src="imagenes/edit.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#EditEn\').toggle(\'drop\')">
					</div>
					
					
					<div nombre="EditSec" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">7 :</font>
							Editar Contenido de la Encuesta</b>						
							<div id="EditSec" style="display:none">
							
								<form destino="con" action="editarEncuesta.php" style="display:inline-block">
										<input type="hidden" name="option" value="Edit">';
							
							echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para modificar el contenido seleccione la encuesta y de click en comenzar'</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
							
										
										$pro = mysqli_query($conexion, "SELECT id_encuesta,nombre_encuesta FROM Encuestas ");
											$numpro = mysqli_num_rows($pro);
											if($numpro>0){
												echo"<select name='encuesta'>
												<option value='na'>Eliga la encuesta a editar</option>";
												for($x=0;$x<$numpro;$x++){
														$datospro = mysqli_fetch_array($pro);
														echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
												}
												echo"</select>";					
											}
					echo'				<button >Comenzar</button>';
										
										
					echo'    </form>
							
							</div>
					<img src="imagenes/edit.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#EditSec\').toggle(\'drop\')">
					</div>
					
					
					
					
					<div nombre="Sueave" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">8 :</font>
							Dar de alta Encuesta</b>						
							<div id="Sueave" style="display:none">
							
								<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
										<input type="hidden" name="option" value="ha">';
										$pro = mysqli_query($conexion, "SELECT id_encuesta,nombre_encuesta FROM Encuestas WHERE status=0; ");
											$numpro = mysqli_num_rows($pro);
											echo"<select name='encuesta' class='' required='required'><option value='na'>Eliga la encuesta a habilitar</option>";
											if($numpro>0){
												
												for($x=0;$x<$numpro;$x++){
														$datospro = mysqli_fetch_array($pro);
														echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
												}
																
											}
											echo"</select>";	
					echo'				<button >Habilitar</button>';
					echo'    </form>
					
					
							</div>
					<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Sueave\').toggle(\'drop\')">
					</div>
					
					
					<div nombre="Del" tipo="fila" style="position:relative;width:50%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">9 :</font>
							Dar de baja Encuesta</b>						
							<div id="Del" style="display:none">
							
								<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
										<input type="hidden" name="option" value="de">';
										
										$pro = mysqli_query($conexion, "SELECT id_encuesta,nombre_encuesta FROM Encuestas WHERE status=1; ");
											$numpro = mysqli_num_rows($pro);
											echo"<select name='encuesta' class='' required='required'><option value='na'>Eliga la encuesta a habilitar</option>";
											if($numpro>0){
												
												for($x=0;$x<$numpro;$x++){
														$datospro = mysqli_fetch_array($pro);
														echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
												}
																
											}
											echo"</select>";	
					echo'				<button >Desahabilitar</button>';
										
										
					echo'    </form>
							
					
							</div>
					<img src="imagenes/delete.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Del\').toggle(\'drop\')">
					</div>
					
				</div>
			
			</div>
					
			
			<div nombre="ver" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
			<b>Reportes de Encuestas</b>
			<img src="imagenes/folder.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#ver\').toggle(\'drop\')">
			
				<div id="ver" style="display:none">
					
					<div nombre="Gen" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Generar Reporte de Encusta en PDF</b>						
							<div id="Gen" style="display:none">
								<form destino="resultadoRegistro" action="pdf.php" method="post">
									<font color="#191970" weight="bold">Instrucciones:</font><br/>
									<b>Ingrese el numero de Folio de la alumna (O):</b> <hr></hr>
								
								<input type="text" name="alumno" placeholder="Ejemplo: 20141113"/>
								<button class="button" >Generar PDF</button>
								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Gen\').toggle(\'drop\')">
					</div>

					<div nombre="Dow" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Descarga e Impresion del reporte de la encuesta en PDF</b>	
										
							<div id="Dow" style="display:none">

							<div style="padding:8px;position:absolute;top:36px;right:0;" class="buscar">
								<input type="search" autofocus class="name" padre="reporte"  placeholder="Buscar...">
								<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
							</div>		
								
								<hr></hr>
								
								<table id="reporte" style="width:100%;">';
									
									$directorio = opendir("documentacion/Reportes_Encuestas_Pdf/"); 
									while ($archivo = readdir($directorio))
									{

									echo '	<tr class="reporte">

												<td>
												<span class="reporte_nombre" style="display:none;">'.$archivo.'</span>';
												    if (is_dir($archivo)){}
												    else
												    {
														echo '<div nombre="'.strtolower($archivo).'" tipo="fila" style="position:relative;width:65%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
															  <font color="#191970" weight="bold">'.$archivo.'</font>
															  <a href="documentacion/Reportes_Encuestas_Pdf/'.$archivo.'" download="'.$archivo.'" style="padding:4px; top:5px; position:absolute; right:3%; cursor:pointer;"><img src="imagenes/cloud_download.png" ></a>
															  </div>';
														
												    }
												echo'</td>
											</tr>';
									}
									
						echo'	</table>

								<script>
									$("#reporte").tablePagination({});
									$.expr[":"].Contains = function(x, y, z){
									return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
									};
								</script>
								
								
							</div>
					<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Dow\').toggle(\'drop\')">
					</div>

					
					<div nombre="print" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Descarga e Impresion de la encuesta en PDF</b>						
							<div id="print" style="display:none">
								
								<div style="padding:8px;position:absolute;top:36px;right:0;" class="buscar">
								<input type="search" autofocus class="name" padre="reportePDF"  placeholder="Buscar...">
								<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
							</div>		
								
								<hr></hr>
								
								<table id="reportePDF" style="width:100%;">';
									
									$directorio = opendir("documentacion/encuestas/"); 
									while ($archivo = readdir($directorio))
									{

									echo '	<tr class="reportePDF">

												<td>
												<span class="reportePDF_nombre" style="display:none;">'.$archivo.'</span>';
												    if (is_dir($archivo)){}
												    else
												    {
														echo '<div nombre="'.strtolower($archivo).'" tipo="fila" style="position:relative;width:65%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
															  <font color="#191970" weight="bold">'.$archivo.'</font>
															  <a href="documentacion/encuestas/'.$archivo.'" download="'.$archivo.'" style="padding:4px; top:5px; position:absolute; right:3%; cursor:pointer;"><img src="imagenes/cloud_download.png" ></a>
															  </div>';
														
												    }
												echo'</td>
											</tr>';
									}
									
						echo'	</table>

								<script>
									$("#reportePDF").tablePagination({});
									$.expr[":"].Contains = function(x, y, z){
									return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
									};
								</script>
								
							</div>
					<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#print\').toggle(\'drop\')">
					</div>

					<div nombre="View" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Ver Encuesta Contestada</b>						
							<div id="ViewX" style="display:none">
								<form destino="con" action="VerEncuesta.php" method="post">
									<font color="#191970" weight="bold">Instrucciones:</font><br/>
									<b>Ingrese el numero de Folio de la alumna (O):</b> <hr></hr>
								
								<input type="text" name="alumno" placeholder="Ejemplo: s20141113"/>
								<button class="button" >Ver Encuesta</button>
								</form>
								
							</div>
					<img src="imagenes/ver.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#ViewX\').toggle(\'drop\')">
					</div>


				</div>


			
			</div>

			<div nombre="ver" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
			<b>Revisar Encuesta</b>
			<img src="imagenes/folder.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#rev\').toggle(\'drop\')">

					<form id="rev" destino="con" action="revizarEncuesta.php" style="display:none">';
										
						$pro = mysqli_query($conexion, "SELECT id_encuesta,nombre_encuesta FROM Encuestas WHERE status=1; ");
											$numpro = mysqli_num_rows($pro);
											echo"<select name='encuesta' class='' required='required'><option value='na'>Eliga la encuesta a revisar</option>";
											if($numpro>0){
												
												for($x=0;$x<$numpro;$x++){
														$datospro = mysqli_fetch_array($pro);
														echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
												}
																
											}
											echo"</select>";	
					echo'				<button >Revisar</button>';
										
										
					echo'    </form>
			
			</div>
	
		</div>	<br/><br/>
				
	</div>';

	if(substr($_SESSION["Permisos_Eneaware"][12],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][12],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][12],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}

	mysqli_close($conexion);
			
    
?>
<script>
	$(function(){
		$("#tabs").tabs();
		$("#tabs2").tabs();
		$("#tabs3").tabs();
	});
	
</script>