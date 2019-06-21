function getMLP(th) {
		$(document).ready(function(){
		var noLpAw = $('input[name="noLpAw"]').val();
		var noLpAk = $('input[name="noLpAk"]').val();
		var tglAw = $('input[name="tglAw"]').val();
		var tglAk = $('input[name="tglAk"]').val();
		// console.log(noLpAw, noLpAk, tglAw, tglAk, 'okas');
		
		var request = $.ajax({
			url: baseurl+'MonitoringLppbPenerimaan/Umum/search/',
			data: {
				noLpAw : noLpAw, noLpAk : noLpAk, tglAw : tglAw, tglAk : tglAk
			},
			type: "POST",
			datatype: 'html'
		});
		
		
			$('#ResultLppb').html('');
			$('#ResultLppb').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
			
			// if (noLpAw == '' || noLpAk == ''){
			//  console.log("Masih ada yg kosong cuk 1");
			// }
			// else if(tglAw == '' || tglAk == ''){
			//  console.log("Masih ada yg kosong cuk 2");
			// }

			// $('#myModal').on('shown.bs.modal', function () {
			// 	$('#myInput').focus();
			//   })
		request.done(function(result){
			// console.log("sukses2");
				$('#ResultLppb').html(result);
				$('#myTable').DataTable({
					"scrollX": true,
					"scrollY": 500,
  					"scrollCollapse": true,
					"fixedHeader":true,
				});
			})
		});
		
}