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
	})

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
	})
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
                .width(400)
                .height(300);
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