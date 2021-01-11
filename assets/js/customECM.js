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
				$('#searchResultTableItemBySubInventory').html(response);
				$('.tbItemTokoquick').DataTable({
					dom: `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4'B> <'col-sm-12 col-md-4'f> >
						<'row' <'col-sm-12'tr> >
						<'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
					buttons: [{
						extend: 'excelHtml5',
						exportOptions: {
							columns: [0, 2, 1, 4]
						},
						customize: function(xlsx) {
							var sheet = xlsx.xl.worksheets['sheet1.xml'];
							$('c[r=B2] t', sheet).text('NAME');
							$('c[r=C2] t', sheet).text('REFERENCE');
							$('c[r=D2] t', sheet).text('QUANTITY');
						}
					}]
				});
			}
		});
	});

    $('#dataWaktuOrder').DataTable( {
    	scrollX: true,
        "pagingType": "full_numbers"
    } );

    $('#btn-search').click(function(){
		$('#searchResultTableItemByDate').html('<img src="'+baseurl+'/assets/img/gif/loading12.gif">');
	});

	$("#tanggalan").datepicker({    
		format: "dd/mm/yyyy",    
		autoclose: true,  
	});
});