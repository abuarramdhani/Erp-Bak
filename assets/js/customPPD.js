//perizinan pribadi
$(document).ready(function(){
	$('.tabel_psp_all').DataTable({
		fixedColumns:   {
            leftColumns: 4
        },
        scrollX: true
	});

	$('.ppd_id_iz').click(function(){
		var val = $(this).val();
		
		$('#ppd_prmdk_mdl').find('textarea').val('');
		$('#ppd_mdl_id').val(val);
		$('#ppd_prmdk_mdl').modal('show');
	});

	$('.ppd_btn_rej').click(function(){
		var val = $(this).val();
		
		$('#ppd_prmdk_mdl_rej').find('textarea').val('');
		$('#ppd_mdl_id_rej').val(val);
		$('#ppd_prmdk_mdl_rej').modal('show');
	});

	// $('.ppd_btn_rej').click(function(){
	// 	var val = $(this).val();
	// 	var r = confirm('Apa anda yakin ingin me-Reject Data ini?');
	// 	if (r == true) {
	// 		$('#surat-loading').attr('hidden', false);
	// 		$.ajax({
	// 			url: baseurl + 'PerizinanPribadi/PSP/ApproveParamedik/reject',
	// 			type: "post",
	// 			data: {id: val},
	// 			success: function (response) {
	// 				window.location.reload();
	// 			},
	// 			error: function(jqXHR, textStatus, errorThrown) {
	// 				console.log(textStatus, errorThrown);
	// 			}
	// 		});
	// 	}
	// })
});