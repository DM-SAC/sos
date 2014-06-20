$(document).ready(function() {
  var consulta;
  function getAlertas(){

    // consulta = $("#ultimo").val();
consulta = 'prueba';
    $.ajax({
      type: "POST",
      url: "../alerta/alertas",
      data: "ultimo="+consulta,
      dataType: "html",
      
      success: function(data){   
        $("tbody").prepend(data); 
        }
      });
    }
    setInterval(getAlertas, 5000);
});