// $(document).ready(function() {
//     function getRandValue(){
//         value = $('#value').text();
//         //var dataString = 'value='+value;

//         $.ajax({
//             type: "POST",
//             url: "../bombero/random",
//             //data: dataString,
//             success: function(data) {
//                 $('#value').text(data);
//             }
//         });
//     }

//     setInterval(getRandValue, 3000);
// });

// $(document).ready(function() {
//     function getAlertas(){
//         // value = $('#value').text();
//         //var dataString = 'value='+value;

//         $.post("../bombero/alertAjax",{},function(cadena){
//             $("#fila").html(cadena); 
//         })


        // $.ajax({
        //     type: "POST",
        //     url: "../bombero/alertas",
        //     //data: dataString,
        //     success: function(data) {
        //         $('#value').text(data);
        //     }
        // });
    }

//     setInterval(getAlertas, 3000);
// });

// $(document).ready(function() {
//     $('#departamento').live('change',function(){
//         $.post("../provincias/"+$('#departamento').val(),{},function(cadena){
//             $("#provincia").html(cadena); 
//             $("#distrito").html(''); 
//         })
//     });
//     $('#provincia').live('change',function(){
//         $.post("../distritos/"+$('#departamento').val()+"/"+$('#provincia').val(),{},function(cadena){
//             $("#distrito").html(cadena); 
//         })
//     });
// });