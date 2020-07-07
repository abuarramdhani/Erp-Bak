$(document).ready(function () {
	$(".getkodebrg").select2({
			allowClear: true,
			// minimumInputLength: 2,
			ajax: {
					url: baseurl + "MonitoringCuttingTool/SettingMin/getitem",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.ITEM, text:obj.ITEM+' - '+obj.DESCRIPTION};
									})
							};
					}
			}
	});

});

function monitoringcuttingtool(th) {
	$('#datacuttingtool').removeAttr("onmouseover");
	$.ajax({
		url: baseurl + 'MonitoringCuttingTool/Monitoring/mon_cuttingtool',
		type: 'POST',
		beforeSend: function() {
		  $('div#tb_moncuttol' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading4.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_moncuttol').html(result);
			$('#tblcutting').DataTable({
			"scrollX" : true,
			"columnDefs": [{
				"targets": '_all',
			}],
			});
		}
	})
}


function monitoringtransaksi(th) {
	$('#datatransaksi').removeAttr("onmouseover");
	$.ajax({
		url: baseurl + 'MonitoringCuttingTool/MonitoringTransaksi/cuttingtoolbaru',
		type: 'POST',
		beforeSend: function() {
		$('div#tb_baru' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_baru').html(result);
		}
	})

	$.ajax({
		url: baseurl + 'MonitoringCuttingTool/MonitoringTransaksi/cuttingtoolresharp',
		type: 'POST',
		beforeSend: function() {
		  $('div#tb_resharp' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_resharp').html(result);
		}
	})

	$.ajax({
		url: baseurl + 'MonitoringCuttingTool/MonitoringTransaksi/cuttingtooltumpul',
		type: 'POST',
		beforeSend: function() {
			$('div#tb_tumpul' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_tumpul').html(result);
		}
	})
}

function mdleditminmax(no) {
	var item = $('#item'+no).val();
	var min = $('#min'+no).val();
	var max = $('#max'+no).val();
	
    var request = $.ajax({
        url: baseurl+'MonitoringCuttingTool/SettingMin/EditMinmax',
        data: {
            item : item, min : min, max : max
        },
        type: "POST",
        datatype: 'html'
	});
	
    request.done(function(result){
        $('#datamdlminmax').html(result);
        $('#mdlminmaxCutt').modal('show');
    });
}

function tambahdata(no) {	
    var request = $.ajax({
        url: baseurl+'MonitoringCuttingTool/SettingMin/Tambah',
        type: "POST",
        datatype: 'html'
	});
	
    request.done(function(result){
        $('#datamdlminmax').html(result);
				$('#mdlminmaxCutt').modal('show');
				$(".getkodebrg").select2({
					allowClear: true,
					// minimumInputLength: 2,
					ajax: {
							url: baseurl + "MonitoringCuttingTool/SettingMin/getitem",
							dataType: 'json',
							type: "GET",
							data: function (params) {
									var queryParameters = {
											term: params.term,
									}
									return queryParameters;
							},
							processResults: function (data) {
									// console.log(data);
									return {
											results: $.map(data, function (obj) {
													return {id:obj.ITEM, text:obj.ITEM+' - '+obj.DESCRIPTION};
											})
									};
							}
					}
				});
    });
}

