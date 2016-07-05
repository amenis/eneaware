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
 
if($accion=="Add"){
	
	$encuesta = $_POST["encuesta"];
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Registro de la pregunta:</h1><br/>
			<font color="#191970" weight="bold"> Instrucciones: </font><hr></hr> Para registar la pregunta favor de seguir los pasos que se muestran acontinuacion<br/>
			<button class="tab seleccionado"  style="border-bottom:none;"  mostrar="paso1">PASO 1: Seleccion de Seccion</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso3">PASO 2: Crear Pregunta</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
			<form destino="resultadoRegistro" action="guardarEncuesta.php">
			<input type="hidden" name="option" value="pregunta">
			
				<div id="paso1" class="tabCont">
					<h2>Seleccionar Seccion</h2>
					
					  <font color="#191970" weight="bold">Instrucciones:</font> <br/> 
					  <b>Seleccione la seccion a agregar pregunta</b><br/>';
					
					
							$req = mysqli_query($conexion,"SELECT * FROM Secciones WHERE id_encuesta=".$encuesta.";");
							$num = mysqli_num_rows($req);
								
							echo"<br/><select name='seccion'  >
							<option value='0'>Seleccion la Seccion donde desea que la pregunta se agrege...</option>";
							
								if($num>0){
									
									while($datos = mysqli_fetch_array($req)){
												echo"<option value='".$datos["id_seccion"]."'>".$datos["nombre_seccion"]."</option>";
									}
													
								}
							echo"</select>";	
							
							
				echo'		<input type="text" name="encuesta" value="'.$encuesta.'" style="display:none;"/>

				<br/>
				</div>
				
				
				<div id="paso3" class="tabCont" style="display:none">
					<h2>Cree la pregunta Preguntas</h2>';
					
				echo'		<div id="Bot" style="position:absolute; left:45%; display: none;">
							 	<img src="imagenes/plus.png" id="AddOp" style="cursor: pointer;" title="Agregar opcion"> &nbsp;
							 	<img src="imagenes/minus.png" id="DelOp" style="cursor: pointer;" title="Quitar opcion">
							 	<img src="imagenes/database.png" id="AddOt" style="cursor: pointer;" title="Agregar opcion abierta"> &nbsp;
							 	<img src="imagenes/minus.png" id="DelOt" style="cursor: pointer;" title="Quitar opcion"> &nbsp;
							</div>
							<img src="imagenes/repeat.png" id="Atras" style=" position:absolute; top:1%; left:30%; cursor: pointer; display: none;" title="Regesar">
							<b>Pregunta: ¿</b> <input type="text" style="width:370px" name="pregunta" required="required"/><b>?</b><br/><br/>

							<div id="Res">
							<b>Eliga el tipo de Respuesta:</b>
							<input type="radio" id="Abierta" name="tipo" value="Abierta" />Abierta &nbsp;&nbsp;&nbsp; 
							<input type="radio" id="PorOp"  name="tipo" value="Poropciones" />Por Opciones
							</div>
							
							<div id="opciones" style="display: none;">
							<div id="1"><b>Opcion 1:</b><br/>
							<input type="text" name="op1" /></div>
							<div id="2"><b>Opcion 2:</b><br/>
							<input type="text" name="op2" /></div>
							</div>
							
							<div id="abierta" style="display: none;">
							<input type="text" name="abiertaTxt" placeholder="Este campo no se completa"/><br/>
							<b>*Nota: Este campo de texto No necesita se autocompletado ya que solo es una vista previa del tipo de respuesta elegida</b>
							</div>
							
							<br/><center><button >Guardar Pregunta</button></center><br/>
							
				</div>
				
				
				
			</form>';
		   	
	echo'	</div>
		</div>';
	}	
	
	
	if($accion=="AddAp"){
	
	$encuesta = $_POST["encuesta"];
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Registro de Apartado:</h1><br/>
			<font color="#191970" weight="bold"> Instrucciones: </font><hr></hr> Favor de elegir la opcion que desee<br/>
			<button class="tab seleccionado"  style="border-bottom:none;"  mostrar="paso1">Opcion 1: Agregar Apartado</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso3">Opcion 2: Crear Pregunta a Apartado</button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
			<form id="Apa1" destino="resultadoRegistro" action="guardarEncuesta.php">
			<input type="hidden" name="option" value="AddApa">
			
				<div id="paso1" class="tabCont">
					<h2>Creear Apartado</h2>
					
					  <b>Nombre deñ apartado:</b> <input type="text" name="apartado"/>
						<input type="text" name="encuesta" value="'.$encuesta.'" style="display:none"/>
						
					<br/><center><button >Guardar Apartado </button></center>
					
				</div>
				</form>
				
				
				
				<div id="paso3" class="tabCont" style="display:none">
					<h2>Cree la pregunta</h2>

					<form id="Apa2" destino="resultadoRegistro" action="guardarEncuesta.php">
					<input type="hidden" name="option" value="apartado">';
					
					$pro= mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$encuesta.";");
					$numpro = mysqli_num_rows($pro);
					
					
					echo"<select id='sec' name='apartado' ><option value='0'>Eliga apartado a agregar la pregunta</option>";
									
										if($numpro>0){
											
											for($x=0;$x<$numpro;$x++){
													$datospro = mysqli_fetch_array($pro);
													echo"<option value='".$datospro["id_apartado"]."'>". $datospro["nombre_apartado"]."</option>";
											}
															
										}
									echo"</select>
									<br/><br/><input type='text' name='encuesta' value='".$encuesta."' style='display:none'/>";	
					
					
					
				echo'		<div id="Bot" style="position:absolute; left:45%; display: none;">
							 	<img src="imagenes/plus.png" id="AddOp" style="cursor: pointer;" title="Agregar opcion"> &nbsp;
							 	<img src="imagenes/minus.png" id="DelOp" style="cursor: pointer;" title="Quitar opcion">
							 	<img src="imagenes/database.png" id="AddOt" style="cursor: pointer;" title="Agregar opcion abierta"> &nbsp;
							 	<img src="imagenes/minus.png" id="DelOt" style="cursor: pointer;" title="Quitar opcion"> &nbsp;
							</div>
							<img src="imagenes/repeat.png" id="Atras" style=" position:absolute; top:1%; left:30%; cursor: pointer; display: none;" title="Regesar">
							<b>Pregunta: ¿</b> <input type="text" style="width:370px" name="pregunta" required="required"/><b>?</b><br/><br/>

							<div id="Res">
							<b>Eliga el tipo de Respuesta:</b>
							<input type="radio" id="Abierta" name="tipo" value="Abierta" />Abierta &nbsp;&nbsp;&nbsp; 
							<input type="radio" id="PorOp"  name="tipo" value="Por opciones" />Por Opciones
							</div>
							
							<div id="opciones" style="display: none;">
							<div id="1"><b>Opcion 1:</b><br/>
							<input type="text" name="op1" /></div>
							<div id="2"><b>Opcion 2:</b><br/>
							<input type="text" name="op2" /></div>
							</div>
							
							<div id="abierta" style="display: none;">
							<input type="text" name="abiertaTxt" placeholder="Este campo no se completa"/><br/>
							<b>*Nota: Este campo de texto No necesita se autocompletado ya que solo es una vista previa del tipo de respuesta elegida</b>
							</div>
							
							<br/><center><button >Guardar Pregunta</button></center>
							
						</div>
					</form>';
				   	
	echo'	</div>
		</div>';
	}	

	if($accion=="capasidad"){
	
	echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Agregar Copetencias:</h1><br/>
			<font color="#191970" weight="bold"> Instrucciones: </font><hr></hr> Favor de ingresar lo que le se indique revizando su ortogrfia y dando click en agregar para que se agrege correctamente,<br/><br/>
			<button class="tab seleccionado"  style="border-bottom:none;"  mostrar="paso1">Opcion 1: Agregar Copetencia</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso2">Opcion 2: Crear Pregunta a Copetencia</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso3">Opcion 3: Editar Copetencia </button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			
			<div id="paso1" class="tabCont">
				<form destino="resultadoRegistro" action="guardarEncuesta.php">
					<input type="hidden" name="option" value="capasidad">
					<input type="hidden" name="encuesta" value="'.$_POST["encuesta"].'">

					<b>Ingrese el tipo de la copetencia a agregar</b><br/><br/>

					<b>Copetencia: </b><input type="text" style="width:370px" name="capasidad" required="required"/><button>Agregar</button>
				</form><br/>
			</div>

			<div id="paso2" style="display:none;" class="tabCont">
				<form destino="resultadoRegistro" action="guardarEncuesta.php">
					<input type="hidden" name="option" value="capasidadPre">
					<input type="hidden" name="encuesta" value="'.$_POST["encuesta"].'">

					<b>Ingrese un pregunta para agregr als capasidades</b><br/><br/>

					<b>Pregunta: </b><input type="text" style="width:370px" name="capasidad" required="required"/><br/><br/>
					<b>Respuestas:</b><br/>
					<input type="text" name="op1" required="required" placeholder="Opcion 1"/><br/>
					<input type="text" name="op2" required="required" placeholder="Opcion 2"/><br/>
					<input type="text" name="op3" required="required" placeholder="Opcion 3"/><br/>
					<input type="text" name="op4" required="required" placeholder="Opcion 4"/><br/>
					<br/><center><button>Agregar</button></center><br/>
				</form>
			</div>

			<div id="paso3" style="display:none;" class="tabCont">

			<br/><b>Seleccione la opcion que desee</b><br/><br/>

			<form destino="pasos" action="crearEncuesta.php">
			<input type="hidden" name="option" value="EditCapasidad">';

			$pro= mysqli_query($conexion,"SELECT * FROM Capasidades_encuesta WHERE id_encuesta=".$_POST["encuesta"].";");
			$numpro = mysqli_num_rows($pro);

			echo" <b>1.- Editar Copetencias: </b> <br/> <select id='sec' name='copetencia' ><option value='0'>Eliga la copetencia a Editar</option>";
									
				if($numpro>0){
					for($x=0;$x<$numpro;$x++){
						$datospro = mysqli_fetch_array($pro);
						echo"<option value='".$datospro["id_capasidad"]."'>". $datospro["capasidad"]."</option>";
					}
				}

			echo"</select><button>Editar</button></form>";	

			echo'<form destino="pasos" action="crearEncuesta.php">
			<input type="hidden" name="option" value="EditPrecapasidad"';

			$pro= mysqli_query($conexion,"SELECT * FROM Preguntas_capasidades WHERE id_encuesta=".$_POST["encuesta"].";");
			$numpro = mysqli_num_rows($pro);

			echo" <b>2.- Editar Pregunta a Copetencias: </b> <br/> <select id='sec' name='copetencia' ><option value='0'>Eliga la pregunta</option>";
									
				if($numpro>0){
					for($x=0;$x<$numpro;$x++){
						$datospro = mysqli_fetch_array($pro);
						echo"<option value='".$datospro["id_pregunta_capasidad"]."'>¿". $datospro["pregunta"]."?</option>";
					}
				}

			echo"</select><button>Editar</button></form>";
					

	echo'	<br/></div>
			';
		   	
	echo'	</div>
		</div>';
	}	


	if($accion=="EditCapasidad"){
	
		echo'<div id="pasos" style="overflow:auto;height:100%">
			<h1>Editar Copetencias:</h1><br/>
			<font color="#191970" weight="bold"> Instrucciones: </font><hr></hr> Favor de ingresar lo que le se indique revizando su ortogrfia y dando click en agregar para que se agrege correctamente,<br/><br/>
			<button class="tab"  style="border-bottom:none;"  mostrar="paso1" disabled>Opcion 1: Agregar Copetencia</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso2" disabled>Opcion 2: Crear Pregunta a Copetencia</button>
			<button class="tab seleccionado" style="border-bottom:none;" id="ref" mostrar="paso3">Opcion 3: Editar Copetencia </button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="paso3" class="tabCont"><br/>
			<form destino="resultadoRegistro" action="guardarEncuesta.php">
			<input type="hidden" name="option" value="EditarCopetencia">
			<input type="hidden" name="id" value="'.$_POST["copetencia"].'">';
				$Edit= mysqli_query($conexion,"SELECT * FROM Capasidades_encuesta WHERE id_capasidad=".$_POST["copetencia"].";");
				$numEdit = mysqli_num_rows($Edit);

				if($numEdit>0){
					for($x=0;$x<$numEdit;$x++){
						$datos = mysqli_fetch_array($Edit);
		echo'			<b>Copetencia: </b><input type="text" style="width:370px" name="capasidad" value="'.$datos["capasidad"].'" required="required"/>';
					}
				}
		echo'	<button>Editar</button>
				</form><br/>
				</div>
			</div>';
	}

	if($accion=="EditPrecapasidad"){
	
		echo'<div id="pasose" style="overflow:auto;height:100%">
			<h1>Editar Preguntas de Copetencias:</h1><br/>
			<font color="#191970" weight="bold"> Instrucciones: </font><hr></hr> Favor de ingresar lo que le se indique revizando su ortogrfia y dando click en agregar para que se agrege correctamente,<br/><br/>
			<button class="tab"  style="border-bottom:none;"  mostrar="paso1" disabled>Opcion 1: Agregar Copetencia</button>
			<button class="tab" style="border-bottom:none;" id="ref" mostrar="paso2" disabled>Opcion 2: Crear Pregunta a Copetencia</button>
			<button class="tab seleccionado" style="border-bottom:none;" id="ref" mostrar="paso3">Opcion 3: Editar Copetencia </button>	

			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="paso3" class="tabCont"><br/>
			<form destino="resultadoRegistro" action="guardarEncuesta.php">
			<input type="hidden" name="option" value="EditarPreCopetencia">
			<input type="hidden" name="id" value="'.$_POST["copetencia"].'">';
				$Edit= mysqli_query($conexion,"SELECT * FROM Preguntas_capasidades WHERE id_pregunta_capasidad=".$_POST["copetencia"].";");
				$numEdit = mysqli_num_rows($Edit);

				if($numEdit>0){
					for($x=0;$x<$numEdit;$x++){
						$datos = mysqli_fetch_array($Edit);
		echo'			<b>Pregunta: </b><input type="text" style="width:370px" value="'.$datos["pregunta"].'" name="capasidad" required="required"/><br/><br/>
						<b>Respuestas:</b><br/>
						<input type="text" name="op1" value="'.$datos["opcion1"].'" required="required" placeholder="Opcion 1"/><br/>
						<input type="text" name="op2" value="'.$datos["opcion2"].'" required="required" placeholder="Opcion 2"/><br/>
						<input type="text" name="op3" value="'.$datos["opcion3"].'" required="required" placeholder="Opcion 3"/><br/>
						<input type="text" name="op4" value="'.$datos["opcion4"].'" required="required" placeholder="Opcion 4"/><br/>';
					}
				}
		echo'	<br/><center><button>Editar</button></center><br/>
				</form><br/>
				</div>
			</div>';
	}
	
	mysqli_close($conexion);
?>