$('#btnClearMI').click(function(){

	$('#invoice_id_nih').val('').trigger('change');
	$('#nomorPOID').val('').trigger('change');
	$('#slcVendor').val('').trigger('change');
	$('#termOfPayment').val('').trigger('change');
	$('#ppn_status').val('').trigger('change');
	$('#invoice_date').val('').trigger('change');
	$('#invoice_numbergenerate').val('').trigger('change');
	$('#inv_amount_akt').val('').trigger('change');
	$('#invoice_category').val('').trigger('change');
	$('#jenis_jasa').val('').trigger('change');
	$('#slcKategori').val('').trigger('change');
	$('.slckelengkapandokumenakuntansi').val('').trigger('change');
	$('#txaKeterangan').val('').trigger('change');

	$('.customDiv').html('');
	$('.customDoc').html('');
	$('td#jenis_jasa').html('');
})

function ambilNominalPPPN() {
	var nominal_dpp = $('#idNominalDpp').val();
	var nom_dpp = $('#idNominalDpp');
	var nominal_ppn = $('#nominalPPN');
	var coba = $('#ppn_status').val();
	var tax = $('#tax_id_inv');

	if (coba === 'Y') {
var persentase = (Number(nominal_dpp) * 10) / 100;
nominal_ppn.val(persentase);
nominal_ppn.trigger('change');
nominal_ppn.moneyFormat();
nom_dpp.moneyFormat();
} else if (coba === 'N'){
nominal_ppn.val('0');
nominal_ppn.trigger('change');
}
}

function resetInvBermasalah(th) {
	var invoice_id = th


	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Invoice akan dihapus!',
		  text: 'Yakin ingin menghapus Invoice ini ?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/resetInvoice",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				Swal.fire({
				  type: 'success',
				  title: 'Invoice berhasil dihapus dari Invoice Bermasalah',
				  showConfirmButton: true,
				})

				window.location.reload();
			}
		})

  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Invoice batal dihapus',
      'error'
    )
  }
})

	
}

function bukaHasilConf(th) {
	var invoice_id = th;
	$('#MdlAkuntansi').modal('show');
	$('h5.modal-title').html('HASIL KONFIRMASI CEKLIST DOKUMEN PURCHASING')
	$('h5.modal-title-footer').html('<i>(*)Dokumen Ditolak Purchasing = Dokumen tidak tersedia/Dokumen tidak diturunkan (kecuali kondisi Without Document)</i>')
	$('modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/getHasilKonfirmasi",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
			}
		})
}

function returnedConfirmation(th) {
	var invoice_id = th

	$('#MdlPurchasing').modal('show');
	$('h5.modal-title').html('MASUKKAN FEEDBACK INVOICE RETURNED UNTUK AKUNTANSI')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/showReturnedfromAkuntansi",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="submitReturned('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})	

}

function returnedConfirmationBuyer(th) {
	var invoice_id = th

	$('#MdlBuyer').modal('show');
	$('h5.modal-title').html('MASUKKAN FEEDBACK INVOICE RETURNED DARI BUYER')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/showModalReturnBuyer",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="submitReturnedBuyer('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})	

}

function submitReturned(th) {
	var invoice_id = th;
	var note_return_purchasing = $('#txaReturnPurc').val();

	$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/returnToAkuntansi",
			data:{
				invoice_id:invoice_id,
				note_return_purchasing:note_return_purchasing
			},
			success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Konfirmasi pengembalian invoice ke Akuntansi berhasil',
			  showConfirmButton: false,
			  timer: 1500
			})

			window.location.reload();
			}
		})
}

function submitReturnedBuyer(th) {
	var invoice_id = th;
	var note_return_buyer = $('#txaReturnBuyer').val();

	$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/returnToAkuntansiBuyer",
			data:{
				invoice_id:invoice_id,
				note_return_buyer:note_return_buyer
			},
			success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'Konfirmasi pengembalian invoice dari Buyer berhasil',
			  showConfirmButton: false,
			  timer: 1500
			})

			window.location.reload();
			}
		})
}

// $(document).ready(function(){

function kategoriBermasalah(th) {
	var param = $('#slcKategori').val();
	if (param !== null) {
	var param2 = param.includes("LainLain");
	var cek = $('#inputLain').val();
	if(typeof cek == 'undefined') cek = "";
	// console.log(param2)
	if (param2 == true && cek == "") {
		$('.customDiv').html('<input type="text" class="form-control" placeholder="Masukkan Keterangan" style="width: 320px;" name="txtLainLain" id="inputLain">')
	}
	else if (param2 == false){
		$('.customDiv').html('')
	}
}
}

function kelengkapanDokumen(th) {
	var param = $('#slcKelengkapanDokumen').val()
	if (param !== null) {
	var param2 = param.includes("DokumenLain");
	var cek = $('#dokumenLain').val();
	if(typeof cek == 'undefined') cek = "";
	// console.log(param2)
	if (param2 == true && cek == "") {
		$('.customDoc').html('<input type="text" class="form-control" placeholder="Masukkan Keterangan" style="width: 320px;" name="txtDokumenLain" id="dokumenLain">')
	}
	else if (param2 == false){
		$('.customDoc').html('')
	}
}
}

// })

function updatePO(th) {
	var invoice_id = th
	var nomor_po = $('#nomorPOID').val();
	var vendor_id = $('#slcVendorEdit').val();
	var top = $('#termOfPayment').val();
	var ppn = $('#ppn_status').val();

		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/Unprocess/updatePONumberBermasalah",
			data:{
				invoice_id:invoice_id,
				nomor_po:nomor_po,
				vendor_id:vendor_id,
				top:top,
				ppn:ppn
			},
			success: function(response){
			Swal.fire({
			  type: 'success',
			  title: 'PO pada Invoice ID '+invoice_id+' berhasil diupdate!',
			  showConfirmButton: false,
			  timer: 1500
			})

			window.location.replace(baseurl+'AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt');
			}
		})

}

//tiket delete rejected mon invoice------------------------------------------------------------//

function deleteRejectedInv(th) {

	var arry = [];
		$('input[name="rejectedChckBox[]"]').each(function(){
			if ($(this).parent().hasClass('checked')) {
				var id_invoice = $(this).val();
				arry.push(id_invoice);
			}
		});


	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Invoice akan dihapus!',
		  text: 'Yakin ingin menghapus Invoice ini ?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/deleteInvoice",
					dataType: 'JSON',
					data:{
						invoice_id:arry,
					},
					success: function(response) {

				$.each(response, (i, item) => {
					$('tr.'+item+'').remove();
				})
						  swalWithBootstrapButtons.fire(
					      'Finished!',
					      'Invoice berhasil dihapus!',
					      'success'
					    	)
			 		}


				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Invoice batal dihapus',
      'error'
    )
  }
})
}

$(document).on('ifChanged','.submit_checking_all_rejected', function() {
		if ($('.submit_checking_all_rejected').iCheck('update')[0].checked) {
			$('.chckInvoice_rejected').each(function () {
				var a = $(this).parent().parent().closest('tr').find('input[class~="chckInvoice_rejected"]');
				if (a) {
					$(this).iCheck('check');
				}
			});
		}else{
			$('.chckInvoice_rejected').each(function () {
				$(this).iCheck('uncheck');
			});
		};
	})

//tiket delete rejected mon invoice------------------------------------------------------------//

function btnApproveBerkas(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_pembelian');
	var div_date = row.find('.date_purc');
	var input = row.find('#pembelian_id');
	var date = row.find('#inputDatePurc');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('Y').trigger('change');
	div.html('<span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');

}

function btnReApproveBerkas(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_repurc');
	var div_date = row.find('.date_repurc');
	var input = row.find('#repurc_id');
	var date = row.find('#inputDateRePurc');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('Y').trigger('change');
	div.html('<span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnReApproveBerkasAkt(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_akt');
	var div_date = row.find('.date_reakt');
	var input = row.find('#reakt_id');
	var date = row.find('#inputDateReAkt');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('Y').trigger('change');
	div.html('<span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnRejectBerkas(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_pembelian');
	var div_date = row.find('.date_purc');
	var input = row.find('#pembelian_id');
	var date = row.find('#inputDatePurc');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('N').trigger('change');
	div.html('<span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnReRejectBerkas(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_repurc');
	var div_date = row.find('.date_repurc');
	var input = row.find('#repurc_id');
	var date = row.find('#inputDateRePurc');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('N').trigger('change');
	div.html('<span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnReRejectBerkasAkt(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_akt');
	var div_date = row.find('.date_reakt');
	var input = row.find('#reakt_id');
	var date = row.find('#inputDateReAkt');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('N').trigger('change');
	div.html('<span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span>');
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnApproveBuyer(th) {

	var row = $(th).closest('tr');
	var div = row.find('.hasil_buyer');
	var div_date = row.find('.date_buyer');
	var input = row.find('#buyer_id');
	var date = row.find('#inputDateBuyer');
	var btn = row.find('#btnRejected');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	btn.prop('disabled', true);
	input.val('Y').trigger('change');
	div.html('<span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span>')
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function btnRejectBuyer(th) {
	var row = $(th).closest('tr');
	var div = row.find('.hasil_buyer');
	var div_date = row.find('.date_buyer');
	var input = row.find('#buyer_id');
	var date = row.find('#inputDateBuyer');
	var tanggal = moment().format('DD/MM/YYYY hh:mm:ss'); 

	input.val('N').trigger('change');
	div.html('<span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span>')
	date.val(tanggal).trigger('change');
	div_date.html('<span>'+tanggal+'</span>');
}

function KonfirmasiBerkasPurc(th) {

	var feedback = $('#txaFbPurc').val()
	var invoice_id = th;
	var arry = [];
	$('input#pembelian_id').each(function(){
	var tipe = $(this).val();
	arry.push(tipe);
	});

	if (feedback == "") {
		Swal.fire({
			  type: 'error',
			  title: 'Harap Masukkan Feedback!',
			  showConfirmButton: false,
			  timer: 1500
			})
	}else {

	console.log(arry)
	
	$('#mdlNotifikasiKasie').modal('show');
	$('#mdlYesAkt').click(function(){
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/saveInvBermasalah",
			data:{
				invoice_id:invoice_id,
				txaFbPurc:feedback,
				status_berkas:arry
			},
			success: function(response){
				Swal.fire(
  					'Saved!',
  					'Data sudah dikonfirmasi',
  					'success'
						);
			$('#mdlNotifikasiKasie').modal('hide');
			window.location.replace(baseurl+'AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List')
			}
		})
	})
}
}

function openMdlPurcConf(th) {

	var invoice_id = th;
	$('#MdlPurchasing').modal('show');
	$('h5.modal-title').html('KONFIRMASI DOKUMEN BERMASALAH (PURCHASING)')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/getDataDokumen",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="saveBerkas('+th+')" id="btnSave"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

function konfirmasiKembaliPurc(th) {

	var invoice_id = th;
	$('#MdlPurchasing').modal('show');
	$('h5.modal-title').html('REKONFIRMASI DOKUMEN BERMASALAH DARI BUYER')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/getDataReKonfirmasi",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="saveBerkasRePurc('+th+')" id="btnSave"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

function konfirmasiKembaliAkt(th) {

	var invoice_id = th;
	$('#MdlAkuntansi').modal('show');
	$('h5.modal-title').html('REKONFIRMASI DOKUMEN BERMASALAH DARI PURCHASING')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/getDataReKonfirmasi",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="saveBerkasReAkt('+th+')" id="btnSave"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

function saveBerkasReAkt(th) {
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

	var invoice_id = th;

	var arry = [];
	$('input#dokumen_id').each(function(){
	var doc_id = $(this).val();
	arry.push(doc_id);
	});

	var arry2 = [];
	$('input#reakt_id').each(function(){
	var hasil = $(this).val();
	arry2.push(hasil);
	});

	var arry3 = [];
	$('input#inputDateReAkt').each(function(){
	var time = $(this).val();
	arry3.push(time);
	});
// console.log(arry2);

	  $.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/saveReconfirmInvBermasalah",
			data:{
				invoice_id:invoice_id,
				// txaFbPurc:feedback,
				status_berkas:arry2,
				waktu_berkas:arry3,
				doc_id:arry
			},
			success: function(response){
				Swal.fire(
  					'Saved!',
  					'Data konfirmasi tersimpan',
  					'success'
						);
			$('#MdlAkuntansi').modal('hide');
			window.location.reload();
			}
})
}

function saveBerkasRePurc(th) {
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

	var invoice_id = th;

	var arry = [];
	$('input#dokumen_id').each(function(){
	var doc_id = $(this).val();
	arry.push(doc_id);
	});

	var arry2 = [];
	$('input#repurc_id').each(function(){
	var hasil = $(this).val();
	arry2.push(hasil);
	});

	var arry3 = [];
	$('input#inputDateRePurc').each(function(){
	var time = $(this).val();
	arry3.push(time);
	});

	// console.log(arry2)


	  $.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/saveReconfirmInvBermasalah",
			data:{
				invoice_id:invoice_id,
				// txaFbPurc:feedback,
				status_berkas:arry2,
				waktu_berkas:arry3,
				doc_id:arry
			},
			success: function(response){
				Swal.fire(
  					'Saved!',
  					'Data konfirmasi tersimpan',
  					'success'
						);
			$('#MdlPurchasing').modal('hide');
			window.location.reload();
			}
})
}

function saveBerkas(th) {

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

	var invoice_id = th;

	var arry = [];
	$('input#dokumen_id').each(function(){
	var doc_id = $(this).val();
	arry.push(doc_id);
	});

	var arry2 = [];
	$('input#pembelian_id').each(function(){
	var hasil = $(this).val();
	arry2.push(hasil);
	});

	var arry3 = [];
	$('input#inputDatePurc').each(function(){
	var time = $(this).val();
	arry3.push(time);
	});


	  $.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/saveInvBermasalah",
			data:{
				invoice_id:invoice_id,
				status_berkas:arry2,
				waktu_berkas:arry3,
				doc_id:arry
			},
			success: function(response){
				Swal.fire(
  					'Saved!',
  					'Data konfirmasi tersimpan',
  					'success'
						);
			$('#MdlPurchasing').modal('hide');
			window.location.reload();
			}
})
}


function KonfirmasiBuyer(th) {

	var invoice_id = th;
	$('#MdlBuyer').modal('show');
	$('h5.modal-title').html('KONFIRMASI DOKUMEN BERMASALAH (BUYER)')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/KonfirmasiBuyer",
			data: {
					invoice_id:invoice_id
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="saveKonfirmasiBuyer('+th+')" id="btnForward"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

function saveKonfirmasiBuyer(th) {
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

	var invoice_id = th;
	// var feedback = $('#txaFbPurc').val()

	var arry = [];
	$('input#dokumen_id').each(function(){
	var doc_id = $(this).val();
	arry.push(doc_id);
	});

	var arry2 = [];
	$('input#buyer_id').each(function(){
	var hasil = $(this).val();
	arry2.push(hasil);
	});

	var arry3 = [];
	$('input#inputDateBuyer').each(function(){
	var time = $(this).val();
	arry3.push(time);
	});


	  $.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/saveInvBermasalahBuyer",
			data:{
				invoice_id:invoice_id,
				status_berkas:arry2,
				waktu_berkas:arry3,
				doc_id:arry
			},
			success: function(response){
				Swal.fire(
  					'Saved!',
  					'Data konfirmasi tersimpan',
  					'success'
						);
			$('#MdlBuyer').modal('hide');
			window.location.reload();
			}
})
}

function FeedbackBuyer(th) {
	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

 swalWithBootstrapButtons.fire(
      'Peringatan!',
      'Sebelum memberikan feedback ke Purchasing, pastikan invoice sudah dikonfirmasi!',
      'error'
    )

	var invoice_id = th;

	$('#MdlBuyer').modal('show');
	$('h5.modal-title').html('MASUKKAN FEEDBACK INVOICE BERMASALAH UNTUK PURCHASING')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/InputFeedbackBuyer",
			data : {
				invoice_id:invoice_id
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="sendFeedbackBuyer('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})
	
}

function selesaikanInvoice(th) {

	Swal.fire(
  					'Info!',
  					'Pastikan berkas yang perlu direkonfirmasi sudah dilakukan rekonfirmasi',
  					'info'
			);
	var invoice_id = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Invoice akan diselesaikan',
		  text: 'Yakin ingin menngakhiri Invoice ID.'+invoice_id+' dari status Bermasalah?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, end it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/EndStatus",
					data:{
						invoice_id:invoice_id,
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Finished!',
					      'Invoice ID.'+invoice_id+' berhasil diselesaikan!',
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
      'Invoice ID.'+invoice_id+' batal diselesaikan',
      'error'
    )
  }
})

}

function openReturnedInv(th) {
	var invoice_id = th

	$('#MdlAkuntansi').modal('show');
	$('h5.modal-title').html('KEMBALIKAN INVOICE BERMASALAH KE PURCHASING')
	$('modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/openModalReturned",
			data:{
				invoice_id:invoice_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				// $('h5.modal-title-footer').html('<i>(*)Kategori <b>Dokumen Lain</b> harap sertakan keterangan nama dokumen di Note</i>')
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="returnedInvoice('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})

}

function returnedInvoice(th) {

	// var param = $('#hdnRestatus').val()
	// if (param !== '') {
			var invoice_id = th;
			var note_purchasing = $('#noteForPurcReturned').val();

			var dokumen_returned = [];
			$('select[name~="slcKelengkapanDokumen[]"]').each(function(){
			var doc_id = $(this).val();
			dokumen_returned.push(doc_id);
			});

					const swalWithBootstrapButtons = Swal.mixin({
					  customClass: {
					    confirmButton: 'btn btn-success',
					    cancelButton: 'btn btn-danger'
					  },
					  buttonsStyling: true
					})

				swalWithBootstrapButtons.fire({
					  title: 'Invoice akan dikembalikan ke Purchasing',
					  text: 'Yakin ingin mengembalikan Invoice ID.'+invoice_id+' ke Purchasing?',
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonText: 'Yes, return it!',
					  cancelButtonText: 'No, cancel!',
					  reverseButtons: true
				}).then((result) => {
			  if (result.value) {
				  	$.ajax({
								type: "POST",
								url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/Returning",
								data:{
									invoice_id:invoice_id,
									note_purchasing:note_purchasing,
									dokumen_returned:dokumen_returned
								},
								success: function(response) {
									  swalWithBootstrapButtons.fire(
								      'Finished!',
								      'Invoice ID.'+invoice_id+' berhasil dikembalikan, pantau invoice di menu Returned Invoice!',
								      'success'
								    	)
									  window.location.replace(baseurl+'AccountPayables/MonitoringInvoice/ReturnedInvoice');
						 		}

							});
				  
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Invoice ID.'+invoice_id+' batal dikembalikan',
      'error'
    )
  }
})

// }else if (param == ''){
// 	Swal.fire(
//   					'Perhatian!',
//   					'Harap lakukan rekonfirmasi berkas sebelum mengembalikan Invoice',
//   					'info'
// 			);
// }

}

function goReturn(th) {
	
}

$( document ).ready(function() {
	$('.selectBuyer').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
})

function submitToBuyer(th) {

	var invoice_id = th

const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

 swalWithBootstrapButtons.fire(
      'Peringatan!',
      'Sebelum forward ke buyer, pastikan invoice sudah dikonfirmasi!',
      'error'
    )


	$('#MdlPurchasing').modal('show');
	$('h5.modal-title').html('PILIH BUYER UNTUK FORWARD INVOICE')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/getDataBuyer",
			data: {
				invoice_id:invoice_id
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="forwardAkt('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Forward</button>');
			}
		})
}

function feedbackAkt(th) {

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

 swalWithBootstrapButtons.fire(
      'Peringatan!',
      'Sebelum memberi feedback ke Akuntansi, pastikan invoice sudah dikonfirmasi!',
      'error'
    )

	var invoice_id = th;

	$('#MdlPurchasing').modal('show');
	$('h5.modal-title').html('MASUKKAN FEEDBACK INVOICE BERMASALAH UNTUK AKUNTANSI')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/InputFeedback",
			data : {
				invoice_id:invoice_id
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="sendFeedback('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})

}

function sendFeedback(th) {
	var param = $('#hdnBerkasPurc').val();
	var invoice_id = th;
	var feedback = $('#txaFbPurc').val();

	if (param !== " " ) {

			if (param == "" ){

				Swal.fire({
				  type: 'info',
				  title: 'Harap konfirmasi berkas sebelum memberi feedback ke Akuntansi',
				  showConfirmButton: true
				})

			}else if (param !== "" ){

				$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/submitFeedback",
					data:{
						invoice_id:invoice_id,
						feedback:feedback
					},
					success: function(response) {
						 Swal.fire(
  					'Sent!',
  					'Data sudah diberi feedback',
  					'success'
						);
						 $('#MdlPurchasing').modal('hide');
						  window.location.reload();
			 		}

				});
			}

	}else if (param == " " ) {

		Swal.fire({
				  type: 'info',
				  title: 'Harap konfirmasi berkas sebelum memberi feedback ke Akuntansi',
				  showConfirmButton: true
				})
	} 
	
}

function sendFeedbackBuyer(th) {

	var invoice_id = th;
	var feedback = $('#txaFbBuyer').val();
	var param = $('#hdnBerkasPurc').val();

		if (param !== " " ) {

				if (param == "" ){

					Swal.fire({
					  type: 'info',
					  title: 'Harap konfirmasi berkas sebelum memberi feedback ke Purchasing',
					  showConfirmButton: true
					})

				}else if (param !== "" ){

					$.ajax({
						type: "POST",
						url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/submitFeedbackBuyer",
						data:{
							invoice_id:invoice_id,
							feedback:feedback
						},
						success: function(response) {
							 Swal.fire(
	  					'Sent!',
	  					'Data sudah diberi feedback',
	  					'success'
							);
							 $('#MdlBuyer').modal('hide');
							  window.location.reload();
				 		}

					});
				}
				
		}else if (param == " " ) {
		Swal.fire({
				  type: 'info',
				  title: 'Harap konfirmasi berkas sebelum memberi forward ke Purchasing',
				  showConfirmButton: true
				})
		} 
	}

function forwardAkt(th) {
	var param = $('#hdnBerkasPurc').val();

	if (param !== " " ) {

			if (param == "" ){

				Swal.fire({
				  type: 'info',
				  title: 'Harap konfirmasi berkas sebelum memberi forward ke Buyer',
				  showConfirmButton: true
				})

			}else if (param !== "" ){
				
				var invoice_id = th;
					var no_induk_buyer = $('select#selectBuyer').val();
					var note = $('#noteForBuyer').val()

					const swalWithBootstrapButtons = Swal.mixin({
						  customClass: {
						    confirmButton: 'btn btn-success',
						    cancelButton: 'btn btn-danger'
						  },
						  buttonsStyling: true
						})

					swalWithBootstrapButtons.fire({
						  title: 'Invoice akan di forward',
						  text: 'Yakin ingin memforward Invoice ID.'+invoice_id+' ke '+no_induk_buyer+'?',
						  type: 'warning',
						  showCancelButton: true,
						  confirmButtonText: 'Yes, forward it!',
						  cancelButtonText: 'No, cancel!',
						  reverseButtons: true
					}).then((result) => {
				  if (result.value) {
					  	$.ajax({
									type: "POST",
									url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/submitKeBuyer",
									data:{
										invoice_id:invoice_id,
										no_induk_buyer:no_induk_buyer,
										note:note
									},
									success: function(response) {
										  swalWithBootstrapButtons.fire(
									      'Forwarded!',
									      'Invoice ID.'+invoice_id+' berhasil dikirim!',
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
				      'Invoice ID.'+invoice_id+' batal diforward',
				      'error'
				    )
				    $('#MdlPurchasing').modal('hide');
				  }
				})
			}
	}else if (param == " " ) {

		Swal.fire({
				  type: 'info',
				  title: 'Harap konfirmasi berkas sebelum memberi forward ke Buyer',
				  showConfirmButton: true
				})
		} 
}


	$('.idDateInvoiceTambahInvBer').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true,
	});

$('#btnCariInvId').click(function(){
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
	})



function cariInvoicebyId() {
	var invoice_id = $('#invoice_id_nih').val();

	$.ajax({
		type : 'POST',
		url: baseurl+'AccountPayables/MonitoringInvoice/Unprocess/invBermasalah',
		data : {
			invoice_id:invoice_id,
		},
		success:function(response) {
			
			window.location.replace(baseurl+"AccountPayables/MonitoringInvoice/Unprocess/invBermasalah/"+invoice_id)
		}
	})
}

function iniVendor() {
	var nama_vendor = $('#slcVendor').val();
	$('#hdnTxt').val(nama_vendor).trigger('change');

}


$('#btnCariTop').click(function() { 
	Swal.fire({
  title: 'Please Wait ...',
  showConfirmButton: false,
  showClass: {
    popup: 'animated fadeInDown faster'
  },
  hideClass: {
    popup: 'animated fadeOutUp faster'
  }
})// $('#loading_mpm').html("<center> <img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
	var nomor_po = $('.ininopo').val();
	var vendor_name = $('.vendorNameClass');
	var top = $('.termOfPayment');
	var tax_status = $('#tax_status');

	$.ajax({
			method: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/NewInvoice/cariVendorandTerm",
			dataType: 'JSON',
			data:{
					nomor_po:nomor_po
				},
			success: function(response) {
				// console.log(response.status)

				var status = '';
				var buyer = '';

				$.each(response, (i, item) => {
					var status = item.FLAG;
					var buyer = item.BUYER;
					console.log(status+'-'+buyer)
				

									if (response == "") {
											Swal.fire({
									  type: 'error',
									  title: 'Data tidak ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})

									} else if (response !== "" && status == 'Y' ) {

									Swal.fire({
									  type: 'success',
									  title: 'Data ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
									}else if (response !== "" && status == 'N' ) {
									Swal.fire({
									  type: 'info',
									  title: 'PO dicancel harap hubungi buyer '+buyer+' !',
									  showConfirmButton: true,
									})

									}else {
										Swal.fire({
											  type: 'success',
											  title: 'Data ditemukan!',
											  showConfirmButton: false,
											  timer: 1500
											})
									}
									})

			var val1 = '';	
			var val2 = '';
			var val3 = '';
			var val4 = '';
			var val5 = '';

			$.each(response, (i, item) => {
					val2 = item.PAYMENT_TERMS
					val1 += '<option value="'+item.VENDOR_ID+'">'+item.VENDOR_NAME+'</option>'	
					val3 += '<option value="'+item.PPN+'">'+item.PPN+'</option>'	
					// val4 = item.VENDOR_NAME		
				})	
				// deskripsi.val(val1);
				// deskripsi.trigger('change');
				top.val(val2);
				top.trigger('change');

				vendor_name.html(val1);
				// vendor_name.val(response[0].VENDOR_NAME);
				vendor_name.trigger('change');

				var ini_ppn = $('#ppn_status').html(val3);
				$('#ppn_status').trigger('change');
				var coba = ini_ppn.val();
				var nominal = $('.nomppn');
				var nom_dpp = $('.nomdppfaktur');
				var tax = $('#tax_id_inv');
			
				if (coba === 'Y') {
					val5 += '<option value="Y"> Y </option>'
					val5 += '<option value="N"> N </option>'         
					tax_status.html(val5);
					tax_status.trigger('change');
				// nominal.prop('disabled', false);
				// nominal.trigger('change');

				// nom_dpp.prop('disabled', false);
				// nom_dpp.val('0').trigger('change');

				// tax.prop('disabled', false);
				// tax.val('010.005-').trigger('change');

				}else if (coba === 'N') {
					val4 += '<option value="N"> N </option>'
					val4 += '<option value="Y"> Y </option>'
					tax_status.html(val4);
					tax_status.trigger('change');
				// nominal.prop('disabled', true);
				// nominal.trigger('change');
				// nominal.val(null).trigger('change')
				// nom_dpp.prop('disabled', true);
				// nom_dpp.trigger('change');
				// nom_dpp.val(null).trigger('change')
				// tax.prop('disabled', true);
				// tax.trigger('change');
				// tax.val(null).trigger('change')
				}


			}

		});
})

$("input[id='inv_amount_akt']").keyup(function() {
    	// var invAmount = $(this).moneyFormat();
    	var invAmount = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
    	// var invAmount = $(this).val($(this).val().moneyFormat());
    	// var invAmount = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	});

$(document).ready(function(){
	//mengatur semua tabel
	$('#btn_clear_invoice').click(function() {
		$('#nama_vendor').val('').trigger('change')
	})
// --------------------------------re upload------------------//
	$('#btnMISave').click(function(){
		Swal.fire({
			  // position: 'top-end',
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
	})

	$('#btnBermasalah').click(function(){
		Swal.fire({
			  // position: 'top-end',
			  type: 'success',
			  title: 'Invoice berhasil dilaporkan!',
			  showConfirmButton: false,
			  timer: 1500
			})
	})



	$( document ).ready(function() {
	$('#slcKelengkapanDokumen').select2({
		  placeholder: 'PILIH KELENGKAPAN DOKUMEN',
		  allowClear: true,
		});
})

		$( document ).ready(function() {
	$('#slcKategori').select2({
		  placeholder: 'PILIH KATEGORI',
		  allowClear: true,
		});
})

function onClickBermasalah(th) {
	var invoice_id = th;
	var kelengkapan_doc = $('#slcKelengkapanDokumen').val();
	var kategori = $('#slcKategori').val();
	var keterangan = $('#txaKeterangan').val();

	console.log(invoice_id, kelengkapan_doc, kategori, keterangan)

	$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/Unprocess/saveInvBermasalah",
			data:{
				invoice_id:invoice_id,
				kelengkapan_doc:kelengkapan_doc,
				kategori:kategori,
				keterangan:keterangan
			},
			success: function(response) {
				// // console.log(response, 'data');
				// $('.modal-tabel').html("");
				// $('.modal-tabel').html(response);


			}
		})

}

function openDetailAkt(th) {
	var batch_number = th;
	console.log(batch_number);

	$('#mdlDetailAkt').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/FinishInvoiceAkt/bukaModalAkutansi",
			data:{
				batch_number:batch_number
			},
			success: function(response) {
				// console.log(response, 'data');
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);


			}
		})
	
	
}

function invBermasalah(th) {
	invoice_number = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Invoice Bermasalah ?',
		  text: 'Yakin ingin melaporkan invoice '+invoice_number+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, report it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
		type: "POST",
		url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/LaporInvoice",
		data:{
			invoice_number:invoice_number
		},
		success: function (response) {
						  swalWithBootstrapButtons.fire(
					      'Reported!',
					      'Invoice '+invoice_number+' berhasil dilaporkan!',
					      'success'
					    	)
						  window.location.replace(baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt")
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Invoice '+invoice_number+' batal dilaporkan :)',
      'error'
    )
  }
})
}
// --------------------------------re upload------------------//
	$('#btnMICancel').click(function() {
		$('#poLinesTable').remove()
	})
	$('.tblMI').DataTable({
		"paging":   true,
		"ordering": true,
		"info":     false
	});
	$('span[class~="statusInvoice"]').each(function(){
	var status = $(this).attr('value');
		if(status == 2){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('check');
		}
		if(status == 1){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('uncheck');
		}
		if(status == 3){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('disable');
			$(this).parent().parent().closest('tr').find('button[name="checkbtndisable[]"]').toggleClass('btn-primary btn-info');
		}
	})
	$(document).on('ifChanged','.submit_checking_all', function() {
		if ($('.submit_checking_all').iCheck('update')[0].checked) {
			$('.chckInvoice').each(function () {
				var a = $(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]');
				if (a) {
					$(this).iCheck('check');
				}
				// $(this).prop('checked',true);
			});
		}else{
			$('.chckInvoice').each(function () {
				// $(this).prop('checked',false);
				$(this).iCheck('uncheck');
			});
		};
	})
	$('#btnSubmitChecking').click(function(){
		var jml = 0;
		var arrId = [];
		$('input[name="mi-check-list[]"]').each(function(){
			if ($(this).parent().hasClass('checked')) {
				jml = jml +1;
				valueId = $(this).val();
				arrId.push(valueId);
				var hasil = arrId.join();
				$('input[name="idYangDiPilih"]').val(hasil);
				
				$('.invoice_category').val($(this).attr('inv-cat'));
			}
		});
		$('#jmlChecked').text(jml);
		// $('#content1').slideDown();
		// $('#content2').slideUp();
	});
	// $('.inv_amount').moneyFormat();
	// $('.po_amount').moneyFormat();
	//formatting input di tax invoice number
	$("input[name='tax_invoice_number']").attr({ maxLength : 19 }).keyup(function() {
		$(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{2})(\d)+$/, "$1.$2-$3.$4"));
	});
	$('#slcVendor').val($('#slcVendor').attr('value')).trigger('change');
	
	var $po_num_btn = $('#slcPoNumberMonitoring');
	$('.btn_search').on('mousedown', function () {
		$(this).data('inputFocused', $po_num_btn.is(":focus"));
	}).click(function () {
		if ($(this).data('inputFocused')) {
			$po_num_btn.blur();
		} else {
			$po_num_btn.focus();
		}
	});
	//Untuk fungsi separator ribuan.
	$("input[id='invoice_amounttttt']").change(function() {
    	var invAmount = $(this).moneyFormat();
    	// var invAmount = $(this).val($(this).val().moneyFormat());
    	// var invAmount = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	});
	$("input[id='nominalDpp']").keyup(function() {
    	var NomDpp = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	});
	// $("input[id='AmountOtomatis']").keyup(function() {
 //    	var AmountOto = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	// });
	//untuk total po amount di halaman add invoice
	$(document).on('input click', '.qty_invoice, .del_row, input[id="invoice_amounttttt"]', function(){
		var total=0;
		var invAmount = $("input[id='invoice_amounttttt']").val(); //.replace( /[^0-9]+/g, "");
		$('.qty_invoice').each(function() {
			var qty = $(this).val();
			var rownum = $(this).attr('row-num')
			var price = $('.unit_price[row-num="'+rownum+'"]').val();
			var rowtotal = qty*price;
			total+=Number(Math.round(rowtotal));
		});	
		$('#AmountOtomatis').html(total).moneyFormat();
		 // $('#AmountOtomatis').html(total).replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
		if (total == invAmount) {
			$('#invoice_amounttttt, #AmountOtomatis').css("background-color","white");
		}else{
			$('#invoice_amounttttt, #AmountOtomatis').css("background-color","red");
		}
	});
	
	var num=0;
	$('#btnSearchPoNumber').click(function(){
		$('#tablePoLines').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
		var po_no = $('#slcPoNumberMonitoring').val();
		var line_number_sent = '0';
		$('.line_number').each(function(){
			var linenumval = $(this).val();
			line_number_sent += (', '+linenumval);
		});
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/getPoNumber/"+po_no,
			data: {line_number_sent:line_number_sent},
			// dataType: "json",
			success: function (response) {
				// console.log(response);
				
				$('#tablePoLines').html(response);
				$('#poLinesTable').DataTable({
					"paging":   false,
					"ordering": true,
					"info":     false	
				});
				//button Add menuju Invoice PO Detail (checkbox)
				$('#btnAddPoNumber').on('click', function(){
					var inputName = ['line_num','vendor_name','po_number','lppb_number','status','shipment_number',
					'received_date','item_id','item_description','qty_receipt','quantity_billed','qty_reject','currency','unit_price']
					$('.addMonitoringInvoice').each(function () {
						var html ='';
						if (this.checked) {
							var id_num = $(this).val();
							html += '<tr id="row-1">';
							$('tr#'+id_num).each(function(){
								num++;
								var col=0;
								$(this).find('td').each(function(){
									col++;
									if (col==1) {
										html+='<td>'+num+'</td>'
									}else{
										html+='<td><input style="width: 100%" name="'+inputName[(col-2)]+'[]" type="hidden" class="form-control '+inputName[(col-2)]+'" value="'+$(this).text()+'" row-num="'+num+'" readonly>'
										html+='<span>'+$(this).text()+'</span></td>';
									}
								});
							})
							html+='<td><input style="width: 100%" type="text" onchange="PresTab(this)" name="qty_invoice[]" class="form-control qty_invoice" row-num="'+num+'"></td>'; 
							html+='<td><button type="button"class="del_row btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>'; 
							html+='</tr>'; 
							$('#tbodyPoDetailAll').append(html);
						}
					});
					//untuk menghapus baris di halaman add invoice
					$('.del_row').click(function(){
						var cnf = confirm('Yakin untuk menghapusnya ?');
						var ths = $(this);
						if (cnf) {
							ths.parent('td').parent('tr').remove();
						}else{
							alert('Hapus dibatalkan');
						}
					});
					var inputCurr = $('input[name="currency[]"]').val();
					$('#currency').append(inputCurr);
				});
			}
		});
	});
	
	//formatting tanggal
	$('.idDateInvoice').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true,
	});


	$('#btnHapus').click(function(){
		alert('Yakin untuk menghapusnya ?');
	});
	$('table#tbListInvoice tbody tr, #tabel_detail_purchasing tbody tr, #finishInvoice tbody tr, #tabel_invoice tbody tr, #unprocessTabel tbody tr, #rejectinvoice tbody tr').each(function(){
		var po_amount = $(this).find('.po_amount').text();
		var inv_amount = $(this).find('.inv_amount').text();
		if (po_amount == inv_amount) {
			$(this).find('.po_amount').css("background-color","white");
			$(this).find('.inv_amount').css("background-color","white");
		}else{
			$(this).find('.po_amount').css("background-color","red").css("color","white");
			$(this).find('.inv_amount').css("background-color","red").css("color","white");
		}
	})
	$('table#tbInvoiceEdit tbody tr, #editlinespo tbody tr, #tbInvoiceKasie tbody tr, #invoiceKasiePembelian tbody tr, #filInvoice tbody tr, #detailUnprocessed tbody tr, #processedinvoice tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').text();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white");
			$('#invoice_amount').css("background-color","white");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	$('table#tbInvoice tbody tr, #rejectdetail tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').text();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white");
			$('#invoice_amount').css("background-color","white");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	$('table#tbInvoiceEdit tbody tr, #editlinespo tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').val();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white").css("color","black");
			$('#invoice_amount').css("background-color","white").css("color","black");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	
	$('#btnGenerate').click(function(){
		var invoice_date = $('#invoice_dateid').val();
		$.ajax({
			type: 'POST',
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/GenerateInvoice/",
			data: {
				invoice_date : invoice_date,
			},
			success: function(response){
				$('#invoice_numbergenerate').val('');
				$('#invoice_numbergenerate').val(response);
			}
		});
	});
	$('.RejectByKasiePurc').click(function(){
		alert('NOT OK = ALASAN HARUS DI ISI');
	});
	$("input[name='tax_input']").attr({ maxLength : 19 }).keyup(function() {
		$(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{2})(\d)+$/, "$1.$2-$3.$4"));
	});
	$('.saveTaxInvoice').click(function(){
		var tax_invoice_number = $(this).siblings('.tax_id').val();
		var id = $(this).siblings('.text_invoice_id').val();
		$.ajax({
			type: 'POST',
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/tax_invoice_number/",
			data: {
				tax_input : tax_invoice_number,
				id : id
			},
			success: function(response){
				alert('Tax Invoice Number telah di tambahkan');
			}
		});
	});
	$('#btnToFinance').click(function(){
		var status = $('.statusInvoice').attr('value');
		var arrId = [];
		$('button.statusInvoice').each(function(){
			if ($(this).hasClass('checked')) {
			var valueId = $(this).attr('inv-id');
			arrId.push(valueId);
			}
		});
		var invoice_id = arrId.join();
		var submit_finance = $(this).val();
		if (status == 1 > 0) {
			alert('Mohon pengecekan ulang. Ada line yang belum di approve/reject');
		}else{
			alert('Invoice akan di submit ke finance');
			$.ajax({
				url: baseurl+'AccountPayables/MonitoringInvoice/InvoiceKasie/submittofinance',
				data: {
					invoice_id : invoice_id,
					submit_finance: submit_finance
				},
				type: 'POST',
				success: function(response){
					// console.log(invoice_id);
					window.location.replace(baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/finishBatch");
				}
			})
		}
	});
	// new edit icheck testing chamber
	
	
	$('#invoice_category').on('change', function(){
		var jasa = $(this).val();
		if (jasa == 'JASA NON EKSPEDISI TRAKTOR' || jasa == 'JASA EKSPEDISI TRAKTOR') {
			$('#jenis_jasa').show();
		}
	})
	
});

var simpanHtml = new Array();
function prosesInvMI(th){
	var row = $(th).closest('tr')
	var td = row.find('.kasihInputInvoice');
	var invoice_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();
	// prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
	simpanHtml[invoice_id]= $('.ganti_'+invoice_id+'').html();
	// console.log(simpanHtml)
	if (proses == 2) {
		prnt.html('<span class="btn btn-success" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnTerima[]" class="hdnProses" value="'+invoice_id+'"></span><a class="btn btn-sm btn-primary" onclick="reloadTerimaInnvoice('+invoice_id+');"><i class="fa fa-refresh"></i></a>');
	} else {
		prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnTolak[]" class="hdnProses" value="'+invoice_id+'"></span><a class="btn btn-sm btn-primary" onclick="reloadTolakInnvoice('+invoice_id+');"><i class="fa fa-refresh"></i></a>');
		td.html('<input type="text" class="reason_finance_class'+invoice_id+'" name="reason_finance[]">')
		// prnt.siblings('td').children('.reason_finance_class'+invoice_id+'').show();
		// prnt.siblings('td').children('.reason_finance_class'+invoice_id+'').attr('required',true);
		alert('Alasan harus diisi');
	}
}

function reloadTerimaInnvoice(th) {
	var id = th;
	$('.ganti_'+id+'').html(simpanHtml[id]);
}
function reloadTolakInnvoice(th) {
	var id = th;
	$('.ganti_'+id+'').html(simpanHtml[id]);
	$('.reason_finance_class'+id+'').remove();
}
function deleteLinePO(th){
	var id = $(th).attr('data-id');
	$.ajax({
		url: baseurl+'AccountPayables/MonitoringInvoice/Invoice/deletePOLine/'+id,
		data: {
			invoice_po_id : id
		},
		type: 'POST',
		success: function(response){
			alert('Po Line di hapus');
			$(th).parent('td').parent('tr').remove();
		}
	});
}
function chkAllAddMonitoringInvoice() {
	if ($('.chkAllAddMonitoringInvoice').is(':checked')) {
		$('.addMonitoringInvoice').each(function () {
			$(this).prop('checked',true);
		});
	}else{
		$('.addMonitoringInvoice').each(function () {
			$(this).prop('checked',false);
		});
	};
}
function bukaMOdal(elm){
	var id = $(elm).attr('inv');
	$.ajax({
		url: baseurl+'AccountPayables/MonitoringInvoice/InvoiceKasie/modal_approve_reject_invoice/'+id,
		data:{
			invoice_id: id
		},
		type: 'POST',
		success: function(response){
			$('.body_invoice').html(response);
			$('.invoice_id').val(id);
			$('#modal-invoice').modal('show');
			$('#invoice_categorySlc').select2();
			$('#jenis_jasaSlc').select2();
		}
	});
}
function PresTab(th)
{
	$(th).parent().parent().next().find('.qty_invoice').focus();
}
function rejectAction(th){
	var invoice_id = $(th).attr('data-id');
}
function submitUlangKasieGudang(th) {
	var batch_number = th.attr('value');
	$.ajax({
		type: "POST",
		url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/submitUlangKasieGudang",
		data:{
			batch_number: batch_number
		},
		success: function(response){
			window.location.href = baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie";
		}
	})
}
function approveInvoice(th) {
	var invoice_id = $('#invoice_id').val();
	var status = th.attr('value');
	var batch_number = th.attr('batch-num');
	var invoice_number = $('#invoice_number').val();
	var invoice_date = $('#invoice_date').val();
	var invoice_amount = $('#invoice_amountt').val();
	var tax_invoice_number = $('#tax_invoice_number').val();
	var invoice_category = $('#invoice_categorySlc').val();
	var jenis_jasa = $('#jenis_jasaSlc').val();
	var nominal_dpp = $('#nominal_dpp').val();
	var info = $('#info').val();
	$.ajax({
		type: "POST",
		url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice",
		data:{
			invoice_id: invoice_id,
			status: status,
			invoice_number: invoice_number,
			invoice_date: invoice_date,
			invoice_amount: invoice_amount,
			tax_invoice_number: tax_invoice_number,
			invoice_category: invoice_category,
			jenis_jasa: jenis_jasa,
			nominal_dpp: nominal_dpp,
			info: info
		},
		success: function(response){
			// console.log(invoice_id,invoice_number,invoice_date,invoice_amount,tax_invoice_number,invoice_category
			// 	,jenis_jasa,nominal_dpp,info,status);
			window.location.href = baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/"+batch_number;
		}
	})
} 
function btnApproveNew(th){		
	var btn = th.parent().parent().closest('tr').find('button.statusInvoice');
	var isChecked = btn.html();
	var invoice_id = th.attr('inv-id');
        if(isChecked == 'Approve'){
          	btn.attr('value','1').removeClass('checked').toggleClass('btn-info').toggleClass('btn-success').html('Submit');
			var status = btn.attr('value');
	        $.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice2",
			data:{
				invoice_id: invoice_id,
				status: status,
				 },
	    	})
        }
        if(isChecked == 'Submit'){
			btn.attr('value','2').addClass('checked').toggleClass('btn-success').toggleClass('btn-info').html('Approve');
			var status = btn.attr('value');
			$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice2",
			data:{
				invoice_id: invoice_id,
				status: status,
				},
	    	})
		}	  
}
function btn_cari(th) {
	var id = th.attr('invoice');
	var win = window.open(baseurl+'Monitoring/TrackingInvoice/DetailInvoice/'+id);
}

$(document).ready(function () {
	$(document).on('click','.btnReceiptMIA', function () {
		var invoice_number = $(this).val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/Receipt",
			data: {invoice_number},
			success: function (resp) {
				if (resp == 1) {
					swal.fire({
						type : 'success',
						title : 'Berhasil!'
					})
				}
			}
		});
	});

	$('#tbListSubmit_filter').prepend('<button id="btnOrclReportMI" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mdlOrclReportMI" style="margin-right: 10px" type="button">Monitoring Receipt PO</button>');

	$(document)
	
	.on('click', '#btnOrclReportMI', function () {
		$('#mdlOrclReportMI').modal('show')
	})

	.on('click', '#btnSubmitReportMI', function () {
		$('#mdlOrclReportMI').modal('hide')
	})

})