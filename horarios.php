<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">
		<h1>Administracion de Horarios del Personal</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="resgistrarHora">Registrar Horarios</button>
		<button class="tab" style="border-bottom:none;" mostrar="modHora" >Modificar Horarios</button>
		<button class="tab" style="border-bottom:none;" mostrar="baja">Restaurar Horarios</button>
		
		
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="resgistrarHora" class="tabCont" permiso="A">
				<h2>Registro de horarios</h2>
					Selecciona al personal
				<form action="accionesHorarios.php" destino="resultadoRegistro">
					<input type="hidden" name="accion" value="guardar">
					<select id="usuario" name="usuario" onchange=" $(\'[name=idClave]\').hide().prop(\'disabled\',true); var ver = $(\'#usuario\').find(\'option:selected\').attr(\'value\'); $(\'#\'+ver).show().prop(\'disabled\',false);" >
									<option ></option>';									
									$datos=mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE status=1");
									while($nombre=mysqli_fetch_array($datos)){
										echo '<option  value="'.$nombre['id_usuario'].'">'.$nombre['nombre'].'</option>';
									}
									mysqli_free_result($nombre);
								echo'
					</select><br/><br/>					
					<table>
						<tr><td>Dia de la semana</td>
							<td>
								<select name="dia">
									<option value="lunes" >Lunes</option>
									<option value="martes">Martes</option>
									<option value="miercoles">Miercoles</option>
									<option value="jueves">Jueves</option>
									<option value="viernes">Viernes</option>
								</select>
							</td>
						</tr>
						<tr><td>Hora de inicio</td>
							<td>
								<label>Hora</label><input type="time" name="hi" />
								
							</td>
						</tr>
						<tr><td>Hora de Final</td>
							<td>
								<label>Hora</label><input type="time" name="hf"/>
								
							</td>
						</tr>
						<tr><td>Asignar a la Clave</td>
							<td>';
								$datos=mysqli_query($conexion,"SELECT id_usuario,nombre FROM Usuarios WHERE status=1");
								while($usuario=@mysqli_fetch_array($datos)){
									$clave =mysqli_query($conexion,"SELECT * FROM Claves WHERE status=1 AND id_usuario=".$usuario['id_usuario']);
									echo'<select id="'.$usuario['id_usuario'].'" name="idClave" style="display:none" disabled>
											<option value="0" selected></option>';
									while($datosC=@mysqli_fetch_array($clave)){
										echo '
											<option value="'.$datosC['id_clave'].'">'.$datosC["puesto"].$datosC["categoria"].$datosC["horas"].$datosC["plaza"].'</option>
										';
									}
									echo'</select>';
								}
								mysqli_free_result($datos);	
								mysqli_free_result($clave);									
							echo'
							</td>
						</tr>
					</table>
					<center><button>Guardar</button></center>
				</form>
			</div>
			<div id="modHora" class="tabCont" permiso="M" style="display:none;" >
				<h2>Ver Horarios</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" id="name" padre="modH"/>
					<img src="imagenes/search.png" id="search-name" />
				</div>
				<table id="modH" style="width:100%;">';
					$sql = "SELECT * FROM Usuarios WHERE status=1";
					
					$User = mysqli_query($conexion,$sql);
					$numU = mysqli_num_rows($User);
					$cant=0;
					while($cant < $numU){
						$datosU = @mysqli_fetch_assoc($User);
						echo'
						<tr class="modH">
							<td>
								<span style="display:none" class="modH_nombre">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU["nombre"].'</span>
								<div nombre="'.strtolower($datosU["nombre"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU["nombre"].'
									<div id="horario'.$datosU['id_usuario'].'" style="display:none;">';
										$hora = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE id_usuario=".$datosU['id_usuario']." AND status=1");
										while($dataH = @mysqli_fetch_array($hora)){
											echo '
											<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
												Horario <br/> <span style="style="padding-left:20px"">Dia: '.$dataH['dia_semana'].'</span><span style="padding-left:20px">Horario de Entrada:  '.$dataH['hora_inicio'].'</span><span style="padding-left:20px">Horario de Salida: '.$dataH["hora_fin"].'</span>
												<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#edit'.$dataH["id_horario_gral"].'\').toggle(\'drop\')">
												<img src="imagenes/bin.png" style="padding:4px; top:0px; position:absolute;right:0;" onclick="$(this).next().toggle(\'drop\');">
												<div style="display:none">
													<form class="borrar" destino="resultadoRegistro" action="accionesHorarios.php"style="display:inline-block" >
														<input type="hidden" value="borrar" name="accion">
														<input type="hidden" value="'.$dataH["id_horario_gral"].'" name="horario" >									
														<label>Estas Seguro que deseas dar de baja este horario</label>
														<button>Si,estoy seguro</button>																		
													</form>
													<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>
												</div>
												<div id="edit'.$dataH['id_horario_gral'].'" style="display:none">
													<form action="accionesHorarios.php" destino="resultadoRegistro">
														<input type="hidden" name="id" value="'.$datosU['id_usuario'].'">
														<input type="hidden" name="id_horario" value="'.$dataH['id_horario_gral'].'">
														<input type="hidden" name="accion" value="modificar">
														<table>
															<tr><td>Dia de la semana</td>
																<td>
																	<select name="dia" id="dia'.$dataH['id_horario_gral'].'">
																		<option value="lunes" >Lunes</option>
																		<option value="martes">Martes</option>
																		<option value="miercoles">Miercoles</option>
																		<option value="jueves">Jueves</option>
																		<option value="viernes">Viernes</option>
																	</select>
																	<script>
																		opciones = $("#dia'.$dataH['id_horario_gral'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$dataH['dia_semana'].'"){
																				$(this).prop("selected", true);
																				return false;
																			}
																		});
																	</script>
																</td>
															</tr>
															<tr><td>Hora de inicio</td>
																<td>
																	<label>Hora</label><input type="time" name="hi" value="'.$dataH['hora_inicio'].'"/>
																</td>
															</tr>
															<tr><td>Hora de Final</td>
																<td>
																	<label>Hora</label><input type="time" name="hf" value="'.$dataH['hora_fin'].'"/>
																</td>
															</tr>
															<tr><td>Asignar a la Clave</td>
																<td>';
																	if($dataH==""){
																		
																	}
																	else{
																		$clave =mysqli_query($conexion,"SELECT * FROM Claves WHERE status=1 AND id_usuario=".$datosU['id_usuario']);
																		echo'<select id="clave'.$dataH['id_clave'].'" name="idClave">
																				<option value="0"></option>';																	
																			while($dataClave = @mysqli_fetch_array($clave)){
																				echo'<option value="'.$dataClave['id_clave'].'">'.$dataClave["puesto"].$dataClave["categoria"].$dataClave["horas"].$dataClave["plaza"].'</option>';
																			}
																		echo'</select>
																			<script>
																				opciones = $("#clave'.$dataH['id_clave'].'").find("option");
																				opciones.each(function(){
																					if($(this).val()=="'.$dataH['id_clave'].'"){
																						$(this).prop("selected", true);
																						return false;
																					}
																				});
																			</script>
																			';
																	}
																																					
																	echo'
																</td>
															</tr>
														</table>
														<center><button>Guardar</button></center>
													</form>
												</div>

											</div>';										
										}	
								echo'
									</div>
									<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#horario'.$datosU["id_usuario"].'\').toggle(\'drop\')">
								</div>
							</td>
						</tr>';						
							$cant++;
					}
				
					mysqli_free_result($User);
					mysqli_free_result($hora);


			echo'
				</table>	
					<script>
						$("#modH").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
					        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
					    };
					</script>
			</div>

			<div id="baja" class="tabCont" style="display:none;">
				<h2>Ver y Restaurar Horarios</h2>
				<div  style="panoding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="bajaH" placeholder="Buscar por nombre">
					<img src="imagenes/search.png">
				</div>
				<table id="bajaH" width="100%">';
					$sql = "SELECT * FROM Usuarios WHERE status=1";
					$User = mysqli_query($conexion,$sql);
					$numU = mysqli_num_rows($User);
					$cant=0;
					while($cant < $numU){
						$datosU = @mysqli_fetch_assoc($User);
						echo'
						<tr class="bajaH">
							<td>
								<span class="bajaH_nombre" style="display:none">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU["nombre"].'</span>
								<div nombre="'.strtolower($datosU["nombre"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU["nombre"].'
									<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
									<div id="horario'.$datosU['id_usuario'].'" style="display:none;">';								

										$hora = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE id_usuario=".$datosU['id_usuario']." AND status=0");
										while($dataH = @mysqli_fetch_array($hora)){
											echo '
											<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
												Horario <br/> <span style="style="padding-left:20px"">Dia: '.$dataH['dia_semana'].'</span><span style="padding-left:20px">Horario de Entrada:  '.$dataH['hora_inicio'].'</span><span style="padding-left:20px">Horario de Salida: '.$dataH["hora_fin"].'</span>
												<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
												<div style="display:none">
													<form style="display:inline-block" action="accionesHorarios.php" destino="resultadoRegistro">
														<input type="hidden" name="accion" value="restaurar"/>
														<input type="hidden" value="'.$dataH["id_horario_gral"].'" name="horario" />									
														<label>Estas Seguro que deseas Restaurar este horario</label>
														<button>Si,estoy seguro</button>
														<button onclick="return false;">No</button>
													</form>
												</div>
											</div>';

										}
							echo'
									</div>
								</div>
							</td>
						</tr>';
						$cant++;
					}
					
					mysqli_free_result($User);
					mysqli_free_result($hora);
				echo'					
				</table>
					<script>
						$("#bajaH").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
					        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
					    };
					</script>
			
			</div>
			<div id="Reportes" style="display:none" class="tabCont">
				<h2>Reportes</h2>
				<div id="tabs">
					<ul>
						<li><a href="#Docentes">Docente</a></li>
						<li><a href="#Estado">Todos los Horarios</a></li>
					</ul>
					
						<div id="Docentes" class="clase" style="display:none">
							<br/><br/>
							<fieldset>
								<legend>Busqueda de Horario por Docente</legend>
								<form action="accionesHorarios.php" destino="resultados">
									<input type="hidden" name="accion" value="porDocente">
									Muestrame los horarios de
									<select name="id_usuario">';
										$perso = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE status=1");
										while($dataU= @mysqli_fetch_assoc($perso)){
											echo'
											<option value="'.$dataU['id_usuario'].'">'.$dataU['nombre'].'</option>
											';
										}
									echo'
									</select>
									<br/>
									<button>Buscar</button>
								</form>
							</fieldset>
						</div>

						<div id="Estado" class="clase" style="display:none">
							<br/><br/>
							
								<form action="accionesHorarios.php" destino="resultados">
									<input type="hidden" name="accion" value="estado">
									Muestrame todos los registros 
									<button>Buscar</button>
								</form>
						
						</div>
					</div>
					
				<div id="resultados"></div>			
			</div>

		</div>
	</div>
	';
	if(substr($_SESSION["Permisos_Eneaware"][5],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][5],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][5],2,1)=="0"){
		echo "
			<scrilpt>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>
<script type="text/javascript">
		$(function(){
			$("#tabs").tabs();
		});

</script>>