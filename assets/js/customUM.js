$(document).ready(function(){
	// $('#um-fileinput').attr('disabled', 'true');

	$('#um-fileinput').on( "change", function( event ) {  
		var tes = $('#um-fileinput').val();
		// alert(tes);
		// $('#erp-um-input').val(tes.replace("C:\\fakepath\\", ""));
		// replace("C:\\fakepath\\", "")
	});

	$('.erp-um').select2({
		allowClear: false,
		searching: true,
		placeholder: "Pilih Responsibility",
		ajax: 
		{
			url: baseurl+'usermanual/upload/mylist',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					term: params.term,
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.module_id+" - "+obj.user_group_menu_name, text: obj.module_id+" - "+obj.user_group_menu_name};
					})
				};
			}
		}
	});

	$('#um-table').DataTable( {
		"scrollX": true,
	});

	$('.um_copyclip').click(function(){
		let vall = $(this).val();
		copyToClipboard(vall);
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			onOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		})

		Toast.fire({
			icon: 'success',
			title: 'Coppied !!'
		})
	});
});

function copyToClipboard(vallue) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(vallue).select();
    document.execCommand("copy");
    $temp.remove();
}

$(document).on('change', '#erp-um', function(){
	// alert('a');
	// $('#um-fileinput').attr('disabled', false);
	var res = $('#erp-um').val();
	res =  res.split(" - ");
	res = res[1];
	var d = new Date();
	var day = d.getDate();
	var month = d.getMonth()+1;
	var year = d.getFullYear();
	// alert();
	$('#erp-um-input').val(res.replace(/ /g,"_")+'_'+day+'-'+month+'-'+year);
		
});

$(document).on('change', '#erp-um-modal', function(){
	// alert('a');
	// $('#um-fileinput').attr('disabled', false);
	var res = $('#erp-um-modal').val();
	res =  res.split(" - ");
	res = res[1];
	var d = new Date();
	var day = d.getDate();
	var month = d.getMonth()+1;
	var year = d.getFullYear();
	// alert();
	$('#erp-um-input-modal').val(res.replace(/ /g,"_")+'_'+day+'-'+month+'-'+year);
		
});