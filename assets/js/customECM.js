$(document).ready(function () {
	$('#slcEcommerceOrganization').select2({placeholder: "ORGANIZATION"});
	$('#slcEcommerceSubInventory').select2({placeholder: "SUBINVENTORY"});
	$('#slcEcommerceKriteriaCari').select2({placeholder: "KRITERIA"});

	$('#slcEcommerceOrganization').change(function(){
		var org_id = $('#slcEcommerceOrganization').val();
		$('#slcEcommerceSubInventory').attr('disabled','disabled');
		$('#slcEcommerceOrganization').attr('disabled','disabled');
		$('#btnTambahKriteriaPencarian').attr('disabled','disabled');
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
		$('#btnTambahKriteriaPencarian').removeAttr('disabled');
	});

	$('#btnTambahKriteriaPencarian').click(function(){
		var org_id = $('#slcEcommerceOrganization').val();
		var org_op = $('#slcEcommerceOrganization option[value="'+org_id+'"]').html().replace(/\s/g, '');
		var sub_in = $('#slcEcommerceSubInventory').val();

		var org_ar = org_op.split("-");

		// alert(org_id+'/'+org_ar[0]+'-'+sub_in);

		$('#slcEcommerceKriteriaCari').append('<option value="'+org_id+'/'+sub_in+'" selected>'+org_ar[0]+' - '+sub_in+'</option>').trigger('change');
		$('#btnSearchEcommerceItem').removeAttr('disabled');
	});

	$('#btnSearchEcommerceItem').click(function(){
		$('#searchResultTableItemBySubInventory').html('<img src="'+baseurl+'/assets/img/gif/loading12.gif">');
		$('#slcEcommerceSubInventory').attr('disabled','disabled');
		$('#slcEcommerceOrganization').attr('disabled','disabled');
		$('#submitExportExcelItemEcatalog').attr('disabled','disabled');

		var kriteria = $('#slcEcommerceKriteriaCari').val();

		$.ajax({
			type: "POST",
			url: baseurl+"ECommerce/SearchItem/getItemBySubInventory",
			data: {
				kriteria:kriteria,
			},
			success: function (response) {
				$('#slcEcommerceSubInventory').removeAttr('disabled');
				$('#slcEcommerceOrganization').removeAttr('disabled');
				$('#btnTambahKriteriaPencarian').removeAttr('disabled');
				$('#submitExportExcelItemEcatalog').removeAttr('disabled');
				$('#searchResultTableItemBySubInventory').html(response);
				$('#tbItemTokoquick').DataTable();
			}
		});
	});

    $('#dataWaktuOrder').DataTable( {
        "pagingType": "full_numbers"
    } );

    $('#btn-search').click(function(){
		$('#searchResultTableItemByDate').html('<img src="'+baseurl+'/assets/img/gif/loading12.gif">');
	});

    // $('#dataWaktuOrder').DataTable({
    //     "searching"		: true,
    //     "lengthChange"	: false,
    //     "scrollX"		: false,
    //     "paging"		: false

    // });

});