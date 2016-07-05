<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][0]!="000"){
		
		include("conexion.php");
		require_once("funciones.php");		

		if($_POST["accion"]=="registrar"){
			$permisos="";
			$correcto=false;
			extract($_POST);
			$loginGranted = 0;
			$usuario = "";
			$pass = "";
			$tipo_usuario="";
			if(isset($_POST["acceso"])){
				if($_POST["pass"]==$_POST["pass2"]){
					$correcto=true;
				}
				else {
					$correcto=false;
					echo 'Las contraseñas no coinciden'; 	
				}
				if($correcto){
					$usuario=md5($_POST["usuario"]);
					$pass=md5($_POST["pass"]);
					$loginGranted = 1;
					$tipo_usuario=$_POST["tipoUsuario"];
					for($x=1;$x<108;$x++){
						if($x%4==0){
							$permisos.=",";
						}
						else {
							if(isset($_POST["pos".$x])){
								$permisos.="1";
							}
							else {
								$permisos.="0";
							}	
						}
					}
					$edad=CalculaEdad($fechaN);
					if(mysqli_query($conexion, "INSERT INTO Usuarios() VALUES(null, '".$usuario."', '".$pass."', '".$apP."','".$apM."','".$nombre."' , '".$rfc."', '".$curp."', '".$sexo."', '".$tel."', '".$email."', '".$domicilio."', '".$fechaN."','".$edad."','".$fechaIE."', '".$grado."',  ".$estudio." ,'".$escuela_estudia."', ".$beca.",'".$tipo_beca."', 1,  ".$loginGranted.", '".$permisos."', '".$nombramiento."','".$funcion."' ,'".$tipo_usuario."', '".$turno."', '".$localidad."', '".$municipio."', '".$fechaIS."', ".$otroJob.",'".$otro_trabajo."', '".$estadoC."')")){
					
						echo '
							Registro correcto.
							<script>
								$("[carga=personal]").trigger("click");
							</script>
						';
						$usuario = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM Usuarios");
						$datosMax = mysqli_fetch_row($usuario);
						$max = $datosMax[0];
						if(isset($_FILES["foto"])){
							$datosImg = explode(".", $_FILES["foto"]["name"]);
							$extension = $datosImg[count($datosImg)-1];
							copy($_FILES["foto"]["tmp_name"], "imagenes/personal/".$max.".".$extension);				
						}
						mkdir("documentacion/docentes/".$max, 0777);
					}
					else {
						echo 'Hubo un error: '.mysqli_error($conexion);	
					}
					for($x=1;$x<=$nuevos_reg;$x++){

						if(($_POST['escuela'.$x]=="") && ($_POST['carrera'.$x]=="") && ($_POST['cedula'.$x]=="") && ($_POST['fechaTi'.$x]=="") && ($_POST['actaEx'.$x]=="") && ($_POST['temaTi'.$x]=="") ){
						}
						else{
							if(mysqli_query($conexion,"INSERT INTO Estudios_personal() VALUES(null,'".$max=$datosMax[0]."','".$_POST['escuela'.$x]."','".$_POST['carrera'.$x]."','".$_POST['cedula'.$x]."','".$_POST['fechaTi'.$x]."','".$_POST['actaEx'.$x]."','".$_POST['temaTi'.$x]."' )")){
							}	
							else{
								echo 'Hubo un error'.mysqli_error($conexion);
							}		
						}
					}
				}
			}
			else {
				$edad=CalculaEdad($fechaN);
				if(mysqli_query($conexion, "INSERT INTO Usuarios() VALUES(null, '".$usuario."', '".$pass."', '".$apP."','".$apM."','".$nombre."' , '".$rfc."', '".$curp."', '".$sexo."', '".$tel."', '".$email."', '".$domicilio."', '".$fechaN."','".$edad."','".$fechaIE."', '".$grado."',  ".$estudio." , '".$escuela_estudia."' ,".$beca.",'".$tipo_beca."', 1,  ".$loginGranted.", '".$permisos."', '".$nombramiento."','".$funcion."','".$tipo_usuario."', '".$turno."', '".$localidad."', '".$municipio."', '".$fechaIS."', ".$otroJob.",'".$otro_trabajo."','".$estadoC."')")){
				
					echo '
						Registro correcto.
							<script>
								$("[carga=personal]").trigger("click");
							</script>
					';
					$usuario = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM Usuarios");
					$datosMax = mysqli_fetch_row($usuario);
					$max = $datosMax[0];
					if(isset($_FILES["foto"])){
						$datosImg = explode(".", $_FILES["foto"]["name"]);
						$extension = $datosImg[count($datosImg)-1];
						copy($_FILES["foto"]["tmp_name"], "imagenes/personal/".$max.".".$extension);					
					}
					mkdir("documentacion/docentes/".$max, 0777);
				}
				else {
					echo 'Hubo un error: '.mysqli_error($conexion);	
				}	

				for($x=1;$x<=$nuevos_reg;$x++){

					if(($_POST['escuela'.$x]=="") && ($_POST['carrera'.$x]=="") && ($_POST['cedula'.$x]=="") && ($_POST['fechaTi'.$x]=="") && ($_POST['actaEx'.$x]=="") && ($_POST['temaTi'.$x]=="") ){
					}
					else{
						if(mysqli_query($conexion,"INSERT INTO Estudios_personal() VALUES(null,'".$max=$datosMax[0]."','".$_POST['escuela'.$x]."','".$_POST['carrera'.$x]."','".$_POST['cedula'.$x]."','".$_POST['fechaTi'.$x]."','".$_POST['actaEx'.$x]."','".$_POST['temaTi'.$x]."' )")){
						}	
						else{
							echo 'Hubo un error'.mysqli_error($conexion);
						}		
					}
				}
			}			
		}
		if($_POST["accion"]=="deshabilitar"){
			if(mysqli_query($conexion, "UPDATE Usuarios SET status=0, status_login=0 WHERE id_usuario=".$_POST["id"])){
				echo '
							Usuario deshabilitado.
							<script>
								$("[carga=personal]").trigger("click");
								setTimeout(function(){$("[mostrar=modificarPer]").trigger("click")},1000);
							</script>
						';
			}
			else{
				echo 'Hubo un error: '.mysqli_error();			
			}
		}
		if($_POST["accion"]=="restaurar"){
			if(mysqli_query($conexion, "UPDATE Usuarios SET status=1 WHERE id_usuario=".$_POST["id"])){
				echo '
							Usuario restaurado.
							<script>
								$("[carga=personal]").trigger("click");
								setTimeout(function(){$("[mostrar=modificarPer]").trigger("click")},1000);
							</script>
						';
			}
			else{
				echo 'Hubo un error: '.mysqli_error();			
			}
		}
		if($_POST["accion"]=="modificar"){
			$permisos="";
			$correcto=false;
			extract($_POST);
			$loginGranted = 0;
			$usuario = "";
			$pass = "";
			$tipo_usuario="";
			if(isset($_POST["acceso"])){
				$usuario = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE id_usuario = ".$_POST["id"]);
				$datosU = mysqli_fetch_assoc($usuario);
				if($_POST["pass"]==$_POST["pass2"]){
					$correcto=true;
				}
				else {
					$correcto=false;
					echo 'Las contraseñas no coinciden'; 	
				}
				if($correcto){
					$usuario = $datosU["usuario"];
					if($_POST["usuario"]!=$datosU["usuario"]) {
						$usuario=md5($_POST["usuario"]);
					}
					$pass = $datosU["password"];
					if($_POST["pass"]!=$datosU["password"]) {
						$pass=md5($_POST["pass"]);
					}
					$loginGranted = 1;
					$tipo_usuario=$_POST["tipoUsuario"];
					for($x=1;$x<108;$x++){
						if($x%4==0){
							$permisos.=",";
						}
						else {
							if(isset($_POST["pos".$x])){
								$permisos.="1";
							}
							else {
								$permisos.="0";
							}	
						}
					}
					$edad=CalculaEdad($fechaN);
					if(mysqli_query($conexion, "UPDATE Usuarios SET usuario='".$usuario."', password='".$pass."', apellidoP='".$apP."',apellidoM='".$apM."', nombre='".$nombre."' , rfc='".$rfc."', curp='".$curp."', sexo='".$sexo."', telefono='".$tel."', email='".$email."', domicilio='".$domicilio."', fecha_nacimiento='".$fechaN."', edad='".$edad."', fecha_ingreso_enea='".$fechaIE."', nivel_estudio='".$grado."',  estudio=".$estudio." , lugar_estudio='".$escuela_estudia."', beca=".$beca.", tipo_beca='".$tipo_beca."', status_login=".$loginGranted.", permisos='".$permisos."', nombramiento='".$nombramiento."',funcion='".$funcion."', tipo_usuario='".$tipo_usuario."', turno='".$turno."', localidad='".$localidad."', municipio='".$municipio."', fecha_ingreso_sep='".$fechaIS."', otro_trabajo=".$otroJob.", lugar_trabajo='".$otro_trabajo."', estado_civil='".$estadoC."' WHERE id_usuario=".$_POST["id"])){
						
						for($x=1;$x<=$nuevos_reg;$x++){
								if(mysqli_query($conexion,"UPDATE Estudios_personal SET escuela='".$_POST['escuela'.$x]."',carrera='".$_POST['carrera'.$x]."',cedula='".$_POST['cedula'.$x]."',fecha_titulacion='".$_POST['fechaTi'.$x]."',acta_examen='".$_POST['actaEx'.$x]."',tema_titulacion='".$_POST['temaTi'.$x]."' WHERE id_estudio='".$_POST['id_estudio'.$x]."' ")){
															
								}	
								else{
									if(!mysqli_error($conexion)){
										if(mysqli_query($conexion,"INSERT INTO Estudios_personal() VALUES(null,'".$max=$datosMax[0]."','".$_POST['escuela'.$x]."','".$_POST['carrera'.$x]."','".$_POST['cedula'.$x]."','".$_POST['fechaTi'.$x]."','".$_POST['actaEx'.$x]."','".$_POST['temaTi'.$x]."' )")){

										}
										else{
											echo 'Hubo un error'.mysqli_error($conexion);
										}
									}
									
									
									
								}		
							}
						

						echo '
							Datos guardados.
							<script>
								$("[carga=personal]").trigger("click");
								setTimeout(function(){$("[mostrar=modificarPer]").trigger("click")},1000);
							</script>
						';
						$usuario = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM Usuarios");
						$datosMax = mysqli_fetch_row($usuario);
						$max = $datosMax[0];
						if(isset($_FILES["archivo"])){
								$datosImg = explode(".", $_FILES["archivo"]["name"]);
								$extension = $datosImg[count($datosImg)-1];
								copy($_FILES["archivo"]["tmp_name"], "imagenes/personal/".$_POST['id'].".".$extension);				
							}
						}

					else {
						echo 'Hubo un error: '.mysqli_error($conexion);	
					}
				}
			}
			else {
				$edad=CalculaEdad($fechaN);

				if(mysqli_query($conexion, "UPDATE Usuarios SET usuario='".$usuario."', password='".$pass."', apellidoP='".$apP."',apellidoM='".$apM."', nombre='".$nombre."' , rfc='".$rfc."', curp='".$curp."', sexo='".$sexo."', telefono='".$tel."', email='".$email."', domicilio='".$domicilio."', fecha_nacimiento='".$fechaN."',edad='".$edad."', fecha_ingreso_enea='".$fechaIE."', nivel_estudio='".$grado."', estudio=".$estudio." , lugar_estudio='".$escuela_estudia."',beca=".$beca.",tipo_beca='".$tipo_beca."', status_login=".$loginGranted.", permisos='".$permisos."', nombramiento='".$nombramiento."',funcion='".$funcion."',tipo_usuario='".$tipo_usuario."', turno='".$turno."', localidad='".$localidad."', municipio='".$municipio."', fecha_ingreso_sep='".$fechaIS."', otro_trabajo=".$otroJob.", lugar_trabajo='".$otro_trabajo."',estado_civil='".$estadoC."' WHERE id_usuario=".$_POST["id"])){
				
					echo '
							Datos guardados.
							<script>
								$("[carga=personal]").trigger("click");
								setTimeout(function(){$("[mostrar=modificarPer]").trigger("click")},1000);
							</script>
						';
					$usuario = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM Usuarios");
					$datosMax = mysqli_fetch_row($usuario);
					$max = $datosMax[0];
					if(isset($_FILES["foto"])){
						$datosImg = explode(".", $_FILES["foto"]["name"]);
						$extension = $datosImg[count($datosImg)-1];
						copy($_FILES["foto"]["tmp_name"], "imagenes/personal/".$max.".".$extension);					
					}
					for($x=1;$x<=$nuevos_reg;$x++){
							if($_POST['id_estudio'.$x]==null){
								if(mysqli_query($conexion,"INSERT INTO Estudios_personal() VALUES(null,'".$max=$datosMax[0]."','".$_POST['escuela'.$x]."','".$_POST['carrera'.$x]."','".$_POST['cedula'.$x]."','".$_POST['fechaTi'.$x]."','".$_POST['actaEx'.$x]."','".$_POST['temaTi'.$x]."' )")){

								}
								
							}
							else{
								if(mysqli_query($conexion,"UPDATE Estudios_personal SET escuela='".$_POST['escuela'.$x]."',carrera='".$_POST['carrera'.$x]."',cedula='".$_POST['cedula'.$x]."',fecha_titulacion='".$_POST['fechaTi'.$x]."',acta_examen='".$_POST['actaEx'.$x]."',tema_titulacion='".$_POST['temaTi'.$x]."' WHERE id_estudio='".$_POST['id_estudio'.$x]."' ")){
															
								}	
								
							}
											
									
						}
				}
				else {
					echo 'Hubo un error: '.mysqli_error($conexion);	
				}	
			}			
		}
		if($_POST["accion"]=="miniconsulta"){
			$cont=1;
			$maxid = mysqli_query($conexion,"SELECT MAX(id_viatico) FROM Viaticos");
			$id = mysqli_fetch_row($maxid);
			mysqli_free_result($maxid);

			$usuarios = mysqli_query($conexion, "SELECT id_usuario,rfc,funcion, CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE id_usuario IN(".$_POST["ids"].")");
			
			while($datosU = mysqli_fetch_assoc($usuarios)) {
				echo '			
				<input type="hidden" name="idU'.$datosU['id_usuario'].'" value="'.$datosU['id_usuario'].'">';
			}
				echo'
						<div style="font-family:Arial;margin:auto;padding:0.5cm;background:white;width:21cm;border:1px solid grey; height:26cm">
						<img src="imagenes/sej.png" style="position:absolute;width:128px;z-index:3">
						<input type="hidden" name="viatic" id="Viactico" value>
						<input type="hidden" name="detalleV" id="Detalle" value>						
												
							<span style="position:relative;top:0;font-size:10pt">
								<b style="position:relative;left:30%;top:0%;">GOBIERNO DEL ESTADO DE JALISCO</b><span style="position:relative;left:50%">'.$_SESSION['Nombre_Usuario_Eneaware'].' '.($id[0]+1).'</span><br/>
								<b style="position:relative;left:20%;">SECRETARIA DE PLANEACION ADMININISTRACION Y FINANZAS</b><br/>
								<b style="position:relative;left:35%;top:0%;">RECIBO DE VIATICOS</b>	
								<div style="position:relative;top:3%;left:75%;"><span style="font-size:11pt;"><b>BUENO POR</b>$ </span><input type="text" size="10" name="totalDV" style="border-bottom:1px solid black;border-top:none;border-right:none;border-left:none;"class="presio"/></div>							
								
							</span>
						
							<table style="font-size:10pt" width="98%">
								<tr class="encabezado" bgcolor="gray" style="color:white;"><td colspan="3" style="text-align:center">DATOS GENERALES</td></tr>
								<tr>
									<td><b>DEPENDENCIA</b></td>
									<td style="border-bottom:1px solid black">SECRETARIA DE EDUCACION DEL ESTADO DE JALISCO</td>
								</tr>
								<tr>
									<td><b>DIRECCION</b></td>
									<td style="border-bottom:1px solid black">CORDINACION DE FORMACION Y ACTUALIZACION DOCENTE</td>
								</tr>
								<tr>
									<td><b>DEPARTAMENTO</b></td>
									<td style="border-bottom:1px solid black">DIRECCION GENERAL DE EDUCACION NORMAL/ESC NOMRAL PARA EDUCADORES DE ARANDAS</td>
								</tr>
								<tr>
									<td colspan="2" width="32px"><b>NOMBRE Y CATEGORIA DEL SERVIDOR PUBLICO</b>: <span  style="border-bottom:1px solid black">'.$datosU["nombre"].'</span> <b>RFC: </b><span style="border-bottom:1px solid black">'.$datosU['rfc'].'</span></td>
									
								</tr>
							</table>
						<div contenteditable id="viatic" style="">
							<table style="font-size:10pt" width="98%">
								<tr>
									<td colspan="2" contenteditable="false"><b>DESCRIPCION DE LA COMISION EFECTUADA:  </b> </span></td>									
								</tr>
								<tr >
									<td style="border-bottom:1px solid black" colspan="2"><span style="word-wrap: break-word; "> descipcion</span></td>
								</tr>
								<tr>
									<td colspan="2" style="border-bottom:1px solid black;"><b contenteditable="false" >GUADALAJARA JAL</b> <span >   Dia </span><b contenteditable="false"> DE</b><span > a&ntilde;o</span></td>
								</tr>
								<tr><td colspan="2"><b>RECIBI DE CAJA DE LA SECRETARIA DE PLANEACION ADMININISTRACION Y FINANZAS LA CANTIDAD DE</b></td></tr>
								<tr><td colspan="2" style="border-bottom:1px solid black;"><b contenteditable="false">$ </b><span > cantidad</span><b contenteditable="false"> CON LETRA </b> <span> letra</span></td></tr>
								<tr><td colspan="2"><b>POR CONCEPTO DE PASAJES,VIATICOS Y DEMAS GASTOS DEVENGADOS DURANTE LOS DIAS</b></td></tr>
								<tr><td colspan="2" style="border-bottom:1px solid"><span> dia de ida </span><b contenteditable="false">Al</b> <span> dia de regreso</span> <b contenteditable="false">EN LAS POBLACION(ES) DE</b><span> poblacion</span></td></tr>
							</table>
						</div>
						<div contenteditable id="detalleV">	
							<table border="1" cellspacing="0" style="font-size:10pt" width="98%">
								<tr class="encabezado" ><td colspan="9" bgcolor="gray"><center>GASTOS DE PASAJES,VIATICOS Y DEMAS</center></td></tr>	
								<tr><td><b>CONCEPTO<b></b></td><td><b>LUNES</b></td><td><b>MARTES</b></td><td><b>MIERCOLES</b></td><td><b>JUEVES</b></td><td><b>VIERNES</b></td><td><b>SABADO</b></td><td><b>DOMINGO</b></td><td><b>TOTAL</b></td></tr>';
								
								$arreglo = array("<td><b>DESAYUNO</b></td>","<td><b>COMIDA</b></td>","<td><b>CENA</b></td>","<td><b>HOSPEDAJE</b></td>","<td><b>PASAJES</b></td>","<td><b>TRANSP. INT.</b></td>","<td><b>SERV. TELEF.</b></td>","<td><b>LAVANDERIA</b></td>","<td><b>SUMAS</b></td>");
								for($x=0;$x<=8;$x++){
									echo '<tr>'.$arreglo[$x].'';
									for($y=0;$y<=7;$y++){
									  echo'<td><span class="'.$x.''.$y.'"></span></td>';
									}
									echo'</tr>';
								}
							echo'
							</table>

							<table border="1" cellspacing="0"  width="98%" style="font-size:10pt">
								<tr class="encabezado" bgcolor="gray"><td colspan="6"><center>GASTOS DE TRASPORTACION</center></td></tr>
								<tr><td><b>VEHICULO</b></td><td><b>MARCA</b></td><td><b>TIPO</b></td><td><b>MODELO</b></td><td><b>No PLACAS</b></td><td><b>CILINDROS</b></td></tr>
								<tr><td>|<span> </span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td></tr>
							</table>

							<table border="1" cellspacing="0" cellpadding="0" width="98%" style="font-size:10pt">
								<tr bgcolor="gray"><td colspan="6"><center>GASTOS DE TRASPORTACION</center></td></tr>
								<tr><td><b>POBLACION</b></td><td><b>DISTANCIA EN<br> KILOMETROS</b></td><td><b>CANTIDAD<br> LITROS</b></td><td><b>PRECIO<br> UNITARIO</b></td><td><b>IMPORTE</b></td><td><b>PEAJES</b></td></tr>
								<tr><td>|<span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td></tr>
								<tr><td>|<span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td></tr>
								<tr><td>SUMAS</td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td><td><span></span></td></tr>
							</table>

							
						
						</div>
												
					</div>
				';
			
			mysqli_free_result($usuarios);
			echo'
				<script>
						function llenado(valor,este){
							var clase = $(este).attr("class");
							$("."+clase).val(valor);
							
						}
						function funcion(){
							$("#Viactico").val($("#viatic").html());
							$("#Detalle").val($("#detalleV").html());
							
						}
						
						
				</script>
			
			';			
		}

		if($_POST["accion"]=="guardarDoc"){
			extract($_POST);
			if(isset($_FILES['doc'])){
				$datosDoc = explode(".", $_FILES['doc']['name']);
				$ext = $datosDoc[count($datosDoc)-1];
				copy($_FILES['doc']['tmp_name'],"documentacion/docentes/".$id."/".$nombre.".".$ext);

				echo 'Archivo Registrado
				<script>
					$("[carga=personal]").trigger("click");
					setTimeout(function(){$("[mostrar=documentosPer]").trigger("click")},1000);
				</script>
				';

			}
			else{
				echo 'No se detecto ningun documento '.$id;
			}
		}
		if($_POST['accion']=="edades"){

		echo'
	
		<div id="dialog-message" title="Reporte " >
			<form id="report" action="reportes.php"  method="POST" target="_self" >
				<input type="hidden" name="nombre" value="ReporteEdad">
				<input type="hidden" name="accion" value="reporte">
				<input type="hidden" name="table" id="reporteedad">
				
			</form>
			<table style="padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteEdad">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="16"><center>REGISTRO DE PERSONAL POR EDADES</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
				    <tr bgcolor="gray"><td>Nombre</td><td>nombramiento</td><td>Funcion</td><td>Turno</td><td>Sexo</td><td>Estado Civil</td><td>RFC</td><td>Curp</td><td>Localidad</td><td>Municipio</td><td>Domicilio</td><td>Telefono</td><td>Email</td><td>Fecha de Nacimiento</td><td>Edad</td><td>Nivel de Estudio</td></tr>
				    ';
				        
				        $Usuarios  = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,nombramiento,funcion,turno,sexo,estado_civil,rfc,curp,localidad,municipio,domicilio,telefono,email,fecha_nacimiento,edad,nivel_estudio FROM Usuarios WHERE status =1 AND edad BETWEEN ".$_POST['edad']." AND ".$_POST['edadH']." ");
				                while($data = mysqli_fetch_array($Usuarios)){
				            echo'
				                    <tr>
				                        <td bgcolor="pink">'.$data['nombre'].'</td>
				                        <td>'.$data['nombramiento'].'</td>
				                        <td>'.$data['funcion'].'</td>
				                        <td>'.$data['turno'].'</td>
				                        <td>'.$data['sexo'].'</td>
				                        <td>'.$data['estado_civil'].'</td>
				                        <td>'.$data['rfc'].'</td>
				                        <td>'.$data['curp'].'</td>
				                        <td>'.$data['localidad'].'</td>
				                        <td>'.$data['municipio'].'</td>
				                        <td>'.$data['domicilio'].'</td>
				                        <td>'.$data['telefono'].'</td>
				                        <td>'.$data['email'].'</td>
				                        <td>'.$data['fecha_nacimiento'].'</td>
				                        <td>'.$data['edad'].'</td>
				                        <td>'.$data['nivel_estudio'].'</td>
				                    </tr>';
				            
				    
				         }
				   
				 echo'
				
				</table>
				
		</div>
		<script>
			$(function() {
				$( "#dialog-message" ).dialog({
				    modal: true,
				    closeText: "Close",
				    width:"90%",
			        height:600,
				    buttons:{
					    "Expotar a Excel":function(){
					   		 $(\'#reporteedad\').val($(\'<div>\').html( $(\'#tablaReporteEdad\').eq(0).clone()).html());
					   		 $(\'#report\').submit();
					   		 $(\'#resultados\').empty();
							 $("#dialog-message").remove();
				    	}
				    }
				});
			});
		</script>';
				
			
		}
		if($_POST['accion']=="nivel_estudio"){
			$Usuarios  = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,nombramiento,funcion,turno,sexo,estado_civil,rfc,curp,localidad,municipio,domicilio,telefono,email,fecha_nacimiento,edad,nivel_estudio FROM Usuarios WHERE status =1 AND nivel_estudio='".$_POST['grado']."' ");
			
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reportes por nivel de estudios">
					<input type="hidden" name="table" id="reporte">
					
				</form>
				<table style="padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="16"><center>REGISTRO DE PERSONAL POR NIVEL DE ESTUDIO</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
				    <tr bgcolor="gray"><td>Nombre</td><td>nombramiento</td><td>Funcion</td><td>Turno</td><td>Sexo</td><td>Estado Civil</td><td>RFC</td><td>Curp</td><td>Localidad</td><td>Municipio</td><td>Domicilio</td><td>Telefono</td><td>Email</td><td>Fecha de Nacimiento</td><td>Edad</td><td>Nivel de Estudio</td></tr>
				';
				while($data= @mysqli_fetch_assoc($Usuarios)){
					  echo'
				        <tr>
		 					<td bgcolor="pink">'.$data['nombre'].'</td>
				            <td>'.$data['nombramiento'].'</td>
				            <td>'.$data['funcion'].'</td>
				            <td>'.$data['turno'].'</td>
				            <td>'.$data['sexo'].'</td>
				            <td>'.$data['estado_civil'].'</td>
				            <td>'.$data['rfc'].'</td>
				            <td>'.$data['curp'].'</td>
				            <td>'.$data['localidad'].'</td>
				            <td>'.$data['municipio'].'</td>
				            <td>'.$data['domicilio'].'</td>
				            <td>'.$data['telefono'].'</td>
				            <td>'.$data['email'].'</td>
				            <td>'.$data['fecha_nacimiento'].'</td>
				            <td>'.$data['edad'].'</td>
				            <td>'.$data['nivel_estudio'].'</td>
				        </tr>';           
				                       
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
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
			</script>';
			mysqli_free_result($Usuarios);
				
		}
		if($_POST['accion']=="status"){

			$Usuarios  = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,status,nombramiento,funcion,turno,sexo,estado_civil,rfc,curp,localidad,municipio,domicilio,telefono,email,fecha_nacimiento,edad,nivel_estudio FROM Usuarios ");
			echo'
			
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reporte Status">
					<input type="hidden" name="table" id="reporteStatus">
					
				</form>
				<table style="padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte2">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="16"><center>REGISTRO DE PERSONAL POR STATUS</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
				    <tr bgcolor="gray">
				    	<td>Nombre</td>
				    	<td>nombramiento</td>
				    	<td>Funcion</td>
				    	<td>Turno</td>
				    	<td>Sexo</td>
				    	<td>Estado Civil</td>
				    	<td>RFC</td>
				    	<td>Curp</td>
				    	<td>Localidad</td>
				    	<td>Municipio</td>
				    	<td>Domicilio</td>
				    	<td>Telefono</td>
				    	<td>Email</td>
				    	<td>Fecha de Nacimiento</td>
				    	<td>Edad</td>
				    	<td>Nivel de Estudio</td>
				    	<td>status</td>
				    </tr>
				';
				while($data= @mysqli_fetch_assoc($Usuarios)){
					  echo'
				        <tr>
		 					<td bgcolor="pink">'.$data['nombre'].'</td>
				            <td>'.$data['nombramiento'].'</td>
				            <td>'.$data['funcion'].'</td>
				            <td>'.$data['turno'].'</td>
				            <td>'.$data['sexo'].'</td>
				            <td>'.$data['estado_civil'].'</td>
				            <td>'.$data['rfc'].'</td>
				            <td>'.$data['curp'].'</td>
				            <td>'.$data['localidad'].'</td>
				            <td>'.$data['municipio'].'</td>
				            <td>'.$data['domicilio'].'</td>
				            <td>'.$data['telefono'].'</td>
				            <td>'.$data['email'].'</td>
				            <td>'.$data['fecha_nacimiento'].'</td>
				            <td>'.$data['edad'].'</td>
				            <td>'.$data['nivel_estudio'].'</td>
				            <td>'; echo $status = $data['status'] ? 'activo' :' en baja';  echo'</td>
				        </tr>';           
				                       
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
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte2\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
			</script>';
			mysqli_free_result($Usuarios);
		}
		if($_POST['accion']=="nombramiento"){

			$Usuarios  = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,nombramiento,funcion,turno,sexo,estado_civil,rfc,curp,localidad,municipio,domicilio,telefono,email,fecha_nacimiento,edad,nivel_estudio FROM Usuarios WHERE nombramiento='".$_POST['nombramiento']."' ");
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"   method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reporte Nombramiento">
					<input type="hidden" name="table" id="reporte">
					
				</form>
				<table style="padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="16"><center>REGISTRO DE PERSONAL POR NOMBRAMIENTO</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
				    <tr bgcolor="gray"><td>Nombre</td><td>nombramiento</td><td>Funcion</td><td>Turno</td><td>Sexo</td><td>Estado Civil</td><td>RFC</td><td>Curp</td><td>Localidad</td><td>Municipio</td><td>Domicilio</td><td>Telefono</td><td>Email</td><td>Fecha de Nacimiento</td><td>Edad</td><td>Nivel de Estudio</td></tr>
				';
				while($data= @mysqli_fetch_assoc($Usuarios)){
					  echo'
				        <tr>
		 					<td bgcolor="pink">'.$data['nombre'].'</td>
				            <td>'.$data['nombramiento'].'</td>
				            <td>'.$data['funcion'].'</td>
				            <td>'.$data['turno'].'</td>
				            <td>'.$data['sexo'].'</td>
				            <td>'.$data['estado_civil'].'</td>
				            <td>'.$data['rfc'].'</td>
				            <td>'.$data['curp'].'</td>
				            <td>'.$data['localidad'].'</td>
				            <td>'.$data['municipio'].'</td>
				            <td>'.$data['domicilio'].'</td>
				            <td>'.$data['telefono'].'</td>
				            <td>'.$data['email'].'</td>
				            <td>'.$data['fecha_nacimiento'].'</td>
				            <td>'.$data['edad'].'</td>
				            <td>'.$data['nivel_estudio'].'</td>
				        </tr>';           
				                       
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
							   closeText: "x",
							    buttons:{
							    	"Expotar a Excel":function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
			</script>';
			mysqli_free_result($Usuarios);
		}
		if($_POST['accion']=="editDire"){

			$delete= mysqli_query($conexion,"Update Direccion set nombre_direc='".$_POST['nD']."', frase_celebre='".$_POST['fc']."' WHERE id_direccion=".$_POST['id']);
			echo"Datos del Direct@r modificados con exito...";
			echo '<script>
					$("[carga=personal]").trigger("click");
				</script>';
		
		}
		
	}

	else {
		echo 'Usted no tiene permisos para entrar a esta seccion.';	
	}
}
else {
	header("Location: index.php");	
}
?>