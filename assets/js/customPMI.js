$(document).ready(function () {
	 
	$(".frmpreqpiea").keypress(function(e) {
		if (e.which == 13) {     
				return false;   
		} 
	});
    
	$('.tblreqmasteritem').DataTable({
			"scrollX" : true,
			"columnDefs": [{
					"targets": '_all',
			}],
	});

	var seksi = document.getElementById("masteritemreq");
	if(seksi){ // resp. pendaftaran master item
		//func tampil(keterangan_tabel, aplikasi, batas data yg tampil, warna tabel, name per tabel)
		viewrequest('ongoing', 'seksi', 5, 'teal', 'ongoing'); // parameter data ongoing
		viewrequest('finished', 'seksi', 5, 'orange', 'finished'); // parameter data finished
	}
	
	var timkode = document.getElementById("masteritemTimKode");
  if(timkode){ // resp. master item tim kode barang
		viewrequest('needed', 'timkode', 1, 'orange', 'needed');
		viewrequest('performed', 'timkode', 1, 'navy', 'performed');
	}
	
	var akt = document.getElementById("masteritemAkuntansi");
  if(akt){ // resp. master item akuntansi
		viewrequest('incoming', 'akuntansi', 2, 'teal', 'incomingakt');
		viewrequest('needed', 'akuntansi', 2, 'orange', 'needakt');
		viewrequest('performed', 'akuntansi', 2, 'navy', 'performakt');
	}
	
	var pembelian = document.getElementById("masteritemPembelian");
  if(pembelian){ // resp. master item pembelian
		viewrequest('incoming', 'pembelian', 3, 'teal', 'incomingpembelian');
		viewrequest('needed', 'pembelian', 3, 'orange', 'needpembelian');
		viewrequest('performed', 'pembelian', 3, 'navy', 'performpembelian');
	}
	
	var piea = document.getElementById("masteritemPIEA");
  if(piea){ // resp. master item piea
		viewrequest('incoming', 'piea', 4, 'teal', 'incomingpiea');
		viewrequest('needed', 'piea', 4, 'orange', 'needpiea');
		viewrequest('performed', 'piea', 4, 'navy', 'performpiea');
	}
		
		$(".kodeuom").select2({
			allowClear: true,
			placeholder: "pilih UOM",
			minimumInputLength: 0,
			ajax: {
				url: baseurl + "PendaftaranMasterItem/Request/kodeuom",
				dataType: 'json',
				type: "GET",
				data: function (params) {
						var queryParameters = {
								term: params.term,
						}
						return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (obj) {
							return {id:obj.KODE_UOM, text:obj.KODE_UOM+' - '+obj.UOM};
						})
					};
				}
			}
		});		
		
		$(".getorg_assign").select2({
			allowClear: true,
			minimumInputLength: 0,
			ajax: {
				url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
				dataType: 'json',
				type: "GET",
				data: function (params) {
						var queryParameters = {
								term: params.term,
						}
						return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (obj) {
							return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
						})
					};
				}
			}
		});	
		
		$(".getorg_assign2").select2({
			allowClear: true,
			minimumInputLength: 0,
		});	

});

function viewrequest(ket, apk, batas, warna, name) {
	$.ajax({
		url: baseurl + 'PendaftaranMasterItem/Request/viewrequest',
		data : {ket : ket, apk : apk, batas : batas, warna : warna, name : name},
		type: 'POST',
		beforeSend: function() {
			$('div#tb_'+ket ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_'+ket).html(result);
		}
	})
}

function modaldetailreq(ket, num){
	// console.log(ket, num);
	var no 		= $('#id_'+ket+num).val();
	var nodoc = $('#no_'+ket+num).val();
	var seksi = $('#seksi_'+ket+num).val();
	var tgl 	= $('#tgl_'+ket+num).val();
	var status = $('#status_'+ket+num).val();
	if (ket == 'needpiea') { // setting modal detail tabel needed master item piea
		tujuan = 'MasterItemPIEA/Request/modalDetail'; 
	}else if (ket == 'needakt') { // setting modal detail tabel needed master item akuntansi
		tujuan = 'MasterItemAkuntansi/Request/modalDetail';
	}else if (ket == 'needed' || ket == 'performed') { // setting modal detail tabel needed dan performed master item tim kode barang
		tujuan = 'MasterItemTimKode/Request/modalDetail';
	}else if (ket == 'needpembelian' || ket == 'performpembelian') { // setting modal detail tabel needed dan performed master item pembelian
		tujuan = 'MasterItemPembelian/Request/modalDetail';
	}else{ 
		tujuan = 'PendaftaranMasterItem/Request/modalDetail';
	}
	var request = $.ajax({
        url: baseurl+tujuan,
        data: {ket : ket, no: no, nodoc : nodoc, seksi : seksi, tgl : tgl, status : status},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
				$('#mdlReqMasterItem').modal('show');
        $('#datareq').html(result);
				$('#tbldetail').DataTable({
					"scrollX": true,
				});
				
				$(".getBuyer").select2({
					allowClear: true,
					placeholder: "pilih buyer",
					minimumInputLength: 0,
					ajax: {
							url: baseurl + "MasterItemPembelian/Request/getBuyer",
							dataType: 'json',
							type: "GET",
							data: function (params) {
									var queryParameters = {
											term: params.term,
									}
									return queryParameters;
							},
							processResults: function (data) {
									// console.log(apa);
									return {
											results: $.map(data, function (obj) {
													return {id:obj.FULL_NAME, text:obj.FULL_NAME};
											})
									};
							}
					}
				});
				
				$(".getapprover").select2({
					allowClear: true,
					placeholder: "pilih buyer",
					minimumInputLength: 0,
					ajax: {
							url: baseurl + "MasterItemPembelian/Request/getApproval",
							dataType: 'json',
							type: "GET",
							data: function (params) {
									var queryParameters = {
											term: params.term,
									}
									return queryParameters;
							},
							processResults: function (data) {
									// console.log(apa);
									return {
											results: $.map(data, function (obj) {
													return {id:obj.FLEX_VALUE, text:obj.FLEX_VALUE};
											})
									};
							}
					}
				});
		});
	}

function clearall() { // kosongin semua value pendaftaran master item baru
		$('input[name="dual_uom"]').prop('checked', false);
		$('input[name="make"]').prop('checked', false);
		$('input[name="stock"]').prop('checked', false);
		$('input[name="no_serial"]').prop('checked', false);
		$('input[name="inspect"]').prop('checked', false);
		$('input[name="odm"]').prop('checked', false);
		$('input[name="opm"]').prop('checked', false);
		$('input[name="jual"]').prop('checked', false);
		$('.checked').removeClass('checked');
		$('#org_group').select2('val','');
		$('#tambahorg_assign').html('<div class="col-md-3 text-right"></div><div class="col-md-6"><select id="org_assign1" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select></div><div class="col-md-1" style="text-align:left"><a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(6)" class="btn btn-default"><i class="fa fa-plus"></i></a></div><br><br>');
		$('#keterangan').val('');
		$('#latar_belakang').val('');
		$('#ketItem').val('tidak');
		$('.checked').removeClass('checked');
		$('#dual_yes').css('display', 'none');
		$('#isi_dual').select2('val', '');
		
		$(".getorg_assign").select2({
			allowClear: true,
			minimumInputLength: 0,
			ajax: {
				url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
				dataType: 'json',
				type: "GET",
				data: function (params) {
						var queryParameters = {
								term: params.term,
						}
						return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (obj) {
							return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
						})
					};
				}
			}
		});
}

$(document).on('change', '#statusbaru',  function() {
	var value = $('#statusbaru').val();
	if (value == 'P') {
		$('#tambah_req').removeAttr('disabled', false);
		$('#gantiItem').html('<input id="item" name="item" class="form-control" placeholder="Masukkan item" style="text-transform:uppercase" autocomplete="off">');
		$('#gantiDesc').html('<input id="desc" name="desc" class="form-control" placeholder="Masukkan deskripsi" style="text-transform:uppercase" autocomplete="off"><input type="hidden" id="inv_item_id" name="inv_item_id">');
		$('#gantiUOM').html('<select id="uom" name="uom" class="form-control select2 kodeuom" placeholder="Masukkan UOM"><option></option><select>');
		
    $(".kodeuom").select2({
			allowClear: true,
			placeholder: "pilih UOM",
			minimumInputLength: 0,
			ajax: {
					url: baseurl + "PendaftaranMasterItem/Request/kodeuom",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(apa);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.KODE_UOM, text:obj.KODE_UOM+' - '+obj.UOM};
									})
							};
					}
			}
		});	
		$('.inactive').css('display','');
		clearall();
	}else if(value == 'I' || value == 'R'){
		$('#tambah_req').removeAttr('disabled', false);
		$('#gantiItem').html('<select id="item" name="item" class="form-control select2 itemreq" placeholder="Masukkan item" style="width:100%" autocomplete="off" onchange="descrequest()"><option></option></select>');
		$('#gantiUOM').html('<input id="uom" name="uom" class="form-control" readonly>');
		
		if (value == 'I') {
			$('#gantiDesc').html('<input id="desc" name="desc" class="form-control" placeholder="Masukkan deskripsi" autocomplete="off" readonly><input type="hidden" id="inv_item_id" name="inv_item_id">');
			$('.inactive').css('display','none');
		}else{
			$('#gantiDesc').html('<input id="desc" name="desc" class="form-control" placeholder="Masukkan deskripsi" autocomplete="off"><input type="hidden" id="inv_item_id" name="inv_item_id">');
			$('.inactive').css('display', '');
			$('#dualUom').css('display', 'none');
		}
		clearall();

		$(".itemreq").select2({
			allowClear: true,
			placeholder: "Masukkan item",
			minimumInputLength: 3,
			ajax: {
					url: baseurl + "PendaftaranMasterItem/Request/getItem",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(apa);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
									})
							};
					}
			}
		});
	}
});

$(document).on("change", ".dualuom", function () {
	var dual_uom 		= $('input[name="dual_uom"]:checked').val();
	console.log(dual_uom); 
	if (dual_uom == 'Y') {
			$('#dual_yes').css('display', '');
	}else{
		$('#dual_yes').css('display', 'none');
		$('#isi_dual').select2('val', '');
	}
})

function descrequest() {
	var item = $('#item').val();
	$.ajax({
		url: baseurl + 'PendaftaranMasterItem/Request/getDescription',
		data  : {item : item},
		dataType: 'json',
		type: 'POST',
		success: function(result) {
			// console.log(result)
			$('#desc').val(result[0]);
			$('#inv_item_id').val(result[1]);
			$('#uom').val(result[2]);
		}
	})
}

$(document).on('change', '#item',  function() {
	var status 	= $('select[name="status"]').val();
	var item 		= $('#item').val(); // kode item yang mau dicek
	var item2 	= $('input[name="item2"]').map(function(){return $(this).val();}).get(); // semua kode item untuk cek
	// console.log(item, item2);
	if (status == 'P') {
		$.ajax({
			url: baseurl + 'PendaftaranMasterItem/Request/cekItem',
			data: { term : item, item2 : item2},
			dataType: 'json',
			type: "GET",
			success: function(data) {
				// console.log(data);
				if (data == 'ada') {
					document.getElementById("item").style.backgroundColor = "#F6B0AF";
					$('#ketItem').val('ada');
					$('#warning_item').html('Item sudah terdaftar.');
				}else{
					document.getElementById("item").style.backgroundColor = "#C2F5D1";
					$('#ketItem').val('tidak');
					$('#warning_item').html('');
				}
			}
		});
	}
});

$(document).on('change', '#org_group',  function() {
	var group = $('#org_group').val();
	if (group != '' && group != null) {
		$.ajax({
			url: baseurl + 'PendaftaranMasterItem/Request/org_group',
			data: { group : group},
			dataType: 'html',
			type: "POST",
			success: function(data) {
				// console.log(data);
				$('#tambahorg_assign').html(data);
				$(".getorg_assign").select2({
					allowClear: true,
					minimumInputLength: 0,
					ajax: {
						url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
						dataType: 'json',
						type: "GET",
						data: function (params) {
								var queryParameters = {
										term: params.term,
								}
								return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function (obj) {
									return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
								})
							};
						}
					}
				});	
			}
		});
	}else {
		$('#tambahorg_assign').html('<div class="col-md-3 text-right"></div><div class="col-md-6"><select id="org_assign1" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select></div><div class="col-md-1" style="text-align:left"><a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(6)" class="btn btn-default"><i class="fa fa-plus"></i></a></div><br><br>');
		
		$(".getorg_assign").select2({
			allowClear: true,
			minimumInputLength: 0,
			ajax: {
				url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
				dataType: 'json',
				type: "GET",
				data: function (params) {
						var queryParameters = {
								term: params.term,
						}
						return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (obj) {
							return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
						})
					};
				}
			}
		});		
	}
});

function deletebaris(no) {
	$('#baris'+no).remove()
}

function addrequest() {
	var num 				= $('.ininumber:last').val();
	var number 			= parseFloat(num) + 1;
	var seksi 			= $('input[name="seksi"]').val();
	var kode 				= $('input[name="kode"]').val();
	var status 			= $('select[name="status"]').val();
	var item 				= $('#item').val();
	var desc 				= $('input[name="desc"]').val();
	var inv_item_id = $('input[name="inv_item_id"]').val();
	var uom 				= $('#uom').val();
	var dual_uom 		= $('input[name="dual_uom"]:checked').val();
	var isi_dual 		= $('#isi_dual').val();
	var makebuy 		= $('input[name="make"]:checked').val();
	var stock 			= $('input[name="stock"]:checked').val();
	var no_serial 	= $('input[name="no_serial"]:checked').val();
	var inspect 		= $('input[name="inspect"]:checked').val();
	var org 				= $('[name="org_assign[]"]').map(function(){return $(this).val();}).get();
	var odm 				= $('input[name="odm"]:checked').val();
	var opm 				= $('input[name="opm"]:checked').val();
	var jual 				= $('input[name="jual"]:checked').val();
	var latar 			= $('input[name="latar_belakang"]').val();
	var keterangan 	= $('#keterangan').val();
	var ketItem 		= $('#ketItem').val();
	// console.log(ketItem);
	if (kode == '') {
		swal.fire("Kode Seksi Belum Terdaftar", "Harap lapor PIEA untuk mendaftarkan Kode Seksi.", "error");
	}
		
	if (latar != '' && latar != null && ketItem == 'tidak' && item != '') {
		$('#tambah_req').attr('disabled', 'disabled');
		$.ajax({
			url: baseurl + 'PendaftaranMasterItem/Request/tambahbaristabelreq',
			data: {seksi : seksi, kode : kode, status : status, item : item, desc : desc, uom : uom, dual_uom : dual_uom,
					makebuy : makebuy, stock : stock,no_serial : no_serial, inspect : inspect, org : org, odm : odm,
					opm : opm, jual : jual, keterangan : keterangan, number : number, latar : latar, inv_item_id : inv_item_id, isi_dual : isi_dual},
			type : "POST",
			dataType: "html",
			success: function(result) {
				$('.inactive').css('display','');
				$('.odd').css('display', 'none');
				$('#inirequest').append(result);
				$('select[name="status"]').select2('val','');
				$('#gantiItem').html('<input id="item" name="item" class="form-control" placeholder="Masukkan item" autocomplete="off">');
				$('#gantiDesc').html('<input id="desc" name="desc" class="form-control" placeholder="Masukkan deskripsi" autocomplete="off"><input type="hidden" id="inv_item_id" name="inv_item_id">');
				$('#gantiUOM').html('<select id="uom" name="uom" class="form-control select2 kodeuom" data-placeholder="Masukkan UOM"><option></option><select>');
				
				clearall();

				$(".kodeuom").select2({
					allowClear: true,
					placeholder: "pilih UOM",
					minimumInputLength: 0,
					ajax: {
						url: baseurl + "PendaftaranMasterItem/Request/kodeuom",
						dataType: 'json',
						type: "GET",
						data: function (params) {
								var queryParameters = {
										term: params.term,
								}
								return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function (obj) {
									return {id:obj.KODE_UOM, text:obj.KODE_UOM+' - '+obj.UOM};
								})
							};
						}
					}
				});	
					
			}
		})
	}else if (ketItem == 'ada') { // kode item sudah pernah didaftarkan
		swal.fire("Kode Item Sudah Ada", "", "error");
	}
}

function submitrequest() {
	var kode 	= $('input[name="kode2"]').map(function(){return $(this).val();}).get();

	if (kode != '') { // kode seksi sudah terdaftar
		$('#submit_req').attr('disabled','disabled');
		$.ajax({ // cek email user sudah terdaftar/ belum
			url: baseurl + 'PendaftaranMasterItem/Request/cekuser',
			success: function(data) {
				if (data == 'tidak') { // email belum terdaftar
						Swal.fire({
							title: 'Alamat email belum terdaftar!',
							html : 'Masukkan alamat email agar mendapat pemberitahuan jika request telah selesai.',
							type: 'warning',
							input: 'text',
							inputAttributes: {
								autocapitalize: 'off'
							},
							showCancelButton: true,
							confirmButtonText: 'OK',
							showLoaderOnConfirm: true,
						}).then(result => {
							if (result.value) {
								$.ajax({ // save email yang dimasukan
									url: baseurl + 'PendaftaranMasterItem/SettingEmail/saveemail',
									data: { email : result.value},
									type : "POST",
									dataType: "html",
									success: function(data) {
										saveRequest();
									}
								})
							}})
				}else{ // email sudah terdaftar
						saveRequest();
				}
			}
		});
	}

}

function saveRequest() {
	var seksi 			= $('input[name="seksi2"]').map(function(){return $(this).val();}).get();
	var kode				= $('input[name="kode2"]').map(function(){return $(this).val();}).get();
	var id_kode 		= $('#id_kode').val();
	var status 			= $('input[name="status2"]').map(function(){return $(this).val();}).get();
	var item 				= $('input[name="item2"]').map(function(){return $(this).val();}).get();
	var desc 				= $('input[name="desc2"]').map(function(){return $(this).val();}).get();
	var item_id 		= $('input[name="item_id2"]').map(function(){return $(this).val();}).get();
	var uom 				= $('input[name="uom2"]').map(function(){return $(this).val();}).get();
	var dual_uom 		= $('input[name="dual_uom2"]').map(function(){return $(this).val();}).get();
	var isi_dual 		= $('input[name="isi_dual2"]').map(function(){return $(this).val();}).get();
	var makebuy 		= $('input[name="makebuy2"]').map(function(){return $(this).val();}).get();
	var stock 			= $('input[name="stock2"]').map(function(){return $(this).val();}).get();
	var no_serial 	= $('input[name="no_serial2"]').map(function(){return $(this).val();}).get();
	var inspect 		= $('input[name="inspect2"]').map(function(){return $(this).val();}).get();
	var org 				= $('input[name="org2"]').map(function(){return $(this).val();}).get();
	var odm 				= $('input[name="odm2"]').map(function(){return $(this).val();}).get();
	var opm 				= $('input[name="opm2"]').map(function(){return $(this).val();}).get();
	var jual 				= $('input[name="jual2"]').map(function(){return $(this).val();}).get();
	var latar 			= $('input[name="latar2"]').map(function(){return $(this).val();}).get();
	var keterangan 	= $('input[name="keterangan2"]').map(function(){return $(this).val();}).get();
	// console.log(item)
	$.ajax({
			url: baseurl + 'PendaftaranMasterItem/Request/saverequest',
			data: {seksi : seksi, kode : kode, status : status, item : item, desc : desc, uom : uom, dual_uom : dual_uom, isi_dual : isi_dual,
					makebuy : makebuy, stock : stock,no_serial : no_serial, inspect : inspect, org : org, odm : odm,
					opm : opm, jual : jual, keterangan : keterangan, id_kode : id_kode, latar : latar, item_id : item_id},
			type : "POST",
			dataType: "html",
			success: function(data) {
				Swal.fire({ // menampilkan no dokumen dari pendaftaran master item
					title: 'Nomor Dokumen : ',
					text : data,
					type: 'success',
					allowOutsideClick: false
				}).then(result => {
					if (result.value) {
						// console.log(data)
						window.location.href =  baseurl + 'PendaftaranMasterItem/Request';
				}})  
			}
		})
}

var x = 2;
function addorg_assign(col) {
	//col 6 => tambah org assign di request baru resp. pendaftaran master item dan tambah org group setting data resp. master item piea
	//col 9 => tambah org assign di edit org group resp. master item piea
	var tambah = col == 9 ? '' : '<div class="col-md-3"></div>';

	$('#tambahorg_assign').append('<div class="tambahorg_assign" >'+tambah+'<div class="col-md-'+col+'"><select id="org_assign'+x+'" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select></div><div class="col-md-1" style="text-align:left"><button class = "btn btn-default tombolhapus'+x+'" type="button"><i class = "fa fa-minus" ></i></button></div><br><br></div>');

	$(document).on('click', '.tombolhapus'+x,  function() {
		$(this).parents('.tambahorg_assign').remove()
	});
	
	$(".getorg_assign").select2({
		allowClear: true,
		minimumInputLength: 0,
		ajax: {
			url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
			dataType: 'json',
			type: "GET",
			data: function (params) {
					var queryParameters = {
							term: params.term,
					}
					return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
					})
				};
			}
		}
	});	
}

function revisiTKB(no) { // revisi kode barang dari master item tim kode barang
	var kode 		= $('#kode_item'+no).val();
	var revisi 	= $('#revisi_kode'+no).val();
	if (revisi == '-') { // belum ada revisi
		var item = ': <b>'+kode+'</b>';
	}else{ // sudah ada revisi
		var item = ': <b>'+kode+'</b> <br>Kode Item revisi : <b>'+revisi+'</b>';
	}
	Swal.fire({
		title: 'Revisi Kode Item : ',
		html : "Kode Item "+item+"",
		// type: 'success',
		input: 'text',
		inputAttributes: {
			autocapitalize: 'off'
		},
		showCancelButton: true,
		confirmButtonText: 'OK',
		showLoaderOnConfirm: true,
	}).then(result => {
		if (result.value) {
			var val 		= result.value.toUpperCase();
			var item2 	= $('input[name="revisi_kode[]"]').map(function(){return $(this).val();}).get();
			// console.log(item2)
			$.ajax({ // cek item revisi sudah pernah didaftarkan / belum
				url: baseurl + 'PendaftaranMasterItem/Request/cekItem',
				data: { term : val, item2 : item2},
				dataType: 'json',
				type: "GET",
				success: function(data) {
					// console.log(data);
					if (data == 'ada') { // item sudah pernah terdaftar
						swal.fire("Kode Item Sudah Ada.", "", "error");
					}else{ // item belum terdaftar
						$('#revisi_kode'+no).val(val);
						$('#ini_kode'+no).html(val);
					}
				}
			});
	}})
}

function revisiTKB2(no) { // revisi deskripsi barang dari master item tim kode barang
	var kode 		= $('#desc_item'+no).val();
	var revisi 	= $('#revisi_desc'+no).val();
	if (revisi == '-') {
		var item = ': <b>'+kode+'</b>';
	}else{
		var item = ': <b>'+kode+'</b> <br>Deskripsi revisi : <b>'+revisi+'</b>';
	}
	Swal.fire({
		title: 'Revisi Kode Item : ',
		html : "Deskripsi Item "+item+"",
		// type: 'success',
		input: 'text',
		inputAttributes: {
			autocapitalize: 'off'
		},
		showCancelButton: true,
		confirmButtonText: 'OK',
		showLoaderOnConfirm: true,
	}).then(result => {
		if (result.value) {
			// console.log(result);
			var val = result.value.toUpperCase();
			$('#revisi_desc'+no).val(val);
			$('#ini_desc'+no).html(val);
	}})
}

function inv_value(no) {
	var val = $('#inv_value'+no).val();
	// console.log(val)
	if (val == 'Yes') {
		$('#gantiExp'+no).html('<input id="exp_acc'+no+'" name="exp_acc[]" class="form-control" style="width:100%" autocomplete="off" readonly>');
	}else{
		$('#gantiExp'+no).html('<select id="exp_acc'+no+'" name="exp_acc[]" class="form-control select2" style="width:160px" autocomplete="off" required><option></option></select>');
		$("#exp_acc"+no).select2({
			allowClear: true,
			placeholder: "",
			minimumInputLength: 0,
			ajax: {
					url: baseurl + "MasterItemAkuntansi/Request/getExpAcc",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(apa);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.FLEX_VALUE, text:obj.FLEX_VALUE};
									})
							};
					}
			}
	});
	}
}

function getBuyer(no) {
		var item = $('#item'+no).val();
		$.ajax({
			url: baseurl+('MasterItemPembelian/Request/getBuyer'),
			data: {item : item},
			type: "POST",
			datatype: 'html'
		});
}

function perhitunganTotal(no) {
	var pre_proses 	= parseFloat($('#pre_process'+no).val());
	var preparation = parseFloat($('#preparation'+no).val());
	var delivery 		= parseFloat($('#delivery'+no).val());
	var post_proses = parseFloat($('#post_process'+no).val());
	// console.log(pre_proses, preparation, delivery, post_proses);
	var totalProses = (preparation + delivery);
	var totalLead = (totalProses + pre_proses + post_proses );
	$('#total_process'+no).val(parseFloat(totalProses).toFixed(2));
	$('#ini_total_process'+no).html(parseFloat(totalProses).toFixed(2));
	$('#total_lead'+no).val(parseFloat(totalLead).toFixed(2));
	$('#ini_total_lead'+no).html(parseFloat(totalLead).toFixed(2));
}

function mdltambahseksi(){
	var request = $.ajax({
        url: baseurl+('MasterItemPIEA/SettingData/tambahseksi'),
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datareq').html(result);
				$('#mdlReqMasterItem').modal('show');
				
				$(".settingseksi").select2({
					allowClear: true,
					placeholder: "pilih seksi",
					minimumInputLength: 0,
					ajax: {
							url: baseurl + "MasterItemPIEA/SettingData/getseksi",
							dataType: 'json',
							type: "GET",
							data: function (params) {
									var queryParameters = {
											term: params.term,
									}
									return queryParameters;
							},
							processResults: function (data) {
									// console.log(apa);
									return {
											results: $.map(data, function (obj) {
													return {id:obj.seksi, text:obj.seksi};
											})
									};
							}
					}
			});
	});
}

function mdltambahuom(){
	var request = $.ajax({
        url: baseurl+('MasterItemPIEA/SettingData/tambahuom'),
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datareq').html(result);
				$('#mdlReqMasterItem').modal('show');
	});
}

function mdltambahemail(){
	var ket = $('#keterangan').val();
	if (ket == 'Seksi') { // modal email khusus untuk resp. pendaftaran master item, hanya bisa mendaftarkan email milik user login saja
		Swal.fire({
			title: 'Masukkan Alamat Email',
			input: 'text',
			inputAttributes: {
				autocapitalize: 'off'
			},
			showCancelButton: true,
			confirmButtonText: 'OK',
			showLoaderOnConfirm: true,
		}).then(result => {
			if (result.value) {
				var request = $.ajax({
					url: baseurl+('PendaftaranMasterItem/SettingEmail/saveemail'),
					data: { email : result.value, ket : ket},
					type: "POST",
					datatype: 'html'
				});
				request.done(function(result){
				window.location.href =  baseurl + ('PendaftaranMasterItem/SettingEmail');
				});
			}
		});
	}else{ // selain resp. pendaftaran master item dapat mendaftarkan beberapa email
		var request = $.ajax({
			url: baseurl+('MasterItemTimKode/SettingEmail/tambahemail'),
			data: { ket : ket},
			type: "POST",
			datatype: 'html'
		});
		request.done(function(result){
					$('#datareq').html(result);
					$('#mdlReqMasterItem').modal('show');
					var i = 2;
					$('#addbarisemail').click(function(){
							$('#tambah_email').append('<div class="tambah_email" ><br><br><div class="col-md-1"></div><div class="col-md-9"><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input id="email'+i+'" name="email[]" class="form-control" placeholder="Masukkan Email" autocomplete="off"></div></div><div class="col-md-1" style="text-align:left"><button class = "btn btn-default tombolhapus'+i+'" type="button"><i class = "fa fa-minus" ></i></button></div></div>');

							$(document).on('click', '.tombolhapus'+i,  function() {
							$(this).parents('.tambah_email').remove()
						});
					})

		});
	}
}

function mdltambahorg(){
	var request = $.ajax({
        url: baseurl+('MasterItemPIEA/SettingData/tambahorg'),
        data: {},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datareq').html(result);
				$('#mdlReqMasterItem').modal('show');
				$(".getorg_assign").select2({
					allowClear: true,
					minimumInputLength: 0,
					ajax: {
						url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
						dataType: 'json',
						type: "GET",
						data: function (params) {
								var queryParameters = {
										term: params.term,
								}
								return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function (obj) {
									return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
								})
							};
						}
					}
				});	
	});
}

function tombolapus(no) { // hapus baris org_assign request baru & modal org group setting data piea
	$('.tmborg_assign'+no).remove()
}

$(document).on('change', '#nama_group',  function() {
	var nama = $('#nama_group').val().toUpperCase();
	// console.log(nama);
	$.ajax({ // cek nama group sudah dipakai / belum
		url: baseurl + 'MasterItemPIEA/SettingData/cekORG',
		data  : {nama : nama},
		dataType: 'json',
		type: 'POST',
		success: function(result) {
			// console.log(result)
			if (result == 'ada') { // nama group sudah dipakai
				document.getElementById("nama_group").style.backgroundColor = "#F6B0AF";
				$('#warning_group').html('Nama Group Sudah Ada.');
			}
		}
	})
})

function editorg_group(no){
	var id = $('#id_org'+no).val();
	var request = $.ajax({
        url: baseurl+('MasterItemPIEA/SettingData/editorg'),
        data: { id : id},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datareq').html(result);
				$('#mdlReqMasterItem').modal('show');
				$(".getorg_assign").select2({
					allowClear: true,
					minimumInputLength: 0,
					ajax: {
						url: baseurl + "PendaftaranMasterItem/Request/getOrgAssign",
						dataType: 'json',
						type: "GET",
						data: function (params) {
								var queryParameters = {
										term: params.term,
								}
								return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function (obj) {
									return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
								})
							};
						}
					}
				});	
		});
}

function deleteseksi(no) {
	var id = $('#id_seksi'+no).val();
	var kode = $('#kode_seksi'+no).val();
	Swal.fire({
			title: 'Apakah Anda Yakin?',
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
	}).then(result => {
			if (result.value) {  
				$.ajax({
					url: baseurl + 'MasterItemPIEA/SettingData/deleteseksi',
					data: {id : id, kode : kode},
					type : "POST",
					dataType: "html",
					success: function(data) {
						Swal.fire({
							title: 'Data Berhasil di Hapus!',
							type: 'success',
							allowOutsideClick: false
						}).then(result => {
							if (result.value) {
								// console.log(data)
								window.location.href =  baseurl + 'MasterItemPIEA/SettingData';
						}})  
					}
				})
		}})  
}

function deleteuom(no) {
	var id = $('#id_uom'+no).val();
	var kode = $('#kode_uom'+no).val();
	Swal.fire({
			title: 'Apakah Anda Yakin?',
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
	}).then(result => {
			if (result.value) {  
				$.ajax({
					url: baseurl + 'MasterItemPIEA/SettingData/deleteuom',
					data: {id : id, kode : kode},
					type : "POST",
					dataType: "html",
					success: function(data) {
						Swal.fire({
							title: 'Data Berhasil di Hapus!',
							type: 'success',
							allowOutsideClick: false
						}).then(result => {
							if (result.value) {
								// console.log(data)
								window.location.href =  baseurl + 'MasterItemPIEA/SettingData';
						}})  
					}
				})
	}})  
}

function deleteemail(no) {
	var id = $('#id_email'+no).val();
	var ket = $('#keterangan').val();
	Swal.fire({
			title: 'Apakah Anda Yakin?',
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
	}).then(result => {
			if (result.value) {  
				$.ajax({
					url: baseurl + 'PendaftaranMasterItem/SettingEmail/deleteemail',
					data: {id : id, ket : ket},
					type : "POST",
					dataType: "html",
					success: function(data) {
						Swal.fire({
							title: 'Data Berhasil di Hapus!',
							type: 'success',
							allowOutsideClick: false
						}).then(result => {
							if (result.value) {
								// console.log(data)
								window.location.href =  baseurl + data;
						}})  
					}
				})
	}})  
}

function deleteorg_group(no) {
	var id = $('#id_org'+no).val();
	var nama = $('#nama_group'+no).val();
	Swal.fire({
			title: 'Apakah Anda Yakin?',
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
	}).then(result => {
			if (result.value) {  
				$.ajax({
					url: baseurl + 'MasterItemPIEA/SettingData/deleteorg',
					data: {id : id, nama : nama},
					type : "POST",
					dataType: "html",
					success: function(data) {
						Swal.fire({
							title: 'Data Berhasil di Hapus!',
							type: 'success',
							allowOutsideClick: false
						}).then(result => {
							if (result.value) {
								// console.log(data)
								window.location.href =  baseurl + 'MasterItemPIEA/SettingData';
						}})  
					}
				})
	}})  
}
