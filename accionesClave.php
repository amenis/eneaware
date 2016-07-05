
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
		$(document).on("ready",function(){
							$(".ui-button").on("click",function(){
								$("#dialog-message").remove();
							});
						});
	
</script>
<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][1]!="000"){
		include("conexion.php");

		if($_POST["accion"]=="registro"){
			extract($_POST);
			 $HorasClave="";
			 if($horas<10){
			 	$HorasClave = "0".$horas.".";
			 }
			 else{
			 	$HorasClave=$horas.".";
			 }

			if(mysqli_query($conexion, "INSERT INTO Claves() VALUES(null, ".$id_usuario.", '".$categoria."', '".$HorasClave."', '".$plaza."', '".$fecha_inicio."', '', '".$puesto."', 1)")) {
				echo '
					Registro correcto.
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}

		if($_POST['accion']=="recategorizar"){
			extract($_POST);
			$recate = mysqli_query($conexion,"INSERT INTO Claves_recat() VALUES(null,'".$idU."','".$id_clave."','".$clave_ante."' )");
			if($recate){
				echo'Clave Recateorizada
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			
		}

		if($_POST["accion"]=="modificar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Claves SET id_usuario=".$id_usuario.", categoria='".$categoria."', horas='".$horas."', plaza='".$plaza."' WHERE id_clave=".$_POST["id_clave"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		if($_POST["accion"]=="deshabilitar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Claves SET status=0, fecha_cancelacion='".$fechaCance."' WHERE id_clave=".$_POST["id_clave"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}
		if($_POST["accion"]=="restaurar"){
			extract($_POST);
			if(mysqli_query($conexion, "UPDATE Claves SET status=1, fecha_modificacion='".date("Y-m-d")."' WHERE id_clave=".$_POST["id_clave"])) {
				echo '
					Actualizacion correcta.
					<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else {
				echo 'Hubo un error: '.mysqli_error($conexion);	
			}
		}

		if($_POST['accion']=="new_cate"){

			extract($_POST);
			$Update = mysqli_query($conexion,"INSERT INTO Categorias SET codigo='".$codigo."', descripcion='".$desc."', status=1; ");
			if($Update){
				echo'
				Categoria Guardada Exitosamente
				<script>
						$("[carga=claves]").trigger("click");
					</script>
				';
			}
			else{
				echo mysqli_error($conexion);
			}
		}

		if($_POST['accion']=="modificar_cate"){

			extract($_POST);
			$Update = mysqli_query($conexion,"UPDATE Categorias SET codigo='".$codigo."', descripcion='".$desc."' WHERE id_categoria=".$idCa." ");
			if($Update){
				echo'
				Categoria Modficada Exitosamente
				';
			}
			else{
				echo mysqli_error($conexion);
			}
		}

		if($_POST['accion']=="puesto"){
			$clave = mysqli_query($conexion,"SELECT * FROM Claves_recat WHERE id_usuario='".$_POST['idU']."'" );
			echo'
				
				<div id="dialog-message" title="Reporte " >
						<form id="report" action="reportes.php" method="POST" target="_self" >
							<input type="hidden" name="nombre" value="Reporte por Puesto ">
							<input type="hidden" name="table" id="reportePu">
							
						</form>
						<table style="widt:100%;background:#F2F2F2;border-radius:5px;top:30%;left:30%;" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReportePu">
							<tr bgcolor="#0404B4"><td style="border:none;color:ghostwhite;" colspan="9"><center>HISTORIAL DE CLAVES </center></td></tr>
							<tr></tr>
							<tr bgcolor="gray"><td>NOMBRE</td><td>Claves Nuevas</td><td>Fechas de Creacion</td><td>CLAVES ANTIGUAS</td><td>Fechas de Creacion y Cancelacion</td></tr>
						';
					while($dataClave = @mysqli_fetch_array($clave)){
						$usuarios = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,curp,rfc FROM Usuarios WHERE id_usuario='".$dataClave['id_usuario']."' ");
						$dataUser= @mysqli_fetch_array($usuarios);
						
						$newKey = mysqli_query($conexion,"SELECT CONCAT(puesto,' ',categoria,'',horas,'',plaza) AS clave,fecha_ingreso FROM Claves WHERE id_clave='".$dataClave['id_newKey']."' ");
						$datank = mysqli_fetch_array($newKey);
						
						$oldKey = mysqli_query($conexion,"SELECT CONCAT(puesto,' ',categoria,'',horas,'',plaza) AS clave,fecha_ingreso,fecha_cancelacion FROM Claves WHERE id_clave='".$dataClave['id_oldkey']."' ");
						$dataok = mysqli_fetch_array($oldKey);
						
						echo'
						<tr ><td bgcolor="pink">'.$dataUser['nombre'].'</td>
							<td>'.$datank ['clave'].'</td>
							<td>'.$datank['fecha_ingreso'].'</td>
							<td>'.$dataok['clave'].'</td>
							<td>'.$dataok['fecha_ingreso'].'-'.$dataok['fecha_cancelacion'].' </td>
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
							    width:"80%",
							    height:497,
							    buttons:{
							    	"Exportar a Excel" :function(){
							    		 $(\'#reportePu\').val($(\'<div>\').html( $(\'#tablaReportePu\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
					</script>';
			
		}
		if($_POST['accion']=="categoria"){

			$clave = mysqli_query($conexion,"SELECT * FROM Claves WHERE categoria='".$_POST['categoria']."' AND status=1 " );
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reporte Calve por categoria">
					<input type="hidden" name="table" id="reporteCate">
					
				</form>
				<table style="padding-top:20px;left:30%;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporteCate">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="8"><center>REGISTRO DE CLAVES POR CATEGORIA</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
					<tr bgcolor="gray"><td>NOMBRE</td><td>CURP</td><td>RFC</td><td colspan="3" >CLAVE</td></tr>
				';
			while($dataClave = @mysqli_fetch_array($clave)){
				$usuarios = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,curp,rfc FROM Usuarios WHERE id_usuario='".$dataClave['id_usuario']."' ");
				$dataUser= @mysqli_fetch_array($usuarios);
				
					echo'
					<tr style=" mso-style-parent:style0; mso-number-format:\@;"><td bgcolor="pink">'.$dataUser['nombre'].'</td><td>'.$dataUser['curp'].'</td><td>'.$dataUser['rfc'].'</td><td>'.$dataClave["puesto"].' '.$dataClave["categoria"].''.$dataClave["horas"].'.'.$dataClave["plaza"].'</td></tr>
					';
			}
			echo'					
				</table>
					
			</div>
			<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"40%",
							    height:600,
							    buttons:{
							    	"Exportar a Excel" :function(){
							    		 $(\'#reporteCate\').val($(\'<div>\').html( $(\'#tablaReporteCate\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
					</script>';

		}
		if($_POST['accion']=="horas"){
			$clave = mysqli_query($conexion,"SELECT * FROM Claves WHERE horas='".$_POST['hora']."' AND status=1 " );
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reporte Calve por Horas">
					<input type="hidden" name="table" id="reporte">
				</form>
				<table style="padding-top:20px;left:30%;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="9"><center>REGISTRO DE CLAVES POR HORAS</center></td></tr>
					<tr><td  style="border:none">Fecha de expediciontd><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
					<tr bgcolor="gray"><td>NOMBRE</td><td>CURP</td><td>RFC</td><td colspan="3" >CLAVE</td></tr>
				';
			while($dataClave = @mysqli_fetch_array($clave)){
				$usuarios = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,curp,rfc FROM Usuarios WHERE id_usuario='".$dataClave['id_usuario']."' ");
				$dataUser= @mysqli_fetch_array($usuarios);
				
					echo'
					<tr><td bgcolor="pink">'.$dataUser['nombre'].'</td><td>'.$dataUser['curp'].'</td><td>'.$dataUser['rfc'].'</td><td>'.$dataClave["puesto"].' '.$dataClave["categoria"].''.$dataClave["horas"].'.'.$dataClave["plaza"].'</td></tr>';
			}
			echo'
				</table>
					
			</div>
			<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"45%",
							    height:600,
							    buttons:{
							    	"Exportar a Excel" :function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());$(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
					</script>';


		}
		if($_POST['accion']=="estado"){
			$clave = mysqli_query($conexion,"SELECT * FROM Claves " );
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="Reporte Calve por Status">
					<input type="hidden" name="table" id="reporte">
				
				</form>
				<table style="padding-top:20px;left:30%;top:30%;background:#F2F2F2;border-radius:5px" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr bgcolor="#0404B4"><td style="border:none;" colspan="16"><center>REGISTRO DE CLAVES POR STATUS</center></td></tr>
					<tr><td  style="border:none">Fecha de expedicion</td><td style="border:none">'.date('Y-m-d').'</td></tr>
					<tr></tr>
					<tr bgcolor="gray"><td>NOMBRE</td><td>CURP</td><td>RFC</td><td colspan="3" >CLAVE</td><td>status</td></tr>
				';
			while($dataClave = @mysqli_fetch_array($clave)){
				$usuarios = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,curp,rfc FROM Usuarios WHERE id_usuario='".$dataClave['id_usuario']."' ");
				$dataUser= @mysqli_fetch_array($usuarios);
				
					echo'
					<tr><td bgcolor="pink">'.$dataUser['nombre'].'</td><td>'.$dataUser['curp'].'</td><td>'.$dataUser['rfc'].'</td><td>'.$dataClave["puesto"].' '.$dataClave["categoria"].''.$dataClave["horas"].'.'.$dataClave["plaza"].'</td><td>'; echo $status= $dataClave['status']?'en uso' :'en baja'; echo '</td></tr>
					';
			}
			echo'
				
				</table>
				
			</div>
					<script>
						$(function() {
						    $( "#dialog-message" ).dialog({
							    modal: true,
							    width:"45%",
							    height:600,
							    buttons:{
							    	"Exportar a Excel" :function(){
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());$(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});

							
						});
					
							
					</script>';
		}


		mysqli_close($conexion);
	}
}
else {
	header("Location: index.php");	
}
?>