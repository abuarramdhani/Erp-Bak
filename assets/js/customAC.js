//--------untuk append di menu new proposal cabang


var num = 2;
function addRowAC(th){ 
	if (num<=15) {
			var html = '<tr class="number'+num+'"><td id="hima'+num+'">'+num+'</td>';
			// kolom 2
			html += '<td><select id="slcNamaAsset" onchange="namaAsset(this)" name="slcNamaAsset[]" class="form-control select2 selectAC" style="width:370px;" required="required">'
            html += '<option value="">PILIH</option>'
            html += '</select></td>'
	        // kolom 4
	        html += '<td><input required="required" type="text" class="form-control txtKodeBarangAC" name="txtKodeBarangAC[]" id="txtKodeBarang"></td>'
	        html += '<td><input required="required" type="text" class="form-control" name="txtSpesifikasiAssetAC[]" id="txtSpesifikasiAssetAC"></td>'
	        html += '<td><input type="text" class="form-control" name="txtJumlahAC[]" id="txtJumlahAC"></td>'
	        html += '<td><input readonly type="text" class="form-control" name="txtUmurTeknisAC[]" id="txtUmurTeknisAC"></td>'
			html += '<td><button type="button" onClick="deleteRowAC('+num+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
			html += "</tr>";
		num++;
	    	$('#tblNewPropCbg').append(html);
			$(".selectAC").select2({
		placeholder: 'Pilih',
		allowClear: true,
		minimumInputLength: 3,
		ajax: {	
		url:baseurl+'AssetCabang/NewProposal/cariNamaAsset',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			// console.log(params)
		var queryParameters = {
			term: params.term,
			code: $('.selectAC').val()
		}
	return queryParameters;
		},
		processResults: function (data) {
	return {
		results: $.map(data, function(obj) {
	return { id:obj.DESCRIPTION, text:obj.DESCRIPTION}; 
					})
				};
			}
		}	
	});
    } else {
    	Swal.fire({
			  type: 'error',
			  title: 'Maksimal Item adalah 15',
			  showConfirmButton: false,
			  timer: 1500
		});
		num = 16;
    }

}

function deleteRowAC(th){
	$('tr.number'+th).remove();
    num -=1;

	var thhima = 0;
	for($i=1;$i<=15;$i++){
		var himatambah$i = th+$i;
		var himaakhir = th+thhima;
		$('#hima'+himatambah$i).text(himaakhir);
		$('#hima'+himatambah$i).attr('id','hima'+himaakhir);
		$('.number'+himatambah$i).attr('class','number'+himaakhir)
		thhima++;
	} 
}

function submitToMarketing(th) {

	var kategori_asset = $('#slcKategoriAst').val();
	var jenis_asset = $('#slcJenisAst').val();
	var perolehan_asset = $('#slcPerolehanAst').val();
	var seksi_pemakai = $('#slcPemakai').val();
	var alasan = $('#txaAlasan').val();
	// var asal_cabang = $('#slcAsalCabang').val();

		var arry = [];
		$('input[name~="txtKodeBarangAC[]"]').each(function(){
		var kodbar = $(this).val();
		arry.push(kodbar);
		});

		var arry2 = [];
		$('select[name~="slcNamaAsset[]"]').each(function(){
		var namset = $(this).val();
		arry2.push(namset);
		});

		console.log(arry2)

		var arry3 = [];
		$('input[name~="txtSpesifikasiAssetAC[]"]').each(function(){
		var spesset = $(this).val();
		arry3.push(spesset);
		});

		var arry4 = [];
		$('input[name~="txtJumlahAC[]"]').each(function(){
		var jumlah = $(this).val();
		arry4.push(jumlah);
		});

		var arry5 = [];
		$('input[name~="txtUmurTeknisAC[]"]').each(function(){
		var umtek = $(this).val();
		arry5.push(umtek);
		});


	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan disubmit!',
		  text: 'Harap cek kembali proposal sebelum disubmit. Proposal yang sudah disubmit tidak dapat diedit!',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, kirim!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabang/NewProposal/submitProposal",
					data:{
						kategori_asset:kategori_asset,
						jenis_asset:jenis_asset,
						perolehan_asset:perolehan_asset,
						seksi_pemakai:seksi_pemakai,
						alasan:alasan,
						// asal_cabang:asal_cabang,
						kode_barang:arry,
						nama_asset:arry2,
						spesifikasi_asset:arry3,
						jumlah:arry4,
						umur_teknis:arry5
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil di submit!',
					  showConfirmButton: false,
					  timer: 1500
					})
					// // window.location.reload();
					window.location.replace(baseurl+"AssetCabang/Draft")			
						}
					})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal dikirim',
      'error'
    )
  }
})
	
}

function getRejected(th) {

	var id_proposal = th;
	var batch_number = $('#judulproposalhdn').val();
	var status = $('#btnReject').val();

			$.ajax({
					type: "POST",
					url: baseurl+"AssetCabangMarketing/ApproveReject/"+id_proposal,
					data:{
						judulProposalNm:batch_number,
						btnApproveAC:status
					},
					success: function(response){

					Swal.fire({
					  // position: 'top-end',
					  type: 'error',
					  title: 'Proposal telah direject!',
					  showConfirmButton: false,
					  timer: 1500
					})
					
					window.location.replace(baseurl+"AssetCabangMarketing/Draft")			
		}
	})

}

function receivedAkuntansi(th) {
	var id_proposal = th
	var batch_number = $('#judulproposalhdnakt').val();
	var status = $('#btnReceiveAkt').val();

const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan diterima!',
		  text: 'Harap cek kembali proposal sebelum diterima. Proposal yang sudah diterima tidak dapat diedit!',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, terima!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {

				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabangAkuntansi/updateAkt",
					data:{
						id_proposal:id_proposal,
						batch_number:batch_number,
						status:status
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil diterima!',
					  showConfirmButton: false,
					  timer: 1500
					})
					
					window.location.replace(baseurl+"AssetCabangAkuntansi/Draft")			
		}
	})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal diterima',
      'error'
    )
  }
})
			
}

function deleteDraft(th) {
	var id_proposal = th

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan dihapus',
		  text: 'Anda yakin ingin menghapus proposal ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, hapus!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {

				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabang/deleteDraft",
					data:{
						id_proposal:id_proposal,
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil dihapus!',
					  showConfirmButton: false,
					  timer: 1500
					})
					
					window.location.reload()			
		}
	})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal dihapus',
      'error'
    )
  }
})
}

 $(document).ready(function(){    
	$(".selectAC").select2({
		placeholder: 'Pilih',
		allowClear: true,
		minimumInputLength: 3,
		ajax: {	
		url:baseurl+'AssetCabang/NewProposal/cariNamaAsset',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			// console.log(params)
		var queryParameters = {
			term: params.term,
			code: $('.selectAC').val()
		}
	return queryParameters;
		},
		processResults: function (data) {
	return {
		results: $.map(data, function(obj) {
	return { id:obj.DESCRIPTION, text:obj.DESCRIPTION}; 
					})
				};
			}
		}	
	});
});

function namaAsset(th) {

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

var row = $(th).closest('tr');
var code_bar = row.find('.selectAC').val();
var kode_barang = row.find('.txtKodeBarangAC');

 	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/NewProposal/cariKodeBarang",
			dataType: 'JSON',
			data:{
					code_bar:code_bar,
				},
			success: function(response) {
			
			var val1 = '';	
		
			$.each(response, (i, item) => {
					val1 = item.SEGMENT1
				})	
				
				kode_barang.val(val1).trigger('change');

			Swal.fire({
					  type: 'success',
					  title: 'Kode Barang ditemukan!',
					  showConfirmButton: false,
					  timer: 1500
					})
				
			}



		});
 }

 function getOptionSetup(th){

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
	
	var id_option = $(th).val();
$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/showOption_"+id_option,
		data:{
			id_option: id_option
		},
		success: function(response){

			Swal.fire({
					  type: 'success',
					  title: 'Setup Tersedia',
					  showConfirmButton: false,
					  timer: 1500
					})
			
			$('#showOptionSetup').html(response);

		}
	})
}

 function getOptionFilter(th){

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
	
	var id_branch = $(th).val();
$.ajax({
		type: "POST",
		url: baseurl+"AssetCabangMarketing/LaporanDataAssetOracle/getFilter",
		data:{
			id_branch: id_branch
		},
		success: function(response){

			Swal.fire({
					  type: 'success',
					  title: 'Setup '+id_branch+' Ditemukan',
					  showConfirmButton: false,
					  timer: 1500
					})
			
			$('#showFilter').html(response);

		}
	})
}

function getOptionFilterAkt(th){

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
	
	var id_branch = $(th).val();
$.ajax({
		type: "POST",
		url: baseurl+"AssetCabangAkuntansi/LaporanDataAssetOracle/getFilter",
		data:{
			id_branch: id_branch
		},
		success: function(response){
  					 Swal.fire({
							  type: 'success',
							  title: 'Setup '+id_branch+' Ditemukan',
							  showConfirmButton: false,
							  timer: 1500
					})
			$('#showFilter').html(response);

		}
	})
}



function saveSetupJA(th) {

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

	var jenis_asset = $('#txtSetupJenisAset').val();

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/saveSetupJA",
		data:{
			jenis_asset: jenis_asset
		},
		success: function(response){

			Swal.fire({
					  type: 'success',
					  title: 'Jenis Asset '+jenis_asset+' ditambahkan',
					  showConfirmButton: false,
					  timer: 1500
					})

			var aaaa = Number($('#tambahJA tr:last td.no').text())+1;
		    var html = 	'<tr class='+aaaa+'><td class="no">'+aaaa+'</td>'
				html +=	'<td>'+jenis_asset+'</td>'
				html += '<td style="display: none"><input type="hidden" id="hdnIDAC" value=" "></td>'
				html +=	'<td><button disabled type="button" onclick="deleteKhususJA('+aaaa+')" class="btn btn-sm btn-danger" style="width:100px;margin-right: 5px"><i class="fa fa-trash"></i> Delete</button><button disabled type="button" class="btn btn-sm btn-primary" style="width:100px"><i class="fa fa-pencil"></i> Edit</button></td>'
				html +=	'</tr>'
			aaaa++;
			$('#tambahJA').append(html);
			$('#txtSetupJenisAset').val('').trigger('change')
		}
	})
}

function deleteJA(th) {

	var row = $(th).closest('tr');
	var id = row.find('#hdnIDAC').val();
	var row2 = $(th).closest('th');
	var coba = row2.parent()

		const swalWithBootstrapButtons = Swal.mixin({
			  customClass: {
			    confirmButton: 'btn btn-success',
			    cancelButton: 'btn btn-danger'
			  },
			  buttonsStyling: true
			})

		swalWithBootstrapButtons.fire({
			  title: 'Item pada Jenis Asset akan dihapus',
			  text: 'Anda yakin ingin menghapus item ini?',
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Ya, hapus!',
			  cancelButtonText: 'Tidak, batalkan!',
			  reverseButtons: true
		}).then((result) => {
	  if (result.value) {


					  	$.ajax({
							type: "POST",
							url: baseurl+"AssetCabang/Setup/deleteJA",
							data:{
								id: id
							},
							success: function(response){
							$('#tambahJA tr.'+id+'').remove()
							Swal.fire({
								  type: 'success',
								  title: 'Item berhasil dihapus',
								  showConfirmButton: false,
								  timer: 1500
								})
						}
					})
			
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Item batal dihapus',
      'error'
    )
  }
})

}

function deleteKhususJA(th) {

	$('#tambahJA tr.'+th).remove()
}

function openModalJA(th) {

	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	var id = th;

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/getDataJA",
		data:{
			id: id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function saveSetupKA(th) {

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

	var cc = $('#txtSetupKategoriAset').val();

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/saveSetupKA",
		data:{
			kategori_asset: cc
		},
		success: function(response){

			Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Kategori Asset '+cc+' ditambahkan',
					  showConfirmButton: false,
					  timer: 1500
					})

			var aaaa = Number($('#tambahKA tr:last td.no').text())+1;
		    var html = 	'<tr class='+aaaa+'><td class="no">'+aaaa+'</td>'
				html +=	'<td>'+cc+'</td>'
				html += '<td style="display: none"><input type="hidden" id="hdnIDKA" value=" "></td>'
				html +=	'<td><button disabled type="button" onclick="deleteKhususKA('+aaaa+')" class="btn btn-sm btn-danger" style="width:100px;margin-right: 5px"><i class="fa fa-trash"></i> Delete</button><button disabled type="button" class="btn btn-sm btn-primary" style="width:100px"><i class="fa fa-pencil"></i> Edit</button></td>'
				html +=	'</tr>'
			aaaa++;
			$('#tambahKA').append(html);
			$('#txtSetupKategoriAset').val('').trigger('change')

		}
	})
}

function deleteKA(th) {

	var row = $(th).closest('tr');
	var id = row.find('#hdnIDKA').val();
	var row2 = $(th).closest('th');
	var coba = row2.parent()

	const swalWithBootstrapButtons = Swal.mixin({
			  customClass: {
			    confirmButton: 'btn btn-success',
			    cancelButton: 'btn btn-danger'
			  },
			  buttonsStyling: true
			})

		swalWithBootstrapButtons.fire({
			  title: 'Item pada Kategori Asset akan dihapus',
			  text: 'Anda yakin ingin menghapus item ini?',
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Ya, hapus!',
			  cancelButtonText: 'Tidak, batalkan!',
			  reverseButtons: true
		}).then((result) => {
	  if (result.value) {


				$.ajax({
					type: "POST",
					url: baseurl+"AssetCabang/Setup/deleteKA",
					data:{
						id: id
					},
					success: function(response){
					$('#tambahKA tr.'+id+'').remove()
					Swal.fire({
								  type: 'success',
								  title: 'Item berhasil dihapus',
								  showConfirmButton: false,
								  timer: 1500
								})
					}
				})
			
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Item batal dihapus',
      'error'
    )
  }
})

}

function deleteKhususKA(th) {

	$('#tambahKA tr.'+th).remove()
}

function openModalKA(th) {

	var id = th;
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/getDataKA",
		data:{
			id:id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function saveSetupPA(th) {

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

	var cc = $('#txtSetupPerolehanAset').val();

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/saveSetupPA",
		data:{
			perolehan_asset: cc
		},
		success: function(response){

			Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Perolehan Asset '+cc+' ditambahkan',
					  showConfirmButton: false,
					  timer: 1500
					})

			var aaaa = Number($('#tambahPA tr:last td.no').text())+1;
		    var html = 	'<tr class='+aaaa+'><td class="no">'+aaaa+'</td>'
		    	html += '<td style="display: none"><input type="hidden" id="hdnIDPA" value=" "></td>'
				html +=	'<td>'+cc+'</td>'
				html +=	'<td><button disabled type="button" class="btn btn-sm btn-danger" onclick="deleteKhususPA('+aaaa+')" style="width:100px;margin-right: 5px"><i class="fa fa-trash"></i> Delete</button><button type="button" disabled class="btn btn-sm btn-primary" style="width:100px"><i class="fa fa-pencil"></i> Edit</button></td>'
				html +=	'</tr>'
			aaaa++;
			$('#tambahPA').append(html);				
			$('#txtSetupPerolehanAset').val('').trigger('change')
		}
	})
}

function deletePA(th) {

	var row = $(th).closest('tr');
	var id = row.find('#hdnIDPA').val();
	var row2 = $(th).closest('th');
	var coba = row2.parent()

		const swalWithBootstrapButtons = Swal.mixin({
			  customClass: {
			    confirmButton: 'btn btn-success',
			    cancelButton: 'btn btn-danger'
			  },
			  buttonsStyling: true
			})

		swalWithBootstrapButtons.fire({
			  title: 'Item pada Perolehan Asset akan dihapus',
			  text: 'Anda yakin ingin menghapus item ini?',
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Ya, hapus!',
			  cancelButtonText: 'Tidak, batalkan!',
			  reverseButtons: true
		}).then((result) => {
	  if (result.value) {


				$.ajax({
						type: "POST",
						url: baseurl+"AssetCabang/Setup/deletePA",
						data:{
							id: id
						},
						success: function(response){
					$('#tambahPA tr.'+id+'').remove()
					Swal.fire({
								  type: 'success',
								  title: 'Item berhasil dihapus',
								  showConfirmButton: false,
								  timer: 1500
								})
						}
					})
			
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Item batal dihapus',
      'error'
    )
  }
})	

}

function deleteKhususPA(th) {

	$('#tambahPA tr.'+th).remove()
}

function openModalPA(th) {

	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	var id = th;

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/getDataPA",
		data:{
			id: id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function saveSetupSP(th) {

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

	var cc = $('#txtSetupSeksiPemakai').val();

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/saveSetupSP",
		data:{
			seksi_pemakai: cc
		},
		success: function(response){

			Swal.fire({
					  type: 'success',
					  title: 'Seksi Pemakai '+cc+' ditambahkan',
					  showConfirmButton: false,
					  timer: 1500
					})

			var aaaa = Number($('#tambahSP tr:last td.no').text())+1;
		    var html = 	'<tr class='+aaaa+'><td class="no">'+aaaa+'</td>'
		   		html += '<td style="display: none"><input type="hidden" id="hdnIDSP" value=" "></td>'
				html +=	'<td>'+cc+'</td>'
				html +=	'<td><button disabled type="button" onclick="deleteKhususSP('+aaaa+')" class="btn btn-sm btn-danger" style="width:100px;margin-right: 5px"><i class="fa fa-trash"></i> Delete</button><button disabled type="button" class="btn btn-sm btn-primary" style="width:100px"><i class="fa fa-pencil"></i> Edit</button></td>'
				html +=	'</tr>'
			aaaa++;
			$('#tambahSP').append(html);
			$('#txtSetupSeksiPemakai').val('').trigger('change')
		}
	})
}

function deleteSP(th) {

	var row = $(th).closest('tr');
	var id = row.find('#hdnIDSP').val();
	var row2 = $(th).closest('th');
	var coba = row2.parent()

	const swalWithBootstrapButtons = Swal.mixin({
			  customClass: {
			    confirmButton: 'btn btn-success',
			    cancelButton: 'btn btn-danger'
			  },
			  buttonsStyling: true
			})

		swalWithBootstrapButtons.fire({
			  title: 'Item pada Seksi Pemakai akan dihapus',
			  text: 'Anda yakin ingin menghapus item ini?',
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Ya, hapus!',
			  cancelButtonText: 'Tidak, batalkan!',
			  reverseButtons: true
		}).then((result) => {
	  if (result.value) {

				$.ajax({
						type: "POST",
						url: baseurl+"AssetCabang/Setup/deleteSP",
						data:{
							id: id
						},
						success: function(response){
						$('#tambahSP tr.'+id+'').remove()
						Swal.fire({
								  type: 'success',
								  title: 'Item berhasil dihapus',
								  showConfirmButton: false,
								  timer: 1500
								})	
					}
				})
			
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Item batal dihapus',
      'error'
    )
  }
})	

}

function deleteKhususSP(th) {

	$('#tambahSP tr.'+th).remove()
}

function openModalSP(th) {

	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	var id = th;

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/Setup/getDataSP",
		data:{
			id: id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function cariNomorInduk(th) {
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


	var nomor_induk = $('#txtNomorIndukAC').val();

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/cariUser",
			dataType: 'JSON',
			data:{
					nomor_induk:nomor_induk,
				},
			success: function(response) {

				if (response !== '0') {
						var employee_code = '';
						var employee_name = '';	
						var section_name = '';
							$.each(response, (i, item) => {
								employee_code = item.employee_code
								employee_name = item.employee_name
								section_name = item.section_name
							})
						$('#txtNamaUserAC').val(employee_name).trigger('change');
						$('#txtSectionName').val(section_name).trigger('change');
						Swal.fire({
									  type: 'success',
									  title: 'User ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
				}else if (response == '0'){
						$('#txtNamaUserAC').val('').trigger('change');
						$('#txtSectionName').val('').trigger('change');
						$('#txtNomorIndukAC').val('').trigger('change');
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

function cariNomorIndukKacab(th) {

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


	var nomor_induk = $('#txtNomorIndukAC').val();

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/cariUserKacab",
			dataType: 'JSON',
			data:{
					nomor_induk:nomor_induk,
				},
			success: function(response) {

				if (response !== '0') {
						var employee_code = '';
						var employee_name = '';	
						var section_name = '';
							$.each(response, (i, item) => {
								employee_code = item.employee_code
								employee_name = item.employee_name
								section_name = item.section_name
							})
						$('#txtNamaUserAC').val(employee_name).trigger('change');
						$('#txtSectionName').val(section_name).trigger('change');
						$('#slcStatusKacab').val('Y').trigger('change');
						Swal.fire({
									  type: 'success',
									  title: 'User ditemukan!',
									  showConfirmButton: false,
									  timer: 1500
									})
				}else if (response == '0'){
						$('#txtNamaUserAC').val('').trigger('change');
						$('#txtSectionName').val('').trigger('change');
						$('#txtNomorIndukAC').val('').trigger('change');
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

function saveSuperUser(th) {

	var nomor_induk = $('#txtNomorIndukAC').val()
	var nama_pekerja = $('#txtNamaUserAC').val()
	var section_name = $('#txtSectionName').val()
	var kode_cabang = $('#slcAsalCabangSU').val()
	
	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/saveUser",
			data:{
					nomor_induk:nomor_induk,
					nama_pekerja:nama_pekerja,
					section_name:section_name,
					kode_cabang:kode_cabang
				},
			success: function(response) {
								Swal.fire({
									  type: 'success',
									  title: 'User ditambahkan!',
									  showConfirmButton: false,
									  timer: 1500
									})
								window.location.reload();
			}
		})
}

function saveKacab(th) {

	var nomor_induk = $('#txtNomorIndukAC').val()
	var nama_pekerja = $('#txtNamaUserAC').val()
	var section_name = $('#txtSectionName').val()
	var kode_cabang = $('#slcAsalCabangSU').val()
	var status = $('#slcStatusKacab').val()

	if (kode_cabang == '') {

		Swal.fire({
		type: 'info',
		title: 'Harap pilih asal cabang!',
		showConfirmButton: false,
		timer: 1000
		})


	}else if (kode_cabang !== '') {
	
	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/saveKacab",
			data:{
					nomor_induk:nomor_induk,
					nama_pekerja:nama_pekerja,
					section_name:section_name,
					kode_cabang:kode_cabang,
					status:status
				},
			success: function(response) {
								Swal.fire({
									  type: 'success',
									  title: 'User ditambahkan!',
									  showConfirmButton: false,
									  timer: 1500
									})
								window.location.reload();
			}
		})
	}
}

function btnEditJA(th) {

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

	var id = th;
	var jenis_asset_baru = $('#txtJenisAssetEdit').val()

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/Setup/updateSetupJA",
			data:{
					id:id,
					jenis_asset_baru:jenis_asset_baru
				},
			success: function(response) {
				$('#mdlJenisAsset').modal('hide');
				$('tr.'+th+' td.ini_ya').text(jenis_asset_baru);
				Swal.fire({
							type: 'success',
							title: 'Item diupdate!',
							showConfirmButton: false,
							timer: 1500
				})
			}
		})

}

function btnEditKA(th) {
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

	var id = th;
	var kategori_asset_baru = $('#txtKategoriAssetEdit').val()

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/Setup/updateSetupKA",
			data:{
					id:id,
					kategori_asset_baru:kategori_asset_baru
				},
			success: function(response) {
				$('#mdlKategoriAsset').modal('hide');
				$('tr.'+th+' td.ini_ya').text(kategori_asset_baru);
				Swal.fire({
							type: 'success',
							title: 'Item diupdate!',
							showConfirmButton: false,
							timer: 1500
				})
			}
		})

}

function btnEditPA(th) {
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

	var id = th;
	var perolehan_asset_baru = $('#txtPerolehanAssetEdit').val()

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/Setup/updateSetupPA",
			data:{
					id:id,
					perolehan_asset_baru:perolehan_asset_baru
				},
			success: function(response) {
				$('#mdlPerolehanAsset').modal('hide');
				$('tr.'+th+' td.ini_ya').text(perolehan_asset_baru);
				Swal.fire({
							type: 'success',
							title: 'Item diupdate!',
							showConfirmButton: false,
							timer: 1500
				})
			}
		})

}

function btnEditSP(th) {
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

	var id = th;
	var seksi_pemakai_baru = $('#txtSeksiPemakaiEdit').val()

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/Setup/updateSetupSP",
			data:{
					id:id,
					seksi_pemakai_baru:seksi_pemakai_baru
				},
			success: function(response) {
				$('#mdlSeksiPemakai').modal('hide');
				$('tr.'+th+' td.ini_ya').text(seksi_pemakai_baru);
				Swal.fire({
							type: 'success',
							title: 'Item diupdate!',
							showConfirmButton: false,
							timer: 1500
				})
			}
		})

}

function deleteSU(th) {
	var id = th;

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/deleteSuperUser",
			data:{
					id:id,
				},
			success: function(response) {
				Swal.fire({
							type: 'success',
							title: 'User berhasil dihapus!',
							showConfirmButton: false,
							timer: 1500
						})
				window.location.reload();
			}
		})

}

function deleteKacab(th) {
	var id = th;

	$.ajax({
			method: "POST",
			url: baseurl+"AssetCabang/SuperUser/deleteKacab",
			data:{
					id:id,
				},
			success: function(response) {
				Swal.fire({
							type: 'success',
							title: 'Kacab berhasil dihapus!',
							showConfirmButton: false,
							timer: 1500
						})
				window.location.reload();
			}
		})

}

function openEditSU(th) {
	var id = th

	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/SuperUser/openModalSU",
		data:{
			id: id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function openEditKacab(th) {
	var id = th

	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/SuperUser/openModalKacab",
		data:{
			id: id
		},
		success: function(response){
			$('.modal-tabel').html("");
			$('.modal-tabel').html(response);
		}
	})
}

function btnEditSU(th) {
	var id = th
	var ganti = $('#slcAsalCabangSUEdit').val()

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/SuperUser/saveEditSU",
		data:{
			id: id,
			ganti:ganti
		},
		success: function(response){
			$('#mdlSuperUser').modal('hide');
			Swal.fire({
							type: 'success',
							title: 'User berhasil diupdate!',
							showConfirmButton: false,
							timer: 1500
						})

			window.location.reload();
		}
	})

}

function btnEditKCB(th) {

	var id = th
	var ganti = $('#slccabangKACAB').val()

	$.ajax({
		type: "POST",
		url: baseurl+"AssetCabang/SuperUser/saveEditKacab",
		data:{
			id: id,
			ganti:ganti
		},
		success: function(response){
			$('#mdlSuperUser').modal('hide');
			Swal.fire({
							type: 'success',
							title: 'User berhasil diupdate!',
							showConfirmButton: false,
							timer: 1500
						})

			window.location.reload();
		}
	})

}

function approveProposalKacab(th) {

	var id = th;
	var kategori_asset = $('#slcKategoriAst').val();
	var jenis_asset = $('#slcJenisAst').val();
	var perolehan_asset = $('#slcPerolehanAst').val();
	var seksi_pemakai = $('#slcPemakai').val();
	var alasan = $('#txaAlasan').val();
	var asal_cabang = $('#slcAsalCabang').val();
	var judul_proposal = $('#judulproposalhdn').val();
	var batch_number = $('#batch_number').val();

		var arry = [];
		$('input[name~="txtKodeBarangAC[]"]').each(function(){
		var kodbar = $(this).val();
		arry.push(kodbar);
		});

		var arry2 = [];
		$('input[name~="slcNamaAsset[]"]').each(function(){
		var namset = $(this).val();
		arry2.push(namset);
		});

		console.log(arry2)

		var arry3 = [];
		$('input[name~="txtSpesifikasiAssetAC[]"]').each(function(){
		var spesset = $(this).val();
		arry3.push(spesset);
		});

		var arry4 = [];
		$('input[name~="txtJumlahAC[]"]').each(function(){
		var jumlah = $(this).val();
		arry4.push(jumlah);
		});

		var arry5 = [];
		$('input[name~="txtUmurTeknisAC[]"]').each(function(){
		var umtek = $(this).val();
		arry5.push(umtek);
		});

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan diapprove!',
		  text: 'Harap cek kembali proposal sebelum diapprove. Proposal yang sudah diapprove tidak dapat diedit!',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, kirim!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabangKacab/Draft/submitProposal",
					data:{
						id:id,
						batch_number:batch_number,
						judul_proposal:judul_proposal,
						kategori_asset:kategori_asset,
						jenis_asset:jenis_asset,
						perolehan_asset:perolehan_asset,
						seksi_pemakai:seksi_pemakai,
						alasan:alasan,
						asal_cabang:asal_cabang,
						kode_barang:arry,
						nama_asset:arry2,
						spesifikasi_asset:arry3,
						jumlah:arry4,
						umur_teknis:arry5
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil diapprove!',
					  showConfirmButton: false,
					  timer: 1500
					})
					// // window.location.reload();
					window.location.replace(baseurl+"AssetCabangKacab/Draft")			
						}
					})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal diapprove',
      'error'
    )
  }
})
}



function open_modal_upload(th) {
	var proposal_id = th;

	$('h5.modal-title').html('UPLOAD BERKAS UNTUK DILAMPIRKAN DI PROPOSAL')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "post",
			url: baseurl+"AssetCabang/NewProposal/open_modal_upload",
			data:{
				proposal_id:proposal_id
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				// $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" onclick="saveKonfirmasiBuyer('+th+')" id="btnForward"><i class="fa fa-check"></i> Save</button>');
			}
		})
}

$('#button-submit-berkas-draft').click(function(){
		Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Berkas berhasil diupload!',
					  showConfirmButton: true,
					})
	})


function submitToMarketingEdit(th) {

	var id_proposal = th;
	var batch_number = $('#batch_number').val()
	var kategori_asset = $('#slcKategoriAst').val();
	var jenis_asset = $('#slcJenisAst').val();
	var perolehan_asset = $('#slcPerolehanAst').val();
	var seksi_pemakai = $('#slcPemakai').val();
	var alasan = $('#txaAlasan').val();
	// var asal_cabang = $('#slcAsalCabang').val();

		var arry = [];
		$('input[name~="txtKodeBarangAC[]"]').each(function(){
		var kodbar = $(this).val();
		arry.push(kodbar);
		});

		var arry2 = [];
		$('select[name~="slcNamaAsset[]"]').each(function(){
		var namset = $(this).val();
		arry2.push(namset);
		});

		console.log(arry2)

		var arry3 = [];
		$('input[name~="txtSpesifikasiAssetAC[]"]').each(function(){
		var spesset = $(this).val();
		arry3.push(spesset);
		});

		var arry4 = [];
		$('input[name~="txtJumlahAC[]"]').each(function(){
		var jumlah = $(this).val();
		arry4.push(jumlah);
		});

		var arry5 = [];
		$('input[name~="txtUmurTeknisAC[]"]').each(function(){
		var umtek = $(this).val();
		arry5.push(umtek);
		});


	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan disubmit!',
		  text: 'Harap cek kembali proposal sebelum disubmit. Proposal yang sudah disubmit tidak dapat diedit!',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, kirim!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabang/CheckedbyKacab/submitEditProposal",
					data:{
						kategori_asset:kategori_asset,
						jenis_asset:jenis_asset,
						perolehan_asset:perolehan_asset,
						seksi_pemakai:seksi_pemakai,
						alasan:alasan,
						id_proposal:id_proposal,
						batch_number:batch_number,
						kode_barang:arry,
						nama_asset:arry2,
						spesifikasi_asset:arry3,
						jumlah:arry4,
						umur_teknis:arry5
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil di re-forward!',
					  showConfirmButton: false,
					  timer: 1500
					})
					// // window.location.reload();
					window.location.replace(baseurl+"AssetCabang/Draft")			
						}
					})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal dikirim',
      'error'
    )
  }
})
	
}

function openModalRejectedAC(th) {
	var proposal_id = th;

	$('h5.modal-title').html('MASUKKAN ALASAN REJECT')
	$('.modal-body').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"AssetCabangKacab/Draft/OpenMdlReject",
			data:{
				proposal_id:proposal_id,
			},
			success: function(response){
				$('.modal-body').html("");
				$('.modal-body').html(response);
				$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onclick="rejectProposalKacab('+th+')" id="btnForward"><i class="fa fa-paper-plane"></i> Send</button>');
			}
		})	
}

function rejectProposalKacab(th) {

	var id = th;
	var status = $('#status').val();
	var batch_number = $('#batch_number').val();
	var feedback = $('#textFeedbackAC').val();
	
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Proposal akan direject!',
		  text: 'Harap cek kembali proposal sebelum direject. Proposal yang sudah direject tidak dapat ditarik kembali!',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Ya, kirim!',
		  cancelButtonText: 'Tidak, batalkan!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
				  	$.ajax({
					type: "POST",
					url: baseurl+"AssetCabangKacab/Draft/rejectProposal",
					data:{
						id:id,
						batch_number:batch_number,
						status:status,
						feedback:feedback
					},
					success: function(response){
					Swal.fire({
					  // position: 'top-end',
					  type: 'success',
					  title: 'Proposal berhasil direject!',
					  showConfirmButton: false,
					  timer: 1500
					})
					// // window.location.reload();
					window.location.replace(baseurl+"AssetCabangKacab/Draft")			
						}
					})
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Batal',
      'Proposal batal direject',
      'error'
    )
  }
})
}