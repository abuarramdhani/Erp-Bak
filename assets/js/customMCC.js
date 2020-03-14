$(document).ready(function(){
	$('.MCC_slc2').select2({
		placeholder: 'Pilih Salah Satu',
		allowClear: true
	});

	$('#mccsl').on('click', function(){
		var sk = $('select[name ="mcc_seksi"]').val();
		var cc = $('select[name ="mcc_cc"]').val();
		var br = $('select[name ="mcc_branch"]').val();
		var ak = $('select[name ="mcc_akun"]').val();

		if (sk.length < 1 || cc.length < 1 || br.length < 1 || ak.length < 1) {
			alert('Data Belum Lengkap !! \nMohon isi semua Data');
		}else{
			$('#mccsl').attr('disabled', true);
			saveAjax(sk, cc, br);
		}
	});

	$('.MCC_slc2').change(function(){
		$('#mccsaveed').attr('disabled', false);
	});

	$('#mccbtled').click(function(){
		$('.mccbtnhid').hide();
		$('#mccsl').show();
		$('.MCC_slc2').each(function() {
			$(this).val("").trigger('change');
		});
	});

	$('#mcctbl').on('click', '.mccuprow', function(){
		var val = $(this).val();
		var ini = $(this);

		var seksi = $(this).val();
		var cost = $(this).closest('tr').find('td.cost').text().replace('-', '|');
		var branch = $(this).closest('tr').find('td.branch').text().split(' - ')[0];
		var akun = $(this).closest('tr').find('td.akun').find('input').val();
		
		$('.MCC_slc2').eq(0).val(seksi).trigger('change');
		$('.MCC_slc2').eq(1).val(cost).trigger('change');
		$('.MCC_slc2').eq(2).val(branch).trigger('change');
		$('.MCC_slc2').eq(3).val(akun).trigger('change');
		$('#mccsaveed').val(val);
		$('#mccsaveed').attr('disabled', true);

		$('#mcc_modal_edit').modal('show');
	});

	$('#mccsaveed').on('click', function(){
		$('#mccsaveed').attr('disabled', true);
		var sk = $('select[name ="mcc_seksi"]').val();
		var cc = $('select[name ="mcc_cc"]').val();
		var br = $('select[name ="mcc_branch"]').val();
		var ak = $('select[name ="mcc_akun"]').val();
		var id = $(this).val();
		if (sk.length < 1 || cc.length < 1 || br.length < 1 || ak.length < 1 || id.length < 1) {
			alert('Data Belum Lengkap !! \nMohon isi semua Data');
			return false;
		}

		$.ajax({
			url: baseurl + 'MasterCC/ListCC/updateCC',
			type: "post",
			dataType: 'json',
			data: {seksi: sk, cost: cc, branch: br, id: id, akun: ak},
			success: function (response) {
				if (response['hasil'] == 1) {
					alert(response['pesan']);
				}else{
					mcc_showAlert('success', 'Berhasil di Perbarui !');
					$('#mcc_modal_edit').modal('hide');
					mcc_showTbl();
					$('.MCC_slc2').each(function() {
						$(this).val("").trigger('change');
					});
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
				$('#mccsaveed').attr('disabled', false);
				$('#mccsl').attr('disabled', false);
				alert('Error !!\nGagal Menambahkan Data');
			}
		});
	});
});

function saveAjax(sk, cc, br)
{
	$.ajax({
		url: baseurl + 'MasterCC/ListCC/saveCC',
		type: "post",
		dataType: 'json',
		data: {seksi: sk, cost: cc, branch: br},
		success: function (response) {
			console.log(response['hasil']);
			if (response['hasil'] == 1) {
				alert(response['pesan']);
			}else{
				mcc_showAlert('success', 'Berhasil di Tambahkan ^_^');
				$('.MCC_slc2').each(function() {
					$(this).val("").trigger('change');
				});
				mcc_showTbl();
			}
			$('#mccsl').attr('disabled', false);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
			$('#mccsl').attr('disabled', false);
			alert('Error !!\nGagal Menambahkan Data');
		}
	});
}

function mcc_showTbl()
{
	$.ajax({
		url: baseurl + 'MasterCC/ListCC/getTableData',
		type: "get",
		success: function (response) {
			$('#mcctbl').removeClass('text-center');
			$('#mcctbl').html(response);
			mcc_init_tbl();
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
}

function mcc_init_tbl()
{
	var mcc_tabel = $('#mcc_tbl_list').DataTable({
		scrollX: true,
		dom: 'Bfrtip',
        buttons: [
            {
            	extend: 'print',
            	exportOptions: {
            		columns: [ 0, 1, 2, 3, 4, 5, 6 ]
            	}
            },
            {
            	extend: 'excelHtml5',
            	title: '',
            	exportOptions: {
            		columns: [ 0, 1, 2, 3, 4, 5, 6 ]
            	}
            }
        ]
	});

	$('.mccdelrow').off('click');
	$('#mcctbl').on('click', '.mccdelrow',function(){
		var val = $(this).val();
		var ini = $(this);
		if (confirm("Apa anda yakin ingin menghapus Data ini ?") == true) {
			$.ajax({
				url: baseurl + 'MasterCC/ListCC/delCC',
				type: "get",
				data: {id: val},
				success: function (response) {
					mcc_showAlert('success', 'Data Berhasil di Hapus !');
					mcc_tabel.row( $(ini).parents('tr') ).remove().draw();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		}
	});

	$('.mccCeksk').off('click');
	$('.mccCeksk').click(function(){
		$('#surat-loading').attr('hidden', false);
		$.ajax({
			url: baseurl + 'MasterCC/ListCC/cekSeksi',
			type: "get",
			success: function (response) {
				$('#mcc_modal_cekseksi').find('div.modal-body').html(response);
				$('#mcc_tbl_seksi').DataTable();
				$('#mcc_modal_cekseksi').modal('show');
				$('#surat-loading').attr('hidden', true);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(textStatus, errorThrown);
			}
		});
	});
}

function mcc_showAlert(icon, title)
{
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 5000,
		timerProgressBar: true,
		onOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	Toast.fire({
		icon: icon,
		title: title
	})
}
