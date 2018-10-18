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
})
});

function getRequirementMO(th){
	var nojob = $('#NoJob').val();

	if (nojob != "") {
		$('#NoJob').css("border-color","#d2d6de");
	var request = $.ajax({
		url: baseurl+'InventoryManagement/CreateMoveOrder/search/'+nojob,
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