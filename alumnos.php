<script src="js/upload.js"></script>
<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
session_start();
include('conexion.php');
echo'<div  style="overflow:auto;height:100%">

		<h1>Administracion de Alumnos</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" mostrar="RegistrarAlum" permiso="A">Registrar Alumnado</button>
		<button class="tab" style="border-bottom:none;" mostrar="documentosAl">Documentos digitales</button>
		<button class="tab" style="border-bottom:none;" mostrar="reinscripcion">Reinscripciones</button>
		<button class="tab" style="border-bottom:none;" mostrar="VerPagos">Ver Pagos</button>
		<button class="tab" style="border-bottom:none;" mostrar="titulacion">Titulacion</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarA">Ver / Modificar Informacion del Alumnado</button>	
		<button class="tab" style="border-bottom:none;" mostrar="restaurarA">Restaurar Alumno</button>	
		<button class="tab" style="border-bottom:none" mostrar="reportes">Reportes</button>
		

		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="RegistrarAlum" class="tabCont" permiso="A">
				<h2>Registro de Alumnos <hr></hr> parte 1: <font color="#191970" weight="bold">Registro del alumno</font></h2>
				<form destino="RegistrarAlum" action="accionesAlumno.php" style="width:95%">
						<input type="hidden" name="accion" value="reg">
					<table>
						<tr><td>Apellido Paterno</td><td><input type="text" name="apP" placeholder="Ejemplo: Méndez" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
						<tr><td>Apellido Materno</td><td><input type="text" name="apM" placeholder="Ejemplo: arballo" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
						<tr><td>Nombre</td><td><input type="text" name="nombre" placeholder="Ejemplo: Carlos Arturo " size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
						<tr><td> Matricula</td><td><input type="text" placeholder="Ejemplo: 15080002" size="30" name="matricula"></td><td><td></tr>
						<tr><td> Generacion</td><td><input type="text" placeholder="Ejemplo: 2011-2015" size="25" name="generacion"></td><td><td></tr>
						<tr><td>Turno</td><td><input type="text" name="turno" placeholder="Ejemplo: Matutino"></td><td></td></tr>
						<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" checked><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M"><label for="sexRPM">Mujer</label></td><td></td></tr>
						<tr><td>Curp</td><td><input type="text" placeholder="Ejemplo: MECC020123HDFNRR04" name="curp" size="30" pattern="[A-Z0-9]{18}" title="Debe de tener una longitud de 18 digitos"></td></td></td></tr>
						<tr><td>Fecha de Nacimiento</td><td><input type="date" name="fechaN"></td><td></td></tr>
						<tr><td>Lugar de Nacimiento</td><td><input type="text" name="lugNan" placeholder="Ejemplo: Arandas,Jalisco"></td><td></td></tr>
						<tr><td>Telefono de Casa</td><td><input type="text" name="telCasa" placeholder="Ejemplo: 7810967"></td><td></td></tr>
						<tr><td>Telefono Celular</td><td><input type="text" name="telCel" placeholder="Ejemplo: 3481116699"></td><td></td></tr>
						<tr><td>Email </td><td><input type="email" placeholder="Ejemplo: ThomasR@hotmail.com" name="email" size="30" title="Debe ser un email real"></td><td></td></tr>
						<tr><td>Email ENEA </td><td><input type="email" placeholder="Ejemplo: ana.glis@estudiantes.enea.edu.mx" name="email_enea" size="30" title="Debe ser un email real"></td><td></td></tr>
						<tr><td>**Contraseña temporal del Email ENEA </td><td><input type="text"  name="contratopenea" size="30" title="Esto no se guaradra en la base de datos"></td><td></td></tr>
						<tr><td>Domicilio</td><td><input type="text" name="dom" placeholder="Ejemplo: Zaragoza"></td><td></td></tr>
						<tr><td>Numero Exterior</td><td><input type="text" name="NumExt" placeholder="Ejemplo: #253"></td><td></td></tr>
						<tr><td>Numero Interior</td><td><input type="text" name="NumInt" placeholder="Ejemplo: 12"></td><td></td></tr>
						<tr><td>Colonia</td><td><input type="text" name="colonia" placeholder="Ejemplo: Centro" ></td><td></td></tr>
						<tr><td>Municipio</td><td><input type="text" name="municipio" placeholder="Ejemplo: Arandas"></td><td></td></tr>
						<tr><td>Codigo Postal</td><td><input type="text" name="cp" placeholder="Ejemplo: 47180"></td><td></td></tr>
						<tr><td>Estado</td>
							<td>
								<select name="state" id="state">
									<option value="Aguascalientes">Aguascalientes</option>
									<option value="Baja California">Baja California</option>
									<option value="Baja California Sur">Baja California Sur</option>
									<option value="Campeche">Campeche</option>
									<option value="Chiapas">Chiapas</option>
									<option value="Chihuahua">Chihuahua</option>
									<option value="Coahuila">Coahuila</option>
									<option value="Colima">Colima</option>
									<option value="Distrito Federal">Distrito Federal</option>
									<option value="Durango">Durango</option>
									<option value="Estado de México">Estado de México</option>
									<option value="Guanajuato">Guanajuato</option>
									<option value="Guerrero">Guerrero</option>
									<option value="Hidalgo">Hidalgo</option>
									<option value="Jalisco">Jalisco</option>
									<option value="Michoacán">Michoacán</option>
									<option value="Morelos">Morelos</option>
									<option value="Nayarit">Nayarit</option>
									<option value="Nuevo León">Nuevo León</option>
									<option value="Oaxaca">Oaxaca</option>
									<option value="Puebla">Puebla</option>
									<option value="Querétaro">Querétaro</option>
									<option value="Quintana Roo">Quintana Roo</option>
									<option value="San Luis Potosí">San Luis Potosí</option>
									<option value="Sinaloa">Sinaloa</option>
									<option value="Sonora">Sonora</option>
									<option value="Tabasco">Tabasco</option>
									<option value="Tamaulipas">Tamaulipas</option>
									<option value="Tlaxcala">Tlaxcala</option>
									<option value="Veracruz">Veracruz</option>
									<option value="Yucatán">Yucatán</option>
									<option value="Zacatecas">Zacatecas</option>
								</select>
							</td><td></td>
						</tr>
						<tr><td>¿Vive Fuera?</td><td>						
								<input onclick="$(\'.Fora\').hide()" type="radio" id="rFoN" value="N" name="foraneo" checked><label for="rFoN">No</label><br>
								<input onclick="$(\'.Fora\').show()" type="radio" id="rFoS" value="S" name="foraneo"><label for="rFoS">Si</label>
							</td><td></td></tr>							
						<tr class="Fora" style="display:none;"><td >Domicilio</td><td><input type="text" name="calleF" placeholder="Ejemplo: Zaragoza" size="30"></td><td></td></tr>
						<tr  class="Fora" style="display:none;"><td>Numero Exterior</td><td><input type="text" name="NumExtF" placeholder="Ejemplo: #253"></td><td></td></tr>
						<tr  class="Fora" style="display:none;"><td  >Numero Interior</td><td ><input type="text" name="NumIntF" placeholder="Ejemplo: 12"></td><td></td></tr>
						<tr  class="Fora" style="display:none;"><td >Colonia</td><td ><input type="text" name="coloniaF" placeholder="Ejemplo: Centro" ></td><td></td></tr>
						<tr  class="Fora" style="display:none;"><td>Municipio</td><td ><input type="text" name="municipioF" placeholder="Ejemplo: Arandas"></td><td></td></tr>
						<tr class="Fora" style="display:none;" ><td>Codigo Postal</td><td><input type="text" name="cpF" placeholder="Ejemplo: 2456" ></td><td></td></tr>
						<tr class="Fora" style="display:none;"> <td>Estado</td><td><input type="text" name="estadoF" placeholder="Ejemplo: Jalisco"></td><td></td></tr>
						<tr><td>"¿Tiene tutor?</td><td>
								<input onclick="$(\'.tuto\').hide()" type="radio" id="TN" value="N" name="tutor" checked><label for="TN">No</label><br>
								<input onclick="$(\'.tuto\').show()" type="radio" name="tutor" id="TS" value="S"><label for="TS">Si</label>
							</td><td></td>
						</tr>
						<tr class="tuto" style="display:none;"><td>Nombre del Tutor</td><td><input type="text" name="tutor" placeholder="Ejemplo: Juan Perez"></td><td></td></tr>
						<tr class="tuto" style="display:none;"><td>Domicilio del Tutor</td><td><input type="text" name="domTu" placeholder="Ejemplo: Hernandez #120"></td><td></td></tr>
						<tr><td>Nombre del Padre</td><td><input type="text" name="padre" placeholder="Ejemplo: Pancho"></td><td></td></tr>
						<tr><td>Domicilio del Padre</td><td><input type="text" name="DomPa" placeholder="Ejemplo: Corona #32"></td><td></td></tr>
						<tr><td>Nombre del Madre</td><td><input type="text" name="madre" placeholder="Ejemplo: Irene"></td><td></td></tr>
						<tr><td>Domicilio del Madre</td><td><input type="text" name="DomMa" placeholder="Ejemplo: Corona #32"></td><td></td></tr>
						<tr><td>En caso de emergencia llamar a </td><td><input type="text" name="emerg" placeholder="Ejemplo: Irene"></td><td></td></tr>
						<tr><td>Domicilio de Emergencia</td><td><input type="text" name="domEme" placeholder="Ejemplo: colon #23"></td><td></td></tr>
						<tr><td>Telefono de Emergencia</td><td><input type="text" name="telEme" placeholder="Ejemplo: 3312547895"></td><td></td></tr>
						<tr><td>Tipo de Sangre</td><td><input type="text" name="tipSan" placeholder="Ejemplo: O+"></td><td></td></tr>
						<tr><td>No. de seguro</td><td><input type="text" name="imss" placeholder="Ejemplo: 1234567890"></td><td></td></tr>
						<tr><td>Bachillerato </td><td><input type="text" name="bachi" placeholder="Ejemplo: UDG "></td><td></td></tr>
						<tr><td>Fecha de Ingreso</td><td><input type="date" name="inside" ></td><td></td></tr>
						<tr>
							<td>Carrera </td>
							<td>
								<select  name="carrera">
									<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
									<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
								</select>
							</td>
							<td></td>
						</tr>
						<tr><td>Semestre Actual</td><td>
								<select  name="semestre">
									<option value="1">1ro</option>
									<option value="2">2do</option>
									<option value="3">3ro</option>
									<option value="4">4to</option>
									<option value="5">5to</option>
									<option value="6">6to</option>
									<option value="7">7mo</option>
									<option value="8">8vo</option>
									<option value="9">Egresado</option>
									<option value="10">Tutulado</option>
								</select></td><td></td></tr>						
						<tr><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>
						<tr id="nB" style="display:none"><td>Nombre de la beca</td><td><input type="text" name="nombreBeca" /></td><td></td></tr>
						<tr><td>Fecha de Termino</td><td><input type="date" name="term" ></td><td></td></tr>
						<tr><td>Dictamen de Titulacion</td><td><input type="text" name="dict" placeholder="Ejemplo:En trámite de Titulación" size="50 "></td><td></td></tr>
						<tr><td>Notas</td><td><textarea rows="4" cols="50" name="notas"></textarea></td><td></td></tr>
						
					</table>					
					<img src="imagenes/user.gif" style="cursor:pointer;position:fixed;top:190px;right:8%;border-radius:4px;border:2px solid grey;width:15%" onclick="$(this).next().next().trigger(\'click\')"/><br/>
					<input type="file" nombre="archivo" accept=".jpg, .gif, .png" style="display:none;"/>					

					<fieldset style="width:63%;">
						<legend><h4>Registro del Pago</h4></legend>
							<table>
								<tr><td>No Autentificacion</td><td>&nbsp; <input type="text" name="auth" required/></td></tr>
								<tr><td>Monto</td><td><b>$</b><input type="number" size="3" step="any" min="0" name="amount" required/></td></tr>
								<tr><td>Fecha de Deposito</td><td>&nbsp; <input type="date" name="fhdes" required ></td></tr>
								<tr><td>Descripcion</td><td><textArea rows="5" cols="25" name="note"></textArea></td></tr>
								<tr><td>Ficha</td><td><input type="file" nombre="ficha" accept=".jpg,.png,.gif" required></td></tr>
							</table>
					</fieldset><br>

					<center><button>ENVIAR</button></center><br><br>
				</form>
			</div>

				<div id="modificarA" style="display:none;" class="tabCont">
					<h2>Buscar y/o Modificar Datos de Alumnos</h2>


					<div id="alm" style="border:none">
								
						<ul>
							<li><a href="#prescolar">Buscar por Alumno</a></li>
							<li><a href="#primaria">Buscar por Semestre</a></li>
						</ul>
								
						<div id="prescolar" class="clase" style="display:none">	
						
							<form destino="verConsultaPA" action="busqueda.php" style="display:inline-block">
								<input type="hidden" name="option" value="bporAlumno">
								Buscar: <input type="search" size="47" placeholder="por: Matricula, Apellido Paterno, Apellido Materno y Nombre" name="mati" required/> <button ><img src="imagenes/search.png"></button>
							</form><br><br>
							<div id="verConsultaPA"></div>

						</div>

						<div id="primaria" class="clase" style="display:none">
							
							<form destino="verConsultaPg" action="busqueda.php" style="display:inline-block">
								<input type="hidden" name="option" value="bporGrupo">

								<table>
								<tr><td>Semestre:</td><td>
								<select  name="semestre">
									<option value="1">1ro</option>
									<option value="2">2do</option>
									<option value="3">3ro</option>
									<option value="4">4to</option>
									<option value="5">5to</option>
									<option value="6">6to</option>
									<option value="7">7mo</option>
									<option value="8">8vo</option>
									<option value="9">Egresado</option>
									<option value="10">Tutulado</option>
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

					</div><br>
				

				</div>
				
				<div id="reinscripcion" class="tabCont" style="display:none" permiso="M">
					<h2>Reinscripciones</h2>
					<div id="reinscripciones" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">					
						<form action="accionesAlumno.php" destino="reinscripciones">
							<input type="hidden" name="accion" value="registroAl">
							Matricula 
							<input id="matricula" type="text" name="matricula"> <button>Buscar</button>

						</form>					
					</div>
					<div style="height:20px;width:95%;padding-left:20px;"></div>
				</div>

				<div id="titulacion" class="tabCont" style="display:none" permiso="M">
					<h2>Proceso de Titulacion</h2>
					<div id="titulaciones" >

						<div id="titu" style="border:none">
								
						<ul>
							<li><a href="#prescolar">Alumn@s a Egresar</a></li>
							<li><a href="#primaria">Alumn@s aTitular</a></li>
						</ul>
								
						<div id="prescolar" class="clase" style="display:none">	
						

								<div style="padding:8px;position:absolute;top:50px;right:0;" class="buscar">
									<input type="search" autofocus class="name" padre="alumno9"  placeholder="Buscar...">
									<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
								</div></br></br></br>

								<table id="alumno9" style="width:100%;">';
				
									$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE semestre=8 ;");
										while($datos = mysqli_fetch_array($alumnos)){

												echo'

													<tr class="alumno9">

														<td>
														<span class="alumno9_nombre" style="display:none;">'.$datos["matricula"].' '.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].'</span>
															<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
																<b><font color="#191970" weight="bold">'.$datos["matricula"].'</font>, '.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].' <br>Carrera: <font color="#191970" weight="bold">'.$datos["carrera"].'</font></b>							
																<div id="resPer'.$datos["id_alumno"].'" style="display:none">
																	<form destino="resultadoRegistro" action="accionesAlumno.php" style="display:inline-block">
																		<input type="hidden" name="accion" value="egresar">
																			<input type="hidden" name="egresado" value="'.$datos["id_alumno"].'"/>
																			¿Estas seguro que deseas egresar a: <font color="#191970" weight="bold">'.$datos["nombre"].'</font>?
																			<button >Si, estoy seguro</button>									
																	</form>
																	<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
																</div>';
																
																if ($datos["status"]==1) {
																	echo'<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer'.$datos["id_alumno"].'\').toggle(\'drop\')">';
																} else {
																	# code...
																}
																
																
															echo'</div>

														</td>

													</tr>';

											}

										echo '</table>

												<script>
													$("#alumno9").tablePagination({});
													$.expr[":"].Contains = function(x, y, z){
													return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
													};
												</script>
									

						</div>

						<div id="primaria" class="clase" style="display:none">
							

								<div style="padding:8px;position:absolute;top:50px;right:0;" class="buscar">
									<input type="search" autofocus class="name" padre="alumno9A"  placeholder="Buscar...">
									<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
								</div>	</br></br></br>

								<table id="alumno9A" style="width:100%;">';
				
									$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE semestre=10 ;");
										while($datos = mysqli_fetch_array($alumnos)){

												echo'

													<tr class="alumno9A">

														<td>
														<span class="alumno9A_nombre" style="display:none;">'.$datos["matricula"].' '.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].'</span>
															<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
																<b><font color="#191970" weight="bold">'.$datos["matricula"].'</font>, '.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].' <br>Carrera: <font color="#191970" weight="bold">'.$datos["carrera"].'</font></b>							
																<div id="resPer'.$datos["id_alumno"].'" style="display:none">
																	<form destino="resultadoRegistro" action="accionesAlumno.php" style="display:inline-block">
																		<input type="hidden" name="accion" value="titular">
																			<input type="hidden" name="titulado" value="'.$datos["id_alumno"].'"/>
																			¿Estas seguro que deseas titular a: <font color="#191970" weight="bold">'.$datos["nombre"].'</font>?
																			<button >Si, estoy seguro</button>									
																	</form>
																	<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
																</div>';
																
																if ($datos["status"]==1) {
																	echo'<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer'.$datos["id_alumno"].'\').toggle(\'drop\')">';
																} else {
																	# code...
																}
																
																
															echo'</div>

														</td>

													</tr>';

											}

										echo '</table>

												<script>
													$("#alumno9A").tablePagination({});
													$.expr[":"].Contains = function(x, y, z){
													return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
													};
												</script>
								

						</div>
							
					</div>

					</div>
					<div style="height:20px;width:95%;padding-left:20px;"></div>
				</div>

				 <div id="restaurarA" style="display:none;" class="tabCont" permiso="M">
					<h2>Restaurar Alumnos</h2>
					<div  style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
						<input type="search" autofocus padre="rest" placeholder="Buscar">
						<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
					</div>
					<table id="rest" style="width:100%;">';
						$personal = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_alumno FROM Alumnos WHERE status=0");
						$numPers = mysqli_num_rows($personal);
						$pers = 0;				
						while($pers < $numPers) {
							$datosA = mysqli_fetch_assoc($personal);
							echo'
							<tr class="rest">
								<td>
									<span class="rest_nombre" style="display:none">'.$datosA["nombre"].'</span>
									<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
										<b>'.$datosA["nombre"].'</b>							
										<div id="resPer1'.$datosA["id_alumno"].'" style="display:none">
											<form destino="resultadoRegistro" action="accionesAlumno.php" style="display:inline-block">
													<input type="hidden" name="accion" value="restaurar">
													<input type="hidden" name="id_alumno" value="'.$datosA["id_alumno"].'">
													<br>¿Estas seguro que deseas restaurar a esta persona <b>'.$datosA["nombre"].'</b>?
													<button >Si, estoy seguro</button>									
											</form>
											<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
										</div>
										<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer1'.$datosA["id_alumno"].'\').toggle(\'drop\')">
									</div>
								</td>
							</tr>';
						$pers++;	
						}
				echo'
					</table>
					<script>
						$("#rest").tablePagination({});
						 $.expr[":"].Contains = function(x, y, z){
				            return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
				          };
									
					</script>	
				</div>
			<div id="documentosAl" style="display:none;" class="tabCont" permiso="M">
				<h2>Documentos Digitales</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus padre="docs" placeholder="Buscar">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>

				<div id="resultados"></div>

				<table id="docs" style="position:relative;width:100%;">';
					$sql = "SELECT * FROM Alumnos WHERE status=1 ORDER BY apellidoP,apellidoM ASC";
					$alumnos2 = mysqli_query($conexion,$sql);
					$alum=0;
					$num_result = mysqli_num_rows($alumnos2);
						while($alum < $num_result){
							$datosAl= mysqli_fetch_array($alumnos2);
							echo'
							<tr class="docs">
								<td>
									<span class="docs_nombre" style="display:none">'.$datosAl["matricula"].' '.$datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"].'</span>
									<div tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
										<b><font color="#191970" weight="bold">'.$datosAl["matricula"]."</font>, ".$datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"].'</b>
										
										
										<div id="docsAL'.$datosAl["id_alumno"].'" style="display:none">';
											
											$directorio = opendir("documentacion/alumnos/".$datosAl['id_alumno']."/"); 
											while ($archivo = readdir($directorio)){
												list($nombre, $ext) = split('[/.-]', $archivo);
												if (is_dir($archivo)){}
												else {
													echo '<div nombre="'.strtolower($archivo).'" tipo="fila" style="position:relative;width:55%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
															<font color="#191970" weight="bold">'.$archivo.'</font>
															<a title="Descargar archivo" href="documentacion/alumnos/'.$datosAl['id_alumno'].'/'.$archivo.'" download="'.$archivo.'" style="padding:4px; top:5px; position:absolute; right:18%; cursor:pointer;"><img src="imagenes/cloud_download.png" ></a>

															<img src="imagenes/bin.png" permiso="D" style="padding:4px; top:5px; position:absolute;right:2%;cursor:pointer;" onclick="$(this).next().toggle(\'drop\');" permiso="D" title="Eliminar archivo">
															<div style="display:none;">
																<form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
																	<input type="hidden" name="accion" value="Doceli">
																	<input type="hidden" name="id" value="'.$datosAl['id_alumno'].'">
																	<input type="hidden" name="archivo" value="'.$archivo.'">
																	<br><label>Estas Seguro que deseas eleminar este archivo</label>
																	<button>Si,estoy seguro</button>
																</form>
																<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
															</div>

															<form destino="resultadoRegistro" action="accionesAlumno.php" >
																<input type="hidden" name="accion" value="guardarDoc">
																<input type="hidden" name="id" value="'.$datosAl["id_alumno"].'">													
			       												<input type="hidden" name="nombre" value="'.$nombre.'">
																<img src="imagenes/cloud_upload.png" title="Remplazar archivo" style="padding:4px; top:5px; position:absolute; right:10%; cursor:pointer;" onclick="$(this).next().next().next().trigger(\'click\');" >
																<span></span>
																<span></span>
																<input type="file"nombre="doc" accept=".pdf,.jpg" style="display:none" onclick="$(this).next().toggle()" />
																<button style="position:absolute; top:1%; left:105%; display:none;" onclick="$(this).hide();">Guardar</button>
															</form>

															<form destino="resultados" action="accionesAlumno.php" >
																<input type="hidden" name="accion" value="verDocs">
																<input type="hidden" name="id" value="'.$datosAl["id_alumno"].'">													
			       												<input type="hidden" name="archivo" value="'.$archivo.'">
																<button style="padding:4px; top:5px; position:absolute; right:26%; cursor:pointer; background:none;border:none;"><img src="imagenes/ver.png" ></button>
															</form>

															

														</div>';
												}
											}

										echo'<hr></hr><form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
												<input type="hidden" name="accion" value="guardarDoc">
												<input type="hidden" name="id" value="'.$datosAl['id_alumno'].'">
												<input type="search" name="nombre" placeholder="Nombre del Documento" title="necesita poner nombre al documento" required> <input type="file" nombre="doc" accept=".pdf,.jpg" /> <button>Subir documento</button>
											</form>
										</div>
										<img src="imagenes/folder.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#docsAL'.$datosAl["id_alumno"].'\').toggle(\'drop\')">
									</div>
								</td>
							</tr>';
							$alum++;
						}
						mysqli_free_result($alumnos2);
			echo'
				</table>
				<script>
					$("#docs").tablePagination({});
					$.expr[":"].Contains = function(x, y, z){
				       return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
				    };
				</script><br>	
						
			</div> 
			
			<div id="VerPagos" class="tabCont" style="display:none">
				<h2>Pagos</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus padre="pagosv" placeholder="Buscar">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				
				<table id="pagosv" style="position:relative;width:100%;">';
					$sql = "SELECT * FROM Alumnos WHERE status=1 ORDER BY apellidoP,apellidoM ASC";
					$alumnos2 = mysqli_query($conexion,$sql);
					$alum=0;
					$num_result = mysqli_num_rows($alumnos2);
						while($alum < $num_result){
							$datosAl= mysqli_fetch_array($alumnos2);
							echo'
							<tr class="pagosv">
								<td>
									<span class="pagosv_nombre" style="display:none">'.$datosAl["matricula"].' '.$datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"].'</span>
									
									<div tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
										<b><font color="#191970" weight="bold">'.$datosAl["matricula"]."</font>, ".$datosAl["apellidoP"]." ".$datosAl["apellidoM"]." ".$datosAl["nombre"].'</b>
										<div id="docsAL'.$datosAl["id_alumno"].'VP" style="display:none">';
										$pagoCa = mysqli_query($conexion,"SELECT DISTINCT id_alumno,notas FROM Pagos WHERE status=1");
										mysqli_free_result($pagoCa);

										$pago = mysqli_query($conexion,"SELECT DISTINCT id_alumno,num_autorizacion,importe,notas,id_pago,fecha_desposito FROM Pagos WHERE  status=1 AND id_alumno=".$datosAl["id_alumno"].";");
										while($dataP = @mysqli_fetch_assoc($pago)){
											$Al= mysqli_query($conexion,"SELECT * FROM Alumnos WHERE  id_alumno=".$dataP['id_alumno']." ");					
											$dataA = @mysqli_fetch_assoc($Al);

											echo'<div tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
											<img src="imagenes/edit.png" style="padding:4px;cursor:pointer" onclick="$(\'#pago'.$dataP['id_pago'].'\').toggle(\'drop\')">
											'.$dataP['notas'].' - <font color="#191970" weight="bold">'.$dataP['fecha_desposito'].'</font>
											<div id="pago'.$dataP['id_pago'].'" style="display:none;padding-top:20px;position:relative;left:5%;">
												<form action="accionesAlumno.php" destino="resultadoRegistro">
													<input type="hidden" name="accion" value="modReins"/>
													<input type="hidden" name="id_pago" value="'.$dataP['id_pago'].'"/>
													<input type="hidden" name="id_al" value="'.$dataA['id_alumno'].'"/>
													<table>
														<tr>
															<th># de Autorizacion</th>
															<th>Importe</th>
															<th>Notas</th>
														</tr>
														<tr>
															<td><input type="text" name="numAut" value="'.$dataP['num_autorizacion'].'" /></td>
															<td> $ <input type="number" name="importe" value="'.$dataP['importe'].'" /></td>
															<td><textArea cols="20" rows="2" name="notas">'.$dataP['notas'].'</textArea></td>
														</tr>
													</table>';

														if(file_exists("documentacion/alumnos/".$dataA['id_alumno']."/ficha".$dataP['id_pago'].".png")){
															$imagenTmp1='ficha'.$dataP["id_pago"].'.png';
														}
														else{
															if(file_exists("documentacion/alumnos/".$dataA['id_alumno']."/ficha".$dataP['id_pago'].".jpg")){
																$imagenTmp1='ficha'.$dataP["id_pago"].'.jpg';
															}
															else{
																if(file_exists("documentacion/alumnos/".$dataA['id_alumno']."/ficha".$dataP['id_pago'].".gif")){
																	$imagenTmp1='ficha'.$dataP["id_pago"].'.gif';
																}
																else {
																	if(file_exists("documentacion/alumnos/".$dataA['id_alumno']."/ficha".$dataP['id_pago'].".svg")){
																		$imagenTmp1='ficha'.$dataP["id_pago"].'.svg';
																	}
																}
															}
														}
																	
													echo'
													<img src="documentacion/alumnos/'.$dataA['id_alumno'].'/'.$imagenTmp1.'" onclick="$(this).next().trigger(\'\click\')" />
													<input type="file" nombre="ficha" accept=".jpg, .gif, .png" style="display:none;"/>
													<center><button>Editar</button></center>
												</form>
											</div>
											</div>';
										}
										echo'</div>
										<img src="imagenes/folder.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#docsAL'.$datosAl["id_alumno"].'VP\').toggle(\'drop\')">
									</div>
								</td>
							</tr>';
							$alum++;
						}
						mysqli_free_result($alumnos2);
			echo'
				</table>
				<script>
					$("#pagosv").tablePagination({});
					$.expr[":"].Contains = function(x, y, z){
				       return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
				    };
				</script><br>


			</div>

			<div id="reportes" class="tabCont" style="display:none" permiso="A">
				<h2>Reportes</h2>
				<div >
					<div id="tabs" style="border:none">
						<ul>
							<li><a href="#semestre">Semestre</a></li>
							<li><a href="#carrera">Carrera</a></li>
							<li><a href="#estado">Todos los Alumnos</a></li>
							<li><a href="#pagosq">Pagos por fechas</a></li>
							<li><a href="#pagosa">Pagos por alumno</a></li>
						</ul>
				
						
						<div id="semestre" class="clase" style="display:none">		
								<br><br>		
							
								<fieldset width="50%">
									<legend>Busqueda de alumnos por semestre</legend>
									<form action="accionesAlumno.php" destino="resultados" >
										<input type="hidden" name="accion" value="semestre">
										Muestrame todos los alumnos del semestre
										<select name="semestre">
											<option value="1">1ro</option>
											<option value="2">2do</option>
											<option value="3">3ro</option>
											<option value="4">4to</option>
											<option value="5">5to</option>
											<option value="6">6to</option>
											<option value="7">7mo</option>
											<option value="8">8vo</option>
											<option value="9">Egresado</option>
											<option value="10">Tutulado</option>
										</select>
										<button>Buscar</button>
									</form>
								</fieldset>
							</div>

						

						<div id="carrera" class="clase" style="display:none">
								<br><br>
							<fieldset>
								<legend>Busqueda de alumnos por carrera</legend>
								<form action="accionesAlumno.php" destino="resultados">
									<input type="hidden" name="accion" value="carrera">
									Muestrame todos los alumnos de la carrera
									<select name="carrera">
										<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
										<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
									</select>
									<button>Buscar</button>
								</form>
							</fieldset>
						</div>

						<div id="estado" class="clase" style="display:none">
								<br><br>
								<form action="accionesAlumno.php" destino="resultados">
									<input type="hidden" name="accion" value="status">
									Muestrame todos los alumnos 
									<select name="status1">
										<option value="2">Si</option>
										<option value="1">No, Solo Activos</option>
										<option value="0">No, Solo No activos</option>
									</select>
									<button>Buscar</button>
								</form>
							

						</div>

						<div id="pagosq" class="clase" style="display:none">
								<br><br>
								<fieldset>
									<legend>Busqueda de pagos por fecha</legend>
									<form action="accionesAlumno.php" destino="resultados">
										<input type="hidden" name="accion" value="pagosq">
										Ver los pagos de: 
										<input type="date" name="fhde"> a:
										<input type="date" name="fha">
										<button>Buscar</button>
									</form>
								</fieldset>

						</div>
						<div id="pagosa" class="clase" style="display:none">
								<br><br>
								<fieldset>
									<legend>Busqueda de pagos por alumnos</legend>
									<form action="accionesAlumno.php" destino="resultados">
										<input type="hidden" name="accion" value="pagosa">
										Seleccione al alumno:<select name="nombre">';
										$alumnos = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_alumno FROM Alumnos;");
										while($datos = mysqli_fetch_array($alumnos)){

											echo "<option value='".$datos["id_alumno"]."'>".$datos["nombre"]."</option>";

										}
									echo'</select>	<button>Buscar</button>
									</form>
								</fieldset>

						</div>
				</div>

				<div id="resultados">

				</div>

			</div>	
		</div>
	</div>';
	
	if(substr($_SESSION["Permisos_Eneaware"][10],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][10],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][10],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	
	function CalculaEdad( $fecha ) {
    	list($Y,$m,$d) = explode("-",$fecha);
    	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}

	mysqli_close($conexion);

?>
<script>
	$(function(){
		$("#tabs").tabs();
		$("#alm").tabs();
		$("#titu").tabs();
	});
	
</script>