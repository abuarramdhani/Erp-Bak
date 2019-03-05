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
			},
			pointLabels: {
	            fontSize: 12,
	            fontStyle: '300',
	            fontColor: 'rgba(0, 0, 0, 1)',
	            fontFamily: "'Lato', sans-serif"
	        }
		},
		animation: {
			duration: 1,
			onComplete: function () {
			    // render the value of the chart above the bar
			    var ctx = this.chart.ctx;
			    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			    ctx.fillStyle = this.chart.config.options.defaultFontColor;
			    ctx.textAlign = 'center';
			    ctx.textBaseline = 'bottom';
			    this.data.datasets.forEach(function (dataset) {
			        for (var i = 0; i < dataset.data.length; i++) {
			            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
			            ctx.fillText(dataset.data[i], model.x, model.y - 5);
			        }
			    });
			}
		}
	}
})
}


$(document).ready(function(){

	$('#btnSubmitChartPNBP').on('click',function(){
		var periode = $('.selectPeriodeQuestionerPNBP').find(':selected').val();
		var dept 	= $('.selectPNBPDept').find(':selected').val();
		var sec 	= $('.selectPNBPSeksi').find(':selected').val();
		var masa  	= $('input[name="txtMasaKerja"]:checked').val();
		var jk 		= $('input[name="txtJenKel"]:checked').val();
		var usia 	= $('input[name="txtUsia"]:checked').val();
		var suku 	= $('.selectPNBPSuku').find(':selected').val();
		var status 	= $('.selectStatusJabatan').find(':selected').val();
		var pendidikan 	= $('.selectPendidikanAkhir').find(':selected').val();
		
		$('input[name="txtPeriodeHiddenPNBP"]').val(periode);
		$('input[name="txtSeksiHiddenPNBP"]').val(sec);
		$('input[name="txtDeptHiddenPNBP"]').val(dept);
		$('input[name="txtMasaKerjaHiddenPNBP"]').val(masa);
		$('input[name="txtJenkelHiddenPNBP"]').val(jk);
		$('input[name="txtUsiaHiddenPNBP"]').val(usia);
		$('input[name="txtSukuHiddenPNBP"]').val(suku);
		$('input[name="txtStatusHiddenPNBP"]').val(status);
		$('input[name="txtPendidikanHiddenPNBP"]').val(pendidikan);

		$('#chartBig').html('');
		$('#chartBig').html('<canvas id="canvasReportPNBP"></canvas>');
		$('#chartSmall1').html('');
		$('#chartSmall1').html('<canvas id="canvasReportPNBP1"></canvas>');
		$('#chartSmall2').html('');
		$('#chartSmall2').html('<canvas id="canvasReportPNBP2"></canvas>');
		$.ajax({
			type 	: 'POST',
			data 	: {periode : periode, dept : dept, sec : sec, masa : masa, jk : jk, usia : usia, suku : suku, status : status, pendidikan : pendidikan},
			url 	: baseurl+'PNBP/Report/getData',
			success : function(data){
				var obj = JSON.parse(data);
				var aspek = [];
				var ds = [];
				ds = [{
					data : [],
					borderColor : '#e91e63',
					backgroundColor : 'transparent',
					pointBackgroundColor : '#f50057',
					label : 'Kelompok 2'
				},
				{
					data : [],
					borderColor : '#e91e63',
					backgroundColor : 'transparent',
					pointBackgroundColor : '#f50057',
					label : 'Kelompok 2'
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
			data 	: {periode : periode, dept : dept, sec : sec, masa : masa, jk : jk, usia : usia, suku : suku, status : status, pendidikan : pendidikan},
			url 	: baseurl+'PNBP/Report/getKepuasan',
			success : function(data){
				var dt = JSON.parse(data);
				
				$('#PNBPKepuasanRata').text(dt['0']['rata']);
				$('#PNBPKepuasanPersen').text(dt['0']['persen']);

				var partisipan 	= 'Jumlah Partisipan : ';
				$('#PNBPPartisipan').text(partisipan+dt['0']['peserta']);
				
				

				var tarik		= 'Periode Penarikan Data : ';
				var prd 		= $('.selectPeriodeQuestionerPNBP').find(':selected').text();
				$('#PNBPPeriodePenarikan').text(tarik+prd);

				var pilih 		= 'Sorted By : ';
				var textPilih 	= "<table>";
				var deptName 	= $('.selectPNBPDept').find(':selected').text();
				if (deptName !== "") {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Departemen</td><td>:</td><td style='padding-left:10px'>"+deptName+"</td></tr>";
				}
				var secName 	= $('.selectPNBPSeksi').find(':selected').text();
				if (secName !== "") {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Seksi/Unit</td><td>:</td><td style='padding-left:10px'>"+secName+"</td></tr>";
				}
				var masa  	= $('input[name="txtMasaKerja"]:checked').val();
				if (masa == '1') {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Masa Kerja</td><td>:</td><td style='padding-left:10px'>< 1 Tahun"+"</td></tr>";
				}else if(masa == '2'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Masa Kerja</td><td>:</td><td style='padding-left:10px'>1-3 Tahun"+"</td></tr>";
				}else if(masa == '3'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Masa Kerja</td><td>:</td><td style='padding-left:10px'>4-6 Tahun"+"</td></tr>";
				}else if(masa == '4'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Masa Kerja</td><td>:</td><td style='padding-left:10px'>> 6 Tahun"+"</td></tr>";
				}
				var jk 		= $('input[name="txtJenKel"]:checked').val();
				if (jk == 'L') {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Jenis Kelamin</td><td>:</td><td style='padding-left:10px'>Laki-Laki"+"</td></tr>";
				}else if(jk == 'P'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Jenis Kelamin</td><td>:</td><td style='padding-left:10px'>Perempuan"+"</td></tr>";
				}
				var usia 	= $('input[name="txtUsia"]:checked').val();
				if (usia == '1'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Usia</td><td>:</td><td style='padding-left:10px'><20 Tahun"+"</td></tr>";
				}else if(usia == '2'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Usia</td><td>:</td><td style='padding-left:10px'>20-29 Tahun"+"</td></tr>";
				}else if(usia == '3'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Usia</td><td>:</td><td style='padding-left:10px'>30-39 Tahun"+"</td></tr>";
				}else if(usia == '4'){
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Usia</td><td>:</td><td style='padding-left:10px'>≥40 Tahun"+"</td></tr>";
				}
				var sukuName 	= $('.selectPNBPSuku').find(':selected').text();
				if (sukuName !== "") {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Suku</td><td>:</td><td style='padding-left:10px'>"+sukuName+"</td></tr>";
				}
				var status 	= $('.selectStatusJabatan').find(':selected').text();
				if (status !== "") {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Status Kerja</td><td>:</td><td style='padding-left:10px'>"+status+"</td></tr>";
				}
				var pendidikanName 	= $('.selectPendidikanAkhir').find(':selected').text();
				if (pendidikanName !== "") {
					textPilih += "<tr><td class='text-right' style='padding-right:10px'>Pendidikan Terakhir</td><td>:</td><td style='padding-left:10px'>"+pendidikanName+"</td></tr>";
				}
				textPilih += "</table>";
				$('#PNBPPilih').html(pilih+textPilih);
			}
		});	
		$('.PNBPHiddenReport').attr('hidden',false);

			
	});
})

function reportPNBP(){
	html2canvas(document.getElementById('canvasReportPNBP'),{scale : 2}).then(function(canvas){
		var imgData = canvas.toDataURL('image/png',1.0);
		$('input[name="imgChartPNBP"]').val(imgData);
		$('#SubmitReportPNBP').click();
	});
	
}
	
// report end




// start questioner administrator

$(document).ready(function(){
	
	$('.selectPNBPSeksi').select2({
		placeholder: "Seksi / Unit",
		searching: true,
		minimumInputLength: 0,
		allowClear: true,
		ajax:
		{
			url: baseurl+'PNBP/QuestionerAdmin/getSection',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term,
					kd : $('.selectPNBPDept').find(':selected').val()
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.section_code, text: obj.section_name+" / "+obj.unit_name};
					})
				}
			}
		}
	});

	$('.selectStatusJabatan').select2({
		placeholder: "Status Kerja",
		searching: true,
		minimumInputLength: 0,
		allowClear: true,
		ajax:
		{
			url: baseurl+'PNBP/QuestionerAdmin/getStatusKerja',
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
						return {id: obj.jabatan, text: obj.jabatan};
					})
				}
			}
		}
	});
});

// end questioner administrator
