// ----------------------------------------------UMUM---------------------------------------------------------------
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

$('#blinking_td tr:first-child').css('background-color', '#c9efff').addClass('blink_me');

// -------------------------------------------PENGIRIMAN UNIT --------------------------------------------------------




$('.enter').on("keypress",function(e){
		if (e.keyCode == 13) {
		$('#loading_unit').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
			var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/FindShipment/btn_search_unit",
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
	}
})


	$('#btn_search_mpm_unit').click(function(){
		$('#loading_mpm').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/FindShipment/btn_search_unit",
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
function addRowMpm(){
    var unit = "";
    var jumlah = "";

    $.ajax({
		type: "GET",
		url: baseurl+"MonitoringPengiriman/NewShipment/getRow",
		dataType: 'json'
	}).done(function(result){
		
		console.log("num atas", num);
		// kolom 1 
		var html = '<tr class="number'+num+'"><td>'+num+'</td>';
		// kolom 2
		html += '<td><input type="number" class="form-control" style="width: 100%" type="text" id="jumlah" name="jumlah"></td>';
		// kolom 3
		html += '<td><select id="tipe" name="tipe" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.uom, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.uom_id+'">'+item.name+'</option>';
        })
		html += "</select></td>";
		// kolom 4
		html += '<td><select id="content" name="content" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.content_id, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.content_id+'">'+item.name+'</option>';
        })
		html += "</select></td>";
		// kolom 5
		html += '<td><select id="unit" name="unit" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.unit, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.unit_id+'">'+item.name+'</option>';
        })
        html += "</select></td>";
        // kolom 6
		html += '<td><button type="button" onClick="onClickBakso('+num+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	num++;

    	$('#tabelAddmpm').append(html);

    	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
		console.log("num tengah", num);

		console.log("num bawah", num);

	});


}

const onClickBakso = (th) => {
	console.log(th, "bakso")

	$('tr.number'+th).remove()
		num -=1

}

function ModalDetailUnit(th) {
	
	var no_ship = th

	$('#MdlMPM').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/FindShipment/btn_edit_unit",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function myFunction() {
  document.getElementById("tabelAddmpmUnit").deleteRow(1);
  // document.getElementById("tabelAddmpm").css('background-color','#ffccf9');
}

function saveMPM(){
		var estimasi = $('#estimasi_brkt').val();
		var finish_good = $('#fingo').val();
		var status = $('#status').val();
		var cabang = $('#cabang').val();
		var jk = $('#jk').val();
		var estimasi_loading = $('#estimasi_loading').val();
		
		var arry = [];
		$('select[name~="tipe"]').each(function(){
		var tipe = $(this).val();
		arry.push(tipe);
		});

		var arry1 = [];
		$('select[name~="content"]').each(function(){
		var content = $(this).val();
		arry1.push(content);
		});
		// str_arry = arry1.join();

		var arry2 = [];
		$('select[name~="unit"]').each(function(){
		var unit = $(this).val();
		arry2.push(unit);
		});

		var arry3 = [];
		$('input[name~="jumlah"]').each(function(){
		var jumlah = $(this).val();
		arry3.push(jumlah);
		});

		$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengiriman/NewShipment/saveMPM",
		data:{
			estimasi: estimasi,
			estimasi_loading:estimasi_loading,
			finish_good: finish_good,
			status: status,
			cabang: cabang,
			jk: jk,
			tipe: arry,
			content: arry1,
			unit: arry2,
			jumlah: arry3,
		},
		success: function(response){
			// console.log(lppb_info,id_gudang,str_arry,str_arry2,str_arry3,str_arry5);
			Swal.fire({
			  // position: 'top-end',
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			// window.location.reload();
			window.location.replace(baseurl+"MonitoringPengiriman/Dashboard")			
		}
	})

	}
			
function saveEditMPM(th){
	
		var no_ship = th
		var estimasi = $('#estimasi_brkt').val();
		var finish_good = $('#fingo').val();
		var status = $('#status').val();
		var jk = $('#jk').val();
		var estimasi_loading = $('#estimasi_loading').val();
		var cabang = $('#cabang').val();
		

		var arry = [];
		$('select[name~="tipe"]').each(function(){
		var tipe = $(this).val();
		arry.push(tipe);
		});

		var arry1 = [];
		$('select[name~="content"]').each(function(){
		var content = $(this).val();
		arry1.push(content);
		});

		var arry2 = [];
		$('select[name~="unit"]').each(function(){
		var unit = $(this).val();
		arry2.push(unit);
		});

		var arry3 = [];
		$('input[name~="jumlah"]').each(function(){
		var jumlah = $(this).val();
		arry3.push(jumlah);
		});


		$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengiriman/FindShipment/saveEditMPMUnit",
		data:{
			no_ship:no_ship,
			estimasi: estimasi,
			estimasi_loading:estimasi_loading,
			finish_good: finish_good,
			status: status,
			jk: jk,
			tipe: arry,
			content: arry1,
			unit: arry2,
			jumlah: arry3,
			cabang: cabang,
		},
		success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
			
		$('#MdlMPM').modal('hide');
			window.location.replace(baseurl+"MonitoringPengiriman/Dashboard")	
			
		}
	})

	}

	function saveSetup() {
 	var set_jk = $('#set_jk').val();
 	var set_unit = $('#set_unit').val();

 	$.ajax({
 		type : "POST",
 		url : baseurl+"MonitoringPengiriman/Setup/saveSetup",
 		data:{
 			set_jk : set_jk,
 			set_unit : set_unit,

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

 	function SaveCabang() {
	 	var cabang = $('#cabangname').val();
	 	var alamat = $('#alamatcabang').val();

	 	$.ajax({
	 		type: "POST",
	 		url: baseurl+"MonitoringPengiriman/Setup/Cabang/saveCabang",
	 		data:{
	 			cabang:cabang, 
	 			alamat:alamat,
	 		},
	 		success:function(response){
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


	 function OpenModal(th) {
	 	var cabang_id = th

	$('#MdlSetupCbg').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/Cabang/bukaModal",
			data:{
				cabang_id:cabang_id
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

$(document).ready(function() {
    $(".capital").keyup(function() {
        var val = $(this).val()
        $(this).val(val.toUpperCase());
    });

    $('input[name~="alamatcabangedit"]').on('keypress', function() { 
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
            $this.val( value.charAt(0).toUpperCase() );
        }  
    });
});


function DeleteRow(th) {
	var id = th
	// console.log(id)

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/Cabang/deleteRow",
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

$('.entercbg').on("keypress",function(e){
		if (e.keyCode == 13) {
			var id = th;
	var alamat = $('#alamatcabangcabang').val();
	var namacabang = $('#cabangnamename').val();

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/Cabang/editCabang",
			data:{
				id:id,
				alamat : alamat,
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
				  $('#MdlSetupCbg').modal('hide');
				  window.location.reload();


			}



		})
}
})

function SaveEditCabang(th) {
	var id = th;
	var alamat = $('#alamatcabangcabang').val();
	var namacabang = $('#cabangnamename').val();
	console.log(alamat, 'alamat', namacabang, 'namacabang');

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/Cabang/editCabang",
			data:{
				id:id,
				alamat : alamat,
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
				  $('#MdlSetupCbg').modal('hide');
				  window.location.reload();


			}



		})
	
}

function DeleteRowUnit(th) {
	var unit_id = th;

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/deleteUnit",
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

function DeleteRowVehicle(th) {
	var vehicle_id = th;

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/deleteVehicle",
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

function OpenModalUV(id, from) {
	var id_unit = id;
	var id_vehicle = from;

	if(from == "vehicle"){
	$('#mdlVehicle').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/openVehicle",
			data:{
				id_vehicle : id,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
		
	}else{
	$('#mdlVehicle').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/openUnit",
			data:{
				id_unit : id,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

	}


}

function OpenModalUnit(th) {
	var id = th;
	
	$('#mdlUnit').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/openUnit",
			data:{
				id:id,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function SaveEditVehicle(th) {
	var id = th;
	var vehiclename = $('#vehiclename').val();
console.log(id, vehiclename);

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/EditVehicle",
			data:{
				id:id,
				name:vehiclename
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

function SaveEditUnit(th) {
	var id = th;
	var unitname = $('#unitname').val();

	console.log(id, unitname);

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengiriman/Setup/EditUnit",
			data:{
				id:id,
				name:unitname
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


// ----------------------------------------------------PENGIRIMAN SPAREPART----------------------------------------







var num = 2;
function addRowMpmSp(){
    var unit = "";
    var jumlah = "";

    $.ajax({
		type: "GET",
		url: baseurl+"MonitoringPengirimanSparepart/FindShipment/getRowsp",
		dataType: 'json'
	}).done(function(result){
		
		console.log("num atas", num);
		// kolom 1 
		var html = '<tr class="number'+num+'"><td>'+num+'</td>';
		// kolom 2
		html += '<td><input type="number" class="form-control" style="width: 100%" type="text" id="jumlah" name="jumlah"></td>';
		// kolom 3
		html += '<td><select id="tipe" name="tipe" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.uom, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.uom_id+'">'+item.name+'</option>';
        })
		html += "</select></td>";
		// kolom 4
		html += '<td><select id="content" name="content" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.content_id, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.content_id+'">'+item.name+'</option>';
        })
		html += "</select></td>";
		// kolom 5
		html += '<td><select id="unit" name="unit" class="form-control selectUnitMPM" style="width:100%;" onFocus="onBakso()">';
		html += '<option value="" > Pilih  </option>';
		$.map(result.unit, function(item) {
			// console.log(item, "bakso")
			html += '<option value="'+item.unit_id+'">'+item.name+'</option>';
        })
        html += "</select></td>";
        // kolom 6
		html += '<td><button type="button" onClick="onClickBakso('+num+')" class="btnDeleteRowsp btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	num++;

    	$('#tabelAddmpmsp').append(html);

    	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
		console.log("num tengah", num);

		console.log("num bawah", num);

	});


}

function ModalDetailsp(th) {
	
	var no_ship = th

	$('#MdlMPMsp').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanSparepart/FindShipment/btn_edit_sp",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function myFunction2() {
  document.getElementById("tabelAddmpmsp").deleteRow(1);
  // document.getElementById("tabelAddmpm").css('background-color','#ffccf9');
}

function saveEditMPMsp(th){
	
		var no_ship = th
		var estimasi = $('#estimasi_brkt').val();
		var finish_good = $('#fingo').val();
		var status = $('#status').val();
		var jk = $('#jk').val();
		var estimasi_loading = $('#estimasi_loading').val();
		var cabang = $('#cabang').val();
		

		var arry = [];
		$('select[name~="tipe"]').each(function(){
		var tipe = $(this).val();
		arry.push(tipe);
		});

		var arry1 = [];
		$('select[name~="content"]').each(function(){
		var content = $(this).val();
		arry1.push(content);
		});

		var arry2 = [];
		$('select[name~="unit"]').each(function(){
		var unit = $(this).val();
		arry2.push(unit);
		});

		var arry3 = [];
		$('input[name~="jumlah"]').each(function(){
		var jumlah = $(this).val();
		arry3.push(jumlah);
		});


		$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengirimanSparepart/FindShipment/saveEditMPMsp",
		data:{
			no_ship:no_ship,
			estimasi: estimasi,
			estimasi_loading:estimasi_loading,
			finish_good: finish_good,
			status: status,
			jk: jk,
			tipe: arry,
			content: arry1,
			unit: arry2,
			jumlah: arry3,
			cabang: cabang,
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
			window.location.replace(baseurl+"MonitoringPengirimanSparepart/Dashboard")	
			
		}
	})

	}

$('.entersp').on("keypress",function(e){
		if (e.keyCode == 13) {
		$('#loading_mpm').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
			var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanSparepart/FindShipment/btn_search_sp",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#tabel_search_mpm_sp').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	}
})


	$('#btn_search_mpm_sp').click(function(){
		$('#loading_mpm').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanSparepart/FindShipment/btn_search_sp",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#tabel_search_mpm_sp').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})


	//-----------------------------------------------------------------PENGIRIMAN GUDANG------------------------
	


	function ModalDetailgd(th) {
	
	var no_ship = th

	$('#MdlMPMgdg').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanGudang/FindShipment/btn_edit_gd",
			data:{
				no_ship:no_ship
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

$('.entergd').on("keypress",function(e){
		if (e.keyCode == 13) {
		$('#loading_mpm').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
			var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanGudang/FindShipment/btn_search_gd",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#tabel_search_mpm_gd').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	}
})


	$('#btn_search_mpm_gd').click(function(){
		$('#loading_mpm').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		var no_ship = $('#no_ship').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanGudang/FindShipment/btn_search_gd",
			data: {
				no_ship:no_ship
			},
			success: function (response) {
				$('#loading_mpm').html(response);
				$('#tabel_search_mpm_gd').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})


	function saveEditMPMgd(th){
	
		var no_ship = th
		var actual_brkt = $('#actual_brkt').val();
		var actual_loading = $('#actual_loading').val();
		console.log(no_ship)

		$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengirimanGudang/FindShipment/saveEditMPMgd",
		data:{
			no_ship:no_ship,
			actual_loading: actual_loading,
			actual_brkt:actual_brkt,
		},
		success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
		$('#MdlMPM').modal('hide');
		window.location.replace(baseurl+"MonitoringPengirimanGudang/Dashboard")
			
		}
	})

	}
