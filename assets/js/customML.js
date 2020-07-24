$(document).ready(function(){
	$('.tblLPPBAkt').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
			"zeroRecords": " "             
		}
	})
})

function saveActionLppbNumber(th) {
	var batch_number = $('.batch_number_save').val();
	// console.log(batch_number)

		var arry = [];
		$('.hdnProses_save').each(function(){
		var proses = $(this).val();
		arry.push(proses);
		});

		// console.log(arry)

		var arry2 = [];
		$('.tglTerimaTolak_save').each(function(){
		var tanggal = $(this).val();
		arry2.push(tanggal);
		});

		// console.log(arry2)

		var arry3 = [];
		$('.alasan_reject_save').each(function(){
		var alasan = $(this).val();
		arry3.push(alasan);
		});

		// console.log(arry3)

		var arry4 = [];
		$('.id_save').each(function(){
		var id = $(this).val();
		arry4.push(id);
		});

		// console.log(arry4)
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbKasieGudang/Unprocess/saveActionLppbNumber",
			data: {
				batch_number:batch_number,
				hdnProses:arry,
				tglTerimaTolak:arry2,
				alasan_reject:arry3,
				id:arry4
			},
			success: function (response) {

				Swal.fire({
			  // position: 'top-end',
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
				})

				$('#btnSubmitCheckingToAkuntansi').removeClass("sembunyi");
				$('#btnsavekasie').addClass("sembunyi");
			}
		});

}

$(document).ready(function(){
	$('.dtTableMl').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
			"zeroRecords": " "             
		}
	})

	$('.slcnmvendorLppb').select2({
        ajax: {
            url: baseurl+'TrackingLppb/Tracking/searchVendor',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.VENDOR_NAME,
                            text: item.VENDOR_NAME,
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
		placeholder: 'Nama Vendor',
		allowClear: true
    })

	
$('#btnsavekasie').click(function(){
	Swal.fire({
			  // position: 'top-end',
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})

			$('#btnSubmitCheckingToAkuntansi').prop('disabled', false)
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
		$('#loading_lppb').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		var nama_vendor = $('#nama_vendor').val();
		var nomor_lppb = $('#nomor_lppb').val();
		var dateFrom = $('#dateFromUw').val();
		var dateTo = $('#dateToUw').val();
		var nomor_po = $('#nomor_po').val();
		var inventory = $('#inventory').val();
		var opsigdg = $('#opsigdg').val();

		// var status = $('#status_lppb').val();
		// console.log(status);
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingLppb/Tracking/btn_search",
			data: {
				nama_vendor: nama_vendor,
				nomor_lppb: nomor_lppb,
				dateFrom: dateFrom,
				dateTo: dateTo,
				nomor_po: nomor_po,
				inventory: inventory,
				opsigdg: opsigdg
				// status: status
			},
			success: function (response) {
				$('#loading_lppb').html(response);
				$('#tabel_search_tracking_lppb').DataTable({
					"paging": true,
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

});
function searchNumberLppb(th){
	$('#loading_search').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	var lppb_number =  $('#lppb_number').val();
	var lppb_numberFrom =  $('#lppb_numberFrom').val();
	var inventory_organization = $('#inventory').val();
	var status = $('#status_lppb').val();
	console.log('searchNumberLppb');
	$.ajax({
		type: "POST",
		url : baseurl+"MonitoringLPPB/ListBatch/addNomorLPPB",
		data : {
			lppb_number : lppb_number,
			lppb_numberFrom : lppb_numberFrom,
			inventory_organization : inventory_organization,
			status_lppb : status
		},
			// dataType:'json',
			success: function(response){
				$('#loading_search').html(response);
				$('#showTableLppb').DataTable({
					"paging":   true,
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
								$(this).prop('checked', false); 
								$(this).attr("disabled", true);
								$(this).parent('td').parent('tr').css('background-color','#ffccf9');
								
									html += '<tr id="row-1">';
									$('tr#'+id_num).each(function(){
										num++;
										var col=0;
										$(this).find('td').each(function(){
											col++;
											if (col==1) {
												html+='<td>'+num+'<input class="LppbInput" type="hidden" value="'+id_num+'"</td>';
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
					$('.btnDeleteRow').click(function(){
						// var cfrm = confirm('Yakin menghapusnya?');
						var th = $(this);
						var inputan = $('td .LppbInput').val();
						console.log(inputan);
							th.parent('td').parent('tr').remove();
								$('tr#'+inputan+' .chkAllLppbNumber').attr("disabled", false);
								$('tr#'+inputan+' .chkAllLppbNumber').parent('td').parent('tr').css('background-color','#FFF');
						// if (cfrm) {
						// }else{
						// 	alert('Hapus dibatalkan');
						// }
						// console.log(th);
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
		prnt.html('<span class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Approve<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="3"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" class="tglTerimaTolak_save" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
	} else {
		prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="4"></span>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input type="text" class="tglTerimaTolak_save" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span>'+tanggal+'</span>');
		prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
	}
}
var prnt = "";
var reload = "";
function actionLppbNumber(th){
	var batch_detail_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	prnt = $(th).parent();
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 
	console.log("atas", prnt);
	// alert(tanggal);
	
	prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
	if (proses == 6) {
		prnt.html('<span id="btn_'+batch_detail_id+'" class="btn btn-primary" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="6"></span> <a id="reload_'+batch_detail_id+'" class="btn btn-sm btn-primary" onclick="reloadAktTerima('+batch_detail_id+');"><i class="fa fa-refresh"></i></a>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input id="tgl_'+batch_detail_id+'" type="text" class="tglTerimaTolak_save" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span id="span_'+batch_detail_id+'">'+tanggal+'</span>');
	} else {
		prnt.html('<span id="btntlk_'+batch_detail_id+'"class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="7"></span><br><a id="reload_'+batch_detail_id+'" class="btn btn-sm btn-primary" onclick="reloadAktTolak('+batch_detail_id+');"><i class="fa fa-refresh"></i></a>');
		prnt.siblings('td').children('.tglTerimaTolak').html('<input id="tgltlk_'+batch_detail_id+'"type="text" style="display:none" class="tglTerimaTolak_save" name="tglTerimaTolak[]" value="'+tanggal+'"><span id="spantlk_'+batch_detail_id+'">'+tanggal+'</span>');
		prnt.siblings('td').children('.txtAlasan').show().attr('required', true);
	}
}
function reloadAktTerima (th) {
	// prnt = $(th).parent();
	// console.log("bawah" ) 
	$('#btn_'+th).remove();
	$('#tgl_'+th).remove();
	$('#span_'+th).remove();
	$('#reload_'+th).remove();
	$('#txtTolak_'+th).hide();
	var btn = '<button id="btnAkt_'+th+'" class="btn btn-primary" onclick="actionLppbNumber(this)" value="6" name="proses" data-id="'+th+'">OK</button> ';
	btn += '<button id="btnAkt_'+th+'" class="btn btn-danger" onclick="actionLppbNumber(this)" value="7" name="proses" data-id="'+th+'">NOT OK</button>';
	$('td[data = "'+th+'"]').html(btn);
	// $('td[data = "'+th+'"]').html("sadasdas")
	// $(th).remove();
}
function reloadAktTolak(th) {
	// txtTolak = "txtTolak_"+th;
	$('#btntlk_'+th).remove();
	$('#tgltlk_'+th).remove();
	$('#spantlk_'+th).remove();
	$('#reloadtlk_'+th).remove();
	$('#txtTolak_'+th).hide();
	var btn = '<button id="btnAkt_'+th+'" class="btn btn-primary" onclick="actionLppbNumber(this)" value="6" name="proses" data-id="'+th+'">OK</button> ';
	btn += '<button id="btnAkt_'+th+'" class="btn btn-danger" onclick="actionLppbNumber(this);" value="7" name="proses" data-id="'+th+'">NOT OK</button>';
	$('td[data = "'+th+'"]').html(btn);
	// $('td.batchdid_'+ th).children('.txtAlasan').show().attr('required', true);
	// console.log(th);
	// console.log("reload : " + th);
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
	console.log(batch_number)
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
	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})
						  

	var batch_number = $(th).attr('data-id');
	var group_batch = $(th).attr('data-batch');
	var alasan_reject = $('.txtAlasan').val();
	
		$.ajax({
			type: "post",
			url: baseurl+"MonitoringLppbKasieGudang/Unprocess/SubmitKeAKuntansi",
			dataType: 'JSON',
			data:{
				batch_number: batch_number,
				alasan_reject: alasan_reject
			},
			success: function(response){

					$('tr.'+response+'').remove();

				swalWithBootstrapButtons.fire(
					      'Sent!',
					      'LPPB berhasil dikirim!',
					      'success'
					    	)
				$('#mdlSubmitToKasieGudang').modal('hide');

			}
		})
}



function getOptionGudang(th){
	Swal.fire({
	  title: 'Please Wait ...',
	  showConfirmButton: false,
	  showClass: {
	    popup: 'animated fadeInDown faster'
	  },
	  hideClass: {
	    popup: 'animated fadeOutUp faster'
	  }
	})
	
	var id_gudang = $(th).val();
$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/showGudang",
		data:{
			id_gudang: id_gudang
		},
		success: function(response){
			// console.log(response)
			// var id = $(hh).closest('tr').find('input#txtKodeItem'). 
  // 172    attr('data-id'); 
			// console.log(row)
			//menampilkan gudang yang dipilih
			$('#showOptionLppb').html(response);
			$('#tabel_list_batch').DataTable({
				"paging": false,
				"info":     false,
				"language" : {
					"zeroRecords": " "             
				}
			});
	var row = $('#tbodyCoba tr td.coba').text();
	console.log(row)
			if (($('#tbodyCoba tr td.coba').text()) == '') {
									Swal.fire({
									  type: 'error',
									  title: 'Data tidak ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})

			} else if (($('#tbodyCoba tr td.coba').text()) !== "") {

									Swal.fire({
									  type: 'success',
									  title: 'Data ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
										}
		}
	})
}
function getOptionKasieGudang(th){
	Swal.fire({
			  title: 'Please Wait ...',
			  showConfirmButton: false,
			  showClass: {
			    popup: 'animated fadeInDown faster'
			  },
			  hideClass: {
			    popup: 'animated fadeOutUp faster'
			  }
			})
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
			var row = $('.coba tr td.coba').text();
	// console.log(row)
			if (($('.coba tr td.coba').text()) == '') {
											Swal.fire({
									  type: 'error',
									  title: 'Data tidak ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})

			} else if (($('.coba tr td.coba').text()) !== "") {

									Swal.fire({
									  type: 'success',
									  title: 'Data ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
										}
		}
	})
}
function getOptionKasieAkt(th){
		Swal.fire({
  title: 'Please Wait ...',
  showConfirmButton: false,
  showClass: {
    popup: 'animated fadeInDown faster'
  },
  hideClass: {
    popup: 'animated fadeOutUp faster'
  }
})
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
				var row = $('.coba tr td.coba').text();
	// console.log(row)
			if (($('.coba tr td.coba').text()) == '') {
											Swal.fire({
									  type: 'error',
									  title: 'Data tidak ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})

			} else if (($('.coba tr td.coba').text()) !== "") {

									Swal.fire({
									  type: 'success',
									  title: 'Data ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
										}
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
	var arry5 = [];
	$('input[class~="po_header_id[]').each(function(){
		var po_header_id = $(this).val();
		arry5.push(po_header_id);
	})
	// console.log(arry5);
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/saveLppbNumber",
		data:{
			lppb_info: lppb_info,
			id_gudang: id_gudang,
			lppb_number: str_arry,
			organization_id: str_arry2,
			po_number: arry3,
			po_header_id: arry5
		},
		// dataType: "json",
		success: function(response){
			// console.log(lppb_info,id_gudang,str_arry,str_arry2,str_arry3,str_arry5);
			Swal.fire(
  					'Saved!',
  					'Data sudah disimpan',
  					'success'
						);

			// window.location.reload();
		}
	})
	
}
function saveEditLPPBNumber(th){
	var batch_number = $('#batch_number').val();
	// var batch_detail_id = $('#batch_detail_id').val();
	var id_lppb = $('.row-id').length;
	
	var arry = [];
	$('td[class~="lppb_number"]').each(function(){
		var lppb_number = $(this).text();
		arry.push(lppb_number);
	});
	// console.log("lppb_number", arry);
	str_arry = arry.join();
	
	var arry2 = [];
	$('td[class~="organization_id').each(function(){
		var organization_id = $(this).text(); 
		arry2.push(organization_id);
	});
	// console.log("oi", arry2);
	str_arry2 = arry2.join();
	var arry3 = [];
	$('td[class~="po_number').each(function(){
		var po_number = $(this).text();
		arry3.push(po_number);
	});
	str_arry3 = arry3.join();
	var arry5 = [];
	$('td[class~="po_header_id').each(function(){
		var po_header_id = $(this).text();
		arry5.push(po_header_id);
	});
	str_arry5 = arry5.join();
	//ini yang insert
		var arry6 = [];
	$('td[class~="lppb_numberNew"]').each(function(){
		var lppb_numberNew = $(this).text();
		arry6.push(lppb_numberNew);
	});
	// console.log("lppb_numberNew", arry);
	str_arry6 = arry6.join();
	
	var arry7 = [];
	$('td[class~="organization_idNew').each(function(){
		var organization_idNew = $(this).text(); 
		arry7.push(organization_idNew);
	});
	// console.log("organization_idNew", arry7);
	str_arry7 = arry7.join();
	var arry8 = [];
	$('td[class~="po_numberNew').each(function(){
		var po_numberNew = $(this).text();
		arry8.push(po_numberNew);
	})
	// str_arry8 = arry8.join();
	// console.log("po_numberNew", arry8);
	var arry9 = [];
	$('td[class~="po_header_idNew').each(function(){
		var po_header_idNew = $(this).text();
		arry9.push(po_header_idNew);
	})
	// console.log("po_header_idNew", arry9);

	var arry10 = [];
	$('td[class~="batch_detail_id').each(function(){
		var batch_detail_id = $(this).text();
		arry10.push(batch_detail_id);
	})
	console.log("batch_detail_id", arry10);

	// var arry11 = [];
	// $('td[class~="batch_detail_idNew').each(function(){
	// 	var batch_detail_idNew = $(this).text();
	// 	arry11.push(batch_detail_idNew);
	// })
	// console.log("batch_detail_idNew", arry11);
	$.ajax({
		type: "post",
		url: baseurl+"MonitoringLPPB/ListBatch/saveEditLppbNumber" ,
		data:{
			lppb_number: str_arry,
			organization_id: str_arry2, 
			po_number: str_arry3,
			po_header_id: str_arry5,
			// batch_detail_id: batch_detail_id,
			batch_number: batch_number,
			id_lppb: id_lppb,
			lppb_numberNew: str_arry6,
			organization_idNew: str_arry7, 
			po_numberNew: arry8,
			po_header_idNew: arry9,
			batch_detail_id: arry10,
			// batch_detail_idNew: arry11
		},
		success: function(response){
			Swal.fire(
  					'Saved!',
  					'Data sudah ditambahkan',
  					'success'
						);
		$('#mdlDetailAdminGudang').modal('hide');
			window.location.reload();
			// alert('Data sudah disimpan');
		// 	console.log(lppb_number,organization_id,po_number,po_header_id,batch_number,id_lppb);
		}
	})
}
function searchLppb(th){ //ini fungsi add bawah detail
	$('#loading_search').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	var lppb_numberFrom =  $('#lppb_numberFrom').val();
	var lppb_number =  $('#lppb_numberTo').val();
	var inventory_organization = $('#inventory').val();
	var status = $('#status_lppb').val();
	$.ajax({
		type: "POST",
		url : baseurl+"MonitoringLPPB/ListBatch/addDetailNomorLPPB",
		data : {
			lppb_numberFrom : lppb_numberFrom,
			lppb_number : lppb_number,
			inventory_organization : inventory_organization,
			status_lppb : status
		},
		success: function(response){
				$('#loading_search').html(response);
					$('#showTableLppb').DataTable({
						"paging":   true,
						"ordering": true,
						"info":     false	
					});
					var id_lppb = $('.lppb_id').length;
					var num = id_lppb;
			$('#addDetailLppbNumber').click(function(){ //button dari add detail
					var organization_id ='';
					var organization_code = '';
					var po_header_id = '';
					var lppb_number = '';
					var vendor_name ='';
					var tanggal_lppb = '';
					var po_number='';
					var status='';
					var d = new Date();
					// console.log("d", d);
					var month = new Array();
						  month[0] = "JAN";
						  month[1] = "FEB";
						  month[2] = "MAR";
						  month[3] = "APR";
						  month[4] = "MAY";
						  month[5] = "JUN";
						  month[6] = "JUL";
						  month[7] = "AUG";
						  month[8] = "SEP";
						  month[9] = "OCT";
						  month[10] = "NOV";
						  month[11] = "DEC";
					// console.log("bulan",month);
					var get_month = d.getMonth();
					var res_month = month[get_month];
					var day = d.getDate();
					var year = d.getFullYear();
					year = year.toString().substr(-2);
					// console.log("hari",day);
					var output =  (day<10 ? '0' : '')+day + '-' + res_month + '-'
					     + year;
					 // console.log(output, 'total');
					if (response != false) {
						$('.chkAllLppbNumber').each(function(){
							var html = '';
							if (this.checked) {
								var id_num = $(this).val();
								// console.log(id_num,'ini data');
								html += '<tr class="row-id" id="row-1">';
								$('tr#'+id_num).each(function(){
									num++;
									var col=0;
					 				// console.log(inputLppb,'di dalam each tr#');
									$(this).find('td').each(function(){
										// console.log(inputLppb,'di dalam find td');
										col++;
										if (col==1) {
											html+='<td>'+num+'</td>';
											// organization_code = $(this).text();
										}else if (col==2) {
											html+='<td class="organization_idNew">'+$(this).text()+'</td>';
											
										}
										else if (col==3){
											html+='<td class="organization_codeNew">'+$(this).text()+'</td>';
											
										}
										else if (col==4){
											html+='<td>'+output+'</td>';
											lppb_number = $(this).text();
										}
										else if (col==5){
											html+='<td class="lppb_numberNew">'+lppb_number+'</td>';
											vendor_name = $(this).text();
										}
										else if (col==6){
											html+='<td class="vendor_nameNew">'+vendor_name+' </td>';
											tanggal_lppb = $(this).text();
										}
										else if (col==7){
											html+='<td class="tanggal_lppbNew">'+tanggal_lppb+' </td>';
											
										}
										else if (col==8){
											html+='<td class="po_header_idNew">'+$(this).text()+'</td>';
										}
										else if (col==9){
											html+='<td class="po_numberNew">'+$(this).text()+'</td>';
										}
										// else if (col==10){
										// 	html+='<td class="batch_detail_idNew">'+$(this).text()+'</td>';
										// }
										
										
									});
								})
								if (batch_number >= 0) {
									html+='<td> <span class="label label-default"> New/Draf &nbsp;<br></span></td>';
								}else {
									html+='<td> <span class="label label-warning"> Admin Edit &nbsp;<br></span></td>';
								}
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

var valueId = "";
function approveLppbByKasie(th) { 
	// console.log(th);
	var jml = 0;
	var arrId = [];
	var hasil = '';
	$('input[name="check-id[]"]').each(function(){
		if ($(this).parent().hasClass('checked')) {
		console.log($(this))
			valueId = $(this).attr('value');
			arrId.push(valueId);
		}
	});
	hasil = arrId.join();
	console.log(hasil)
	var status = th;
	// console.log(status);
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss');
	var hasilsplit = hasil.split(',');
	for (var i = 0; i < hasilsplit.length; i++) {
		hasilsplit[i]
	
		if (status == 3) {
			$('td.batchdid_'+hasilsplit[i]).children('.btnApproveReject').html('<span class="btn btn-primary" id="btn_'+hasilsplit[i]+'" style="cursor: none;font-size: 10pt; value="3" >Diterima<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="3"></span><a id="reload_'+hasilsplit[i]+'" class="btn btn-sm btn-primary" onclick="reloadTerima('+hasilsplit[i]+');"><i class="fa fa-refresh"></i></a>');
			$('td.batchdid_'+hasilsplit[i]).children('.tglTerimaTolak').html('<input type="text" class="tglTerimaTolak_save" id="tgl_'+hasilsplit[i]+'" style="display:none" name="tglTerimaTolak[]" value="'+tanggal+'"><span id="span_'+hasilsplit[i]+'">'+tanggal+'</span>');
			$('.chkAllLppbNumber').iCheck('uncheck');
		} else {
			$('td.batchdid_'+hasilsplit[i]).children('.btnApproveReject').html('<span class="btn btn-danger" id="btntlk_'+hasilsplit[i]+'" style="font-size: 8pt ;cursor: none;" value="4">Ditolak<input type="hidden" name="hdnProses[]" class="hdnProses hdnProses_save" value="4"></span><a id="reloadtlk_'+hasilsplit[i]+'" class="btn btn-sm btn-primary" onclick="reloadTolak('+hasilsplit[i]+');"><i class="fa fa-refresh"></i></a>');
			$('td.batchdid_'+hasilsplit[i]).children('.tglTerimaTolak').html('<input type="text" class="tglTerimaTolak_save" style="display:none"  id="tgltlk_'+hasilsplit[i]+'" name="tglTerimaTolak[]" value="'+tanggal+'"><span id="spantlk_'+hasilsplit[i]+'">'+tanggal+'</span>');
			$('td.batchdid_'+hasilsplit[i]).children('.txtAlasan').show().attr('required', true);
			$('.chkAllLppbNumber').iCheck('uncheck');
			// console.log("check : "+hasilsplit[i]);
		}
	}
}
function reloadTerima (th) {
	$('#btn_'+th).remove();
	$('#tgl_'+th).remove();
	$('#span_'+th).remove();
	$('#reload_'+th).remove();
	$('#txtTolak_'+th).hide();
	// $(th).remove();
}
function reloadTolak(th) {
	// txtTolak = "txtTolak_"+th;
	$('#btntlk_'+th).remove();
	$('#tgltlk_'+th).remove();
	$('#spantlk_'+th).remove();
	$('#reloadtlk_'+th).remove();
	$('#txtTolak_'+th).hide();
	// $('td.batchdid_'+ th).children('.txtAlasan').show().attr('required', true);
	// console.log(th);
	// console.log("reload : " + th);
}


/*function updateData(th){
var tag = $('#tag').val();
var nama = $('#nama').val();
var merk = $('#merk').val();
var qty = $('#qty').val();
var jenis = $('#jenis').val();

console.log("clicked";

var request = $.ajax({
url: baseurl+'StockGudangAlat/updateData/',
data: {
tag : tag,
nama : nama, 
merk : merk, 
qty : qty,
jenis : jenis
},
type: "POST",
datatype: 'html', 
});

request.done(function(
console.log("Done";
})
}

*/

function bukaMdl(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');
	// var batch_detail_id = ;
	// var organization_code = ;
	// var lppb_number = ;
	// var vendor_name = ;


	$('#group_batch').text(group_batch);	
	$('#mdlSubmitToKasieGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbKasieGudang/Unprocess/detailLppbKasieGudang",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


				// $('#mdlSubmitToKasieGudang').modal('hide');
				// $('#group_batch2').text(group_batch);
				// $('#mdlChecking').modal('show');
				// $('#btnClose').click(function(){
				// // 		$('#mdlChecking').modal('hide');
				// // 		window.location.reload();
				// })
			}
		})
	
	
}

function MdlRejectKasie(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlRejectKasieGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbKasieGudang/Reject/RejectLppb/",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


				// $('#mdlSubmitToKasieGudang').modal('hide');
				// $('#group_batch2').text(group_batch);
				// $('#mdlChecking').modal('show');
				// $('#btnClose').click(function(){
				// // 		$('#mdlChecking').modal('hide');
				// // 		window.location.reload();
				// })
			}
		})
	
	
}

function MdlFinishKasie(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlFinishKasieGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbKasieGudang/Finish/detailFinishKasie",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


				// $('#mdlSubmitToKasieGudang').modal('hide');
				// $('#group_batch2').text(group_batch);
				// $('#mdlChecking').modal('show');
				// $('#btnClose').click(function(){
				// // 		$('#mdlChecking').modal('hide');
				// // 		window.location.reload();
				// })
			}
		})
	
	
}


function ModalRejectAdmin(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlRejectAdminGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/RejectLppb/detailRejectLppb",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


				// $('#mdlSubmitToKasieGudang').modal('hide');
				// $('#group_batch2').text(group_batch);
				// $('#mdlChecking').modal('show');
				// $('#btnClose').click(function(){
				// // 		$('#mdlChecking').modal('hide');
				// // 		window.location.reload();
				// })
			}
		})
	
	
}

function ModalFinishAdmin(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlFinishAdminGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/Finish/FinishDetail",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


				// $('#mdlSubmitToKasieGudang').modal('hide');
				// $('#group_batch2').text(group_batch);
				// $('#mdlChecking').modal('show');
				// $('#btnClose').click(function(){
				// // 		$('#mdlChecking').modal('hide');
				// // 		window.location.reload();
				// })
			}
		})
	
	
}


function ModalDetailAdmin(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlDetailAdminGudang').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLPPB/ListBatch/detailLppb",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function ModalDetailAkt(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlDetailAkt').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbAkuntansi/Unprocess/detailLppbAkuntansi",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function ModalRejectAkt(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlRejectAkt').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbAkuntansi/Reject/RejectLppb",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function ModalFinishAkt(th) {
	
	var batch_number = th
	var group_batch = $(th).attr('data-batch');


	$('#group_batch').text(group_batch);	
	$('#mdlFinishAkt').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringLppbAkuntansi/Finish/finishDetail",
			data:{
				batch_number: batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function ModalTrackingLppb(th,th2) {
	
	var batch_detail_id = th
	var section_id = th2
	console.log(section_id)

	$('#mdlDetailTrackingLppb').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;width: 200px' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingLppb/Tracking/detail",
			data:{
				batch_detail_id: batch_detail_id,
				section_id:section_id
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}