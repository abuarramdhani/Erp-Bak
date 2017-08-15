$(document).ready(function() {
		$('#table_casting').DataTable({
          "paging": false,
          "lengthChange": true,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": true,
		});		

		$(".select-2").select2({
			allowClear: true,
		});

		$('.format_money').maskMoney({prefix:'Rp ', thousands:',', decimal:'.',suffix:'/jam',symbolStay:0});
		$('.format_number').maskMoney({thousands:',',decimal:'.'});
});



$('#berat_casting,#berat_cairan').change(function(){
	var cairan = $('input#berat_cairan').val();
	var casting = $('input#berat_casting').val();
	var remelt = ((cairan*100000) - (casting*100000))/100000
	var ycast = (casting/cairan)*100;
	var yiedl = ycast.toFixed(1);

		$('input#berat_remelt').val(remelt);
		$('input#yield_casting').val(yiedl);
	});

$('#target_pieces , #cavity_flask').change(function(){
	var pieces = $('input#target_pieces').val()
	var cavity = $('input#cavity_flask').val()
	var tcs = pieces / cavity;
	
		$('input#target_flask').val(tcs);
})

$('.core_fiedl').change(function(){
	var choosen = $('input[name="core_input"]:checked').val()
		if (choosen == 'yes') {
			$('#fiedl_core').show()
		}
		else{
			$('#fiedl_core').hide()
		}
});


function save_cost(e, t){

		var resource = $(t).closest('tr').find('input[name="resource_machine"]').val();
		var val_cost = $(t).val();
		var cost = val_cost.replace(',','').replace(',','').replace('/jam','').replace('Rp ','');
		if (cost == '') {
			cost = '0';
		}

		$.ajax({
		     type : 'POST',
		     url : baseurl+"CastingCost/edit/savecostmachine",
		     data : {
		     	resource : resource,
		     	cost : cost,
		     },
		     success: function(result){
		     	alert ('edit berhasil!');
		 	},
		 	error: function(){
		 		alert('terjadi kesalahan');
		 	}
		 })
}

function save_cost2(e, t){

		var resource = $(t).closest('tr').find('input[name="resource_electric"]').val();
		var val_cost = $(t).val();
		var cost 	 = val_cost.replace(',','').replace(',','').replace('/jam','').replace('Rp ','');
		if (cost == '') {
			cost = '0';
		}

		$.ajax({
		     type : 'POST',
		     url : baseurl+"CastingCost/edit/savecostelectric",
		     data : {
		     	resource : resource,
		     	cost : cost,
		     },
		     success: function(result){
		     	alert ('edit berhasil!');
		 	},
		 	error: function(){
		 		alert('terjadi kesalahan');
		 	}
		 })
}

function addCommass(e, th) {
    var value_input = $(th).val();
    value_input += '';
    x = value_input.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return $(th).val(x1 + x2);
}


/*$('#basic_tonage').change(function(){
	var basic = $('#basic_tonage').val();
	basic += '';
    x = basic.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return $('#basic_tonage').val(x1 + x2);
});

$('#target_pieces').change(function(){
	var basic = $('#target_pieces').val();
	basic += '';
    x = basic.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return $('#target_pieces').val(x1 + x2);
})*/