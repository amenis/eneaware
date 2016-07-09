<?php
	echo '
		<h1>¿Estas seguro que deseas salir?</h1>
		<button style="width:250px;" onclick="$(\'#principal\').load(\'destroy.php\', function(){location.reload()})">Si</button>
		<button style="width:250px" onclick="$(\'#menu [carga=inicio]\').trigger(\'click\')">No</button>
	';
?>