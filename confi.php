<?php
session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">

		<h1>Configuracion del Sistema</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="backup">Copia de Seguridad</button>
		<button class="tab"  style="border-bottom:none;" permiso="A" mostrar="status">Estado del Sistema</button>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
				
				<div id="backup" class="tabCont" permiso="A">

					<h2>Hacer una copia de seguridad del Sistema</h2>

					<button onclick="$(\'#confirmacion\').toggle(\'drop\')">Iniciar Respaldo</button>
					<form destino="2" action="system.php" method="post">
						<input type="hidden" name="option" value="backup">
						<div id="confirmacion" style="display:none">
							¿Estas seguro que deseas: <font color="#191970" weight="bold">Iniciar la copia de seguridad</font>?
							<button >Si, estoy seguro</button>
							<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
						</div>
					</form>
					<br><br><div id="2"></div>

				</div>

				<div id="status" class="tabCont" style="display:none">

				</div>

				<br><br>		
		</div>
	</div>
	';
	
	if(substr($_SESSION["Permisos_Eneaware"][25],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][25],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][25],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>