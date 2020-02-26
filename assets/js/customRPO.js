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
					scrollY:  400,
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
					scrollY:  100,
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

		var ket = $('#keterangandong').val();
		if (ket == '') {
			Swal.fire(
			  'Mohon Isikan keterangan',
			  '',
			  'warning'
			)
		} else if (ket != '') {

		var descrecipt = $('#descrecipt'+no).val(); 	
		var itemrecipt = $('#itemrecipt'+no).val(); 

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
			console.log(ket)

				
			});
	}
}

// -------------------------------------------------------------------------- DELIVER -------------------------------------------------------------------- //

function getPO(th) {
	$(document).ready(function(){
		var lppbno = $('input[name="lppbno"]').val();
		
		var request = $.ajax({
			url: baseurl+'ReceivePO/Deliver/getPO/',
			data: {
			    lppbno : lppbno
			},
			type: "POST",
			datatype: 'html'
		});
		
		
			$('#has').html('');
			$('#has').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
			

		request.done(function(result){
			// console.log("sukses2");
			$('#has').html(result);
			});
		});		
}
function getdataInsert(th) {
	$(document).ready(function(){

		var itemdelive			= [];
		$('input[name="itemdelive[]"]').each(function(){ itemdelive.push($(this).val())});
		var descdelive			= [];
		$('input[name="descdelive[]"]').each(function(){ descdelive.push($(this).val())});
		var qtydelive				= [];
		$('input[name="qtydelive[]"]').each(function(){ qtydelive.push($(this).val())});
		var commentsdelive	= [];
		$('input[name="commentsdelive[]"]').each(function(){ commentsdelive.push($(this).val())});
		var podelive				= [];
		$('input[name="podelive[]"]').each(function(){ podelive.push($(this).val())});
		var sujadelive			= [];
		$('input[name="sujadelive[]"]').each(function(){ sujadelive.push($(this).val())});
		var serialstatus			= [];
		$('input[name="serialstatus[]"]').each(function(){ serialstatus.push($(this).val())});
		var lppbnumber		= [];
		$('input[name="lppbnumber[]"]').each(function(){ lppbnumber.push($(this).val())});
		var iddelive				= [];
		$('input[name="iddelive[]"]').each(function(){ iddelive.push($(this).val())});
		var pilihloc				= [];
		$('input[name="pilihloc[]"]').each(function(){ pilihloc.push($(this).val())});
		
		var request = $.ajax({
			url: baseurl+'ReceivePO/Deliver/Insertketable/',
			data: {
			    itemdelive 			: itemdelive,
			    descdelive 			: descdelive,
			    qtydelive 				: qtydelive,
				commentsdelive 	: commentsdelive,
				podelive 				: podelive,
				sujadelive 				: sujadelive,
				serialstatus 			: serialstatus,
				lppbnumber 			: lppbnumber,
				iddelive 				: iddelive,
				pilihloc 					: pilihloc

			},
			type: "POST",
			datatype: 'html'
		});
		
		
			// $('#has').html('');
			// $('#has').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
			

		request.done(function(result){
			console.log("sukses2");
			 Swal.fire(
			      'Delivered!',
			      'Proses Deliver Selesai',
			      'success'
			    )
			});
		});		
}