$(document).ready(function(){
    $('#administrador').validate({
        rules:{
            NOMBRE:{
                required: true
            },
            APELLIDOS:{
                required: true
            },
            CLAVE:{
                required: true,
                minlength: 6,
                maxlength: 20
            },
            EMAIL:{
                required: true,
                email: true
            },
            NUMERO:{
                required: true,
                minlength: 9,
                maxlength: 9
            }
        },
        messages:{
            NOMBRE:{
                required: "Debe introducir el nombre del administrador."
            },
            APELLIDOS:{
                required: "Debe introducir el apellido del administrador."
            },
            CLAVE:{
                required: "Debe introducir una contraseña.",
                minlength: "La contraseña debe tener al menos 6 caracteres.",
                maxlength: "La contraseña debe tener como máximo 20 caracteres."
            },
            EMAIL:{
                required: "Debe introducir el email del administrador.",
                email: "Debe introducir un email valido."
            },
            NUMERO:{
                required: "Debe introducir el Número del administrador.",
                minlength: "El Número debe tener 9 dígitos.",
                maxlength: "El Número debe tener 9 dígitos."
            }
        }
    });
});