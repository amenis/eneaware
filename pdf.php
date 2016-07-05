<?php
include("conexion.php");
require('lib/fpdf/fpdf.php');

	$folio=$_POST["alumno"];
	$hora = date("H:i:s");
	$hoy = date("Y-m-d");

	$consultaFolio = mysqli_query($conexion, "SELECT * FROM Folio_encuesta WHERE  folio='".$folio."' ;");
				
	while($datos = mysqli_fetch_array($consultaFolio)){	
		$id = $datos["id_alumno"];
		$en = $datos["id_encuesta"];
	}

		if ( isset($id) ) {

				$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$en."; ");
						
					while($datos = mysqli_fetch_array($con)){	
						$nombre_encuesta = $datos["nombre_encuesta"];
					}

				$consultaAl = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$id." ;");
							
					while($datosCurp = mysqli_fetch_array($consultaAl)){			
						$nombre = $datosCurp["apellidoP"]." ".$datosCurp["apellidoM"]." ".$datosCurp["nombre"];
						$domicilio = $datosCurp["calle_local"]."   ".$datosCurp["num_ext_local"];
						$ce = $datosCurp["municipio_local"]." - ".$datosCurp["estado_local"];
						$telefono = $datosCurp["tel_casa"];
						$email = $datosCurp["email"];
						$fn = $datosCurp["fecha_nacimiento"];
						$se = $datosCurp["sexo"];
						$id_alumno = $datosCurp["id_alumno"];
						$edad = date("Y")-$fn;
						$cu = $datosCurp["curp"];
						$matricula = $datosCurp["matricula"];
					}		
					if ($se=="M") {
						$sexo="Mujer";
					} else {
						$sexo="Hombre";
					}

				$consulEncuesta =mysqli_query($conexion,"SELECT * FROM Encuestas_activadas WHERE periodo=".$en." AND id_alumno=".$id." ; ");
						
					while($datos = mysqli_fetch_array($consulEncuesta)){	
						$aplicador = $datos["aplicador"];
						$fecho_inicio = $datos["fecha_inicio"]." | ".$datos["hora_inicio"];
						$fecho_fin = $datos["fecha_fin"]." | ".$datos["hora_fin"];
					}


					//Generarion del PDF

						$pdf=new FPDF();
						$pdf->AliasNbPages();
						$pdf->AddPage();


						$pdf->Image('imagenes/logo.png',10,10,40);
						$pdf->Cell(40);
						$pdf->SetFont('Arial','B',14);
						$pdf->SetTextColor(17,39,135);
						$pdf->Cell(8);
						$pdf->Cell(0,20,utf8_decode('Escuela Normal para Educadores de Arandas'));
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(66);
						$pdf->Cell(0,30,utf8_decode('Comprobante de termino Encuestas Alumnos'));
						$pdf->SetFont('Arial','B',12);
						$pdf->SetTextColor(178,8,8);
						$pdf->Ln(4);
						$pdf->Cell(145);
						$pdf->Cell(0,45,utf8_decode('Folio: '.$folio));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,70,utf8_decode('Matricula: '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,39,135);
						$pdf->Ln(0);
						$pdf->Cell(17);
						$pdf->Cell(0,70,utf8_decode($matricula));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,70,utf8_decode('Nombre de la alumna (o): '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,29,135);
						$pdf->Ln(0);
						$pdf->Cell(40);
						$pdf->Cell(0,70,utf8_decode($nombre));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,70,utf8_decode('Curp: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(10);
						$pdf->Cell(0,70,utf8_decode($cu));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(48);
						$pdf->Cell(0,70,utf8_decode('Fecha de Nacimiento: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(83);
						$pdf->Cell(0,70,utf8_decode($fn));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(102);
						$pdf->Cell(0,70,utf8_decode('Domicilio: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(118);
						$pdf->Cell(0,70,utf8_decode($domicilio));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,70,utf8_decode('Ciudad y Estado: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(28);
						$pdf->Cell(0,70,utf8_decode($ce));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(63);
						$pdf->Cell(0,70,utf8_decode('Telefono: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(79);
						$pdf->Cell(0,70,utf8_decode($telefono));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(102);
						$pdf->Cell(0,70,utf8_decode('E-mail: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(113);
						$pdf->Cell(0,70,utf8_decode($email));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,70,utf8_decode('Sexo: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(11);
						$pdf->Cell(0,70,utf8_decode($sexo));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(25);
						$pdf->Cell(0,70,utf8_decode('Edad: '));
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(35);
						$pdf->Cell(0,70,utf8_decode($edad));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,90,utf8_decode('Nombre de la Encuesta: '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,39,135);
						$pdf->Ln(0);
						$pdf->Cell(42);
						$pdf->Cell(0,90,utf8_decode($nombre_encuesta));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,90,utf8_decode('Aplicador: '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,39,135);
						$pdf->Ln(0);
						$pdf->Cell(42);
						$pdf->Cell(0,90,utf8_decode($aplicador));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,90,utf8_decode('Fecha y hora de inicio: '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,39,135);
						$pdf->Ln(0);
						$pdf->Cell(42);
						$pdf->Cell(0,90,utf8_decode($fecho_inicio));

						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,90,utf8_decode('Fecha y hora de termino: '));
						$pdf->SetFont('Arial','B',9);
						$pdf->SetTextColor(17,39,135);
						$pdf->Ln(0);
						$pdf->Cell(42);
						$pdf->Cell(0,90,utf8_decode($fecho_fin));

						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(10);
						$pdf->Cell(0,120,utf8_decode('Este documento se expide con finalidad de dar constancia que la alumna(o) concluyo exitosamente el llenado de su '));
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,120,utf8_decode('Encuesta de Alumnos que se le aplico con el objetivo de continuar con los tramites protocolarios de titulacion y/o necesarios'));
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,120,utf8_decode('para el plan de estudios vigente que este cursando. Se anexa la encuesta contestada por la alumna(o)'));
						$pdf->Ln(34);
						$pdf->Cell(1);
						$pdf->Cell(0,120,utf8_decode('___________________________'));
						$pdf->Ln(0);
						$pdf->Cell(130);
						$pdf->Cell(0,120,utf8_decode('___________________________'));
						$pdf->Ln(4);
						$pdf->Cell(12);
						$pdf->Cell(0,120,utf8_decode('Firma Alumna (o)'));
						$pdf->Ln(0);
						$pdf->Cell(143);
						$pdf->Cell(0,120,utf8_decode('Control Escoral'));
						$pdf->Ln(4);
						$pdf->Cell(1);
						$pdf->Cell(0,150,utf8_decode('*Este documento no tiene validez para tramites fuera de la institucion'));

						$pdf->Output('documentacion/Reportes_Encuestas_Pdf/reporte_de_'.$nombre.'_'.$folio.'.pdf');

					//fin

						$pdf=new FPDF();
						$pdf->AliasNbPages();
						$pdf->AddPage();

						$pdf->SetFont('Arial','',6.5);
						$pdf->SetTextColor(0);
						$pdf->Ln(0);
						$pdf->Cell(0,20,utf8_decode('Escuela Normal para Educadores de Arandas'));
						$pdf->Ln(6);
						$pdf->Cell(0,20,utf8_decode('Encuesta: '.$nombre_encuesta));
						$pdf->Ln(4);
						$pdf->Cell(0,20,utf8_decode('Folio: '.$folio));
						$pdf->Ln(4);
						$pdf->Cell(0,20,utf8_decode('Matricula: '.$matricula));
						$pdf->Ln(4);
						$pdf->Cell(0,20,utf8_decode('Alumna (o): '.$nombre));
						$pdf->Ln(4);
						$pdf->Cell(0,20,utf8_decode('Fecha y hora de expedicion: '.$hoy.' | '.$hora));
						$pdf->Ln(6);
						$pdf->Cell(0,20,utf8_decode('-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'));
						$pdf->Ln(6);
						$pdf->Cell(0,20,utf8_decode('Acontinuacion se presentan la encuesta contestada por el alumn@'));

						$cont=1;
						$c=1;
						$i=1;
						$Secciones = mysqli_query($conexion,"SELECT * FROM Secciones WHERE id_encuesta=".$en.";");
						
						while($datosSeccion = mysqli_fetch_array($Secciones)){

							$pdf->Ln(8);
							$pdf->Cell(0,20,utf8_decode('Seccion: '.$datosSeccion["nombre_seccion"]));
							
							$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas WHERE id_seccion = ".$datosSeccion["id_seccion"]." AND id_encuesta=".$en." ;");
											
								while($dato = mysqli_fetch_array($pregunta)){

									$pdf->Ln(6);
									$pdf->Cell(0,20,utf8_decode($c.'¿'.$dato["pregunta"].'?'),false);

									$Respuestas = mysqli_query($conexion, "SELECT * FROM Encuestas_contestadas WHERE id_pregunta='".$dato["id_pregunta"]."' AND id_alumno='".$id_alumno."' AND seccion=".$datosSeccion["id_seccion"]." ;");
									
									while($datosRespuesta = mysqli_fetch_array($Respuestas)){

										$consulResp = mysqli_query($conexion, "SELECT * FROM Respuestas WHERE id_respuesta='".$datosRespuesta["id_respuesta"]."';");
										$NumRespuestas =mysqli_num_rows($consulResp);

											while($datoRespuesta = mysqli_fetch_array($consulResp)){

												if ($datoRespuesta["tipo_respuesta"]=="Abierta") {

													if ($datosRespuesta["respuesta_contestada"]==NULL) {
														
													} else {
														$pdf->Ln(4);
														$pdf->Cell(10);
														$pdf->Cell(10,20,utf8_decode('R: '.$datosRespuesta["respuesta_contestada"]));
													}				

												}
												if ($datoRespuesta["tipo_respuesta"]=="Poropciones") {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode('R: '.$datoRespuesta["opciones"]));
												}
												if ($datoRespuesta["tipo_respuesta"]=="Poropciones | otro") {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode('R: '.$datoRespuesta["opciones"].' : '.$datosRespuesta["respuesta_contestada"]));
												}
															
											}

									}
									$c++;
								}
								
						}
						
						$Apartados = mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$en.";");
						
						while($datosApartado = mysqli_fetch_array($Apartados)){

							$pdf->Ln(8);
							$pdf->Cell(0,20,utf8_decode('Apartado: '.$datosApartado["nombre_apartado"]));

							$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_apartado WHERE id_apartado = ".$datosApartado["id_apartado"]." ;");
											
							while($dato = mysqli_fetch_array($pregunta)){

								$pdf->Ln(6);
									$pdf->Cell(0,20,utf8_decode($c.'¿'.$dato["pregunta"].'?'),false);

									$Respuestas = mysqli_query($conexion, "SELECT * FROM Encuestas_contestadas WHERE apartado='".$datosApartado["id_apartado"]."' AND id_pregunta='".$dato["id_pregunta_apartado"]."' AND id_alumno='".$id_alumno."' ;");
									$Num = mysqli_num_rows($Respuestas);

									if ($Num == 0) {
										$pdf->Ln(4);
										$pdf->Cell(10);
										$pdf->Cell(0,20,utf8_decode('La alumna (o) no requirio contestar esto'));

									} else {
							
										while($datosRespuesta = mysqli_fetch_array($Respuestas)){

											$consulResp = mysqli_query($conexion, "SELECT * FROM Respuestas_apartado WHERE id_respuesta_apartado='".$datosRespuesta["id_respuesta"]."';");

												while($datoRespuesta = mysqli_fetch_array($consulResp)){

													if ($datoRespuesta["tipo_respuesta"]=="Abierta") {
														$pdf->Ln(4);
														$pdf->Cell(10);
														$pdf->Cell(10,20,utf8_decode('R: '.$datosRespuesta["respuesta_contestada"]));
													}
													if ($datoRespuesta["tipo_respuesta"]=="Por opciones") {
														$pdf->Ln(4);
														$pdf->Cell(10);
														$pdf->Cell(10,20,utf8_decode('R: '.$datoRespuesta["opciones"]));
													}
													if ($datoRespuesta["tipo_respuesta"]=="Por opciones | otro") {
														$pdf->Ln(4);
														$pdf->Cell(10);
														$pdf->Cell(10,20,utf8_decode('R: '.$datoRespuesta["opciones"].' : '.$datosRespuesta["respuesta_contestada"]));
													}
															
												}

										}
									}
									$c++;		
							}
						}

						$n = 1;
						$pdf->Ln(8);
						$pdf->Cell(0,20,utf8_decode('Preguntas de las competencias:'));

						$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_capasidades WHERE id_encuesta=".$en." ;");
											
						while($dato = mysqli_fetch_array($pregunta)){

							$pdf->Ln(6);
							$pdf->Cell(0,20,utf8_decode($n.'¿'.$dato["pregunta"].'?'),false);

							$Respuestas = mysqli_query($conexion,"SELECT * FROM Respuesta_capasidad WHERE id_pregunta_capasidad=".$dato["id_pregunta_capasidad"]." AND id_alumno= ".$id_alumno." ;");
											
							
							
							while($datoRespuesta = mysqli_fetch_array($Respuestas)){

								$Competencias = mysqli_query($conexion,"SELECT * FROM Capasidades_encuesta WHERE id_capasidad=".$datoRespuesta["id_capasidad"]." ;");
											
								while($datos = mysqli_fetch_array($Competencias)){

												if ($datoRespuesta["respuesta"] == $dato["opcion1"]) {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode($datos["capasidad"].' R: '.$dato["opcion1"]));
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion2"]) {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode($datos["capasidad"].' R: '.$dato["opcion2"]));
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion3"]) {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode($datos["capasidad"].' R: '.$dato["opcion3"]));
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion4"]) {
													$pdf->Ln(4);
													$pdf->Cell(10);
													$pdf->Cell(10,20,utf8_decode($datos["capasidad"].' R: '.$dato["opcion4"]));
												}

												

								}

							}
							$n++;
								
						}


						$pdf->Output('documentacion/encuestas/encuesta_de_'.$nombre.'_'.$folio.'.pdf');
						



						echo 'Reportes generados con exito:<br/>
						<li>reporte_de_'.$nombre.'_'.$folio.'.pdf</li><br/>
						<li>encuesta_de_'.$nombre.'_'.$folio.'.pdf</li>';
						echo '<script>
									$("[carga=administrarEncuesta]").trigger("click");
									settimeout(function(){$("[ mostrar=encuestasDes ]").trigger("click") });
							  </script>';
			} else {
				echo '	<font color="red" weight="bold">Error: No. de Folio invalido</font>';
		}

?>