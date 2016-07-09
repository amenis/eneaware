<script src="js/encuesta.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<style>
	.bot{
	text-align: center;
	padding-bottom: 10px;
	padding-top: 10px;
	background-color: ghostwhite;
	border:none;
	margin: 0;
	border:1px solid rgba(0,0,0,0.2);
	font-family: biko;
	font-size: 11pt;
	}
	.bot:hover{
		background: -webkit-linear-gradient(top, #00b7ea 0%,#009ec3 100%);
		color: white;
		cursor: pointer;
	}
</style>
<?php
session_start();
include("conexion.php");	
$accion = $_POST["option"];
$periodo = "";
 
if($accion=="Edit"){
	
	$encuesta = $_POST["encuesta"];
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Editar Contenido de la Encuesta</h1>
			<font color="#191970" weight="bold"> Instrucciones: </font><br/> 
			Para modificar lo que desee eliga la opcion correspondiente:<hr></hr><br/>
			<button class="tab seleccionado"  style="border-bottom:none;"  mostrar="sec">Modificr Nombre de Seccion</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="pre">Modificar Pregunta de Secciones</button>	
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="ap">Modificar Nombre de Apartado</button>	
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="preAp">Modificar Pregunta de Apartados</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
				<div id="sec" class="tabCont">
					<h2>Modificar Nombre de Seccion</h2>
					<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditSec">';
					$req = mysqli_query($conexion,"SELECT * FROM Secciones WHERE id_encuesta=".$encuesta.";");
					$num = mysqli_num_rows($req);
								if($num>0){
									echo"<br/><select name='encuesta' id='SecSec' >
									<option value='0'>Seleccion la Seccion que desea modificar...</option>";
									while($datos = mysqli_fetch_array($req)){
												echo"<option value='".$datos["id_seccion"]."'>".$datos["nombre_seccion"]."</option>";
									}
									echo"</select>";		
								}
								else {
									echo "no selecciono ninguna encuesta";
								}			
					echo'		<input type="text" id="UpSec" name="Usec" style="display:none;"/>
								<button>Editar</button>
								</form><br/><br/>';
		echo'   </div>


				
				<div id="ap" class="tabCont" Style="Display:none">
					<h2>Modificar Nombre de Apartado</h2>
					<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditAp">';
					$req = mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$encuesta.";");
					$num = mysqli_num_rows($req);
								if($num>0){
									echo"<br/><select name='encuesta' id='SecAp' >
									<option value='0'>Seleccion el Apartado que desea modificar...</option>";
									while($datos = mysqli_fetch_array($req)){
												echo"<option value='".$datos["id_apartado"]."'>".$datos["nombre_apartado"]."</option>";
									}
									echo"</select>";		
								}
								else {
									echo "no selecciono ninguna encuesta";
								}			
					echo'		<input type="text" id="UpAp" name="Uap" style="display:none;"/>
								<button>Editar</button>
								</form><br/><br/>';
		echo'   </div>
				


				
				<div id="pre" class="tabCont" style="display:none">
					<h2>Modificar Preguntas de Seccion</h2>
					
					<form destino="pasos" action="editarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditPre">';
					
					echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para editar la pregunta seleccione la pregunta que desee y de click en seleccionar</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
					
						$pre = mysqli_query($conexion,"SELECT * FROM Preguntas WHERE id_encuesta=".$encuesta.";");
						$con = mysqli_num_rows($pre);
								
								if($con>0){
									echo"<br/><select name='pregunta' style='width:500px;' >
									<option value='0'>Seleccion la Pregunta que desea modificar...</option>";
									while($datos = mysqli_fetch_array($pre)){
												echo"<option value='".$datos["id_pregunta"]."'>".$datos["pregunta"]."</option>";
									}
									echo"</select>";				
								}
					
	echo'			<input type="text" name="encuesta" value="'.$encuesta.'" style="display:none;"/>
					<button>Seleccionar</button>
					</form>    <br/><br/>
	
			</div>';

	echo '
					<div id="preAp" class="tabCont" style="display:none">
					<h2>Modificar Preguntas de Apartado</h2>
					
					<form destino="pasos" action="editarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditAp">';
					
					$req = mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$encuesta.";");
					$num = mysqli_num_rows($req);
								if($num>0){
									echo"<br/><select name='apartado' id='SecAp' >
									<option value='0'>Seleccion el Apartado que muestrar preguntas...</option>";
									while($datos = mysqli_fetch_array($req)){
												echo"<option value='".$datos["id_apartado"]."'>".$datos["nombre_apartado"]."</option>";
									}
									echo"</select>";		
								}
								else {
									echo "no selecciono ninguna encuesta";
								}	

			echo'
					<button>Seleccionar</button><br/>
					</form>    <br/></br>
	
			</div>';
		   	
	echo'	</div>
		</div>';
	}	
	
	
	if($accion=="EditPre"){
	
	$encuesta = $_POST["encuesta"];
	$prregunta = $_POST["pregunta"];
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Editar Contenido de la Encuesta</h1>
			<font color="#191970" weight="bold"> Instrucciones: </font><br/> 
			Para modificar lo que desee eliga la opcion correspondiente:<hr></hr><br/>
			<button class="tab"  style="border-bottom:none;"  mostrar="sec" disabled>Modificr Nombre de Seccion</button>
			<button class="tab seleccionado" style="border-bottom:none;" id="ref" mostrar="pre">Modificar Pregunta de Secciones</button>	
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="ap" disabled>Modificar Nombre de Apartado</button>	
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="preAp" disabled>Modificar Pregunta de Apartados</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
			
				<div id="pre" class="tabCont" >
					<h2>Modificar Preguntas</h2>
					
					
					<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditPre">';
					
					echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para editar la pregunta seleccione la pregunta solo cambie lo que desee</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
					$cont=0;
					
					$pre = mysqli_query($conexion,"SELECT * FROM Preguntas WHERE id_pregunta=".$prregunta.";");
					$con = mysqli_num_rows($pre);
					$res = mysqli_query($conexion,"SELECT * FROM Respuestas WHERE id_pregunta=".$prregunta.";");
					$conR = mysqli_num_rows($res);
					
								if($con>0){
									while($datos = mysqli_fetch_array($pre)){
											echo '<b>¿</b><input type="text" name="preM" style="width:370px" value="'.$datos["pregunta"].'"/><b>?</b><br/>';
									}			
								}
								if ($conR>0) {
									for($x=1;$x<=$conR;$x++){
												$dato = mysqli_fetch_array($res);
												$tipo = $dato["tipo_respuesta"];
												if ($dato["opciones"]=="abierta") {
													echo '<br/><b>La respuesta de esta pregunta es abierta...</b>';
												} else {
													$cont++;
													echo 'Opcion '.$x.':<br><input type="text" name="resM'.$x.'" value="'.$dato["opciones"].'"/><input type="text" name="id'.$x.'" value="'.$dato["id_respuesta"].'" style="display:none;"/><br/>';
												}
												$c = $x;
											}
								}
								echo '<input type="text" value="'.$tipo.'" name="tipo_respuesta" style="display:none;"/>
									  <input type="text" value="'.$prregunta.'" name="pregunta"  style="display:none;"/>
									  <input type="text" value="'.$conR.'" name="op" style="display:none;"/>';
					
	echo'	    	<center><button>Editar</button></center><br/>
				</form>
				</div>';

	
		   	
	echo'	</div>
		</div>';
	}	


	if($accion=="EditAp"){
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Editar Contenido de la Encuesta</h1>
			<font color="#191970" weight="bold"> Instrucciones: </font><br/> 
			Para modificar lo que desee eliga la opcion correspondiente:<hr></hr><br/>
			<button class="tab"  style="border-bottom:none;"  mostrar="sec" disabled>Modificr Nombre de Seccion</button>
			<button class="tab" style="border-bottom:none;"   mostrar="pre" disabled>Modificar Pregunta de Secciones</button>	
			<button class="tab" style="border-bottom:none;"   mostrar="ap" disabled>Modificar Nombre de Apartado</button>	
			<button class="tab seleccionado" style="border-bottom:none;" id="ref" mostrar="preAp">Modificar Pregunta de Apartados</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
	
					<div id="preAp" class="tabCont">
					<h2>Modificar Preguntas de Apartado</h2>
					
					<form destino="pasos" action="editarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditPreAp">';
					
					echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para editar la pregunta seleccione la pregunta que desee y de click en seleccionar</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
					
						$pre = mysqli_query($conexion,"SELECT * FROM Preguntas_apartado WHERE id_apartado=".$_POST["apartado"].";");
						$con = mysqli_num_rows($pre);
								
								if($con>0){
									echo"<br/><select name='pregunta' >
									<option value='0'>Seleccion la Pregunta que desea modificar...</option>";
									while($datos = mysqli_fetch_array($pre)){
												echo"<option value='".$datos["id_pregunta_apartado"]."'>".$datos["pregunta"]."</option>";
									}
									echo"</select>";				
								}
					
	echo'			
					<button>Seleccionar</button>

			
					</form>  <br/><br/>  
	
			</div>';
		   	
	echo'	</div>
		</div>';
	}	

	if($accion=="EditPreAp"){
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Editar Contenido de la Encuesta</h1>
			<font color="#191970" weight="bold"> Instrucciones: </font><br/> 
			Para modificar lo que desee eliga la opcion correspondiente:<hr></hr><br/>
			<button class="tab"  style="border-bottom:none;"  mostrar="sec" disabled>Modificr Nombre de Seccion</button>
			<button class="tab" style="border-bottom:none;"   mostrar="pre" disabled>Modificar Pregunta de Secciones</button>	
			<button class="tab" style="border-bottom:none;"   mostrar="ap" disabled>Modificar Nombre de Apartado</button>	
			<button class="tab seleccionado" style="border-bottom:none;" id="ref" mostrar="preAp">Modificar Pregunta de Apartados</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
	
					<div id="preAp" class="tabCont">
					<h2>Modificar Preguntas de Apartado</h2>
					
					<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
					<input type="hidden" name="option" value="EditPreAp">';
					
					echo "<font color='#191970' weight='bold'>Instrucciones:</font> <br/> 
							<b>Para editar la pregunta seleccione la pregunta que desee y de click en seleccionar</b><br/>
						   (<b>OJO:</b> Revise bien su ortografia)<hr></hr>";
					$cont=0;
					
					$pre = mysqli_query($conexion,"SELECT * FROM Preguntas_apartado WHERE id_pregunta_apartado=".$_POST["pregunta"].";");
					$con = mysqli_num_rows($pre);
					$res = mysqli_query($conexion,"SELECT * FROM Respuestas_apartado WHERE id_pregunta_apartado=".$_POST["pregunta"].";");
					$conR = mysqli_num_rows($res);
					
								if($con>0){
									while($datos = mysqli_fetch_array($pre)){
											echo '<b>¿</b><input type="text" name="preM" style="width:370px" value="'.$datos["pregunta"].'"/><b>?</b><br/>';
									}			
								}
								if ($conR>0) {
									for($x=1;$x<=$conR;$x++){
												$dato = mysqli_fetch_array($res);
												$tipo = $dato["tipo_respuesta"];
												if ($dato["opciones"]=="abierta") {
													echo '<br/><b>La respuesta de esta pregunta es abierta...</b>';
												} else {
													$cont++;
													echo 'Opcion '.$x.':<br><input type="text" name="resM'.$x.'" value="'.$dato["opciones"].'"/><input type="text" name="id'.$x.'" value="'.$dato["id_respuesta_apartado"].'" style="display:none;"/><br/>';
												}
												$c = $x;
											}
								}
								echo '<input type="text" value="'.$tipo.'" name="tipo_respuesta" style="display:none;"/>
									  <input type="text" value="'.$_POST["pregunta"].'" name="pregunta"  style="display:none;"/>
									  <input type="text" value="'.$conR.'" name="op" style="display:none;"/>';
					
					
	echo'			
					<center><button>Editar</button></center><br/>

			
					</form>    
	
			</div>';
		   	
	echo'	</div>
		</div>';
	}	
	
	
	
	mysqli_close($conexion);
?>