// select department class
$(document).ready(function(){
	$("#deptclass").select2({
		allowClear: true,
		placeholder: "Department Class",
		minimumInputLength: 0,
		ajax: {		
			url:baseurl+"PerhitunganUM/Hitung/DeptClass",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.SEKSI_CODE, text:obj.SEKSI};
					})
				};
			}
		}
	});
});

function getPUM(th) {
	$(document).ready(function(){
		var deptclass = $('select[name="deptclass"]').val();
		var plan = $('select[name="plan"]').val();
		console.log(deptclass, plan);
		
		var request = $.ajax({
			url: baseurl+'PerhitunganUM/Hitung/search/',
			data: {
				deptclass : deptclass, 
				plan : plan
			},
			type: "POST",
			datatype: 'html'
		});
		$('#ResultPUM').html('');
		$('#ResultPUM').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading14.gif"><br/></center><center><p style="font-size:12px">Harap tunggu beberapa menit...<p></center>' );
			
		request.done(function(result){
			// console.log("sukses2");
			$('#ResultPUM').html(result);
			$('#tblsatu').DataTable({
				scrollX: true,
				scrollY:  500,
				scrollCollapse: true,
				paging:false,
				info:true,
				ordering:false
			});
		});
	});		
}

$('#tbldua').DataTable({
	scrollX: true,
	scrollY:  500,
	scrollCollapse: true,
	paging:false,
	info:true,
	ordering:false,
	fixedColumns: {
		leftColumns: 1
		}
});

$('.slcDeclas').change(function(){
	$('#findPUM').removeAttr("disabled");
})
