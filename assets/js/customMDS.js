//------------------------------------------------------------BOM MANAGEMENT------------------------------------------------------------------------
function getDataBom(th) {
	$(document).ready(function(){
		var kode = $('input[name="rootCode"]').val();
		console.log(kode);
		
		var request = $.ajax({
			url: baseurl+'MonitoringDeliverySparepart/BomManagement/GenerateBoM',
			data: {
				kode : kode
			},
			type: "POST",
			datatype: 'html'
		});
		$('#ResultBom').html('');
		$('#ResultBom').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
			
		request.done(function(result){
			$('#ResultBom').html(result);
		});
	});		
}

function haha(no, bom) {
	// alert('Tenane?');
	var btn 		= $('#btn'+bom).val();
	var compnum = $('#compnum'+bom).val();
	console.log(compnum);
	if (btn == 'trash') {
		$('.'+compnum).prop('disabled', true);
		$('#btn'+no).removeClass('text-red').addClass('');
		$('.'+compnum).css("backgroundColor", "#8c8c8c");
		$('#btn'+bom).val("restore");
	}else{
		$('.'+compnum).prop('disabled', false);
		$('#btn'+no).removeClass('').addClass('text-red');
		$('.'+compnum).css("backgroundColor", "#f1f1f1");
		$('#btn'+bom).val("trash");

	}
}

function cekIdentitasBom(th) {
	var version = $('#idBom').val();
	var root 		= $('#rootCode1').val();
	var request1 = $.ajax ({
        url : baseurl + "MonitoringDeliverySparepart/BomManagement/cekIdentitas",
        data: { root : root, version : version},
        type : "POST",
        dataType: "html"
		});

	request1.done(function(result){
	// console.log(result);
		$('#alert').html(result);
	});
}

$(document).ready(function () {
	$("#rootCode").select2({
			allowClear: true,
			placeholder: "component code",
			minimumInputLength: 3,
			ajax: {
					url: baseurl + "MonitoringDeliverySparepart/MonitoringManagement/getCompCode",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
									})
							};
					}
			}
	});
});


//-------------------------------------------------------MONITORING MANAGEMENT------------------------------------------------------------------

function saveMonMng(th) {
	var qty 		= $('input[name="qty[]"]').map(function(){return $(this).val();}).get();
	var tglTarget 		= $('input[name="tglTarget[]"]').map(function(){return $(this).val();}).get();
	var compCode 		= $('select[name="compCode"]').val();
	var comDesc 		= $('input[name="comDesc"]').val();
	var bomVer 		= $('select[name="bomVer"]').val();
	var periodeMon 		= $('input[name="periodeMon"]').val();
	console.log(compCode);
	$("#mdlloading").modal({
		backdrop: 'static',
		keyboard: true, 
		show: true
}); 
	$.ajax ({
		url : baseurl + "MonitoringDeliverySparepart/MonitoringManagement/saveMonMng",
		data: { qty : qty , tglTarget : tglTarget, compCode : compCode, comDesc : comDesc, bomVer : bomVer, periodeMon : periodeMon},
		type : "POST",
		dataType: "html",
		success: function(data){
			$("#mdlloading").modal("hide"); 
			window.location.reload();
	}
	});
}

$(document).ready(function () {
	$("#compCode").select2({
			allowClear: false,
			placeholder: "component code",
			minimumInputLength: 3,
			ajax: {
					url: baseurl + "MonitoringDeliverySparepart/MonitoringManagement/getCompCode",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.SEGMENT1, text:obj.SEGMENT1};
									})
							};
					}
			}
	});
});

function getCompCode(th){
	var par = $('select[name="compCode"]').val();
	console.log(par);

	$.ajax({
		url: baseurl + "MonitoringDeliverySparepart/MonitoringManagement/getDescCode",
		type: 'POST',
		dataType:'json',
		data: {par:par},
		beforeSend: function(){
		},
		success: function(result){
			console.log(result);
			$('#comDesc').val(result);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
		}
	});

	$("#bomVer").select2({
		allowClear: true,
		placeholder: "bom version",
		minimumInputLength: 0,
		ajax: {		
			url:baseurl+"MonitoringDeliverySparepart/MonitoringManagement/getBomVersion",
			dataType: 'json',
			type: "GET",
			data:  { par : par },
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.identitas_bom, text:obj.identitas_bom};
					})
				};
			}
		}
  });
}


var i = 2;
function addTargetMon() {
	$('#tambahTarget').append('<div class="tambahtarget" ><br><br><div class="col-md-2" align="right"></div><div class="col-md-3" > <input id="tglTarget'+i+'" name="tglTarget[]" class="form-control pull-right dateMonMng" placeholder="dd/mm/yyyy" onchange="cekTarget('+i+')" autocomplete="off" required><span id="alert'+i+'" style="font-size:11px; color:red"></span></div><div class="col-md-3" align="right"></div><div class="col-md-3" ><input id="qty" name="qty[]" class="form-control pull-right" placeholder="qty" autocomplete="off" required></div><div class="col-md-1"><button class = "btn btn-default tombolhapus'+i+'" type="button"><i class = "fa fa-minus" ></i></button></div><br></div></div>');
	$(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.tambahtarget').remove()
	});
	$('.dateMonMng').datepicker({
		format: 'dd M yyyy',
		todayHighlight: true,
		autoClose: true
	});
	i++; 
}

function cekTarget(no) {
	var periode = $('#periodeMon').val();
	var tgl 		= $('#tglTarget'+no).val();
	var request1 = $.ajax ({
        url : baseurl + "MonitoringDeliverySparepart/MonitoringManagement/cekTglTarget",
        data: { periode : periode, tgl : tgl},
        type : "POST",
        dataType: "html"
		});

	request1.done(function(result){
	// console.log(result);
		$('#alert'+no).html(result);
	});
}


//---------------------------------------------------------MONITORING----------------------------------------------------------------------------
function schMonitoring(th) {
	$(document).ready(function(){
		var periode = $('#period').val();
		var dept 		= $('#dept').val();
		console.log(periode);
		
		var request = $.ajax({
			url: baseurl+'MonitoringDeliverySparepart/Monitoring/searchData',
			data: {
				periode : periode, dept : dept
			},
			type: "POST",
			datatype: 'html'
		});
		$('#tb_monitoring').html('');
		$('#tb_monitoring').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
			
		request.done(function(result){
			$('#tb_monitoring').html(result);
		});
	});		
}

function saveQtyTarget2(no, idunix) {
	var qty 		= $('#qty'+no+idunix).val();
	var compnum = $('#compnum'+idunix).val();
	var root 		= $('#root'+idunix).val();
	var idBom 	= $('#idbom'+idunix).val();
	var version = $('#version'+idunix).val();
	console.log(root, idBom, compnum, version, qty, no);
	
	var save = $.ajax ({
		url : baseurl + "MonitoringDeliverySparepart/Monitoring/saveQtyTarget",
		data: { no : no , compnum : compnum, root : root, qty : qty, idBom : idBom, version : version, idunix : idunix},
		type : "POST",
		dataType: "html"
	});
}

function saveAktual(no, id1, id2) {
	var qty 		= $('#akt'+no+id2).val();
	var compnum = $('#compnum'+id2).val();
	var root 		= $('#root'+id2).val();
	var periode = $('#version'+id2).val();
	
	console.log(root, compnum, qty, no);
	$.ajax ({
    url : baseurl + "MonitoringDeliverySparepart/Monitoring/saveQtyAktual",
    data: { no : no , compnum : compnum, root : root, qty : qty, id1 : id1, periode : periode},
    type : "POST",
    dataType: "html"
  });
}

function terimaKomp(id1, id2, tgl, no) {
	var compnum = $('#compnum'+id2).val();
	var root 		= $('#root'+id2).val();
	var periode = $('#version'+id2).val();
	$('#btnterima'+id2+no).removeClass('text-red').addClass('text-green');
	$('#faterima'+id2+no).removeClass('fa-square-o').addClass('fa-check-square-o');
	$('.terima'+id2).removeClass('text-red').addClass('text-green');

		$.ajax ({
		  url : baseurl + "MonitoringDeliverySparepart/Monitoring/terimaKomponen",
		  data: { compnum : compnum, root : root, id1 : id1, periode : periode, tgl : tgl},
		  type : "POST",
		  dataType: "html"
		});

}

function ganti(id) {
	var tanda = $('#tanda'+id).val();
	var compnum = $('#compnum'+id).val();
	if (tanda == 'plus') {
		$('#icon'+id).removeClass('fa-plus').addClass('fa-minus');
		$('.'+compnum).removeClass('collapse in').addClass('collapse');
		$('#tanda'+id).val('minus');
	}else{
		$('#icon'+id).removeClass('fa-minus').addClass('fa-plus');
		$('.'+compnum).removeClass('collapse').addClass('collapse in');
		$('#tanda'+id).val('plus');
		$("."+compnum).find('input[name="tanda"]').val('minus');
		$("."+compnum).find('i[name="icon"]').removeClass('fa-plus').addClass('fa-minus');
	}
}

function getModalTerima(id1, id2) {
	var compnum = $('#compnum'+id2).val();
	var desc = $('#desc'+id2).val();
	var root = $('#root'+id2).val();

	var request = $.ajax({
			url: baseurl+'MonitoringDeliverySparepart/Monitoring/getModal',
			data: {
				compnum : compnum, root : root, id1 : id1, id2 : id2, desc : desc
			},
			type: "POST",
			datatype: 'html'
	});
	request.done(function(result){
			$('#tglaktual').html(result);
			$('#mdlaktual').modal('show');
	});
 
}

//-----------------------------------------------------------------USER MANAGEMENT----------------------------------------------------------------

function getSeksiDept(th){
	var par = $('#noInduk').val();
	console.log(par);

	$.ajax({
		url: baseurl + "MonitoringDeliverySparepart/UserManagement/getSeksi",
		type: 'POST',
		dataType:'json',
		data: {par:par},
		beforeSend: function(){
		},
		success: function(result){
			console.log(result);
			$('#seksiUser').val(result);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
		}
	});
}

$(document).ready(function () {
	$(".deptclassUser").select2({
			allowClear: true,
			placeholder: "department",
			minimumInputLength: 0,
			ajax: {
					url: baseurl + "MonitoringDeliverySparepart/UserManagement/getDept",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.DEPARTMENT_CLASS_CODE, text:obj.DEPARTMENT_CLASS_CODE};
									})
							};
					}
			}
	});
});

$(".formBom").keypress(function(e) {   //Enter key   
	if (e.which == 13) {     
			return false;   
	} });
