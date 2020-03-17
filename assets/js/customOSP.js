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

$('#subinv').change(function(){
    var subinv = $(this).val();
    console.log(subinv);
    $("#locator").select2('val', null);
    
    $.ajax( {
            url:baseurl+"OrderSharpening/Order/getLocator",
            dataType: 'json',
            type:'POST',
            data : {
                subinv : subinv
                },
            success: function (data) {
                $('#locator').html('');
                for (let i = 0; i < data.length; i++) {
                    var element = data[i];
                    // console.log(element)
                    $('#locator').append('<option value="'+element.INVENTORY_LOCATION_ID+'">'+element.SEGMENT1+" - "+element.INVENTORY_LOCATION_ID+'</option>');
                    
                }
                $('#locator').select2('val',null);
            }
        }
    );
});

function validasi()                                    
{ 
    var item = document.forms["Orderform"]["item_sharp"];               
    var desc = document.forms["Orderform"]["desc_sharp"];    
    var qty = document.forms["Orderform"]["qty_sharp"];  

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

var i = 1;
function addRowOrderSharpening(){
    var noOrder = $('#no_order').val();
    var reffNumber = $('#reff_number').val();
    var subinv = $('#subinv').val();
    var locator = $('#locator').val();
    var kodeBarang = $('#item_sharp').val();
    var deskBarang = $('#desc_sharp').val();
    var quantity = $('#qty_sharp').val();

    var tambahan = '';

    $('#tbodyUserResponsibility').append('<tr class="clone"><td><input type="hidden" name="reffNumber[]" value="'+reffNumber+i+'" readonly><input type="hidden" name="noOrder[]" value="'+noOrder+i+'" readonly><input type="text" name="subinv[]" value="'+subinv+'" readonly class="form-control"></td><td><input type="text" name="locator[]" value="'+locator+'" readonly class="form-control"></td><td><input type="text" name="kodeBarang[]" value="'+kodeBarang+'" readonly class="form-control"></td><td><input type="text" name="deskBarang[]" value="'+deskBarang+'" readonly class="form-control"></td><td><input type="text" name="quantity[]" value="'+quantity+'" readonly class="form-control"></td><td><button onclick="Alert()" type="button" class="btn btn-md btn-danger btnRemoveUserResponsibility"><i class="fa fa-trash"></i></button></td></tr>');
    i++;  
}

function Alert() {
    Swal.fire({
      type: 'success',
      title: 'Data has been deleted!',
      showConfirmButton: false,
      timer: 1500
  })
}

function insertOrderSharpening(){
    var noOrder = [];
    var reffNumber = [];
    var subinv = [];
    var locator = [];
    var kodeBarang = [];
    var deskBarang = [];
    var quantity = [];
    var date = $('input[name~=dateOrder]').val();

    $('#tbodyUserResponsibility input[name~=noOrder]').each(function(){
        noOrder.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=reffNumber]').each(function(){
        reffNumber.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=subinv]').each(function(){
        subinv.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=locator]').each(function(){
        locator.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=kodeBarang]').each(function(){
        kodeBarang.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=deskBarang]').each(function(){
        deskBarang.push($(this).val());
    });
    $('#tbodyUserResponsibility input[name~=quantity]').each(function(){
        quantity.push($(this).val());
    });

    $.ajax({
        url: baseurl + "OrderSharpening/Order/Insert",
        async: true,
        type: 'POST',
        dataType: 'JSON',
        data: {
            'noOrder': noOrder,
            'reffNumber': reffNumber,
            'subinv'    : subinv,
            'locator'   : locator,
            'kodeBarang': kodeBarang,
            'deskBarang': deskBarang,
            'quantity': quantity,
            'date': date
        },
        success: function(response) {
            alert('success');
        },
        error: function(response) {
            alert('error');
            console.log(response.status);
        }
    });
}
