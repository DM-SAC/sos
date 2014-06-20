$(document).ready(function(){
    $('#usuario').validate({
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
            NUMERO:{
                required: true,
                minlength: 9,
                maxlength: 9
            },
            DNI:{
                required: true,
                minlength: 8,
                maxlength: 8
            }
        },
        messages:{
            NOMBRE:{
                required: "Debe introducir el nombre del usuario."
            },
            APELLIDOS:{
                required: "Debe introducir el apellido del usuario."
            },
            CLAVE:{
                required: "Debe introducir una contraseña.",
                minlength: "La contraseña debe tener al menos 6 caracteres.",
                maxlength: "La contraseña debe tener como máximo 20 caracteres."
            },
            DNI:{
                required: "Debe introducir el DNI del usuario.",
                minlength: "El DNI debe tener 8 dígitos.",
                maxlength: "El DNI debe tener 8 dígitos."
            },
            NUMERO:{
                required: "Debe introducir el Número del usuario.",
                minlength: "El Número debe tener 9 dígitos.",
                maxlength: "El Número debe tener 9 dígitos."
            }
        }
    });
});