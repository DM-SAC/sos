$(document).ready(function() {
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