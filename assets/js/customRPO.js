function getHistory(th) {
	$(document).ready(function(){
		var datefrom = $('input[name="datefrom"]').val();
		var dateto = $('input[name="dateto"]').val();
		
		var request = $.ajax({
			url: baseurl+'ReceivePO/History/Hist/',
			data: {
			    datefrom,datefrom,
			    dateto,dateto
			},
			type: "POST",
			datatype: 'html'
		});
		
		
			$('#hasil').html('');
			// $('#hasil').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
			

		request.done(function(result){
			// console.log("sukses2");
			$('#hasil').html(result);
				$('#uwuuwu').DataTable({
					scrollX: false,
					scrollY:  300,
					scrollCollapse: true,
					paging:false,
                    info:false,
                    searching : false,
				});
			});
		});		
}

function Detail(no) {
	$(document).ready(function(){
		var buttonpo = $('#buttonpo'+no).val(); 
		var suratjalan = $('#suratjalan'+no).val();	
		var request = $.ajax({
			url: baseurl+'ReceivePO/History/Detail/',
			data: {
			    buttonpo : buttonpo,
			    suratjalan : suratjalan
			},
			type: "POST",
			datatype: 'html'
		});
		
		
			$('#detail').html('');
			

		request.done(function(result){
			// console.log("sukses2");
			$('#detail').html(result);
				$('#detaillist').DataTable({
					scrollX: false,
					scrollY:  145,
					scrollCollapse: true,
					paging:false,
                    info:false,
                    searching : false,
				});
			});
		});		
}

$(document).ready(function() {
	$('.tanggalan').datepicker({
	    format: 'dd/M/yyyy'
	});
});

function intine(th, no)
{ 	
	var title = $(th).text(); 	
	$('#detailll'+no).slideToggle('slow'); 
}

function CetakKartu(no) {
	$(document).ready(function(){

		var descrecipt = $('#descrecipt'+no).val(); 	
		var itemrecipt = $('#itemrecipt'+no).val(); 	
		var ket = $('#Ket').val(); 	

		// var serial = $('input[name="serial[]"]').val();

		var serial = [];
			 $('input[name="serial'+no+'"]').each(function(){
			serial.push($(this).val());
			});


		var request = $.ajax({
			url: baseurl+'ReceivePO/History/CetakKartu/',
			data: {
				descrecipt:descrecipt,
				itemrecipt:itemrecipt,
			    serial:serial,
			    ket:ket
			},
			type: "POST",
			// datatype: 'json'
		});
			
		request.done(function(result){
			console.log(result)
			var win = window.open(result, '_blank');
  			win.focus()
			console.log("sukses2");
				
			});
		});		
}