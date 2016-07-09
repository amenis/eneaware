<?php
    session_start();
    if(isset($_SESSION["Usuario_Eneaware"])){
       
?>    
    <html>
    <head>
        <meta charset="utf-8" />
        <title>EneaWare</title>
        <link href="../css/jquery-ui.css" rel="stylesheet">					
       
        <link href="../css/servidor.css" rel="stylesheet">	
        <link rel="icon" type="image/png" href="../imagenes/icono.png"/>
        <link href="../css/tabs_jquery.css" rel="stylesheet">
        <link href="../css/bootstrap.css" rel="stylesheet">
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/printThis.js"></script>
        <script src="../js/servidor.js"></script>
        <script src="../js/main.js"></script>
        
    </head>
    <body style="overflow:hidden">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                  <li><!--<a href="#" data-url=''><span class="glyphicon glyphicon-user">--><span id="time"  class="glyphicon"></span></li>
                  <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>
        </nav>
        <aside class="sidebar-menu">
            <div id="id-user">
                <img src="../imagenes/user.gif" alt="user image" style="border-radius:80px" width="80" height="80"/>
                <span style="color:white"><?php echo $_SESSION['Nombre_Usuario_Eneaware'];?></span>
            </div>
            <div id="menu">
                <div id="marcador"></div>
                 <?php
				    if($_SESSION["Permisos_Eneaware"][0]!="000" || 
					   $_SESSION["Permisos_Eneaware"][1]!="000" || 
                       $_SESSION["Permisos_Eneaware"][2]!="000" || 
                       $_SESSION["Permisos_Eneaware"][3]!="000" || 
                       $_SESSION["Permisos_Eneaware"][4]!="000" || 
                       $_SESSION["Permisos_Eneaware"][5]!="000" || 
                       $_SESSION["Permisos_Eneaware"][6]!="000" || 
                       $_SESSION["Permisos_Eneaware"][7]!="000" || 
                       $_SESSION["Permisos_Eneaware"][8]!="000" || 
                       $_SESSION["Permisos_Eneaware"][9]!="000") {
                        echo'
						  <button carga="recursosHumanos" class="botonMenu" submenu="subHuman">Recursos humanos</button>
						  <div id="subHuman" class="submenu">';
                                if($_SESSION["Permisos_Eneaware"][0]!="000") {
                                    echo '<button class="subBoton" carga="personal">Personal ENEA</button>';
				                }
				                if($_SESSION["Permisos_Eneaware"][1]!="000") {
                                    echo '<button class="subBoton" carga="claves">Claves</button>';
								}
								if($_SESSION["Permisos_Eneaware"][2]!="000") {
									echo '<button class="subBoton" carga="comisiones">Comisiones</button>';
								}
								if($_SESSION["Permisos_Eneaware"][3]!="000") {
									echo '<button class="subBoton" carga="viaticos">Viaticos</button>';
								}
								if($_SESSION["Permisos_Eneaware"][5]!="000") {
									echo '<button class="subBoton" carga="horarios">Horarios</button>';
								}
								if($_SESSION["Permisos_Eneaware"][6]!="000") {
                                    echo '<button class="subBoton" carga="incidencias">Incidencias</button>';
								}
								if($_SESSION["Permisos_Eneaware"][7]!="000") {
                                    echo '<button class="subBoton" carga="licencias">Licencias</button>';
                                }
								if($_SESSION["Permisos_Eneaware"][8]!="000") {
									echo '<button class="subBoton" carga="propuestas">Propuestas</button>';
								}
								if($_SESSION["Permisos_Eneaware"][9]!="000") {
									echo '<button class="subBoton" carga="prestadores">Prestadores de Servicio</button>';
								}
								if($_SESSION["Permisos_Eneaware"][4]!="000") {
									echo '<button class="subBoton" carga="reportesRH">Reportes</button>';
								}
				        echo'
						</div>';
				    }
                    include("../menu.php");
					if($_SESSION["Permisos_Eneaware"][25]!="000" ) {
					   echo'<button carga="confi" class="botonMenu">Coonfiguracion del Sistema</button>';
					}
                    if($_SESSION["Permisos_Eneaware"][26]!="000" ) {
					   echo'<button carga="recep" class="botonMenu">Recepcion</button>';
				    }
				?>
            </div>
        </aside>
        <section>
            <article >
                <div id="principal">
                    <div style="height:95%;background:url(../imagenes/inicio.jpg) no-repeat center">
                        <h1 style="position:absolute;left:40%;">Bienvenid@</h1>                    		
                    </div>
                </div>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">logout</h4>
                              </div>
                              <div class="modal-body">
                                <p>¿Estas Seguro de Cerrar Sesion?</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" id="close_session" class="btn btn-warning">Si</button>                              
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                              </div>
                        </div>

                  </div>
                </div>
            </article>
            
        </section>
    </body>
</html>

<?php    
	}
    else{  
        header("location: ../index.php");

    }
?>