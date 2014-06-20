$(document).ready(function(){

    $('#button-blue').click(function(){
        $(".er").html(''); 

    });

    $('#login').validate({
        rules:{
            usuario:{
                required: true,
                email: true
            },
            clave:{
                required: true,
                minlength: 6
            }
        },
        messages:{
            usuario:{
                required: "Debe introducir su email.",
                email: "Debe ingresar un email válido"
            },
            clave:{
                required: "Debe introducir la contraseña.",
                minlength: "La contraseña contiene 6 caracteres como mínimo."
            }
        }

    });
});