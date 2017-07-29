//$(document).ready(function(){
	var table_group = $('#im-data-table-group').DataTable({
		"dom": '<"pull-left"f>tip',
		"info": false,
		"displayLength": 10,
		language: {
			search: "Search : ",
		},
		"columnDefs": [
			{ "visible": false, "targets": 2 }
		],
		"order": [[ 2, 'asc' ]],
		"drawCallback": function ( settings ) {
			var api = this.api();
			var rows = api.rows( {page:'current'} ).nodes();
			var last=null;
 
			api.column(2, {page:'current'} ).data().each( function ( group, i ) {
				if ( last !== group ) {
					$(rows).eq( i ).before(
						'<tr class="group"><td colspan="4">'+group+'</td></tr>'
					);
 
					last = group;
				}
			} );
		}
	});

	$('#im-data-table-group tbody').on( 'click', 'tr.group', function () {
		var currentOrder = table_group.order()[0];
		if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
			table_group.order( [ 2, 'desc' ] ).draw();
		}
		else {
			table_group.order( [ 2, 'asc' ] ).draw();
		}
	} );


	var table_ignore_last = $('#im-data-table-ignore-last').DataTable({
		"dom": '<"pull-left"f>tip',
		"info": false,
		language: {
			search: "Search : ",
		},
		"columnDefs": [
			{
				"targets": [ -1 ],
				"searchable": false,
				"orderable": false,
			}
		],
	});

	data_table();
	function data_table(){
		var table = $('#im-data-table, .im-data-table').DataTable({
			destroy: true,
			"dom": '<"pull-left"f>tip',
			"info": false,
			language: {
				search: "Search : ",
			},
		});

		$('.dataTables_filter input[type="search"]').css(
			{'width':'400px','display':'inline-block'}
		);
	}

	checkBox();
	var rows = table_ignore_last.rows({ 'search': 'applied' }).nodes();
	function checkBox(){
		var rows = table_ignore_last.rows({ 'search': 'applied' }).nodes();
		if ($('input[name="txt_data_status[]"]:checked', rows).length > 0)
		{
			$('#update-status-btn').prop('disabled', false);
		}
		else
		{
			$('input[name="check_all"]').prop('checked', false);
			$('#update-status-btn').prop('disabled', true);
		}

		if ($('input[name="txt_data_status[]"]', rows).length > $('input[name="txt_data_status[]"]:checked', rows).length)
		{
			$('input[name="check_all"]').prop('checked', false);
		}
		else{
			$('input[name="check_all"]').prop('checked', true);
		}
	}

	$('input[name="txt_data_status[]"]', rows).change(function(){
		checkBox();
	});

	$('input[name="check_all"]').on('change', function(){
		$('input[name="txt_data_status[]"]', rows).prop('checked', this.checked);

		checkBox();
	});

	$('#form-status').on('submit', function(e){
		var form = this;
		table_ignore_last.$('input[type="checkbox"]').each(function(){
			if(!$.contains(document, this)){
				if(this.checked){
					$(form).append(
						$('<input>')
							.attr('type', 'hidden')
							.attr('name', this.name)
							.val(this.value)
					);
				}
			} 
		});
	});
//});

im_datepicker();
function im_datepicker(){
	$(document).ready(function() {
		$('.im-datepicker').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM'
				},
		});
	});
}


select2_IM();
function select2_IM(){
	$(document).ready(function() {
		$('.select2').select2({
			allowClear : true,
			placeholder : $(this).data('placeholder')
		});
	});
}

checkbox_peringatan();
function checkbox_peringatan(){
	$('#chkPeringatan').on('change', function(){
		if (this.checked) {
			$('#peringatan').show();
			$('select[name="txt_satuan_peringatan"]').prop('required', true);
			$('input[name="txt_interval_peringatan"]').prop('required', true);
		}
		else{
			$('#peringatan').hide();
			$('select[name="txt_satuan_peringatan"]').select2("val", "");
			$('select[name="txt_satuan_peringatan"]').prop('required', false);
			$('input[name="txt_interval_peringatan"]').val("");
			$('input[name="txt_interval_peringatan"]').prop('required', false);
		}
	});
}

function update_item(id){
	$('#update-form').html('');
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{kode_barang:id},
		url: baseurl+"ItemManagement/MasterItem/edit",
		success:function(result)
		{
			$('#loading').html('');
			$('#update-form').html(result);
			select2_IM();
			checkbox_peringatan();
		},
		error:function()
		{
			$('#loading').html('');
			$('#update-form').html("<center><h1>Error Ocurred When Getting Data!</h1></center>");
		}
	});
}

function detail_kebutuhan(kd_std,kd_sie,kd_pekerjaan){
	$('#update-form').html('');
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{kd_std:kd_std, kd_sie:kd_sie, kd_pekerjaan:kd_pekerjaan},
		url: baseurl+"ItemManagement/SetupKebutuhan/Kodesie/detail",
		success:function(result)
		{
			$('#loading').html('');
			$('#update-form').html(result);
			data_table();
		},
		error:function()
		{
			$('#loading').html('');
			$('#update-form').html("<center><h1>Error Ocurred When Getting Data!</h1></center>");
		}
	});
}

function detail_kebutuhan_indv(kd_std,kd_sie,noind){
	$('#update-form').html('');
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{kd_std:kd_std, kd_sie:kd_sie, noind:noind},
		url: baseurl+"ItemManagement/SetupKebutuhan/Individu/detail",
		success:function(result)
		{
			$('#loading').html('');
			$('#update-form').html(result);
			data_table();
		},
		error:function()
		{
			$('#loading').html('');
			$('#update-form').html("<center><h1>Error Ocurred When Getting Data!</h1></center>");
		}
	});
}

function detail_monitoring_kebutuhan(periode,kd_sie){
	$('#update-form').html('');
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{periode:periode, kd_sie:kd_sie},
		url: baseurl+"ItemManagement/Hitung/MonitoringKebutuhan/detail",
		success:function(result)
		{
			$('#loading').html('');
			$('#update-form').html(result);
			data_table();
		},
		error:function()
		{
			$('#loading').html('');
			$('#update-form').html("<center><h1>Error Ocurred When Getting Data!</h1></center>");
		}
	});
}

function delete_item(id){
	$('#delete_btn').attr('href', baseurl + 'ItemManagement/MasterItem/delete/' + id);
}

function delete_kebutuhan(kd_std,kd_sie,kd_pekerjaan){
	$('#delete_btn').attr('href', baseurl + 'ItemManagement/SetupKebutuhan/Kodesie/delete/' + kd_std + '/' + kd_sie + '/' + kd_pekerjaan);
}

function delete_kebutuhan_indv(kd_std,kd_sie,noind){
	$('#delete_btn').attr('href', baseurl + 'ItemManagement/SetupKebutuhan/Individu/delete/' + kd_std + '/' + kd_sie + '/' + noind);
}

function delete_jumlah_pekerja(id){
	$('#delete_btn').attr('href', baseurl + 'ItemManagement/User/InputPekerja/delete/' + id);
}

function addNewForm(){
	var new_form = $('<div>').addClass('form-clone');
	var e = jQuery.Event( "click" );
	e.preventDefault();
	$(".form-clone:last .slcKodeBrg:last").select2("destroy");
	$(".form-clone:last .slcBonItem:last").select2("destroy");
	$(".form-clone:last .slcKodePkj:last").select2("destroy");
	if ($('.add-col').length) {
		$('.add-col').before($('.form-clone').last().clone());
	}
	else{
		$('.form-clone').last().clone().appendTo(new_form).appendTo('#multiple-form');
	}
	$(".form-clone:last .form-control").val("").change();
	$(".form-clone:last .periode-selesai:last").val("9999-12").change();
	kode_barang();
	getDetail();
	im_datepicker();
	getItem();
	getBatasBon();
	KodePekerjaan_detail();
}

$("#multiple-form").delegate(".delete-form", "click", function(){
	var formCount = $("#multiple-form .form-clone").size();
	if(formCount <= 1){
		$(".flyover-top .alert-text").text("Minimal Harus ada 1 Form!");
		$(".flyover-top").addClass("in");
		setTimeout(function(){
			$(".flyover-top").removeClass("in");
		}, 5000);
	}
	else{
		$(this).closest('.form-clone').remove();
	}
});

kode_barang();
function kode_barang(){
	$(document).ready(function() {
		$('.slcKodeBrg').select2({
			placeholder : $(this).data('placeholder'),
			allowClear : true,
			minimumInputLength: 0,
			ajax: {		
				url: baseurl + "ItemManagement/SetupKebutuhan/getKodeBarang",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.kode_barang, text:obj.kode_barang + ' - ' + obj.detail};
						})
					};
				}
			}
		});
	});
}

getDetail();
function getDetail(){
	$('.slcKodeBrg').change(function(){
		var slc = $(this);
		var value = slc.val();
		$.ajax({
			type:'GET',
			data:{kode_barang:value, modul:'nama'},
			url: baseurl+"ItemManagement/SetupKebutuhan/getDetail",
			success:function(result)
			{
				slc.closest('div.form-clone').find('input.nama-barang').val(result);
			}
		});

		/*
		$.ajax({
			type:'GET',
			data:{kode_barang:value, modul:'stok'},
			url: baseurl+"ItemManagement/SetupKebutuhan/getDetail",
			success:function(result)
			{
				slc.closest('div.form-clone').find('input.jumlah-barang').val(result);
				slc.closest('div.form-clone').find('input.jumlah-barang').attr("max",result);
			}
		});
		*/
	});
}

getItem();
function getItem(){
	$(document).ready(function() {
		$('.slcBonItem').select2({
			placeholder : $(this).data('placeholder'),
			allowClear : true,
			minimumInputLength: 0,
			ajax: {		
				url: baseurl + "ItemManagement/User/MonitoringBon/getItem",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						periode: $('input[name="txt_periode"]').val(),
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.kode_barang, text:obj.kode_barang + ' - ' + obj.detail};
						})
					};
				}
			}
		});
	});
}

getBatasBon();
function getBatasBon(){
	$('.slcBonItem').change(function(){
		var slc = $(this);
		var value = slc.val();
		var seksi = $('input[name="txt_kodesie"]').val();
		var tgl = $('input[name="txt_periode"]').val();
		$.ajax({
			type:'GET',
			data:{kode_barang:value, kodesie: seksi, periode: tgl},
			url: baseurl+"ItemManagement/User/MonitoringBon/getBonDetail",
			success:function(result)
			{
				slc.closest('.form-clone').find('.jumlah-bon').val(result);
				slc.closest('.form-clone').find('.jumlah-bon').attr("max",result);
			}
		});

		$.ajax({
			type:'GET',
			data:{kode_barang:value, modul: 'nama'},
			url: baseurl+"ItemManagement/SetupKebutuhan/getDetail",
			success:function(result)
			{
				slc.closest('.form-clone').find('.item-details').val(value + ' - ' + result);
			}
		});
	});
}

$(document).ready(function() {
	$('#slcKodesie').select2({
		placeholder : $(this).data('placeholder'),
		allowClear : true,
		minimumInputLength: 0,
		ajax: {		
			url: baseurl + "ItemManagement/SetupKebutuhan/getSeksi",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.kodesie, text:obj.kodesie + ' - ' + obj.seksi};
					})
				};
			}
		}
	});

	$('#slcKodesie').change(function(){
		var value = $(this).val();
		console.log(value);
		if (value != null && value != '') {
			$('#save-btn').prop("disabled", false);

			$('#slcKodePkj').prop("disabled", false);
			$('#slcKodePkj').select2("val", "");
			$('#slcKodePkj').select2("data", null);
			$.ajax({
				type:'GET',
				data:{term:value},
				url:baseurl+"ItemManagement/SetupKebutuhan/getKodePekerjaan",
				success:function(result)
				{
					$('#slcKodePkj').html(result);
				}
			});

			$('#slcNoInduk').prop("disabled", false);
			$('#slcNoInduk').select2("val", "");
			$('#slcNoInduk').select2("data", null);
			$.ajax({
				type:'GET',
				data:{term:value},
				url:baseurl+"ItemManagement/SetupKebutuhan/getNoInduk",
				success:function(result)
				{
					$('#slcNoInduk').html(result);
				}
			});
		}
		else{
			$('#slcKodePkj').select2("val", "");
			$('#slcKodePkj').select2("data", null);
			$('#slcKodePkj').prop("disabled", true);
			
			$('#slcNoInduk').select2("val", "");
			$('#slcNoInduk').select2("data", null);
			$('#slcNoInduk').prop("disabled", true);

			$('#save-btn').prop("disabled", true);
		}
	});

	$('#slcKodePkj').select2({
		placeholder : $(this).data('placeholder'),
		allowClear : true,
	});

	$('#slcNoInduk').select2({
		placeholder : $(this).data('placeholder'),
		allowClear : true,
	});
});

$("#save-button").click(function(){
	$('.preview-body').html('');
	$("#kode_blanko_text").text($('input[name="txt_kode_blanko"').val());
	$("#tgl_text").text($('input[name="txt_periode"').val());
	$("#kodesie_text").text($('input[name="txt_kodesie"').val());

	var item_code = $('input[name="txt_item_detail[]"');
	var item_jumlah = $('input[name="txt_jumlah[]"');
	var mapped_item_code = item_code.map(function(){return $(this).val();});
	var mapped_item_jumlah = item_jumlah.map(function(){return $(this).val();});
	for (var i = 0; i < mapped_item_code.length; i++) {
		var jumlah = mapped_item_jumlah[i];
		if (jumlah == '') {
			jumlah = '0';
		}
		else{
			jumlah = jumlah;
		}

		var item_rows = '<tr><td>' + mapped_item_code[i] + '</td><td align="center"> ' + jumlah + '</td></tr>';
		$('.preview-body').append(item_rows);
	}
});

KodePekerjaan_detail();
function KodePekerjaan_detail(){
	$(document).ready(function() {
		$('.slcKodePkj').select2({
			placeholder : $(this).data('placeholder'),
			allowClear : true,
			ajax: {		
				url: baseurl + "ItemManagement/User/InputPekerja/getKodePekerjaan",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.kdpekerjaan, text:obj.kdpekerjaan + ' - ' + obj.pekerjaan};
						})
					};
				}
			}
		});
	});
}

$("#btn-hitung-kebutuhan").click(function(){
	$('#submit-kebutuhan').prop("disabled",true);
	$('#hitung-kebutuhan').html('');
	$('#summary-kebutuhan').html('');
	$('input[name="txt_modul"]').val('detail');
	$('#calculating').html('<img src="' + baseurl + 'assets/img/gif/loading3.gif" width="32px">');
	$.ajax({
		type:'POST',
		data:$("#form-hitung-kebutuhan").serialize(),
		url: baseurl+"ItemManagement/Hitung/HitungKebutuhan/calculate",
		success:function(result)
		{
			$('#hitung-kebutuhan').html(result);
			$('input[name="txt_modul"]').val('summary');
			$.ajax({
				type:'POST',
				data:$("#form-hitung-kebutuhan").serialize(),
				url: baseurl+"ItemManagement/Hitung/HitungKebutuhan/calculate",
				success:function(result)
				{
					$('#summary-kebutuhan').html(result);
					$('#calculating').html('');
					if (result != '') {
						$('#submit-kebutuhan').prop("disabled",false);
					}
					else{
						$('#submit-kebutuhan').prop("disabled",true);
					}
				}
			});
		},
		error: function()
		{
			$('#calculating').html('');
			$('#submit-kebutuhan').prop("disabled",true);
		}
	});
});

$('#date-filter').change(function(){
	var input = $(this);
	$('#table-wrapper').html('');
	$('#loading').html('<img src="' + baseurl + 'assets/img/gif/loading3.gif" width="32px">');
	var value = input.val();
	$.ajax({
		type:'GET',
		data:{periode:value},
		url: baseurl+"ItemManagement/User/MonitoringBon/filterPeriode",
		success:function(result)
		{
			$('#loading').html('');
			$('#table-wrapper').html(result);
		},
		error:function(){
			$('#loading').html('');
			$('#table-wrapper').html('');
			$('#export').prop("disabled",true);
		}
	});
});

