$(document).ready(function() {
		$("#usuario").validate({
		rules: {
			NOMBRE: {
				required: true,
				maxlength: 30
			},
			APELLIDOS: {
				required: true,
				maxlength: 30
			},
			EMAIL: {
				required: true,
				email: true
			}
		},
		messages: {
			NOMBRE: {
				required: "Ingrese su nombre.",
				maxlength: jQuery.format("Máximo 30 caracteres.")
			},
			APELLIDOS: {
				required: "Ingrese sus apellidos.",
				maxlength: jQuery.format("Máximo 30 caracteres.")
			},
			EMAIL: {
				required: "Ingrese su email.",
				email: "No es un email correcto."
			}
		}
	});

	$('#departamento').live('change',function(){
		$.post("../provincias/"+$('#departamento').val(),{},function(cadena){
			$("#provincia").html(cadena); 
			$("#distrito").html(''); 
		})
	});
	$('#provincia').live('change',function(){
		$.post("../distritos/"+$('#departamento').val()+"/"+$('#provincia').val(),{},function(cadena){
			$("#distrito").html(cadena); 
		})
	});
});