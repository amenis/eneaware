<script src="js/jquery-ui.js"></script>
<?php
session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">

		<h1>Recepcion</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="backup">Alumnos</button>
		<button class="tab"  style="border-bottom:none;" permiso="A" mostrar="status">Personal</button>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">		

			<div id="backup" class="tabCont" permiso="A">
			<br><br>
					<form destino="verConsultaPA" action="busqueda.php" style="display:inline-block">
								<input type="hidden" name="option" value="bporAlumno">
								Buscar: <input type="search" size="47" placeholder="por: Matricula, Apellido Paterno, Apellido Materno y Nombre" name="mati" required/> <button ><img src="imagenes/search.png"></button>
							</form><br><br>
							<div id="verConsultaPA"></div>

			</div>

			<div id="status" class="tabCont" style="display:none">

			</div>

				<br><br>

		</div>
	</div>
	';
	if(substr($_SESSION["Permisos_Eneaware"][26],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][26],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][26],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>