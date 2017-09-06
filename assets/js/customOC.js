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
	var remelt = ((cairan*1000) - (casting*1000))/1000;
	var ycast = (casting/cairan)*100;
	var yiedl = ycast.toFixed(1);

		$('input#berat_remelt').val(remelt.toFixed(2));
		$('input#yield_casting').val(yiedl);
	});

$('#target_pieces , #cavity_flask').change(function(){
	var pieces = $('input#target_pieces').val().replace(/,/g , "");
	var cavity = $('input#cavity_flask').val().replace(/,/g , "");
	var tcs = pieces / cavity;
	
		$('input#target_flask').val(tcs);
})

$('.core_fiedl').change(function(){
	var choosen = $('input[name="core_input"]:checked').val();
		if (choosen == 'yes') {
			$('#fiedl_core').show();
		}
		else{
			$('#fiedl_core').hide();
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
    return $(th).val(value_input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

$('.number-format').change(function(){
	var val = $(this).val();
	var valNumber = Number(val);
	$(this).val(valNumber);
});