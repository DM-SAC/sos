$(document).ready(function(){
  
$('form').keypress(function(e){   
    if(e == 13){
      return false;
    }
  });

  $('input').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });

  var consulta;

  $("#buscar").keyup(function(e){

  consulta = $("#buscar").val();
                                                                      
  $.ajax({
    type: "POST",
    url: "../alerta/alertas",
    data: "buscar="+consulta,
    dataType: "html",
    beforeSend: function(){
      $("#resultado").html("<br><br><p>CARGANDO ...</p></br><br>");
      // $("#resultado").html('<img src="<?= $_layoutParams["ruta_img"]?>carga.gif">');
    },
    error: function(){
          alert("error petición ajax");
    },
    success: function(data){   
      $("#resultado").html('');                                                  
      $("#resultado").html(data); 
      }
    });
  });   
});