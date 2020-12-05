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
    })

	$('#tbl-CVD-MonitoringCovid').on('click', '.btn-CVD-MonitoringCovid-Hapus', function(){
		var params = {
		  				id		: $(this).attr('data-href'),
		  				status 	: $(this).attr('data-status'),
		  			}
		console.log('trigger hapus');
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
	})

	$('.btn-CVD-MonitoringCovid-Tambah-Lampiran').on('click', function(){
		$('.file-CVD-MonitoringCovid-Tambah-Lampiran').last().click();
	})

	$(document).on('change','.file-CVD-MonitoringCovid-Tambah-Lampiran', function(){
		$(this).closest('div').append('<label class="label label-success" style="margin: 5px;">' + $(this).val().substring(12) + '</label>');
		$(this).clone().val('').appendTo($(this).closest('div'));
	})

	$('#tbl-CVD-MonitoringCovid').on('click', '.btn-CVD-MonitoringCovid-FollowUp', function(){
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

	$('#slcMPSuratIsolasiMandiriTo').select2();

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

$(document).on('change', '#cvd_samaalasan', function(){
	var val = $('.cvd_alasan_table').eq(0).val();
	$('.cvd_alasan_table').each(function(){
		$(this).val(val).trigger('change');
	});
});