const toastMPL_ = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

// select department class
$(document).ready(function(){
	// $("#deptclassLP").select2({
	// 	allowClear: true,
	// 	placeholder: "Department Class",
	// 	minimumInputLength: 0,
	// 	ajax: {
	// 		url:baseurl+"MonitoringLoadingProduksi/Monitoring/getDeptClass",
	// 		dataType: 'JSON',
	// 		type: "POST",
	// 		data: function (params) {
	// 			return {
	// 				term: params.term
	// 			}
	// 		},
	// 		processResults: function (data) {
	// 			// console.log(data);
	// 			return {
	// 				results: $.map(data, function(obj) {
	// 					return {
	// 						id:obj.SEKSI_CODE,
	// 						text:obj.SEKSI
	// 					};
	// 				})
	// 			};
	// 		}
	// 	}
	// });
});

$('#deptclassLP').change(function(){
	if ($(this).val() != '') {
		$('#searchLP').removeAttr("disabled");
	}else {
		$('#searchLP').attr("disabled", true);
	}
})

let request_pl_2021 = 0;
function getdataPL(th) {
		if (request_pl_2021 != 0) {
			request_pl_2021.abort();
			toastMPL_('warning', 'Data request canceled!');
		}
		let deptclass = $('select[name="deptclass"]').val();
		let plan = $('select[name="plan"]').val();
		let jam = $('input[name="jam"]').val();
		// console.log(deptclass, plan);
		// console.log('hai');
		request_pl_2021 = $.ajax({
			url: baseurl+'MonitoringLoadingProduksi/Monitoring/getTable',
			cache:false,
			data: {
				deptclass : deptclass,
				plan : plan,
				jam : jam
			},
			type: "POST",
			datatype: 'html'
		});
		$('.area-table-lp').html('');
			$('.area-table-lp').html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"><br/></center><center><p style="font-size:14px;font-weight:bold">Harap tunggu, sedang memuat data...<p></center>' );

		request_pl_2021.done(function(result){
			$('.area-table-lp').html(result);
			request_pl_2021 = 0;
			toastMPL_('success', 'Success Loaded Data.');
		});
}

// $('#tbldua').DataTable({
// 	scrollX: true,
// 	scrollY:  500,
// 	scrollCollapse: true,
// 	paging:false,
// 	info:true,
// 	ordering:false,
// 	fixedColumns: {
// 		leftColumns: 1
// 		}
// });

// $('.slcDeclas').change(function(){
// 	$('#findPUM').removeAttr("disabled");
// })

// function insertPUM(th) {
// 	var resource = $('input[name="resource[]"]').map(function(){return $(this).val();}).get();
// 	var nomesin = $('input[name="nomesin[]"]').map(function(){return $(this).val();}).get();
// 	var tagnum = $('input[name="tagnum[]"]').map(function(){return $(this).val();}).get();
// 	var jenis = $('input[name="jenis[]"]').map(function(){return $(this).val();}).get();
// 	var cost = $('input[name="cost[]"]').map(function(){return $(this).val();}).get();
// 	var deptclass = $('input[name="deptc[]"]').map(function(){return $(this).val();}).get();
// 	var username = $('input[name="username[]"]').map(function(){return $(this).val();}).get();
// 	var utilitas = $('input[name="utilitas2[]"]').map(function(){return $(this).val();}).get();
// 	var last_update = $('#tgl_update').val();
// 	var plan = $('#plan').val();
// 	var nama_user = $('#nama_user').val();
// 	console.log(last_update);
// 	if (last_update == '') {
// 		Swal.fire({
// 			title: 'Peringatan',
// 			text: 'Apakah Anda Yakin?',
// 			type: 'question',
// 			showCancelButton: true,
// 			allowOutsideClick: false
// 		}).then(result => {
// 			if (result.value) {
// 				$.ajax ({
// 					url : baseurl + "PerhitunganUM/Hitung/insertPUM",
// 					data: { resource : resource , nomesin : nomesin, tagnum : tagnum, jenis : jenis, cost : cost, deptclass : deptclass, username : username, utilitas : utilitas, last_update : last_update, plan : plan},
// 					type : "POST",
// 					dataType: "html",
// 					success: function(data){
// 						swal.fire("Berhasil!", "Data telah disimpan.", "success");
// 					}
// 				});
// 		}})
// 	}else{
// 		Swal.fire({
// 			title: 'Apakah Anda Yakin?',
// 			text: 'Terakhir Update Data : '+last_update,
// 			type: 'question',
// 			showCancelButton: true,
// 			allowOutsideClick: false
// 		}).then(result => {
// 			if (result.value) {
// 				$.ajax ({
// 					url : baseurl + "PerhitunganUM/Hitung/insertPUM",
// 					data: { resource : resource , nomesin : nomesin, tagnum : tagnum, jenis : jenis, cost : cost, deptclass : deptclass, username : username, utilitas : utilitas, last_update : last_update, plan : plan},
// 					type : "POST",
// 					dataType: "html",
// 					success: function(data){
// 						swal.fire("Berhasil!", "Data telah diupdate.", "success");
// 					}
// 				});
// 		}})
// 	}
// }

// // //---------------------------------------------- OPM -------------------------------------------//

// $(document).ready(function(){
// 	$("#routclass").select2({
// 		allowClear: true,
// 		placeholder: "Routing Class",
// 		minimumInputLength: 0,
// 		ajax: {
// 			url:baseurl+"PerhitunganUM/HitungOPM/RoutClass",
// 			dataType: 'json',
// 			type: "GET",
// 			data: function (params) {
// 				var queryParameters = {
// 					term: params.term
// 				}
// 				return queryParameters;
// 			},
// 			processResults: function (data) {
// 				// console.log(data);
// 				return {
// 					results: $.map(data, function(obj) {
// 						return { id:obj.ROUTING_CLASS, text:obj.ROUTING_CLASS};
// 					})
// 				};
// 			}
// 		}
// 	});
// });

// $('.slcRoclas').change(function(){
// 	$('#findPUMopm').removeAttr("disabled");
// })

// function getPUMopm(th) {
// 	$(document).ready(function(){
// 		var routclass = $('select[name="routclass"]').val();
// 		var planopm = $('select[name="planopm"]').val();
// 		var usernameopm = $('#usernameopm').val();

// 		var request = $.ajax({
// 			url: baseurl+'PerhitunganUM/HitungOPM/search',
// 			data: {
// 				routclass : routclass,
// 				planopm : planopm,
// 				usernameopm : usernameopm
// 			},
// 			type: "POST",
// 			datatype: 'html'
// 		});
// 		$('#ResultPUMopm').html('');
// 		$('#ResultPUMopm').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading14.gif"><br/></center><center><p style="font-size:12px">Harap tunggu beberapa menit...<p></center>' );

// 		request.done(function(result){
// 			// console.log(result);
// 			$('#ResultPUMopm').html(result);
// 			$('#tblsatuopm').DataTable({
// 				scrollX: true,
// 				scrollY:  500,
// 				scrollCollapse: true,
// 				paging:false,
// 				info:true,
// 				ordering:false
// 			});
// 		});
// 	});
// }

// $('#tblduaopm').DataTable({
// 	scrollX: true,
// 	scrollY:  500,
// 	scrollCollapse: true,
// 	paging:false,
// 	info:true,
// 	ordering:false,
// 	fixedColumns: {
// 		leftColumns: 1
// 	}
// });
