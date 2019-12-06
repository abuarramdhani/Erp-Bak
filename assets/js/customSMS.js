// -----------------------------------------------------------------UMUM---------------------------------------------------------------
$('.timeMPM').timepicker();

$( document ).ready(function() {
	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
})

$('.time-set').datetimepicker({
          locale : 'id'
    });	

$('tbody#blinking_td tr:first-child').css('background-color', '#c9efff');

// .addClass('blink_me')
// $(document).ready(function() {
//     var table = $('.tb_responsive_sms').DataTable( {
//         responsive: true,
//         fixedHeader: true,
//     } );
 
// } );	



$(document).ready(function(){
	$('.tb_responsive_sms').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
		"zeroRecords": " "             
		}
	})

	})

$(document).ready(function(){
	$('.tb_setup_sms').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
		"zeroRecords": " "             
		}
	})

	})


$(document).ready(function(){
	$('.table-historysms').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
		"zeroRecords": " "             
		}
	})

	})

// var timeDown = 1;
// Set the date we're counting down to

// timeDown++
//--------------------------------------------------------------ONCHANGE-----------------------------------------------------------------//

function detailDO(th) {
	var no_ship = th;
	
	$('#MdlSMS').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/detailDO",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function selectTujuan () {//ON CHANGE TUJUAN DI NEW SHIPMENT 
	var noncabang = $('#cabangsms').val();
	var prov = jQuery('select[name=provinsi]');
	var city = jQuery('select[name=kota]');

	if (noncabang != '2' ) {
		var alamat = $('.inialamatplz').prop('readonly', true);
		prov.prop('readonly', false);
		city.prop('readonly', false);

		$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/DetailCabang",
			dataType: 'JSON',
			data:{
					noncabang:noncabang,
				},
			success: function(response) {
			var dataItem1 = '';
			var dataItem2 = '';
			var dataItem3 = '';
			var val1 = '';	
			var val2 = '';

			// console.log(response)
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
					val1 = item.city_id
					val2 = item.province_id					
					// dataItem2 += '<option value="'+item.province_id+'">'+item.province_name+'</option>'
					dataItem3 += item.address
				})	
				var alamat = $('.inialamatplz')
				
				
				prov.val(val2);
				prov.trigger('change');
				alamat.val(dataItem3);
				// alamat.trigger('change');

				city.html(dataItem1);
				city.val(response[0].city_id);
				city.trigger('change')
				
				
			}

		});
	} else if (noncabang == '2') {
		prov.prop('disabled', false);
		prov.val(null).trigger('change');
		city.prop('disabled', true);
		city.val(null).trigger('change');
		var alamat = $('.inialamatplz').prop('readonly', true);
		alamat.val(null).trigger('change');

	}
}

function selectTipBar () {//ON CHANGE TUJUAN DI titip barang
	var noncabang = $('#cabangsmstb').val();
	var prov = jQuery('select[name=provinsi]');
	var city = jQuery('select[name=kota]');

	if (noncabang != '2' ) {
		var alamat = $('.inialamatplz').prop('readonly', true);
		prov.prop('readonly', false);
		city.prop('readonly', false);

		$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/DetailCabang",
			dataType: 'JSON',
			data:{
					noncabang:noncabang,
				},
			success: function(response) {
			var dataItem1 = '';
			var dataItem2 = '';
			var dataItem3 = '';
			var val1 = '';	
			var val2 = '';

			// console.log(response)
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
					val1 = item.city_id
					val2 = item.province_id					
					// dataItem2 += '<option value="'+item.province_id+'">'+item.province_name+'</option>'
					dataItem3 += item.address
				})	
				var alamat = $('.inialamatplz')
				
				
				prov.val(val2);
				prov.trigger('change');
				alamat.val(dataItem3);
				// alamat.trigger('change');

				city.html(dataItem1);
				city.val(response[0].city_id);
				city.trigger('change')
				
				
			}

		});
	} else if (noncabang == '2') {
		prov.prop('disabled', false);
		prov.val(null).trigger('change');
		city.prop('disabled', true);
		city.val(null).trigger('change');
		var alamat = $('.inialamatplz').prop('readonly', true);
		alamat.val(null).trigger('change');

	}
}


function selectTujuanUpdate () { //SELECT TUJUAN DI BAGIAN FIND SHIPMENT
	var noncabang = $('#cabangsms1').val();
	var prov = jQuery('select[name=provinsi1]');
	var city = jQuery('select[name=kotasms]');

	if (noncabang != '2' ) {
		var alamat = $('.alalalamat').prop('readonly', true);
		prov.prop('readonly', true);
		city.prop('readonly', true);

		$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/DetailCabang",
			dataType: 'JSON',
			data:{
					noncabang:noncabang,
				},
			success: function(response) {
			var dataItem1 = '';
			var dataItem2 = '';
			var dataItem3 = '';
			var val1 = '';	
			var val2 = '';

			// console.log(response)
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
					val1 = item.city_id
					val2 = item.province_id					
					// dataItem2 += '<option value="'+item.province_id+'">'+item.province_name+'</option>'
					dataItem3 += item.address
				})	
				var alamat = $('.alalalamat')
				
				
				prov.val(val2);
				prov.trigger('change');
				alamat.val(dataItem3)
				alamat.trigger('change');

				city.html(dataItem1);
				city.val(response[0].city_id);
				city.trigger('change')
				
				
			}

		});
	} else if (noncabang == '2') {
		prov.prop('disabled', false);
		prov.val(null).trigger('change');
		city.prop('disabled', true);
		city.val(null).trigger('change');
		var alamat = $('#alamatsms1').prop('readonly', true);
		alamat.val(null).trigger('change');

	}


}


function cariVolume() { //MENGHITUNG VOLUME DAN PERSENTASE NYA DI NEW SHIPMENT
	var idJk = $('select[name=jk]').val();

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/selectVolume",
			dataType: 'JSON',
			data:{
					vehicle_id_sms:idJk,
				},
			success: function(response) {
			// console.log(response)
			var dataItem = '';
			$.each(response, (i, item) => {
					dataItem += item.volume_cm3
			})	
			var vol = jQuery('input[name=vksms]');
			vol.val(dataItem);
			// city.prop('disabled', false);
			// var alamat = $('#alamatsms').prop('readonly', false);

			//cari line item
			$('.select_gud').each((i, item) => {
				volumeline(item)
			})
	 		}

		});

	
}

function volumeline(th) { //PERSENTASE VOLUME
	var row = $(th).closest('tr')
	var idUnit = row.find('.select_gud').val();
	var qty = row.find('.jumlahsms').val();
	var seratus = $('#vksms').val();
	var totalsemua = $('.fullpersenya');

	if (idUnit == ""){
		console.log("kosong");
		return 
	}
	// console.log(totalsemua, 'totalsemua')

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/selectUnitVolume",
			dataType: 'JSON',
			data:{
					idUnit:idUnit,
				},
			success: function(response) {
			// console.log(response)
			var dataItem = '';
			$.each(response, (i, item) => {
					dataItem = (Number(item.volume_cm3) * Number(qty))
			})	
			var vol = row.find('.jumlahvol');
			vol.val(dataItem);
			var pers = row.find('.persentasevolsms');
			pers.val(Number(((dataItem) / Number(seratus) * 100)).toFixed(2))
			totalPers = 0;
			$('.persentasevolsms').each((i, item) => { 
				totalPers += Number(item.value);
			})
			totalsemua.val((totalPers).toFixed(2));

			if (Number(totalsemua.val()) > 100) {
				totalsemua.css('background-color', 'red')
				Swal.fire({
				  type: 'error',
				  title: 'Muatan melebihi 100%!',
				  showConfirmButton: false,
				  timer: 1000
			})
				$('.statussms').val('Y').trigger('change');
			} else if ((Number(totalsemua.val()) < 100)){
				totalsemua.css('background-color', 'white');
				$('.statussms').val('N').trigger('change');
			}

			// $('.jumlahsms').each((i, item) => {
			// 	qty.val(item)
			// })
			// console.log(totalsemua);
	 		}


		});

	
}

function selectKota(th) { //ONCHANGE PILIH KOTA

	var idProv2 = $('select[name=provinsi]').val();
	let cabang = $('#cabangsms').val();
	if (cabang != '2') {
		return ;
	}
	// console.log(idProv2)

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/SelectCity",
			dataType: 'JSON',
			data:{
					idprovinsi:idProv2,
				},

			success: function(response) {
				var dataItem = '';
				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
				})	
				var city = jQuery('select[name=kota]');
				city.html(dataItem);
				city.prop('disabled', false);
				var alamat = $('#alamatsms').prop('readonly', false);

	 		}

		});


}

function selectKotaTitipBarang(th) { //ONCHANGE PILIH KOTA

	var idProv2 = $('select[name=provinsi]').val();
	let cabang = $('#cabangsmstb').val();
	if (cabang != '2') {
		return ;
	}
	// console.log(idProv2)

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/SelectCity",
			dataType: 'JSON',
			data:{
					idprovinsi:idProv2,
				},

			success: function(response) {
				var dataItem = '';
				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
				})	
				var city = jQuery('select[name=kota]');
				city.html(dataItem);
				city.prop('disabled', false);
				var alamat = $('#alamatsmstb').prop('readonly', false);

	 		}

		});


}

function selectKotaSetup () { //ONCHANGE PILIH KOTA DI SETUP
	var id_propinsi = $('.provinsi_cabang').val();
	// console.log(id_propinsi);

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/SelectCity",
			dataType: 'JSON',
			data:{
					idprovinsi:id_propinsi,
				},

			success: function(response) {
				var dataItem = '';
				var valsetup = '';
				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
					valsetup = item.city_id;
				})	
				var city = jQuery('select.kota_cabang');
				city.html(dataItem);
				city.trigger('change');

	 		}


	})
}

function selectKotaKota(th) { //ONCHANGE PILIH KOTA DI FIND SHIPMENT

	var idProv2 = $('select[name=provinsi1]').val();
	let cabang = $('#cabangsms1').val();
	if (cabang != '2') {
		return ;
	}
	console.log(idProv2)

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/FindShipment/SelectCityAgain",
			dataType: 'JSON',
			data:{
					idprovinsiagain:idProv2,
				},

			success: function(response) {
				var dataItem = '';
				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
				})	
				var city = jQuery('select[name=kotasms]');
				city.html(dataItem);
				city.prop('disabled', false);
				var alamat = $('.alalalamat').prop('readonly', false);
				// console.log(dataItem);
	 		}

		});


}

function provinsisetup() { //ONCHANGE PILIH PROVINSI DI SETUP

	var idProv = $('select[name=provinsisetup]').val();

	$.ajax({
			method: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/SelectCityforCabang",
			dataType: 'JSON',
			data:{
					idProv:idProv,
				},

			success: function(response) {
				var dataItem = '';
				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.city_id+'">'+item.city_name+'</option>'
				})	
				var city = jQuery('select[name=kotasetup]');
				city.html(dataItem);

	 		}

		});


}

//--------------------------------------------------------------SMS GENERAL--------------------------------------------------------------------//

function detailPR(th1, th2) { //MODAL UNTUK DETAIL PR
	var pr_line = th1;
	var pr_number = th2;
	
	$('#MdlSMS').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/NewShipment/detailPR",
			data:{
				id:pr_number,
				line:pr_line
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function detailPRGdg(th1, th2) { //MODAL UNTUK DETAIL PR
	var pr_line = th1;
	var pr_number = th2;
	
	$('#MdlSMS').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/Gudang/detailPR",
			data:{
				id:pr_number,
				line:pr_line
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function detailShpUndeliver(th) {
	var nomer_shipment = th;

	$('#MdlDetailShpUndeliver').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/Undelivered/detailShpUndeliver",
			data:{
				id:nomer_shipment,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

}

function DeleteShipment(th) { //MODAL CONFIRMATION UNTUK DELETE SHIPMENT
	var id = th
	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Shipment Akan Dihapus',
		  text: 'Yakin ingin menghapus Shipment No.'+id+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"ShipmentMonitoringSystem/FindShipment/deleteShipment",
					data:{
						id_shipment:id,
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Shipment No.'+id+' berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Shipment No.'+id+' batal dihapus :)',
      'error'
    )
  }
})
}

function DeleteShipment_Gudang(th) { //MODAL CONFIRMATION UNTUK DELETE SHIPMENT GUDANG
	var id = th
	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Shipment Akan Dihapus',
		  text: 'Yakin ingin menghapus Shipment No.'+id+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"ShipmentMonitoringSystem/Gudang/FindShipment/deleteShipment",
					data:{
						id_shipment:id,
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Shipment No.'+id+' berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Shipment No.'+id+' batal dihapus :)',
      'error'
    )
  }
})
}

	$('#btn_search_sms').click(function(){ //BUTTON IN FIND SHIPMENT FOR SEARCHING
		$('#loading_mpm').html("<center><img id='loading99' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/FindShipment/btn_search_sms",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#unitpunya').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})

	$('#btn_search_sms_gudang').click(function(){ //BUTTON FIND SHIPMENT FOR SEARCHING IN INVENTORY
		$('#loading_mpm').html("<center><img id='loading99' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/Gudang/FindShipment/btn_search_sms_gudang",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#unitpunya').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})

var num = 2;
function addRowSms(){ //APPEND DI NEW SHIPMENT
    var unit = "";
    var jumlah = "";

    $.ajax({
		type: "GET",
		url: baseurl+"ShipmentMonitoringSystem/NewShipment/getRow",
		dataType: 'json'
	}).done(function(result){
		// kolom 1 
		var html = '<tr class="number'+num+'"><td>'+num+'</td>';
		// kolom 2
		html += '<td><input type="number" onchange="volumeline(this)" class="form-control jumlahsms" style="width: 100%" type="text" id="jumlahsms_id" name="jumlahsms[]"></td>';
		// kolom 3
		html += '<td><select id="unitsms_id" name="unitsms[]" class="form-control selectUnitMPM select_gud" style="width:100%;" onchange="volumeline(this)" onFocus="onBakso1()">';
		html += '<option value="" > Pilih  </option>';
		$.each(result, function(i,item) {
			html += '<option value="'+item.goods_id+'">'+item.goods_name+'</option>';
        })
        html += "</select></td>";
        // kolom 4
        html += '<td><input class="form-control no_do" value="0" style="width: 100%" type="text" id="nomor_do_id" name="nomor_do"></td>'
        html += '<td><input id="jumlahvolinsert" class="form-control jumlahvol" style="width: 100%" type="text"  name="jumlahvol[]" readonly="true"></td>'
        html += '<td><input class="form-control persentasevolsms" style="width: 100%" type="text" id="persentasevolsmsinsert" name="persentasevolsms" readonly="true"></td>'
		html += '<td><button type="button" onClick="onClickBakso11('+num+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	num++;
    	$('#tabelAddsms').append(html);

    	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
	

	});


}

const onClickBakso11 = (th) => { //FUNCTION DELETE SHIPMENT LINE DAN DELETE TOTAL PERSENTASE VOLUME

	var bil_pengurang = $('tr.number'+th+' input.persentasevolsms').val()
	console.log(bil_pengurang)
	var persen_awal = $('.fullpersenya')
	var persen_value = $('.fullpersenya').val()
	var persen_total = (Number(persen_value) - Number(bil_pengurang))
	persen_awal.val((persen_total).toFixed(2))

	if (Number(persen_awal.val()) > 100) {
				persen_awal.css('background-color', 'red')
				Swal.fire({
				  type: 'error',
				  title: 'Muatan melebihi 100%!',
				  showConfirmButton: false,
				  timer: 1000
			})
				$('.statussms').val('Y').trigger('change');
			} else {
				persen_awal.css('background-color', 'white');
				$('.statussms').val('N').trigger('change');
			}

	$('tr.number'+th).remove()
		num -=1
}



function addRowSms2(){ //APPEND DI FIND SHIPMENT EDIT 
	var numb = Number($('.findtabelsms tr:last td.editnum').text())
	// console.log(numb);
	var unit = "";
    var jumlah = "";

    $.ajax({
		type: "GET",
		url: baseurl+"ShipmentMonitoringSystem/NewShipment/getRowupdate",
		dataType: 'json'
	}).done(function(result){
		// console.log(result)
		// console.log("num atas", numb);
		// kolom 1 nomor
		var html = '<tr class="numberedit'+(numb+1)+'"><td class="editnum">'+(numb+1)+'</td>';
		// kolom 2 jumlah
		html += '<td><input type="number" onchange="volumeline(this)" class="form-control jumlahsms" style="width: 100%" type="text" id="jumlahsmsedit_id" name="jumlahsms[]"></td>';
		// kolom 3 select
		html += '<td><select id="unitsms_id" name="unitsms[]" onchange="volumeline(this)" class="selectUnitMPM select_gud form-control" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.unit, function(item) {
			// console.log(item);
			html += '<option value="'+item.goods_id+'">'+item.goods_name+'</option>';
			// console.log(item)
        })
        html += "</select></td>";
        html += '<td><input type="text" class="form-control nomor_do" style="width: 100%" type="text" id="nomor_do_id1" name="nomor_do1" value="0"> </input></td>'
        html += '<td><input class="form-control jumlahvol" id="jumlahvol_id" style="width: 100%" type="text"  name="jumlahvol1" readonly="true"></td>'
        html += '<td><input class="form-control persentasevolsms" style="width: 100%" type="text" id="persentasevolsms" name="persentasevolsms" readonly="true"></td>'
		// $.map(result.user, function(item) {
		// 	console.log(item);
		html += '<td><input type="text" class="form-control created_line" value="'+result.user+'" style="width: 100%" type="text" id="created_line" name="created_line"></td>';
        // })
        // kolom 6
		html += '<td><button type="button" onClick="myFunction1('+(numb+1)+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	numb++;

    	$('#tabelAddSmsEdit').append(html);

    	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
		// console.log("num tengah", num);

		// console.log("num bawah", num);

	});


}

const myFunction1 = (th) => { //FUNCTION DELETE SHIPMENT DI FINDSHIPMENT EDIT
	// console.log(th, "bakso")
	var bil_pengurang = $('tr.numberedit'+th+' input.persentasevolsms').val()
	// console.log(bil_pengurang)
	var persen_awal = $('.fullpersenya')
	var persen_value = $('.fullpersenya').val()
	var persen_total = (Number(persen_value) - Number(bil_pengurang))
	persen_awal.val((persen_total).toFixed(2))


	if (Number(persen_awal.val()) > 100) {
				persen_awal.css('background-color', 'red')
				Swal.fire({
				  type: 'error',
				  title: 'Muatan melebihi 100%!',
				  showConfirmButton: false,
				  timer: 1000
			})
				$('.statussms').val('Y').trigger('change');
			} else {
				persen_awal.css('background-color', 'white');
				$('.statussms').val('N').trigger('change');
			}
	$('tr.numberedit'+th).remove()
		num -=1

}

const deleteEdit1 = (th) => { 
	var bil_pengurang = $('tr#ini_id'+th+' input.persentasevolsms').val()
	// console.log(bil_pengurang)
	var persen_awal = $('.fullpersenya')
	var persen_value = $('.fullpersenya').val()
	var persen_total = (Number(persen_value) - Number(bil_pengurang))
	persen_awal.val((persen_total).toFixed(2))

	if (Number(persen_awal.val()) > 100) {
				persen_awal.css('background-color', 'red')
				Swal.fire({
				  type: 'error',
				  title: 'Muatan melebihi 100%!',
				  showConfirmButton: false,
				  timer: 1000
			})
				$('.statussms').val('Y').trigger('change');
			} else {
				persen_awal.css('background-color', 'white');
				$('.statussms').val('N').trigger('change');
			}

	$('tr#ini_id'+th).remove()
		num -=1

}



function ModalDetailSMS(th) { //MODAL YANG NGELUARIN FIND SHIPMENT
	
	var no_ship = th

	$('#MdlMPM').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/FindShipment/btn_edit_sms",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function ModalDetailSMS_Gudang(th) { //MODAL DETAIL PUNYA GUDANG
	
	var no_ship = th

	$('#MdlMPM').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width: 200px;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/Gudang/FindShipment/btn_edit_sms",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}


function saveSMS(){ //PROSES SAVING DI NEW SHIPMENT
		var estimasiSMS = $('#estimasi_brkt').val();
		var finish_goodSMS = $('#finishgud').val();
		var statusSMS = $('#statussms').val();
		var cabangSMS = $('#cabangsms').val();
		var provSMS = $('#provinsisms').val();
		var kotaSMS = $('#kotasms').val();
		var jkSMS = $('#jksms').val();
		var estimasi_loadingSMS = $('#estimasi_loading').val();
		var alamatSMS = $('#alamatsms').val();
		var pr_number = $('#pr_numbersms').val();
		var pr_line = $('#pr_linesms').val();
		var precentage_sms = $('#fullpersen').val();
		var volume_line = $('#jumlahvolinsert').val();
		var percentage_line = $('#persentasevolsmsinsert').val();

		// console.log(provSMS, kotaSMS)
		var arry = [];
		$('select#unitsms_id').each(function(){
		var unit = $(this).val();
		arry.push(unit);
		});

		var arry1 = [];
		$('input#jumlahsms_id').each(function(){
		var jumlah = $(this).val();
		arry1.push(jumlah);
		});

		var arry2 = [];
		$('input#jumlahvolinsert').each(function(){
		var jumlahvolinsert = $(this).val();
		arry2.push(jumlahvolinsert);
		});

		var arry3 = [];
		$('input#persentasevolsmsinsert').each(function(){
		var persentasevolsmsinsert = $(this).val();
		arry3.push(persentasevolsmsinsert);
		});

		var arry4 = [];
		$('input#nomor_do_id').each(function(){
		var nomor_do = $(this).val();
		arry4.push(nomor_do);
		});


		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/NewShipment/saveSMS",
		data:{
			estimasi: estimasiSMS,
			finish_good: finish_goodSMS,
			status: statusSMS,
			cabang: cabangSMS,
			prov: provSMS,
			city: kotaSMS,		
			jk: jkSMS,
			estimasi_loading:estimasi_loadingSMS,
			alamat: alamatSMS,
			pr_number: pr_number,
			pr_line: pr_line,			
			unit: arry,
			jumlah: arry1,
			percentage: precentage_sms,
			volume_line:arry2,
			percentage_line:arry3,
			nomor_do:arry4
		},
		success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			// window.location.reload();
			window.location.replace(baseurl+"ShipmentMonitoringSystem/")
		}
	})

	}
			
function saveEditSMS(th){ //PROSES SAVING EDIT 
	
		var no_ship = th
		var estimasi = $('#estimasi_brkt1').val();
		var finish_good = $('#finishgud1').val();
		var status = $('#status1').val();
		var jk = $('#jk1').val();
		var estimasi_loading = $('#estimasi_loading1').val();
		var cabang = $('#cabangsms1').val();
		var pr_nomer = $('#pr_number1').val();
		var pr_lein = $('#pr_line1').val();
		var provinsiyeah = $('#provinsi1').val();
		var citi = $('#kota1').val();
		var rumah = $('#alamatsms1').val();
		var full_persen = $('#fullpersen1').val();
		var created_header = $('#created_by').val();

		var arry2 = [];
		$('select#unitsms_id').each(function(){
		var unit = $(this).val();
		arry2.push(unit);
		});

		var arry3 = [];
		$('input#jumlahsmsedit_id').each(function(){
		var jumlah = $(this).val();
		arry3.push(jumlah);
		});

		var arry4 = [];
		$('input#jumlahvol_id').each(function(){
		var jumlahvol = $(this).val();
		arry4.push(jumlahvol);
		});

		var arry5= [];
		$('input#persentasevolsms').each(function(){
		var persentasevol = $(this).val();
		arry5.push(persentasevol);
		})

		var arry6= [];
		$('input#nomor_do_id1').each(function(){
		var nomor_do = $(this).val();
		arry6.push(nomor_do);
		})


		var arry7= [];
		$('input#created_line').each(function(){
		var created_line = $(this).val();
		arry7.push(created_line);
		})



		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/FindShipment/saveEditMPMUnit",
		data:{
			 no_ship:no_ship,
			 estimasi:estimasi,
			 finish_good:finish_good,
			 status:status, 
			 jk:jk,
			 estimasi_loading:estimasi_loading, 
			 cabang:cabang,
			 pr_nomer:pr_nomer,
			 pr_lein:pr_lein,
			 provinsiyeah:provinsiyeah, 
			 citi:citi,
			 rumah:rumah, 
			 full_persen:full_persen,
			 created_header:created_header,
			 unitgud:arry2,
			 jumlahsms:arry3,
			 jumlahvol:arry4,
			 persentasevol:arry5,
			 nomor_do:arry6,
			 created_line:arry7
		},
		success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			
		$('#MdlMPM').modal('hide');
			// window.location.reload();
			window.location.replace(baseurl+"ShipmentMonitoringSystem/")
			
		}
	})

	}

	function saveEditSMSGudang(th){ //PROSES SAVING UPDATE DI SMS GUDANG
	
		var no_ship = th
		var estimasi = $('#estimasi_brkt1').val();
		var finish_good = $('#finishgud1').val();
		var status = $('#status1').val();
		var jk = $('#jk1').val();
		var estimasi_loading = $('#estimasi_loading1').val();
		var cabang = $('#cabangsms1').val();
		var pr_nomer = $('#pr_number1').val();
		var pr_lein = $('#pr_line1').val();
		var provinsiyeah = $('#provinsi1').val();
		var citi = $('#kota1').val();
		var rumah = $('#alamatsms1').val();
		var full_persen = $('#fullpersen1').val();
		var created_header = $('#created_by').val();
		var actual_loading = $('#actual_loading').val();
		var actual_berangkat = $('#actual_berangkat').val();
		var nama_driver = $('#nama_driver').val();
		var plat_nomor = $('#plat_nomor').val();

		var arry2 = [];
		$('select#unitsms_id').each(function(){
		var unit = $(this).val();
		arry2.push(unit);
		});

		var arry3 = [];
		$('input#jumlahsmsedit_id').each(function(){
		var jumlah = $(this).val();
		arry3.push(jumlah);
		});

		var arry4 = [];
		$('input#jumlahvol_id').each(function(){
		var jumlahvol = $(this).val();
		arry4.push(jumlahvol);
		});

		var arry5= [];
		$('input#persentasevolsms').each(function(){
		var persentasevol = $(this).val();
		arry5.push(persentasevol);
		})

		var arry6= [];
		$('input#jumlah_terkirim_id').each(function(){
		var jumlah_terkirim = $(this).val();
		arry6.push(jumlah_terkirim);
		})

		var arry7= [];
		$('input#created_line').each(function(){
		var created_line = $(this).val();
		arry7.push(created_line);
		})

		var arry8= [];
		$('input#no_do').each(function(){
		var no_do = $(this).val();
		arry8.push(no_do);
		})



		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/Gudang/FindShipment/UpdateGudang",
		data:{
			 no_ship:no_ship,
			 estimasi:estimasi,
			 finish_good:finish_good,
			 status:status, 
			 jk:jk,
			 estimasi_loading:estimasi_loading, 
			 cabang:cabang,
			 pr_nomer:pr_nomer,
			 pr_lein:pr_lein,
			 provinsiyeah:provinsiyeah, 
			 citi:citi,
			 rumah:rumah, 
			 full_persen:full_persen,
			 created_header:created_header,
			 actual_loading:actual_loading,
			 actual_berangkat:actual_berangkat,
			 nama_driver:nama_driver,
			 plat_nomor:plat_nomor,
			 unitgud:arry2,
			 jumlahsms:arry3,
			 jumlahvol:arry4,
			 persentasevol:arry5,
			 jumlah_terkirim:arry6,
			 created_line:arry7,
			 no_do:arry8
		},
		success: function(response){
		console.log(response)
			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			
		$('#MdlMPM').modal('hide');
			// window.location.reload();
			window.location.replace(baseurl+"ShipmentMonitoringSystem/Gudang")
			
		}
	})

	}

	function saveTitipBarang() {

		var fingo_tb = $('#finishgudtb').val();
		var tujuan_tb = $('#cabangsmstb').val();
		var namabarang_tb = $('#unitsms_idtb').val();
		var provinsi_tb = $('#provinsismstb').val();
		var quantity_tb = $('#jumlahsms_idtb').val();
		var kota_tb = $('#kotasmstb').val();
		var alamat_tb = $('#alamatsmstb').val();

		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/TitipBarang/saveTitipBarang",
		data:{
			 fingo_tb:fingo_tb,
			 tujuan_tb:tujuan_tb,
			 namabarang_tb:namabarang_tb,
			 provinsi_tb:provinsi_tb,
			 quantity_tb:quantity_tb,
			 kota_tb:kota_tb,
			 alamat_tb:alamat_tb,
		},
		success: function(response){
		console.log(response)
			Swal.fire({
			  type: 'success',
			  title: 'Request has been added!',
			  showConfirmButton: false,
			  timer: 1500
			})
			
		// $('#MdlMPM').modal('hide');
			window.location.reload();
			// window.location.replace(baseurl+"ShipmentMonitoringSystem/Gudang")
			
		}
	})


	}

	function saveJumlahAsli(th) {
		var entrusted_id = th;
		var jumlah_asli = $('#jumlah_beneran').val();

		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/Gudang/TitipBarang/saveTitipBarang",
		data:{
			 entrusted_id:entrusted_id,
			 jumlah_asli:jumlah_asli,
		},

		success: function(response){
		// console.log(response)
			Swal.fire({
			  type: 'success',
			  title: 'Barang sejumlah '+jumlah_asli+' telah diterima!',
			  showConfirmButton: false,
			  timer: 1500
			})

			$('#jumlah_beneran').val(jumlah_asli);

			
		// $('#MdlMPM').modal('hide');
			// window.location.reload();
			// window.location.replace(baseurl+"ShipmentMonitoringSystem/Gudang")
			
		}
	})
	}

		function saveJumlahDikirim(th) {
		var entrusted_id = th;
		var jumlah_dikirim = $('#jumlah_dikirim').val();

		$.ajax({
		type: "POST",
		url: baseurl+"ShipmentMonitoringSystem/Gudang/TitipBarang/saveKirimBarang",
		data:{
			 entrusted_id:entrusted_id,
			 jumlah_dikirim:jumlah_dikirim,
		},

		success: function(response){
		console.log(response)
			Swal.fire({
			  type: 'success',
			  title: 'Barang sejumlah '+jumlah_dikirim+' telah dikirim!',
			  showConfirmButton: false,
			  timer: 1500
			})
			$('#jumlah_dikirim').val(jumlah_dikirim).trigger('change')

		// $('#MdlMPM').modal('hide');
			// window.location.reload();
			// window.location.replace(baseurl+"ShipmentMonitoringSystem/Gudang")
			
		}
	})



	}

	function saveSetupUnitSMS() { //PROSES SAVING SETUP GOODS/UNIT
 	var goods_name_set = $('#goods_name_set').val();
 	var volume_unit = $('#volume_unit').val();

 	$.ajax({
 		type : "POST",
 		url : baseurl+"ShipmentMonitoringSystem/SetupUnit/saveSetup",
 		data:{
 			goods_name : goods_name_set,
 			volume_goods : volume_unit,

 		},
 		success: function(response) {
 			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload();
 		}

 	})
 } 

 function saveSetupVehicleSMS() { //PROSES SAVING SETUP VEHICLE
 	var volume_jk_sms = $('#volume_jk_sms').val();
 	var jk_sms = $('#jk_sms').val();

 	$.ajax({
 		type : "POST",
 		url : baseurl+"ShipmentMonitoringSystem/SetupKendaraan/saveSetupJK",
 		data:{
 			vjk : volume_jk_sms,
 			jk : jk_sms,

 		},
 		success: function(response) {
 			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload();
 		}

 	})
 } 


	function OpenModalCabangSMS(th) { //UNTUK MEMBUKA MODAL CABANG
	 	var cabang_id = th

	$('#MdlSetupCbgSMS').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/bukaModalsms",
			data:{
				cabang_id:cabang_id
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}


function DeleteRowGoods(th) { //UNTUK DELETE ROWS PADA SETUP UNIT
	var id = th

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupUnit/deleteRow",
			data:{
				id:id,
			},
			success: function(response) {
				  Swal.fire({
			  type: 'error',
			  title: 'Data has been deleted!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
				  window.location.reload();


			}



		})
	
}


function SaveEditCabangsms(th) { //UNTUK PROSES UPDATE DI SETUP CABANG
	var id = th;
	var alamat = $('#alamatcabangsms').val();
	var kota = $('#kotasetupsms').val();
	var provinsi = $('#provinsisetupsms').val();
	var namacabang = $('#cabangnameupdate').val();

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/UpdateCabang",
			data:{
				id:id,
				alamat : alamat,
				kota : kota,
				provinsi : provinsi,
				namacabang : namacabang,

			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);
				  Swal.fire({
			  type: 'success',
			  title: 'Data has been edited!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
				  $('#MdlSetupCbgSMS').modal('hide');
				  window.location.reload();


			}



		})
	
}

function SaveCabangSMS(th) { //PROSES SAVING DI SETUP CABANG
	var cabang_name = $('#cabangname').val();
	var provinsi = $('#provinsi').val();
	var kota = $('#kota').val();
	var alamatcabang = $('#alamatcabang').val();


	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/InsertCabang",
			data:{
				nama_cabang:cabang_name,
				id_prov:provinsi,
				id_kota:kota,
				alamat_cabang:alamatcabang,

			},
			success: function(response) {
				  Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			 window.location.reload();

		}
	})
}

function DeleteRowCabangSMS(th) { //PROSES DELETE DI SETUP CABANG
	var cabang_id = th;

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/deleteCabang",
			data:{
				cabang_id:cabang_id,
			},
			success: function(response) {
				  Swal.fire({
			  type: 'error',
			  title: 'Data has been deleted!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			 window.location.reload();

		}
	})
}

function DeleteRowUnit(th) { //PROSES DELETE DI SETUP UNIT
	var unit_id = th;

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/Setup/deleteUnit",
			data:{
				id:unit_id,
			},
			success: function(response) {
				  Swal.fire({
			  type: 'error',
			  title: 'Data has been deleted!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			 window.location.reload();

		}
	})
}

function DeleteRowVehiclesms(th) { //PROSES DELETE ROW DI SETUP VEHICLE
	var vehicle_id = th;

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupKendaraan/deleteVehicle",
			data:{
				id:vehicle_id,
			},
			success: function(response) {
				  Swal.fire({
			  type: 'error',
			  title: 'Data has been deleted!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			 window.location.reload();

		}
	})
}


function OpenModalUVsms(id) { //UNTUK MEMBUKA MODAL SETUP VEHICLE
	var id = id;

	$('#mdlVehiclesms').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupCabang/openVehicle",
			data:{
				id_vehicle : id,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

}

function OpenModalGoods(th) { //UNTUK MEMBUKA MODAL DI SETUP UNIT
	var id = th;
	
	$('#mdlGoods').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupUnit/openGoods",
			data:{
				id_goods:id,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function SaveEditVehiclesms(th) { //PROSES UPDATE DI SETUP VEHICLE
	var id = th;
	var vehiclename = $('#jk_edit').val();
	var volumevehicle = $('#vol_edit').val();

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupKendaraan/EditVehicle",
			data:{
				id:id,
				name:vehiclename,
				volume:volumevehicle
			},
			success: function(response) {
				  Swal.fire({
			  type: 'success',
			  title: 'Data has been edited!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			$('#mdlVehicle').modal('hide');
			 window.location.reload();

		}
	})
}

function SaveEditGoods(th) { //PROSES UPDATE DI SETUP UNIT
	var id = th;
	var goods_name = $('#good_edit').val();
	var goods_volume = $('#volume_edit').val();

	$.ajax({
			type: "POST",
			url: baseurl+"ShipmentMonitoringSystem/SetupUnit/EditGudla",
			data:{
				id_goodla:id,
				name:goods_name,
				vol: goods_volume
			},
			success: function(response) {
				  Swal.fire({
			  type: 'success',
			  title: 'Data has been edited!',
			  showConfirmButton: false,
			  timer: 1500

	 		});
			$('#mdlVehicle').modal('hide');
			 window.location.reload();

		}
	})
}