
//Input Data Component Pusat
auto_complete_all();
function auto_complete_all(){
	$(".io_name").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/io_name',
		appendTo: '.io_name_list'
	});

	$(".sub_inventory").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/sub_inventory',
		appendTo: '.sub_inventory_list'
	});

	$(".area").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/area',
		appendTo: '.area_list'
	});

	$(".locator").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/locator',
		appendTo: '.locator_list'
	});

	$(".saving_place").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/saving_place',
		appendTo: '.saving_place_list'
	});

	$(".cost_center").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/cost_center',
		appendTo: '.cost_center_list'
	});

	$(".type").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/type',
		appendTo: '.type_list'
	});

	$(".uom").autocomplete({
		serviceUrl: baseurl + 'StockControl/stock-opname-pusat/autocomplete/uom',
		appendTo: '.uom_list'
	});

	$(document).ready(function(){
		$('.autocomplete-suggestions').removeAttr("style");
	});
}

function update_component(id){
	$('#update-form').html('');
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{master_data_id:id},
		url: baseurl+"StockControl/stock-opname-pusat/edit_component",
		success:function(result)
		{
			$('#loading').html('');
			$('#update-form').html(result);
			auto_complete_all();
		},
		error:function()
		{
			$('#loading').html('');
			$('#update-form').html("Error While Get Data!");
		}
	});
}

$('.tgl-so').daterangepicker({
	"singleDatePicker": true,
	"timePicker": false,
	"timePicker24Hour": true,
	"showDropdowns": false,
	"locale": {
		"format": 'DD MMMM YYYY',
		"monthNames": [
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"November",
			"Desember"
		],
	},
})

stock_opname_pusat();
function stock_opname_pusat(){
	$('#stock-opname-pusat').DataTable({
		"scrollY": "620px",
		scrollCollapse: true,
		"lengthChange": false,
		"dom": '<"pull-left"f>t',
		"paging": false,
		"info": false,
		language: {
			search: "_INPUT_",
		},
	});
	$('#stock-opname-pusat_filter input[type="search"]').css(
		{'width':'400px','display':'inline-block'}
	);
	$('#stock-opname-pusat_filter input').attr("placeholder", "Search...")
}

$("select[name='txt_locator']").change(function(){
	var data = $(this).val();
	if (data != '') {
		$("#show-result").prop("disabled", false);
		$(".btn-submit").prop("disabled",false);
	}
	else{
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
	}
});

$("select[name='txt_area_pusat']").change(function(){
	var data = $(this).val();
	if (data != '') {
		$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
		$("select[name='txt_locator']").prop("disabled", false);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
		var data2 = "locator";
		$.ajax({
			type: "GET",
			url:baseurl+"StockControl/stock-opname-pusat/getFilterData",
			data:{modul: data2, value: data},
			success:function(result)
			{
				$("select[name='txt_locator']").html(result);
				$("#loadingImage").html('');
			},
			error:function()
			{
				$("#loadingImage").html('');
				alert('Something Error');
			}
		});
	}
	else{
		$("select[name='txt_locator']").prop("disabled", true);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
	}
});

$("select[name='txt_sub_inventory']").change(function(){
	var data = $(this).val();
	if (data != '') {
		$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
		$("select[name='txt_area_pusat']").prop("disabled", false);
		$("select[name='txt_area_pusat']").select2("val", "");
		$("select[name='txt_area_pusat']").select2("data", null);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("select[name='txt_locator']").prop("disabled", true);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
		var data2 = "area";
		$.ajax({
			type: "GET",
			url:baseurl+"StockControl/stock-opname-pusat/getFilterData",
			data:{modul: data2, value: data},
			success:function(result)
			{
				$("select[name='txt_area_pusat']").html(result);
				$("#loadingImage").html('');
			},
			error:function()
			{
				$("#loadingImage").html('');
				alert('Something Error');
			}
		});
	}
	else{
		$("select[name='txt_area_pusat']").prop("disabled", true);
		$("select[name='txt_area_pusat']").select2("val", "");
		$("select[name='txt_area_pusat']").select2("data", null);
		$("select[name='txt_locator']").prop("disabled", true);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
	}
});

$("select[name='txt_io_name']").change(function(){
	var data = $(this).val();
	if (data != '') {
		$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
		$("select[name='txt_sub_inventory']").prop("disabled", false);
		$("select[name='txt_sub_inventory']").select2("val", "");
		$("select[name='txt_sub_inventory']").select2("data", null);
		$("select[name='txt_area_pusat']").prop("disabled", true);
		$("select[name='txt_area_pusat']").select2("val", "");
		$("select[name='txt_area_pusat']").select2("data", null);
		$("select[name='txt_locator']").prop("disabled", true);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
		var data2 = "sub_inventory";
		$.ajax({
			type: "GET",
			url:baseurl+"StockControl/stock-opname-pusat/getFilterData",
			data:{modul: data2, value: data},
			success:function(result)
			{
				$("select[name='txt_sub_inventory']").html(result);
				$("#loadingImage").html('');
			},
			error:function()
			{
				$("#loadingImage").html('');
				alert('Something Error');
			}
		});
	}
	else{
		$("select[name='txt_sub_inventory']").prop("disabled", true);
		$("select[name='txt_sub_inventory']").select2("val", "");
		$("select[name='txt_sub_inventory']").select2("data", null);
		$("select[name='txt_area_pusat']").prop("disabled", true);
		$("select[name='txt_area_pusat']").select2("val", "");
		$("select[name='txt_area_pusat']").select2("data", null);
		$("select[name='txt_locator']").prop("disabled", true);
		$("select[name='txt_locator']").select2("val", "");
		$("select[name='txt_locator']").select2("data", null);
		$("#show-result").prop("disabled", true);
		$(".btn-submit").prop("disabled",true);
	}
});

$("#filter-form").submit(function(){
	$(".btn-submit").prop("disabled",true);
});

function submit_export(url){
	$("#filter-form").attr('action', url);
	$("#filter-form").submit();
}

$("#show-result").click(function(){
	$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
	var form = $('#filter-form-pusat');
	var data = $('#filter-form-pusat').serialize();
	$.ajax({
		type: "POST",
		url:baseurl+"StockControl/stock-opname-pusat/getData",
		data:data,
		success:function(result)
		{
			$("#table-full").html(result);
			$("#loadingImage").html('');
			stock_opname_pusat();
		},
		error:function()
		{
			$("#loadingImage").html('');
			alert('Something Error');
		}
	});
});