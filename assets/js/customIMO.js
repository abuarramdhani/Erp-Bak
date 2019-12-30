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
	
	// if (nojob != "") {
		// $('#NoJob').css("border-color","#d2d6de");
	var request = $.ajax({
		url: baseurl+'InventoryManagement/CreateMoveOrder/search/',
		data: {
			dept : dept, date : date, shift : shift
		},
		type: "POST",
		datatype: 'html', 
	});
		$('#ResultJob').html('');
		$('#ResultJob').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );

	request.done(function(result){
			$('#ResultJob').html(result);
		})

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