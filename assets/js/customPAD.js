$(document).ready(function(){
	var table_pad = $('.pad_tblpkj').DataTable();
	getAllPekerjaTpribadi('#pad_mdl_getpkj');

	$('.pad_slcInit').select2();

	$('#pad_btnAddRow').click(function(){
		PadcloneRow();
	});

	$('#pad_tbl_AddData').on('click', '.pad_btnDelRow',function(){
		if ($('.pad_rowAPD').length > 1) {
			$(this).closest('tr').remove();
			reIndexNomor();
		}
	});
	// $('#pad_tbl_Dtbl').DataTable();

	$('.pad_tblpkj').on('click', '.pad_btnDelAPD', function(){
		var id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Hapus Data yang di pilih?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				window.location.replace(baseurl+'pengembalian-apd/pekerja/del_data?id='+id);
			}
		});
	});

	$('#pad_slcStat').change(function(){
		let id = $(this).val();
		$('#surat-loading').show();
		window.location.replace(baseurl+'pengembalian-apd/hubker/view_data?stat='+id);
	});

	$('#pad_ApproveApd').click(function(){
		let id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Anda yakin ingin Approve data ini?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				$('#surat-loading').show();
				window.location.replace(baseurl+'pengembalian-apd/hubker/terima_apd?status=1&id='+id);
			}
		});
	});
	$('#pad_RejectApd').click(function(){
		let id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Anda yakin ingin Reject data ini?',
			type: 'error',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				$('#surat-loading').show();
				window.location.replace(baseurl+'pengembalian-apd/hubker/terima_apd?status=2&id='+id);
			}
		});
	});

	$('#pad_btnSavewoID').click(function(){
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Anda yakin ingin Input data tanpa APD?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				var noind = $('#pad_mdl_getpkj').val();
				if (noind == null || noind.length < 4)
					alert("Pekerja tidak boleh Kosong");
				else
					pad_inputData(noind);
			}
		});
	});
});

function pad_inputData(noind){
	$.ajax({
		method: "POST",
		data: {
			pekerja: noind
		},
		url: baseurl + "pengembalian-apd/pekerja/save_data2",
		success: a => {
			window.location.replace(baseurl+'pengembalian-apd/pekerja');
		}
	})
}

function getAllPekerjaTpribadi(selector)
{
	$(selector).select2({
		ajax:
		{
			url: baseurl+'pengembalian-apd/pekerja/getSemuaPkjTpribadi',
			dataType: 'json',
			type: 'get',
			data: function (params) {
				return {s: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind.trim()+' - '+item.nama.trim(),
						}
					})
				};
			},
			cache: true
		},
		delay: 1000,
		minimumInputLength: 3,
		placeholder: 'Pilih Pekerja',
	});
}

function PadcloneRow()
{
	$('.pad_rowAPD').find('select').select2('destroy');
	var c = $('.pad_rowAPD').last().clone();
	$('#pad_rowToAppend').append(c);
	reIndexNomor();
	$('.pad_rowAPD').find('select').select2();
	$('.pad_rowAPD').last().find('td').eq(1).find('select').val('APRON DADA').trigger('change');
	$('.pad_rowAPD').last().find('td').eq(3).find('input').val(0);
	$('.pad_rowAPD').last().find('td').eq(4).find('select').val(0).trigger('change');
	$('.pad_rowAPD').last().find('td').eq(5).find('select').val(0).trigger('change');
}

function reIndexNomor()
{
	var x = 1;
	$('.pad_rowNum').each(function(){
		$(this).text(x);
		x++;
	});
}