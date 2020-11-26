$(document).ready(function(){
	$('.tblResultIMO').DataTable({
		"paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,

	});

$('.selectIMO').select2({
	allowClear : true,
});

$('.dateIMO').datepicker({
		todayHighlight: true,
	});

$('.shiftForm').hide();

});

$('#selectDept').change(function(){
	jQuery('DIV.ResultJob').html('');
	var dept = $('select[name="slcDeptIMO"]').val();
	if(dept == 'SUBKT') {
		$('.shiftForm').hide();
	} else {
		$('.shiftForm').show();
	}
});

$('#txtTanggalIMO').change(function(){
	var date = $('input[name="txtTanggalIMO"]').val();
	var dept = $('select[name="slcDeptIMO"]').val();
	var html = '<option></option>';
	$.ajax({
			url : baseurl+('InventoryManagement/CreateMoveOrder/getShift'),
			type : 'POST',
			data : {
				date : date
				},
			datatype : 'json',
			success: function(result) {
				$.each(JSON.parse(result), function(key, value) {
					html += '<option value="'+value.SHIFT_NUM+'">'+value.DESCRIPTION+'</option>';
					$('.inputShiftIMO').removeAttr("disabled");
				});
					$('.inputShiftIMO').html(html);
					$('.inputShiftIMO').val(null).trigger('change');
			}
		});
});


function getRequirementMO(th){
	var dept = $('select[name="slcDeptIMO"]').val();
	var date = $('input[name="txtTanggalIMO"]').val();
	var shift = $('select[name="slcShiftIMO"]').val();
	var nojob_sebelumnya = $('input[name="selectedPicklistIMO"]').val();
	// console.log(nojob_sebelumnya);
	$('#ResultJob').css('display','');
	$('#ResultJob').html('');
	$('#ResultJob').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	if (nojob_sebelumnya) {
		$.ajax({
			url : baseurl + "InventoryManagement/CreateMoveOrder/checkATTPicklistSelect",
			data : {nojob : nojob_sebelumnya},
			dataType : "html",
			type : 'POST',
			success : function (result) {
				if (result) {\
				   swal.fire('PERHATIAN!', result, "");
				}
			   var request = $.ajax({
				   url: baseurl+'InventoryManagement/CreateMoveOrder/search/',
				   data: {
					   dept : dept, date : date, shift : shift
				   },
				   type: "POST",
				   datatype: 'html', 
			   });
		   
			   request.done(function(result){
					   $('#ResultJob').html(result);
				   })
			}
		})
	}else{
		var request = $.ajax({
			url: baseurl+'InventoryManagement/CreateMoveOrder/search/',
			data: {
				dept : dept, date : date, shift : shift
			},
			type: "POST",
			datatype: 'html', 
		});
	
		request.done(function(result){
				$('#ResultJob').html(result);
			})
	}
	// if (nojob != "") {
		// $('#NoJob').css("border-color","#d2d6de");

	// }else{
	// 	$('#NoJob').css("border-color","red");
	// }
}


function getDetailJobInv(th){
	var nojob = $('#NoJob').val();

	if (nojob != "") {
		$('#NoJob').css("border-color","#d2d6de");
	var request = $.ajax({
		url: baseurl+'InventoryManagement/CreateKIB/search/'+nojob,
		datatype: 'html',
		type: "GET",
	});

	$('#ResultJob').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );


	request.done(function(result){
		$('#ResultJob').html(result);
	});

	}else{
		$('#NoJob').css("border-color","red");
	}
}

function imo_printKIB(th){
	var statusMO = $(th).attr('status-val');
	var qtyMO = $(th).attr('qty-val');
	var subinv = $(th).attr('subinv-val');
	var loc = $(th).attr('loc-val');
	$('#id_imo_txt_status').val(statusMO);
	$('#id_imo_qty_actual').val(qtyMO);
	$('#id_imo_subinv_from').val(subinv);
	$('#id_imo_loc_from').val(loc);
}


function getIMOSubInv(th){
	var qty = $(th).find('input[name="qtyHandling"]').val();
	var org = $(th).val();
	var subinv = $('select[name="slcSubInvIMO"]').val();
	var request = $.ajax({
		url : baseurl+"InventoryManagement/CreateKIB/getSubInv",
		type : "POST",
		data : {
			org :org
		}
	});

	request.done(function(result){
		$('#id_imo_slc_subinv').removeAttr('disabled');
		$('#id_imo_slc_subinv').html('');
		$('#id_imo_slc_subinv').html(result);

		$(th).parent().parent().parent().find('.bg-success').removeClass('bg-success');
		$(th).closest('tr').next('tr').addClass('bg-success');

	});
	checkFill();
}

function getIMODescSubInv(th){
	var qty = $(th).find('input[name="qtyHandling"]').val();
	var value = $(th).val();
	var desc = $(th).find('option[value="'+value+'"]').attr('data-desc');
	var org = $('select[name="slcOrgIMO"]').val();
	var request = $.ajax({
						url : baseurl+"InventoryManagement/CreateKIB/getLocator",
						type : "POST",
						data : {
							org : org,
							subinv : value
						}
					});
		request.done(function(result){
			$(th).parent().parent().parent().find('.bg-success').removeClass('bg-success');
			if (result){
				$('#id_imo_tr_slc_loc').show();
				$('#id_imo_slc_loc').removeAttr('disabled');
				$('#id_imo_slc_loc').html('');
				$('#id_imo_slc_loc').append('<option></option>');
				$('#id_imo_slc_loc').append(result);
				$(th).closest('tr').next('tr').next('tr').addClass('bg-success');
			}else{
				$('#id_imo_tr_slc_loc').hide();
				$('#id_imo_slc_loc').html('');
				$('#id_imo_slc_loc').attr('disabled','disabled');
				$(th).closest('tr').next('tr').next('tr').next('tr').addClass('bg-success');
			}

			if (value != "") {
				$('#id_imo_tr_desc_subinv').show();
			}else{
				$('#id_imo_tr_desc_subinv').hide();
			}
				$('#id_imo_desc_sub_inv').html('');
				$('#id_imo_desc_sub_inv').html(desc);

		});
	checkFill();

}

function nextQty(th){
	$(th).parent().parent().parent().find('.bg-success').removeClass('bg-success');
	$(th).closest('tr').next('tr').addClass('bg-success');
	checkFill();
}

function checkFill(){
	var org = $('#id_imo_slc_org').val();
	var subinv = $('#id_imo_slc_subinv').val();
	var locator = $('#id_imo_slc_loc').val();
	var qty = $('#id_imo_qty_handling').val();
	var statloc = 0;

	if ($('#id_imo_slc_loc').is(':enabled')) {
		if (locator !="") {
			statloc = 1;
		}else{
			statloc = 0;
		}
	}else{
			statloc = 1;
	}

	if ((org != "") && (subinv != "") && (qty.length > 0) && (statloc == 1)) {
		$('#id_imo_btn_sub').removeAttr('disabled');
	}else{
		$('#id_imo_btn_sub').attr('disabled','disabled');
	}
}

function seeDetailIMO(th, idnya){
	var title = $(th).text();
	$('#detail'+idnya).slideToggle('slow');
	
}

function formsubmitIMO(id){
	alert(id);
	form = $('form'+id);
	form.submit();
}


$('.checkedAllIMO1, .ch_komp_imo1').on('click',function(){
	var a = 0;
	var jml = 0;
	var val = '';
	$('input[name="ch_komp[]"]').each(function(){
		if ($(this).is(":checked") === true ) {
			a = 1;
			jml +=1;
			val += $(this).val();
		}
	});
	if (a == 0) {
		$('#btnSelectedIMO').attr("disabled","disabled");
		$('#btnSelectedIMO2').attr("disabled","disabled");
		$('#jmlSlcIMO').text('');
		$('#jmlSlcIMO2').text('');
	}else{
		$('#btnSelectedIMO').removeAttr("disabled");
		$('#btnSelectedIMO2').removeAttr("disabled");
		$('#jmlSlcIMO').text('('+jml+')');
		$('#jmlSlcIMO2').text('('+jml+')');
		$('input[name="selectedPicklistIMO"]').val(val);
	}

});


function getExportMO(th){
	var dept = $('select[name="slcDeptIMO"]').val();
	var date1 = $('input[name="tglAwl"]').val();
	var date2 = $('input[name="tglAkh"]').val();
	// console.log(date2);
	// if (nojob != "") {
		// $('#NoJob').css("border-color","#d2d6de");
	var request = $.ajax({
		url: baseurl+'InventoryManagement/ExportMoveOrder/search/',
		data: {
			dept : dept, date1 : date1, date2 : date2
		},
		type: "POST",
		datatype: 'html', 
	});
		$('#ResultExport').html('');
		$('#ResultExport').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );

	request.done(function(result){
			$('#ResultExport').html(result);
			$('#tblExportMO').dataTable({
				"scrollX": false,
				"paging": false,
				"searching": false,
				"bInfo" : false,
				dom:"lfrtBip", 
				buttons: [{
					extend: 'excel',
					className: "btn btn-success",
					text: '<i class="fa fa-download"></i> Download',
					title: 'Rekap Move Order',
					message: date1+' - '+date2,
				}
			]
			});
		})

	// }else{
	// 	$('#NoJob').css("border-color","red");
	// }
}

$(document).ready(function () {
	$("#masukkanassy").select2({
		allowClear: true,
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "InventoryManagement/Monitoring/sugestion",
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
						return {
							id: obj.SEGMENT1,
							text: obj.SEGMENT1
						};
					})
				};
			}
		}
	});
});
$(document).ready(function () {
	$("#pilihdept").select2({
		allowClear: true,
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "InventoryManagement/Monitoring/sugestiondept",
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
						return {
							id: obj.DEPT,
							text: obj.DEPT+' - '+obj.DESCRIPTION
						};
					})
				};
			}
		}
	});
});
function getAssy(th) {
	$(document).ready(function(){
		var dept = $('#pilihdept').val();
		var assy = $('#masukkanassy').val();

		console.log(dept,assy)
		
		var request = $.ajax({
			url: baseurl+"InventoryManagement/Monitoring/Searchmonitoringassy",
			data: {
			    dept : dept,
			    assy : assy
			},
			type: "POST",
			datatype: 'html'
		});
		
		
			$('#tb_monitorassy').html('');
			$('#tb_monitorassy').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading12.gif"></center>' );
			

		request.done(function(result){
			// console.log("sukses2");
			$('#tb_monitorassy').html(result);
				$('#tb_assy').DataTable({
					scrollX: true,
					scrollCollapse: true,
					paging:true,
                    info:false,
                    searching : true,
				});
			});
		});		
}


$(document).on("click", "#submit_go", function(){
	$('#loadingsimulasi').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading12.gif"></center>' );
 });

 function createsebagian(no) {
		var sudah = $('#qty_sudah_header'+no).val();
		if (sudah) {
			$('#printpicksebelumnya').html('<button class="btn" style="background-color:#0AA86C;color:white;" target="_blank" onclick="clickform4('+no+')"><i class="fa fa-print"></i> Print Picklist Yang Sudah Dibuat</button>');
		}else{
			$('#printpicksebelumnya').html('');
		}
		$('#qty_request').val('');
		$('#loadcheckqty').html('');
		$('#btncheckqty').html('<button type="button" class="btn" style="background-color:#0AA86C;color:white;" onclick="checkqtysebagian('+no+')"><i class="fa fa-spinner"></i> Check</button>');
		$('#mdlCreateSebagian').modal('show');
 }

 function clickform4(no) {
	var nojob = $('#nojob_header'+no).val();
	$('#form4'+nojob).trigger('click');
	$('#mdlCreateSebagian').modal('hide');
 }
 
 function clickform3(no) {
	var nojob = $('#nojob_header'+no).val();
	create = $('#form3'+nojob).trigger('click');
	window.location.reload();
 }

 function checkqtysebagian(no) {
	var nojob 				= $('#nojob_header'+no).val();
	var start_qty 		= $('#qty_header'+no).val();
	var qty_sudah 		= $('#qty_sudah_header'+no).val();
	var qty_komponen 	= $('.qty_komponen'+no).map(function(){return $(this).val();}).get();
	var att_komponen 	= $('.att_komponen'+no).map(function(){return $(this).val();}).get();
	var qty_request 	= $('#qty_request').val();
	if (qty_request > 0) {
		$('.qtyreq'+no).val(qty_request);
		$('#loadcheckqty').html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"><br/></center>' );
		 $.ajax({
			 url : baseurl + "InventoryManagement/CreateMoveOrder/checksebagian",
			 data : {nojob : nojob, start_qty : start_qty, qty_komponen : qty_komponen, att_komponen : att_komponen, qty_request : qty_request, qty_sudah : qty_sudah},
			 dataType : 'html',
			 type : 'POST',
			 success : function (result) {
				//  console.log(result, nojob, qty_request);
				 if (result == 'oke') {
					$('#loadcheckqty').html('<button class="btn" style="background-color:#0AA86C;color:white;" target="_blank" onclick="clickform3('+no+')"><i class="fa fa-check"></i> Create</button>');
				 }else{
					$('#loadcheckqty').html('Masih Terdapat Quantity yang Melebihi ATT.<br>Mohon Ganti Quantity Request Anda.');
				 }
			 }
		 })
	}else{
		$('#loadcheckqty').html('Masukkan Quantity Request.');
	}
 }

 function cekCreatePicklist(no, form) {
	var nojob = $('#wip_entity_name'+no).val();
	var ket = $('#keterangan_picklist'+no).val();
	if (form == 1) {
		$('#form'+nojob).trigger('submit');
	}else if (form == 2) {
		$('#form2'+nojob).trigger('submit');
	}
	// console.log(nojob);
	if (ket != 1) {
		$.ajax({
			url : baseurl + "InventoryManagement/CreateMoveOrder/checkATTPicklist",
			data : {nojob : nojob},
			dataType : "html",
			type : 'POST',
			success : function (result) {
				if (result > 0) {
					swal.fire("PERHATIAN!", "Terdapat "+result+" item yang tidak bisa dilayani.", "");
				}
			}
		})
	}
	getRequirementMO(this);
 }

 function cekSelectPicklist(ket) {
	 if (ket == 1) {
		 $('#btnSelectedIMOSubmit').click();
	 }else if (ket == 2) {
		$('#btnSelectedIMO2Submit').click();
	 }
	//  console.log(nojob);
	 swal.fire('Find untuk melihat data terbaru.', "", "success");
	 $('#ResultJob').css('display','none');
 }
