function getDeskripsi(th){
	console.log('Deskripsi Error');
	var param = $(th).val();
	$.ajax({
		url: baseurl + "OrderSharpening/Order/getDeskripsi",
		type: 'POST',
		dataType:'json',
		data: {param:param},
		beforeSend: function(){

		},
		success: function(result){
			console.log(result);

			$('#desc_sharp').val(result);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
		}
	});
}

function validasi()                                    
{ 
    var item = document.forms["Orderform"]["txtItem"];               
    var desc = document.forms["Orderform"]["txtDesc"];    
    var qty = document.forms["Orderform"]["txtQty"];  

    if (item.value == "")                                  
    { 
    	//window.alert("Please enter your item.");
        item.focus(); 
        var element = document.getElementById("item_error");
        element.style.display = "block"
        return false;  
    } 
   
    if (desc.value == "")                               
    { 
    	//window.alert("Please enter your desc."); 
        desc.focus(); 
        return false; 
    } 
       
    if (qty.value == "")                                   
    { 
        //window.alert("Please enter a valid qty."); 
        qty.focus(); 
        var element = document.getElementById("qty_error");
        element.style.display = "block"
        // element.classList.add('alert alert-warning');
        return false; 
    } 
    return true; 
} 


/// function klir(th) {

// 	var formkuh = document.getElementById("formkuh");
// 		console.log
//         if (formkuh.value == "") {
//             //If the "Please Select" option is selected display error.
//             alert("Please select an option!");
//           	return false;
//         } else
//         {
//         	$('#formkuh').submit();
//         	$('input, select').val('');
// 			$('#item_sharp').val(null).trigger('change');
// 			return true;
//         }


// }