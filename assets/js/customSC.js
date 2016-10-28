
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
	$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading3.gif" width="64px"/>');
	$.ajax({
		type:'POST',
		data:{master_data_id:id},
		url: baseurl+"StockControl/stock-opname-pusat/edit_component",
		success:function(result)
		{
			$('#loading').html();
			$('#update-form').html(result);
			auto_complete_all();
		},
		error:function()
		{
			$('#loading').html();
			$('#update-form').html("Error While Get Data!");
		}
	});
}