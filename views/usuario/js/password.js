$(document).ready(function() {
	$("#client-form").validate({
		rules: {
			ANTIGUO: {
				required: true,
				minlength: 6
			},
			password: {
				required: true,
				minlength: 6
			},
			password_confirm: {
				required: true,
				equalTo: "#password"
			}
		},
		messages: {
			ANTIGUO: {
				required: "Ingresar contraseña anterior.",
				minlength: jQuery.format("Mínimo 6 caracteres.")
			},
			password: {
				required: "Ingresar nueva contraseña.",
				minlength: jQuery.format("Mínimo 6 caracteres.")
			},
			password_confirm: {
				required: "Repetir nueva contraseña.",
				equalTo: "No coincide con la nueva contraseña."
			}
		}
	});
});