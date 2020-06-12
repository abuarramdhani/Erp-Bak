//patroli satpam
$(document).ready(function(){
	$('.pts_del_ask').click(function(){
		var txt = $(this).closest('tr').find('.pts_ask').text();
		var id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Hapus pertanyaan \n"'+txt+'"?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				window.location.replace(baseurl+'PatroliSatpam/web/delask?id='+id);
			}
		});
	});

	$('.pts_edit_ask').click(function(){
		var id = $(this).val();
		var txt = $(this).closest('tr').find('.pts_ask').text();
		$('#pts_mdl_upask').find('input').eq(0).val(txt);
		$('#pts_mdl_upask').find('button#id').eq(0).val(id);
		$('#pts_mdl_upask').modal('show');
	});

	$('.pts_slcask').select2({
		placeholder: "Pilih Pertanyaan"
	});

	$('.pts_tblask').dataTable({});

	$('.pts_tblask').on('click','.pts_btn_edlokasi', function(){
		var lokasi = $(this).closest('tr').find('td').eq(2).text();
		var lat = $(this).closest('tr').find('td').eq(3).text();
		var long = $(this).closest('tr').find('td').eq(4).text();
		var id = $(this).val();
		var ask = $(this).closest('tr').find('input').val().split(',')

		$('#pts_mdl_editlokasi').find('input').eq(0).val(lokasi);
		$('#pts_mdl_editlokasi').find('input').eq(1).val(lat);
		$('#pts_mdl_editlokasi').find('input').eq(2).val(long.trim());
		$('#pts_mdl_editlokasi').find('#pts_lokid').val(id);
		$('#pts_mdl_editlokasi').find('select').val(ask).trigger('change');

		$.ajax({
			url: baseurl + 'PatroliSatpam/web/get_map_id',
			type: "post",
			data: {id: id},
			success: function (response) {
				$('#pts_mdl_editlokasi').find('#pts_gMap_modal').html(response);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	});

	$('.pts_tblask').on('click','.pts_btn_todelok', function(){
		var id = $(this).val();
		var txt = $(this).closest('tr').find('td').eq(1).text();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Hapus Lokasi \n"'+txt+'"?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				window.location.replace(baseurl+'PatroliSatpam/web/dellokasi?id='+id);
			}
		});
	});

	$('.pts_daterange').daterangepicker({
		"singleDatePicker": false,
		"timePicker": false,
		"timePicker24Hour": false,
		"showDropdowns": true,
		locale: {
			format: 'YYYY-MM-DD'
		},
	});

	getPekerjaTpribadi('.pts_getPekerja');
	var tbl_rkp = $('.pts_tbl_rkp').DataTable({
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',
			title: '',
			filename: 'Patroli Satpam Rekap Harian ',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
			}
		},
		{
			extend: 'pdfHtml5',
			filename: 'Patroli Satpam Rekap Harian ',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
			}
		}
		]
	});
	$('#pts_btn_rdata').click(function(){
		var pr = $('.pts_daterange').val();
		var pkj = $('.pts_getPekerja').val();
		tbl_rkp.clear().draw();

		$.ajax({
			url: baseurl + 'PatroliSatpam/web/get_rekap_data',
			type: "post",
			data: {pr: pr, pkj: pkj},
			success: function (response) {
				var send = $.parseJSON(response);
				tbl_rkp.rows.add(send);

				tbl_rkp.draw();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	});

	$(".pts_monthrange").monthpicker({
		changeYear:true,
		dateFormat: 'mm - yy', });

	$('.pts_kesimpulan').redactor();

	$('#pts_addKs').click(function(){
		var pr = $('.pts_monthrange').val();
		var isi = $('.pts_kesimpulan').val();
		if (pr.length < 1){
			alert('Mohon pilih periode terlebih dahulu!');
		}else if(isi.length < 10){
			alert('Isi Kesimpulan minimal 10 karakter!');
		}else{
			$.ajax({
			url: baseurl + 'PatroliSatpam/web/add_kesimpulan',
			type: "post",
			data: {pr: pr, isi: isi},
			success: function (response) {
				$('.pts_loadKs').trigger('change');
				$('.pts_kesimpulan').redactor('set', ''); 
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
		}
	});

	var tblKs = $('.pts_tblKS').DataTable();
	$('.pts_loadKs').change(function(){
		var pr = $(this).val();
		$.ajax({
			url: baseurl + 'PatroliSatpam/web/get_kesimpulan',
			type: "get",
			data: {pr: pr},
			success: function (response) {
				tblKs.clear().draw();
				var send = $.parseJSON(response);
				tblKs.rows.add(send);

				tblKs.draw();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
		if ( $(this).is('[readonly]') ) {
			//biarkan
		}else{
			$.ajax({
				url: baseurl + 'PatroliSatpam/web/cek_cetak_laporan',
				type: "get",
				data: {pr: pr},
				success: function (response) {
					let data = JSON.parse(response);
					console.log(data.ada);
					if (data.ada) {
						$('#pts_alertCek').html('<label style="color:red">*Sudah Ada Rekapan pada Periode Tersebut. Harap di cek kembali</label>');
					}else{
						$('#pts_alertCek').html('');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		}
	});

	$('.pts_tblKS').on('click', '.pts_btnDelKs', function(){
		var id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Hapus Kesimpulan ini?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				$.ajax({
					url: baseurl + 'PatroliSatpam/web/del_kesimpulan',
					type: "post",
					data: {id: id},
					success: function (response) {
						$('.pts_loadKs').trigger('change');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(textStatus, errorThrown);
					}
				});
			}
		});
	});

	$('.pts_tblask').on('click', '.pts_delrkpData', function(){
		var id = $(this).val();
		Swal.fire({
			showCancelButton: true,
			title: 'Apa anda yakin?',
			text: 'Hapus file Laporan ini?',
			type: 'warning',
			focusCancel: true
		}).then(function(result) {
			if (result.value) {
				$.ajax({
					url: baseurl + 'PatroliSatpam/web/del_rekap_file',
					type: "post",
					data: {id: id},
					success: function (response) {
						location.reload();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(textStatus, errorThrown);
					}
				});
			}
		});
	});



	// $('.pts_tglrkp').datepicker({
 //        autoclose : true,
 //        format    : 'yyyy-mm-dd'
 //    });
	$('.pts_tglrkp').daterangepicker({
		"showDropdowns": false,
		"autoApply": false,
		"maxSpan": {
			"days": 15
		},
		"locale": {
			"format": "YYYY-MM-DD"
		}
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});
});


function getPekerjaTpribadi(selector)
{
	$(selector).select2({
		ajax:
		{
			url: baseurl+'PatroliSatpam/web/getAllPkjTpribadi',
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

function getTanggal()
{
	return new Date().toISOString().split('T')[0];
}

$(document).on('click', '.pts_copylatlong', function(){
	let vall = $(this).text();
	vall = vall.replace('(', '');
	vall = vall.replace(')', '');
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
		title: 'Location Coppied !!'
	})
});