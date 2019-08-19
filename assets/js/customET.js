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
	});

	$('.bt_et_harian').click(function(){
		$('#surat-loading').attr('hidden', false);
	});

	$('input[name*=et_rd_le]').on('ifChecked', function(){
		$('.btn_et_el').prop('disabled', false);
	});
	$('.btn_et_el').click(function(){
		$('#surat-loading').attr('hidden', false);
	});

	$('#formTimsBulanan').submit(function(){
		$('#surat-loading').attr('hidden', false);
	});

	$('#evt_isi').redactor();
	$('#evt_alasan').redactor();
	$('.tx_et_bulanan').redactor();
	var editor = $('#evt_result').redactor();

	$('#evt_preview').click(function(){
		// var no_surat = $('#evt_no_surat').val();
		// if ($('#evt_departemen').val() != null && typeof $('#evt_departemen').val()[0] != 'undefined') {
		// 	var departemen = $('#evt_departemen').val()[0].split(' | ');
		// 	departemen = departemen[0];
		// }else{
		// 	var departemen = '';
		// }
		// var lampiran = $('#evt_lampiran').val();
		// var pdev = $('#evt_pdev').val();
		// var kepada = $('#evt_kepada').val();
		// var isi = $('#evt_isi').val();
		// var alasan = $('#evt_alasan').val();
		$('#surat-loading').attr('hidden', false);

		$.ajax({
			type: 'POST',
			data: $('#evt_form_memo').serialize(),
			url: baseurl+"EvaluasiTIMS/Setup/previewMemo",
			success:function(result)
			{
				if (result.length < 100) {
					$('#surat-loading').attr('hidden', true);
					alert(result);
				}else{
					var result = JSON.parse(result);
					console.log(result);

					$('#evt_result').redactor('set', result['preview']);
					$('#surat-loading').attr('hidden', true);
				}
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
							id: item.pilih+' | '+item.kodesie,
							text: item.pilih,
						}
					})
				};
			},
			cache: true
		},
		placeholder: 'Pilih Salah Satu',
	});
	$('#evt_departemen').on("select2:select", function (evt) {
	  var element = evt.params.data.element;
	  var $element = $(element);
	  
	  $element.detach();
	  $(this).append($element);
	  $(this).trigger("change");
	});

	$('#evt_departemen2').select2({
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
	$('#evt_kepada').select2();

	$('#evt_pilih').change(function(){
		var id = $(this).val();
		var teks = $('option#'+id).text();
		$('#evt_departemen2').each(function () { //added a each loop here
			$(this).val(null).trigger("change");
		});
		$('#evt_departemen').each(function () { //added a each loop here
			$(this).val('').trigger("change"); // ganti ke change untuk multiple
		});
		if (id == '0') {
			$('#evt_departemen').attr('disabled', true);
			$('#evt_departemen2').attr('disabled', true);
			$('#evt_lbl_pilih').text('Pilihan :');
		}else{
			$('#evt_departemen').attr('disabled', false);
			$('#evt_departemen2').attr('disabled', false);
			$('#evt_lbl_pilih').text(teks+' :');
		}
	});

	$('#evt_departemen').change(function(){
		$('#surat-loading').attr('hidden', false);
		$('#evt_kepada').each(function () { //added a each loop here
			$(this).val(null).trigger("change");
		});
		var str = $(this).val();
		// if (str) {
		// 	str = str.split(' | ');
		// }else{
		// 	str = ['',''];
		// }
		// alert(str);
		if (str != null && typeof str[0] != 'undefined') {
			str = str[0].split(' | ');
		}else{
			str = ['',''];
		}
			text = str[0];
		$.ajax({
			type: 'POST',
			url: baseurl+'EvaluasiTIMS/Setup/getNamaKadept',
			data: {id:$('#evt_pilih').val(), text:text, ks:str[1]},
			success: function(response){
				response = JSON.parse(response);
				$('#evt_kepada').html(response);
				$('#surat-loading').attr('hidden', true);
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
		if (angka == '-') {
			angka = 0;
		}
		var satuan = ['-','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh'];
		$('#evt_lampiran_satuan').val(satuan[angka]);
	});

	$(".evt_test").click(function(){
		var data = $('#evt_result').val();
		var no = $('#evt_no_surat').val();
		$.ajax({
			type: 'POST',
			url: baseurl+'EvaluasiTIMS/Bulanan/testPreview',
			data: {id:no, text:data},
			success: function(response){
				var data2 = response.join('');
    			var base64 = window.btoa(data2);
				var data = 'data:application/pdf;charset=UTF-8,' + window.atob(base64);
				alert(data);
			}
		});
	});

	$('.btn_edit_kdu').click(function(){
		$('#et_edit_kdu').attr('disabled', false);
		$('.btn_simpan_kdu').attr('disabled', false);
		$('.btn_edit_kdu').remove();
	});

});
	function evt_ayoJalan(noind, nilaian){
		// alert(noind);
		// alert(nilaian);
		$('#surat-loading').attr('hidden', false);
		// var noind = $(this).attr('data-noind');
		// var nilaian = $(this).attr('data-penilaian');
		$.ajax({
			url: baseurl+"EvaluasiTIMS/Bulanan/detail_perpanjangan",
			method: "POST",
			data: {noind:noind, nilai:nilaian},
			success: function(data){
				$('#surat-loading').attr('hidden', true);
				$('#phone_result').html(data);
				$('#evt_perpanjangan').modal('show');
			}
		});
	};