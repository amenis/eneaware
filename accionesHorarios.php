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
	if($_SESSION["Permisos_Eneaware"][5]!="000"){
		include("conexion.php");

		if($_POST['accion']=="guardar"){
			extract($_POST);
			if($insertar = mysqli_query($conexion,"INSERT INTO Horario_gral(id_usuario,dia_semana,hora_inicio,hora_fin,id_clave,status) VALUES('".$usuario."','".$dia."','".$hi."','".$hf."','".$idClave."',1)")){
				
					echo '
					Registro correcto.
					<script>
						$("[carga=horarios]").trigger("click");
						setTimeout(function(){$("[mostrar=resgistrarHora]").trigger("click")},1000);
					</script>
				'; 
			}
			else{mysqli_error($conexion);}			
		}
		if($_POST['accion']=="modificar"){
			extract($_POST);
			$modHora = mysqli_query($conexion,"UPDATE Horario_gral SET id_usuario='".$id."',dia_semana='".$dia."',hora_inicio='".$hi."',hora_fin='".$hf."',id_clave='".$idClave."' WHERE id_horario_gral='".$id_horario."' ");
			if($modHora){
				echo 'Registro Modificado Correctamente
				<script>
					$("[carga=horarios]").trigger("click");
					setTimeout(function(){$("[mostrar=modHora]").trigger("click")},1000);
				</script>';
			}
			else{
				echo mysqli_error($conexion);
				}			
		}
		if($_POST['accion']=="borrar"){
			extract($_POST);
			$eliminar = mysqli_query($conexion,"UPDATE Horario_gral set status=0 WHERE id_horario_gral=".$horario);	
			if($eliminar){
				echo 'El Registro ha Sido Dado de Baja
				<script>
					$("[carga=horarios]").trigger("click");
					setTimeout(function(){$("[mostrar=modHora]").trigger("click")},1000);
				</script>';
			}
			else{
				echo mysqli_error($conexion);
			}
		}
		if($_POST['accion']=="restaurar"){
			extract($_POST);
			$eliminar = mysqli_query($conexion,"UPDATE Horario_gral set status=1 WHERE id_horario_gral=".$horario);	
			if($eliminar){
				echo 'El Registro ha Sido Dado de Alta
				<script>
					$("[carga=horarios]").trigger("click");
					setTimeout(function(){$("[mostrar=baja]").trigger("click")},1000);
				</script>';
			}
			else{
				echo mysqli_error($conexion);
			}
		}
		if($_POST['accion']=="porDocente"){
			$horario = mysqli_query($conexion,"SELECT * FROM Horario_gral WHERE id_usuario='".$_POST['id_usuario']."' ");
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php"  method="POST" target="_self" >
					<input type="hidden" name="nombre" value="ReporteHorario">
					<input type="hidden" name="table" id="reporte">					
				</form>
				 <table style="left:30%;padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px;width:100%;" border="1" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr  bgcolor="#0404B4"><td style="border:none" colspan="16"style="color:black;text-aling:center;" >REPORTES DE EDADES DEL PERSONAL</td></tr>
					<tr bgcolor="gray"><td>Nombre</td><td>Dia</td><td>Horarios</td><td>Estado</td></tr>
				';
				while($dataH = mysqli_fetch_array($horario)){
					$usuario = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre FROM Usuarios WHERE id_usuario='".$dataH['id_usuario']."' ORDER BY nombre DESC ");
					$dataU = mysqli_fetch_array($usuario);
					echo'
					<tr bgcolor="pink"><td>'.$dataU['nombre'].'</td><td>'.$dataH['dia_semana'].'</td><td>'.$dataH['hora_inicio'].'-'.$dataH['hora_fin'].'</td><td>';echo ($dataH['status']==1)?'Activa':'Inactiva'; echo'</td></tr>
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
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
					</script>';
		}
		if($_POST['accion']=="estado"){
			$horario = mysqli_query($conexion,"SELECT * FROM Horario_gral ");
			echo'
			<div id="dialog-message" title="Reporte " >
				<form id="report" action="reportes.php" method="POST" target="_self" >
					<input type="hidden" name="nombre" value="ReporteHorario">
					<input type="hidden" name="table" id="reporte">					
				</form>
				 <table style="left:30%;padding-top:20px;top:30%;background:#F2F2F2;border-radius:5px;width:100%;" border="1"  cellpadding="10" cellspacing="0" bordercolor="#666666" id="tablaReporte">
					<tr bgcolor="#0404B4"><td style="border:none" colspan="16"style="color:black;text-aling:center;" >REPORTES DE HORARIOS DEL PERSONAL</td></tr>
					<tr bgcolor="gray"><td>Nombre</td><td>Dia</td><td>Horarios</td><td>Estado</td></tr>
				';
				while($dataH = mysqli_fetch_array($horario)){
					$usuario = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre  FROM Usuarios WHERE id_usuario='".$dataH['id_usuario']."' ");
					$dataU = mysqli_fetch_array($usuario);
					echo'
					<tr bgcolor="pink"><td>'.$dataU['nombre'].'</td><td>'.$dataH['dia_semana'].'</td><td>'.$dataH['hora_inicio'].'-'.$dataH['hora_fin'].'</td><td>';echo ($dataH['status']==1)?'Activa':'Inactiva'; echo'</td></tr>
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
							    		 $(\'#reporte\').val($(\'<div>\').html( $(\'#tablaReporte\').eq(0).clone()).html());
							    		 $(\'#report\').submit();
							    		 $(\'#resultados\').empty();
							    		 $("#dialog-message").remove();
							    	}
							    }
							    
							});
						});
					</script>';
		}		
		
	}
		
 }
else {
	header("Location: index.php");	
}
  
?>