<?php

include("conexion.php");

		$accion = $_POST["option"];
		
		if($accion=="salir"){
		echo '<script>$("[carga=administrarEncuesta]").trigger("click");setTimeout(function(){$("[mostrar=conEn]").trigger("click")},1000);</script>';
		}

session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][25]!="000"){

		
		if($accion=="backup"){

		 	$db ="eneaware";	
			
			
			$command = "\"bin\\mysqldump\" --opt --skip-extended-insert --complete-insert  --user=root  ".$db."  > backup/".$db.date("d-m-Y").".sql";
			$result = shell_exec($command);

			echo $result;

			if(!is_null($result)) {
				echo 'Error al Realizar el Respaldo';
			}
			else{
				echo 'Respaldo Creado Satisfactoriamente';
			}
			

			function descargar($archivo){
				
				$path= "backup/".$archivo;
				header("Pragma: no-cache"); 
				header("Expires: 0"); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename=".basename($path));
				header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');		
			    header('Pragma: public');
				header('Content-Length: ' . filesize($path)); 
				ob_clean();    		
				flush();
		    	readfile($path);
				//unlink($path);
			}

		}

	}
}
else {
	header("Location: index.php");	
}
?>