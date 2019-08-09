function getMLP(th) {
	$(document).ready(function(){
		var noLpAw = $('input[name="noLpAw"]').val();
		var noLpAk = $('input[name="noLpAk"]').val();
		var tgAw = $('input[name="tgAw"]').val();
		var tgAk = $('input[name="tgAk"]').val();
		var io = $('.io').val();
		console.log(noLpAw, noLpAk, tgAw, tgAk, io);
		
		var request = $.ajax({
			url: baseurl+'MonitoringLppbPenerimaan/Umum/search/',
			data: {
				noLpAw : noLpAw, 
				noLpAk : noLpAk, 
				tgAw : tgAw, 
				tgAk : tgAk,
				io : io
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
				$('#tbl_umumDt').DataTable({
					scrollX: true,
					scrollY:  400,
					scrollCollapse: true,
					paging:true,
					info:false,
					fixedColumns: {
						leftColumns: 2
					}
				});
			});
		});		
}
