/*
catatan
mau mengubah satuan meter or pcs ada di js
*/

function getTableMasterOs(tabelnya)
{
	$('#surat-loading').attr('hidden', false);
	$.ajax({
		url: baseurl + 'SeragamOnline/MasterData/getTableTipe',
		data: {tabel: tabelnya},
		type: "post",
		success: function (response) {
			$('#surat-loading').attr('hidden', true);
			$('#os_getTableBaju').html(response);
			os_init_table(tabelnya)
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$('#surat-loading').attr('hidden', true);
			console.log(textStatus, errorThrown);
		}
	});
}

function os_init_table(tabelnya = false)
{
	$('table').DataTable();
	
	$('#os_addTB').click(function(){
		if (tabelnya == 'ttipe_baju') {
			swalDual(tabelnya);
		}else{
			Swal.fire({
				title: 'Input '+os_info,
				input: 'text',
				showCancelButton: true,
				inputPlaceholder: 'Masukan '+os_info
			}).then(function(result) {
				if (result.value) {
					$('#surat-loading').attr('hidden', false);
					$.ajax({
						type: 'POST',
						url: baseurl+'SeragamOnline/MasterData/addTableTipe',
						dataType: 'json',
						data: {data:result.value, tabel: tabelnya},
						success: function(response){
							getTableMasterOs(tabelnya);
							alert(response.text);
							$('#surat-loading').attr('hidden', true);
						}
					});
				}
			});
		}
	});

	$('.os_edTB').click(function(){
		var txt = $(this).attr('textnya');
		var id = $(this).attr('idnya');
		if (tabelnya == 'ttipe_baju') {
			swalDual_ed(tabelnya,$(this));
		}else{
			Swal.fire({
				title: 'Edit '+os_info,
				input: 'text',
				showCancelButton: true,
				inputValue: txt,
				inputPlaceholder: 'Masukan '+os_info
			}).then(function(result) {
				if (result.value && result.value != txt) {
					$('#surat-loading').attr('hidden', false);
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: baseurl+'SeragamOnline/MasterData/edTableTipe',
						data: {data:result.value, id:id, tabel: tabelnya},
						success: function(response){
							getTableMasterOs(tabelnya);
							alert(response.text);
							$('#surat-loading').attr('hidden', true);
						}
					});
				}
			});
		}
	});

	$('.os_delTB').click(function(){
		var txt = $(this).attr('textnya');
		var id = $(this).attr('idnya');
		Swal.fire({
			title: 'Anda Yakin ?',
			text: 'Apa anda yakin ingin menghapus '+os_info+' "'+txt+'"',
			showCancelButton: true,
		}).then(function(result) {
			if (result.value && result.value != txt) {
				$('#surat-loading').attr('hidden', false);
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: baseurl+'SeragamOnline/MasterData/delTableTipe',
					data: {id:id, tabel: tabelnya},
					success: function(response){
						alert(response.text);
						if (tabelnya == 'tjenis_baju') {
							location.reload();
						}else{
							getTableMasterOs(tabelnya);
							$('#surat-loading').attr('hidden', true);
						}
					}
				});
			}
		});
	});
}

$(document).ready(function(){
	$('.os_dtable').DataTable();
	$('.os_edTB_modal').click(function(){
		$('#edit_jnsbj').val($(this).attr('textnya'));
		$('#edit_jnsbj_tipe').val($(this).attr('tipenya')).trigger('change');
		$('#for_id_jns').val($(this).attr('idnya'));
		$('#for_id_jns').attr('disabled', true);
		$('#mdl_edit_jnsBaju').modal('show');
	});

	$('.deaktif_disabled').change(function(){
		$('#for_id_jns').attr('disabled', false);
	});

	$('.so_datepicker').daterangepicker({
		"singleDatePicker": true,
		"locale": {
        "format": "YYYY-MM-DD"
    	}
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});

	$('.osbjmsktpbj').change(function(){
		var ini = $(this).val();
		$('#os_label_jns').text('Jumlah ('+arraySatuan[ini-1]+')');
		if (ini == '1') {
			$('.os_slc_dis').val(null).trigger('change').attr('disabled', true);
		}else if(ini == '2') {
			$('.os_slc_dis').attr('disabled', false);
		}else{
			$('.os_slc_dis').attr('disabled', false)
		}
	});

	$('.os_slc_jnsBaju').select2({
        allowClear: false,
        minimumResultsForSearch: -1,
        ajax: {
            url: baseurl + 'SeragamOnline/Transaksi/getJenisbyTipe',
            dataType: 'json',
            delay: 500,
            type: "GET",
            data: function(params) {
                return {
                    term: params.term,
                    tipe: $(this).closest('div').find('.osbjmsktpbj').val()
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.id, text: obj.jenis};
                    })
                };
            }
        }
    });

	$('.os_edit_bjmsk').click(function(){
		var val = $(this).val();
		var tgl = $(this).closest('tr').find('td').eq(1).attr('id');
		var tipe = $(this).closest('tr').find('td').eq(2).attr('id');
		var jenis = $(this).closest('tr').find('td').eq(3).attr('id');
		var jenis_text = $(this).closest('tr').find('td').eq(3).text();
		var ukuran = $(this).closest('tr').find('td').eq(4).attr('id');
		var jumlah = $(this).closest('tr').find('td').eq(5).text();

		$('.soEditbjmskModal').eq(0).val(tgl);
		$('.soEditbjmskModal').eq(4).val(jumlah);
		$('.soEditbjmskModal').eq(1).val(tipe).trigger('change');
		$('.soEditbjmskModal').eq(3).val(ukuran).trigger('change');
		$('.soEditbjmskModal').eq(2).html('<option value="'+jenis+'" selected >'+jenis_text+'</option>').trigger('change');

		$('#modal_edit_baju').find('button#sosubmited').val(val).attr('disabled', true);
		$('#modal_edit_baju').modal('show');
	});
	$('.soEditbjmskModal').change(function(){
		$('#modal_edit_baju').find('button#sosubmited').attr('disabled', false);
	});

	$('.os_edit_clmsk').click(function(){
		var val = $(this).val();
		var tgl = $(this).closest('tr').find('td').eq(1).attr('isi');
		var jenis = $(this).closest('tr').find('td').eq(2).attr('isi');
		var ukuran = $(this).closest('tr').find('td').eq(3).attr('isi');
		var jumlah = $(this).closest('tr').find('td').eq(4).text();

		$('.soEditclmskModal').eq(0).val(tgl);
		$('.soEditclmskModal').eq(1).val(jenis).trigger('change');
		$('.soEditclmskModal').eq(2).val(ukuran).trigger('change');
		$('.soEditclmskModal').eq(3).val(jumlah);

		$('#modal_edit_celana').find('button#sosubmited').val(val).attr('disabled', true);
		$('#modal_edit_celana').modal('show');
	});
	$('.soEditclmskModal').change(function(){
		$('#modal_edit_celana').find('button#sosubmited').attr('disabled', false);
	});

	$('.os_edit_tpmsk').click(function(){
		var val = $(this).val();
		var tgl = $(this).closest('tr').find('td').eq(1).attr('id');
		var jenis = $(this).closest('tr').find('td').eq(2).attr('id');
		var jumlah = $(this).closest('tr').find('td').eq(3).text();

		$('.soEdittpmskModal').eq(0).val(tgl).trigger('change');
		$('.soEdittpmskModal').eq(1).val(jenis).trigger('change');
		$('.soEdittpmskModal').eq(2).val(jumlah);

		$('#modal_edit_topi').find('button#sosubmited').val(val).attr('disabled', true);
		$('#modal_edit_topi').modal('show');
	});

	$('.soEdittpmskModal').change(function(){
		$('#modal_edit_topi').find('button#sosubmited').attr('disabled', false);
	});

});

function swalDual(tabelnya)
{
	Swal.fire({
		title: 'Masukan '+os_info,
		html:
		'<input id="swal-input1" class="swal2-input" placeholder="'+os_info+'">' +
		'<select id="swal-input2" class="swal2-input">'+
			'<option disabled>-- Pilih Satuan --</option><option value="meter">Meter</option><option value="pcs">PCS</option>'+
		'</select>',
		focusConfirm: false,
		preConfirm: () => {
			return [
			document.getElementById('swal-input1').value,
			document.getElementById('swal-input2').value
			]
		}
	}).then(function(result) {
		if (result.value && result.value[0].length > 0 && result.value[1].length > 0) {
			// console.log(result.value);
			$('#surat-loading').attr('hidden', false);
			$.ajax({
				type: 'POST',
				url: baseurl+'SeragamOnline/MasterData/addTableTipe',
				dataType: 'json',
				data: {data:result.value[0], satuan: result.value[1], tabel: tabelnya},
				success: function(response){
					getTableMasterOs(tabelnya);
					alert(response.text);
					$('#surat-loading').attr('hidden', true);
				}
			});
		}
	});
}

function swalDual_ed(tabelnya, ini)
{
	var txt = ini.attr('textnya');
	var id = ini.attr('idnya');
	var satuan = ini.closest('tr').find('.so_satuan').attr('satuan');
	var vallue = '';
	if (satuan == 'meter') {
		vallue = '<option disabled>-- Pilih Satuan --</option><option selected value="meter">Meter</option><option value="pcs">PCS</option>';
	}else{
		vallue = '<option disabled>-- Pilih Satuan --</option><option value="meter">Meter</option><option selected value="pcs">PCS</option>';
	}
	Swal.fire({
		title: 'Masukan '+os_info,
		html:
		'<input id="swal-input1" class="swal2-input" placeholder="'+os_info+'" value="'+txt+'">' +
		'<select id="swal-input2" class="swal2-input">'+
			vallue+
		'</select>',
		focusConfirm: false,
		preConfirm: () => {
			return [
			document.getElementById('swal-input1').value,
			document.getElementById('swal-input2').value
			]
		}
	}).then(function(result) {
		if (result.value && result.value[0].length > 0 && result.value[1].length > 0) {
			console.log(result.value);
			$('#surat-loading').attr('hidden', false);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: baseurl+'SeragamOnline/MasterData/edTableTipe',
				data: {data:result.value[0], satuan:result.value[1], id:id, tabel: tabelnya},
				success: function(response){
					getTableMasterOs(tabelnya);
					alert(response.text);
					$('#surat-loading').attr('hidden', true);
				}
			});
		}
	});
}