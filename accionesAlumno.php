<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/printThis.js"></script>
<?php
session_start();
	if(isset($_SESSION["Usuario_Eneaware"])){
		if($_SESSION["Permisos_Eneaware"][10]!="000"){
			include('conexion.php');
			$accion = $_POST["accion"];	

			if($accion=="reg"){
				echo "<h2>Registro de Alumnos <hr></hr> parte 2: <font color='#191970' weight='bold'>Documentacion</font></h2>";

				$Alumnos=mysqli_query($conexion,'INSERT INTO Alumnos() VALUES (null,"'.$_POST['matricula'].'","'.$_POST['generacion'].'","'.$_POST['turno'].'","'.$_POST['curp'].'",
				"'.$_POST['apP'].'","'.$_POST['apM'].'","'.$_POST['nombre'].'",
				"'.$_POST['fechaN'].'","'.$_POST['lugNan'].'","'.$_POST['tutor'].'","'.$_POST['domTu'].'","'.$_POST['inside'].'","'.$_POST['telCasa'].'","'.$_POST['telCel'].'","'.$_POST['email'].'","'.$_POST['email_enea'].'","'.$_POST['dom'].'",
				"'.$_POST['NumExt'].'","'.$_POST['NumInt'].'","'.$_POST['colonia'].'","'.$_POST['municipio'].'","'.$_POST['state'].'","'.$_POST['cp'].'",
				"'.$_POST['calleF'].'","'.$_POST['NumExtF'].'","'.$_POST['NumIntF'].'","'.$_POST['coloniaF'].'","'.$_POST['municipioF'].'","'.$_POST['estadoF'].'","'.$_POST['cpF'].'",
				"'.$_POST['padre'].'","'.$_POST['DomPa'].'","'.$_POST['madre'].'","'.$_POST['DomMa'].'","'.$_POST['emerg'].'","'.$_POST['domEme'].'",
				"'.$_POST['telEme'].'","'.$_POST['tipSan'].'","'.$_POST['imss'].'","'.$_POST['sexo'].'","'.$_POST['beca'].'","'.$_POST['nombreBeca'].'",1,"'.$_POST['semestre'].'","'.$_POST['carrera'].'",
				"'.$_POST['notas'].'","'.$_POST['term'].'","'.$_POST['bachi'].'","'.$_POST['dict'].'")');

				if($Alumnos){
					echo'<b><font color="green" weight="bold">ALUMN@ RESGISTRAD@...</font></b><br><br>';	
					$id = mysqli_insert_id($conexion);
					$ida=$id;
					if(isset($_FILES["archivo"])){
					$datosImg = explode(".", $_FILES["archivo"]["name"]);
					$extension = $datosImg[count($datosImg)-1];
					copy($_FILES["archivo"]["tmp_name"], "imagenes/alumnos/".$id.".".$extension);				
					}
					mkdir("documentacion/alumnos/".$id, 0777);
					$matriculaAl = md5($_POST['matricula']);	
					$pasTempo = md5($_POST['curp']);
					$pagos= mysqli_query($conexion,"INSERT INTO Pagos() VALUES(null,'".$_POST['auth']."','".$_POST['fhdes']."','".$id."','".$_POST['note']."','".$_POST['amount']."',1)");
					if($pagos){

						$id_pago= mysqli_insert_id($conexion);
						
						if(isset($_FILES['ficha'])){
							$datosImg = explode(".",$_FILES['ficha']['name']);
							$extension= $datosImg[count($datosImg)-1];
							copy($_FILES['ficha']['tmp_name'],"documentacion/alumnos/".$id."/ficha".$id_pago.".".$extension);
						}
					}
					else{
						echo mysqli_error($conexion);
					}
					$sai = mysqli_query($conexion,"INSERT INTO Sai SET id_alumno=".$id.", matricula='".$matriculaAl."',password='".$pasTempo."',permisos='111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111,111',status=1");	
				}
				echo 'Acontinuacion favor de subir la documentacion del alumno para poder concluir con el registro del mismo 

				<br><br>

				<form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
					<input type="hidden" name="accion" value="Doc">
					<input type="hidden" name="id" value="'.$ida.'">
					Documento : 
					<input type="search" name="NombreDoc" placeholder="Nombre del Documento" required> <input type="file" nombre="doc" accept=".pdf,.jpg" /> <button>Subir documento</button>
				</form>

				<br><b>Documentos subidos:</b>
				<div id="verDoc" style="width:50%;height:80px;border:2px solid grey;padding-top: 10px;padding-left: 10px;overflow: scroll;"></div>
				
				<br><br>

				<div nombre="gerenerAcuse" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
					<b>Imprimir Solicitud de Inscripcion</b>							
					<div id="Acuse" style="">

					<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
					
					<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
						<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>	
						<span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'</span>';
						
						$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno= ".$ida." ;");
				
						while($datosAl = mysqli_fetch_array($alumnos)){

							$rs = mysqli_query($conexion,"SELECT MAX(id_ciclo) AS id FROM Ciclos");
							if ($row = mysqli_fetch_row($rs)) {
							$id_ciclo = trim($row[0]);
							}
							$ciclo = mysqli_query($conexion, "SELECT * FROM Ciclos WHERE id_ciclo= ".$id_ciclo." ;");
							$datosCi = mysqli_fetch_array($ciclo);

							if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
								$imagenTmp1=$datosAl["id_alumno"].'.png';
							}
							else{
								if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
									$imagenTmp1=$datosAl["id_alumno"].'.jpg';
								}
								else{
									if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
										$imagenTmp1=$datosAl["id_alumno"].'.gif';
									}
									else {
										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
											$imagenTmp1=$datosAl["id_alumno"].'.svg';
										}
										else {
											$imagenTmp1="disable.gif";
										}
									}
								}
							}
							$fecha= $datosAl["fecha_nacimiento"];
							$edad=CalculaEdad($fecha);

							if ($datosAl["status"]==1) {
								$sta="Activo, Regular";
							} else {
								$sta="Actibo, Inrregular";
							}
							

							echo'<center><h2>SOLICITUD DE INSCRIPCION</h2></center>
								<table style="width: 70%;">
									<tr><td> Matricula</td><td>'.$datosAl["matricula"].'</td><td><td></tr>
									<tr><td>Curp</td><td>'.$datosAl["curp"].'</td></td></td></tr>
									<tr><td> Estatus</td><td> '.$sta.' </td><td><td></tr>
									<tr><td>Licenciatura </td><td>'.$datosAl["carrera"].'</td><td></td></tr>
									<tr><td> Generacion</td><td>'.$datosAl["generacion"].'</td><td><td></tr>
									<tr><td> Turno</td><td>'.$datosAl["turno"].'</td><td><td></tr>
									<tr><td>Apellido Paterno</td><td>'.$datosAl["apellidoP"].'</td><td></td></tr>
									<tr><td>Apellido Materno</td><td>'.$datosAl["apellidoM"].'</td><td></td></tr>
									<tr><td>Nombre</td><td>'.$datosAl["nombre"].'</td><td></td></tr>
									<tr><td>Fecha de Nacimiento</td><td>'.$datosAl["fecha_nacimiento"].'</td></tr>
									<tr><td>Lugar de Nacimiento</td><td>'.$datosAl["lugar_nacimiento"].'</td></tr>
									<tr><td>Domicilio Particular</td><td>'.$datosAl["calle_local"].' #'.$datosAl["num_ext_local"].' int:'.$datosAl["num_int_local"].' </td><td></td></tr>
									<tr><td>Codigo Postal</td><td>'.$datosAl["cp_local"].'</td><td></td></tr>
									<tr><td>Municipio</td><td>'.$datosAl["municipio_local"].'</td><td></td></tr>
									<tr><td>Telefono de Casa</td><td>'.$datosAl["tel_casa"].'</td><td></td></tr>
									<tr><td>Telefono Celular</td><td>'.$datosAl["tel_celular"].'</td><td></td></tr>
									<tr><td>Ciclo escolar</td><td>'.$datosCi["ciclo"].$datosCi["periodo"].'</td><td></td></tr>
									<tr><td>No. de Seguro</td><td>'.$datosAl["imss"].'</td><td></td></tr>
									<tr><td>Email ENEA</td><td>'.$datosAl["email_enea"].'</td><td></td></tr>
									<tr><td>Contraseña temporal Email ENEA</td><td>'.$_POST["contratopenea"].'</td><td></td></tr>
									<tr><td>Email Secundario </td><td>'.$datosAl["email"].'</td><td></td></tr>
									<tr><td>Datos del contacto de emergencia </td><td>'.$datosAl["tel_emergencia"].', '.$datosAl["nombre_emergecia"].', '.$datosAl["domicilio_emergencia"].'</td><td></td></tr>
									<tr><td>Usuario SAI</td><td>'.$datosAl["matricula"].'</td><td></td></tr>
									<tr><td>Contraseña temporal SAI</td><td>'.$datosAl["curp"].'</td><td></td></tr>
									<tr><td>Datos del deposito de la colegiatura</td><td>'.$_POST["auth"].', $'.$_POST["amount"].', '.$_POST["fhdes"].'</td><td></td></tr>
									<tr><td>Fecha y Hora de recepcion de Solicitud</td><td>'.date("F j, Y, g:i a").'</td><td></td></tr>
									<tr><td colspan="3">
										<font size="1" weight="bold">
											ME COMPROMETO COMO ALUMNO DE ESTA ESCUELA QUE MIS ACTITUDES Y CONDUCTA RESPONDERAN A LO ESTABLECIDO
											EN LAS LEYES, REGLAMENTO Y DEMAS NORMATIVIDAD ESPECIFICADA EN EL PLAN DE ESTUDIOS QUE SE DERIVAN DE
											LA LEY GENERAL DE EDUCACION Y QUE SE RIGE EN ESTA INSTITUCION, ASI COMO EL TAMBIEN RESPETAR EL 
											RLEGLAMENTO DE LAS ESCUELAS QUE SE ASIGNEN PARA REALIZAR MIS PRACTICAS DE TRABAJO DOCENTE.<BR><BR>

											PROTESTO QUE SON VERDADEROS LOS DATOS QUE SE ANOTO EN LA SOLUCITUD DE INSCRIPCION.
										</font>
									</td><td></td></tr>
								</table>
							<img src="imagenes/alumnos/'.$imagenTmp1.'" alt="alumno" height="250" width="180" style="position:relative;top:-700px;right:-570px;border:2px solid grey;border-radius:5px"/>
							';
						}
														
					echo'	<div id="verDoc2" style="position:relative;top:-255px;right:-5px;width:40%;height:80px;padding-top: 10px;padding-left: 10px;"><b>Documentos Entregados:<br><li>Ficha de deposito bancario</li></b></div>
							<div style="position:relative;top:-305px;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma alumn@</b></div>
							<div style="position:relative;top:-390px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>
							
						
					</div>
						
					</div>
									
				</div>

				<div nombre="gerenerHorario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
					<b>Imprimir Horario</b>							
					<div id="Horario" style="display:none">

					<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>

					<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
						<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:0%;"/>	
						<span style="position:relative;left:70%;top:0;">'.date("m/d/Y").'</span>
						
						
					</div>
						
					</div>
									
					<img src="imagenes/print.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Horario\').toggle(\'drop\')">
				</div>

				<br><br><center><form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
					<input type="hidden" name="accion" value="end">
					<button>Finalizar Registro del Alumno</button>
				</form></center>

				<br><br>';

			}

			if($accion=="Doc"){
				extract($_POST);
				if(isset($_FILES['doc'])){
					$datosDoc = explode(".", $_FILES['doc']['name']);
					$ext = $datosDoc[count($datosDoc)-1];
					copy($_FILES['doc']['tmp_name'],"documentacion/alumnos/".$id."/".$NombreDoc.".".$ext);

					echo 'Archivo Registrado';
					echo '<script>
							$("#verDoc").append("<li>Documento subido: <b>'.$NombreDoc.'</b></li>");
							$("#verDoc2").append("<li><b>'.$NombreDoc.'</b></li>");
						</script>';

				}
				else{
					echo 'No se detecto ningun documento '.$id;
				}
			}

			if($accion=="Doceli"){

				unlink("documentacion/alumnos/".$_POST["id"]."/".$_POST["archivo"]);

				echo 'Archivo eliminado '.$_POST["archivo"].'
					<script>
						$("[carga=alumnos]").trigger("click");
						setTimeout(function(){$("[mostrar=documentosAl]").trigger("click")},1000);
					</script>
					';

			}

			if($accion=="verDocs"){
				list($nombre, $ext) = split('[/.-]', $_POST["archivo"]);

				if ($ext=="pdf") {
					echo'<div id="dialog-message" title="'.$_POST["archivo"].'" >
				
					<center>
				  	<embed style="width:70%;height: 1050px;" src="documentacion/alumnos/'.$_POST["id"].'/'.$nombre.'.pdf">
					</center>

					</div>
							
						<script>
								$(function() {
								    $( "#dialog-message" ).dialog({
									    modal: true,
									    width:"80%",
									    height:600,
									});
								});
							</script>';
				} else {
					echo'<div id="dialog-message" title="'.$_POST["archivo"].'" >
				
					<center>
				  	<img style="width:100%;height:100%;" src="documentacion/alumnos/'.$_POST["id"].'/'.$_POST["archivo"].'" >
					</center>

					</div>
							
						<script>
								$(function() {
								    $( "#dialog-message" ).dialog({
									    modal: true,
									    width:"80%",
									    height:600,
									});
								});
							</script>';
				}

			}

			if($accion=="end"){

				echo 'Finalizando Registro del Alumno...
					<script>
						$("[carga=alumnos]").trigger("click");
						setTimeout(function(){$("[mostrar=RegistrarAlum]").trigger("click")},1000);
					</script>
					';

			}

			if($accion=="end2"){

				echo 'Finalizando Proceso de reinscripcion...
					<script>
						$("[carga=alumnos]").trigger("click");
						setTimeout(function(){$("[mostrar=reinscripcion]").trigger("click")},1000);
					</script>
					';

			}
				
			if($accion=="modificar"){
				$ModAl=mysqli_query($conexion,'UPDATE Alumnos SET generacion="'.$_POST["generacion"].'",turno="'.$_POST["turno"].'",curp="'.$_POST['curp'].'",apellidoP="'.$_POST['apP'].'",apellidoM="'.$_POST['apM'].'",nombre="'.$_POST['nombre'].'",fecha_nacimiento="'.$_POST['fechaN'].'",lugar_nacimiento="'.$_POST['lg'].'",
				tutor="'.$_POST['tutor'].'",domicilio_tutor="'.$_POST['domTu'].'",fecha_ingreso="'.$_POST['inside'].'",tel_casa="'.$_POST['telCasa'].'",tel_celular="'.$_POST['telCel'].'",email="'.$_POST['email'].'",email_enea="'.$_POST['email_enea'].'",
				calle_local="'.$_POST['dom'].'",num_ext_local="'.$_POST['NumExt'].'",num_int_local="'.$_POST['NumInt'].'",colonia_local="'.$_POST['colonia'].'",municipio_local="'.$_POST['municipio'].'",
				estado_local="'.$_POST['state'].'",cp_local="'.$_POST['cp'].'",calle_foranea="'.$_POST['calleF'].'",num_ext_foranea="'.$_POST['NumExtF'].'",
				num_int_foranea="'.$_POST['NumIntF'].'",colonia_foranea="'.$_POST['coloniaF'].'",municipio_foranea="'.$_POST['municipioF'].'",estado_foranea="'.$_POST['estadoF'].'",
				cp_foranea="'.$_POST['cpF'].'",padre="'.$_POST['padre'].'",dom_padre="'.$_POST['DomPa'].'",madre="'.$_POST['madre'].'",dom_madre="'.$_POST['DomMa'].'",nombre_emergecia="'.$_POST['emerg'].'",
				domicilio_emergencia="'.$_POST['domEme'].'",tel_emergencia="'.$_POST['telEme'].'",tipo_sangre="'.$_POST['tipSan'].'",imss="'.$_POST["imss"].'",sexo="'.$_POST['sexo'].'",beca="'.$_POST['beca'].'", nombreBeca="'.$_POST['nombreBeca'].'",
				semestre="'.$_POST['semestre'].'",carrera="'.$_POST['carrera'].'",notas="'.$_POST['notas'].'",fecha_termino="'.$_POST['term'].'",bachillerato="'.$_POST['bachi'].'",dictamen_titulacion="'.$_POST['dict'].'"  WHERE id_alumno='.$_POST['id'].'');
				echo 'Registro Modificado';				
				
				if(isset($_FILES["archivo"])){
					$datosImg = explode(".", $_FILES["archivo"]["name"]);
					$extension = $datosImg[count($datosImg)-1];
					copy($_FILES["archivo"]["tmp_name"], "imagenes/alumnos/".$_POST['id'].".".$extension);				
				}
				
				echo '<script>
						$("[carga=alumnos]").trigger("click");
						setTimeout(function(){$("[mostrar=modificarA]").trigger("click")},1000);
					</script>';
			}

			if($accion=="modificarAluRein"){
				$ModAl=mysqli_query($conexion,'UPDATE Alumnos SET generacion="'.$_POST["generacion"].'",turno="'.$_POST["turno"].'",curp="'.$_POST['curp'].'",apellidoP="'.$_POST['apP'].'",apellidoM="'.$_POST['apM'].'",nombre="'.$_POST['nombre'].'",fecha_nacimiento="'.$_POST['fechaN'].'",lugar_nacimiento="'.$_POST['lg'].'",
				tutor="'.$_POST['tutor'].'",domicilio_tutor="'.$_POST['domTu'].'",tel_casa="'.$_POST['telCasa'].'",tel_celular="'.$_POST['telCel'].'",email="'.$_POST['email'].'",email_enea="'.$_POST['email_enea'].'",
				calle_local="'.$_POST['dom'].'",num_ext_local="'.$_POST['NumExt'].'",num_int_local="'.$_POST['NumInt'].'",colonia_local="'.$_POST['colonia'].'",municipio_local="'.$_POST['municipio'].'",
				estado_local="'.$_POST['state'].'",cp_local="'.$_POST['cp'].'",calle_foranea="'.$_POST['calleF'].'",num_ext_foranea="'.$_POST['NumExtF'].'",
				num_int_foranea="'.$_POST['NumIntF'].'",colonia_foranea="'.$_POST['coloniaF'].'",municipio_foranea="'.$_POST['municipioF'].'",estado_foranea="'.$_POST['estadoF'].'",
				cp_foranea="'.$_POST['cpF'].'",padre="'.$_POST['padre'].'",dom_padre="'.$_POST['DomPa'].'",madre="'.$_POST['madre'].'",dom_madre="'.$_POST['DomMa'].'",nombre_emergecia="'.$_POST['emerg'].'",
				domicilio_emergencia="'.$_POST['domEme'].'",tel_emergencia="'.$_POST['telEme'].'",tipo_sangre="'.$_POST['tipSan'].'",imss="'.$_POST["imss"].'",sexo="'.$_POST['sexo'].'",beca="'.$_POST['beca'].'", nombreBeca="'.$_POST['nombreBeca'].'",
				notas="'.$_POST['notas'].'"  WHERE id_alumno='.$_POST['id'].'');			
				

				if ($_POST["tipo_reins"]==1) {
					
					extract($_POST);
					$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre, id_alumno,semestre,matricula,email_enea FROM Alumnos WHERE matricula='".$matricula."' ");
					$datosAl= mysqli_fetch_assoc($alumno);

					if ($datosAl['semestre']>=8) {
						echo '<b><font color="#191970" weight="bold">'.$datosAl['nombre'].'</font>, Ya no puede Reinscribir porque exedio el no. de Semestres permitidos</b>';
					} else {				
						if($datosAl!=0){
							$semin=$datosAl['semestre']+1;
							
							echo'
							<table>
								<tr>
									<td>Nombre </td><td><b>'.$datosAl['nombre'].'</b></td>
									
								</tr>
								<tr>
									<td>Semestre Actual </td><td><b>'.$datosAl['semestre'].'</b></td>
								</tr>
								<tr>
									<td>Semestre a reinscribir:  </td><td><b>'.$semin.'</b></td>
								</tr>
								<tr>
									<td>Matricula</td><td><b>'.$datosAl['matricula'].'</b></td>
								</tr>
								<tr>
									<td>Correo institucional</td><td><b>'.$datosAl['email_enea'].'</b></td>
								</tr>
							</table>';

							if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
										$imagenTmp1=$datosAl["id_alumno"].'.png';
							}
							else{
								if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
									$imagenTmp1=$datosAl["id_alumno"].'.jpg';
								}
								else{
									if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
										$imagenTmp1=$datosAl["id_alumno"].'.gif';
									}
									else {
										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
											$imagenTmp1=$datosAl["id_alumno"].'.svg';
										}
										else {
											$imagenTmp1="disable.gif";
										}
									}
								}
							}	

							echo'
							<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:145px;left:63%;width:23%;border:2px solid grey;border-radius:5px;"/><br/>
							<hr></hr><br>
							<form action="accionesAlumno.php" destino="reinscripciones">					
								<fieldset style="width:50%;">
									<legend><h4>Registro del Pago de reinscripcion</h4></legend>
										<input type="hidden" name="tipo" value="1"/>
										<input type="hidden" name="accion" value="reinscripcion"/>
										<input type="hidden" name="id" value="'.$datosAl['id_alumno'].'"/>
										<table>
											<tr><td>No Autentificacion</td><td>&nbsp; <input type="text" name="auth" required/></td></tr>
											<tr><td>Monto</td><td><b>$</b><input type="number" size="3" step="any" min="0" name="amount" required/></td></tr>
											<tr><td>Fecha de Deposito</td><td>&nbsp; <input type="date" name="fhdes" required ></td></tr>
											<tr><td>Descripcion</td><td><textArea rows="5" cols="25" name="note"></textArea></td></tr>
											<tr><td>Ficha</td><td><input type="file" nombre="ficha" accept=".jpg,.png,.gif" required></td></tr>
										</table>
								
								<center><button>Guardar/Reinscribir</button></center>
								</fieldset>
							</form>';
						}
						mysqli_free_result($alumno);
					}

				} else {
					
					extract($_POST);
					$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre, id_alumno,semestre,matricula,email_enea FROM Alumnos WHERE matricula='".$matricula."' ");
					$datosAl= mysqli_fetch_assoc($alumno);

					if ($datosAl['semestre']>=8) {
						echo '<b><font color="#191970" weight="bold">'.$datosAl['nombre'].'</font>, Ya no puede Reinscribir porque exedio el no. de Semestres permitidos</b>';
					} else {				
						if($datosAl!=0){
							$semin=$datosAl['semestre']+1;
							
							echo'
							<table>
								<tr>
									<td>Nombre </td><td><b>'.$datosAl['nombre'].'</b></td>
									
								</tr>
								<tr>
									<td>Semestre Actual </td><td><b>'.$datosAl['semestre'].'</b></td>
								</tr>
								<tr>
									<td>Semestre a reinscribir:  </td><td><b>'.$semin.'</b></td>
								</tr>
								<tr>
									<td>Matricula</td><td><b>'.$datosAl['matricula'].'</b></td>
								</tr>
								<tr>
									<td>Correo institucional</td><td><b>'.$datosAl['email_enea'].'</b></td>
								</tr>
							</table>';

							if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
										$imagenTmp1=$datosAl["id_alumno"].'.png';
							}
							else{
								if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
									$imagenTmp1=$datosAl["id_alumno"].'.jpg';
								}
								else{
									if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
										$imagenTmp1=$datosAl["id_alumno"].'.gif';
									}
									else {
										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
											$imagenTmp1=$datosAl["id_alumno"].'.svg';
										}
										else {
											$imagenTmp1="disable.gif";
										}
									}
								}
							}	

							echo'
							<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:145px;left:63%;width:23%;border:2px solid grey;border-radius:5px;"/><br/>
							<hr></hr><br>
							<br><form action="accionesAlumno.php" destino="reinscripciones">
								<input type="hidden" name="accion" value="reinscripcion"/>
								<input type="hidden" name="tipo" value="2"/>
								<input type="hidden" name="id" value="'.$datosAl['id_alumno'].'"/>
								<b>*En este Ciclo no se necesita hacer deposito bancario: </b><button>Reinscribir</button>
							</form>
							<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
						}
						mysqli_free_result($alumno);
					}

				}
				
			}

			if($accion=="borrar"){
				$delete= mysqli_query($conexion,"Update Alumnos set status='0' WHERE id_alumno=".$_POST['alumno']);
				$delete1= mysqli_query($conexion,"Update Sai set status='0' WHERE id_alumno=".$_POST['alumno']);
			echo"REGISTRO DESHABILITADO";
			
			echo '<script>
						$("[carga=alumnos]").trigger("click");
						settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
					</script>';
			}
			if($accion=="restaurar"){
				$delete= mysqli_query($conexion,"UPDATE Alumnos set status='1' WHERE id_alumno=".$_POST['id_alumno']);
				$delete1= mysqli_query($conexion,"UPDATE Sai set status='1' WHERE id_alumno=".$_POST['id_alumno']);
			echo"REGISTRO HABILITADO";
			
			echo '<script>
						$("[carga=alumnos]").trigger("click");
						settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
					</script>';
			}

			if($accion=="reinscripcion"){

				if ($_POST["tipo"]=="2") {
					
					extract($_POST);
					$reinscribir = mysqli_query($conexion,"UPDATE Alumnos SET semestre= semestre + 1 WHERE id_alumno=".$id." ");
					if($reinscribir){

							echo'Acontinuacion favor de subir la documentacion requerida para la reinscripcion

							<br><br>

							<form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
								<input type="hidden" name="accion" value="Doc">
								<input type="hidden" name="id" value="'.$id.'">
								Documento : 
								<input type="search" name="NombreDoc" placeholder="Nombre del Documento" required> <input type="file" nombre="doc" accept=".pdf,.jpg" /> <button>Subir documento</button>
							</form>

							<br><b>Documentos subidos:</b>
							<div id="verDoc" style="width:50%;height:80px;border:2px solid grey;padding-top: 10px;padding-left: 10px;overflow: scroll;"></div>
							
							<br><br>
							
							<div nombre="gerenerAcuse" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b>Imprimir Solicitud de Inscripcion</b>							
								<div id="Acuse" style="">

								<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
								
								<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
									<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>	
									<span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'</span>';
									
									$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno= ".$id." ;");
							
									while($datosAl = mysqli_fetch_array($alumnos)){

										$rs = mysqli_query($conexion,"SELECT MAX(id_ciclo) AS id FROM Ciclos");
										if ($row = mysqli_fetch_row($rs)) {
										$id_ciclo = trim($row[0]);
										}
										$ciclo = mysqli_query($conexion, "SELECT * FROM Ciclos WHERE id_ciclo= ".$id_ciclo." ;");
										$datosCi = mysqli_fetch_array($ciclo);


										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
											$imagenTmp1=$datosAl["id_alumno"].'.png';
										}
										else{
											if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
												$imagenTmp1=$datosAl["id_alumno"].'.jpg';
											}
											else{
												if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
													$imagenTmp1=$datosAl["id_alumno"].'.gif';
												}
												else {
													if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
														$imagenTmp1=$datosAl["id_alumno"].'.svg';
													}
													else {
														$imagenTmp1="disable.gif";
													}
												}
											}
										}
										$fecha= $datosAl["fecha_nacimiento"];
										$edad=CalculaEdad($fecha);
										$semestrereins=$datosAl["semestre"]+1;

										if ($datosAl["status"]==1) {
											$sta="Activo, Regular";
										} else {
											$sta="Actibo, Inrregular";
										}
										

										echo'<center><h2>SOLICITUD DE REINSCRIPCION</h2></center>
											<table style="width: 70%;">
												<tr><td> Matricula</td><td>'.$datosAl["matricula"].'</td><td><td></tr>
												<tr><td>Curp</td><td>'.$datosAl["curp"].'</td></td></td></tr>
												<tr><td> Estatus</td><td> '.$sta.' </td><td><td></tr>
												<tr><td>Semestre reinscript@</td><td>'.$datosAl["semestre"].'</td><td></td></tr>
												<tr><td>Licenciatura </td><td>'.$datosAl["carrera"].'</td><td></td></tr>
												<tr><td> Generacion</td><td>'.$datosAl["generacion"].'</td><td><td></tr>
												<tr><td> Turno</td><td>'.$datosAl["turno"].'</td><td><td></tr>
												<tr><td>Apellido Paterno</td><td>'.$datosAl["apellidoP"].'</td><td></td></tr>
												<tr><td>Apellido Materno</td><td>'.$datosAl["apellidoM"].'</td><td></td></tr>
												<tr><td>Nombre</td><td>'.$datosAl["nombre"].'</td><td></td></tr>
												<tr><td>Fecha de Nacimiento</td><td>'.$datosAl["fecha_nacimiento"].'</td></tr>
												<tr><td>Lugar de Nacimiento</td><td>'.$datosAl["lugar_nacimiento"].'</td></tr>
												<tr><td>Domicilio Particular</td><td>'.$datosAl["calle_local"].' #'.$datosAl["num_ext_local"].' int:'.$datosAl["num_int_local"].' </td><td></td></tr>
												<tr><td>Codigo Postal</td><td>'.$datosAl["cp_local"].'</td><td></td></tr>
												<tr><td>Municipio</td><td>'.$datosAl["municipio_local"].'</td><td></td></tr>
												<tr><td>Telefono de Casa</td><td>'.$datosAl["tel_casa"].'</td><td></td></tr>
												<tr><td>Telefono Celular</td><td>'.$datosAl["tel_celular"].'</td><td></td></tr>
												<tr><td>Ciclo escolar</td><td>'.$datosCi["ciclo"].$datosCi["periodo"].'</td><td></td></tr>
												<tr><td>No. de Seguro</td><td>'.$datosAl["imss"].'</td><td></td></tr>
												<tr><td>Email ENEA</td><td>'.$datosAl["email_enea"].'</td><td></td></tr>
												<tr><td>Email Secundario </td><td>'.$datosAl["email"].'</td><td></td></tr>
												<tr><td>Datos del contacto de emergencia </td><td>'.$datosAl["tel_emergencia"].', '.$datosAl["nombre_emergecia"].', '.$datosAl["domicilio_emergencia"].'</td><td></td></tr>
												<tr><td>Usuario SAI</td><td>'.$datosAl["matricula"].'</td><td></td></tr>
												<tr><td>Fecha y Hora de recepcion de Solicitud</td><td>'.date("F j, Y, g:i a").'</td><td></td></tr>
												<tr><td colspan="3">
													<font size="1" weight="bold">
														ME COMPROMETO COMO ALUMNO DE ESTA ESCUELA QUE MIS ACTITUDES Y CONDUCTA RESPONDERAN A LO ESTABLECIDO
														EN LAS LEYES, REGLAMENTO Y DEMAS NORMATIVIDAD ESPECIFICADA EN EL PLAN DE ESTUDIOS QUE SE DERIVAN DE
														LA LEY GENERAL DE EDUCACION Y QUE SE RIGE EN ESTA INSTITUCION, ASI COMO EL TAMBIEN RESPETAR EL 
														RLEGLAMENTO DE LAS ESCUELAS QUE SE ASIGNEN PARA REALIZAR MIS PRACTICAS DE TRABAJO DOCENTE.<BR><BR>

														PROTESTO QUE SON VERDADEROS LOS DATOS QUE SE ANOTO EN LA SOLUCITUD DE INSCRIPCION.
													</font>
												</td><td></td></tr>
											</table>
										<img src="imagenes/alumnos/'.$imagenTmp1.'" alt="alumno" height="250" width="180" style="position:relative;top:-650px;right:-570px;border:2px solid grey;border-radius:5px"/>
										';
									}
																	
								echo'	<div id="verDoc2" style="position:relative;top:-255px;right:-5px;width:40%;height:80px;padding-top: 10px;padding-left: 10px;"><b>Documentos Entregados:<br></b></div>
										<div style="position:relative;top:-305px;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma alumn@</b></div>
										<div style="position:relative;top:-390px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>
										
									
								</div>
									
								</div>

								</div>

							<div nombre="gerenerHorario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b>Imprimir Horario</b>							
								<div id="Horario" style="display:none">

								<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>

								<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
									<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:0%;"/>	
									<span style="position:relative;left:70%;top:0;">'.date("m/d/Y").'</span>
									
									
								</div>
									
								</div>
												
								<img src="imagenes/print.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Horario\').toggle(\'drop\')">
							</div>

							<br><br><center><form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
								<input type="hidden" name="accion" value="end2">
								<button>Finalizar reinscripcion del Alumno</button>
							</form></center>


							';
						
					}
					else{
						echo  mysqli_error($conexion);
					}

				} 
				if ($_POST["tipo"]=="1") {
					
					extract($_POST);
					$reinscribir = mysqli_query($conexion,"UPDATE Alumnos SET semestre= semestre + 1 WHERE id_alumno=".$id." ");
					if($reinscribir){
						$pagos= mysqli_query($conexion,"INSERT INTO Pagos() VALUES(null,'".$_POST['auth']."','".$_POST['fhdes']."','".$id."','".$_POST['note']."','".$_POST['amount']."',1)");
						
						if($pagos){

							$id_pago= mysqli_insert_id($conexion);
							
							if(isset($_FILES['ficha'])){
								$datosImg = explode(".",$_FILES['ficha']['name']);
								$extension= $datosImg[count($datosImg)-1];
								copy($_FILES['ficha']['tmp_name'],"documentacion/alumnos/".$id."/ficha".$id_pago.".".$extension);
							}

							echo'Acontinuacion favor de subir la documentacion requerida para la reinscripcion

							<br><br>

							<form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
								<input type="hidden" name="accion" value="Doc">
								<input type="hidden" name="id" value="'.$id.'">
								Documento : 
								<input type="search" name="NombreDoc" placeholder="Nombre del Documento" required> <input type="file" nombre="doc" accept=".pdf,.jpg" /> <button>Subir documento</button>
							</form>

							<br><b>Documentos subidos:</b>
							<div id="verDoc" style="width:50%;height:80px;border:2px solid grey;padding-top: 10px;padding-left: 10px;overflow: scroll;"></div>
							
							<br><br>
							
							<div nombre="gerenerAcuse" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b>Imprimir Solicitud de Inscripcion</b>							
								<div id="Acuse" style="">

								<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
								
								<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
									<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>	
									<span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'</span>';
									
									$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno= ".$id." ;");
							
									while($datosAl = mysqli_fetch_array($alumnos)){

										$rs = mysqli_query($conexion,"SELECT MAX(id_ciclo) AS id FROM Ciclos");
										if ($row = mysqli_fetch_row($rs)) {
										$id_ciclo = trim($row[0]);
										}
										$ciclo = mysqli_query($conexion, "SELECT * FROM Ciclos WHERE id_ciclo= ".$id_ciclo." ;");
										$datosCi = mysqli_fetch_array($ciclo);


										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
											$imagenTmp1=$datosAl["id_alumno"].'.png';
										}
										else{
											if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
												$imagenTmp1=$datosAl["id_alumno"].'.jpg';
											}
											else{
												if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
													$imagenTmp1=$datosAl["id_alumno"].'.gif';
												}
												else {
													if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
														$imagenTmp1=$datosAl["id_alumno"].'.svg';
													}
													else {
														$imagenTmp1="disable.gif";
													}
												}
											}
										}
										$fecha= $datosAl["fecha_nacimiento"];
										$edad=CalculaEdad($fecha);
										$semestrereins=$datosAl["semestre"]+1;

										if ($datosAl["status"]==1) {
											$sta="Activo, Regular";
										} else {
											$sta="Actibo, Inrregular";
										}
										

										echo'<center><h2>SOLICITUD DE REINSCRIPCION</h2></center>
											<table style="width: 70%;">
												<tr><td> Matricula</td><td>'.$datosAl["matricula"].'</td><td><td></tr>
												<tr><td>Curp</td><td>'.$datosAl["curp"].'</td></td></td></tr>
												<tr><td> Estatus</td><td> '.$sta.' </td><td><td></tr>
												<tr><td>Licenciatura </td><td>'.$datosAl["carrera"].'</td><td></td></tr>
												<tr><td> Generacion</td><td>'.$datosAl["generacion"].'</td><td><td></tr>
												<tr><td> Turno</td><td>'.$datosAl["turno"].'</td><td><td></tr>
												<tr><td>Apellido Paterno</td><td>'.$datosAl["apellidoP"].'</td><td></td></tr>
												<tr><td>Apellido Materno</td><td>'.$datosAl["apellidoM"].'</td><td></td></tr>
												<tr><td>Nombre</td><td>'.$datosAl["nombre"].'</td><td></td></tr>
												<tr><td>Fecha de Nacimiento</td><td>'.$datosAl["fecha_nacimiento"].'</td></tr>
												<tr><td>Lugar de Nacimiento</td><td>'.$datosAl["lugar_nacimiento"].'</td></tr>
												<tr><td>Domicilio Particular</td><td>'.$datosAl["calle_local"].' #'.$datosAl["num_ext_local"].' int:'.$datosAl["num_int_local"].' </td><td></td></tr>
												<tr><td>Codigo Postal</td><td>'.$datosAl["cp_local"].'</td><td></td></tr>
												<tr><td>Municipio</td><td>'.$datosAl["municipio_local"].'</td><td></td></tr>
												<tr><td>Telefono de Casa</td><td>'.$datosAl["tel_casa"].'</td><td></td></tr>
												<tr><td>Telefono Celular</td><td>'.$datosAl["tel_celular"].'</td><td></td></tr>
												<tr><td>Ciclo escolar</td><td>'.$datosCi["ciclo"].$datosCi["periodo"].'</td><td></td></tr>
												<tr><td>No. de Seguro</td><td>'.$datosAl["imss"].'</td><td></td></tr>
												<tr><td>Email ENEA</td><td>'.$datosAl["email_enea"].'</td><td></td></tr>
												<tr><td>Email Secundario </td><td>'.$datosAl["email"].'</td><td></td></tr>
												<tr><td>Dotos del concatto de emergencia </td><td>'.$datosAl["tel_emergencia"].', '.$datosAl["nombre_emergecia"].', '.$datosAl["domicilio_emergencia"].'</td><td></td></tr>
												<tr><td>Usuario SAI</td><td>'.$datosAl["matricula"].'</td><td></td></tr>
												<tr><td>Datos del dopisito de la colegiatura</td><td>'.$_POST["auth"].', $'.$_POST["amount"].', '.$_POST["fhdes"].'</td><td></td></tr>
												<tr><td>Fecha y Hora de recepcion de Solicitud</td><td>'.date("F j, Y, g:i a").'</td><td></td></tr>
												<tr><td>Semestre reinscript@</td><td>'.$datosAl["semestre"].'</td><td></td></tr>
												<tr><td colspan="3">
													<font size="1" weight="bold">
														ME COMPROMETO COMO ALUMNO DE ESTA ESCUELA QUE MIS ACTITUDES Y CONDUCTA RESPONDERAN A LO ESTABLECIDO
														EN LAS LEYES, REGLAMENTO Y DEMAS NORMATIVIDAD ESPECIFICADA EN EL PLAN DE ESTUDIOS QUE SE DERIVAN DE
														LA LEY GENERAL DE EDUCACION Y QUE SE RIGE EN ESTA INSTITUCION, ASI COMO EL TAMBIEN RESPETAR EL 
														RLEGLAMENTO DE LAS ESCUELAS QUE SE AGSINEN PARA REALIZAR MIS PRACTICAS DE TRABAJO DOCENTE.<BR><BR>

														PROTESTO QUE SON VERDADEROS LOS DATOS QUE SE ANOTO EN LA SOLUCITUD DE INSCRIPCION.
													</font>
												</td><td></td></tr>
											</table>
										<img src="imagenes/alumnos/'.$imagenTmp1.'" alt="alumno" height="250" width="180" style="position:relative;top:-650px;right:-570px;border:2px solid grey;border-radius:5px"/>
										';
									}
																	
								echo'	<div id="verDoc2" style="position:relative;top:-255px;right:-5px;width:40%;height:80px;padding-top: 10px;padding-left: 10px;"><b>Documentos Entregados:<br><li>Ficha de deposito bancario</li></b></div>
										<div style="position:relative;top:-305px;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma alumn@</b></div>
										<div style="position:relative;top:-390px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>
										
									
								</div>
									
								</div>

								</div>

							<div nombre="gerenerHorario" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b>Imprimir Horario</b>							
								<div id="Horario" style="display:none">

								<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>

								<div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">				
									<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:0%;"/>	
									<span style="position:relative;left:70%;top:0;">'.date("m/d/Y").'</span>
									
									
								</div>
									
								</div>
												
								<img src="imagenes/print.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Horario\').toggle(\'drop\')">
							</div>

							<br><br><center><form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
								<input type="hidden" name="accion" value="end2">
								<button>Finalizar reinscripcion del Alumno</button>
							</form></center>


							';
						}
						else{
							echo mysqli_error($conexion);
						}
						
						
					}
					else{
						echo  mysqli_error($conexion);
					}

				}
				
			}

			if($accion=="modReins"){
				extract($_POST);
                $modPago = mysqli_query($conexion,"UPDATE Pagos SET num_autorizacion='".$numAut."',notas='".$notas."',importe='".$importe."' WHERE id_pago=".$id_pago." ");
                if($modPago){
                    if(isset($_FILES['ficha'])){
                        $datosImg = explode(".",$_FILES['ficha']['name']);
                        $extension= $datosImg[count($datosImg)-1];
                        copy($_FILES['ficha']['tmp_name'],"documentacion/alumnos/".$id_al."/ficha".$id_pago.".".$extension);
                    }

                    echo'
                    MODIFICACION EXITOSA
                    <script>
                        $("[carga=alumnos]").trigger("click");
                        setTimeout(function(){$("[ mostrar=verPagos]").trigger("click") });
                    </script>';
                }
                else{
                    echo mysqli_error($conexion);
                }
			}

			if($accion=="registroAl"){
				extract($_POST);
				$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre, id_alumno,semestre,matricula,email_enea,carrera FROM Alumnos WHERE matricula='".$matricula."' ");
				$datosAl= mysqli_fetch_assoc($alumno);

				if ($datosAl['semestre']>=8) {
					echo'
						<table>
							<tr>
								<td>Nombre </td><td><b>'.$datosAl['nombre'].'</b></td>
								
							</tr>
							<tr>
								<td>Semestre Actual </td><td><b>'.$datosAl['semestre'].'</b></td>
							</tr>
							<tr>
								<td>Matricula</td><td><b>'.$datosAl['matricula'].'</b></td>
							</tr>
							<tr>
								<td>Correo institucional</td><td><b>'.$datosAl['email_enea'].'</b></td>
							</tr>
						</table>';

						if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
									$imagenTmp1=$datosAl["id_alumno"].'.png';
						}
						else{
							if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
								$imagenTmp1=$datosAl["id_alumno"].'.jpg';
							}
							else{
								if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
									$imagenTmp1=$datosAl["id_alumno"].'.gif';
								}
								else {
									if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
										$imagenTmp1=$datosAl["id_alumno"].'.svg';
									}
									else {
										$imagenTmp1="disable.gif";
									}
								}
							}
						}	

						echo'
						<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:165px;left:63%;width:23%;border:2px solid grey;border-radius:5px;"/><br/>
						<hr></hr>
						<br><b>*Ya no se puede reinscribir porque se encuentra en el 8vo semestre de su plan de Estudios.</b>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
						<center><form destino="resultadoRegistro" action="accionesAlumno.php" style="width:95%">
							<input type="hidden" name="accion" value="end2">
							<button>Salir del procero de reinscripcion</button>
						</form></center><br><br><br>';
				} else {				
					if($datosAl!=0){
						$semin=$datosAl['semestre']+1;
						
						echo'
						<table>
							<tr>
								<td>Nombre </td><td><b>'.$datosAl['nombre'].'</b></td>
								<td>
									<form destino="resultados" action="busqueda.php" >
										<input type="hidden" name="option" value="ver">
										<input type="hidden" name="nombre" value="'.$datosAl['nombre'].'">
										<input type="hidden" name="id" value="'.$datosAl['id_alumno'].'">
										<button>Actulizar datos</button>
									</form>
								</td>
							</tr>
							<tr>
								<td>Semestre Actual </td><td><b>'.$datosAl['semestre'].'</b></td>
							</tr>
							<tr>
								<td>Semestre a reinscribir:  </td><td><b>'.$semin.'</b></td>
							</tr>
							<tr>
								<td>Matricula</td><td><b>'.$datosAl['matricula'].'</b></td>
							</tr>
							<tr>
								<td>Correo institucional</td><td><b>'.$datosAl['email_enea'].'</b></td>
							</tr>
						</table>';

						if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
									$imagenTmp1=$datosAl["id_alumno"].'.png';
						}
						else{
							if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
								$imagenTmp1=$datosAl["id_alumno"].'.jpg';
							}
							else{
								if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
									$imagenTmp1=$datosAl["id_alumno"].'.gif';
								}
								else {
									if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
										$imagenTmp1=$datosAl["id_alumno"].'.svg';
									}
									else {
										$imagenTmp1="disable.gif";
									}
								}
							}
						}	

						echo'
						<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:165px;left:63%;width:23%;border:2px solid grey;border-radius:5px;"/><br/>
						<hr></hr>
						<br><b>*Para poder reinscribir al alumn@ necesita actializar sus datos.</b>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
					}
					else{
						echo'
						<script>
							$("[carga=alumnos]").trigger("click");
							setTimeout(function(){$("[mostrar=reinscripcion]").trigger("click")},1000);
							setTimeout(function(){$("#resultadoRegistro").html("Matricula Invalida").show()},1000);
							$("#resultadoRegistro").html("Matricula Invalida").hide();
						</script>';
					}
					mysqli_free_result($alumno);
				}
			}

			if($accion=="guardarDoc"){
				extract($_POST);
				if(isset($_FILES['doc'])){
					$datosDoc = explode(".", $_FILES['doc']['name']);
					$ext = $datosDoc[count($datosDoc)-1];
					copy($_FILES['doc']['tmp_name'],"documentacion/alumnos/".$id."/".$nombre.".".$ext);

					echo 'Archivo Registrado
					<script>
						$("[carga=alumnos]").trigger("click");
						setTimeout(function(){$("[mostrar=documentosAl]").trigger("click")},1000);
					</script>
					';

				}
				else{
					echo 'No se detecto ningun documento '.$id;
				}
			}
			if($accion=="semestre"){
				$al = mysqli_query($conexion,"SELECT * FROM Alumnos WHERE semestre='".$_POST['semestre']."' AND status=1 ");

				echo'
				
				<div id="dialog-message" title="Reporte " >
							<form id="report" action="accionesAlumno.php"  method="POST" target="_self" >
								<input type="hidden" name="nombre" value="Reporte por semestre">
								<input type="hidden" name="accion" value="reporte">
								<input type="hidden" name="table" id="reporte">

							</form>
						<table style="padding-top:20px;top:30%;left:15%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteSEM">
							<tr bgcolor="#0404B4"><td style="border:none;" colspan="25"><center>REGISTRO DE ALUMNOS POR SEMESTRE</center></td></tr>
							<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
							<tr></tr>
							<tr bgcolor="gray">
								<td>NOMBRE</td>
								<td>MATRICULA</td>
								<td>CURP</td>
								<td>SEMESTRE</td>
								<td>CORREO INSTITUCIONAL</td>
								<td>CARRERA</td>
								<td>Fecha de Nacimiento</td>
								<td>Telefono de Casa</td>
								<td>Telefono Celular</td>
								<td>Email </td>
								<td>Domicilio</td>
								<td>Numero Exterior</td>
								<td>Numero Interior</td>
								<td>Colonia</td>
								<td>Municipio</td>
								<td>Codigo Postal</td>
								<td>Estado</td>
								<td>Nombre del Padre</td>
								<td>En caso de emergencia llamar a </td>
								<td>Domicilio de Emergencia</td>
								<td>Telefono de Emergencia</td>
								<td>Tipo de Sangre</td>
								<td>Bachillerato </td>
								<td>Fecha de Ingreso</td>

							</tr>';
							while($datosAl = mysqli_fetch_assoc($al)){
								echo'
								<tr>
									<td bgcolor="pink">'.$datosAl['apellidoP'].' '.$datosAl['apellidoM'].' '.$datosAl['nombre'].'</td>
									<td>'.$datosAl['matricula'].'</td>
									<td>'.$datosAl['curp'].'</td>
									<td>'.$datosAl['semestre'].'</td>
									<td>'.$datosAl['email_enea'].'</td>
									<td>'.$datosAl['carrera'].'</td>
									<td>'.$datosAl["fecha_nacimiento"].'</td>
									<td>'.$datosAl["tel_casa"].'</td>
									<td>'.$datosAl["tel_celular"].'</td>
									<td>'.$datosAl["calle_local"].'</td>
									<td>'.$datosAl["num_ext_local"].'</td>
									<td>'.$datosAl["num_int_local"].'</td>
									<td>'.$datosAl["colonia_local"].'</td>
									<td>'.$datosAl["municipio_local"].'</td>
									<td>'.$datosAl["cp_local"].'</td>
									<td>'.$datosAl['estado_local'].'</td>
									<td>'.$datosAl["padre"].'</td>
									<td>'.$datosAl["madre"].'</td>
									<td>'.$datosAl["nombre_emergecia"].'</td>
									<td>'.$datosAl["domicilio_emergencia"].'</td>
									<td>'.$datosAl["tel_emergencia"].'</td>
									<td>'.$datosAl["tipo_sangre"].'</td>
									<td>'.$datosAl["bachillerato"].'</td>
									<td>'.$datosAl["fecha_ingreso"].'</td>
								</tr>
								';
							}
					echo'
							
						</table>
					
				<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"90%",
							    height:600,
							    buttons:{
							    	"Exportar a Excel" :function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporteSEM\').eq(0).clone()).html());$(\'#report\').submit();
							    	}
							    }
							    
							});
						});
					</script>';

			}
			if($accion=="carrera"){
				$al = mysqli_query($conexion,"SELECT * FROM Alumnos WHERE carrera='".$_POST['carrera']."' AND status=1 ");

				echo'
				
  
				<div id="dialog-message" title="Reporte " >
							<form  id="report" action="accionesAlumno.php"  method="POST" target="_self">
								<input type="hidden" name="nombre" value="Reportes por carrera">
								<input type="hidden" name="table" id="reporte">
								<input type="hidden" name="accion" value="reporte">
																
							</form>

						<table style="padding-top:20px;top:30%;left:15%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteC">
							<tr bgcolor="#0404B4"><td style="border:none;" colspan="6"><center>REGISTRO DE ALUMNOS POR CARRERA</center></td></tr>
							<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
							<tr></tr>
							<tr bgcolor="gray">
								<td>NOMBRE</td>
								<td>MATRICULA</td>
								<td>CURP</td>
								<td>SEMESTRE</td>
								<td>CORREO INSTITUCIONAL</td>
								<td>CARRERA</td>
								<td>Fecha de Nacimiento</td>
								<td>Telefono de Casa</td>
								<td>Telefono Celular</td>
								<td>Email </td>
								<td>Domicilio</td>
								<td>Numero Exterior</td>
								<td>Numero Interior</td>
								<td>Colonia</td>
								<td>Municipio</td>
								<td>Codigo Postal</td>
								<td>Estado</td>
								<td>Nombre del Padre</td>
								<td>En caso de emergencia llamar a </td>
								<td>Domicilio de Emergencia</td>
								<td>Telefono de Emergencia</td>
								<td>Tipo de Sangre</td>
								<td>Bachillerato </td>
								<td>Fecha de Ingreso</td>

							</tr>';
							while($datosAl = mysqli_fetch_assoc($al)){
								echo'
								<tr>
									<td bgcolor="pink">'.$datosAl['apellidoP'].' '.$datosAl['apellidoM'].' '.$datosAl['nombre'].'</td>
									<td>'.$datosAl['matricula'].'</td>
									<td>'.$datosAl['curp'].'</td>
									<td>'.$datosAl['semestre'].'</td>
									<td>'.$datosAl['email_enea'].'</td>
									<td>'.$datosAl['carrera'].'</td>
									<td>'.$datosAl["fecha_nacimiento"].'</td>
									<td>'.$datosAl["tel_casa"].'</td>
									<td>'.$datosAl["tel_celular"].'</td>
									<td>'.$datosAl["calle_local"].'</td>
									<td>'.$datosAl["num_ext_local"].'</td>
									<td>'.$datosAl["num_int_local"].'</td>
									<td>'.$datosAl["colonia_local"].'</td>
									<td>'.$datosAl["municipio_local"].'</td>
									<td>'.$datosAl["cp_local"].'</td>
									<td>'.$datosAl['estado_local'].'</td>
									<td>'.$datosAl["padre"].'</td>
									<td>'.$datosAl["madre"].'</td>
									<td>'.$datosAl["nombre_emergecia"].'</td>
									<td>'.$datosAl["domicilio_emergencia"].'</td>
									<td>'.$datosAl["tel_emergencia"].'</td>
									<td>'.$datosAl["tipo_sangre"].'</td>
									<td>'.$datosAl["bachillerato"].'</td>
									<td>'.$datosAl["fecha_ingreso"].'</td>
								</tr>
								';
							}
					echo'
						
						</table>
										
				</div>
					<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"90%",
							   height:600,
							    buttons:{
							    	"Expotar a Excel":function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporteC\').eq(0).clone()).html());$(\'#report\').submit();
							    	}
							    }
							    
							});
						});
					</script>';

			}
			if($accion=="status"){

				if ($_POST['status1']==2) {
					$al = mysqli_query($conexion,"SELECT * FROM Alumnos ");

					echo'			
					<div id="dialog-message" title="Reporte " >
								<form id="report" action="accionesAlumno.php"  method="POST" target="_self" >
									<input type="hidden" name="nombre" value="Reporte de todos los alumnos">
									<input type="hidden" name="table" id="reporte">
									<input type="hidden" name="accion" value="reporte">
									
								</form>
							<table style="padding-top:20px;top:30%;left:10%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteA">
								<tr bgcolor="#0404B4"><td style="border:none;" colspan="7"><center>REGISTRO DE TODOS LOS ALUMNOS</center></td></tr>
								<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
								<tr></tr>
								<tr bgcolor="gray">
									<td>NOMBRE</td>
									<td>MATRICULA</td>
									<td>CURP</td>
									<td>SEMESTRE</td>
									<td>CORREO INSTITUCIONAL</td>
									<td>CARRERA</td>
									<td>Fecha de Nacimiento</td>
									<td>Telefono de Casa</td>
									<td>Telefono Celular</td>
									<td>Email </td>
									<td>Domicilio</td>
									<td>Numero Exterior</td>
									<td>Numero Interior</td>
									<td>Colonia</td>
									<td>Municipio</td>
									<td>Codigo Postal</td>
									<td>Estado</td>
									<td>Nombre del Padre</td>
									<td>En caso de emergencia llamar a </td>
									<td>Domicilio de Emergencia</td>
									<td>Telefono de Emergencia</td>
									<td>Tipo de Sangre</td>
									<td>Bachillerato </td>
									<td>Fecha de Ingreso</td>

								</tr>';
								while($datosAl = mysqli_fetch_assoc($al)){
									echo'
										<tr>
										<td bgcolor="pink">'.$datosAl['apellidoP'].' '.$datosAl['apellidoM'].' '.$datosAl['nombre'].'</td>
										<td>'.$datosAl['matricula'].'</td>
										<td>'.$datosAl['curp'].'</td>
										<td>'.$datosAl['semestre'].'</td>
										<td>'.$datosAl['email_enea'].'</td>
										<td>'.$datosAl['carrera'].'</td>
										<td>'.$datosAl["fecha_nacimiento"].'</td>
										<td>'.$datosAl["tel_casa"].'</td>
										<td>'.$datosAl["tel_celular"].'</td>
										<td>'.$datosAl["calle_local"].'</td>
										<td>'.$datosAl["num_ext_local"].'</td>
										<td>'.$datosAl["num_int_local"].'</td>
										<td>'.$datosAl["colonia_local"].'</td>
										<td>'.$datosAl["municipio_local"].'</td>
										<td>'.$datosAl["cp_local"].'</td>
										<td>'.$datosAl['estado_local'].'</td>
										<td>'.$datosAl["padre"].'</td>
										<td>'.$datosAl["madre"].'</td>
										<td>'.$datosAl["nombre_emergecia"].'</td>
										<td>'.$datosAl["domicilio_emergencia"].'</td>
										<td>'.$datosAl["tel_emergencia"].'</td>
										<td>'.$datosAl["tipo_sangre"].'</td>
										<td>'.$datosAl["bachillerato"].'</td>
										<td>'.$datosAl["fecha_ingreso"].'</td>
									</tr>
									';
								}
						echo'

								
							</table>
						
					</div>
						<script>
							$(function() {
							    $( "#dialog-message" ).dialog({
								    modal: true,
								    width:"90%",
								   height:600,
								    buttons:{
								    	exportar:function(){
								    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporteA\').eq(0).clone()).html());$(\'#report\').submit();
								    	}
								    }
								    
								});
							});
						</script>';
				} else {
					$al = mysqli_query($conexion,"SELECT * FROM Alumnos WHERE status='".$_POST['status1']."' ");

					echo'			
					<div id="dialog-message" title="Reporte " >
								<form id="report" action="accionesAlumno.php"  method="POST" target="_self" >
									<input type="hidden" name="nombre" value="Reporte por status">
									<input type="hidden" name="table" id="reporte">
									<input type="hidden" name="accion" value="reporte">
									
								</form>
							<table style="padding-top:20px;top:30%;left:10%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReportest">
								<tr bgcolor="#0404B4"><td style="border:none;" colspan="7"><center>REGISTRO DE ALUMNOS POR STATUS</center></td></tr>
								<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
								<tr></tr>
								<tr bgcolor="gray">
									<td>NOMBRE</td>
									<td>MATRICULA</td>
									<td>CURP</td>
									<td>SEMESTRE</td>
									<td>CORREO INSTITUCIONAL</td>
									<td>CARRERA</td>
									<td>Fecha de Nacimiento</td>
									<td>Telefono de Casa</td>
									<td>Telefono Celular</td>
									<td>Email </td>
									<td>Domicilio</td>
									<td>Numero Exterior</td>
									<td>Numero Interior</td>
									<td>Colonia</td>
									<td>Municipio</td>
									<td>Codigo Postal</td>
									<td>Estado</td>
									<td>Nombre del Padre</td>
									<td>En caso de emergencia llamar a </td>
									<td>Domicilio de Emergencia</td>
									<td>Telefono de Emergencia</td>
									<td>Tipo de Sangre</td>
									<td>Bachillerato </td>
									<td>Fecha de Ingreso</td>

								</tr>';
								while($datosAl = mysqli_fetch_assoc($al)){
									echo'
										<tr>
										<td bgcolor="pink">'.$datosAl['apellidoP'].' '.$datosAl['apellidoM'].' '.$datosAl['nombre'].'</td>
										<td>'.$datosAl['matricula'].'</td>
										<td>'.$datosAl['curp'].'</td>
										<td>'.$datosAl['semestre'].'</td>
										<td>'.$datosAl['email_enea'].'</td>
										<td>'.$datosAl['carrera'].'</td>
										<td>'.$datosAl["fecha_nacimiento"].'</td>
										<td>'.$datosAl["tel_casa"].'</td>
										<td>'.$datosAl["tel_celular"].'</td>
										<td>'.$datosAl["calle_local"].'</td>
										<td>'.$datosAl["num_ext_local"].'</td>
										<td>'.$datosAl["num_int_local"].'</td>
										<td>'.$datosAl["colonia_local"].'</td>
										<td>'.$datosAl["municipio_local"].'</td>
										<td>'.$datosAl["cp_local"].'</td>
										<td>'.$datosAl['estado_local'].'</td>
										<td>'.$datosAl["padre"].'</td>
										<td>'.$datosAl["madre"].'</td>
										<td>'.$datosAl["nombre_emergecia"].'</td>
										<td>'.$datosAl["domicilio_emergencia"].'</td>
										<td>'.$datosAl["tel_emergencia"].'</td>
										<td>'.$datosAl["tipo_sangre"].'</td>
										<td>'.$datosAl["bachillerato"].'</td>
										<td>'.$datosAl["fecha_ingreso"].'</td>
									</tr>
									';
								}
						echo'

								
							</table>
						
					</div>
						<script>
							$(function() {
							    $( "#dialog-message" ).dialog({
								    modal: true,
								    width:"90%",
								   height:600,
								    buttons:{
								    	exportar:function(){
								    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReportest\').eq(0).clone()).html());$(\'#report\').submit();
								    	}
								    }
								    
								});
							});
						</script>';
				}
				
				
			}
			if($accion=="pagosq"){
				$al = mysqli_query($conexion,"SELECT * FROM Pagos WHERE fecha_desposito BETWEEN '".$_POST["fhde"]."'  AND '".$_POST["fha"]."' ORDER BY id_pago,fecha_desposito ASC ");

				echo'
				
  
				<div id="dialog-message" title="Reporte " >
							<form  id="report" action="accionesAlumno.php"  method="POST" target="_self">
								<input type="hidden" name="nombre" value="Reporte de Pagos">
								<input type="hidden" name="table" id="reporte">
								<input type="hidden" name="accion" value="reporte">
																
							</form>

						<table style="padding-top:20px;top:30%;left:15%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteP">
							<tr bgcolor="#0404B4"><td style="border:none;" colspan="6"><center>REGISTRO DE PAGOS DE: '.$_POST["fhde"].' A: '.$_POST["fha"].'</center></td></tr>
							<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
							<tr></tr>
							<tr bgcolor="gray">
								<td>No. de pago</td>
								<td>Nombre del alumno</td>
								<td>No. de Autorizacion</td>
								<td>Fecha de deposito</td>
								<td>Descripcion</td>
								<td>Importe</td>
								

							</tr>';
							while($datosAl = mysqli_fetch_array($al)){
								$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre FROM Alumnos WHERE id_alumno='".$datosAl['id_alumno']."' ");
								$datosAla = mysqli_fetch_array($alumno);
								echo'
								<tr>
									<td bgcolor="pink">'.$datosAl['id_pago'].'</td>
									<td>'.$datosAla['nombre'].'</td>
									<td>'.$datosAl['num_autorizacion'].'</td>
									<td>'.$datosAl['fecha_desposito'].'</td>
									<td>'.$datosAl['notas'].'</td>
									<td>$ '.$datosAl['importe'].'</td>
									
								</tr>
								';
							}
					echo'
						
						</table>
										
				</div>
					<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"90%",
							   height:600,
							    buttons:{
							    	"Expotar a Excel":function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporteP\').eq(0).clone()).html());$(\'#report\').submit();
							    	}
							    }
							    
							});
						});
					</script>';

			}
			if($accion=="pagosa"){
				$al = mysqli_query($conexion,"SELECT * FROM Pagos WHERE id_alumno=".$_POST["nombre"].";");

				echo'
				
  
				<div id="dialog-message" title="Reporte " >
							<form  id="report" action="accionesAlumno.php"  method="POST" target="_self">
								<input type="hidden" name="nombre" value="Reporte de Pagos">
								<input type="hidden" name="table" id="reporte">
								<input type="hidden" name="accion" value="reporte">
																
							</form>

						<table style="padding-top:20px;top:30%;left:15%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteP">
							<tr bgcolor="#0404B4"><td style="border:none;" colspan="6"><center>REGISTRO DE PAGOS DE: '.$_POST["fhde"].' A: '.$_POST["fha"].'</center></td></tr>
							<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
							<tr></tr>
							<tr bgcolor="gray">
								<td>No. de pago</td>
								<td>Nombre del alumno</td>
								<td>No. de Autorizacion</td>
								<td>Fecha de deposito</td>
								<td>Descripcion</td>
								<td>Importe</td>
								

							</tr>';
							while($datosAl = mysqli_fetch_array($al)){
								$alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre FROM Alumnos WHERE id_alumno='".$datosAl['id_alumno']."' ");
								$datosAla = mysqli_fetch_array($alumno);
								echo'
								<tr>
									<td bgcolor="pink">'.$datosAl['id_pago'].'</td>
									<td>'.$datosAla['nombre'].'</td>
									<td>'.$datosAl['num_autorizacion'].'</td>
									<td>'.$datosAl['fecha_desposito'].'</td>
									<td>'.$datosAl['notas'].'</td>
									<td>$ '.$datosAl['importe'].'</td>
									
								</tr>
								';
							}
					echo'
						
						</table>
										
				</div>
					<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"90%",
							   height:600,
							    buttons:{
							    	"Expotar a Excel":function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporteP\').eq(0).clone()).html());$(\'#report\').submit();
							    	}
							    }
							    
							});
						});
					</script>';

			}
			if($accion=="reporte"){
				try{
					
					header("Pragma: public");
					header("Content-Disposition: filename=".$_POST['nombre'].".xls");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');					
					header("Pragma: no-cache");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Cache-Control: public");
					header("Expires: 0");
					header("Content-Type: application/force-download");
					echo $_POST['table'];

				}
				catch(Exception $e){
				    echo $e->getMessage();

				}		
					
			}

			if($accion=="egresar"){
				
			$delete= mysqli_query($conexion,"Update Alumnos set semestre='13' WHERE id_alumno=".$_POST['egresado']);
			echo"Alumno Egresado con Exito...";
			
			echo '<script>
						$("[carga=alumnos]").trigger("click");
						settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
					</script>';

			}

			if($accion=="titular"){
				
			$delete= mysqli_query($conexion,"Update Alumnos set semestre='14' WHERE id_alumno=".$_POST['titulado']);
			$delete= mysqli_query($conexion,"Update Sai set status='0' WHERE id_alumno=".$_POST['titulado']);
			echo"Alumno Egresado con Exito...";
			
			echo '<script>
						$("[carga=alumnos]").trigger("click");
						settimeout(function(){$("[ mostrar=restaurarA ]").trigger("click") });
					</script>';
					
			}
		}
	}	
	function CalculaEdad( $fecha ) {
    	list($Y,$m,$d) = explode("-",$fecha);
    	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
?>

