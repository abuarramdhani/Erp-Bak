$(document).ready(function(){
	var tblCVDMonitoringCovid = $('#tbl-CVD-MonitoringCovid').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'print', 'pageLength'
        ],
		"scrollX" : true,
		"fixedColumns":   {
            leftColumns: 4
        }
	});

	$('.cvd_tabledatatable').DataTable();

	$('#slc-CVD-MonitoringCovid-Tambah-Pekerja').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'Covid/MonitoringCovid/getPekerja',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama
						};
					})

				};
			},
		}
	})

	$('#slc-CVD-MonitoringCovid-Tambah-Pekerja').on('change', function(){
		var noind = $(this).val();
		$.ajax({
			data: {noind: noind},
			method: 'GET',
			url: baseurl + 'Covid/MonitoringCovid/getDetailPekerja',
			error: function(xhr,status,error){
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				var obj = JSON.parse(data);
				if (obj.status == 'success') {
					$('#txt-CVD-MonitoringCovid-Tambah-Seksi').val(obj.seksi);
					$('#txt-CVD-MonitoringCovid-Tambah-Departemen').val(obj.dept);

				}
			}
		})
	})

	$('#txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#txa-CVD-MonitoringCovid-Tambah-Wawancara').redactor({
        imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

	$('#txt-CVD-MonitoringCovid-Tambah-Keterangan').redactor({
        imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    });

    $(document).on('click', '.cvd_btntriggerdrop',function(){
    	var elm = $(this).next().find('.btn-CVD-MonitoringCovid-Hapus');
    	elm.off('click');
    	elm.click(function(){
    		var params = {
    			id		: $(this).attr('data-href'),
    			status 	: $(this).attr('data-status'),
    		}
    		console.log(params);
    		Swal.fire({
    			title: 'Hapus Data',
    			text: "Apakah Anda Yakin Akan Menghapus Data Ini ?",
    			type: 'question',
    			showCancelButton: true,
    			confirmButtonColor: '#3085d6',
    			cancelButtonColor: '#d33',
    			confirmButtonText: 'Ya',
    			cancelButtonText: 'Tidak'
    		}).then((result) => {
    			if (result.value) {
    				showAjaxGetPRM(params);
    			}
    		});
    	});

    });

	$('.btn-CVD-MonitoringCovid-Tambah-Lampiran').on('click', function(){
		$('.file-CVD-MonitoringCovid-Tambah-Lampiran').last().click();
	})

	$(document).on('change','.file-CVD-MonitoringCovid-Tambah-Lampiran', function(){
		$(this).closest('div').append('<div class="btn-group"><button class="btn btn-success btn-xs" type="button">' + $(this).val().substring(12) + '</button><button class="btn btn-danger btn-xs file-CVD-MonitoringCovid-Hapus-Lampiran"><i class="fa fa-remove"></i></button></div>');
		$(this).clone().val('').appendTo($(this).closest('div'));
	});

	$(document).on('click', '.file-CVD-MonitoringCovid-Hapus-Lampiran', function(){
		$(this).closest('div').next().remove();
		$(this).closest('div').remove();
	});

	$(document).on('click', '.cvd_btntriggerdrop', function(){
		var elm = $(this).next().find('.btn-CVD-MonitoringCovid-FollowUp');
    	elm.off('click');
    	elm.click(function(){
    		var status = $(this).attr('data-status');
    		var link = $(this).attr('data-href');
    		console.log('trigger follow up');
    		if (status.toLowerCase() == "Follow Up Pekerja Masuk".toLowerCase()) {
    			Swal.fire({
    				title: "Apakah Anda sudah Melakukan Follow Up Pekerja?",
    				text: 'Follow Up Pekerja Question 1',
    				type: 'question',
    				showCancelButton: true,
    				confirmButtonColor: '#3085d6',
    				cancelButtonColor: '#d33',
    				confirmButtonText: 'Ya',
    				cancelButtonText: 'Tidak'
    			}).then((result1) => {
    				if (result1.value) {
    					Swal.fire({
    						title: "Apakah Anda akan membuat laporan hasil wawancara pekerja selesai isolasi?",
    						text: 'Follow Up Pekerja Question 2',
    						type: 'question',
    						showCancelButton: true,
    						confirmButtonColor: '#3085d6',
    						cancelButtonColor: '#d33',
    						confirmButtonText: 'Ya',
    						cancelButtonText: 'Tidak'
    					}).then((result2) => {
    						if (result2.value) {
    							window.location.href = link;
    						}
    					});
    				}
    			});
    		}else{
    			console.log('bukan follow up');
    		}
    	});
	});

	$('.cekAbsens').click(function(){
		$.ajax({
			data: {
				pkj: pkj,
				awal_lama: awal,
				awal_baru: $('#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal').val(),
				akhir_lama: akhir,
				akhir_baru: $('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal').val()
			},
			method: 'GET',
			url: baseurl + 'MasterPekerja/Surat/SuratIsolasiMandiri/cekTinput',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				$('#cvd_lbleditpres').text(data);	
			}
		});
	});

	$('.slcMPSuratIsolasiMandiriTo').select2({
		allowClear: true
	});

	$('.cvd_btncektim').click(function(){
		$.ajax({
			data: {
				pkj: $('#slcMPSuratIsolasiMandiriPekerja').val(),
				awal: $('#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal').val(),
				akhir: $('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal').val()
			},
			method: 'GET',
			url: baseurl + 'MasterPekerja/Surat/SuratIsolasiMandiri/cekTimIs',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				$('#cvd_divtim').html(data);	
			}
		});
	});

	var elem = '<div class="cvd_bg_trans" style="text-align: center;">'+
				'<a class="btn btn-default btn-xs" type="button" style="width:100px;">Lihat</a>'+
				'<br><button class="btn btn-default btn-xs" type="button" style="width:100px; margin-top:10px;">Hapus</button>'+
				'</div>';

	// $('.cvd_popoverAttc').popover({animation:true, content:elem, html:true, placement:'top', trigger:'focus'});

	$('.cvd_btndelAttc').click(function(){
		var val = $(this).val();
		var txt = $(this).attr('text');
		Swal.fire({
			type: 'warning',
			title: "Hapus Lampiran Ini?",
			html: txt+'<br>(You won\'t be able to revert this!)',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				cvd_deleteAttachment(val);
			}
		});
	});

	$('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal, #txtMPSuratIsolasiMandiriMulaiIsolasiTanggal').change(function(){
		var mulai = $('#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal').val();
		var selesai = $('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal').val();
		var pkj = $('#slcMPSuratIsolasiMandiriPekerja').val();
		if (mulai != '' && selesai != '' && pkj != '') {
			var d1 = new Date(mulai);
			var d2 = new Date(selesai);
			if (d1.getTime() <= d2.getTime()) {
				$.ajax({
					data: {
						mulai: mulai,
						selesai:selesai,
						pkj: pkj,
						isolasi_id: isolasi_id
					},
					method: 'get',
					url: baseurl + 'MasterPekerja/Surat/SuratIsolasiMandiri/getIsolasiRow',
					error: function(xhr,status,error){
						swal.fire({
							title: xhr['status'] + "(" + xhr['statusText'] + ")",
							html: xhr['responseText'],
							type: "error",
							confirmButtonText: 'OK',
							confirmButtonColor: '#d63031',
						})
					},
					success: function(data){
						$('#cvd_tbladdAS tbody').html('');
						$('#cvd_tbladdAS tbody').html(data);
						$('#cvd_tbladdAS .select2').select2();
					}
				});
			}
		}
	});

	$('.cvd_btncekabsen').click(function(){
		$.ajax({
			data: {
				pkj: $('#slcMPSuratIsolasiMandiriPekerja').val(),
				awal: $('#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal').val(),
				akhir: $('#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal').val()
			},
			method: 'GET',
			url: baseurl + 'MasterPekerja/Surat/SuratIsolasiMandiri/cekPresensiIs',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				$('#cvd_divtim2').html(data);	
			}
		});
	});
	$('#slc-CVD-MonitoringCovid-Tambah-Pekerja').on('change', function(){
		var noind = $(this).val();
		$.ajax({
			data: {noind: noind},
			method: 'GET',
			url: baseurl + 'Covid/MonitoringCovid/getDetailPekerja',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				var obj = JSON.parse(data);
				if (obj.status == 'success') {
					$('#txt-CVD-MonitoringCovid-Tambah-Seksi').val(obj.seksi);
					$('#txt-CVD-MonitoringCovid-Tambah-Departemen').val(obj.dept);
				}
			}
		})

		$.ajax({
			data: {noind: noind},
			method: 'POST',
			dataType: 'JSON',
			url: baseurl + 'Covid/MonitoringCovid/getAtasan',
			beforeSend: function () {
				$('.select2Covid').html('<option value=""></option>')
			},
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				let tampung = [];
				data.forEach((value,indexnya) => {
					let hhtml = `<option value="${value.noind}"> ${value.noind} - ${value.nama} </option>`;
					tampung.push(hhtml);
				})
				$('.select2Covid').append(tampung.join(''));
			}
		});
	});

	$('#txt-CVD-Aktifitas').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})
	$('#txt-CVD-Prokes').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	});
	$('.txt-CVD-Prokes').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	});
	$('input[name="covid_menginap"]').on('change', function () {
		if ($('input[name="covid_menginap"]:checked').val() == "1") {
			$('.covid_show_menginap').show();
		} else if ($('input[name="covid_menginap"]:checked').val() == "0") {
			$('.covid_show_menginap').hide();
		}
	});

	$('input[name="covid_sakit"]').on('change', function () {
		if ($('input[name="covid_sakit"]:checked').val() == "1") {
			$('.covid_show_sakit').show();
		} else if ($('input[name="covid_sakit"]:checked').val() == "0") {
			$('.covid_show_sakit').hide();
		}
	});

	$('#txt-CVD-Penyakit').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})

	$('input[name="covid_sakit_kembali"]').on('change', function () {
		if ($('input[name="covid_sakit_kembali"]:checked').val() == "1") {
			$('.covid_show_sakit_kembali').show();
		} else if ($('input[name="covid_sakit_kembali"]:checked').val() == "0") {
			$('.covid_show_sakit_kembali').hide();
		}
	});

	$('#txt-CVD-Penyakit_kembali').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})

	$('input[name="covid_tamu_luar"]').on('change', function () {
		if ($('input[name="covid_tamu_luar"]:checked').val() == "1") {
			$('.covid_show_tamu_luar').show();
		} else if ($('input[name="covid_tamu_luar"]:checked').val() == "0") {
			$('.covid_show_tamu_luar').hide();
		}
	});

	$('#txt-CVD-Tamu-Luar').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})

	$('input[name="covid_orang_luar"]').on('change', function () {
		if ($('input[name="covid_orang_luar"]:checked').val() == "1") {
			$('.covid_show_orang_luar').show();
		} else if ($('input[name="covid_orang_luar"]:checked').val() == "0") {
			$('.covid_show_orang_luar').hide();
		}
	});

	$('#txt-CVD-Orang-Luar').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})

	$('input[name="covid_interaksi"]').on('change', function () {
		if ($('input[name="covid_interaksi"]:checked').val() == "1") {
			$('.covid_show_interaksi').show();
		} else if ($('input[name="covid_interaksi"]:checked').val() == "0") {
			$('.covid_show_interaksi').hide();
		}
	});

	$('#txt-CVD-Jenis_interaksi').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	})

	$('#txt-CVD-MonitoringCovid-Run-Down').redactor({
		imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	});

	$('.cvd_arahanprob').change(function(){
		var id = $('input:radio.cvd_arahanprob:checked').val();
		if (id == '1') {
			$('#cvd_arahan123').show();
			$('#cvd_arahan123 textarea').attr('disabled', false);
			$('#cvd_arahan123 textarea').redactor({
				imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
				imageUploadErrorCallback: function(json) {
					alert(json.error);
				}
			});
		}else{
			$('#cvd_arahan123').hide();
			$('#cvd_arahan123 textarea').redactor('destroy');
			$('#cvd_arahan123 textarea').attr('disabled', true);
		}
	});

	$('[name="hubungan"]').change(function(){
		var id = $(this).val();
		// alert(id);
		if (id == 'lainnya') {
			$('[name="hubungan_lainnya"]').show();
			$('[name="hubungan_lainnya"]').attr('disabled', false);
		}else{
			$('[name="hubungan_lainnya"]').hide();
			$('[name="hubungan_lainnya"]').attr('disabled', true);
		}
	});
	$('[name="hubungan_bedaRumah"]').change(function(){
		var id = $(this).val();
		// alert(id);
		if (id == 'lainnya') {
			$('[name="lainnya"]').show();
			$('[name="lainnya"]').attr('disabled', false);
		}else{
			$('[name="lainnya"]').hide();
			$('[name="lainnya"]').attr('disabled', true);
		}
	});

	$('[name="hubungan_relasi"]').change(function(){
		var id = $(this).val();
		// alert(id);
		if (id == 'lainnya') {
			$('[name="lainnya"]').show();
			$('[name="lainnya"]').attr('disabled', false);
		}else{
			$('[name="lainnya"]').hide();
			$('[name="lainnya"]').attr('disabled', true);
		}
	});

	$(".cvd_drange").daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		timePicker24Hour: true,
		showDropdowns: true,
		locale: {
			format: "YYYY-MM-DD",
		},
	});
	$(".cvd_drange2").daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		timePicker24Hour: true,
		showDropdowns: true,
		locale: {
			format: "DD MMMM YYYY",
		},
	});
	$(".cvd_drangem").daterangepicker({
		singleDatePicker: false,
		timePicker: false,
		timePicker24Hour: true,
		showDropdowns: true,
		locale: {
			format: "YYYY-MM-DD",
		},
	});

	$('[name="hasil_uji"]').change(function(){
		var id = $(this).val();
		if (id == 'Ya') {
			$('#cvd_divtest').show();
		}else{
			$('#cvd_divtest').hide();
			$('#cvd_divtest inputa').each(function(){
				// alert('');
				$(this).prop('checked', false);
				$(this).trigger('change');
			});
		}
	});

	$('[name="fantibody"]').change(function(){
		if ($(this).is(':checked')) {
			$(this).closest('div').find('input').not($(this)).attr('disabled', false);
		}else{
			$(this).closest('div').find('input').not($(this)).attr('disabled', true);
		}
	});
	$('[name="fantigen"]').change(function(){
		if ($(this).is(':checked')) {
			$(this).closest('div').find('input').not($(this)).attr('disabled', false);
		}else{
			$(this).closest('div').find('input').not($(this)).attr('disabled', true);
		}
	});
	$('[name="fpcr"]').change(function(){
		if ($(this).is(':checked')) {
			$(this).closest('div').find('input').not($(this)).attr('disabled', false);
		}else{
			$(this).closest('div').find('input').not($(this)).attr('disabled', true);
		}
	});

	$('[name="lapor_puskesmas"]').change(function(){
		var id = $(this).val();
		if (id == 'Sudah') {
			$('#cvd_divlappuskes').show();
			$('#cvd_divlappuskes input').attr('disabled', false);
		}else{
			$('#cvd_divlappuskes').hide();
			$('#cvd_divlappuskes input').attr('disabled', true);
		}
	});
	$('#cvd_btnaddfasilitas').click(function(){
		var clone = $(this).closest('table').find('tbody').find('tr').eq(0).clone();
		$(this).closest('table').find('tbody').append(clone);
		$(this).closest('table').find('tbody').find('tr').find('input').last().val('');
	});
	$(document).on('click', '.cvd_btnrmfasilitas' ,function(){
		var sum = $(this).closest('table').find('tbody').find('tr').size();
		if (sum > 1) {
			$(this).closest('tr').remove();
		}
	});

	$('.cvd_inboxjml').change(function(){
		var t = $(this).is(':checked');
		if ($(this).is(':checked')) {
			$(this).parents('div').eq(1).find('input').not($(this)).attr('disabled', false);
		}else{
			$(this).parents('div').eq(1).find('input').not($(this)).attr('disabled', true).val('');
		}
	});
	$('#cvd_inboxjmllainya').change(function(){
		var id = $(this).is(':checked');
		if (id) {
			$('#cvd_taanggotalainnya').show();
		}else{
			$('#cvd_taanggotalainnya').hide();
		}
	});

	$('#cvd_tidakgejala').change(function(){
		var c = $(this).is(':checked');
		if (c) {
			$('[name="gejala[]"]').not('#cvd_tidakgejala').prop('checked', false);
			$('[name="gejala[]"]').not('#cvd_tidakgejala').attr('disabled', true);
			$('[name="tgl_gejala"]').val('').attr('disabled', true);
		}else{
			$('[name="tgl_gejala"]').attr('disabled', false);
			$('[name="gejala[]"]').not('#cvd_tidakgejala').attr('disabled', false);
		}
	});
});

function cvd_deleteAttachment(id)
{
	$.ajax({
		data: {id: id},
		method: 'POST',
		url: baseurl + 'Covid/MonitoringCovid/delAttch',
		error: function(xhr,status,error){
			swal.fire({
				title: xhr['status'] + "(" + xhr['statusText'] + ")",
				html: xhr['responseText'],
				type: "error",
				confirmButtonText: 'OK',
				confirmButtonColor: '#d63031',
			})
		},
		success: function(data){
			window.location.reload();
		}
	});
}

function showAjaxGetPRM(params)
{
	$.ajax({
		data: params,
		method: 'GET',
		url: baseurl + 'Covid/MonitoringCovid/CekAbsensiPrm',
		error: function(xhr,status,error){
			swal.fire({
				title: xhr['status'] + "(" + xhr['statusText'] + ")",
				html: xhr['responseText'],
				type: "error",
				confirmButtonText: 'OK',
				confirmButtonColor: '#d63031',
			})
		},
		success: function(data){
				if (data == '1') {
					alertLagi(params);
				}else{
					hapusDataIsolasi(params);
				}
			}
		});
}

function alertLagi(params)
{
	Swal.fire({
		title: 'Hapus Data Presensi',
		text: "Anda yakin akan menghapus Data Presensinya juga ?",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Tidak'
	}).then((result) => {
		if (result.value) {
			hapusDataIsolasi(params);
		}
	});
}

function hapusDataIsolasi(params)
{
	$.ajax({
		data: params,
		method: 'GET',
		url: baseurl + 'Covid/MonitoringCovid/hapus',
		error: function(xhr,status,error){
			swal.fire({
				title: xhr['status'] + "(" + xhr['statusText'] + ")",
				html: xhr['responseText'],
				type: "error",
				confirmButtonText: 'OK',
				confirmButtonColor: '#d63031',
			})
		},
		success: function(data){
			obj = JSON.parse(data);
			if (obj.status == "sukses") {
				Swal.fire(
					'Sukses !!!',
					'Data Berhasil Dihapus',
					'success'
					).then( () => {
						window.location.href = baseurl + 'Covid/MonitoringCovid';
					})
				}
			}
		});
}

$(document).on('change', '#cvd_samastatus', function(){
	var val = $('.cvd_status_table').eq(0).val();
	$('.cvd_status_table').each(function(){
		$(this).val(val).trigger('change');
	});
});

$(document).on('change', '.cvd_status_table', function(){
	var id = $(this).val();

	if (id == 'PKJ' || id == 'PSK') {
		$(this).closest('td').next().find('select').val(null).trigger('change');
		$(this).closest('td').next().find('select').attr('disabled', true);
	}else{
		$(this).closest('td').next().find('select').attr('disabled', false);
	}
});

$(document).on('change', '#cvd_samaalasan', function(){
	var val = $('.cvd_alasan_table').eq(0).val();
	$('.cvd_alasan_table').each(function(){
		$(this).val(val).trigger('change');
	});
});

$(function(){
	$('#txtPeriodeKejadian').daterangepicker({
		"todayHighlight" : true,
		"autoclose": true,
		locale: {
					format: 'DD MMMM YYYY'
				},
	});
	$('#txtPeriodeKejadian').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
	});

	$('#txtPeriodeKejadian').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});
});

function readFilePdf(input, n) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`img[preview_cvd="${n}"]`)
                .attr('src', e.target.result)
                .width(300)
                .height(200);
        };
    reader.readAsDataURL(input.files[0]);
    }
}

const addimgcvd = () =>{
		let jumlah_isi_table_saat_ini = $('.table-add-image-cvd tbody tr').length;
		if (jumlah_isi_table_saat_ini > 3) {
			swal.fire({
								type: "warning",
								text: 'Max 4 File!!!'
						})
		}else {
			let html = `<tr row="${Number(jumlah_isi_table_saat_ini)+1}">
										<td>
											<input type="file" class="form-control" name="filesCVDLampiran[]"  onchange="readFilePdf(this, ${Number(jumlah_isi_table_saat_ini)+1})" multiple="multiple" style="margin-bottom:12px;">
											<center><img preview_cvd="${Number(jumlah_isi_table_saat_ini)+1}" src=""></center>
										</td>
										<td style="text-align:center">
											<button type="button" class="btn btn-sm btn-success" onclick="minimgcvd(${Number(jumlah_isi_table_saat_ini)+1})" name="button"> <i class="fa fa-minus"></i> </button>
										</td>
									</tr>`;
			$('.table-add-image-cvd').append(html);
		}
}

const minimgcvd = (id) =>{
	$(`.table-add-image-cvd tbody tr[row="${id}"]`).remove();
}

// start Zona KHS
$(document).on('ready', function(){
	var tblCVDZonaKHS = $('#tbl-CVD-ZonaKHS').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'print', 'pageLength'
        ],
        "columnDefs": [
		    {
		        targets: -1,
		        className: 'text-center'
		    },
		    {
		        targets: 0,
		        className: 'text-center'
		    },
		    {
		        targets: 3,
		        className: 'text-center'
		    },
		    {
		        targets: 4,
		        className: 'text-center'
		    },
		    {
		        targets: 5,
		        className: 'text-center'
		    }
		],
		'rowsGroup' : [1,2,3,-1]
	});

	$('.txt-CVD-ZonaKHS-PeriodeAwal, .txt-CVD-ZonaKHS-PeriodeAkhir').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#btn-CVD-ZonaKHS-AddKasus').on('click', function(){
		row = $('#tbl-CVD-ZonaKHS-Kasus').find('tbody tr:visible').length;
		if (row == 0) {
			$('#tbl-CVD-ZonaKHS-Kasus').find('tbody tr').show();
		}else{
			clonedTr = $("#tbl-CVD-ZonaKHS-Kasus").find('tbody tr').last().clone();
			$("#tbl-CVD-ZonaKHS-Kasus").find('tbody').append(clonedTr);
			$('.txt-CVD-ZonaKHS-PeriodeAwal').last().val("");
			$('.txt-CVD-ZonaKHS-PeriodeAkhir').last().val("");
			$('.txa-CVD-ZonaKHS-Kasus').last().val("");

			$('.txt-CVD-ZonaKHS-PeriodeAwal, .txt-CVD-ZonaKHS-PeriodeAkhir').datepicker({
				"autoclose": true,
				"todayHighlight": true,
				"todayBtn": "linked",
				"format":'yyyy-mm-dd'
			});
		}
	})

	$("#tbl-CVD-ZonaKHS-Kasus").on('click','.btn-CVD-ZonaKHS-RemoveKasus', function(){
		row = $('#tbl-CVD-ZonaKHS-Kasus').find('tbody tr:visible').length;
		if (row == 1) {
			$(this).closest('tr').hide();
		}else{
			$(this).closest('tr').remove();
		}
	})

	$('#btn-CVD-ZonaKHS-Simpan').on('click', function(){
		seksi = $('#txt-CVD-ZonaKHS-Seksi').val();
		lokasi = $('#slc-CVD-ZonaKHS-Lokasi').val();
		koor = $('#txt-CVD-ZonaKHS-Koordinat').val();

		kasus = []
		$("#tbl-CVD-ZonaKHS-Kasus tbody tr:visible").map(function(){
			obj = {
				tgl_awal: $(this).find('.txt-CVD-ZonaKHS-PeriodeAwal').val(),
				tgl_akhir: $(this).find('.txt-CVD-ZonaKHS-PeriodeAkhir').val(),
				kasus: $(this).find('.txa-CVD-ZonaKHS-Kasus').val()
			}
			if (obj.tgl_awal !== null && obj.tgl_awal.length > 0 && obj.tgl_akhir !== null && obj.tgl_akhir.length > 0 && obj.kasus !== null && obj.kasus.length > 0) {
				kasus.push(obj);
			}
		})
		if (seksi !== null && seksi.length > 0 && lokasi !== null && lokasi.length > 0 && koor !== null && koor.length > 0) {
			$('#ldg-CVD-ZonaKHS-Add').show();
			$.ajax({
				method: 'POST',
	    		url: baseurl + 'Covid/ZonaKHS/Insert',
	    		data: {
	    			seksi 		: seksi,
	    			lokasi 		: lokasi,
	    			kasus 		: kasus,
	    			koordinat	: koor
	    		},
	    		error: function(xhr,status,error){
					$('#ldg-CVD-ZonaKHS-Add').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CVD-ZonaKHS-Add').hide();
					if (data == "sukses") {
						Swal.fire(
							'Simpan Sukses !!!',
							'Data Berhasil Disimpan !!',
							'success'
						).then(function(){
					  		Swal.fire({
								title: 'Apakah Anda Ingin menginput Data lagi ?',
								text: "jika tidak akan diredirect ke halaman list Zona Covid KHS",
								type: 'question',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ya',
								cancelButtonText: 'Tidak'
							}).then((result) => {
							  	if (result.value) {
							  		$('#txt-CVD-ZonaKHS-Seksi').val("");
									$('#slc-CVD-ZonaKHS-Lokasi').val("");
									$('#tbl-CVD-ZonaKHS-Kasus').find('tbody tr').not(':first').remove();
									$('.txt-CVD-ZonaKHS-PeriodeAwal').val("");
									$('.txt-CVD-ZonaKHS-PeriodeAkhir').val("");
									$('.txa-CVD-ZonaKHS-Kasus').val("");
							  	}else{
					  				window.location.href = baseurl + 'Covid/ZonaKHS';
							  	}
							});
						});
					}else{
						swal.fire({
			                title: "Error",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Area, Lokasi, dan Map harus terisi',
				'warning'
			)
		}
	})

	$('#btn-CVD-ZonaKHS-Update').on('click', function(){
		idZona = $(this).attr('data-id');
		seksi = $('#txt-CVD-ZonaKHS-Seksi').val();
		lokasi = $('#slc-CVD-ZonaKHS-Lokasi').val();
		koor = $('#txt-CVD-ZonaKHS-Koordinat').val();

		kasus = []
		$("#tbl-CVD-ZonaKHS-Kasus tbody tr:visible").map(function(){
			obj = {
				tgl_awal: $(this).find('.txt-CVD-ZonaKHS-PeriodeAwal').val(),
				tgl_akhir: $(this).find('.txt-CVD-ZonaKHS-PeriodeAkhir').val(),
				kasus: $(this).find('.txa-CVD-ZonaKHS-Kasus').val()
			}
			if (obj.tgl_awal !== null && obj.tgl_awal.length > 0 && obj.tgl_akhir !== null && obj.tgl_akhir.length > 0 && obj.kasus !== null && obj.kasus.length > 0) {
				kasus.push(obj);
			}
		})
		if (seksi !== null && seksi.length > 0 && lokasi !== null && lokasi.length > 0 && koor !== null && koor.length > 0) {
			
			$('#ldg-CVD-ZonaKHS-Add').show();
			$.ajax({
				method: 'POST',
	    		url: baseurl + 'Covid/ZonaKHS/Update/' + idZona,
	    		data: {
	    			seksi 		: seksi,
	    			lokasi 		: lokasi,
	    			kasus 		: kasus,
	    			koordinat 	: koor
	    		},
	    		error: function(xhr,status,error){
					$('#ldg-CVD-ZonaKHS-Add').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CVD-ZonaKHS-Add').hide();
					if (data == "sukses") {
						Swal.fire(
							'Simpan Sukses !!!',
							'Data Berhasil Disimpan !!',
							'success'
						).then(function(){
					  		Swal.fire({
								title: 'Apakah Anda Ingin meng-update Data lagi ?',
								text: "jika tidak akan diredirect ke halaman list Zona Covid KHS",
								type: 'question',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ya',
								cancelButtonText: 'Tidak'
							}).then((result) => {
							  	if (!result.value) {
					  				window.location.href = baseurl + 'Covid/ZonaKHS';
							  	}
							});
						});
					}else{
						swal.fire({
			                title: "Error",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Seksi, Lokasi, dan Map harus terisi',
				'warning'
			)
		}
	})

	$('#tbl-CVD-ZonaKHS').on('click', '.btn-CVD-ZonaKHS-Hapus', function(){
		idZona = $(this).closest('tr').find('input').val();
		Swal.fire({
			title: 'Apakah Anda Ingin menghapus Data ini ?',
			text: "data yang sudah dihapus tidak dapat dikembalikan.",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
		  	if (result.value) {
				$('#ldg-CVD-ZonaKHS').show();
		  		$.ajax({
		    		method: 'GET',
		    		url: baseurl + 'Covid/ZonaKHS/Delete/' + idZona,
		    		error: function(xhr,status,error){
						$('#ldg-CVD-ZonaKHS').hide();
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						if (obj = JSON.parse(data)) {
							tblCVDZonaKHS.clear().draw();
							button = '<button class="btn btn-info btn-CVD-ZonaKHS-Edit" title="Edit"><span class="fa fa-edit"></span></button>'
							button += '<button class="btn btn-danger btn-CVD-ZonaKHS-Hapus" title="Hapus"><span class="fa fa-trash"></span></button>'
							obj.forEach(function(daftar, index){
								tblCVDZonaKHS.row.add([
									(index + 1) + '<input type="hidden" value="' + daftar.id_zona +'">',
									daftar.lokasi,
									daftar.nama_seksi,
									daftar.isolasi,
									daftar.tgl_awal_isolasi,
									daftar.tgl_akhir_isolasi,
									daftar.kasus,
									button
								]).draw(false);
							})
							tblCVDZonaKHS.columns.adjust().draw();
							Swal.fire(
								'Hapus Data Sukses !!!',
								'Data Berhasil Dihapus !!',
								'success'
							);
							$('#ldg-CVD-ZonaKHS').hide();
						}else{
							$('#ldg-CVD-ZonaKHS').hide();
							swal.fire({
				                title: "Error",
				                html: data,
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
						}
					}
		    	});
		  	}
		});
	})

	$('#tbl-CVD-ZonaKHS').on('click', '.btn-CVD-ZonaKHS-Edit', function(){
		idZona = $(this).closest('tr').find('input').val();
		window.location.href = baseurl + 'Covid/ZonaKHS/Edit/' + idZona;
	})

	$('#slc-CVD-ZonaKHS-Lokasi').on('change', function(){
		lokasi = $(this).val();
		if (lokasi == "JOGJA") {
			$('#map-pst').show();
			$('#map-tks').hide();
		}else{
			$('#map-tks').show();
			$('#map-pst').hide();
		}
	})

	$('.slc-CVD-ZonaKHS-Email-Area').select2({
		placeholder: 'Area',
		minimumInputLength: 0,
		ajax: {
			url: baseurl+'Covid/ZonaKHS/getAreaIsolasi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.id_zona,
							text: item.lokasi + " - " + item.nama_seksi
						};
					})
				};
			},
		}
	})

	$("#tbl-CVD-ZonaKHS-Email-Area").on('change','.slc-CVD-ZonaKHS-Email-Area', function(){
		idZona = $(this).val();
		tr = $(this).closest('tr');
		tr.find('.slc-CVD-ZonaKHS-Email-Kasus').attr('disabled', false);
		tr.find('.slc-CVD-ZonaKHS-Email-Kasus').val("").change();
		console.log("Tes");
	})
	
	$('.slc-CVD-ZonaKHS-Email-Kasus').select2({
		placeholder: 'Area',
		minimumInputLength: 0,
		ajax: {
			url: baseurl+'Covid/ZonaKHS/getKasus',
			dataType:'json',
			type: "GET",
			data: function (params) {
				idZona = $(this).closest('tr').find('.slc-CVD-ZonaKHS-Email-Area').val();
				return {
					term: params.term,
					id_zona: idZona
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.id_zona_detail,
							text: item.kasus
						};
					})
				};
			},
		}
	})

	$("#tbl-CVD-ZonaKHS-Email-Area").on('change','.slc-CVD-ZonaKHS-Email-Kasus', function(){
		idKasus = $(this).val();
		if (idKasus !== null && idKasus.length > 0) {
			tr = $(this).closest('tr');
			$.ajax({
	    		method: 'GET',
	    		url: baseurl + 'Covid/ZonaKHS/getPeriode/' + idKasus,
	    		error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (obj = JSON.parse(data)) {
						tr.find('.txt-CVD-ZonaKHS-Email-Isolasi').val(obj.tgl_awal_isolasi + " s/d " +  obj.tgl_akhir_isolasi);
					}else{
						swal.fire({
			                title: "Error",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
				}
			})
		}
	})

	$('#btn-CVD-ZonaKHS-Email-Area-Add').on('click', function(){
		$('.slc-CVD-ZonaKHS-Email-Area').select2("destroy");
		$('.slc-CVD-ZonaKHS-Email-Kasus').select2("destroy");
		clonedTr = $("#tbl-CVD-ZonaKHS-Email-Area").find('tbody tr').last().clone();
		$("#tbl-CVD-ZonaKHS-Email-Area").find('tbody').append(clonedTr);
		$('.txt-CVD-ZonaKHS-Email-Isolasi').last().val("");
		$('.slc-CVD-ZonaKHS-Email-Kasus').last().val("");
		$('.slc-CVD-ZonaKHS-Email-Area').last().val("");

		$('.slc-CVD-ZonaKHS-Email-Area').select2({
			placeholder: 'Area ',
			minimumInputLength: 0,
			ajax: {
				url: baseurl+'Covid/ZonaKHS/getAreaIsolasi',
				dataType:'json',
				type: "GET",
				data: function (params) {
					return {
						term: params.term
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.id_zona,
								text: item.lokasi + " - " + item.nama_seksi
							};
						})
					};
				},
			}
		})

		$('.slc-CVD-ZonaKHS-Email-Kasus').select2({
			placeholder: 'Area',
			minimumInputLength: 0,
			ajax: {
				url: baseurl+'Covid/ZonaKHS/getKasus',
				dataType:'json',
				type: "GET",
				data: function (params) {
					idZona = $(this).closest('tr').find('.slc-CVD-ZonaKHS-Email-Area').val();
					return {
						term: params.term,
						id_zona: idZona
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.id_zona_detail,
								text: item.kasus
							};
						})
					};
				},
			}
		})
	})

	$("#tbl-CVD-ZonaKHS-Email-Area").on('click','.btn-CVD-ZonaKHS-Email-Area-Delete', function(){
		row = $('#tbl-CVD-ZonaKHS-Email-Area').find('tbody tr').length;
		if (row <= 1) {
			Swal.fire(
				'Peringatan !!!',
				'Minimal 1 Area',
				'warning'
			)
		}else{
			$(this).closest('tr').remove();
		}
	})

	$('#btn-CVD-ZonaKHS-Email-Penerima-Add').on('click', function(){
		clonedTr = $("#tbl-CVD-ZonaKHS-Email-Penerima").find('tbody tr').last().clone();
		$("#tbl-CVD-ZonaKHS-Email-Penerima").find('tbody').append(clonedTr);
		$('.txt-CVD-ZonaKHS-Email-Alamat').last().val("");
		$('.txt-CVD-ZonaKHS-Email-Nama').last().val("");
	})

	$("#tbl-CVD-ZonaKHS-Email-Penerima").on('click','.btn-CVD-ZonaKHS-Penerima-Delete', function(){
		row = $('#tbl-CVD-ZonaKHS-Email-Penerima').find('tbody tr').length;
		if (row <= 1) {
			Swal.fire(
				'Peringatan !!!',
				'Minimal 1 Penerima',
				'warning'
			)
		}else{
			$(this).closest('tr').remove();
		}
	})

	$('#txa-CVD-ZonaKHS-Email-Preview').redactor({
        imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

    $('#btn-CVD-ZonaKHS-EMail-Preview').on('click', function(){
    	seksi = []
		$("#tbl-CVD-ZonaKHS-Email-Area tbody tr").map(function(){
			obj = {
				id_zona: $(this).find('.slc-CVD-ZonaKHS-Email-Area').val(),
				id_zona_detail: $(this).find('.slc-CVD-ZonaKHS-Email-Kasus').val()
			}
			if (obj.id_zona !== null && obj.id_zona.length > 0 && obj.id_zona_detail !== null && obj.id_zona_detail.length > 0) {
				seksi.push(obj);
			}
		})
		if (seksi.length > 0) {
	    	$('#ldg-CVD-ZonaKHS-Email').show();
	    	$.ajax({
	    		method: 'POST',
	    		url: baseurl + 'Covid/ZonaKHS/getMessageBody',
	    		data: {
	    			area: seksi
	    		},
	    		error: function(xhr,status,error){
	    			$('#ldg-CVD-ZonaKHS-Email').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (obj = JSON.parse(data)) {
	    				$('#txa-CVD-ZonaKHS-Email-Preview').redactor("set",obj.messageBody);
	    				$('#btn-CVD-ZonaKHS-Email-Kirim').attr('disabled',false);
					}else{
						swal.fire({
			                title: "Error",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
	    			$('#ldg-CVD-ZonaKHS-Email').hide();
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Minimal ada 1 area seksi terisi',
				'warning'
			)
		}
    })

    $('#btn-CVD-ZonaKHS-Email-Kirim').on('click', function(){
    	emailBody = $('#txa-CVD-ZonaKHS-Email-Preview').val();
    	penerima = []
		$("#tbl-CVD-ZonaKHS-Email-Penerima tbody tr").map(function(){
			obj = {
				alamat: $(this).find('.txt-CVD-ZonaKHS-Email-Alamat').val(),
				nama: $(this).find('.txt-CVD-ZonaKHS-Email-Nama').val()
			}
			console.log(obj);
			if (obj.alamat !== null && obj.alamat.length > 0 && obj.nama !== null && obj.nama.length > 0) {
				penerima.push(obj);
			}
		})
		// console.log(penerima);
		if (penerima.length > 0) {
	    	$('#ldg-CVD-ZonaKHS-Email').show();
			$.ajax({
	    		method: 'POST',
	    		url: baseurl + 'Covid/ZonaKHS/sendEmail',
	    		data: {
	    			email_body: emailBody,
	    			penerima: penerima
	    		},
	    		error: function(xhr,status,error){
	    			$('#ldg-CVD-ZonaKHS-Email').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (data == "sukses") {
	    				Swal.fire(
							'Hapus Data Sukses !!!',
							'Email Berhasil Dikirim !!',
							'success'
						);
					}else{
						swal.fire({
			                title: "Error",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
	    			$('#ldg-CVD-ZonaKHS-Email').hide();
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Minimal ada 1 penerima terisi lengkap alamat email dan nama nya!',
				'warning'
			)
		}			
    })
})
// end Zona KHS

function getTabelhasiltest(id)
{
	$('#surat-loading').attr('hidden', false);
	$.ajax({
		data: {
			id:id
		},
		method: 'GET',
		url: baseurl + 'Covid/MonitoringCovid/getHasilTestc',
		error: function(xhr,status,error){
			swal.fire({
				title: xhr['status'] + "(" + xhr['statusText'] + ")",
				html: xhr['responseText'],
				type: "error",
				confirmButtonText: 'OK',
				confirmButtonColor: '#d63031',
			});
			$('#surat-loading').attr('hidden', true);
		},
		success: function(data){
			$('#surat-loading').attr('hidden', true);
			$('#cvd_tbhltes').html(data);
			$('#cvd_tblhsltest').DataTable();
		}
	});
}

$(document).ready(function(){
	$('#cvd_savehsltes').click(function(){
		var jns = $(this).closest('div#cvd_mdladdtest').find('[name="jns_test"]').val();
		var tgl = $(this).closest('div#cvd_mdladdtest').find('[name="tgl_test"]').val();
		var hsl = $(this).closest('div#cvd_mdladdtest').find('[name="hsl_test"]').val();
		if (jns == '' || tgl == '') {
			alert('Harap Isi Semua Kolom');
			return false;
		}

		$.ajax({
			data: $('#cvd_frmaddtes').serialize(),
			method: 'POST',
			url: baseurl + 'Covid/MonitoringCovid/addHsilTestc',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				$('#cvd_mdladdtest').modal('hide');
				mpk_showAlert("success", "Berhasil Menambah Data !");
				getTabelhasiltest(idenc);
			}
		});
	});

	$('#cvd_uphsltes').click(function(){
		var jns = $(this).closest('div#cvd_mdledtest').find('[name="jns_test"]').val();
		var tgl = $(this).closest('div#cvd_mdledtest').find('[name="tgl_test"]').val();
		var hsl = $(this).closest('div#cvd_mdledtest').find('[name="hsl_test"]').val();
		if (jns == '' || tgl == '') {
			alert('Harap Isi Semua Kolom');
			return false;
		}

		$.ajax({
			data: $('#cvd_frmedtes').serialize(),
			method: 'POST',
			url: baseurl + 'Covid/MonitoringCovid/updHsilTestc',
			error: function(xhr,status,error){
				swal.fire({
					title: xhr['status'] + "(" + xhr['statusText'] + ")",
					html: xhr['responseText'],
					type: "error",
					confirmButtonText: 'OK',
					confirmButtonColor: '#d63031',
				})
			},
			success: function(data){
				$('#cvd_mdledtest').modal('hide');
				mpk_showAlert("success", "Berhasil Mengupdate Data !");
				getTabelhasiltest(idenc);
			}
		});
	});

	$('.cvd_select2').select2({
		placeholder: "Pilih Salah Satu",
		allowClear: true
	});
	$('.cvd_select3').select2({
		placeholder: "Kosongkan untuk Melihat Semua Status",
		allowClear: true
	});

	$('#cvd_chcktglkeluar').change(function(){
		var a = $(this).is(':checked');
		if (a) {
			$('[name="tgl_keluar_test"]').attr('disabled', false);
			$('[name="hsl_test"]').attr('disabled', false);
		}else{
			$('[name="tgl_keluar_test"]').attr('disabled', true);
			$('[name="hsl_test"]').attr('disabled', true);
		}
	});

	$('.cvd_dpick').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});
});

$(document).on('click', '.cvd_btndelhsltes', function(){
	var a = $(this).closest('tr').find('td').eq(1).text();
	var b = $(this).closest('tr').find('td').eq(2).text();
	var c = $(this).closest('tr').find('td').eq(3).text();
	var val = $(this).val();
	Swal.fire({
		title: 'Hapus Data ini ?',
		text: "("+a+" | "+b+" | "+c+")",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Tidak'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				data: {
					id:val
				},
				method: 'POST',
				url: baseurl + 'Covid/MonitoringCovid/delHsilTestc',
				error: function(xhr,status,error){
					swal.fire({
						title: xhr['status'] + "(" + xhr['statusText'] + ")",
						html: xhr['responseText'],
						type: "error",
						confirmButtonText: 'OK',
						confirmButtonColor: '#d63031',
					});
				},
				success: function(data){
					mpk_showAlert("success", "Berhasil Menghapus Data !");
					getTabelhasiltest(idenc);
				}
			});
		}
	});
});

$(document).on('click','.cvd_btnedhsltes', function(){
	var a = $(this).attr('jns');
	var b = $(this).attr('tgl');
	var d = $(this).attr('tglkeluar');
	var c = $(this).attr('hsl');
	var val = $(this).val();
	// alert(d);
	$('#cvd_mdledtest').modal('show');
	$('div#cvd_mdledtest').find('select[name="jns_test"]').val(a).trigger('change');
	$('div#cvd_mdledtest').find('input[name="tgl_test"]').val(b).trigger('change');
	$('div#cvd_mdledtest').find('select[name="hsl_test"]').val(c).trigger('change');
	$('div#cvd_mdledtest').find('input[name="tgl_keluar_test"]').val(d).trigger('change');
	$('div#cvd_mdledtest').find('input[name="id"]').val(val).trigger('change');
});

function getDataMonitoringCovid()
{
	fakeLoading(0);
	var l = $('.cvd_pekerjaid').length;
	if (l == 0) {
		cvd_bindPopover();
		fakeLoading(1);
	}
	var x = 0;
	$('.cvd_pekerjaid').each(function(){
		var ini = $(this);
		var id = $(this).attr('data-id');
		// if (id != '258') { return true; }
		// console.log(id);
		$.ajax({
				data: {
					id:id
				},
				method: 'get',
				url: baseurl + 'Covid/PelaporanPekerja/getInfoIsolasi',
				error: function(xhr,status,error){
					swal.fire({
						title: xhr['status'] + "(" + xhr['statusText'] + ")",
						html: xhr['responseText'],
						type: "error",
						confirmButtonText: 'OK',
						confirmButtonColor: '#d63031',
					});
				},
				success: function(data){
					try {
						var d = JSON.parse(data);
						// console.log(d);
						for (var i in d.data) {
							// console.log(d.data[i][0]);
							$(ini).closest('tr').find('.'+i).html(d.data[i]);
						}
					} catch (e) {
						console.log('JSON Invalid for id '+id);
					}
					x++;
					if (x == l) {
						cvd_bindPopover();
						fakeLoading(1);
					}
				}
			});
		// return false;
	});
}

function cvd_bindPopover()
{
	console.log('init Popover');
	$('.cvd_warna1').popover({
		content :  function() {
            return $('#cvd_warna1').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna2').popover({
		content :  function() {
            return $('#cvd_warna2').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna3').popover({
		content :  function() {
            return $('#cvd_warna3').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna4').popover({
		content :  function() {
            return $('#cvd_warna4').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna5').popover({
		content :  function() {
            return $('#cvd_warna5').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna6').popover({
		content :  function() {
            return $('#cvd_warna6').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna7').popover({
		content :  function() {
            return $('#cvd_warna7').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna8').popover({
		content :  function() {
            return $('#cvd_warna8').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna9').popover({
		content :  function() {
            return $('#cvd_warna9').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna10').popover({
		content :  function() {
            return $('#cvd_warna10').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna11').popover({
		content :  function() {
            return $('#cvd_warna11').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna12').popover({
		content :  function() {
            return $('#cvd_warna12').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna13').popover({
		content :  function() {
            return $('#cvd_warna13').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna14').popover({
		content :  function() {
            return $('#cvd_warna14').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});
	$('.cvd_warna15').popover({
		content :  function() {
            return $('#cvd_warna15').html();
        },
        container: 'body',
		html: true,
		trigger: 'hover'
	});

	$('#cvd_tblmntrpel').DataTable({
		scrollX:true,
		"scrollY": "450px",
		"scrollCollapse": true,
		"paging": false,
		fixedColumns:   {
            leftColumns: 5,
        },
		// "ordering": false,
		"columnDefs": [
			{ "orderable": true, "targets": 0 },
			{ "orderable": true, "targets": 1 },
			{ "orderable": true, "targets": 2 },
			{ "orderable": true, "targets": 3 },
			{ "orderable": true, "targets": 4 },
			{ "orderable": true, "targets": 5 },
			{ "orderable": false, "targets": '_all' }
		]
	});
}