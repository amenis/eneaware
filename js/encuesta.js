var contpre=1;
var contop=2;
var cont=0;
    
$(document).ready(function(){
	
	//add preguntas
	$("#AddPre").on("click",function(){
		contpre++;
		if(contpre==21){
			alert("No puede agregar mas preguntas");
		}
		else{
			$('#opciones').append('');
		}
    });
    $("#DelPre").on("click",function(){
		
		
    });
    //fin
    
    //add opciones
    $("#AddOp").on("click",function(){
		contop++;
		if(contop==11){
			contop--;
			alert("No puede agregar mas opciones a esta pregunta");
		}
		else{
			$('#opciones').append('<div id="'+contop+'"><label>Opcion '+contop+':</label><br/><input type="text" required="required" name="op'+contop+'"/></div>');
		}
    });
    
     //add otro
    $("#AddOt").on("click",function(){
		cont++;
		if(cont==5){
			cont--;
			alert("No puede agregar mas opciones de espesificar a esta pregunta");
		}
		else{
			$('#opciones').append('<div id="'+cont+'"><br/><b><input type="text" placeholder="Otro:" required="required" title="Agrege esta opcion" name="OpOt'+cont+'"/> : </b><input type="text" placeholder="Este campo no se completa" name="otro"/></div>');
		}
    });
    
    //del opcion
    $("#DelOp").on("click",function(){
		if (contop==0) {
			alert("no hay opciones para eliminar");
		} 
		else {
			$( '#'+contop ).remove();
			contop--;
		};
    });
    $("#DelOt").on("click",function(){
		if (cont==0) {
			alert("no hay opciones de otro para eliminar");
		} 
		else {
			$( '#'+cont ).remove();
			cont--;
		};
    });
   //fin
   
   //tipo respuesta
   $("#Abierta").on("click",function(){
		$( '#Res' ).hide();
		$( '#abierta' ).toggle( 'slide' );
		$( '#Atras' ).toggle( 'slide' );
   }); 
   $("#PorOp").on("click",function(){
		$( '#Res' ).hide();
		$( '#opciones' ).toggle( 'slide' );
		$( '#Bot' ).toggle( 'slide' );
		$( '#Atras' ).toggle( 'slide' );
    }); 
    $("#Atras").on("click",function(){
		$( '#abierta' ).hide();
		$( '#opciones' ).hide();
		$( '#Bot' ).hide();
		$( '#Atras' ).hide();
		$( '#Res' ).toggle( 'slide' );
    }); 
    //fin
	   
	 //aparecer
	 $('#SecEn').on("change",function(){
        $('#UpEn').show();
    });
    $('#SecSec').on("change",function(){
        $('#UpSec').show();
    });
    $('#SecAp').on("change",function(){
        $('#UpAp').show();
    });
    //fin
});