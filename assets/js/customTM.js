// FORMAT TANGGAL FOR EXPORT EXCELL
var thisday = new Date();
var hari = thisday.getDate();
var bulan = thisday.getMonth() + 1; //January is 0
var tahun = thisday.getFullYear();

if (hari < 10) {
	hari = '0' + hari;
}
if (bulan < 10) {
	bulan = '0' + bulan;
}
var thisday = hari + '-' + bulan + '-' + tahun;

//TABEL RIWAYAT REPARASI//
$('#tblReparasi').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//TABEL SPAREPART//
$('#tblSparepart').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//TABEL KETERLAMBATAN//
$('#tblKeterlambatan').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//TABEL ORDER LIST SEKSI//
$('#tblOrderList').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//TABEL ORDER LIST AGENT//
$('#tblOrderListAgent').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//TABEL MONITORING AWAL//
$('.tblMonitoringOrder').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false,
});

// TABEL ORDER LIST OPEN (NEW)
$('.tblOrderListOpenSeksi').DataTable({
  info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Open_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3],
      }
    }
   ],
});

//TABEL MONITORING ORDER ACC
$('.tblOrderListACC').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListACCSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_ACC_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER REVIEWED
$('.tblOrderListReviewed').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListReviewedSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Reviewed_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER ACTION
$('.tblOrderListAction').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListActionSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Action_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER OVERDUE
$('.tblOrderListOverdue').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListOverdueSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Overdue_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER DONE
$('.tblOrderListDone').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListDoneSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Done_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER CLOSE
$('.tblOrderListClose').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListCloseSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Close_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4],
      }
    }
   ],
});

//TABEL MONITORING ORDER REJECTED
$('.tblOrderListRejected').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});
$('.tblOrderListRejectedSeksi').DataTable({
	// "lengthMenu" : [10],
	// "ordering": false,
	// "lengthChange": false
	info:true,
  ordering:false,
  buttons: true,
  dom: 'frtpBi',
  buttons: [
    {
      extend: 'excelHtml5',
      title: 'Order_Reject_' + thisday,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3, 4, 5],
      }
    }
   ],
});

//TABEL KODE SEKSI
$('.tblKodeSeksi').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

//APPEND INPUT FORM LANGKAH PERBAIKAN
var nomor ="2";
function addLangkahPerbaikan() {
    // var div = $('.tbodyLangkahPerbaikan');
	// var html = '';
	//KOLOM 1
	var html = '<tr class="nomor_'+nomor+'"><td class="text-center langkahTabel">'+nomor+'</td>';
	console.log(nomor);
	// KOLOM 2
	html += '<td class="text-center"><input type="text" style="width:420px" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required></td>'
	// KOLOM 3
	html += '<td class="text-center"><a class="btn btn-primary btn-md"><i class="fa fa-plus fa-md" title="Tambah Langkah Perbaikan" onclick="addLangkahPerbaikan(this)"></i></a><a class="btn btn-danger btn-md" title="Hapus Langkah Perbaikan" onclick="onClickDeleteLpB(this)"><span class="fa fa-times fa-md"></span></a></td>';
	html += "</tr>";
    // html += '<div class="col-lg-2"><input type="text" style="text-align:center; margin-left=0%;" name="txtUrutan[]" class="form-control urutan" value="'+nomor+'" readonly></div><div class="col-lg-10"><input type="text" style="width:490px" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required></div><br/>';
    nomor++

    $('.tbodyLangkahPerbaikan').append(html);
}

{/* <td class="text-center langkahTabel"> ${nomor} </td>  */}

//APPEND TABEL LANGKAH PERBAIKAN
function addRowTabelPerbaikan(){
	// alert(nomor)
	var html = $(`
	<tr class = "nomor_${nomor}">
		<td class="text-center langkahTabel">${nomor}</td>
		<td>
			<input type="text" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required>
		</td>
		<td class="text-center">
			<a class="btn btn-primary btn-md"><i class="fa fa-plus fa-md" title="Tambah Langkah Perbaikan" onclick="addRowTabelPerbaikan(this)"></i></a>
			<a class="btn btn-danger btn-md" title="Hapus Langkah Perbaikan" onclick="onClickDeleteLpB(this)"><span class="fa fa-times fa-md"></span></a>
		</td>
	</tr>
	`);

	nomor++;
	console.log(html)
	$('#tbodyLangkahPerbaikan').append(html);

	$('.langkahTabel').each((i, item) => {
		document.getElementsByClassName('langkahTabel')[i].innerHTML = i + 1
	})
}

//DELETE LANGKAH PERBAIKAN
const onClickDeleteLpB = (th) => {
	var row_index = $(th).parent().parent('tr').index();
	// alert(row_index)
	// var id = $('table tbody tr:nth('+row_index+') td .idRiwayatReparasi').val();
	console.log(row_index, "bakso")
	// console.log(id, "INI ID")
			$('table tbody tr:nth('+row_index+')').remove();


	$('.langkahTabel').each((i, item) => {
		document.getElementsByClassName('langkahTabel')[i].innerHTML = i + 1
	})

	// 	$.ajax({
	// 	url: baseurl+'TicketingMaintenance/C_OrderList/deleteRiwayatReparasi/'+id,
	// 	type: 'POST',
	// 	success: function(results){
	// 		$('table tbody tr:nth('+row_index+')').remove();
	// 	}
	// });
}

// SELECT PELAKSANA REPARASI //
$(document).ready(function() {
	$("#pelaksanaReparasi").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/Pelaksana/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			pls: params.term,
			pelaksana: $('#pelaksanaReparasi').val()
			}
	return queryParameters;
		},
		processResults: function (pelaksana) {
	return {
		results: $.map(pelaksana, function(obj) {
    return { id:obj.noind+' - '+obj.nama, text:obj.noind+' - '+obj.nama };
					})
				};
			}
		}
	});
});

$('.modalApprove').on('click', function(e) {
	var userid = $(this).attr('data-noOrder');
	var nama_mesin = $('#namaMesin'+userid).val();
	var no_mesin = $('#noMesin'+userid).val();
	var line = $('#line'+userid).val();
	var analisis = $('#analisis'+userid).val();
	var duedate = $('#duedate'+userid).val();
	var reason = $('#reason'+userid).val();
	var kondisi = $('#kondisi'+userid).val();
	var running_hour = $('#running_hour'+userid).val();

	$('#namaMesin').text(nama_mesin);
	$('#noMesin').text(no_mesin);
	$('#line').text(line);
	$('#analisis').text(analisis);
	$('#duedate').text(duedate);
	$('#reason').text(reason);
	$('#kondisi').text(kondisi);
	$('#running_hour').text(running_hour);
    $('#no_Order').val(userid);
});

$('.modalReject').on('click', function(e) {
	var userid = $(this).attr('data-no_OrderReject');
	// alert(userid)
    $('#no_OrderReject').val(userid);
});

var numbe = Number($('div.no_urut input:nth-last-child(1)').val()) + 1
// console.log(numbe);
function addLangkahPerbaikanEdit() {
    var div = $('.perbaikan');
    var html = '';

    html += '<div class="col-lg-2"><input type="text" style="text-align:center; margin-left=0%;" name="txtUrutan[]" class="form-control ini_urutan urutan" value="'+numbe+'" readonly></div><div class="col-lg-10"><input type="text" style="width:490px" name="txtPerbaikan[]" class="form-control langkahPerbaikan" placeholder="Input Langkah Perbaikan" required></div><br />';

    numbe++

    div.append(html);
}


//DELETE RIWAYAT REPARASI
const onClickDeleteReparation = (th) => {
	var row_index = $(th).parent().parent('tr').index();
	var id = $('table tbody tr:nth('+row_index+') td .idRiwayatReparasi').val();
	console.log(row_index, "bakso")
	console.log(id, "INI ID")

	// 	$.ajax({
	// 	url: baseurl+'TicketingMaintenance/C_OrderList/deleteRiwayatReparasi/'+id,
	// 	type: 'POST',
	// 	success: function(results){
	// 		$('table tbody tr:nth('+row_index+')').remove();
	// 	}
	// });
}

//SAVE LAPORAN PERBAIKAN//
function saveLaporanPerbaikan(a) {
	// alert('oke');
	//insert header//
	var id					= $('.idLaporan').val();
	var kerusakan		 	= $('.kerusakan').val();
	var penyebab            = $('.penyebab').val();
	var langkahPencegahan 	= $('.langkahPencegahan').val();
	var verPerbaikan        = $('.verPerbaikan').val();
	// console.log(id, kerusakan, penyebab, langkahPencegahan, verPerbaikan);

	var arry = [];
	$('td.langkahTabel').each(function(){
	var urutan = $(this).text();
	arry.push(urutan);
	});
	// console.log(arry)

	var langkah_perbaikan = [];
	$('input[name^=txtPerbaikan]').each(function(){
		langkah_perbaikan.push($(this).val());
		// alert($(this).val());
	});
	// console.log("langkah_perbaikan:" ,langkah_perbaikan);

	// $('#loading').attr('hidden', false);
	$.ajax({
		type: "POST",
		url: baseurl+'TicketingMaintenance/Agent/OrderList/save_laporan/'+id,
		data:{
			id					: id,
			kerusakan			: kerusakan,
			penyebab		    : penyebab,
			arry		 		: arry,
			langkah_perbaikan	: langkah_perbaikan,
			langkahPencegahan  	: langkahPencegahan,
			verPerbaikan		: verPerbaikan
		},
		success:function(response){
			// $('#loading').attr('hidden', true);
			window.location.replace(baseurl+"TicketingMaintenance/Agent/OrderList/detail/"+id);
		}
	});
}

//SAVE LAPORAN PERBAIKAN EDIT//
function saveLaporanPerbaikanEdit(a) {
	// alert('oke');
	//insert header//
	var id					= $('.idLaporan').val();
	var kerusakan		 	= $('.kerusakan').val();
	var penyebab            = $('.penyebab').val();
	var langkahPencegahan 	= $('.langkahPencegahan').val();
	var verPerbaikan        = $('.verPerbaikan').val();
	console.log(id, kerusakan, penyebab, langkahPencegahan, verPerbaikan);

	var arry = [];
	$('td.langkahTabel').each(function(){
	var urutan = $(this).text();
	arry.push(urutan);
	});
	// console.log(arry)

	var langkah_perbaikan = [];
	$('input[name^=txtPerbaikan]').each(function(){
		langkah_perbaikan.push($(this).val());
	});
	// console.log("langkah_perbaikan:" ,langkah_perbaikan);

	// $('#loading').attr('hidden', false);
	$.ajax({
		type: "POST",
		url: baseurl+'TicketingMaintenance/Agent/OrderList/save_laporanEdit/'+id,
		data:{
			id					: id,
			kerusakan			: kerusakan,
			penyebab		    : penyebab,
			arry		 		: arry,
			langkah_perbaikan	: langkah_perbaikan,
			langkahPencegahan  	: langkahPencegahan,
			verPerbaikan		: verPerbaikan
		},
		success:function(response){
			// $('#loading').attr('hidden', true);
			window.location.replace(baseurl+"TicketingMaintenance/Agent/OrderList/detail/"+id);
		}
	});
}

function AreYouSureWantToDoneYourOrder(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();
	if (dd < 10) {
	dd = '0' + dd;
	}
	if (mm < 10) {
	mm = '0' + mm;
	}
	date = yyyy + '-' + mm + '-' + dd;
	var today = new Date();
	var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

	var id		= $('.idLaporan').val();
	var noind   = $('.noInduk').val();
	var now     = date + ', ' + time;
	var status 	= 'done';
	// console.log(now, id, status, noind);

	Swal.fire({
		title: 'Tunggu!',
		text: "Apakah Anda Ingin Menyelesaikan Order?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Selesaikan Order!'
	  }).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: baseurl+'TicketingMaintenance/Agent/OrderList/saveDone/'+id,
				data:{
					id		: id,
					noind	: noind,
					now		: now,
					status	: status
				},
				success:function(response){
					Swal.fire(
						'Done!',
						'Order Ini Telah Anda Selesaikan',
						'success'
					),
					window.location.replace(baseurl+"TicketingMaintenance/Agent/");
				}
			});
		}
	  })
}

function AreYouSureWantToCloseYourOrder(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();
	if (dd < 10) {
	dd = '0' + dd;
	}
	if (mm < 10) {
	mm = '0' + mm;
	}
	date = yyyy + '-' + mm + '-' + dd;
	var today = new Date();
	var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

	var id		= $('.idLaporan').val();
	var noind   = $('.noInduk').val();
	var now     = date + ', ' + time;
	var status 	= 'close';
	console.log(now, id, status, noind);

	Swal.fire({
		title: 'Tunggu!',
		text: "Apakah Anda Ingin Menutup Order?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Close Order!'
	  }).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: baseurl+'TicketingMaintenance/Seksi/MyOrder/closeOrder/'+id,
				data:{
					id		: id,
					noind	: noind,
					now		: now,
					status	: status
				},
				success:function(response){
					Swal.fire(
						'Closed!',
						'Order Ini Telah Anda Close',
						'success'
					),
					window.location.replace(baseurl+"TicketingMaintenance/Seksi/MyOrder/");
				}
			});
		}
	  })
}

//SELECT NO MESIN//
$(document).ready(function() {
	$("#txtNoMesin").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_NewOrder/NoMesin/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			nm: params.term,
			noMesin: $('#txtNoMesin').val()
			}
	return queryParameters;
		},
		processResults: function (noMesin) {
	return {
		results: $.map(noMesin, function(obj) {
	return { id:obj.NO_MESIN, text:obj.NO_MESIN };
					})
				};
			}
		}
	});
});

//AUTOFILL JENIS MESIN//
$('#txtNoMesin').change(function(){
	$.ajax({
		type: "POST",
		url: baseurl+'TicketingMaintenance/C_NewOrder/jenisMesin/',
		dataType: "json",
		data:{params: $(this).val() },
		beforeSend: function(e) {
		if(e && e.overrideMimeType) {
	e.overrideMimeType("application/json;charset=UTF-8");
		}
	},
	success: function(response){
		if(response != null){
			// alert("Data Masuk")
			// var sblm = $('#jenisMesin').val();
			// $('select[name^=txtSlcElemen]')
			var sblm = $('#jenisMesin').val();

			console.log(sblm);
			if (sblm == '') {
				$("#jenisMesin").val(response[0].SPEC_MESIN);
			}
			else {
				$("#jenisMesin").val(response[0].SPEC_MESIN);
			}
		console.log(response[0].SPEC_MESIN);
		}else{
			alert("Data Tidak Ditemukan");
		}
	},
	error: function (xhr) {
	alert(xhr.responseText);
		}
	});
	});

	$('.ModalEditSparepart').on('click', function(e) {
		var userid = $(this).attr('data-noOrder');
		var sparepart = $('#namaSparepart'+userid).val();
		var spesifikasi = $('#spesifikasi'+userid).val();
		var jumlah = $('#jumlah'+userid).val();

		$('#modalSparepart').val(sparepart);
		$('#modalSpesifikasi').val(spesifikasi);
		$('#modalJumlah').val(jumlah);
		$('#no_Order').val(userid);
	});

//SELECT SPAREPART//
$(document).ready(function() {
	$("#sparepartAgent").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/SparePart/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			sp: params.term,
			sparepart: $('#sparepartAgent').val()
			}
	return queryParameters;
		},
		processResults: function (sparepart) {
	return {
		results: $.map(sparepart, function(obj) {
	return { id:obj.DESCRIPTION, text:obj.DESCRIPTION };
					})
				};
			}
		}
	});
});

//DELETE SPAREPART
function deleteSparepart(th) {
	var no_order = $('.no_order').val();
	var row_index = $(th).parent().parent('tr').index();
	console.log(no_order);
	var id_sparepart = $('table tbody tr:nth('+row_index+') td .id_sparepart').val();
		$.ajax({
			type: "POST",
			url: baseurl+'TicketingMaintenance/C_OrderList/deleteSparepart/'+id,
			data:{
			no_order	 : no_order,
			id_sparepart : id_sparepart
			},
			dataType: 'json',
			// cache:false,
			success:function(data){
				console.log(data);
			},
		});
		$('table tbody tr:nth('+row_index+')').remove();
		// window.location.replace(baseurl+"TicketingMaintenance/Agent/OrderList/isiSparepartEdit/"+no_order);
		$('.posisi').each((i, item) => {
			document.getElementsByClassName('posisi')[i].innerHTML = i + 1
		})
}

$('input').iCheck({
	checkboxClass: 'icheckbox_flat-blue',
	radioClass: 'iradio_flat-blue'
});

$(document).ready(function () {
	$('input[name="terdaftar"]').on('ifChanged', function () {
		if ($('input[name=terdaftar]:checked').val() == "TidakTerdaftar") {
			console.log("tdk");
			$('.terdaftar').css("display", "none");
			$('.tdkTerdaftar').show("display", "");
		} else if ($('input[name=terdaftar]:checked').val() == "Terdaftar") {
			console.log("ya");
			$('.terdaftar').css("display", "");
			$('.tdkTerdaftar').css("display", "none");
		}
	});
});

// $('.jamMulai').timepicker({
// 	showSeconds: false,
// 	showMeridian: false,
// 	defaultTime: false,
// 	use24hours: true,
// 	minuteStep: 1
// });

// $('.jamSelesai').timepicker({
// 	showSeconds: false,
// 	showMeridian: false,
// 	defaultTime: false,
// 	use24hours: true,
// 	minuteStep: 1
// });

$('#txtJamMulai').datetimepicker({
	datepicker: false,
	step: 1,
	format: 'H:i'
})

$('#txtJamSelesai').datetimepicker({
	datepicker: false,
	step: 1,
	format: 'H:i'
})

//SELECT SEKSI//
$(document).ready(function(){
	$("#kodeNamaSeksi").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/Seksi/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
		var queryParameters = {
			term: params.term,
			seksi: $('#kodeNamaSeksi').val()
		}
	return queryParameters;
		},
		processResults: function (seksi) {
	return {
		results: $.map(seksi, function(obj) {
	return { id:obj.seksi, text:obj.seksi};
					})
				};
			}
		}
	});
});

//DELETE MASTER KODE SEKSI
function deleteMasterKodeSeksi(th) {
	var row_index = $(th).parent().parent('tr').index();
	var id_seksi = $('table tbody tr:nth('+row_index+') td .id_kode').val();
	console.log(id_seksi);

		$.ajax({
			type: "POST",
			url: baseurl+'TicketingMaintenance/C_OrderList/deleteKodeSeksi/'+id_seksi,
			data:{
			id_seksi : id_seksi
			},
			dataType: 'json',
			// cache:false,
			success:function(data){
				console.log(data);
			},
		});
		$('table tbody tr:nth('+row_index+')').remove();
		// window.location.replace(baseurl+"TicketingMaintenance/Agent/OrderList/isiSparepartEdit/"+no_order);
		$('.posisi').each((i, item) => {
			document.getElementsByClassName('posisi')[i].innerHTML = i + 1
		})
}

$('#rangeAwal').datepicker({
	todayHighlight: true,
	format: 'dd-M-yyyy',
	autoclose: true
});

$('#rangeAkhir').datepicker({
	todayHighlight: true,
	format: 'dd-M-yyyy',
	autoclose: true
});

$('input').iCheck({
	checkboxClass: 'icheckbox_flat-blue',
	radioClass: 'iradio_flat-blue'
});

$(document).ready(function () {
	$('input[name="filterRekap"]').on('ifChanged', function () {
		// console.log("hwhwhwh");
		if ($('input[name=filterRekap]:checked').val() == "FilterMesin") {
			console.log("mesin");
			$('.filterMesin').css("display", "")
			$('.filterSeksi').css("display", "none")
			$('.filterRange').css("display", "none")
		} else if ($('input[name=filterRekap]:checked').val() == "FilterSeksi") {
			console.log("seksi");
			$('.filterSeksi').css("display", "")
			$('.filterMesin').css("display", "none")
			$('.filterRange').css("display", "none")
		}else if ($('input[name=filterRekap]:checked').val() == "FilterRangeTanggal"){
			console.log("rt");
			$('.filterRange').css("display", "")
			$('.filterSeksi').css("display", "none")
			$('.filterMesin').css("display", "none")
		}
	});
});

//SELECT MESIN WHEN RECAP//
$(document).ready(function() {
	$("#parMesin").select2({
		// minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/slcMesinRekap/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
				ms: params.term,
				namaMesin: $('#parMesin').val()
			}
	return queryParameters;
		},
		processResults: function (namaMesin) {
	return {
		results: $.map(namaMesin, function(obj) {
	return { id:obj.nomor_mesin+' - '+obj.nama_mesin, text:obj.nomor_mesin+' - '+obj.nama_mesin };
					})
				};
			}
		}
	});
});

//SELECT SEKSI WHEN RECAP//
$(document).ready(function() {
	$("#parSeksi").select2({
		// minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/slcSeksiRekap/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
				sk: params.term,
				namaSeksi: $('#parSeksi').val()
			}
	return queryParameters;
		},
		processResults: function (namaSeksi) {
	return {
		results: $.map(namaSeksi, function(obj) {
	return { id:obj.seksi, text:obj.seksi };
					})
				};
			}
		}
	});
});
