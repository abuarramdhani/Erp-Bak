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
					document.getElementById("errordiv").html = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Terjadi Kesalahan</div>';
				}
			});
		});
	});

	//---------------------------------REKAP TIMS.end-------------------------------
function rekap_datatable() {
	var rekap_table = $('#rekap-tims').DataTable({
		responsive: false,
		scrollCollapse: true,
		"lengthChange": false,
		"dom": '<"pull-left"f>tp',
		"info": false,
		language: {
			search: "_INPUT_",
		},
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
		"dom": '<"pull-left"f>tp',
		"info": false,
		language: {
			search: "_INPUT_",
		},
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

// 	Rekap Absensi Pekerja
//	{
		$(function()
		{
			// 	DataTables
			//	{
					$('.RekapTIMS-DaftarPresensiHarian').DataTable({
						// lengthChange: false,
						dom: 'Bfrtip',
						buttons: [
							'excel', 'print'
						],
						scrollX: true,
						// scrollY: 400,
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					});
					$('.RekapTIMS-StatistikPresensiHarian').DataTable({
						lengthChange: false,
						scrollX: false,
						scrollY: 76,
						// responsive: true,
						fixedColumns: {
							leftColumns: 4
						},
						pageLength: 5,
						lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
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
			//	}
			//	Select2
			//	{
					$('.RekapAbsensi-cmbDepartemen').select2(
					{
						minimumResultsForSearch: -1,
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
										return {id: obj.kode_departemen, text: obj.nama_departemen};
									})
								}
							}
						}
					});

					$(document).on('change', '.RekapAbsensi-cmbDepartemen', function(){
						var departemen =	$(this).val();
						if(departemen=='0')
						{
							$('.RekapAbsensi-cmbBidang').select2('val','');
							$('.RekapAbsensi-cmbUnit').select2('val','');
							$('.RekapAbsensi-cmbSeksi').select2('val','');

							$('.RekapAbsensi-cmbBidang').attr('disabled', 'true');
							$('.RekapAbsensi-cmbUnit').attr('disabled','true');
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');							
						}
						else
						{
							$('.RekapAbsensi-cmbBidang').select2('val','');
							$('.RekapAbsensi-cmbUnit').select2('val','');
							$('.RekapAbsensi-cmbSeksi').select2('val','');

							$('.RekapAbsensi-cmbBidang').removeAttr('disabled');
							$('.RekapAbsensi-cmbUnit').removeAttr('disabled');
							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');								

							$('.RekapAbsensi-cmbBidang').select2(
							{
								minimumResultsForSearch: -1,
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
							$('.RekapAbsensi-cmbUnit').select2('val','');
							$('.RekapAbsensi-cmbSeksi').select2('val','');

							$('.RekapAbsensi-cmbUnit').attr('disabled','true');
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');
						}
						else
						{
							$('.RekapAbsensi-cmbUnit').select2('val','');
							$('.RekapAbsensi-cmbSeksi').select2('val','');

							$('.RekapAbsensi-cmbUnit').removeAttr('disabled');
							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');

							$('.RekapAbsensi-cmbUnit').select2(
							{
								minimumResultsForSearch: -1,
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
							$('.RekapAbsensi-cmbSeksi').select2('val','');
							
							$('.RekapAbsensi-cmbSeksi').attr('disabled','true');
						}
						else
						{
							$('.RekapAbsensi-cmbSeksi').select2('val','');

							$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');							

							$('.RekapAbsensi-cmbSeksi').select2(
							{
								minimumResultsForSearch: -1,
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

			//	}
		});
//	}