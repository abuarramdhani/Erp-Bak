$(document).ready(function() {
	$('.pilihjenis').select2({
					allowClear: true,
					minimumResultsForSearch: Infinity,
					});
});
function InsertItem(th) {
	$(document).ready(function(){
		$('#hilangkantampilan').css("display","none");
		var priority = $('input[name="priority"]').val();
		var codekomp = $('input[name="codekomp"]').val();
		var namekomp = $('input[name="namekomp"]').val();
		var jeniskomp = $('select[name="jeniskomp"]').val();

		
		var request = $.ajax({
			url: baseurl+'ProductionPlan/ManageItem/Insertitem/',
			data: {
			    priority : priority,
			    codekomp : codekomp,
			    namekomp : namekomp,
			    jeniskomp : jeniskomp
			},
			type: "POST",
			datatype: 'html'
		});
		
			$('#tabelitem').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
			

		request.done(function(result){
			$('#tabelitem').html(result);

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
function TampilkanhasilPlan(th) {
	$(document).ready(function(){
		// var monthplan = $('input[name="monthplan"]').val();
		$('#hilangkan').css("display","none");
		var monthplan = $('#monthplan2').val();

		console.log(monthplan);
		
		var request = $.ajax({
			url: baseurl+'ProductionPlan/Plan/HasilPlan',
			data: {
			    monthplan : monthplan
			},
			type: "POST",
			datatype: 'html'
		});
		
			$('#tabelplan').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
			

		request.done(function(result){
			$('#tabelplan').html(result);

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

$(document).ready(function() {
	var startDate = new Date();
	$('.monthplan').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'MM-yyyy'
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
    }); 

});

function justangka(e, decimal) {
	var key;
	var keychar;
	if (window.event) {
		key = window.event.keyCode;
	} else
	if (e) {
		key = e.which;
	} else return true;
	keychar = String.fromCharCode(key);
	if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
		return true;
	} else
	if ((("0123456789.").indexOf(keychar) > -1)) {
		return true;
	} else
	if (decimal && (keychar == ".")) {
		return true;
	} else return false;
}

function getName(th) {
	 var kodeitem = $('#codekomp').val();	

    console.log(kodeitem)

    var request = $.ajax({
      url: baseurl+'ProductionPlan/ManageItem/getName',
      data: {
          kodeitem : kodeitem
      },
      type: "POST",
      datatype: 'json'
    });
    
    request.done(function(result){
        var str = result
        var hasilstr = str.replace(/"/g, "")
        var hasilstr2 = hasilstr.replace(/ \//g," ");
        $('#namekomp'). val(hasilstr2);
   
      });
}

function removedisabled(th) {
	$('#butonexport').removeAttr('disabled');
}

$(document).ready(function () {
	$("#selectcode").select2({
		allowClear: true,
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "ProductionPlan/Produk/sugestidong",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				// console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.SEGMENT1,
							text: obj.SEGMENT1 +' - ' +obj.DESCRIPTION
						};
					})
				};
			}
		}
	});
});
