function org_selection(th) {
	var select = $('#slcOrgSM').val()
	var order = jQuery('select[name=txt_order_type_list]');

	$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/salestarget/filterOrganization",
			dataType: 'JSON',
			data:{
					select:select,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.NAME+'">'+item.NAME+'</option>'
					val1 = item.NAME
				})	

				order.html(dataItem1);
				order.val(response[0].NAME);
				order.trigger('change')

			}
		})
}

function openDetailOrg(th) {
		var org_id = th;

		$('modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"SalesMonitoring/setting_org/openMdlDetail",
			data:{
				org_id:org_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
			}
		})
	}

	function deleteeeRow(th) {
		var org_id = th;

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/deleteOrg",
			data:{
					org_id:org_id,
				},
			success: function(response) {

				$('#tbodySetupSM .'+th).remove();
				Swal.fire({
								  type: 'success',
								  title: 'OK! Organization berhasil dihapus',
								  showConfirmButton: false,
								  timer: 1000
							})


	}
})
	}

	function province_filter(th) {
		var prov = $('#slcProvinsi').val()
		var city = jQuery('select[name=slcKotaKab]')

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterCity",
			dataType: 'JSON',
			data:{
					prov:prov,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.city_regency_id+'">'+item.regency_name+'</option>'
					val1 = item.regency_name
				})	

				city.html(dataItem1);
				city.val(response[0].city_regency_id);
				city.trigger('change')

			}
		})
	}

	function kotakab_filter(th) {
		var city = $('#slcKotaKab').val();
		var kecamatan = jQuery('select[name=slcKecamatan]');

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterDistrict",
			dataType: 'JSON',
			data:{
					city:city,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.district_id+'">'+item.district_name+'</option>'
					val1 = item.district_name
				})	

				kecamatan.html(dataItem1);
				kecamatan.val(response[0].district_id);
				kecamatan.trigger('change')

			}
		})
	}

	function district_filterr(th) {
		var kcmtn = $('#slcKecamatan').val();
		var desa = $('#slcKelurahanDesa');

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterVillage",
			dataType: 'JSON',
			data:{
					kcmtn:kcmtn,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.village_id+'">'+item.village_name+'</option>'
					val1 = item.village_name
				})	

				desa.html(dataItem1);
				desa.val(response[0].village_id);
				desa.trigger('change')

			}
		})

	}

	function addRowSetupSM(th) {

		var province = $('#slcProvinsi').val() ;
		var city = $('#slcKotaKab').val();
		var kecamatan = $('#slcKecamatan').val();
		var kelurahan = $('#slcKelurahanDesa').val();
		var org_code = $('#org_code').val();
		var org_id = $('#org_id').val();
		var org_name = $('#org_name').val();
		var alamat = $('#alamat_id').val();

		if (org_code == '') {
			Swal.fire({
				  type: 'info',
				  title: 'Harap isi Organization Code!',
				  showConfirmButton: false,
				  timer: 1000
			})

		}else if (org_id == '') {
			Swal.fire({
				  type: 'info',
				  title: 'Harap isi Organization ID!',
				  showConfirmButton: false,
				  timer: 1000
			})

		}else if (org_name == '') {
			Swal.fire({
				  type: 'info',
				  title: 'Harap isi Organization Name!',
				  showConfirmButton: false,
				  timer: 1000
			})

		}else if (alamat == '') {
			Swal.fire({
				  type: 'info',
				  title: 'Harap isi Alamat!',
				  showConfirmButton: false,
				  timer: 1000
			})

		}else {

			$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/saveSetupOrg",
			dataType: 'JSON',
			data:{
					province:province,
					city:city,
					kecamatan:kecamatan,
					kelurahan:kelurahan,
					org_code:org_code,
					org_id:org_id,
					org_name:org_name,
					alamat:alamat,
				},
			success: function(response) {
					if (response == '0'){
						Swal.fire({
								  type: 'error',
								  title: 'Ops! data sudah pernah diinputkan sebelumnya',
								  showConfirmButton: false,
								  timer: 1000
							})
					}else if (response == '1'){
						Swal.fire({
								  type: 'success',
								  title: 'Selamat! data berhasil diinput',
								  showConfirmButton: false,
								  timer: 1000
							})
						window.location.reload();
					}

				}
			})
		}
		

	}

function testtt(th) {
	var select = $('#slcOrgSM2').val()
	var order = jQuery('input#ordertype_id');


	$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_order/createPlaceHolder",
			dataType: 'JSON',
			data:{
					select:select,
				},
			success: function(response) {
				order.val(response+'-').trigger('change');
				showTable(response)
			}
		})
}

function showTable(th) {
	var panel = $('.tabel-setup-sales-monitoring');
	var select = th;

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

	$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_order/showTable",
			data:{
					select:select,
				},
			success: function(response) {
				panel.html(response)
				Swal.close()
			}
		})

}

function deleteeeOrderType(th) {
		var item_id = th;
		var order_old = $('input#'+th).val();


		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_order/deleteOrder",
			data:{
					item_id:item_id,
				},
			success: function(response) {

				$('#tbodyOrderSM .'+th).remove();

				Swal.fire({
								  type: 'success',
								  title: 'OK! '+order_old+' berhasil dihapus',
								  showConfirmButton: true,
								  // timer: 1000
							})
			}
		})
	}

	function insertOrder(th) {
		var order_type = $('#ordertype_id').val()
		var param = $('#slcOrgSM2').val()

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_order/insertOrder",
			data:{
					order_type:order_type,
					param:param
				},
			success: function(response) {

				Swal.fire({
								  type: 'success',
								  title: 'OK! Order Type berhasil diinput',
								  showConfirmButton: false,
								  timer: 1000
							})
				window.location.reload();
			}
		})
	}


function openDetailOrderSM(th) {

	var item_id = th;
	$('h5.modal-title').html('EDIT ORDER TYPE')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"SalesMonitoring/setting_order/detailOrderEdit",
			data:{
				item_id:item_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="editOrderSM('+th+')" id="btnSave"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

function editOrderSM(th) {
	var item_id = th;
	var new_order = $('#ordertype_id_edit').val();

	$.ajax({
			type: "post",
			url: baseurl+"SalesMonitoring/setting_order/updateOrder",
			data:{
				item_id:item_id,
				new_order:new_order
			},
			success: function(response){
				Swal.fire({
								  type: 'success',
								  title: 'OK! '+new_order+' berhasil diedit',
								  showConfirmButton: false,
								  timer: 1000
							})

				$('#MdlEditOrderSM').modal('hide');
				window.location.reload();
			}
		})

}
	