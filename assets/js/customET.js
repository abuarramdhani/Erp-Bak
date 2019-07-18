$(document).ready(function(){
	var tableJp = $('.et_jenis_penilaian').DataTable();

	// var tabela = $('.tbl_et_rekap').DataTable({
	// 	"scrollX": true,
	// 	fixedColumns: true
	// 	// responsive: true
	// });
	// tabela.columns.adjust().draw();

	$('.et_select_jp').select2({
		ajax:
		{
			url: baseurl+'EvaluasiTIMS/Setup/getPenilaian',
			dataType: 'json',
			type: 'get',
			data: function (params) {
				return {s: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.id_jenis,
							text: item.jenis_penilaian,
						}
					})
				};
			},
			cache: true
		},
		placeholder: 'Pilih penilaian',
	});

	$('.et_select_jp').change(function(){
		var s = $(this).val();
		$.ajax({
			type: 'POST',
			url: baseurl+'EvaluasiTIMS/Setup/getPenilaian2',
			data: {s:s},
			success: function(response){
				response = JSON.parse(response);
				// alert(response[0].created_by);
				$('#et_input_t').val(response[0].std_m)
				$('#et_input_tim').val(response[0].std_tim)
				$('#et_input_tims').val(response[0].std_tims)
			}
		});

		$('.bt_et_harian').attr('disabled', false);
	})

	$('input[name*=et_rd_le]').on('ifChecked', function(){
		$('.btn_et_el').prop('disabled', false);
	});
	$('.btn_et_el').click(function(){
		$('#surat-loading').attr('hidden', false);
	});

	$('.bt_et_harian').click(function(){
		$('#surat-loading').attr('hidden', false);
	});

	$('#evt_isi').redactor();
	$('#evt_alasan').redactor();
	var editor = $('#evt_result').redactor();

	$('#evt_preview').click(function(){
		var no_surat = $('#evt_no_surat').val();
		var departemen = $('#evt_departemen').val();
		var lampiran = $('#evt_lampiran').val();
		var pdev = $('#evt_pdev').val();
		var kepada = $('#evt_kepada').val();
		var isi = $('#evt_isi').val();
		var alasan = $('#evt_alasan').val();
		$('#surat-loading').attr('hidden', false);

		$.ajax({
			type: 'POST',
			data: $('#evt_form_memo').serialize(),
			url: baseurl+"EvaluasiTIMS/Setup/previewMemo",
			success:function(result)
			{
				var result = JSON.parse(result);
				console.log(result);

				$('#evt_result').redactor('set', result['preview']);
				$('#surat-loading').attr('hidden', true);
			},
			error: function(jqXHR, exception) {
				if (jqXHR.status === 0) {
					alert('Not connect.\n Verify Network.');
				} else if (jqXHR.status == 404) {
					alert('Requested page not found. [404]');
				} else if (jqXHR.status == 500) {
					alert('Internal Server Error [500].');
				} else if (exception === 'parsererror') {
					alert('Requested JSON parse failed.');
				} else if (exception === 'timeout') {
					alert('Time out error.');
				} else if (exception === 'abort') {
					alert('Ajax request aborted.');
				} else {
					alert('Uncaught Error.\n' + jqXHR.responseText);
				}
				Swal.fire({
					title: 'Error!',
					allowOutsideClick: false,
					text: "Pastikan Semua Kolom Terisi Sebelum Klik Preview!",
					type: 'warning',
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'OK'
				}).then((result) => {
					if (result.value) {
						$('#surat-loading').attr('hidden', true);
					}
				});
			}
		});
	});

	$('#evt_departemen').select2({
		ajax:
		{
			url: baseurl+'EvaluasiTIMS/Setup/getKadept',
			dataType: 'json',
			type: 'get',
			data: function (params) {
				return {s: params.term, id:$('#evt_pilih').val()};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.pilih,
							text: item.pilih,
						}
					})
				};
			},
			cache: true
		},
		placeholder: 'Pilih Salah Satu',
	});

	$('#evt_pilih').select2();

	$('#evt_pilih').change(function(){
		var id = $(this).val();
		var teks = $('option#'+id).text();
		if (id == '0') {
			$('#evt_departemen').attr('disabled', true);
			$('#evt_lbl_pilih').text('Pilihan :');
		}else{
			$('#evt_departemen').attr('disabled', false);
			$('#evt_lbl_pilih').text(teks+' :');
		}
	});

	$('#evt_departemen').change(function(){
		var text = $(this).val();
		$.ajax({
			type: 'POST',
			url: baseurl+'EvaluasiTIMS/Setup/getNamaKadept',
			data: {id:$('#evt_pilih').val(), text:text},
			success: function(response){
				response = JSON.parse(response);
				// alert(response);
				$('#evt_kepada').val(response[0].nama);
			}
		});
	});

	$('#evt_pdev').select2({
		ajax:
		{
			url: baseurl+'EvaluasiTIMS/Setup/getPdev',
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
							text: item.noind+' - '+item.nama,
						}
					})
				};
			},
			cache: true
		},
		placeholder: 'Pilih Orangnya',
	});

	$('.evt_btn_reset').click(function(){
		$('#evt_form_memo').trigger("reset");
	});

	$('.evt_btn_view').click(function(e){
		e.preventDefault();
		var data = $('#evt_result').val();
		var no = $('#evt_no_surat').val();
		$('#evt_inp_hidden').attr('value', data);
		$('#evt_hidden_no_surat').attr('value', no);
		$('.evt_btn_hidden').click();
	});

	$('#evt_lampiran_angka').select2();
	$('#evt_lampiran_angka').change(function(){
		var angka = $(this).val();
		var satuan = ['nol','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh'];
		$('#evt_lampiran_satuan').val(satuan[angka]);
	});
});