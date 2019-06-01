  $(function () {
    $('#example1').DataTable({
      "order" : [[5, "asc"]]
    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $(".slsh").click()

    $("#printfltr").submit(function(e){
      var dari = $('#minCompletionIA').val();
      var hingga = $('#maxCompletionIA').val();
      
      if (dari=='' && hingga=='' )
      {
        $('#modal-alert').modal('show');

        e.preventDefault();
      }    
      
    })
    

  })

  // function test(ths) {
  //     var ornum = $(ths).attr('on');
  //     alert(ornum);
      
  // }

  function test(ORDERNUM) {
    var ornum = $(ORDERNUM).attr('order-number');



    var dpp = $(ORDERNUM).attr('dpp');
    var mak = $(ORDERNUM).attr('max');
    var setat = $(ORDERNUM).attr('status');

    // alert(ornum);
    // $('#ordernum').html(ornum)
    document.getElementById('ordernum').innerHTML = (ornum);
    document.getElementById('depepe').innerHTML = (dpp);
    document.getElementById('mak-ammo').innerHTML = (mak);
    document.getElementById('setatus').innerHTML = (setat);
}

function searchPreContractIndexTable(event) {
	event.preventDefault();
	var tableUsed = $('#example1').DataTable();

	$.fn.dataTable.ext.search.push(
		function(settings, data, dataIndex) {
			var min = $('#minCompletionIA').val();
			var max = $('#maxCompletionIA').val();
			var startCol = data[2];
	
			if (isNaN(min) && isNaN(max)) {
				return true;
			}
			if (isNaN(min) && Number(startCol) <= Number(max)) {
				return true;
			}
			if ((isNaN(max) || max == '') && Number(startCol) >= Number(min)) {
				console.log(min + '-' + startCol);
				return true;
			}
			if (Number(startCol) <= Number(max) && Number(startCol) >= Number(min)) {
				return true;
			}
			return false;
		}
	);
	
	tableUsed.draw();
}


// function prnt_ftr(){
//   var dari = $('#minCompletionIA').val();
//   var hingga = $('#maxCompletionIA').val();
//   // var touchMove = function(e){e.preventDefault();};
  
//   if (dari=='' && hingga=='' )
//   {
    


    
//     $('#modal-alert').modal('show');

//     // document.getElementById('printfltr').addEventListener('printfltr', touchMove, { passive: false });
//     // document.getElementById('printfltr').removeEventListener('printfltr', touchMove);
    


//     document.getElementById('printfltr').addEventListener("click", function(event){event.preventDefault()});
//     document.getElementById('printfltr').removeEventListener("click", function(event){event.preventDefault()});
    
//     // document.getElementById('printfltr').action = '';
//     // document.getElementById('printfltr').target = '';
    
    

//     // document.getElementById('printfltr').removeAttr("action");
//     // document.getElementById('printfltr').removeAttr("target");
//     // document.getElementById('printfltr').target = false;
//     // document.getElementById('printfltr').action = false;
  
//   }
// }

