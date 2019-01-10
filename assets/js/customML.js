$(document).ready(function(){

	$('#detailLppbNumber').DataTable({
		"pageLength": 10,
        "paging": true,
        "searching": true
	});

	$('#btnSearchNomorLPPB').click(function(){
		// $('#loading_search').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading3.gif'/><br /></center><br />");
		var lppb_number =  $('#lppb_number').val();

		$.ajax({
			type: "POST",
			url : baseurl+"MonitoringLPPB/ListBatch/addNomorLPPB",
			data : {
				lppb_number : lppb_number,
			},
			dataType:'json',
			success: function(response){
				var datanya = ['lppb_number[]','vendor_name','po_number','tanggal_lppb'];
				var ct = $('#tabelNomorLPPB').children('tbody').children('tr').length;
				var row='';
				var td = '';

				row += '<tr id="row-'+ct+'">';
				row += '<td>'+(ct+1)+'</td>';
				row += '<td><input name="lppb_number[]" type="text" class="form-control" value="'+response[0]['LPPB_NUMBER']+'"></td>';
				row += '<td><input name="vendor_name" type="text" class="form-control" value="'+response[0]['VENDOR_NAME']+'"></td>';
				row += '<td><input name="tanggal_lppb" type="text" class="form-control" value="'+response[0]['TANGGAL_LPPB']+'"></td>';
				row += '<td><input name="po_number" type="text" class="form-control" value="'+response[0]['PO_NUMBER']+'"></td>';
				row += '<td><input name="status_detail" type="text" class="form-control" value="0"></td>';
				row += '<td>';
				row += '<button type="button" class="btn btn-danger btnDeleteRow"><i class="glyphicon glyphicon-trash"></i></button>';
				row += '</td>';
				row += '</tr>';

				$('#tabelNomorLPPB').append(row);

				$('.btnDeleteRow').on('click', function(){
					var cfrm = confirm('Yakin menghapusnya?');
					var th = $(this);
					if (cfrm) {
						th.parent('td').parent('tr').remove();
					}else{
						alert('Hapus dibatalkan');
					}
				});
			}
		});
	});

	$('#btn_search_lppb').click(function(){
		$('#loading_lppb').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading2.gif'/><br /></center><br />");

		var nama_vendor = $('#nama_vendor').val();
		var nomor_lppb = $('#nomor_lppb').val();
		var dateFrom = $('#dateFrom').val();
		var dateTo = $('#dateTo').val();
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingLppb/Tracking/btn_search",
			data: {
				nama_vendor: nama_vendor,
				nomor_lppb: nomor_lppb,
				dateFrom: dateFrom,
				dateTo: dateTo,
			},
			success: function (response) {
				$('#loading_lppb').html(response);
				$('#tabel_search_tracking_lppb').DataTable();
			}
		});
	})

	$('#table_tracking_lppb').DataTable({
		"pageLength": 10,
        "paging": true,
        "searching": true,
	});

	$('.dateFromAndTo').datepicker({
		format: 'd/m/yyyy',
		autoclose: true,
	});

	$('#save_lppb').click(function(){
		alert('Berhasil di edit');
	})

});

function actionLppbKasieGudang(th){
	var batch_detail_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();

		prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
		
		if (proses == 3) {
			prnt.html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses" value="3"></span>');
		} else {
			prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses" value="4"></span>');
			prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
		}
}

function actionLppbNumber(th){
	var batch_detail_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();

		prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
		
		if (proses == 6) {
			prnt.html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses" value="6"></span>');
		} else {
			prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses" value="7"></span>');
			prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
		}
}

function btnDeleteLppb(th){
	var num = $(this).attr('rownum');
	var batch_detail_id = $('.batch_detail_id_'+num).val();
	// alert(batch_detail_id);
	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringLPPB/ListBatch/deleteLppbNumber",
		data: {
			batch_detail_id: batch_detail_id
		},
		success: function(response){
			// alert(response);
			var conf = confirm('Yakin untuk menghapusnya?');
			var th = $(this);
			if (conf) {
				th.parent('td').parent('tr').remove();
			}else{
				th.parent('td').parent('tr').prepend();
			}
			
		}
	})
}

function del_batch_number(th){
	var num = th.attr('row_id');
	var batch_number = $('.batch_number_'+num).val();

	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringLPPB/ListBatch/deleteNumberBatch",
		data: {
			batch_number: batch_number
		},
		success: function(response){
			// alert(batch_number);
			var conf = confirm('Yakin untuk menghapusnya?');
			if (conf) {
				th.parent('td').parent('tr').remove();
			}else{
				th.parent('td').parent('tr').prepend();
			}
		}
	})
}

function getBtch(th) {
	var batch_number = $(th).attr('data-btch');	
	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringLPPB/ListBatch/submitToKasieGudang",
		data:{
			batch_number: batch_number
		},
		success: function(response) {
			$('#mdlSubmitToKasieGudang').modal('show');
			$('#id_batch').text(batch_number);
			$('#btnYes').click(function() {
				$('#mdlSubmitToKasieGudang').modal('hide');
				$('#mdlChecking').modal('show');
				$('#id_ok').text(batch_number);
				$('#btnClose').click(function(){
					$('#mdlChecking').modal('hide');
					window.location.reload();
				})
			});
		}
	})
}

function submitToKasie(th){
	var batch_number = $(th).attr('data-id');

	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLppbKasieGudang/Unprocess/SubmitKeAKuntansi",
		data:{
			batch_number: batch_number
		},
		success: function(response){
			$('#mdlSubmitToKasieAkuntansi').modal('show');
			$('#id').text(batch_number);
			$('#mdlYesAkt').click(function(){
				$('#mdlSubmitToKasieAkuntansi').modal('hide');
				window.location.reload();
			})
		}
	})
}