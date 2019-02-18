$(document).ready(function(){
	$('.dataTable-pnbd').DataTable({
		retrieve : true,
		dom: 'Bfrtip',
	    buttons: [
	        'excel',
	        'pdf'
	    ]
	});
});

//setup kelompok start

$(document).on('click','#btnCancelKelompok',function(e){
  $('#PNBPkelompok-Create').modal("hide");
  $('#PNBPkelompok-Edit').modal("hide");
});

$(document).on('click','#btnSubmitKelompokCreate',function(e){
	var kelompok = $('input[name="txtNamaKelompok"]').val();
	 
	if (kelompok == '') {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupKelompok/Create",
	        data : {kelompok : kelompok},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupKelompok";
	        }
	    });
	}
});

$(document).on('click','#btnEditKelompokPNBP',function(e){
	var kelompok = $(this).attr('data-kelompok');
	var id = $(this).attr('data-idkelompok');
	$('input[name="txtNamaKelompokEdit"]').val(kelompok);
	$('input[name="txtIDKelompokEdit"]').val(id);

	$('#PNBPkelompok-Edit').modal('show');
});

$(document).on('click','#btnSubmitKelompokEdit',function(e){
	var kelompok = $('input[name="txtNamaKelompokEdit"]').val();
	var idkel = $('input[name="txtIDKelompokEdit"]').val();
	if (kelompok == '') {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupKelompok/Edit/"+idkel,
	        data : {kelompok : kelompok},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupKelompok";
	        }
	    });
	}
});

//setup kelompok end



//setup indikator start

$(document).on('click','#btnCancelIndikator',function(e){
  $('#PNBPIndikator-Create').modal("hide");
  $('#PNBPIndikator-Edit').modal("hide");
});

$(document).ready(function(){
	$('.selectPNBPKelompok').select2({
		dropdownParent: $('#PNBPIndikator-Create'),
		placeholder: "Kelompok",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupIndikator/getKelompok',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_kelompok, text: obj.kelompok};
					})
				}
			}
		}
	});

	$('.selectPNBPKelompokEdit').select2({
		dropdownParent: $('#PNBPIndikator-Edit'),
		placeholder: "Kelompok",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupIndikator/getKelompok',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_kelompok, text: obj.kelompok};
					})
				}
			}
		}
	});
});

$(document).on('click','#btnSubmitIndikatorCreate',function(e){
	var kelompok = $('.selectPNBPKelompok').find(':selected').val();
	var indikator = $('input[name="txtIndikatorPNBP"]').val();
	
	if (kelompok == "" || indikator == "") {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupIndikator/Create",
	        data : {kelompok : kelompok,indikator : indikator},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupIndikator";
	        }
	    });
	}
});

$(document).on('click','#btnEditIndikatorPNBP',function(e){
	var kelompok = $(this).attr('data-kelompok');
	var aspek = $(this).attr('data-aspek');
	var idkelompok = $(this).attr('data-idkelompok');
	var idaspek = $(this).attr('data-idaspek');

	var optionSelect = "<option value = '"+idkelompok+"' selected>"+kelompok+"</option>";
	$('.selectPNBPKelompokEdit').html(optionSelect);
	$('.selectPNBPKelompokEdit').select2({
		dropdownParent: $('#PNBPIndikator-Edit'),
		placeholder: "Kelompok",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupIndikator/getKelompok',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_kelompok, text: obj.kelompok};
					})
				}
			}
		}
	});
	$('input[name="txtIndikatorPNBPEdit"]').val(aspek);
	$('input[name="txtIDIndikatorPNBP"]').val(idaspek);

	$('#PNBPIndikator-Edit').modal('show');
});

$(document).on('click','#btnSubmitIndikatorEdit',function(e){
	var idkel = $('.selectPNBPKelompokEdit').find(':selected').val();
	var idaspek = $('input[name="txtIDIndikatorPNBP"]').val();
	var aspek = $('input[name="txtIndikatorPNBPEdit"]').val();
	
	if (idkel == '' || idaspek == '' || aspek == '') {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupIndikator/Edit/"+idaspek,
	        data : {idkelompok : idkel,aspek : aspek},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupIndikator";
	        }
	    });
	}
});

//	indikator end




// pernyataan start

$(document).on('click','#btnCancelPernyataan',function(e){
  $('#PNBPPernyataan-Create').modal("hide");
  $('#PNBPPernyataan-Edit').modal("hide");
});

$(document).ready(function(){
	$('.selectPNBPIndikator').select2({
		dropdownParent: $('#PNBPPernyataan-Create'),
		placeholder: "Indikator",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupPernyataan/getIndikator',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_aspek, text: obj.kelompok+" - "+obj.nama_aspek};
					})
				}
			}
		}
	});

	$('.selectPNBPIndikatorEdit').select2({
		dropdownParent: $('#PNBPPernyataan-Edit'),
		placeholder: "Kelompok",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupPernyataan/getIndikator',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_aspek, text: obj.kelompok+" - "+obj.nama_aspek};
					})
				}
			}
		}
	});
});

$(document).on('click','#btnSubmitPernyataanCreate',function(e){
	var indikator = $('.selectPNBPIndikator').find(':selected').val();
	var pernyataan = $('input[name="txtPernyataanPNBP"]').val();
	var aktif = $('.statusAktifPernyataanPNBP').val();
	var n1 = $('input[name="txtBobotPenilaian1PNBP"]').val();
	var n2 = $('input[name="txtBobotPenilaian2PNBP"]').val();
	var n3 = $('input[name="txtBobotPenilaian3PNBP"]').val();
	var n4 = $('input[name="txtBobotPenilaian4PNBP"]').val();
	
	if (pernyataan == "" || indikator == "") {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupPernyataan/Create",
	        data : {pernyataan : pernyataan,indikator : indikator, aktif : aktif, nilai1 : n1, nilai2 : n2, nilai3 : n3, nilai4 : n4},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupPernyataan";
	        }
	    });
	}
});

$(document).on('click','#btnEditPernyataanPNBP',function(e){
	var kelompok = $(this).attr('data-kelompok');
	var aspek = $(this).attr('data-aspek');
	var pernyataan = $(this).attr('data-pernyataan');
	var idpernyataan = $(this).attr('data-idpernyataan');
	var idaspek = $(this).attr('data-idaspek');
	var n1 = $(this).attr('data-n1');
	var n2 = $(this).attr('data-n2');
	var n3 = $(this).attr('data-n3');
	var n4 = $(this).attr('data-n4');
	var aktif = $(this).attr('data-aktif');

	var optionSelect = "<option value = '"+idaspek+"' selected>"+kelompok+" - "+aspek+"</option>";
	$('.selectPNBPIndikatorEdit').html(optionSelect);
	$('.selectPNBPIndikatorEdit').select2({
		dropdownParent: $('#PNBPPernyataan-Edit'),
		placeholder: "Indikator",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupPernyataan/getIndikator',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_aspek, text: obj.kelompok+" - "+obj.nama_aspek};
					})
				}
			}
		}
	});
	$('input[name="txtPernyataanPNBPEdit"]').val(pernyataan);
	$('input[name="txtIDPernyataanPNBP"]').val(idpernyataan);
	$('input[name="txtBobotPenilaian1PNBPEdit"]').val(n1);
	$('input[name="txtBobotPenilaian2PNBPEdit"]').val(n2);
	$('input[name="txtBobotPenilaian3PNBPEdit"]').val(n3);
	$('input[name="txtBobotPenilaian4PNBPEdit"]').val(n4);
	if (aktif == 'Aktif') {
		$('.statusAktifPernyataanPNBPEdit').html('<option value="1">Aktif</option><option value="0">Non Aktif</option>');
		$('.statusAktifPernyataanPNBPEdit').select2();
	}else{
		$('.statusAktifPernyataanPNBPEdit').html('<option value="0">Non Aktif</option><option value="1">Aktif</option>');
		$('.statusAktifPernyataanPNBPEdit').select2();
	}

	$('#PNBPPernyataan-Edit').modal('show');
});

$(document).on('click','#btnSubmitPernyataanEdit',function(e){
	var idaspek = $('.selectPNBPIndikatorEdit').find(':selected').val();
	var idpernyataan = $('input[name="txtIDPernyataanPNBP"]').val();
	var pernyataan = $('input[name="txtPernyataanPNBPEdit"]').val();
	var aktif = $('.statusAktifPernyataanPNBPEdit').val();
	var n1 = $('input[name="txtBobotPenilaian1PNBPEdit"]').val();
	var n2 = $('input[name="txtBobotPenilaian2PNBPEdit"]').val();
	var n3 = $('input[name="txtBobotPenilaian3PNBPEdit"]').val();
	var n4 = $('input[name="txtBobotPenilaian4PNBPEdit"]').val();

	if (idaspek == '' || idpernyataan == '' || pernyataan == '') {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupPernyataan/Edit/"+idpernyataan,
	        data : {idaspek : idaspek, pernyataan : pernyataan, aktif : aktif, nilai1 : n1, nilai2 : n2, nilai3 : n3, nilai4 : n4},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupPernyataan";
	        }
	    });
	}
});

//pernyataan end




//admin start
$(document).on('click','#btnCancelAdmin',function(e){
  $('#PNBPAdmin-Create').modal("hide");
});

$(document).ready(function(){
	$('.selectUserAdminPNBP').select2({
		dropdownParent: $('#PNBPAdmin-Create'),
		placeholder: "Noind - Nama",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/SetupAdmin/getUser',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.employee_code, text: obj.employee_code+" - "+obj.employee_name};
					})
				}
			}
		}
	});
});

$(document).on('click','#btnSubmitAdminCreate',function(e){
	var user = $('.selectUserAdminPNBP').find(':selected').val();
	var aktif = $('.selectUserStatusPNBP').find(':selected').val();
	
	if (user == "" || aktif == "") {
	    alert("data masih kosong !!");
	}else{
	    $.ajax({
	        type : 'POST',
	        url  : baseurl+"PNBP/SetupAdmin/Create",
	        data : {user : user,aktif : aktif},
	        success : function(e){
	          window.location = baseurl+"PNBP/SetupAdmin";
	        }
	    });
	}
});