$(document).ready(function(){
    $('#usuario').validate({
        rules:{
            NOMBRE:{
                required: true,
                maxlength: 20
            },
            APELLIDOS:{
                required: true,
                maxlength: 30
            }
        },
        messages:{
            NOMBRE:{
                required: "Debe introducir el nombre.",
                maxlength: "Máximo 20 caracteres."
            },
            APELLIDOS:{
                required: "Debe introducir el apellido.",
                maxlength: "Máximo 30 caracteres."
            }
        }
    });
});