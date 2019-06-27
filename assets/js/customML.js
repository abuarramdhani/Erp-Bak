$(document).ready(function(){
	$('.dtTableMl').DataTable({
		"paging": false,
		"info":     false,
		"language" : {
			"zeroRecords": " "             
		}
	})
	
	//autoload gudang di admin gudang
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/showGudang",
		data:{
			id_gudang: id_gd
		},
		success: function(response){
			//menampilkan gudang yang dipilih
			$('#showOptionLppb').html(response);
			$('#tabel_list_batch').DataTable({
				"paging": false,
				"info":     false,
				"language" : {
					"zeroRecords": " "             
				}
			});
		}
	})
	//autoload gudang di kasie gudang
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLppbKasieGudang/Unprocess/showGudangByKasie",
		data:{
			id_gudang: id_gd
		},
		success: function(response){
			//menampilkan gudang yang dipilih
			$('#showLppbKasieGudang').html(response);
		}
	})
	
	$('#lppb_number').on("keypress",function(e){
		if (e.keyCode == 13) {
			searchNumberLppb(this);
		}
	})
	$('#lppb_numberTo').on("keypress",function(e){
		if (e.keyCode == 13) {
			searchLppb(this);
		}
	})
	$('#btn_search_lppb').click(function(){
		$('#loading_lppb').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading2.gif'/><br /></center><br />");
		var nama_vendor = $('#nama_vendor').val();
		var nomor_lppb = $('#nomor_lppb').val();
		var dateFrom = $('#dateFromUw').val();
		var dateTo = $('#dateToUw').val();
		var nomor_po = $('#nomor_po').val();
		var inventory = $('#inventory').val();
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingLppb/Tracking/btn_search",
			data: {
				nama_vendor: nama_vendor,
				nomor_lppb: nomor_lppb,
				dateFrom: dateFrom,
				dateTo: dateTo,
				nomor_po: nomor_po,
				inventory: inventory
			},
			success: function (response) {
				$('#loading_lppb').html(response);
				$('#tabel_search_tracking_lppb').DataTable({
					"paging": false,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})
	$('#table_tracking_lppb').DataTable({
		"pageLength": 10,
		"paging": true,
		"searching": true,
	});
	$('.dateFromAndTo').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
	});
	$(document).on('click', 'td', function(){
		$(this).find("span[class~='editable']").hide();
		$(this).find("input[class~='editor']").fadeIn().focus();
	});
	$(document).on("keypress",".editor",function(e){
		if(e.keyCode == 13){
			var target = $(e.target);
			var lppb_number = target.val();
			var batch_detail_id = target.attr('data-id');
			$.ajax({
				type: "POST",
				url:baseurl+"MonitoringLPPB/ListBatch/editable",
				data: {
					batch_detail_id: batch_detail_id,
					lppb_number: lppb_number
				},
				success: function(response){
					$('#alert-muncul').slideDown(function() {
						setTimeout(function() {
							$('#alert-muncul').slideUp();
						}, 3000);
						$('.editable').fadeIn();
						$('.editor').hide();
					});
				}
			})
		}
	});
	$('#deleteAllRows').click(function(){
		var batch_number = $(this).val();
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/RejectLppb/deleteAllRows",
			data:{
				batch_number: batch_number
			},
			success: function(){
				$('.deleteAll').remove();
			}
		})
	})
	$(document).on('ifChanged', '.chkAllLppb', function(event) {
		if ($('.chkAllLppb').iCheck('update')[0].checked) {
			// alert('satu');
			$('.chkAllLppbNumber').each(function () {
				// $(this).prop('checked',true);
				$(this).iCheck('check');
			});
		}else{
			$('.chkAllLppbNumber').each(function () {
				// $(this).prop('checked',false);
				$(this).iCheck('uncheck');
			});
			// alert('dua');
		};
	})
});
function searchNumberLppb(th){
	$('#loading_search').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading3.gif'/><br /></center><br />");
	var lppb_number =  $('#lppb_number').val();
	var lppb_numberFrom =  $('#lppb_numberFrom').val();
	var inventory_organization = $('#inventory').val();
	$.ajax({
		type: "POST",
		url : baseurl+"MonitoringLPPB/ListBatch/addNomorLPPB",
		data : {
			lppb_number : lppb_number,
			lppb_numberFrom : lppb_numberFrom,
			inventory_organization : inventory_organization
		},
			// dataType:'json',
			success: function(response){
				$('#loading_search').html(response);
				$('#showTableLppb').DataTable({
					"paging":   false,
					"ordering": true,
					"info":     false	
				});
				var num = 0;
				$('#addLppbNumber').click(function(){
					var inputLppb = ['po_header_id[]','organization_id[]','organization_code[]', 'lppb_number[]', 'vendor_name[]', 'tanggal_lppb[]', 'po_number[]','status_lppb[]'];
					
					if (response != false) {
						$('.chkAllLppbNumber').each(function(){
							var html = '';
							if (this.checked) {
								var id_num = $(this).val();
								html += '<tr id="row-1">';
								$('tr#'+id_num).each(function(){
									num++;
									var col=0;
									$(this).find('td').each(function(){
										col++;
										if (col==1) {
											html+='<td>'+num+'</td>';
										}else{
											html+='<td><input style="width: 100%" name="'+inputLppb[(col-2)]+'" type="hidden" class="form-control '+inputLppb[(col-2)]+'" value="'+$(this).text()+'" row-num="'+num+'" readonly>';
											html+='<span>'+$(this).text()+'</span></td>';
										}
									});
								})
								html+='<td><button type="button" class="btnDeleteRow btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>'; 
								html+='</tr>'; 
								$('#tabelNomorLPPB').append(html);
								$('[name="po_header_id[]"],[name="organization_id[]"]').parent('td').hide();
							}
						})
					}else{
						alert('Nomor LPPB '+lppb_number+' tidak ditemukan');
					}
					
					$('.btnDeleteRow').on('click', function(){
						var cfrm = confirm('Yakin menghapusnya?');
						var th = $(this);
						if (cfrm) {
							th.parent('td').parent('tr').remove();
						}else{
							alert('Hapus dibatalkan');
						}
					});
				})
			}
		});
};
function actionLppbKasieGudang(th){
	var batch_detail_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 
	prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
	if (proses == 3) {
		prnt.html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Approve<input type="hidden" name="hdnProses[]" class="hdnProses" value="3"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
	} else {
		prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses" value="4"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
		prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
	}
}
function actionLppbNumber(th){
	var batch_detail_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 
	// alert(tanggal);
	
	prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
	if (proses == 6) {
		prnt.html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses" value="6"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
	} else {
		prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses" value="7"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
		prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
	}
}
function btnDeleteLppb(th){
	var num = th.attr('rownum');
	var batch_detail_id = $('.batch_detail_id_'+num).val();
	var conf = confirm('Yakin untuk menghapusnya?');
	// alert(num);
	if (conf == true) {
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/ListBatch/deleteLppbNumber",
			data: {
				batch_detail_id: batch_detail_id
			},
			success: function(response){
				th.parent('td').parent('tr').remove();
				return true;
			}
		})
	}else{
		alert('hapus di batalkan');
		return false;
	}
}
function del_batch_number(th){
	var num = th.attr('row_id');
	var batch_number = $('.batch_number_'+num).val();
	var conf = confirm('Yakin untuk menghapusnya?');
	if (conf == true) {
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/ListBatch/deleteNumberBatch",
			data: {
				batch_number: batch_number
			},
			success: function(response){
				th.parent('td').parent('tr').remove();
			}
		})
	}else{
		alert('hapus di batalkan');
		return false;
	}
}
function getBtch(th) {
	var batch_number = $(th).attr('data-id');	
	var group_batch = $(th).attr('data-batch');
	$('#group_batch').text(group_batch);	
	$('#mdlSubmitToKasieGudang').modal('show');
	$('#btnYes').click(function(argument) {
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/ListBatch/submitToKasieGudang",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				$('#mdlSubmitToKasieGudang').modal('hide');
				$('#group_batch2').text(group_batch);
				$('#mdlChecking').modal('show');
				$('#btnClose').click(function(){
					$('#mdlChecking').modal('hide');
					window.location.reload();
				})
			}
		})
	})
	
}
function submitToKasie(th){
	var batch_number = $(th).attr('data-id');
	var group_batch = $(th).attr('data-batch');
	$('#group_batch').text(group_batch);
	$('#mdlSubmitToKasieAkuntansi').modal('show');
	$('#mdlYesAkt').click(function(){
		$.ajax({
			type: "post",
			url: baseurl+"MonitoringLppbKasieGudang/Unprocess/SubmitKeAKuntansi",
			data:{
				batch_number: batch_number
			},
			success: function(response){
				window.location.reload();
			}
		})
	})
}
function getOptionGudang(th){
	var id_gudang = $(th).val();
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/showGudang",
		data:{
			id_gudang: id_gudang
		},
		success: function(response){
			//menampilkan gudang yang dipilih
			$('#showOptionLppb').html(response);
			$('#tabel_list_batch').DataTable({
				"paging": false,
				"info":     false,
				"language" : {
					"zeroRecords": " "             
				}
			});
		}
	})
}
function getOptionKasieGudang(th){
	var id_gudang = $(th).val();
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLppbKasieGudang/Unprocess/showGudangByKasie",
		data:{
			id_gudang: id_gudang
		},
		success: function(response){
			//menampilkan gudang yang dipilih
			$('#showLppbKasieGudang').html(response);
			$('#tabel_list_batch').DataTable({
				"paging": false,
				"info":     false,
				"language" : {
					"zeroRecords": " "             
				}
			});
		}
	})
}
function getOptionKasieAkt(th){
	var id_gudang = $(th).val();
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLppbAkuntansi/Unprocess/showGudangByAkuntansi",
		data:{
			id_gudang: id_gudang
		},
		success: function(response){
			//menampilkan gudang yang dipilih
			$('#unprocessakuntansi').html(response);
			$('#lppbgudangakt').DataTable({
				"paging": false,
				"info":     false,
				"language" : {
					"zeroRecords": " "             
				}
			});
		}
	})
}
function saveLPPBNumber(th){
	var lppb_info = $('#lppb_info').val();
	var id_gudang = $('#id_gudang').val();
	//array
	var arry = [];
	$('input[class~="lppb_number[]"]').each(function(){
		var lppb_number = $(this).val();
		arry.push(lppb_number);
	});
	str_arry = arry.join();
	var arry2 = [];
	$('input[class~="organization_id[]').each(function(){
		var organization_id = $(this).val();
		arry2.push(organization_id);
	});
	str_arry2 = arry2.join();
	var arry3 = [];
	$('input[class~="po_number[]').each(function(){
		var po_number = $(this).val();
		arry3.push(po_number);
	})
	str_arry3 = arry3.join();
	var arry5 = [];
	$('input[class~="po_header_id[]').each(function(){
		var po_header_id = $(this).val();
		arry5.push(po_header_id);
	})
	str_arry5 = arry5.join();
	// console.log(str_arry5);
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/saveLppbNumber",
		data:{
			lppb_info: lppb_info,
			id_gudang: id_gudang,
			lppb_number: str_arry,
			organization_id: str_arry2,
			po_number: str_arry3,
			po_header_id: str_arry5
		},
		// dataType: "json",
		success: function(response){
			// console.log(lppb_info,id_gudang,str_arry,str_arry2,str_arry3,str_arry5);
			window.location.reload();
			alert('Data sudah ditambahkan');
		}
	})
	
}
function saveEditLPPBNumber(th){
	var batch_number = $('#batch_number').val();
	var id_lppb = $('.row-id').length;
	// console.log(id_lppb);
	// var coba = $('td.lppb_number').text();
	// console.log("coba", coba);

	//array
	var arry = [];
	$('td[class~="lppb_number"]').each(function(){
		var lppb_number = $(this).text();
		arry.push(lppb_number);
	});
	console.log("lppb_number", arry);
	str_arry = arry.join();
	// console.log("coba string", str_arry);

	var arry2 = [];
	$('input[name~="org_id').each(function(){
		var organization_id = $(this).val();
		arry2.push(organization_id);
	});
	console.log("oi", arry2);
	str_arry2 = arry2.join();

	var arry3 = [];
	$('td[class~="po_number').each(function(){
		var po_number = $(this).html();
		arry3.push(po_number);
	});
	console.log("po-num", arry3);
	str_arry3 = arry3.join();

	// var arry4 = [];
	// $('input[class~="line_num[]').each(function(){
	// 	var line_num = $(this).val();
	// 	arry4.push(line_num);
	// })
	// str_arry4 = arry4.join();
	var arry5 = [];
	$('input[name~="po_header_id').each(function(){
		var po_header_id = $(this).val();
		arry5.push(po_header_id);
	});
	console.log("po-head", arry5);
	str_arry5 = arry5.join();

	var arry6 = [];
	$('input[name~="batch_detail_id').each(function(){
		var batch_detail_id = $(this).val();
		arry6.push(batch_detail_id);
	});
	console.log("batch", arry6);
	str_arry6 = arry6.join();

	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/saveEditLppbNumber" ,
		data:{
			lppb_number: str_arry,
			organization_id: str_arry2,
			po_number: str_arry3,
			po_header_id: str_arry5,
			batch_detail_id: str_arry6,
			batch_number: batch_number,
			id_lppb: id_lppb
		},
		success: function(response){
			window.location.reload();
			alert('Data sudah disimpan');
			console.log(lppb_number,organization_id,po_number,po_header_id,batch_number,id_lppb);
		}
	})
}
function searchLppb(th){
	$('#loading_search').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading3.gif'/><br /></center><br />");
	var lppb_numberFrom =  $('#lppb_numberFrom').val();
	var lppb_number =  $('#lppb_number').val();
	var inventory_organization = $('#inventory').val();
	$.ajax({
		type: "POST",
		url : baseurl+"MonitoringLPPB/ListBatch/addNomorLPPB",
		data : {
			lppb_numberFrom : lppb_numberFrom,
			lppb_number : lppb_number,
			inventory_organization : inventory_organization
		},
		success: function(response){
			$('#loading_search').html(response);
				$('#showTableLppb').DataTable({
					"paging":   false,
					"ordering": true,
					"info":     false	
				});
			var id_lppb = $('.lppb_id').length;
			var num = id_lppb;
			$('#addLppbNumber').click(function(){
					var inputLppb = ['po_header_id[]','organization_id[]','organization_code[]', 'lppb_number[]', 'vendor_name[]', 'tanggal_lppb[]', 'po_number[]','status_lppb[]'];
					// var ct = $('#tabelNomorLPPB').children('tr').length;
					// var row='';
					// var td = '';
					if (response != false) {
						$('.chkAllLppbNumber').each(function(){
							var html = '';
							if (this.checked) {
								var id_num = $(this).val();
								html += '<tr class="row-id" id="row-1">';
								$('tr#'+id_num).each(function(){
									num++;
									var col=0;
									$(this).find('td').each(function(){
										col++;
										if (col==1) {
											html+='<td>'+num+'</td>';
										}else{
											html+='<td><input style="width: 100%" name="'+inputLppb[(col-2)]+'" type="hidden" class="form-control '+inputLppb[(col-2)]+'" value="'+$(this).text()+'" row-num="'+num+'" readonly>';
											html+='<span>'+$(this).text()+'</span></td>';
										}
									});
								})
								html+='<td><button type="button" class="btnDeleteRow btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>'; 
								html+='</tr>'; 
								$('#tabelNomorLPPB').append(html);
								$('[name="po_header_id[]"],[name="organization_id[]"]').parent('td').hide();
							}
						})
					}else{
						alert('Nomor LPPB '+lppb_number+' tidak ditemukan');
					}
					
					$('.btnDeleteRow').on('click', function(){
						var cfrm = confirm('Yakin menghapusnya?');
						var th = $(this);
						if (cfrm) {
							th.parent('td').parent('tr').remove();
						}else{
							alert('Hapus dibatalkan');
						}
					});
				})
			}
		});
};
function chkAllLppb() {
	if ($('.chkAllLppb').is(':checked')) {
		$('.chkAllLppbNumber').each(function () {
			$(this).prop('checked',true);
		});
	}else{
		$('.chkAllLppbNumber').each(function () {
			$(this).prop('checked',false);
		});
	};
}
function approveLppbByKasie(th) {
	var jml = 0;
	var arrId = [];
	var hasil = '';
	$('input[name="check-id[]"]').each(function(){
		if ($(this).parent().hasClass('checked')) {
			valueId = $(this).attr('value');
			arrId.push(valueId);
		}
	});
	hasil = arrId.join();
	var status = th.attr('value');
	// console.log(status);
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss');
	var hasilsplit = hasil.split(',');
	for (var i = 0; i < hasilsplit.length; i++) {
		hasilsplit[i]
	
		if (status == 3) {
			$('td.batchdid_'+hasilsplit[i]).children('.btnApproveReject').html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt; value="3" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses" value="3"></span>');
			$('td.batchdid_'+hasilsplit[i]).children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
			$('.chkAllLppbNumber').iCheck('uncheck');
		} else {
			$('td.batchdid_'+hasilsplit[i]).children('.btnApproveReject').html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;" value="4">Ditolak<input type="hidden" name="hdnProses[]" class="hdnProses" value="4"></span>');
			$('td.batchdid_'+hasilsplit[i]).children('.tglTerimaTolak').html('<input type="text" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
			$('td.batchdid_'+hasilsplit[i]).children('.txtAlasan').show().attr('required', true);
			$('.chkAllLppbNumber').iCheck('uncheck');
		}
	}
}