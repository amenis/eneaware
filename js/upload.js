 var cont=1;

$(document).ready(function(){
   $("#add").on("click",function(){
      cont++;
      $('#adjuntos').append('<div id="'+cont+'"><label>Nombre del documento:</label> <input type="text" required="required" name="nomDoc'+cont+'"/> <input type="file" name="doc'+cont+'" /></div>');
      $( '#a' ).remove();
      $('#adjuntos').append('<div id="a"><input type="text" value="'+cont+'" name="numDoc"/></div>');   
    });
   $("#del").on("click",function(){
      if (cont==1) {
         alert("Error: ya no puede eliminar");
      } 
      else {
         $( '#'+cont ).remove();
         cont--;
         $( '#a' ).remove();
         $('#adjuntos').append('<div id="a"><input type="text" value="'+cont+'" name="numDoc"/></div>');   
      };
    });
 });