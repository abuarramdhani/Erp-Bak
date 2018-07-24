$(document).ready(function () {
	$('#slcEcommerceOrganization').select2({placeholder: "ORGANIZATION"});
	$('#slcEcommerceSubInventory').select2({placeholder: "SUBINVENTORY"});

	$('#slcEcommerceOrganization').change(function(){
		var org_id = $('#slcEcommerceOrganization').val();
		$('#slcEcommerceSubInventory').attr('disabled','disabled');
		$('#slcEcommerceOrganization').attr('disabled','disabled');
		$('#btnSearchEcommerceItem').attr('disabled','disabled');
		$.ajax({
			type: "POST",
			url: baseurl+"ECommerce/SearchItem/getSubInventoryByOrganization/"+org_id,
			dataType: "json",
			success: function (response) {
				$('#slcEcommerceSubInventory').html(response);
				$('#slcEcommerceSubInventory').removeAttr('disabled');
				$('#slcEcommerceOrganization').removeAttr('disabled');
				$('#slcEcommerceSubInventory').select2({placeholder: "SUBINVENTORY"});
			}
		});
	});

	$('#slcEcommerceSubInventory').change(function(){
		$('#btnSearchEcommerceItem').removeAttr('disabled');
	});

	$('#btnSearchEcommerceItem').click(function(){
		$('#searchResultTableItemBySubInventory').html('<img src="'+baseurl+'/assets/img/gif/loading12.gif">');
		$('#slcEcommerceSubInventory').attr('disabled','disabled');
		$('#slcEcommerceOrganization').attr('disabled','disabled');
		$('#btnSearchEcommerceItem').attr('disabled','disabled');
		$('#submitExportExcelItemEcatalog').attr('disabled','disabled');

		var org_id = $('#slcEcommerceOrganization').val();
		var sub_code = $('#slcEcommerceSubInventory').val();

		$.ajax({
			type: "POST",
			url: baseurl+"ECommerce/SearchItem/getItemBySubInventory",
			data: {
				org_id:org_id,
				sub_code:sub_code,
			},
			success: function (response) {
				$('#slcEcommerceSubInventory').removeAttr('disabled');
				$('#slcEcommerceOrganization').removeAttr('disabled');
				$('#btnSearchEcommerceItem').removeAttr('disabled');
				$('#submitExportExcelItemEcatalog').removeAttr('disabled');
				$('#searchResultTableItemBySubInventory').html(response);
				$('#tbItemTokoquick').DataTable();
			}
		});
	});
});