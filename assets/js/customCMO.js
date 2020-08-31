$(document).ready(function(){
	$('#CMOtblJpkj').DataTable();
	$('#CMOtblJpkjDetail').DataTable();

	$('.textareaMCO').redactor({
		imageUpload: baseurl + 'civil-maintenance-order/order/upload_imageChat',
		imageUploadErrorCallback: function(json) {
			alert(json.error);
		}
	});

	$('#CMO_tblJnsOrder').on('click', '.cmo_setApprove', function(){
		var val = $(this).attr('data-id');
		Swal.fire({
		title: 'Anda yakin ingin melakukan Approve ?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#55b055',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url : baseurl+"civil-maintenance-order/order/setApproveOrder",
					type : 'POST',
					data: {
						id: val,
						status: 1
					},
					success : function(data) {
						mcc_showAlert('success', 'Berhasil Mengupdate Data');
						window.location.reload();
					},
					error : function(request,error)
					{
						alert("Request: "+JSON.stringify(request));
					}
				});
			}
		});		
	});

	$('#CMO_tblJnsOrder').on('click', '.cmo_setReject', function(){
		var val = $(this).attr('data-id');
		Swal.fire({
		title: 'Anda yakin ingin melakukan Reject ?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url : baseurl+"civil-maintenance-order/order/setApproveOrder",
					type : 'POST',
					data: {
						id: val,
						status: 2
					},
					success : function(data) {
						mcc_showAlert('success', 'Berhasil Mengupdate Data');
						window.location.reload();
					},
					error : function(request,error)
					{
						alert("Request: "+JSON.stringify(request));
					}
				});
			}
		});
	});

	$('#cmo_tbllistorder').DataTable({
		dom: 'Bfrtip',
		"scrollX": true,
		fixedColumns:   {
			leftColumns: 3,
			rightColumns:1
		},
		buttons: [
		{
			extend: 'excel',
			title: ''
		}
		]
	});

	$('#mco_changestatus').change(function(){
		$.ajax({
			url : baseurl+"civil-maintenance-order/order/up_kolomOrder",
			type : 'POST',
			data: {
				id: $(this).attr('data-id'),
				kolom: $(this).attr('data-kolom'),
				val: $(this).val()
			},
			success : function(data) {
				mcc_showAlert('success', 'Berhasil Mengupdate Data');
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('#cmo_addJnsOrder').click(function(){
		var frm = $('#frm_addJnsOrder').serialize();
		$.ajax({
			url : baseurl+"civil-maintenance-order/setting/add_jenis_order",
			type : 'POST',
			data: frm,
			success : function(data) {
				if (data || data == ''){
					$('#cmojenisorder').modal('hide')
					$('input[name="jenisOrder"]').val('');
					mcc_showAlert('success', 'Berhasil Menambah Data');
					loadTableCMOjnsOrder();
				}else{
					alert('Gagal!!');
				}
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('#cmoupJnsOrder').click(function(){
		$.ajax({
			url : baseurl+"civil-maintenance-order/setting/up_jnsOrder",
			type : 'POST',
			data: $('#frm_upJnsOrder').serialize(),
			success : function(data) {
				$('#cmoupjenisorder').modal('hide');
				loadTableCMOjnsOrder();
				mcc_showAlert('success', 'Berhasil Mengupdate Data');
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('.cmo_slcPkj[change="1"]').change(function(){
		var val = $(this).val();
		if (val == null || val == '') return false;
		$.ajax({
			url : baseurl+"civil-maintenance-order/order/get_detailpkj",
			type : 'get',
			data: {term: val},
			success : function(data) {
				let obj = jQuery.parseJSON(data);
				$('.mco_isiData').eq(0).text('Seksi : '+obj[0]['seksi']);

				$('.mco_inputData').eq(0).val(obj[0]['kodesie']);
				$('.mco_lokasi').val(obj[0]['id_']).change();
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('.mco_tglpick').daterangepicker({
		"singleDatePicker": true,
		"timePicker": false,
		"timePicker24Hour": true,
		"showDropdowns": false,
		locale: {
			format: 'YYYY-MM-DD'
		},
	});

	$('.cmo_slcJnsPkj').select2({
		searching: false,
		placeholder: "Jenis Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + 'civil-maintenance-order/order/getJnsPkj',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj) {
						return { id: obj.jenis_pekerjaan_id, text: obj.jenis_pekerjaan };
					})
				}
			}
		}
	});

	$('.cmo_slcJnsPkjDetail').select2({
		searching: false,
		placeholder: "Detail Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + 'civil-maintenance-order/order/getJnsPkjDetail',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params) {
				return {
					id: $('.cmo_slcJnsPkj').val(),
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj) {
						return { id: obj.jenis_pekerjaan_detail_id, text: obj.detail_pekerjaan };
					})
				}
			}
		}
	});

	$('.cmo_slcJnsPkj').change(function(){
		var jenisPekerjaan = $(this).find(':selected').text();
		if ( jenisPekerjaan == 'Buat Baru') {
			$('.cmo_slcJnsPkjDetail').closest('.col-md-12').hide();
		}else{
			$('.cmo_slcJnsPkjDetail').closest('.col-md-12').show();
			$.ajax({
				url : baseurl+"civil-maintenance-order/setting/getket_jenis_order",
				type : 'GET',
				data : {
					id:$(this).val()
				},
				success : function(data) {
					let res = jQuery.parseJSON(data);
					$('.cmo_slcJnsPkjDetail').attr('disabled', false);
					// console.log(res);
					$('.setjnsPkjhere').text(res.keterangan);
				},
				error : function(request,error)
				{
					alert("Request: "+JSON.stringify(request));
				}
			});
		}
	});

	$('.cmo_slcJnsPkjDetail').change(function(){
		$.ajax({
			url : baseurl+"civil-maintenance-order/setting/getket_jenis_pekerjaan_detail",
			type : 'GET',
			data : {
				id:$(this).val()
			},
			success : function(data) {
				let res = jQuery.parseJSON(data);
				// console.log(res);
				$('.setjnsPkjhereDetail').text(res.keterangan);
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('.cmo_slcJnsOrder').select2({
		searching: false,
		placeholder: "Jenis Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + 'civil-maintenance-order/order/getJnsOrder',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj) {
						return { id: obj.jenis_order_id, text: obj.jenis_order };
					})
				}
			}
		}
	});

	$('.cmo_slcJnsOrder').change(function(){
		var val = $(this).val();
		if (val == '1') {
			$('.cmo_pengorderCivil').show();
			$('.cmo_pengorderCivil select').attr('required', true);
		}else{
			$('.cmo_pengorderCivil').hide();
			$('.cmo_pengorderCivil select').attr('required', false);
			$('.cmo_pengorderCivil input').val('');
			$('.cmo_pengorderCivil select').val(null).trigger('change');
			$('.mco_isiData').eq(0).text('Seksi : xxxxxxxxxx');
			$('.mco_isiData').eq(1).text('Lokasi : xxxxxxxxx');
		}
	});

	$('.mco_status').on('change', function(){
		var tanggal = $('input[name=tglorder]').val();
		var butuh = new Date(tanggal);

		if ($(this).val() == 'Biasa') {
			butuh.setDate(butuh.getDate()+3);
			var tahun = butuh.getUTCFullYear();
			var bulan = butuh.getMonth() + 1;
			if (bulan < 10) {
				bulan = "0" + bulan;
			}
			var hari = butuh.getDate();
			if (hari < 10) {
				hari = "0" + hari;
			}
			var tglButuh = tahun + '-' + bulan + '-' + hari;
			$('[name=tglbutuh]').val(tglButuh);
			$('.mco_tglbutuh').show();
			$('.mco_alasan').hide();
		}else if($(this).val() == 'Urgent'){
			butuh.setDate(butuh.getDate()+1);
			var tahun = butuh.getUTCFullYear();
			var bulan = butuh.getMonth() + 1;
			if (bulan < 10) {
				bulan = "0" + bulan;
			}
			var hari = butuh.getDate();
			if (hari < 10) {
				hari = "0" + hari;
			}
			var tglButuh = tahun + '-' + bulan + '-' + hari;
			$('[name=tglbutuh]').val(tglButuh);
			$('.mco_tglbutuh').show();
			$('.mco_alasan').show();
		}else{
			$('.mco_tglbutuh').val(tanggal);
			$('.mco_tglbutuh').hide();
			$('.mco_alasan').hide();
		}
	});

	$('.mco_delfile').on('click', function(){
		var txt = $(this).attr('nama');
		var id = $(this).val();
		var ini = $(this);
		Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus File "'+txt+'"',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				let s = mco_delFile(id);
				if(s){
					ini.closest('div.mco_insertafter').remove();
					reIndexLampiran();
				}
			}
		});
	});

	$('.cmo_ifchange').on('change', 'input, select, textarea', function(){
		$('#cmo_btnSaveUp').attr('disabled', false);
	});

	$('.cmo_delOrder').click(function(){
		var val = $(this).attr('hapus');
		Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus Order ini.',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				window.location.href = baseurl+'civil-maintenance-order/order/del_order/'+val;
			}
		});
	});

	$('.mco_addRowPek').click(function(){
		var nomor = $('.mco_daftarPek:last').find('.tbl_pekerjaan').attr('nomor');
		nomor = parseInt(nomor) + 1;
		console.log(nomor);
		let c = $('.mco_daftarPek').eq(0).clone();
		$('.mco_daftarPek_Append').append(c);
		$('.mco_daftarPek:last').find('input, textarea').val('');
		$('.mco_daftarPek:last').find('.td_lampiran div button').remove();
		$('.mco_daftarPek:last').find('.td_lampiran div br').remove();
		$('.mco_daftarPek:last').find('.td_lampiran div label').remove();
		$('.mco_daftarPek:last').find('.td_lampiran input').not(':eq(0)').remove();
		$('.mco_daftarPek:last').find('.td_lampiran input').val('');
		$('.mco_daftarPek:last').find('button.add_lamp').attr('nomor',1);
		$('.mco_daftarPek:last').find('button.add_lamp').text('Choose File 1');
		
		$('.mco_daftarPek:last').find('.tbl_pekerjaan').attr('name','tbl_pekerjaan[' + nomor + ']')
		$('.mco_daftarPek:last').find('.tbl_pekerjaan').attr('nomor',nomor)
		$('.mco_daftarPek:last').find('.tbl_qty').attr('name','tbl_qty[' + nomor + ']')
		$('.mco_daftarPek:last').find('.tbl_satuan').attr('name','tbl_satuan[' + nomor + ']')
		$('.mco_daftarPek:last').find('.tbl_lampiran').attr('name','tbl_lampiran[' + nomor + '][]')
		$('.mco_daftarPek:last').find('.tbl_ket').attr('name','tbl_ket[' + nomor + ']')
		reIndexTblInput('#mco_tblPekerjaan');
	});
	$('.mco_addRowApp').click(function(){
		$(this).closest('div').find('.mco_slc').select2('destroy');
		$(this).closest('div').find('.cmo_slcPkj').select2('destroy');
		let c = $('.mco_daftarApp').last().clone();
		$('.mco_daftarApp_Append').append(c);
		$('.mco_daftarApp:last').find('input, textarea').val('');
		reIndexTblInput('#mco_tbl_approver');
		$(this).closest('div').find('.mco_slc').select2({
			placeholder: 'Pilih Salah Satu'
		});
		initSlcPkj();
		$(this).closest('div').find('.cmo_slcPkj').last().val('').trigger('change');
	});

	$('.mco_slc').select2({
		placeholder: 'Pilih Salah Satu'
	});
	initSlcPkj();

	$(document).on('change', '.mco_lampiranFilePekerjaan', function(){
		var nomor = $(this).closest('td').find('button.add_lamp').attr('nomor');
		var button = '<button nomor="' + nomor + '" class="btn btn-danger btn-xs del_lamp" type="button" style="float: right"><span class="fa fa-trash"></span></button>';
		var anchor = '<button nomor="' + nomor + '" class="btn btn-success btn-xs view_lamp" type="button" style="float: right"><span class="fa fa-eye"></span></button>';
		var label = '<label nomor="' + nomor + '" style="width: 70%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;float: left;"><i>' + nomor + '. ' + $(this).val().substring(12) + ' </i></label>';
		$(this).closest('div').append(label + button + anchor + "<br nomor='" + nomor + "'>");
		var posisi = $(this).closest('div');
		var nomorAsli = nomor;
		if (this.files && this.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e){
				var link = e.target.result;
				posisi.find('.view_lamp[nomor=' + nomorAsli + ']').attr('data-isi',link);
			}

			reader.readAsDataURL(this.files[0]);
		}

		nomor = parseInt(nomor) + 1;
		$(this).clone().val('').attr('nomor',nomor).appendTo($(this).closest('div'));
		$(this).closest('td').find('button.add_lamp').attr('nomor',nomor);
		$(this).closest('td').find('button.add_lamp').text('Choose File ' + nomor);
	})

	$(document).on('click', '.td_lampiran button.add_lamp', function(){
		$(this).closest('td').find('input').last().trigger('click');
	})

	$(document).on('click', '.td_lampiran button.del_lamp', function(){
		var nomor = $(this).attr('nomor');
		var nomorMax = $(this).closest('td').find('button.add_lamp').attr('nomor');
		$(this).closest('div').find('[nomor=' + nomor + ']').attr('nomor',999);

		for (var i = (nomor * 1) + 1; i < nomorMax; i++) {
			var nomorBaru = i - 1;
			var text = $(this).closest('div').find('label[nomor=' + i + '] i').text().substring(1);
			$(this).closest('td').find('label[nomor=' + i + '] i').html(nomorBaru + text);
			$(this).closest('div').find('[nomor=' + i + ']').attr('nomor',nomorBaru);
		}

		$(this).closest('div').find('[nomor=' + nomorMax + ']').attr('nomor',nomorMax - 1);
		$(this).closest('td').find('button.add_lamp').attr('nomor',nomorMax - 1);
		$(this).closest('td').find('button.add_lamp').text('Choose File ' +( nomorMax - 1));

		$(this).closest('div').find('[nomor=' + 999 + ']').remove();
	})

	$(document).on('click', '.td_lampiran button.view_lamp', function(){
		$('iframe').attr('src',$(this).attr('data-isi'));
		$('#inputOrder').modal('show');
	})
});
$(document).on('click', '.mco_deldaftarnoPek', function(){
	if ($('.mco_deldaftarnoPek').length > 1) {
		$(this).closest('tr').remove();
		reIndexTblInput('#mco_tblPekerjaan');
	}
});
$(document).on('click', '.mco_deldaftarnoApp', function(){
	if ($('.mco_deldaftarnoApp').length > 1) {
		$(this).closest('tr').remove();
		reIndexTblInput('#mco_tbl_approver');
	}
});

function cetakOrderCM(id){
	swal.fire({
	    title: 'Apakah Anda Ingin Mencetak Order ?',
	    text: "Anda Akan diarahkan ke halaman PDF",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    confirmButtonText: 'Ya',
	    cancelButtonText: 'Tidak'
	}).then((result) => {
	    if (!result.value) {
	        Swal.fire(
	            'Cetak Telah Dibatalkan',
	            'Cetak Dibatalkan',
	            'error'
	        )
	    }else{
	        window.open( baseurl + 'civil-maintenance-order/order/cetak_order/'+id,'_blank');
	    }
	})
}
function reIndexTblInput(selector)
{
	var x = 1;
	$(selector).find('.mco_daftarnoPek').each(function(){
		$(this).text(x);
		x++;
	});
}

$(document).on('change', '.mco_lampiranFile:last', function(){
	var div = $(this).closest('div.col-md-12').clone();
	div.insertAfter($('.mco_insertafter:last')).find('input').val('');
	reIndexLampiran();
});
function mco_delFile(id)
{
	let ayax = $.ajax({
		url : baseurl+"civil-maintenance-order/order/del_file",
		type : 'post',
		data: {id: id},
		success : function(data) {
			mcc_showAlert('success', 'Berhasil Menghapus File');
			return 1;
		},
		error : function(request,error)
		{
			alert("Request: "+JSON.stringify(request));
			return false;
		}
	});

	return ayax;
}

function reIndexLampiran()
{
	var x = 1;
	$('.mco_lampiranno').each(function(){
		$(this).text('Lampiran '+x);
		x++;
	});
}


function loadTableCMOjnsOrder() {
	$.ajax({
		url : baseurl+"civil-maintenance-order/setting/getlist_jenis_order",
		type : 'GET',
		success : function(data) { 
			$('#CMO_tblJnsOrder').html(data);
			$('#CMOtblJorder').DataTable();
		},
		error : function(request,error)
		{
			alert("Request: "+JSON.stringify(request));
		}
	});
}


$(document).on('click', '.cmo_delJnsOrder', function(){
	var txt = $(this).attr('nama');
	var val = $(this).val();
	Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus Jenis Order "'+txt+'"',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			deleteDataSetting(val);
		}
	});
});

$(document).on('click', '.cmo_delJnsPkj', function(){
	var txt = $(this).attr('nama');
	var val = $(this).val();
	Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus Jenis Pekerjaan "'+txt+'"',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			window.location = baseurl+"civil-maintenance-order/setting/del_jnsPkj?id="+val;
		}
	});
});
$(document).on('click', '.cmo_delsto', function(){
	var txt = $(this).attr('nama');
	var val = $(this).val();
	Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus Status Order "'+txt+'"',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			window.location = baseurl+"civil-maintenance-order/setting/del_sto?id="+val;
		}
	});
});

$(document).on('click', '.cmo_upJnsOrder', function(){
	var txt = $(this).attr('nama');
	var val = $(this).val();
	var ket = $(this).closest('tr').find('td.mco_jpKet').text();
	$('input[name="idJnsOrder"]').val(val);
	$('input[name="upKet"]').val(ket);
	$('input[name="upjenisOrder"]').val(txt);
});

$(document).on('click', '.cmo_upJnsOrderDetail', function(){
	var pekerjaanId = $(this).attr('pekerjaan-id');
	var detailId = $(this).attr('detail-id');
	var detail = $(this).attr('detail');
	var ket = $(this).closest('tr').find('td.mco_jpKet').text();
	console.log(pekerjaanId + "----" + detailId + "-----" + detail + "-----" + ket)
	$('select[name="upjenisPekerjaan"]').val(pekerjaanId).change();
	$('input[name="upKet"]').val(ket);
	$('input[name="upjenisOrderDetail"]').val(detail);
	$('input[name="idJnsPekerjaanDetail"]').val(detailId);
});

function deleteDataSetting(id , url = "civil-maintenance-order/setting/del_jnsOrder")
{
	$.ajax({
		url : baseurl+url,
		type : 'POST',
		data: {id: id},
		success : function(data) { 
			loadTableCMOjnsOrder();
			mcc_showAlert('success', 'Berhasil Menghapus Data');
		},
		error : function(request,error)
		{
			alert("Request: "+JSON.stringify(request));
		}
	});
}

function initSlcPkj()
{
	$('.cmo_slcPkj').select2({
		searching: true,
		minimumInputLength: 3,
		placeholder: "No. Induk / Nama Pekerja",
		allowClear: false,
		ajax: {
			url: baseurl + 'MasterPekerja/Poliklinik/getPekerja',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj) {
						return { id: obj.noind, text: obj.noind + " - " + obj.nama };
					})
				}
			}
		}
	});
}

function mco_initEditApproval(id)
{
	setUrlBack('.mco_getBack');
	$('.mco_tbl_approver select').change(function(){
		$.ajax({
			url : baseurl+"civil-maintenance-order/order/up_kolomApprover",
			type : 'POST',
			data: {
				id: $(this).attr('data-id'),
				kolom: $(this).attr('kolom'),
				val: $(this).val()
			},
			success : function(data) {
				mcc_showAlert('success', 'Berhasil Mengupdate Data');
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});

	$('.mco_delApprover').click(function(){
		var txt = $(this).closest('tr').find('.cmo_slcPkj option:selected').text();
		var ini = $(this);
		Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus Approver '+txt+'?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url : baseurl+"civil-maintenance-order/order/del_kolomApprover",
					type : 'POST',
					data: {
						id: ini.val()
					},
					success : function(data) {
						mcc_showAlert('success', 'Berhasil Menghapus Data');
						ini.closest('tr').remove();
						reIndexTblInput('.mco_tbl_approver');
					},
					error : function(request,error)
					{
						alert("Request: "+JSON.stringify(request));
					}
				});
			}
		});
	});

	$('.cmo_slcPkj').change(function(){
		var val = $(this).val();
		var ini = $(this);
		$.ajax({
			url : baseurl+"civil-maintenance-order/order/get_detailpkj",
			type : 'get',
			data: {term: val},
			success : function(data) {
				let obj = jQuery.parseJSON(data);
				// ini.closest('tr').find('input').remove();
				ini.closest('tr').find('input.cmoisiJabatan').val(obj[0]['jabatan']);
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
	});
}

function mco_initEditKeterangan()
{
	setUrlBack('.mco_getBack');
	$('.mco_tblPekerjaan input, .mco_tblPekerjaan textarea').change(function(){
		var dataId = $(this).attr('data-id');
		if (dataId) {
			$.ajax({
				url : baseurl+"civil-maintenance-order/order/up_kolomKeterangan",
				type : 'POST',
				data: {
					id: $(this).attr('data-id'),
					kolom: $(this).attr('kolom'),
					val: $(this).val()
				},
				success : function(data) {
					mcc_showAlert('success', 'Berhasil Mengupdate Data');
				},
				error : function(request,error)
				{
					alert("Request: "+JSON.stringify(request));
				}
			});
		}else{
			// lampiran
		}
	});

	$('.mco_delKeterangan').click(function(){
		var txt = $(this).closest('tr').find('.mco_editKeteranggan').val();
		var ini = $(this);
		Swal.fire({
		title: 'Anda yakin ?',
		text: 'Anda akan menghapus "'+txt+'"?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff3333',
		confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url : baseurl+"civil-maintenance-order/order/del_kolomKeterangan",
					type : 'POST',
					data: {
						id: ini.val()
					},
					success : function(data) {
						mcc_showAlert('success', 'Berhasil Menghapus Data');
						ini.closest('tr').remove();
						reIndexTblInput('.mco_tblPekerjaan');
					},
					error : function(request,error)
					{
						alert("Request: "+JSON.stringify(request));
					}
				});
			}
		});
	});

	$('.mco_delFile_editKet').on('click', function(){
		att_id = $(this).attr('data-attachment-id');
		$.ajax({
			url: baseurl + 'civil-maintenance-order/order/del_file',
			type: 'POST',
			data: {id: att_id},
			success : function(data) {
				$('a[data-attachment-id='+att_id+']').remove();
				$('label[data-attachment-id='+att_id+']').remove();
			},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		})
		// link 
	})

	$('.mco_lampiranFilePekerjaanEdit').on('change', function(){
		$(this).closest('tr').find('.btnsubmit').click();
	})
}

function setUrlBack(selektor)
{
	let back = document.referrer;
	if (back.length > 2) {
		$(selektor).attr('href', back);
	}else{
		$(selektor).attr('href', baseurl+'civil-maintenance-order');
	}
}