$(document).ready(function(){
    $('#unidad').validate({
        rules:{
            NUMERO:{
                required: true,
                minlength: 9,
                maxlength: 9
            },
            PLACA:{
                required: true,
                minlength: 6,
                maxlength: 6
            },
            CLAVE:{
                required: true,
                minlength: 6,
                maxlength: 20
            }
        },
        messages:{
            PLACA:{
                required: "Debe introducir la PLACA de la unidad.",
                minlength: "La PLACA debe tener 6 caracteres.",
                maxlength: "La PLACA debe tener 6 caracteres."
            },
            NUMERO:{
                required: "Debe introducir el Número de la unidad.",
                minlength: "El Número debe tener 9 dígitos.",
                maxlength: "El Número debe tener 9 dígitos."
            },
            CLAVE:{
                required: "Debe introducir una contraseña.",
                minlength: "La contraseña debe tener al menos 6 caracteres.",
                maxlength: "La contraseña debe tener como máximo 20 caracteres."
            }
        }
    });
});