// select department class
$(document).ready(function(){
	$("#deptclass").select2({
		allowClear: true,
		placeholder: "Department Class",
		minimumInputLength: 0,
		ajax: {		
			url:baseurl+"PerhitunganUM/Hitung/DeptClass",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
				}
				return queryParameters;
			},
			processResults: function (data) {
				// console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.SEKSI_CODE, text:obj.SEKSI};
					})
				};
			}
		}
	});
});

function getPUM(th) {
	$(document).ready(function(){
		var deptclass = $('select[name="deptclass"]').val();
		var plan = $('select[name="plan"]').val();
		var username = $('#username').val();
		// console.log(deptclass, plan);
		
		var request = $.ajax({
			url: baseurl+'PerhitunganUM/Hitung/search/',
			data: {
				deptclass : deptclass, 
				plan : plan,
				username : username
			},
			type: "POST",
			datatype: 'html'
		});
		$('#ResultPUM').html('');
		$('#ResultPUM').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading14.gif"><br/></center><center><p style="font-size:12px">Harap tunggu beberapa menit...<p></center>' );
			
		request.done(function(result){
			// console.log("sukses2");
			$('#ResultPUM').html(result);
			$('#tblsatu').DataTable({
				scrollX: true,
				scrollY:  500,
				scrollCollapse: true,
				paging:false,
				info:true,
				ordering:false
			});
		});
	});		
}

$('#tbldua').DataTable({
	scrollX: true,
	scrollY:  500,
	scrollCollapse: true,
	paging:false,
	info:true,
	ordering:false,
	fixedColumns: {
		leftColumns: 1
		}
});

$('.slcDeclas').change(function(){
	$('#findPUM').removeAttr("disabled");
})

function insertPUM(th) {
	var resource = $('input[name="resource[]"]').map(function(){return $(this).val();}).get();
	var nomesin = $('input[name="nomesin[]"]').map(function(){return $(this).val();}).get();
	var tagnum = $('input[name="tagnum[]"]').map(function(){return $(this).val();}).get();
	var jenis = $('input[name="jenis[]"]').map(function(){return $(this).val();}).get();
	var cost = $('input[name="cost[]"]').map(function(){return $(this).val();}).get();
	var deptclass = $('input[name="deptc[]"]').map(function(){return $(this).val();}).get();
	var username = $('input[name="username[]"]').map(function(){return $(this).val();}).get();
	var utilitas = $('input[name="utilitas2[]"]').map(function(){return $(this).val();}).get();
	var last_update = $('#tgl_update').val();
	var plan = $('#plan').val();
	var nama_user = $('#nama_user').val();
	console.log(last_update);
	if (last_update == '') {
		Swal.fire({
			title: 'Peringatan',
			text: 'Apakah Anda Yakin?',
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
		}).then(result => {
			if (result.value) {  
				$.ajax ({
					url : baseurl + "PerhitunganUM/Hitung/insertPUM",
					data: { resource : resource , nomesin : nomesin, tagnum : tagnum, jenis : jenis, cost : cost, deptclass : deptclass, username : username, utilitas : utilitas, last_update : last_update, plan : plan},
					type : "POST",
					dataType: "html",
					success: function(data){
						swal.fire("Berhasil!", "Data telah disimpan.", "success");
					}
				});
		}})
	}else{
		Swal.fire({
			title: 'Apakah Anda Yakin?',
			text: 'Terakhir Update Data : '+last_update,
			type: 'question',
			showCancelButton: true,
			allowOutsideClick: false
		}).then(result => {
			if (result.value) {  
				$.ajax ({
					url : baseurl + "PerhitunganUM/Hitung/insertPUM",
					data: { resource : resource , nomesin : nomesin, tagnum : tagnum, jenis : jenis, cost : cost, deptclass : deptclass, username : username, utilitas : utilitas, last_update : last_update, plan : plan},
					type : "POST",
					dataType: "html",
					success: function(data){
						swal.fire("Berhasil!", "Data telah diupdate.", "success");
					}
				});
		}})
	}
}

// //---------------------------------------------- OPM -------------------------------------------//
$('#routclass').change(function(){
	$('#findPUMopm').removeAttr("disabled");

	var routclass = $(this).val();
	// console.log(routclass);
	$("#rsrc").select2({
		allowClear: true,
		placeholder: "Resource Code",
		// minimumInputLength: 0,
		ajax: {		
			url:baseurl+"PerhitunganUM/HitungOPM/getResources",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					routclass : routclass
				}
				return queryParameters;
			},
			processResults: function (data) {
				// console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.RESOURCES, text:obj.RESOURCES};
					})
				};
			}
		}
	});
});

let ajax_1 = null;

function getPUMopm(th) {
	$(document).ready(function(){
		if (ajax_1 != null) {
			ajax_1.abort();
		}

		var routclass = $('select[name="routclass"]').val();
		var plan = $('select[name="planopm"]').val();
		var rsrc = $('select[name="rsrc"]').val();

		var request = $.ajax({
			url: baseurl+'PerhitunganUM/HitungOPM/getData',
			data: {
				routclass : routclass, 
				plan : plan,
				rsrc : rsrc
			},
			type: "POST",
			datatype: 'html'
		});
		$('#ResultPUMopm').html('');
		$('#ResultPUMopm').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading14.gif"><br/></center><center><p style="font-size:12px">Harap tunggu beberapa menit...<p></center>' );

		request.done(function(result){
			// console.log(result);
			$('#ResultPUMopm').html(result);
			$('#tblhtgopm').DataTable({
				scrollX: true,
				scrollY:  500,
				scrollCollapse: true,
				paging:false,
				info:true,
				ordering:false,
				fixedColumns: {
					leftColumns: 1
				}
			});
		});
	});
}