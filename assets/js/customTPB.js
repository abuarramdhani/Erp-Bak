function OpenDetailNol(th) {
	var no_spb = th;
	const url = window.location.href;
	const status = url.split('/')
	$('#MdlTPBNol').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/SortingCenter/OpenDetailSorting",
			data:{
				no_spb : no_spb,
				status: status[status.length - 1],
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function OpenDetailSatu(th) {
	var no_spb = th;
	const url = window.location.href;
	const status = url.split('/')
	$('#MdlTPBNol').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/SortingCenter/OpenDetailProcess",
			data:{
				no_spb : no_spb,
				status: status[status.length - 1],
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function OpenDetailDua(th) {
	var no_spb = th;
	const url = window.location.href;
	const status = url.split('/')
	$('#MdlTPBNol').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/SortingCenter/OpenDetailDelivered",
			data:{
				no_spb : no_spb,
				status: status[status.length - 1],
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

$(document).ready(function(){
	$('.tblTPB').DataTable({
		"paging": true,
		"info": true,
		"language" : {
			"zeroRecords": " "
		}
	})

	})

$(document).ready(function(){
	var input_cek = $('#hasilConfirm').val();

	if (input_cek == '') {
$('tbody#tbodyTPB tr').css('background-color', '#c9efff');
	} 

	})


function saveSetupSettingTPB() {
	var id_pekerja = $('#txtIdPekerja').val();
	var nama_pekerja = $('#txtNamaPekerja').val();
	var slcKendaraan = $('#slcKendaraan').val();
	var nomer_kendaraan = $('#txtNoKendaraan').val();
	var kendaraan = $('#txtKendaraan').val();

	console.log(kendaraan);

	$.ajax({
		type: "POST",
		url: baseurl+"TrackingPengirimanBarang/Setting/KurirKendaraan/saveSetupSetting",
		data:{
			id_pekerja:id_pekerja,
			nama_pekerja:nama_pekerja,
			kendaraan:kendaraan,
			slcKendaraan:slcKendaraan,
			nomer_kendaraan:nomer_kendaraan
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

function hanyaKendaraan() {
	var id = $('#txtIdPekerja');
	var nama = $('#txtNamaPekerja');

	id.prop('readonly', true);
	nama.prop('readonly', true);
	$('#slcKendaraan').prop('disabled', true);
	$('#slcKendaraan').val(null).trigger('change');
	$('#txtKendaraan').prop('readonly', false);
	$('#txtNoKendaraan').prop('readonly', false);

	Swal.fire({
			  type: 'success',
			  title: 'Setting Input Kendaraan',
			  showConfirmButton: false,
			  timer: 1000
	})

}

function reload() {
	var id = $('#txtIdPekerja');
	var nama = $('#txtNamaPekerja');

	id.prop('readonly', false);
	nama.prop('readonly', false);
	$('#slcKendaraan').prop('disabled', false);
	$('#txtKendaraan').prop('readonly', true);
	$('#txtNoKendaraan').prop('readonly', true);
	$('#txtKendaraan').val(null).trigger('change');
	$('#txtNoKendaraan').val(null).trigger('change');

	Swal.fire({
			  type: 'success',
			  title: 'Setting Input Kurir',
			  showConfirmButton: false,
			  timer: 1000
			})

}

function onChangeJK() {
	var select = $('#slcKendaraan').val();
	var txtDisabled = $('#txtKendaraan');

	if (select !== ""){
		$('#txtKendaraan').prop('readonly', true);
		$('#txtNoKendaraan').prop('readonly', true);
		$('#txtKendaraan').val(null).trigger('change');
		$('#txtNoKendaraan').val(null).trigger('change');
	}else{
		$('#txtKendaraan').prop('readonly', false);
		$('#txtNoKendaraan').prop('readonly', false);
	}
}

function deleteLogin(th1, th2) {
	id_login = th1;
	nama_pekerja = $('#hdnTxt'+id_login+'').val();

const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Kurir Akan Dihapus',
		  text: 'Yakin ingin menghapus Kurir '+nama_pekerja+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
		type: "POST",
		url: baseurl+"TrackingPengirimanBarang/Setting/KurirKendaraan/deleteLogin",
		data:{
			id_login:id_login
		},
		success: function (response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Kurir '+nama_pekerja+' berhasil dihapus!',
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
      'Kurir '+nama_pekerja+' batal dihapus :)',
      'error'
    )
  }
})
}

function MdlEditSetup(th) {
	var id_login = th;
	$('#mdlSetupTPB').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/Setting/KurirKendaraan/updateLogin",
			data:{
				id_login : id_login,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function updateSetupSettingTPB(th) {
	var id_login = th;
	var username = $('#txtIdPekerja_updte').val();
	var nama_pekerja = $('#txtNamaPekerja_updte').val();
	var kendaraan = $('#slcKendaraan_updte').val();

	$.ajax({
		type : "POST",
	 	url : baseurl+"TrackingPengirimanBarang/Setting/KurirKendaraan/funUpdateLogin",
	 	data:{
	 		id_login:id_login,
	 		username:username,
	 		nama_pekerja:nama_pekerja,
	 		kendaraan:kendaraan,
	 	},
	 	success: function (response) {
	 		Swal.fire({
			  type: 'success',
			  title: 'Data has been updated!',
			  showConfirmButton: false,
			  timer: 1500
			})
		$('#mdlSetupTPB').modal('hide');
			window.location.reload();

	 	}
	})

}

$(document).ready(function() {
    var table = $('.tblResponsive').DataTable( {
        responsive: true,
        fixedHeader: true,
    } );

} );

function deleteData(th) {
	var no_spb = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Data Akan Dihapus',
		  text: 'Yakin ingin menghapus data dengan SPB '+no_spb+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
		type: "POST",
		url: baseurl+"TrackingPengirimanBarang/Delivered/deleteSPB",
		data:{
			no_spb:no_spb
		},
		success: function (response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Data dengan SPB '+no_spb+' berhasil dihapus!',
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
      'Data dengan SPB '+no_spb+' batal dihapus :)',
      'error'
    )
  }
})
}

function buttonConYes(th) {
	console.log(th)
	var row = $(th).closest('tr');
	var test = row.css('background-color', 'white');
	var div = row.find('div.inidiv');
	var hasil = row.find('#hasilConfirm');
	hasil.val('Y').trigger('change')
	console.log(th)

	// var tedeh = $('.mawank tr td.tedeh');
	// line.val('Y').trigger('change');
	var html = '<button type="button" id="btnTerima" style="margin-right: 5px;" class="btn btn-success btn-sm" value="Y"><i class="fa fa-check"></i> Accepted </button>';
	html += '<button type="button" onclick="BtnReload(this)" class="btn btn-warning btn-sm"><i class="fa fa-refresh">  </i></button> '
	div.html(html);
}

function BtnReload(th) {
	var row = $(th).closest('tr');
	var test = row.css('background-color', '#c9efff');
	var div = row.find('div.inidiv');
	var hasil = row.find('#hasilConfirm');
	hasil.val('').trigger('change')

	var html = '<button type="button" style="margin-right:5px" onclick="buttonConYes(this)" class="btn btn-sm btn-success" name="btnYes"><i class="fa fa-check"></i></button>';
    html +=   '<button type="button" class="btn btn-sm btn-danger" onclick="buttonConNo(this)" name="btnNO"><i class="fa fa-remove"></i></button>'
    div.html(html);
}

function buttonConNo(th) {
	var row = $(th).closest('tr');
	var test = row.css('background-color', 'white');
	var div = row.find('div.inidiv');
	var hasil = row.find('#hasilConfirm');
	hasil.val('N').trigger('change')
	
	var html = '<button type="button" id="btnTolak" style="margin-right: 5px;" class="btn btn-danger btn-sm" value="N"><i class="fa fa-remove"></i> Rejected </button>';
	html += '<button type="button" onclick="BtnReload(this)" class="btn btn-warning btn-sm"><i class="fa fa-refresh">  </i></button> '

	div.html(html);
}



function submitConfirmation(th) {

		var no_spb = th;
		var note = $('#noteTPB').val();


		var arry = [];
		$('input[name~="hasilConfirm[]"]').each(function(){
		var confirm = $(this).val();
		arry.push(confirm);
		});


		var arry1 = [];
		$('input[name~="line_id[]"]').each(function(){
		var line_id = $(this).val();
		arry1.push(line_id);
		});

		if (note == '') {
			Swal.fire({
			  type: 'error',
			  title: 'Harap Masukkan Note!',
			  showConfirmButton: false,
			  timer: 1500
			})
		}else if (note !== '') {

		$.ajax({
		type: "POST",
		url: baseurl+"TrackingPengirimanBarang/OnProcess/submitConfirmation",
		data:{
			confirm_status:arry,
			line_id:arry1,
			note:note,
			no_spb:no_spb
		},
		success: function (response) {
						Swal.fire({
						  type: 'success',
						  title: 'Data has been updated!',
						  showConfirmButton: false,
						  timer: 1500
						})
				window.location.replace(baseurl+"TrackingPengirimanBarang/OnProcess")
			 		}

				});
			
		}
		
}

function cekKacab(th) {
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


	var nomor_induk = $('#txtIdPekerja').val();

	$.ajax({
			method: "POST",
			url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/cekNoInd",
			dataType: 'JSON',
			data:{
					nomor_induk:nomor_induk,
				},
			success: function(response) {
				console.log(response)

				if (response !== '0') {
						var employee_code = '';
						var employee_name = '';	
						var section_name = '';
							$.each(response, (i, item) => {
								employee_code = item.employee_code
								employee_name = item.employee_name
								section_name = item.section_name
							})
						$('#txtNamaPekerja').val(employee_name).trigger('change');
						$('#txtSectionName').val(section_name).trigger('change');
						$('#slcStatusKacab option[value=Y]').attr('selected', 'selected').trigger('change');
						Swal.fire({
									  type: 'success',
									  title: 'User ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
				}else if (response == '0'){
						$('#txtNamaPekerja').val('').trigger('change');
						$('#txtSectionName').val('').trigger('change');
						$('#slcStatusKacab').val('').trigger('change');
						Swal.fire({
									  type: 'error',
									  title: 'Maaf, user yang sudah pernah ditambahkan tidak bisa ditambahkan kembali',
									  showConfirmButton: false,
									  timer: 1500
									})
				}
			}
		})
}

function addKacab(th) {
	var nomor_induk = $('#txtIdPekerja').val();
	var nama_kacab = $('#txtNamaPekerja').val();
	var section_name = $('#txtSectionName').val();
	var status = $('#slcStatusKacab').val();
	var alamat_cabang = $('#txaAlamatCabang').val();

$.ajax({
			method: "POST",
			url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/addKacab",
			data:{
					nomor_induk:nomor_induk,
					nama_kacab:nama_kacab,
					section_name:section_name,
					status:status,
					alamat_cabang:alamat_cabang
				},
			success: function(response) {
				Swal.fire({
						  type: 'success',
						  title: 'User has been added!',
						  showConfirmButton: false,
						  timer: 1500
						})
				window.location.reload();

}
})
}

function deleteKacab(th) {
	var id_login = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'User Akan Dihapus',
		  text: 'Yakin akan menghapus user ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/deleteKacab",
					data:{
						id_login:id_login,
					},
					success: function(response) {
						$('tr.'+id_login+'').remove()
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'User berhasil dihapus!',
					      'success'
					    	)
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'User batal dihapus',
      'error'
    )
  }
})
}

function DiactivatedUser(th) {
	var id_login = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'User Akan Dinon-aktifkan',
		  text: 'Yakin akan menon-aktifkan user ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, non-aktifkan!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/DiactivatedUser",
					data:{
						id_login:id_login,
					},
					success: function(response) {
						$('.status'+id_login+'').html('<span><label class="label label-danger" style="width: 80px">Tidak Aktif</label></span>')
						$('.btnActivating'+id_login+'').html('<button id="btnDiactivated" onclick="activatedUser('+id_login+')" class="btn btn-primary btn-sm" style="width: 100px"><i class="fa fa-check"></i> Aktifkan</button>')
						  swalWithBootstrapButtons.fire(
					      'Berhasil!',
					      'User berhasil dinon-aktifkan!',
					      'success'
					    	)
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'User batal Dinon-aktifkan',
      'error'
    )
  }
})
}

function activatedUser(th) {
	var id_login = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'User Akan Diaktifkan',
		  text: 'Yakin akan mengaktifkan user ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, aktifkan!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/activatedUser",
					data:{
						id_login:id_login,
					},
					success: function(response) {
						$('.status'+id_login+'').html('<span><label class="label label-primary" style="width:80px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aktif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></span>')
						$('.btnActivating'+id_login+'').html('<button id="btnDiactivated" onclick="DiactivatedUser('+id_login+')" class="btn btn-primary btn-sm" style="width: 100px"><i class="fa fa-times"></i> Non-Aktifkan</button>')
						  swalWithBootstrapButtons.fire(
					      'Berhasil!',
					      'User berhasil diaktifkan!',
					      'success'
					    	)
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'User batal Diaktifkan',
      'error'
    )
  }
})

}

function editKacab(th) {
	var id_login = th;

	$('#mdlKacab').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/EditKacab",
			data:{
				id_login:id_login
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function btnEditKacab(th) {
	var id_login = th;
	var alamat_cabang = $('#txaAlamatCabangEd').val()
	var status = $('#slcStatusKacabEd').val()
	var section_name = $('#txtSectionNameEd').val()
	var nama_kacab = $('#txtNamaKacabEd').val()
	var nomor_induk = $('#txtNomorIndukEd').val()
 
	$.ajax({
					type: "POST",
					url: baseurl+"TrackingPengirimanBarang/Setting/KepalaCabang/updateKacab",
					data:{
						id_login:id_login,
						alamat_cabang:alamat_cabang,
						status:status,
						section_name:section_name,
						nama_kacab:nama_kacab,
						nomor_induk:nomor_induk
					},
					success: function(response) {
						$('#mdlKacab').modal('hide');
						Swal.fire({
						  type: 'success',
						  title: 'User has been updated!',
						  showConfirmButton: false,
						  timer: 1500
						})

						window.location.reload();
			 		}
				});
}
