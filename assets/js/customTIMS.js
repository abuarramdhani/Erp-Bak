	//------------------------REKAP TIMS.begin------------------
	//Date Picker
	$( document ).ready(function() {
		//-------begin.REKAP TIMS---------------
		$('#rekapBegin').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});

		$('#rekapEnd').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});
	});

	//DATA TABLE
	$(document).ready(function(){
		$('.data-tims-personal').DataTable({
			"dom": '<"pull-left"f>t<"pull-right"p>',
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
        	"pageLength": 5
		});
		$('.datatable-overtime').DataTable({
			retrieve : true,
			"info"		: true,
	    	"searching"	: true,
	    	"lengthChange": true,
		});
	});
	//-------------------------- Ambil Data Seksi.Rekap TIMS -----------------------------
	//AJAX JAVASCRIPT
	$(document).ready(function() {
		$('#departemen_select').change(function()
		{
			$('#bidang_select').select2("val", "");
			$('#unit_select').select2("val", "");
			$('#section_select').select2("val", "");
			$('#bidang_select').select2("data", null);
			$('#unit_select').select2("data", null);
			$('#section_select').select2("data", null);
			$('#bidang_select').prop("disabled", false);
			$('#unit_select').prop("disabled", true);
			$('#section_select').prop("disabled", true);
			var value = $('#departemen_select').val();
			$.ajax({
				type:'POST',
				delay: 500,
				data:{data_name:value,modul:'bidang'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#bidang_select').html(result);
				}
			});
		});
		$('#bidang_select').change(function(){
			$('#unit_select').select2("val", "");
			$('#section_select').select2("val", "");
			$('#unit_select').select2("data", null);
			$('#section_select').select2("data", null);
			$('#unit_select').prop("disabled", false);
			$('#section_select').prop("disabled", true);
			var value = $('#bidang_select').val();
			$.ajax({
				type:'POST',
				delay: 500,
				data:{data_name:value,modul:'unit'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#unit_select').html(result);
				}
			});
		});
		$('#unit_select').change(function(){
			$('#section_select').select2("val", "");
			$('#section_select').select2("data", null);
			$('#section_select').prop("disabled", false);
			var value = $('#unit_select').val();
			$.ajax({
				type:'POST',
				delay: 500,
				data:{data_name:value,modul:'seksi'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#section_select').html(result);
				}
			});
		});

		$(".js-slcNoInduk").select2({
			placeholder: "No Induk",
			minimumInputLength: 3,
			ajax: {		
				url:baseurl+"RekapTIMSPromosiPekerja/GetNoInduk",
				dataType: 'json',
				type: "GET",
				delay: 500,
				data: function (params) {
					var queryParameters = {
						term: params.term,
						type: $('select#slcNoInduk').val(),
						stat: $('select#slcStatus').val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
						})
					};
				}
			}	
		});

		$(".slcNoInduk_listLkhPekerja").select2({
			placeholder: "No Induk",
			minimumInputLength: 3,
			ajax: {		
				url:baseurl+"RekapTIMSPromosiPekerja/GetNoInduk",
				dataType: 'json',
				type: "GET",
				delay: 500,
				data: function (params) {
					var queryParameters = {
						term: params.term,
						type: $('select#slcNoInduk_listLkhPekerja').val(),
						stat: 0
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							console.log({id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama});
							return {id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
						})
					};
				}
			}	
		});	
			
		$('#submit-filter-no-induk').click(function(){
			$('.alert').alert('close');
			$('body').addClass('noscroll');
			$('#loadingAjax').addClass('overlay_loading');
			$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
			$.ajax({
				type:'POST',
				data:$("#filter-rekap").serialize(),
				url:baseurl+"RekapTIMSPromosiPekerja/RekapPerPekerja/show-data",
				success:function(result)
				{
					$('#table-div').html(result);
					$('body').removeClass('noscroll');
					$('#loadingAjax').html('');
					$('#loadingAjax').removeClass('overlay_loading');
					rekap_datatable();
					rekap_datatable_detail();
				},
				error: function() {
					$('body').removeClass('noscroll');
					$('#loadingAjax').html('');
					$('#loadingAjax').removeClass('overlay_loading');
					document.getElementById("errordiv").html = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Terjadi Kesalahan</div>';
				}
			});
		});
		$('#submit-filter-rekap').click(function(e){
			$('.alert').alert('close');
			$('body').addClass('noscroll');
			$('#loadingAjax').addClass('overlay_loading');
			$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
			$.ajax({
				type:'POST',
				data:$("#filter-rekap").serialize(),
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/show-data",
				success:function(result)
				{
					$('#table-div').html(result);
					$('body').removeClass('noscroll');
					$('#loadingAjax').html('');
					$('#loadingAjax').removeClass('overlay_loading');
					rekap_datatable();
					rekap_datatable_detail();
				},
				error: function() {
					$('#loadingAjax').html('');
					$('body').removeClass('noscroll');
					$('#loadingAjax').removeClass('overlay_loading');
					document.getElementById("errordiv").html('<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Terjadi Kesalahan</div>');
				}
			});
		});
	});

	$('#submit-filter-no-induk-bobot').click(function(){
			$('.alert').alert('close');
			$('body').addClass('noscroll');
			$('#loadingAjax').addClass('overlay_loading');
			$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
			$.ajax({
				type:'POST',
				data:$("#filter-rekap-bobot").serialize(),
				url:baseurl+"RekapTIMSPromosiPekerja/RekapBobot/tampilkanData",
				success:function(result)
				{
					$('#table-div').html(result);
					$('body').removeClass('noscroll');
					$('#loadingAjax').html('');
					$('#loadingAjax').removeClass('overlay_loading');
					rekap_datatable();
					rekap_datatable_detail();
				},
				error: function() {
					$('body').removeClass('noscroll');
					$('#loadingAjax').html('');
					$('#loadingAjax').removeClass('overlay_loading');
					document.getElementById("errordiv").html = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Terjadi Kesalahan</div>';
				}
			});
		});

	//---------------------------------REKAP TIMS.end-------------------------------
function rekap_datatable() {
	var rekap_table = $('#rekap-tims').DataTable({
		responsive: false,
		scrollCollapse: true,
		"lengthChange": false,
		/*"dom": '<"pull-left"f>tp',*/
		"info": false,
		language: {
			search: "_INPUT_",
		},
		dom: 'Bfrtip',
		buttons: [
			'excel'
		],
	});
	$('.dataTables_filter input[type="search"]').css(
		{'width':'400px','display':'inline-block'}
	);
	$('#rekap-tims_filter input').attr("placeholder", "Search...")
}

function rekap_datatable_detail() {
	var rekap_table_detail = $('#rekap-tims-detail').DataTable({
		responsive: false,
		"scrollX": true,
		scrollY: "400px",
		scrollCollapse: true,
		"lengthChange": true,
		/*"dom": '<"pull-left"f>tp',*/
		"info": false,
		language: {
			search: "_INPUT_",
		},
		dom: 'Bfrtip',
		buttons: [
			'excel'
		],
	});
	$('.dataTables_filter input[type="search"]').css(
		{'width':'400px','display':'inline-block'}
	);
	$('#rekap-tims-detail_filter input').attr("placeholder", "Search...")
}
//$(document).ready(function(){
	rekap_datatable();
	rekap_datatable_detail();
//});

// 	Rekap Absensi Pekerja, Jam Kerja, Absensi Manual, Data Presensi-TIM, Sinkronisasi Konversi Presensi
//	{
		$(function()
		{
			// 	DataTables
			//	{
					// $('.RekapTIMS-DaftarPresensiHarian').DataTable({
					// 	// lengthChange: false,
					// 	searching: false,
						// dom: 'Bfrtip',
						// buttons: [
						// 	'excel', 'print'
						// ],
						// scrollX: true,
					// 	// scrollY: 400,
					// 	lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					// });
					$('.RekapAbsensiManual-Daftar').DataTable({
						dom: 'Bfrtip',
						buttons: [
							'excel',
							{
								extend: 'pdfHtml5',
								orientation: 'landscape',
								pageSize: 'A2',
							}
						],
						scrollX: true,
						// scrollY: 400,
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					});

					$('.RekapDataPresensiTIM-Daftar').DataTable({
						dom: 'Bfrtip',
						buttons: [
							'excel',
							{
								extend: 'pdfHtml5',
								orientation: 'landscape',
								pageSize: 'A4',
							}
						],
						// scrollY: 400,
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					});

					$('.RekapTIMS-StatistikPresensiHarian').DataTable({
						searching: false,
						lengthChange: false,
					});

					$('#RekapJamKerja-hasil').DataTable({
						lengthChange: true,
						scrollX: true,
						dom: 'Bfrtip',
						buttons: [
							'excel'
						],
					});

					$('.SinkronisasiKonversiPresensi-data').DataTable({
						lengthChange: true,
						scrollX: true,
						dom: 'Bfrtip',
						buttons: [
							'excel'
						],
					});

			//	}

			//	DateRangePicker
			//	{
					$('.RekapAbsensi-daterangepicker').daterangepicker({
					    "showDropdowns": true,
					    "autoApply": true,
					    "locale": {
					        "format": "YYYY-MM-DD",
					        "separator": " - ",
					        "applyLabel": "OK",
					        "cancelLabel": "Batal",
					        "fromLabel": "Dari",
					        "toLabel": "Hingga",
					        "customRangeLabel": "Custom",
					        "weekLabel": "W",
					        "daysOfWeek": [
					            "Mg",
					            "Sn",
					            "Sl",
					            "Rb",
					            "Km",
					            "Jm",
					            "Sa"
					        ],
					        "monthNames": [
					            "Januari",
					            "Februari",
					            "Maret",
					            "April",
					            "Mei",
					            "Juni",
					            "Juli",
					            "Agustus ",
					            "September",
					            "Oktober",
					            "November",
					            "Desember"
					        ],
					        "firstDay": 1
					    }
					}, function(start, end, label) {
					  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
					});

					$('.RekapDataPresensiTIM-daterangepicker').daterangepicker({
					    "showDropdowns": true,
					    "autoApply": true,
					    "locale": {
					        "format": "YYYY-MM-DD",
					        "separator": " - ",
					        "applyLabel": "OK",
					        "cancelLabel": "Batal",
					        "fromLabel": "Dari",
					        "toLabel": "Hingga",
					        "customRangeLabel": "Custom",
					        "weekLabel": "W",
					        "daysOfWeek": [
					            "Mg",
					            "Sn",
					            "Sl",
					            "Rb",
					            "Km",
					            "Jm",
					            "Sa"
					        ],
					        "monthNames": [
					            "Januari",
					            "Februari",
					            "Maret",
					            "April",
					            "Mei",
					            "Juni",
					            "Juli",
					            "Agustus ",
					            "September",
					            "Oktober",
					            "November",
					            "Desember"
					        ],
					        "firstDay": 1
					    }
					}, function(start, end, label) {
					  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
					});

					$('.SinkronisasiKonversiPresensi-daterangepicker').daterangepicker({
					    "showDropdowns": true,
					    "autoApply": true,
					    "locale": {
					        "format": "YYYY-MM-DD",
					        "separator": " - ",
					        "applyLabel": "OK",
					        "cancelLabel": "Batal",
					        "fromLabel": "Dari",
					        "toLabel": "Hingga",
					        "customRangeLabel": "Custom",
					        "weekLabel": "W",
					        "daysOfWeek": [
					            "Mg",
					            "Sn",
					            "Sl",
					            "Rb",
					            "Km",
					            "Jm",
					            "Sa"
					        ],
					        "monthNames": [
					            "Januari",
					            "Februari",
					            "Maret",
					            "April",
					            "Mei",
					            "Juni",
					            "Juli",
					            "Agustus ",
					            "September",
					            "Oktober",
					            "November",
					            "Desember"
					        ],
					        "firstDay": 1
					    }
					}, function(start, end, label) {
					  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
					});
			//	}

			//	Select2
			//	{
					$('#SinkronisasiKonversiPresensi-cmbKodeStatusKerja').select2(
					{
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/kode_status_kerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.fs_noind, text: obj.fs_noind +' - '+obj.fs_ket};
									})
								}
							}
						}
					});

					$('#SinkronisasiKonversiPresensi-cmbNoind').select2(
					{
						minimumInputLength: 3,
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/pekerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.noind, text: obj.noind +' - '+obj.nama};
									})
								}
							}
						}
					});

					$('#SinkronisasiKonversiPresensi-cmbKodeShift').select2(
					{
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/kode_shift',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kd_shift, text: obj.kd_shift +' - '+obj.shift};
									})
								}
							}
						}
					});

					$('#SinkronisasiKonversiPresensi-cmbKodesie').select2(
					{
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/kodesie',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kodesie, text: obj.kodesie +' - '+obj.nama_kodesie};
									})
								}
							}
						}
					});

					$('#SinkronisasiKonversiPresensi-cmbLokasiKerja').select2(
					{
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/lokasi_kerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_, text: obj.id_ +' - '+obj.lokasi_kerja};
									})
								}
							}
						}
					});

					$('#SinkronisasiKonversiPresensi-cmbJabatan').select2(
					{
						allowClear: true,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/jabatan',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kd_jabatan, text: obj.kd_jabatan +' - '+obj.jabatan};
									})
								}
							}
						}
					});

					$('.RekapAbsensi-cmbDepartemen').select2(
					{
						minimumResultsForSearch: 0,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarDepartemen',
							dataType: 'json',
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										// if (obj.kode_departemen == '2') {
										// 	return {id: obj.kode_departemen, text: obj.nama_departemen, disabled: true};
										// }
										return {id: obj.kode_departemen, text: obj.nama_departemen};
									})
								}
							}
						}
					});

					$('.RekapAbsensi-cmbLokasiKerja').select2(
					{
						minimumResultsForSearch: 0,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarLokasiKerja',
							dataType: 'json',
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_, text: obj.id_ +' - '+obj.lokasi_kerja};
									})
								}
							}
						}
					});

					$('.RekapJamKerja-cmbLokasiKerja').select2(
					{
						minimumResultsForSearch: 0,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RekapJamKerja/daftarLokasiKerja',
							dataType: 'json',
							type: "GET",
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_lokasi_kerja, text: obj.kode_lokasi_kerja +' - '+obj.nama_lokasi_kerja};
									})
								}
							}
						}
					});

					$(document).on('change', '.RekapAbsensi-cmbDepartemen', function(){
						var departemen =	$(this).val();
						// alert(departemen);
						if(departemen=='0')
						{
							$('.RekapAbsensi-cmbBidang').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbUnit').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('.RekapAbsensi-cmbBidang').attr('disabled', 'true');
							$('.RekapAbsensi-cmbUnit').attr('disabled','true');
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');							
						}
						else
						{
							$('.RekapAbsensi-cmbBidang').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbUnit').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('.RekapAbsensi-cmbBidang').removeAttr('disabled');
							$('.RekapAbsensi-cmbUnit').removeAttr('disabled');
							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');								

							$('.RekapAbsensi-cmbBidang').select2(
							{
								minimumResultsForSearch: 0,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarBidang',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											departemen: departemen
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_bidang, text: obj.nama_bidang};
											})
										}
									}
								}
							});							
						}
					});

					$(document).on('change', '.RekapAbsensi-cmbBidang', function(){
						var bidang =	$(this).val();

						if(bidang.substr(bidang.length - 2) == '00')
						{
							$('.RekapAbsensi-cmbUnit').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('.RekapAbsensi-cmbUnit').attr('disabled','true');
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');
						}
						else
						{
							$('.RekapAbsensi-cmbUnit').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('.RekapAbsensi-cmbUnit').removeAttr('disabled');
							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');

							$('.RekapAbsensi-cmbUnit').select2(
							{
								minimumResultsForSearch: 0,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarUnit',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											bidang: bidang
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_unit, text: obj.nama_unit};
											})
										}
									}
								}
							});												
						}
					});

					$(document).on('change', '.RekapAbsensi-cmbUnit', function(){
						var unit =	$(this).val();

						if(unit.substr(unit.length - 2) == '00')
						{
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');
						}
						else
						{
							$('.RekapAbsensi-cmbSeksi').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');							

							$('.RekapAbsensi-cmbSeksi').select2(
							{
								minimumResultsForSearch: 0,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarSeksi',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											unit: unit
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_seksi, text: obj.nama_seksi};
											})
										}
									}
								}
							});
						}
					});

					$('#RekapDataPresensiTIM-cmbKeteranganPresensi').select2(
					{
						minimumInputLength: 1,
						delay: 500,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RekapDataPresensiTim/daftar_keterangan_presensi',
							dataType: 'json',
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kd_ket, text: obj.keterangan};
									})
								}
							}
						}
					});

					$('#RekapDataPresensiTIM-cmbPekerja').select2(
					{
						minimumInputLength: 3,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RekapDataPresensiTim/pekerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.noind, text: obj.noind + ' - ' + obj.nama};
									})
								}
							}
						}
					});
			//	}
		});

		//	Individual Functions
		//	{
				$(document).ready(function() {
					    // Setup - add a text input to each footer cell
					    $('.RekapTIMS-DaftarPresensiHarian tfoot th').each( function () {
					        var title = $(this).text();
					        $(this).html( '<input type="text" placeholder="Cari '+title+'" />' );
					    } );
					 
					    // DataTable
					    var table = $('.RekapTIMS-DaftarPresensiHarian').DataTable({
					    	ordering: true,
					    	dom: 'Bfrtip',
							buttons: [
								'excel', 'print'
							],
							scrollX: true,
					    });
					 
					    // Apply the search
					    table.columns().every( function () {
					        var that = this;
					        console.log($( 'input', this.footer() ));
					        $( 'input', this.footer() ).on( 'keyup change', function () {
					            if ( that.search() !== this.value ) {
					                that
					                    .search( this.value )
					                    .draw();
					            }
					        } );
					    } );
					} );
		//	}
//	}

// 	Rekap Riwayat Mutasi Pekerja
//	{
		$(function()
		{
			//	Datatables
			//	{
					$('#RekapRiwayatMutasi-hasil').DataTable({
						lengthChange: true,
						scrollX: true,
						dom: 'Bfrtip',
						buttons: [{
							extend: 'excel',
							customizeData: function(data) {
								for(var i = 0; i < data.body.length; i++) {
									for(var j = 0; j < data.body[i].length; j++) {
										data.body[i][j] = '\u200C' + data.body[i][j];
									}
								}
							}
						}],
					});
			//	}

			//	Select2
			//	{
					$('#RekapRiwayatMutasi-daftarNomorInduk').select2(
					{
						minimumInputLength: 3,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarPekerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.noind, text: obj.noind + ' - ' + obj.nama};
									})
								}
							}
						}
					});

					$('.RekapRiwayatMutasi-daftarLokasiKerja').select2(
					{
						minimumInputLength: -1,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarLokasiKerja',
							dataType: 'json',
							delay: 500,
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_, text: obj.id_ + ' - ' + obj.lokasi_kerja};
									})
								}
							}
						}
					});

					$('#RekapRiwayatMutasi-cmbDepartemenLama').select2(
					{
						minimumResultsForSearch: -1,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarDepartemen',
							dataType: 'json',
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_departemen, text: obj.kode_departemen + ' | ' +obj.nama_departemen};
									})
								}
							}
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbDepartemenLama', function(){
						var departemen =	$(this).val();
						if(departemen=='0')
						{
							$('#RekapRiwayatMutasi-cmbBidangLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbUnitLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbBidangLama').attr('disabled', 'true');
							$('#RekapRiwayatMutasi-cmbUnitLama').attr('disabled','true');
							$('#RekapRiwayatMutasi-cmbSeksiLama').attr('disabled','true');							
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbBidangLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbUnitLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbBidangLama').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbUnitLama').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbSeksiLama').removeAttr('disabled');								

							$('#RekapRiwayatMutasi-cmbBidangLama').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarBidang',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											departemen: departemen
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_bidang, text: obj.kode_bidang + ' | ' + obj.nama_bidang};
											})
										}
									}
								}
							});							
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbBidangLama', function(){
						var bidang =	$(this).val();

						if(bidang.substr(bidang.length - 2) == '00')
						{
							$('#RekapRiwayatMutasi-cmbUnitLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbUnitLama').attr('disabled','true');
							$('#RekapRiwayatMutasi-cmbSeksiLama').attr('disabled','true');
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbUnitLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbUnitLama').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbSeksiLama').removeAttr('disabled');

							$('#RekapRiwayatMutasi-cmbUnitLama').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarUnit',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											bidang: bidang
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_unit, text: obj.kode_unit + ' | ' + obj.nama_unit};
											})
										}
									}
								}
							});												
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbUnitLama', function(){
						var unit =	$(this).val();

						if(unit.substr(unit.length - 2) == '00')
						{
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							
							$('#RekapRiwayatMutasi-cmbSeksiLama').attr('disabled','true');
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbSeksiLama').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbSeksiLama').removeAttr('disabled');							

							$('#RekapRiwayatMutasi-cmbSeksiLama').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarSeksi',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											unit: unit
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_seksi, text: obj.kode_seksi + ' | ' + obj.nama_seksi};
											})
										}
									}
								}
							});
						}
					});

					$('#RekapRiwayatMutasi-cmbDepartemenBaru').select2(
					{
						minimumResultsForSearch: -1,
						allowClear: false,
						ajax:
						{
							url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarDepartemen',
							dataType: 'json',
							data: function(params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_departemen, text: obj.kode_departemen + ' | ' +obj.nama_departemen};
									})
								}
							}
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbDepartemenBaru', function(){
						var departemen =	$(this).val();
						if(departemen=='0')
						{
							$('#RekapRiwayatMutasi-cmbBidangBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbUnitBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbBidangBaru').attr('disabled', 'true');
							$('#RekapRiwayatMutasi-cmbUnitBaru').attr('disabled','true');
							$('#RekapRiwayatMutasi-cmbSeksiBaru').attr('disabled','true');							
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbBidangBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbUnitBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbBidangBaru').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbUnitBaru').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbSeksiBaru').removeAttr('disabled');								

							$('#RekapRiwayatMutasi-cmbBidangBaru').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarBidang',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											departemen: departemen
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_bidang, text: obj.kode_bidang + ' | ' + obj.nama_bidang};
											})
										}
									}
								}
							});							
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbBidangBaru', function(){
						var bidang =	$(this).val();

						if(bidang.substr(bidang.length - 2) == '00')
						{
							$('#RekapRiwayatMutasi-cmbUnitBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbUnitBaru').attr('disabled','true');
							$('#RekapRiwayatMutasi-cmbSeksiBaru').attr('disabled','true');
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbUnitBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbUnitBaru').removeAttr('disabled');
							$('#RekapRiwayatMutasi-cmbSeksiBaru').removeAttr('disabled');

							$('#RekapRiwayatMutasi-cmbUnitBaru').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarUnit',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											bidang: bidang
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_unit, text: obj.kode_unit + ' | ' + obj.nama_unit};
											})
										}
									}
								}
							});												
						}
					});

					$(document).on('change', '#RekapRiwayatMutasi-cmbUnitBaru', function(){
						var unit =	$(this).val();

						if(unit.substr(unit.length - 2) == '00')
						{
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });
							
							$('#RekapRiwayatMutasi-cmbSeksiBaru').attr('disabled','true');
						}
						else
						{
							$('#RekapRiwayatMutasi-cmbSeksiBaru').each(function () { //added a each loop here
						        $(this).select2('destroy').val("").select2();
						    });

							$('#RekapRiwayatMutasi-cmbSeksiBaru').removeAttr('disabled');							

							$('#RekapRiwayatMutasi-cmbSeksiBaru').select2(
							{
								minimumResultsForSearch: -1,
								ajax:
								{
									url: baseurl+'RekapTIMSPromosiPekerja/RiwayatMutasi/daftarSeksi',
									dataType: 'json',
									data: function(params){
										return {
											term: params.term,
											unit: unit
										}
									},
									processResults: function (data){
										return {
											results: $.map(data, function(obj){
												return {id: obj.kode_seksi, text: obj.kode_seksi + ' | ' + obj.nama_seksi};
											})
										}
									}
								}
							});
						}
					});

			//	}

			//	Form Behaviour
			//	{
				    $(document).ready(function () {
				            $('.form-check-input2').prop('disabled', true);
				            $('.form-check-input1').prop('disabled', true); 
				            $('.form-check-input3').prop('disabled', true); 
				            $('.form-check-input4').prop('disabled', true); 
				    $('.mencoba').click(function () {
				    	// alert('a');
				            $('.form-check-input1').prop('disabled', false);
				            $('.form-check-input1').iCheck('check');
				            $('.form-check-input2').iCheck('uncheck');
				            $('.form-check-input3').iCheck('uncheck');
				            $('.form-check-input3').prop('disabled', true);
				            $('.form-check-input2').prop('disabled', true);
				            $('.form-check-input4').iCheck('uncheck');
				            $('.form-check-input4').prop('disabled', true);
				    });
				    $('.mencoba2').click(function () { 
				            $('.form-check-input2').prop('disabled', false);
				            $('.form-check-input2').iCheck('check');
				            $('.form-check-input1').iCheck('uncheck');
				            $('.form-check-input3').iCheck('uncheck');
				            $('.form-check-input3').prop('disabled', true);
				            $('.form-check-input1').prop('disabled', true);
				            $('.form-check-input4').iCheck('uncheck');
				            $('.form-check-input4').prop('disabled', true); 

				    });
				        $('.mencoba3').click(function () {   
				            $('.form-check-input3').prop('disabled', false);  
				            $('.form-check-input3').iCheck('check');
				            $('.form-check-input1').iCheck('uncheck');
				            $('.form-check-input2').iCheck('uncheck');
				            $('.form-check-input2').prop('disabled', true);
				            $('.form-check-input1').prop('disabled', true); 
				            $('.form-check-input4').iCheck('uncheck');
				            $('.form-check-input4').prop('disabled', true);
				    });
				        $('.mencoba4').click(function () {   
				            $('.form-check-input3').prop('disabled', true);  
				            $('.form-check-input3').iCheck('uncheck');
				            $('.form-check-input1').iCheck('uncheck');
				            $('.form-check-input2').iCheck('uncheck');
				            $('.form-check-input2').prop('disabled', true);
				            $('.form-check-input1').prop('disabled', true); 
				            $('.form-check-input4').iCheck('check');
				            $('.form-check-input4').prop('disabled', false);
				    });
				});

					$('#RekapRiwayatMutasi-radioJenisPencarian-noind').click(function()
					{
						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('disabled', true);
						$('#rekapBegin').prop('disabled', true);
						$('#rekapEnd').prop('disabled', true);

						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', true);
          				$('input[name="radioJenisPencarian"]').removeClass("btn-default");
			            $('input[name="radioJenisPencarian"]').removeClass("btn-primary");
			            $('input[name="radioJenisPencarian"]').addClass("btn-default");
						$(this).removeClass("btn-default");
          				$(this).addClass("btn-primary");
          				// $('input[class="form-check-input"]').iCheck('check');
						/*$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('required', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('required', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('required', false);*/
					});

					$('#RekapRiwayatMutasi-radioJenisPencarian-seksi').click(function()
					{
						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('disabled', false);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('disabled', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('disabled', true);
						$('#rekapBegin').prop('disabled', true);
						$('#rekapEnd').prop('disabled', true);

						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', true);
          				$('input[name="radioJenisPencarian"]').removeClass("btn-default");
			            $('input[name="radioJenisPencarian"]').removeClass("btn-primary");
			            $('input[name="radioJenisPencarian"]').addClass("btn-default");
						$(this).removeClass("btn-default");
          				$(this).addClass("btn-primary");
						/*$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('required', true);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('required', true);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('required', true);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('required', true);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('required', true);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('required', true);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('required', true);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('required', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('required', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('required', false);*/
					});

					$('#RekapRiwayatMutasi-radioJenisPencarian-lokasikerja').click(function()
					{
						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('disabled', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('disabled', false);
						$('#rekapBegin').prop('disabled', true);
						$('#rekapEnd').prop('disabled', true);

						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', true);
          				$('input[name="radioJenisPencarian"]').removeClass("btn-default");
			            $('input[name="radioJenisPencarian"]').removeClass("btn-primary");
			            $('input[name="radioJenisPencarian"]').addClass("btn-default");
						$(this).removeClass("btn-default");
          				$(this).addClass("btn-primary");
						/*$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('required', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('required', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('required', true);*/
					});
					$('#RekapRiwayatMutasi-radioJenisPencarian-periode').click(function()
					{
						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('disabled', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('disabled', true);
						$('#rekapBegin').prop('disabled', false);
						$('#rekapEnd').prop('disabled', false);

						$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', true);
          				$('input[name="radioJenisPencarian"]').removeClass("btn-default");
			            $('input[name="radioJenisPencarian"]').removeClass("btn-primary");
			            $('input[name="radioJenisPencarian"]').addClass("btn-default");
						$(this).removeClass("btn-default");
          				$(this).addClass("btn-primary");
						/*$('#RekapRiwayatMutasi-daftarNomorInduk').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbDepartemenBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbBidangBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbUnitBaru').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiLama').prop('required', false);
						$('#RekapRiwayatMutasi-cmbSeksiBaru').prop('required', false);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaLama').prop('required', true);
						$('#RekapRiwayatMutasi-daftarLokasiKerjaBaru').prop('required', true);*/
					});
					
			//	}
		});
		//	Individual Functions
		//	{
		
			$(function () {
				$('#er-status').select2();
				$(document).on('ifChecked', '#er_all', function(event) {
				 // alert('done'); 
				// $("select").select2('destroy').val("").select2();
				// $('#your_select_input').val([]);
				// $("#er-status").text("");
				 // $('#er-status').select2().val(null).trigger("change");
				 $("#er-status").each(function () { //added a each loop here
			        $(this).select2('val', '');
			    });
				 $('#er-status').prop('disabled',true);
				});
				$(document).on('ifUnchecked', '#er_all', function(event) {
				 // alert('done'); 
				 $('#er-status').prop('disabled',false);
				});
			});

		//	}
//	}