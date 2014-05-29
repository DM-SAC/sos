$(document).ready(function(){
    $('#login').validate({
        rules:{
            usuario:{
                required: true,
                email: true
            },
            clave:{
                required: true
            }
        },
        messages:{
            usuario:{
                required: "Debe introducir el usuario (email).",
                email: "Debe ingresar un email válido"
            },
            clave:{
                required: "Debe introducir la contraseña."
            }
        }
    });
});