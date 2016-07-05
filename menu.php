<?php
			//control Escolar
			if($_SESSION["Permisos_Eneaware"][10]!="000" || 
				$_SESSION["Permisos_Eneaware"][11]!="000" || 
				$_SESSION["Permisos_Eneaware"][12]!="000" ||
				$_SESSION["Permisos_Eneaware"][13]!="000" || 
				$_SESSION["Permisos_Eneaware"][14]!="000"  ){
				 echo'<button carga="ControlEscolar" class="botonMenu" submenu="subCE">Control Escolar</button>';
				 
					echo'<div id="subCE" class="submenu">';
							if($_SESSION["Permisos_Eneaware"][10]!="000") {
								echo'<button class="subBoton" carga="alumnos">Alumnos ENEA</button>';
							}
							if($_SESSION["Permisos_Eneaware"][11]!="000") {
								echo'<button class="subBoton" carga="seguimiento">Seguimiento Academico</button>';
							}
							if($_SESSION["Permisos_Eneaware"][12]!="000"){
								echo'<button class="subBoton" carga="administrarEncuesta">Encuestas Alumnos</button>';
							}
							if($_SESSION["Permisos_Eneaware"][13]!="000"){
								echo'<button class="subBoton" carga="practicantes">Lugares Practicantes</button>';
							}
							
					echo'</div>';
			 }		
			//SAI Docentes
			if($_SESSION["Permisos_Eneaware"][22]!="000" || 
				$_SESSION["Permisos_Eneaware"][23]!="000" || 
				$_SESSION["Permisos_Eneaware"][24]!="000" ){
				echo'<button carga="SegimientoAcademicoInstitucional" class="botonMenu" submenu="subSAI">Segimiento Academico Institucional</button>';
				 
					echo'<div id="subSAI" class="submenu">';
							if($_SESSION["Permisos_Eneaware"][22]!="000") {
								echo'<button class="subBoton" carga="subir">Subir Calificicaciones</button>';
							}
							if($_SESSION["Permisos_Eneaware"][23]!="000") {
								echo'<button class="subBoton" carga="horariosDocentes">Mis Horarios</button>';
							}
							if($_SESSION["Permisos_Eneaware"][24]!="000") {
								echo'<button class="subBoton" carga="materiasDocentes">Mis Agsinaturas</button>';
							}
					echo'</div>';
			 }		


?>	