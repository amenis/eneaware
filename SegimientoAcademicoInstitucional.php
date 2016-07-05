<?php
session_start();
include("conexion.php");
$id = $_SESSION["id_usuario"];
	$consultaAl = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE id_usuario='".$id."' ;");
			
	while($datos = mysqli_fetch_array($consultaAl)){			
		$nombre = $datos["apellidoP"]." ".$datos["apellidoM"]." ".$datos["nombre"];
		$status = $datos["status"];
	}
	
	

$realpath = realpath(dirname(dirname(__FILE__)));

	if(file_exists($realpath."/eneaware/imagenes/personal/".$id.".png")){
		$imagenTmp1=$id.'.png';
	}
	else{
		if(file_exists($realpath."/eneaware/imagenes/personal/".$id.".jpg")){
			$imagenTmp1=$id.'.jpg';
		}
		else{
			if(file_exists($realpath."/eneaware/imagenes/personal/".$id.".gif")){
				$imagenTmp1=$id.'.gif';
			}
			else {
				if(file_exists($realpath."/eneaware/imagenes/personal/".$id.".svg")){
					$imagenTmp1=$id.'.svg';
				}
				else {
					$imagenTmp1="disable.gif";
				}
			}
		}
	}

	if ($status == 1) {
		$sa="<font color='green' weight='bold'>En Funciones</font>";
	} else {
		$sa="<font color='red' weight='bold'>Inactiv@</font>";
	}

echo'
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
	</head>
	<body >
		<div style="height:95%; no-repeat center center">
			<img src="imagenes/inicio.jpg" style="width:90px;position:absolute;top:25px;left:30px">			
			<h1 style="width:100px;padding-left:80px">SA<font color="#191970" weight="bold">I</font></h1>
			<b style="width:100px;padding-left:80px">Seguimiento Academico Institucional <font color="#191970" weight="bold">modo: Docente</font><b/><hr></hr>		
			<h1>Bienvenid@, <font color="#191970" weight="bold">'.$nombre.'</font></h1>
			<img src="http://127.0.0.1/eneaware/imagenes/personal/'.$imagenTmp1.'" style="position:absolute;top:200px;left:40px;width:25%;border:2px solid grey;border-radius:5px" onclick="$(this).next().next().trigger(\'click\')"/><br/>
			<div style="position:absolute;top:170px;left:350px;background:rgba(255,255,255,0.6);">
				<br/><br/>
				<table>
					<tr>
						<td colspan="2"><font color="#191970" weight="bold">Datos generales del Docente:</font><hr></hr></td>
					</tr
					<tr>
						<td><font color="#191970" weight="bold">Mis Claves:</font><br> ';
					$consultaCla = mysqli_query($conexion, "SELECT * FROM Claves WHERE id_usuario='".$id."' ;");
			
					while($datos = mysqli_fetch_array($consultaCla)){			
						echo  "*".$datos["categoria"].$datos["horas"].$datos["plaza"]."<br>";
					}


					echo' </td>
					</tr>
					<tr>
						<td><font color="#191970" weight="bold">Mis Agsinaturas:</font> <br> ';
					$consultaDoce = mysqli_query($conexion, "SELECT * FROM Agsi_materia_doce WHERE id_docente='".$id."' ;");
			
					while($datos = mysqli_fetch_array($consultaDoce)){		

						$consultaMati = mysqli_query($conexion, "SELECT * FROM Materias WHERE id_materia='".$datos["id_materia"]."' ;");
			
						while($datos = mysqli_fetch_array($consultaMati)){			
							echo  "*Clave: ".$datos["clave"]." - ".$datos["materia"]."  ".$datos["semestre"]." / ".$datos["carrera"]."<br>";
						}

					}


					echo' </td> </td>
					</tr>
					<tr>
						<td><font color="#191970" weight="bold">Estado Laboral:</font> '.$sa.' </td>
					</tr>
				</table>		
		</div>
	</body>
</html>';

?>