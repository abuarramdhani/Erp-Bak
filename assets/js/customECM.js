$(document).ready(function () {
	$('#slcEcommerceOrganization').select2({
		placeholder: "ORGANIZATION"
	});
	$('#slcEcommerceSubInventory').select2({
		placeholder: "SUBINVENTORY"
	});
	$('#slcEcommerceKriteriaCari').select2({
		placeholder: "KRITERIA"
	});

	$('#slcEcommerceOrganization').change(function () {
		var org_id = $('#slcEcommerceOrganization').val();
		$('#slcEcommerceSubInventory').attr('disabled', 'disabled');
		$('#slcEcommerceOrganization').attr('disabled', 'disabled');
		$('#btnTambahKriteriaPencarian').attr('disabled', 'disabled');
		$.ajax({
			type: "POST",
			url: baseurl + "ECommerce/SearchItem/getSubInventoryByOrganization/" + org_id,
			dataType: "json",
			success: function (response) {
				$('#slcEcommerceSubInventory').html(response);
				$('#slcEcommerceSubInventory').removeAttr('disabled');
				$('#slcEcommerceOrganization').removeAttr('disabled');
				$('#slcEcommerceSubInventory').select2({
					placeholder: "SUBINVENTORY"
				});
			}
		});
	});

	$('#slcEcommerceSubInventory').change(function () {
		$('#btnTambahKriteriaPencarian').removeAttr('disabled');
	});

	$('#btnTambahKriteriaPencarian').click(function () {
		var org_id = $('#slcEcommerceOrganization').val();
		var org_op = $('#slcEcommerceOrganization option[value="' + org_id + '"]').html().replace(/\s/g, '');
		var sub_in = $('#slcEcommerceSubInventory').val();

		var org_ar = org_op.split("-");

		// alert(org_id+'/'+org_ar[0]+'-'+sub_in);

		$('#slcEcommerceKriteriaCari').append('<option value="' + org_id + '/' + sub_in + '" selected>' + org_ar[0] + ' - ' + sub_in + '</option>').trigger('change');
		$('#btnSearchEcommerceItem').removeAttr('disabled');
	});

	$('#btnSearchEcommerceItem').click(function () {
		$('#searchResultTableItemBySubInventory').html('<img src="' + baseurl + '/assets/img/gif/loading12.gif">');
		$('#slcEcommerceSubInventory').attr('disabled', 'disabled');
		$('#slcEcommerceOrganization').attr('disabled', 'disabled');

		var kriteria = $('#slcEcommerceKriteriaCari').val();

		$.ajax({
			type: "POST",
			url: baseurl + "ECommerce/SearchItem/getItemBySubInventory",
			data: {
				kriteria: kriteria,
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
						customize: function (xlsx) {
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

	$('#dataWaktuOrder').DataTable({
		scrollX: true,
		"pagingType": "full_numbers"
	});

	$('#btn-search').click(function () {
		$('#searchResultTableItemByDate').html('<img src="' + baseurl + '/assets/img/gif/loading12.gif">');
	});

	// $("#tanggalan").datepicker({
	// 	format: "dd/mm/yyyy",
	// 	autoclose: true,
	// });

});


// export excel pelanggan
$(document).ready(function () {
	$('#user_id').select2({
		placeholder: "NAMA USER"
	});
	$('#cat_name').select2({
		placeholder: "ITEM CATEGORY"
	});
	$('#item_name').select2({
		placeholder: "ITEM NAME"
	});

	$('#user_id').change(function () {
		var org_id = $('#user_id').val();
		console.log(org_id);
		$('#btn-export').removeAttr('disabled');
		$('#btn-search-export').removeAttr('disabled');
	});
	$('#cat_name').change(function () {
		$('#btn-export').removeAttr('disabled');
		$('#btn-search-export').removeAttr('disabled');
	});
	$('#item_name').change(function () {
		$('#btn-export').removeAttr('disabled');
		$('#btn-search-export').removeAttr('disabled');
	});

	$('#btn-search-export').click(function () {
		var name = $('#user_id').val();
		var cat_name = $('#cat_name').val();
		var item_name = $('#item_name').val();
		console.log(name, cat_name, item_name);

		if (!$('#cat_name').val()) {
			console.log("cat_name tidak ada")
		} else if ($('#cat_name').val() && !$('#item_name').val()) {
			console.log("cat_name ada")
		} else if ($('#cat_name').val() && $('#item_name').val()) {
			console.log("item_name ada")
		}

	});
	$('#btn-name').on('click', function () {
		var name = $('#user_id').val();
		console.log('tes')
		if ($('#user_id').attr('disabled')) {
			$('#user_id').removeAttr('disabled');
			$('#btn-name').html('Disable');
			$('#btn-name').addClass('btn-danger');
			$('#btn-name').removeClass('btn-success');
			if (name.length > 0) {
				$('#btn-export').removeAttr('disabled');
				$('#btn-search-export').removeAttr('disabled');
			} else {
				console.log(name)
			}
		} else {
			$('#user_id').attr('disabled', 'disabled');
			$('#btn-name').html('Enable');
			$('#btn-name').addClass('btn-success');
			$('#btn-name').removeClass('btn-danger');
			if ($('#cat_name').attr('disabled')) {
				if ($('#item_name').attr('disabled')) {
					$('#btn-export').attr('disabled', 'disabled');
					$('#btn-search-export').attr('disabled', 'disabled');
				} else {
					console.log("enable")
				}
			} else {
				console.log("enable")
			}
		}
	})
	$('#btn-cat').on('click', function () {
		console.log('tes')
		var cat_name = $('#cat_name').val();
		if ($('#cat_name').attr('disabled')) {
			$('#cat_name').removeAttr('disabled');
			$('#btn-cat').html('Disable');
			$('#btn-cat').addClass('btn-danger');
			$('#btn-cat').removeClass('btn-success');
			if (cat_name.length > 0) {
				$('#btn-export').removeAttr('disabled');
				$('#btn-search-export').removeAttr('disabled');
			} else {
				console.log(cat_name)
			}
		} else {
			$('#cat_name').attr('disabled', 'disabled');
			$('#btn-cat').html('Enable');
			$('#btn-cat').addClass('btn-success');
			$('#btn-cat').removeClass('btn-danger');
			if ($('#item_name').attr('disabled')) {
				if ($('#user_id').attr('disabled')) {
					$('#btn-export').attr('disabled', 'disabled');
					$('#btn-search-export').attr('disabled', 'disabled');
				} else {
					console.log("enable")
				}
			} else {
				console.log("enable")
			}
		}
	})
	$(document).ready(function () {
		$("#dateBegin").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
		});
		$("#dateEnd").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
		});
	})
	$('#btn-item').on('click', function () {
		var item_name = $('#item_name').val();
		console.log('tes')
		if ($('#item_name').attr('disabled')) {
			$('#item_name').removeAttr('disabled');
			$('#btn-item').html('Disable');
			$('#btn-item').addClass('btn-danger');
			$('#btn-item').removeClass('btn-success');
			if (item_name.length > 0) {
				$('#btn-export').removeAttr('disabled');
				$('#btn-search-export').removeAttr('disabled');
			} else {
				console.log(item_name)
			}
		} else {
			$('#item_name').attr('disabled', 'disabled');
			$('#btn-item').html('Enable');
			$('#btn-item').addClass('btn-success');
			$('#btn-item').removeClass('btn-danger');
			if ($('#user_id').attr('disabled')) {
				if ($('#cat_name').attr('disabled')) {
					$('#btn-export').attr('disabled', 'disabled');
					$('#btn-search-export').attr('disabled', 'disabled');
				} else {
					console.log("enable")
				}
			} else {
				console.log("enable")
			}
		}
	})

	$('#btn-search-export2').click(function () {
		$('#searchResultTableItemByDate').html('<img src="' + baseurl + '/assets/img/gif/loading12.gif">');
	});
	$(".tanggalanExport").datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
	});

	dataExport();

	function dataExport() {
		// function dataExport() {
		$('#dataTableExport').DataTable({
			// dom: '<fl<t>ip>',
			scrollX: true,
			ajax: {
				url: baseurl + "ECommerce/ExportPelanggan/tableExportAll/",
				type: 'POST',
			},
			ordering: false,
			pageLength: 10,
			"pagingType": "first_last_numbers",
			processing: true,
			serverSide: false
		});
	}

	// }

	$('#dataTableExportTable').DataTable({
		scrollX: true,
		"pagingType": "full_numbers"
	});
	$('#dataTableExportTable2').DataTable({
		scrollX: true,
		"pagingType": "full_numbers"
	});
});