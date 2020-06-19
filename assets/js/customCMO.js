$(document).ready(function(){
	$('#CMOtblJpkj').DataTable();

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
				$('.mco_isiData').eq(1).text('Lokasi : '+obj[0]['lokasi_kerja']);

				$('.mco_inputData').eq(0).val(obj[0]['kodesie']);
				$('.mco_inputData').eq(1).val(obj[0]['id_']);
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

	$('.cmo_slcJnsPkj').change(function(){
		$.ajax({
			url : baseurl+"civil-maintenance-order/setting/getket_jenis_order",
			type : 'GET',
			data : {
				id:$(this).val()
			},
			success : function(data) {
				let res = jQuery.parseJSON(data);
				// console.log(res);
				$('.setjnsPkjhere').text(res.keterangan);
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
		let c = $('.mco_daftarPek').eq(0).clone();
		$('.mco_daftarPek_Append').append(c);
		$('.mco_daftarPek:last').find('input, textarea').val('');
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