<?php
 session_start();
    if(isset($_SESSION["Usuario_Eneaware"])){
        if($_SESSION["Permisos_Eneaware"][7]!="000"){
            include("conexion.php");
            if($_POST['accion']=="reg"){
                extract($_POST);
                $insertar = mysqli_query($conexion,"INSERT INTO Licencias() VALUES(null,'".$id."','".$fCreacion."', '".$fInicio."','".$fFinal."',1,'".$asunto."','".$notas."')");
                if($insertar){
                    echo'
                        Lincencia Registrada
                        <script>
                            $("[carga=licencias]").trigger("click");
                            setTimeout(function(){$("[ mostrar=regLic]").trigger("click") });
                        </script>
                    ';
                }
                else{
                   echo mysqli_error($conexion);
                }
            }
            if($_POST['accion']=="baja"){
                extract($_POST);
                $baja =  mysqli_query($conexion,"UPDATE Licencias SET status=0, notas=concat('<div style=\"position:absolute;top:45%;left:35%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', notas)  WHERE id_licencias='".$id."' ");
                if($baja){
                    echo'
                        Licencia Cancelada
                         <script>
                            $("[carga=licencias]").trigger("click");
                            setTimeout(function(){$("[ mostrar='.$seccion.']").trigger("click") });
                        </script>
                    ';
                }
              
            }
              if($_POST['accion']=="restaurar"){
                extract($_POST);
                $baja =  mysqli_query($conexion,"UPDATE Licencias SET status=1, notas=replace(notas, '<div style=\"position:absolute;top:45%;left:35%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>','')  WHERE id_licencias='".$id."' ");
                if($baja){
                    echo'
                        Licencia Cancelada
                         <script>
                            $("[carga=licencias]").trigger("click");
                            setTimeout(function(){$("[ mostrar='.$seccion.']").trigger("click") });
                        </script>
                    ';
                }
              
            }
        }
    }
?>