$(document).ready(function() {    
    var consulta;
        $('#EMAIL').blur(function(){
        // $('#info').html('COMPROBANDO...').fadeOut(1000);
        consulta = $("#EMAIL").val();
if (consulta=="") {
                    return false;
                }
        $.ajax({
            type: "POST",
            url: "validarEmail",
            data: "EMAIL="+consulta,
            dataType: "html",
            success: function(data) {
                // $('#info').html('');
                if (data=="uno") {
                    $("#EMAIL").focus();
                }
                $('#info').html(data);

            }
        });
    });              
});    