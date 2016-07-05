var contadorV = 0;
//document.oncontextmenu = function(){return false}


$(document).ready(function () {	
    
      
	$("body").on("submit", "form", function () {
		var destino = "#"+$(this).attr("destino");  
		var datos = new FormData();
		inputs = $(this).serialize();
		entradas = inputs.split("&");
		for(x=0;x<entradas.length;x++){
			var temp = entradas[x].split("=");
			valor= replaceAll(decodeURIComponent(temp[1].toString()), "+", " ");
			datos.append(temp[0], valor);
		}		
		var archivos = $(this).find($("input:file"));
		archivos.each(function(){  						
  			datos.append($(this).attr("nombre"),this.files[0]);
  		});
  		$.ajax({
			url:$(this).attr("action"),
			type:"POST",
			contentType:false,
			data:datos,
			processData:false,
			cache:false,
			success: function(data) {
				if($(destino).attr("class")=="gtk"){
					$(destino).show("drop",{direction:"down"}, "slow").delay(5000).hide("drop",{direction:"down"}, "slow");
				}
				else{
					$(destino).fadeIn();
				} 
    			$(destino).html(data);
	  		}
		});
		//$(destino).fadeIn("fast").html('Ejecutando accion...');					   	 	      
		return false;
  });
  $(".gtk").on("click", function () {
  		$(this).stop().hide("drop",{direction:"down"}, "medium");
  });
    
    
  $("#menu button").on("click", function () {
        $('#menu button').removeClass("seleccionado");  
        $(this).addClass("seleccionado");
  		if($(this).parent().attr("class")=="submenu"){
  			if($(this).attr("submenu")!==undefined){
  				este = $(this);
  				$("#menu .submenu").not($(this).parent()).not("#"+este.attr("submenu")).hide("fold");
  				$("#"+este.attr("submenu")).show("drop" , function(){
  					$("#marcador").animate({top: este.position().top+1.5}, "fast");
  				});
  			}
  			else{ 				
  				este = $(this);
  				$("#menu .submenu").not($(this).parent()).hide("fold", function(){
  					$("#marcador").animate({top: este.position().top+2}, "fast");
  				});
  				$("#marcador").animate({top: este.position().top+2}, "fast");
  			}	
  		}
  		else{
  			if($(this).attr("submenu")!==undefined){
  				este = $(this);
  				$(".submenu").not("#"+este.attr("submenu")).hide("fold");
  				$("#"+$(this).attr("submenu")).show("drop" , function(){
  					$("#marcador").animate({top: este.position().top+1}, "fast");
  				});
  			}
  			else{
  				este = $(this);
  				$("#menu .submenu").hide("fold", function(){
  					$("#marcador").animate({top: este.position().top+1.5}, "fast");
  				});
  			}
  		}
  		var carga = $(this).attr("carga");
        $("#principal").load(carga+".php");
  		if($(this).attr("class")=="subBoton seleccionado"){
  			$("[submenu="+$(this).parent().attr("id")+"]").addClass("seleccionado");
  		}
     
  });
  $("body").on("click", "button.tab", function () {
  		$("#principal button.tab").removeClass("seleccionado");
  		$(this).addClass("seleccionado");
  		var mostrar = "#"+$(this).attr("mostrar");
  		$(".tabCont").not(mostrar).hide();
  		$(mostrar).fadeIn();
  });
  $("body").on("change", ":file", function () {
  		var oFReader = new FileReader();
  		este = $(this);
      oFReader.readAsDataURL(this.files[0]);
      oFReader.onload = function (oFREvent) {
      	este.prev().prev().attr("src", oFREvent.target.result);
      	$("#"+este.attr("otroPrevio")).attr("src", oFREvent.target.result);
      };
  });
  $("#ayudaG").on("click", function () {
  		$("#ayuda").fadeIn();
  		$("#ayuda"+$("#menu button.seleccionado:last-child").attr("carga")).fadeIn();  		
  });
  $("#todo").fadeIn();
  $("#principalInner").load("inicio.php", function () {
  	$("#cargaInicial").fadeOut();
  });

  /* 
  $("body").on("keyup", "[type=search]", function () {
      console.log($(this).attr("opcion"));
      $.ajax({
        url:$(this).attr("busqueda"),
        type:"POST",
        data:{
                busqueda:$(this).val(),
                accion:$(this).attr("opcion")          
              },
        success:function(msg){
            $("#resultadoRegistro").html(msg);
        },
        error:function(error){
          alert(error);
        }

      });
         
        if ($(this).val()!="") {

            padre = $(this).attr("padre");
            hijo = $(this).attr("hijo");
            $("#"+hijo).load(padre+" #"+hijo,{busqueda:$(this).val()}).show("drop");
          
    			$("#"+$(this).attr("padre")+" > div[tipo=fila]").not("div[nombre*='"+$(this).val().toLowerCase()+"']").hide("drop");
    			$("#"+$(this).attr("padre")+" > div[nombre*='"+$(this).val().toLowerCase()+"']").show("drop");
    		}
        else{
          $("#"+hijo).load(padre+" #"+hijo,{busqueda:''}).show("drop");

        }
      
  		
  });

  
  desplegar = false;
  $("#marcador").on("click", function () {
  		if(!desplegar){
  			$("#menu").parent().animate({width: "25px"}, "fast");
  			$("#menu").children().not("#marcador").hide("fold");
  			$("#marcador").children().attr("src", "imagenes/plus.png");
  			desplegar=true;
  		}
  		else{
  			$("#menu").parent().animate({width: "250px", "text-align": "center"}, "fast");
  			$("#menu > button").not("#marcador").show("fold");
  			$("#"+$("#menu button.seleccionado").attr("submenu")).show("fold");
  			$("#marcador").children().attr("src", "imagenes/minus.png");
  			desplegar=false;
  		}
  });*/
  $("*").tooltip({
  		show:{ 
  			effect: "drop", 
  			duration: 500, 
  			direction:"up",
  			delay:1000 
  		},
  		hide:{ 
  			effect: "drop", 
  			duration: 500, 
  			direction:"up",
  			delay:500
  		},
  		position:{ 
  			my: "left-30 top+25,",
  			at: "right center" 
  		},
  		tooltipClass: "tooltip",
  		content: function () {
 			return $(this).prop('title');
  		}
  });
  $("body").on("keydown", "#registrarClaves form table tr td input", function () {
  		calcularClave();
  });
  $("body").on("keyup", "#registrarClaves form table tr td input", function () {
  		calcularClave();
  });
  $("body").on("change", "#registrarClaves form table tr td select", function () {
  		calcularClave();
  });
  
  $("body").on("change", "#idComViaticos", function () {
  		$("#tablaUComViaticos").html("");
  		var datos = new FormData();
  		var ids = $(this).find("option:selected").attr("idsU");
  		datos.append("accion","miniconsulta");
  		datos.append("ids",ids);
  		$.ajax({
			url:"accionesPersonal.php",
			type:"POST",
			contentType:false,
			data:datos,
			processData:false,
			cache:false,
			success: function(data) {
				$("#tablaUComViaticos").html(data);
	  		}
		});
      
  });
  
  $("body").on("click", "button[accion='agregarDetViatico']", function () {
  		contadorV++;
  		$(this).prev().prev().prev().prev().append("<tr>"+
  			"<td><input type='text' name='conceptoU"+$(this).attr("idU")+"_"+contadorV+"' placeholder='Ej: comida'></td>"+
  			"<td><input type='number' value=0 class='cantDetallesViaC' min='0' step='any' name='totalU"+$(this).attr("idU")+"_"+contadorV+"' placeholder='Ej: 200'></td>"+
  			"<td><input type='text' name='vidaU"+$(this).attr("idU")+"_"+contadorV+"' placeholder='Ej: cara'></td>"+  			
  			"<td><img src='imagenes/bin.png' onclick='$(this).parent().prev().prev().find(\"input:first-child\").val(\"0\").trigger(\"change\");$(this).parent().parent().remove()'></td></tr>")
  });
  
  $("body").on("change", "input.cantDetallesViaC", function () {
  		var totales = $(this).parent().parent().parent().find("tr td input.cantDetallesViaC");
  		var totalDV = 0;
  		totales.each(function () {
  			totalDV += parseFloat($(this).val());
  		});
  		$(this).parent().parent().parent().parent().next().val(totalDV);
  });
  
  $("body").on("keyup", "input.cantDetallesViaC", function () {
  		var totales = $(this).parent().parent().parent().find("tr td input.cantDetallesViaC");
  		var totalDV = 0;
  		totales.each(function () {
  			totalDV += parseFloat($(this).val());
  		});
  		$(this).parent().parent().parent().parent().next().val(totalDV);
  });
  
  $("body").on("keydown", "input.cantDetallesViaC", function () {
  		var totales = $(this).parent().parent().parent().find("tr td input.cantDetallesViaC");
  		var totalDV = 0;
  		totales.each(function () {
  			totalDV += parseFloat($(this).val());
  		});
  		$(this).parent().parent().parent().parent().next().val(totalDV);
  });
});

function replaceAll(text, search, newstring ){
    while (text.toString().indexOf(search) != -1)
        text = text.toString().replace(search,newstring);
    return text;
}

function animarInicio() {
	animarG1();
	animarG2();
	animarG3();
	animarG4();
	animarG5();
	animarG6();
}
function animarG1() {
	$("#cirG1").animate({left:"-200px"}, 7500, function () {
  		$("#cirG1").animate({left:"-2400px"}, 7500, function () {
  			animarG1();
  		});
  	});
}
function animarG2() {
	$("#cirG2").animate({left:"-200px"}, 9000, function () {
  		$("#cirG2").animate({left:"-2400px"}, 9000, function () {
  			animarG2();
  		});
  	});
}
function animarG3() {
	$("#cirG3").animate({left:"-200px"}, 6000, function () {
  		$("#cirG3").animate({left:"-2400px"}, 6000, function () {
  			animarG3();
  		});
  	});
}
function animarG4() {
	$("#cirG4").animate({left:"-200px"}, 5000, function () {
  		$("#cirG4").animate({left:"-2400px"}, 5000, function () {
  			animarG4();
  		});
  	});
}
function animarG5() {
	$("#cirG5").animate({left:"-200px"}, 6000, function () {
  		$("#cirG5").animate({left:"-2400px"}, 4000, function () {
  			animarG5();
  		});
  	});
}
function animarG6() {
	$("#cirG6").animate({left:"-200px"}, 5500, function () {
  		$("#cirG6").animate({left:"-2400px"}, 5000, function () {
  			animarG6();
  		});
  	});
}

function calcularClave() {
	$("#claveGenerada").val($("#puestoClave").val()+$("#categoriaClave").val()+$("#horasClave").val()+$("#plazaClave").val());
}

function agregarUCom(este) {
	var idU = este.prev().find('option:selected').attr('value');
	este.next().append('<div class=userCom idU='+idU+'>'+este.prev().find('option:selected').text()+
		'<input type=hidden readonly name=usuario'+idU+' value='+idU+'>'+
		'<img style=position:relative;top:2px;left:8px; src=imagenes/bin.png onclick=$("[idU='+idU+']").remove()></div>');
	este.next().next().append('<div idU='+idU+' style="font-weigth:bold">'+este.prev().find('option:selected').text().toUpperCase()+'<br>'+
		este.prev().find('option:selected').attr('nombramiento').toUpperCase()+'<br></div>');
}

