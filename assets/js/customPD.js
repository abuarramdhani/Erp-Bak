$(document).ready(function(){
	$('.dataTable-pnbp').DataTable({
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

// admin end




// setup questioner start

$(document).on('click','#btnCancelSetupQuestioner',function(e){
  $('#PNBPSetupQuestioner-Create').modal("hide");
});

$(document).ready(function(){
	$('input[name="txtPeriodeQuestioner"]').daterangepicker({
	    "showDropdowns": true,
	    "autoApply": true,
	    "locale": {
	        "format": "DD MMMM YYYY",
	        "separator": " - ",
	        "applyLabel": "OK",
	        "cancelLabel": "Batal",
	        "fromLabel": "Dari",
	        "toLabel": "Hingga",
	        "customRangeLabel": "Custom",
	        "weekLabel": "W",
	        "daysOfWeek": [
	            "Mg",
	            "Sn",
	            "Sl",
	            "Rb",
	            "Km",
	            "Jm",
	            "Sa"
	        ],
	        "monthNames": [
	            "Januari",
	            "Februari",
	            "Maret",
	            "April",
	            "Mei",
	            "Juni",
	            "Juli",
	            "Agustus ",
	            "September",
	            "Oktober",
	            "November",
	            "Desember"
	        ],
	        "firstDay": 1
	    }
	});
});

//setup questioner end

// report start

function radarBarPNBP(canvas,label,hasil,maks){
	var ctx = $(canvas);
	var radarBarPNBP = new Chart(ctx,{
	type : 'radar',
	data : {
		labels : label,
		datasets : hasil
	},
	options : {
		scale : {
			display : true,
			ticks : {
				max : maks
			}
		}
	}
})
}


$(document).ready(function(){
	$('.selectPekerjaReportPNBP').select2({
		placeholder: "Pekerja",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'PNBP/Report/getPekerja',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term,
					periode: $('.selectPeriodeQuestionerPNBP').find(':selected').val()
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

	$('#btnSubmitChartPNBP').on('click',function(){
		var periode = $('.selectPeriodeQuestionerPNBP').find(':selected').val();
		var noind 	= $('.selectPekerjaReportPNBP').find(':selected').val();
		if (periode == "" || noind =="") {
			alert('Data Masih Kosong');
		}else{
			$('#chartBig').html('');
			$('#chartBig').html('<canvas id="canvasReportPNBP"></canvas>');
			$('#chartSmall1').html('');
			$('#chartSmall1').html('<canvas id="canvasReportPNBP1"></canvas>');
			$('#chartSmall2').html('');
			$('#chartSmall2').html('<canvas id="canvasReportPNBP2"></canvas>');
			$.ajax({
				type 	: 'POST',
				data 	: {periode : periode, noind : noind},
				url 	: baseurl+'PNBP/Report/getData',
				success : function(data){
					var obj = JSON.parse(data);
					var aspek = [];
					var ds = [];
					ds = [{
						data : [],
						borderColor : '#42a5f5',
						backgroundColor : 'transparent',
						pointBackgroundColor : '#2979ff' ,
						label : 'Kelompok 1'
					},
					{
						data : [],
						borderColor : '#e91e63',
						backgroundColor : 'transparent',
						pointBackgroundColor : '#f50057',
						label : 'Kelompok 2'
					}];
					for (var i = 0; i < obj.length; i++) {
						for (var j = 0; j < obj[i]['data'].length; j++) {
							ds[i]['data'].push(obj[i]['data'][j]);
							ds[i]['label'] = obj[i]['label'];
							ds[i]['borderColor'] = obj[i]['borderColor'];
							ds[i]['pointBackgroundColor'] = obj[i]['pointBackgroundColor'];
							ds[i]['backgroundColor'] = obj[i]['backgroundColor'];
							if (i == 0) {
								aspek.push(obj[i]['notes'][j]);
							}
						}
					}
					radarBarPNBP('#canvasReportPNBP',aspek,ds,100);
					
				}
			});
			$.ajax({
				type 	: 'POST',
				data 	: {periode : periode, noind : noind},
				url 	: baseurl+'PNBP/Report/getData1',
				success : function(data){
					var obj = JSON.parse(data);
					var aspek = [];
					var ds = [];
					ds = [{
						data : [],
						borderColor : '#42a5f5',
						backgroundColor : 'transparent',
						pointBackgroundColor : '#2979ff' ,
						label : 'Kelompok 1'
					},
					{
						data : [],
						borderColor : '#e91e63',
						backgroundColor : 'transparent',
						pointBackgroundColor : '#f50057',
						label : 'Kelompok 2'
					}];
					for (var i = 0; i < obj.length; i++) {
						for (var j = 0; j < obj[i]['data'].length; j++) {
							ds[i]['data'].push(obj[i]['data'][j]);
							ds[i]['label'] = obj[i]['label'];
							ds[i]['borderColor'] = obj[i]['borderColor'];
							ds[i]['pointBackgroundColor'] = obj[i]['pointBackgroundColor'];
							ds[i]['backgroundColor'] = obj[i]['backgroundColor'];
							if (i == 0) {
								aspek.push(obj[i]['notes'][j]);
							}
						}
					}
					radarBarPNBP('#canvasReportPNBP1',aspek,ds,15);
					
				}
			});
			$.ajax({
				type 	: 'POST',
				data 	: {periode : periode, noind : noind},
				url 	: baseurl+'PNBP/Report/getData2',
				success : function(data){
					var obj = JSON.parse(data);
					var aspek = [];
					var ds = [];
					ds = [{
						data : [],
						borderColor : '#42a5f5',
						backgroundColor : 'transparent',
						pointBackgroundColor : '#2979ff',
						label : 'Kelompok 1'
					}];
					for (var i = 0; i < obj.length; i++) {
						for (var j = 0; j < obj[i]['data'].length; j++) {
							ds[i]['data'].push(obj[i]['data'][j]);
							ds[i]['label'] = obj[i]['label'];
							ds[i]['borderColor'] = obj[i]['borderColor'];
							ds[i]['pointBackgroundColor'] = obj[i]['pointBackgroundColor'];
							ds[i]['backgroundColor'] = obj[i]['backgroundColor'];
							if (i == 0) {
								aspek.push(obj[i]['notes'][j]);
							}
						}
					}
					radarBarPNBP('#canvasReportPNBP2',aspek,ds,15);
					
				}
			});
			$.ajax({
				type 	: 'POST',
				data 	: {periode : periode, noind : noind},
				url 	: baseurl+'PNBP/Report/getNama',
				success : function(data){
					dat = JSON.parse(data);
					identity = dat[0];
					$('#labelPNBPReportNoind').text(identity['noind']);
					$('#labelPNBPReportNama').text(identity['nama']);
					$('#labelPNBPReportUsia').text(identity['usia']);
					$('#labelPNBPReportJenkel').text(identity['jenkel']);
					$('#labelPNBPReportSuku').text(identity['nama_suku']);
					$('#labelPNBPReportPendidikan').text(identity['pendidikan']);
					$('#labelPNBPReportDept').text(identity['department_name']);
					$('#labelPNBPReportSeksi').text(identity['section_name']);
					$('#labelPNBPReportStatus').text(identity['status_kerja']);
					$('#labelPNBPReportMasaKerja').text(identity['masa_kerja']);
					$('#labelPNBPReportKepuasan').text(identity['kepuasan']);
					$('#identitasPNBPReport').removeClass('hidden');
				}
			});
		}
		
	});
})


// report end