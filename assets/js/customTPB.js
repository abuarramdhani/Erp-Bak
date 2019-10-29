function OpenDetailNol(th) {
	var no_spb = th;
	$('#MdlTPBNol').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"TrackingPengirimanBarang/SortingCenter/OpenDetailSorting",
			data:{
				no_spb : no_spb,
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