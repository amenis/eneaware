<?php
session_start();
	include("conexion.php");
	echo '
	<div id="con" style="overflow:auto;height:100%">

		<h1>Seguimiento Academico <font color="#191970" weight="bold">Institucional</font> ( SA<font color="#191970" weight="bold">I</font> )</h1>
			
		<button class="tab" style="border-bottom:none;" mostrar="Registro" disabled >General</button>
		<button class="tab seleccionado" style="border-bottom:none;" mostrar="Agsi_mati">Reportes SAI</button>
		<button class="tab " style="border-bottom:none;" mostrar="Sai" permiso="A" disabled>Panel de Control</button>';
			
	   echo'<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
				<br><br>
				<button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
					
	   			<div style="font-family:Arial;margin:auto;padding:2cm;background:white;width:17.5cm;border:1px solid grey; height:24cm">';
						$hoy = date("Y-m-d");
						$hora = date("H:i:s");
						
						$constancua = mysqli_query($conexion, "SELECT MAX(id_constancia) FROM Constancias");
						$arrCom = mysqli_fetch_row($constancua);
						mysqli_free_result($constancua);
						
						$sac = mysqli_query($conexion, "SELECT * FROM Ciclos  ;");
						while ($datos = mysqli_fetch_array($sac)) {
							$semestre=$datos["ciclo"].$datos["periodo"];
						}

						$sac = mysqli_query($conexion, "SELECT * FROM Constancias  ;");
						$numpro1 = mysqli_num_rows($sac);
						if($numpro1>0){
							while ($datos = mysqli_fetch_array($sac)) {
								$semestre2=$datos["periodo"];
								$id=$datos["no_constancia"];
							}
						}

						$pro= mysqli_query($conexion,"SELECT * FROM Constancias ;");
						$numpro = mysqli_num_rows($pro);

						if ($semestre2==$semestre) {
							$NoCons=$id;
							$NoCons++;
						} else {
							$NoCons=1;
						}
						

						
						

						$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE matricula= ".$_POST['matricula']." ;");
				
						while($datosAl = mysqli_fetch_array($alumnos)){

							if ($datosAl["turno"]=="MATUTINO") {
								$horario="7:00 a 14:00";
							}else{
								$horario="14:00 a 21:00";
							}

							$ins= mysqli_query($conexion,"INSERT INTO Constancias() VALUES(null,'".$NoCons."','".$datosAl["id_alumno"]."','".$semestre."','".$hoy."','".$hora."')");

						echo '<br><br><br><br><br><br>
						<div style="width:100%;text-align:right">CONSTANCIA N°   '.$NoCons.'/
						'.$semestre.'. </div><br>
						<div style="padding:5px"></div>
						<div contenteditable id="encabezadoCom" style="font-weight:bold;text-align:width:100%; "></div>
						<b>A QUIEN CORRESPONDA:</b><br><br>
						
						<div contenteditable id="contCom" style="width:100%;text-align:justify;line-height:150%">
							
						La que suscribe, Directora de la Escuela Normal para Educadoras de Arandas, Jalisco, 
						CLAVE: 14ENL0010N,  extiende la presente:<br><br>

						<center><b>C O N S T A N C I A &nbsp;  D E  &nbsp; E S T U D I O S</b></center>	<br>

						A: <b>'.$datosAl["apellidoP"].' '.$datosAl["apellidoM"].' '.$datosAl["nombre"].'</b>, con número de matrícula <b>'.$datosAl["matricula"].'</b>, 
						quien es estudiante del primer año semestre uno de la <b> '.$datosAl["carrera"].'
						 (PLAN 2012)</b>, en esta Institución a mi cargo, de lunes a viernes 
						en el turno matutino de las '.$horario.' horas.<br><br>

						El semestre, comprende un período del _ocho de febrero de dos mil dieciséis_ 
						al _quince de julio de dos mil dieciséis_.<br><br>

						Se extiende la presente en Arandas, Jalisco, a los ocho días del mes de febrero 
						del año dos mil dieciséis.
　　　　					
							<div style="text-align:center">';
								$director = mysqli_query($conexion,"SELECT * FROM Direccion");
								$datoName = mysqli_fetch_assoc($director);
								mysqli_free_result($director);
								echo'
								ATENTAMENTE<br>
								<br>
								<b>	<br><br><br>	
								<br>
								'.$datoName['nombre_direc'].'<br>
								DIRECTORA
								</b></b>
							</div>
						<br><br>LCRV/selj
						</div>';
						}
					echo'</div>
					<br><br><center><form destino="con" action="seguimiento.php" style="width:95%">
					<input type="hidden" name="accion" value="end">
					<button>Finalizar</button>
				</form></center>
				<br><br>
			</div>
	</div>
	';
	
	mysqli_close($conexion);
?>