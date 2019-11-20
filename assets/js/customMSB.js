function getMonitor(th) {
	$(document).ready(function(){
		var tgAwal = $('input[name="tgAwal"]').val();
		var tgAkhir = $('input[name="tgAkhir"]').val();
		var job = $('input[name="job"]').val();
		var namasubkont = $('select[name="namasubkont"]').val();
		var kompp = $('select[name="kompp"]').val();
		
		var request = $.ajax({
			url: baseurl+'MonitoringSubkont/Monitoring/search',
			data: {
				job : job,
				tgAwal : tgAwal,
				tgAkhir : tgAkhir,
				namasubkont : namasubkont,
				kompp : kompp
			},
			type: "POST",
			datatype: 'html'
		});
		
		$('#review').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );

		request.done(function(result){
			// console.log("sukses2");
			$('#review').html(result);
			// $('#pitikih').DataTable({
			// 	scrollX: true,
			// 	scrollY:  true,
			// 	paging:true,
			// 	info:false,
			// });
			// j
		});
	});		
}

function intine(th, no)
{ 	
	var title = $(th).text(); 	
	$('#detail'+no).slideToggle('slow'); 
}

function intinee(th, no, nomor)
{ 	
	var title = $(th).text(); 	
	$('#subdetail'+no+nomor).slideToggle('slow'); 

}
$(document).ready(function () {
	$("#searchasek").select2({
		allowClear: true,
		placeholder: "Nama Vendor",
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "MonitoringSubkont/Monitoring/sugesti",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.VENDOR_NAME,
							text: obj.VENDOR_NAME
						};
					})
				};
			}
		}
	});
});

$(document).ready(function () {
	$("#searchasekomp").select2({
		allowClear: true,
		placeholder: "Kode Assy",
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "MonitoringSubkont/Monitoring/sugesti2",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.ASSY,
							text: obj.ASSY
						};
					})
				};
			}
		}
	});
});


// ---------------------------------------------- SO --------------------------------------------------------------------//


$(document).ready(function () {
	$('#tgAwal').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true
	});
});

$(document).ready(function () {
	$('#tgAkhir').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true
	});
});

$(document).ready(function () {
	$("#searchhh").select2({
		allowClear: true,
		placeholder: "Nama Vendor",
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "MonitoringSubkont/SO/dropdowne",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.VENDOR_NAME,
							text: obj.VENDOR_NAME
						};
					})
				};
			}
		}
	});
});

$(document).ready(function () {
	$('#tgl1').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true
	});
});

$(document).ready(function () {
	$('#tgl2').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true
	});
});

function getSo(th) {
	$(document).ready(function(){
		
		var namavendor 	= $('select[name="namavendor"]').val();
		var tgl1 		= $('select[name="tgl1"]').val();
		var tgl2 		= $('select[name="tgl2"]').val();
		
		var request = $.ajax({
			url: baseurl+'MonitoringSubkont/SO/cari',
			data: {
				namavendor : namavendor,
				tgl1 : tgl1,
				tgl2 : tgl2
			},
			type: "POST",
			datatype: 'html'
		});
		
		$('#soreview').html('');
		$('#soreview').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );


		request.done(function(result){
			// console.log("sukses2");
			$('#soreview').html(result);
			$('#pitikih').DataTable({
				scrollX: true,
				scrollY:  true,
				paging:true,
				info:false,
			});
		});
	});		
}

function moreinfo(th, no)
{ 	
	var title = $(th).text(); 	
	$('#inti'+no).slideToggle('slow'); 

}