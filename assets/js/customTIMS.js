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
		$('#departemen_select').change(function(){
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
			minimumInputLength: 0,
			ajax: {		
				url:baseurl+"RekapTIMSPromosiPekerja/GetNoInduk",
				dataType: 'json',
				type: "GET",
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
		responsive: true,
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
		responsive: true,
		"scrollX": true,
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
	$('#rekap-tims-detail_filter input').attr("placeholder", "Search...")
}
//$(document).ready(function(){
	rekap_datatable();
	rekap_datatable_detail();
//});
